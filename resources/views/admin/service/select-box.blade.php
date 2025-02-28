<option value="{{ $category['id'] }}"
    {{ isset($selectedCategory) && $selectedCategory->parent_id == $category['id'] ? 'selected' : '' }}>
    {{ str_repeat('- ', $depth) . $category['name'] }}
</option>

@if (!empty($category['children']))
    @foreach ($category['children'] as $child)
        @include('admin.category.select-box', [
            'category' => $child,
            'depth' => $depth + 1,
            'selectedCategory' => $selectedCategory
        ])
    @endforeach
@endif
