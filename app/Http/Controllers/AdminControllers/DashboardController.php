<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Role;
use App\Models\Comment;
use App\Models\Newsletter;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request){

        $countPost = Post::count();
        $countCategories = Category::count();

        $role_admin = Role::where('name','!=','user')->first();
        $countAdmin = User::where('role_id', $role_admin->id)->count();

        $role_user = Role::where('name','user')->first();
        $countUser = User::where('role_id', $role_user->id)->count();
        $postAll = Post::withCount('comments')->get();

        $countView = (int) $postAll->sum('views');
        $countComments = (int) $postAll->sum('comments_count');

        $countLikes = 0;
        $likesEstimated = false;

        if (Schema::hasColumn('posts', 'likes')) {
            $countLikes = (int) Post::sum('likes');
        } elseif (Schema::hasColumn('posts', 'favorite_count')) {
            $countLikes = (int) Post::sum('favorite_count');
        } elseif (Schema::hasColumn('comments', 'likes')) {
            $countLikes = (int) Comment::sum('likes');
        } else {
            $countLikes = (int) round($countComments * 1.4);
            $likesEstimated = true;
        }

        $avgViewsPerPost = $countPost > 0 ? (int) round($countView / $countPost) : 0;
        $avgCommentsPerPost = $countPost > 0 ? round($countComments / $countPost, 1) : 0;
        $engagementRate = $countView > 0 ? round(($countComments / max($countView, 1)) * 100, 2) : 0;

        $postsLast7 = Post::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $usersLast7 = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $commentsLast7 = Comment::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        $popularCategories = Category::withCount('posts')->orderByDesc('posts_count')->take(6)->get();
        $topPosts = Post::with(['category', 'image'])->orderByDesc('views')->take(5)->get();
        $recentPosts = Post::with(['category', 'image'])->latest()->take(6)->get();
        $recentComments = Comment::with(['user.image', 'post'])->latest()->take(5)->get();
        $topAuthors = User::with(['image'])->withCount('posts')->orderByDesc('posts_count')->take(4)->get();

        $newsletterCount = Newsletter::count();
        $contactCount = Contact::count();
        $pendingPosts = Post::where('approved', false)->count();

        $trafficLabels = [];
        $trafficPosts = [];
        $trafficComments = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $trafficLabels[] = $day->format('d/m');
            $trafficPosts[] = (int) Post::whereDate('created_at', $day)->count();
            $trafficComments[] = (int) Comment::whereDate('created_at', $day)->count();
        }

        $postsWindowTotal = array_sum($trafficPosts);
        $commentsWindowTotal = array_sum($trafficComments);
        $dayCount = count($trafficLabels) ?: 1;

        $avgPostsPerDay = round($postsWindowTotal / max($dayCount, 1), 1);
        $avgCommentsPerDay = round($commentsWindowTotal / max($dayCount, 1), 1);

        $peakIndex = $commentsWindowTotal > 0 ? array_search(max($trafficComments), $trafficComments, true) : null;
        $peakEngagementDay = $peakIndex !== null ? $trafficLabels[$peakIndex] : null;
        $peakEngagementComments = $peakIndex !== null ? $trafficComments[$peakIndex] : 0;


        return view('admin_dashboard.index',[
            'countPost' => $countPost,
            'countCategories' => $countCategories,
            'countAdmin' => $countAdmin,
            'countUser' => $countUser,
            'countView' => $countView,
            'countComments' => $countComments,
            'countLikes' => $countLikes,
            'likesEstimated' => $likesEstimated,
            'avgViewsPerPost' => $avgViewsPerPost,
            'avgCommentsPerPost' => $avgCommentsPerPost,
            'engagementRate' => $engagementRate,
            'postsLast7' => $postsLast7,
            'usersLast7' => $usersLast7,
            'commentsLast7' => $commentsLast7,
            'popularCategories' => $popularCategories,
            'topPosts' => $topPosts,
            'recentPosts' => $recentPosts,
            'recentComments' => $recentComments,
            'topAuthors' => $topAuthors,
            'newsletterCount' => $newsletterCount,
            'contactCount' => $contactCount,
            'pendingPosts' => $pendingPosts,
            'trafficLabels' => $trafficLabels,
            'trafficPosts' => $trafficPosts,
            'trafficComments' => $trafficComments,
            'avgPostsPerDay' => $avgPostsPerDay,
            'avgCommentsPerDay' => $avgCommentsPerDay,
            'peakEngagementDay' => $peakEngagementDay,
            'peakEngagementComments' => $peakEngagementComments,
        ]);
    }

}
