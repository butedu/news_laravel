@props(['status'])

@if ($status)
    <div style="color: #0959AB;" {{ $attributes->merge(['class' => 'font-medium text-sm']) }}>
        {{ $status }}
    </div>
@endif
