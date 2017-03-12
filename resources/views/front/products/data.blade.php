@if (count($products))
    @foreach ($products as $product)
        <div class="col-md-3 col-sm-6">
            <div class="single-shop-product text-center">
                <div class="product-upper">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                </div>
                <h2><a href="#">{{ $product->name }}</a></h2>
                <div class="rateit" data-rateit-value="{{ $product->avg_rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                <div class="product-carousel-price">
                    <ins>{{ Format::currency($product->price) }}</ins>
                </div>
                <div class="product-option-shop">
                    <a class="add_to_cart_button" href="#">{{ trans('front.label.add-to-cart') }}</a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="panel panel-default">
        <div class="panel-body">
            <p class="text-center">{{ trans('front.label.nothing') }}</p>
        </div>
    </div>
@endif
