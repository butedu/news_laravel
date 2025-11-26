<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function show(Post $post){
        $post->load(['comments.user.image', 'tags', 'category', 'author', 'image']);
        $post->loadCount('savedBy');

        $isSaved = auth()->check() ? auth()->user()->hasSavedPost($post) : false;
        
        $recent_posts = Post::latest()->take(5)->get();
        
        $categories  = Category::where('name','!=','Chưa phân loại')->withCount('posts')->orderBy('created_at','DESC')->take(10)->get();
        $tags = Tag::latest()->take(50)->get();

        /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
        $category_unclassified = Category::where('name','Chưa phân loại')->first();

        $posts_new[0]= Post::latest()->approved()
                    ->where('category_id','!=', $category_unclassified->id )
                    ->take(1)->get();
        $posts_new[1] = Post::latest()->approved()
                    ->where('category_id','!=', $category_unclassified->id )
                    ->where('category_id','!=', $posts_new[0][0]->category->id )
                    ->take(1)->get();
        $posts_new[2] = Post::latest()->approved()
                    ->where('category_id','!=', $category_unclassified->id )
                    ->where('category_id','!=', $posts_new[0][0]->category->id )
                    ->where('category_id','!=', $posts_new[1][0]->category->id )
                    ->take(1)->get();
        $posts_new[3] = Post::latest()->approved()
                    ->where('category_id','!=', $category_unclassified->id )
                    ->where('category_id','!=', $posts_new[0][0]->category->id )
                    ->where('category_id','!=', $posts_new[1][0]->category->id)
                    ->where('category_id','!=', $posts_new[2][0]->category->id )
                    ->take(1)->get(); 

        
        // Bài viết tương tự 
        $postTheSame = Post::latest()->approved()->where('category_id', $post->category->id)->where('id', '!=' , $post->id)->take(5)->get(); ;
        

        // Bài viết nổi bật
        $outstanding_posts = Post::approved()->where('category_id', '!=',  $category_unclassified->id )->take(5)->get();
        
        // Tăng lượt xem khi xem bài viết
        $post->views =  ($post->views) + 1;
        $post->save();

        return view('post', [ 
            'post' => $post,
            'recent_posts' => $recent_posts,
            'categories' => $categories, 
            'tags' => $tags,
            'posts_new' => $posts_new,
            'postTheSame' =>  $postTheSame, // Bài viết tương tự
            'outstanding_posts' => $outstanding_posts, // bài viết xu hướng
            'isSaved' => $isSaved,
        ]);
    }

    public function addComment(Post $post)
    {
        $attributes = request()->validate([
            'the_comment' => 'required|min:5|max:300']);

        $attributes['user_id'] = auth()->id();

        $comment = $post->comments()->create($attributes);

        $targetUrl = route('posts.show', $post);

        return redirect($targetUrl . '#comment_' . $comment->id)
            ->with('success', 'Bạn vừa bình luận thành công.');


    }

    public function addCommentUser(){
        $data = array();
        $data['success'] = 0;
        $data['errors'] = [];

        $rules = [
            'the_comment' => 'required|min:5|max:300',
            'post_id' => 'required|exists:posts,id',
            'post_slug' => 'required|exists:posts,slug',
        ];

        $validated = Validator::make( request()->all(), $rules);

        if($validated->fails()){
            $data['errors'] = $validated->errors()->first('the_comment');
            $data['message'] = $validated->errors()->first() ?? 'Không thể bình luận. Vui lòng thử lại.';

        }else{
            $attributes = $validated->validated();
            $post = Post::find($attributes['post_id']);

            if (!$post || $post->slug !== $attributes['post_slug']) {
                $data['message'] = 'Không tìm thấy bài viết để bình luận.';
                return response()->json($data);
            }

            if (!auth()->check()) {
                $data['message'] = 'Bạn cần đăng nhập để bình luận.';
                return response()->json($data, 401);
            }

            $comment['the_comment'] = $attributes['the_comment']; 
            $comment['post_id'] = $post->id; 
            $comment['user_id'] = auth()->id();

            $createdComment = $post->comments()->create($comment);

            $data['success'] = 1;
            $data['message'] = "Bạn đã bình luận thành công !";
            $data['result'] = $createdComment->only(['id', 'the_comment']);
        }
  
        return response()->json($data);
    }

        public function deleteCommentUser(Request $request, Comment $comment)
        {
            if (! auth()->check()) {
                $message = 'Bạn cần đăng nhập để xóa bình luận.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => 0,
                        'message' => $message,
                    ], 401);
                }

                return redirect()->route('login');
            }

            if ($comment->user_id !== auth()->id()) {
                $message = 'Bạn không có quyền xóa bình luận này.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => 0,
                        'message' => $message,
                    ], 403);
                }

                abort(403, $message);
            }

            $comment->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => 1,
                    'message' => 'Bình luận đã được xóa.',
                ]);
            }

            return redirect()->back()->with('success', 'Bạn đã xóa bình luận.');
        }
    

   
}
