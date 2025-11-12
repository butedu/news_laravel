@props(['latest_posts'])

<div class="sidebar-widget">
    <h3 class="widget-title"><i class="fa fa-newspaper-o"></i> Tin mới nhất</h3>
    <div class="widget-content">
        @foreach($latest_posts as $post)
        <div class="sidebar-post-item-simple">
            <a href="{{ route('posts.show', $post) }}" class="thumb-sm">
                <img src="{{ asset($post->image ? 'storage/' . $post->image->path : 'storage/placeholders/placeholder-image.png')}}" alt="{{ $post->title }}">
            </a>
            <div class="post-info">
                <h4>
                    <a href="{{ route('posts.show', $post) }}">{{ Str::limit($post->title, 60) }}</a>
                </h4>
                <div class="meta-sm">
                    <span><i class="fa fa-clock-o"></i> {{ $post->created_at->locale('vi')->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>