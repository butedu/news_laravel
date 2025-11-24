@props(['recent_posts'])
<div class="side">
    <h3 class="sidebar-heading">Bài viết mới nhất</h3>
    @foreach($recent_posts as $recentPost)
        <div class="f-blog">
                <a href="{{ route('posts.show', $recentPost) }}" class="blog-img" style="background-image: url('{{ optional($recentPost->image)->url ?? asset('storage/placeholders/placeholder-image.png') }}');"></a>
            <div class="desc">
                    <p class="admin"><span>{{ $recentPost->created_at->diffForHumans() }}</spann></p>
                <h2>
                        <a href="{{ route('posts.show', $recentPost) }}">
                            {{ \Str::limit($recentPost->title, 20) }}
                    </a></h2>
                    <p>{{ $recentPost->excerpt }}</p>
            </div>
        </div>
    @endforeach
</div>