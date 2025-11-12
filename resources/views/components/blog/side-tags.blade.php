@props(['popular_tags'])

<div class="sidebar-widget">
    <h3 class="widget-title"><i class="fa fa-tags"></i> Thẻ phổ biến</h3>
    <div class="widget-content">
        <div class="tag-cloud">
            @foreach($popular_tags as $tag)
            <a href="{{ route('tags.show', $tag) }}" class="tag-item">
                {{ $tag->name }}
            </a>
            @endforeach
        </div>
    </div>
</div>
