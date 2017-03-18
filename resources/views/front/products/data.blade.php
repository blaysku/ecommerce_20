{!! HTML::script('/bower_components/jquery-legacy/dist/jquery.min.js') !!}
{!! HTML::script('/bower_components/jquery.rateit/scripts/jquery.rateit.min.js') !!}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.add_to_cart_button, .add-to-cart-link').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url:  data['addToCartRoute'] + '/' + $(this).attr('product-id'),
            type: 'POST',
            data: {
                quantity: $(this).parent().find('.input-number').val() ? $(this).parent().find('.input-number').val() : 1,
            },
        })
        .done(function(data) {
            $('span.cart-amunt, .nav-cart span').text(data['totalPrice']);
            $('span.product-count').text(data['totalItems']);
            $('input[name="quantity"]').attr('max', data['restAmount']);
            $('.remainder ins').text(data['restAmount']);
        })
        .fail(function(data) {
            var error = data.responseJSON;
            alert(error['error']);
        })
    });
</script>
@if (count($products))
    @foreach ($products as $product)
        <div class="col-md-3 col-sm-6">
            <div class="single-shop-product text-center">
                <div class="product-upper">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                </div>
                <h2><a href="{{ route('front.product.show', $product->id) }}">{{ $product->name }}</a></h2>
                <div class="rateit" data-rateit-value="{{ $product->avg_rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                <div class="product-carousel-price">
                    <ins>{{ Format::currency($product->price) }}</ins>
                </div>
                <div class="product-option-shop">
                    <a class="add_to_cart_button" href="#" product-id="{{ $product->id }}">{{ trans('front.label.add-to-cart') }}</a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="panel panel-default">
        <div class="panel-body">
            <h3 class="text-center">{{ trans('front.label.nothing') }}</h3>
            <h4 class="text-center">
                <a href="{{ route('index') }}"><i class="fa fa-fw fa-home"></i>{{ trans('front.label.home-page') }}</a>
                <a href="{{ route('front.product.index') }}"><i class="fa fa-fw fa-cart-plus"></i>{{ trans('front.suggest.back-to-product') }}</a>
                @if (Auth::check())
                    <a  data-toggle="modal" href='#suggest-form'><i class="fa fa-fw fa-lightbulb-o"></i>{{ trans('front.suggest.suggest') }}</a>
                @endif
            </h4>
        </div>
    </div>
@endif

