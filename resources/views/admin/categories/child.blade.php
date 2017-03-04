<li>
    <a href="#" class="open">{{ $category->name }}</a>
    @if ($category->parent_id != config('setting.rootcategory'))
        ({{ $category->products->count() }})
    @endif
    <a href="{{ route('category.edit', $category->id) }}" ><i class="fa fa-pencil"></i></a>
    <a class="delete" data-name-value="{{ $category->name }}" href="#"><i class="fa fa-trash"></i></a>
    {!! Form::open(['id' => 'delete-form', 'route' => ['category.destroy', $category->id], 'method' => 'DELETE']) !!}
    {!! Form::close() !!}
    <ul>
        @foreach ($category->childrens as $child)
            @include('admin.categories.child', ['category' => $child])
        @endforeach
    </ul>
    @if (count($category->products))
        <ul>
            @foreach ($category->products as $product)
                <li>{{ $product->name }}</li>
            @endforeach
        </ul>
    @endif
</li>
