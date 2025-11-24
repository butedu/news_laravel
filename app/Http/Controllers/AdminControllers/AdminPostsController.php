<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class AdminPostsController extends Controller
{

    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $postsQuery = Post::with('category');

        if ($search !== '') {
            $postsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($nested) use ($search) {
                        $nested->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('author', function ($nested) use ($search) {
                        $nested->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $posts = $postsQuery->orderByDesc('id')->paginate(20)->appends($request->only('search'));

        return view('admin_dashboard.posts.index', [
            'posts' => $posts,
            'searchTerm' => $search,
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.posts.create',[
            'categories' => Category::pluck('name', 'id')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(true));

        $slugSource = $validated['slug'] ?? $validated['title'];
        $validated['slug'] = $this->makeUniqueSlug($this->slugify($slugSource));
        $validated['user_id'] = auth()->id();

        unset($validated['thumbnail'], $validated['thumbnail_url']);
        $post = Post::create($validated);

        $this->syncThumbnail($post, $request);

        $tags = array_filter(array_map('trim', explode(',', $request->input('tags', ''))));
        $tagsIds = [];
        foreach ($tags as $tag) {
            $tagModel = Tag::firstOrCreate(['name' => $tag]);
            $tagsIds[] = $tagModel->id;
        }

        if (!empty($tagsIds)) {
            $post->tags()->sync($tagsIds);
        }
        
        // $tags = explode(',', $request->input('tags'));
        // $tags_ids = [];
        // foreach ($tags as $tag) {

        //     $tag_exits = $post->tags()->where('name', trim($tag))->count();
        //     if( $tag_exits == 0){
        //         $tag_ob = Tag::create(['name'=> $tag]);
        //         $tags_ids[]  = $tag_ob->id;
        //     }
            
        // }

        // if (count($tags_ids) > 0)
        //     $post->tags()->syncWithoutDetaching( $tags_ids );

        return redirect()->route('admin.posts.create')->with('success', 'Thêm bài viết thành công.');
    }

    public function show($id)
    {
        //
    }


    public function edit(Post $post){
        $tags = '';
        foreach($post->tags as $key => $tag){
            $tags .= $tag->name;
            if($key !== count($post->tags) - 1)
                $tags .= ', ';
        }
        
        return view('admin_dashboard.posts.edit',[
            'post' => $post,
            'tags' => $tags,
            'categories' => Category::pluck('name', 'id')
        ]);
    }


    public function update(Request $request, Post $post)
    {
        $validated = $request->validate($this->validationRules());

        $slugSource = $validated['slug'] ?? $post->slug ?? $validated['title'];
        $validated['slug'] = $this->makeUniqueSlug($this->slugify($slugSource), $post->id);
        $validated['approved'] = $request->input('approved') !== null;

        unset($validated['thumbnail'], $validated['thumbnail_url']);
        $post->update($validated);

        $this->syncThumbnail($post, $request);

        $tags = array_filter(array_map('trim', explode(',', $request->input('tags', ''))));
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagModel = Tag::firstOrCreate(['name' => $tag]);
            $tagIds[] = $tagModel->id;
        }

        $post->tags()->sync($tagIds);

        return redirect()->route('admin.posts.edit', $post)->with('success', 'Sửa viết thành công.');
    }

    private function validationRules(bool $isCreate = false): array
    {
        $thumbnailRules = ['nullable', 'image', 'mimes:jpg,png,webp,svg,jpeg', 'max:5120'];
        $thumbnailUrlRules = ['nullable', 'url'];

        if ($isCreate) {
            array_unshift($thumbnailRules, 'required_without:thumbnail_url');
            array_unshift($thumbnailUrlRules, 'required_without:thumbnail');
        }

        return [
            'title' => 'required|max:200',
            'slug' => 'nullable|max:200',
            'excerpt' => 'required|max:300',
            'category_id' => 'required|numeric',
            'thumbnail' => $thumbnailRules,
            'thumbnail_url' => $thumbnailUrlRules,
            'body' => 'required',
        ];
    }

    private function syncThumbnail(Post $post, Request $request): void
    {
        $file = $request->file('thumbnail');
        $remoteUrl = trim((string) $request->input('thumbnail_url'));

        if (!$file && $remoteUrl === '') {
            return;
        }

        $existingImage = $post->image;

        if ($file && $file->isValid()) {
            $this->deleteLocalImage($existingImage);

            $path = $file->store('images/posts', 'public');

            $post->image()->updateOrCreate(
                [],
                [
                    'name' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'path' => $path,
                ]
            );

            return;
        }

        if ($remoteUrl !== '') {
            $this->deleteLocalImage($existingImage);

            $pathPart = parse_url($remoteUrl, PHP_URL_PATH) ?? '';
            $basename = basename($pathPart) ?: $post->slug;
            $extension = pathinfo($pathPart, PATHINFO_EXTENSION) ?: null;

            $post->image()->updateOrCreate(
                [],
                [
                    'name' => $basename,
                    'extension' => $extension,
                    'path' => $remoteUrl,
                ]
            );
        }
    }

    private function deleteLocalImage($image): void
    {
        if (!$image || !$image->path || $this->isRemotePath($image->path)) {
            return;
        }

        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }
    }

    private function isRemotePath(string $path): bool
    {
        return Str::startsWith($path, ['http://', 'https://']);
    }

    public function destroy(Post $post)
    {
        $this->deleteLocalImage($post->image);
        $post->image()->delete();
        $post->tags()->delete();
        $post->comments()->delete();
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success','Xóa bài viết thành công.');
    }


    // Hàm tạo slug tự động
    public function to_slug(Request $request) {
        $slug = $this->slugify($request->title);
        $data['success'] = 1;
        $data['message'] = $slug;
        return response()->json($data);
    }

    private function slugify(string $value): string
    {
        $str = trim(mb_strtolower($value));
        $patterns = [
            '/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/',
            '/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/',
            '/(ì|í|ị|ỉ|ĩ)/',
            '/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/',
            '/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/',
            '/(ỳ|ý|ỵ|ỷ|ỹ)/',
            '/(đ)/'
        ];
        $replacements = ['a', 'e', 'i', 'o', 'u', 'y', 'd'];
        $str = preg_replace($patterns, $replacements, $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        $str = mb_substr($str, 0, 200);
        return trim($str, '-') ?: Str::random(8);
    }

    private function makeUniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $baseSlug = $slug;
        $counter = 1;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, function ($query, $id) {
                    $query->where('id', '<>', $id);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }


}
