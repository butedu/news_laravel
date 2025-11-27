<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\User;
use App\Models\Image;
use App\Models\Newsletter;
use App\Services\ExternalWidgetService;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class HomeController extends Controller
{
    protected ExternalWidgetService $widgetService;

    public function __construct(ExternalWidgetService $widgetService)
    {
        $this->widgetService = $widgetService;
    }

    public function index(){
        
        $posts = Post::latest()
        ->approved()
        // where('approved',1)
        ->withCount('comments')->paginate(8); 
        // phân trang 8 bài
        $recent_posts = Post::latest()->take(5)->get();
        $categories = Category::where('name','!=','Chưa phân loại')->orderBy('created_at','DESC')->take(10)->get();
        // $categories = Category::where('name','!=','Chưa phân loại')->withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();
        $tags = Tag::latest()->take(50)->get();

       
        /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
        $unclassifiedCategoryId = $this->getUnclassifiedCategoryId();
        $posts_new = $this->buildPostsNew($unclassifiedCategoryId);

        // Tin nổi bật hero (5 tin mới nhất)
        $hero_posts = Post::with(['category', 'user', 'image'])
            ->latest()
            ->approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->take(5)
            ->get();
        
        // Tin xem nhiều nhất (sidebar)
        $most_viewed = Post::with(['category', 'user', 'image'])
            ->approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->orderBy('views', 'DESC')
            ->take(5)
            ->get();

        // Lấy ra tin nổi bật -- Lấy theo views
        $outstanding_posts = Post::orderBy('views','DESC')->take(5)->get();

        // Tin mới nhất (sidebar)
        $latest_posts = Post::with(['category', 'user', 'image'])
            ->latest()
            ->approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->take(6)
            ->get();
        
        // Bài viết có nhiều bình luận nhất
        $most_commented = Post::with(['category', 'user', 'image'])
            ->approved()
            ->withCount('comments')
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->orderBy('comments_count', 'DESC')
            ->take(5)
            ->get();
        
        // Danh mục có nhiều bài viết nhất
        $categories = Category::where('name', '!=', 'Chưa phân loại')
            ->withCount('posts')
            ->orderBy('posts_count', 'DESC')
            ->take(8)
            ->get();
        
        // Thẻ tag phổ biến
        $popular_tags = Tag::withCount('posts')
            ->orderBy('posts_count', 'DESC')
            ->take(15)
            ->get();

        // Lấy ra tất cả danh mục tin tức 
        $stt_home = 0;
        $category_home = Category::where('name','!=','Chưa phân loại')->orderBy('created_at','DESC')->take(10)->get();
        foreach($category_home as $category_item ){
            // Tạo tin tức mới nhất cho layout master
            $stt_home = $stt_home + 1;    
            if($stt_home === 1)
                $post_category_home0 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(5)->get();
            if($stt_home === 2)
                $post_category_home1 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(6)->get();
            if($stt_home === 3)
                $post_category_home2 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(4)->get();
            if($stt_home === 4)
                $post_category_home3 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(6)->get();
            if($stt_home === 5)
                $post_category_home4 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(4)->get();
            if($stt_home === 6)
                $post_category_home5 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(6)->get();
            if($stt_home === 7)
                $post_category_home6 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(4)->get();
            if($stt_home === 8)
                $post_category_home7 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(6)->get();
            if($stt_home === 9)
                $post_category_home8 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(4)->get();
            if($stt_home === 10)
                $post_category_home9 =  Post::with(['category', 'user', 'image'])->latest()->approved()->withCount('comments')->where('category_id',$category_item->id)->take(6)->get();
         }


        // Ý kiến người đọc, comments
        $top_commnents = Comment::take(5)->get();

        // Tin mới nhất (sidebar)
        $latest_posts = Post::with(['category', 'author', 'image'])
            ->latest()
            ->approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->take(6)
            ->get();
        
        // Danh mục có nhiều bài viết nhất
        $categories = Category::where('name', '!=', 'Chưa phân loại')
            ->withCount('posts')
            ->orderBy('posts_count', 'DESC')
            ->take(8)
            ->get();
        
        // Thẻ tag phổ biến
        $popular_tags = Tag::withCount('posts')
            ->orderBy('posts_count', 'DESC')
            ->take(15)
            ->get();
    
        return view('home', [
            'posts' => $posts,
            'recent_posts' => $recent_posts,
            'posts_new' => $posts_new, // Bài viết mới nhất theo mục
            'hero_posts' => $hero_posts, // Tin nổi bật hero section
            'most_viewed' => $most_viewed, // Tin xem nhiều nhất sidebar
            'latest_posts' => $latest_posts, // Tin mới nhất sidebar
            'most_commented' => $most_commented, // Bài viết có nhiều bình luận
            'post_category_home0' => $post_category_home0, // Bài viết danh mục 5
            'post_category_home1' => $post_category_home1, // Bài viết danh mục 1
            'post_category_home2' => $post_category_home2, // Bài viết danh mục 2
            'post_category_home3' => $post_category_home3, // Bài viết danh mục 3
            'post_category_home4' => $post_category_home4, // Bài viết danh mục 4
            'post_category_home5' => $post_category_home5, // Bài viết danh mục 10
            'post_category_home6' => $post_category_home6, // Bài viết danh mục 6
            'post_category_home7' => $post_category_home7, // Bài viết danh mục 7
            'post_category_home8' => $post_category_home8, // Bài viết danh mục 8
            'post_category_home9' => $post_category_home9, // Bài viết danh mục 9
            'outstanding_posts' => $outstanding_posts, // Bài viết nổi bật
            'categories' => $categories, // Danh mục nhiều bài nhất
            'popular_tags' => $popular_tags, // Thẻ tag phổ biến
            'category_home' => $category_home, 
            'tags' => $tags,
            'top_commnents' => $top_commnents, // Lấy ý kiến người đọc mới nhất
            'sidebarUtilities' => $this->widgetService->getSidebarData(),
        ]);
    }

    public function search(Request $request){
        
        $recent_posts = Post::latest()->take(5)->get();
        $categories  = Category::where('name','!=','Chưa phân loại')->withCount('posts')->orderBy('created_at','DESC')->take(10)->get();
       
         /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
         $unclassifiedCategoryId = $this->getUnclassifiedCategoryId();
         $posts_new = $this->buildPostsNew($unclassifiedCategoryId);

        // Bài viết nổi bật
        $outstanding_posts = Post::approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->take(5)
            ->get();
        
        $key = $request->search;
        // tìm kiếm kết quả danh mục
        // $cat = Category::where('name','like' , '%'.$key.'%')->first();
        // $pro = Category::where('name','like' , '%'.$key.'%')->first();

        $posts = Post::latest()->withCount('comments')->approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->where('title','like' , '%'.$key.'%')
            ->paginate(30);
        
        $title = 'Kết quả tìm kiếm';
        $title_t = 'Kết quả tìm kiếm theo';
        $time = '(0,36 giây) ';

        return view('search',compact('posts','title','time','recent_posts','categories', 'key','posts_new', 'outstanding_posts'));
    }

    public function newPost(){
        
        // Bài viết mới nhất
        $recent_posts = Post::latest()->take(5)->get();
        $categories  = Category::where('name','!=','Chưa phân loại')->withCount('posts')->orderBy('created_at','DESC')->take(10)->get();
       
         /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
         $unclassifiedCategoryId = $this->getUnclassifiedCategoryId();
         $posts_new = $this->buildPostsNew($unclassifiedCategoryId);

        // Bài viết nổi bật
        $outstanding_posts = Post::approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->take(5)
            ->get();
        
        
        // Bài viết mới nhất
        $newPosts_category  = Post::latest()->approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->take(20)
            ->get(); 

        return view('newPost',compact(
            'recent_posts',
            'categories',
            'posts_new',
            'outstanding_posts',
            'newPosts_category'
        ));
    }

    public function hotPost(){
        
        // Bài viết mới nhất
        $recent_posts = Post::latest()->take(5)->get();
        $categories  = Category::where('name','!=','Chưa phân loại')->withCount('posts')->orderBy('created_at','DESC')->take(10)->get();
       
         /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
         $unclassifiedCategoryId = $this->getUnclassifiedCategoryId();
         $posts_new = $this->buildPostsNew($unclassifiedCategoryId);

        // Bài viết nổi bật
        $outstanding_posts = Post::approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->take(5)
            ->get();
        
        
        // Bài viết mới nhất
        $category_phap_luat_id = Category::where('name','Pháp luật')->value('id');
        $category_kinh_te_id = Category::where('name','Kinh tế')->value('id');
        $category_xa_hoi_id = Category::where('name','Xã hội')->value('id');
        $category_khoa_hoc_id = Category::where('name','Khoa học')->value('id');
        $category_the_gioi_id = Category::where('name','Thế giới')->value('id');

        $hotPosts_category[0]  = $category_phap_luat_id
            ? Post::approved()->where('category_id', $category_phap_luat_id)->orderBy('created_at','DESC')->take(4)->get()
            : collect();
        $hotPosts_category[1]  = $category_kinh_te_id
            ? Post::approved()->where('category_id', $category_kinh_te_id)->orderBy('created_at','DESC')->take(4)->get()
            : collect();
        $hotPosts_category[2]  = $category_xa_hoi_id
            ? Post::approved()->where('category_id', $category_xa_hoi_id)->orderBy('created_at','DESC')->take(4)->get()
            : collect();
        $hotPosts_category[3]  = $category_khoa_hoc_id
            ? Post::approved()->where('category_id', $category_khoa_hoc_id)->orderBy('created_at','DESC')->take(4)->get()
            : collect();
        $hotPosts_category[4]  = $category_the_gioi_id
            ? Post::approved()->where('category_id', $category_the_gioi_id)->orderBy('created_at','DESC')->take(4)->get()
            : collect();

        return view('hotPost',compact(
            'recent_posts',
            'categories',
            'posts_new',
            'outstanding_posts',
            'hotPosts_category'
        ));
    }

    public function viewPost(){
        
        // Bài viết mới nhất
        $recent_posts = Post::latest()->take(5)->get();
        $categories  = Category::where('name','!=','Chưa phân loại')->withCount('posts')->orderBy('created_at','DESC')->take(10)->get();
       
         /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
         $unclassifiedCategoryId = $this->getUnclassifiedCategoryId();
         $posts_new = $this->buildPostsNew($unclassifiedCategoryId);

        // Bài viết nổi bật
        $outstanding_posts = Post::approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->take(5)
            ->get();
        
        // Bài viết mới nhất
        $viewPosts_category  = Post::approved()
            ->when($unclassifiedCategoryId, fn ($query) => $query->where('category_id', '!=', $unclassifiedCategoryId))
            ->orderBy('views','DESC')
            ->take(20)
            ->get(); 

        return view('viewPost',compact(
            'recent_posts',
            'categories',
            'posts_new',
            'outstanding_posts',
            'viewPosts_category'
        ));
    }

    public function erorr404(){
        return view('errors.404');
    }

    public function profile(){
        if (!auth()->check()) {
            return view('profile');
        }

        $user = auth()->user()->load('image');

        $savedPosts = $user->savedPosts()
            ->with(['category', 'image'])
            ->latest('post_saves.created_at')
            ->get();

        $recentComments = $user->comments()
            ->with(['post.category', 'post.image'])
            ->latest()
            ->get();

        $commentedPosts = $recentComments
            ->map(function ($comment) {
                $post = $comment->post;
                if ($post) {
                    $post->setAttribute('latest_user_comment_at', $comment->created_at);
                }
                return $post;
            })
            ->filter()
            ->unique('id')
            ->values();

        $newsletterSubscription = Newsletter::with('categories')->firstWhere('email', $user->email);
        $newsletterCategories = Category::where('name', '!=', 'Chưa phân loại')
            ->orderBy('name')
            ->get();

        return view('profile', compact(
            'user',
            'savedPosts',
            'commentedPosts',
            'newsletterSubscription',
            'newsletterCategories'
        ));
    }

    private array $rules = [
        'name' => ['required', 'min:3'],
        'email' => ['required', 'email'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'image_url' => ['nullable', 'url'],
        'current_password' => ['nullable', 'required_with:password,password_confirmation', 'current_password'],
        'password' => ['nullable', 'confirmed', 'min:8'],
    ];

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $rules = $this->rules;
        $rules['email'][] = Rule::unique('users')->ignore($user->id);
        $rules['image'][0] = $request->hasFile('image') ? 'required' : 'nullable';

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
            $user->setRememberToken(Str::random(60));
        }

        $user->save();

        $imageUrl = isset($validated['image_url']) ? trim($validated['image_url']) : '';

        if ($request->hasFile('image')) {
            $this->storeUploadedAvatar($user, $request->file('image'));
        } elseif ($imageUrl !== '') {
            $this->storeExternalAvatar($user, $imageUrl);
        }

        $user->refresh();
        
        return redirect()->route('profile')->with('success', 'Sửa tài khoản thành công.');
    }

    private function storeExternalAvatar(User $user, string $imageUrl): void
    {
        $existingImage = $user->image;

        $parsedPath = parse_url($imageUrl, PHP_URL_PATH) ?? '';
        $filename = $parsedPath ? basename($parsedPath) : 'external-avatar';
        $extension = $parsedPath ? pathinfo($parsedPath, PATHINFO_EXTENSION) : null;

        $payload = [
            'name' => $filename ?: 'external-avatar',
            'extension' => $extension,
            'path' => $imageUrl,
        ];

        if ($existingImage) {
            $this->deleteImageFileIfLocal($existingImage);
            $existingImage->update($payload);
        } else {
            $user->image()->create($payload);
        }
    }

    private function storeUploadedAvatar(User $user, UploadedFile $image): void
    {
        $existingImage = $user->image;
        $this->deleteImageFileIfLocal($existingImage);

        $filename = $image->getClientOriginalName();
        $fileExtension = $image->getClientOriginalExtension();
        $storedPath = $image->store('images', 'public');
        $normalizedPath = str_replace('\\', '/', $storedPath);

        $payload = [
            'name' => $filename,
            'extension' => $fileExtension,
            'path' => $normalizedPath,
        ];

        if ($existingImage) {
            $existingImage->update($payload);
        } else {
            $user->image()->create($payload);
        }
    }

    private function deleteImageFileIfLocal(?Image $image): void
    {
        if (!$image || !$image->path) {
            return;
        }

        if (Str::startsWith($image->path, ['http://', 'https://'])) {
            return;
        }

        $normalizedPath = str_replace('\\', '/', $image->path);

        if (Storage::disk('public')->exists($normalizedPath)) {
            Storage::disk('public')->delete($normalizedPath);
        }
    }

    private function getUnclassifiedCategoryId(): ?int
    {
        return Category::where('name', 'Chưa phân loại')->value('id');
    }

    private function buildPostsNew(?int $excludeCategoryId = null, int $limit = 4): array
    {
        $results = [];
        $excludedCategoryIds = [];

        for ($index = 0; $index < $limit; $index++) {
            $query = Post::latest()->approved();

            if ($excludeCategoryId) {
                $query->where('category_id', '!=', $excludeCategoryId);
            }

            if (!empty($excludedCategoryIds)) {
                $query->whereNotIn('category_id', $excludedCategoryIds);
            }

            $posts = $query->take(1)->get();

            if ($posts->isEmpty()) {
                break;
            }

            $results[$index] = $posts;
            $excludedCategoryIds[] = $posts->first()->category_id;
        }

        return $results;
    }
}
