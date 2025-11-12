@props(['categories'])

<div class="sidebar-widget">
    <h3 class="widget-title"><i class="fa fa-list-ul"></i> Chuyên mục</h3>
    <div class="widget-content">
        <ul class="category-list">
            @foreach($categories as $category)
            <li>
                <a href="{{ route('categories.show', $category) }}">
                    <span class="category-name">{{ $category->name }}</span>
                    <span class="category-count">{{ $category->posts_count }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
