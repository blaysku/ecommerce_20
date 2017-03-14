@extends('front.template')
@section('title', trans('front.label.shop-page'))
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @parent
@endsection
@section('main')
    @include('front.includes.title', ['title' => $product->name])
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">{{ trans('front.label.trending') }}</h2>
                        @foreach ($trendingProducts as $trendingProduct)
                            <div class="thubmnail-recent">
                                <img src="{{ Storage::url($trendingProduct->image) }}" class="recent-thumb" alt="{{ $trendingProduct->name }}">
                                <h2><a href="#">{{ $trendingProduct->name }}</a></h2>
                                <div class="rateit" data-rateit-value="{{ $trendingProduct->avg_rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                <div class="product-sidebar-price">
                                    <ins>{{ Format::currency($trendingProduct->price) }}</ins>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($recentlyProducts)
                        <div class="single-sidebar">
                            <h2 class="sidebar-title">{{ trans('front.label.recent') }}</h2>
                            @foreach ($recentlyProducts as $recentlyProduct)
                                <div class="thubmnail-recent">
                                    <img src="{{ Storage::url($recentlyProduct->image) }}" class="recent-thumb" alt="{{ $recentlyProduct->name }}">
                                    <h2><a href="#">{{ $recentlyProduct->name }}</a></h2>
                                    <div class="rateit" data-rateit-value="{{ $recentlyProduct->avg_rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                    <div class="product-sidebar-price">
                                        <ins>{{ Format::currency($recentlyProduct->price) }}</ins>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="product-breadcroumb">
                            <a href="#">{{ trans('front.label.home') }}</a>
                            <a href="#">{{ $product->category->name }}</a>
                            <a href="#">{{ $product->name }}</a>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="product-inner">
                                    <h2 class="product-name">{{ $product->name }}</h2>
                                    <div class="rateit" data-rateit-value="{{ $product->avg_rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                    <small>({{ $product->ratings->count() }} reviews)</small>
                                    <div class="product-inner-price">
                                        <ins>{{ Format::currency($product->price) }}</ins>
                                    </div>
                                    <form action="#" class="cart">
                                        <div class="quantity">
                                            <input type="number" size="4" class="input-text qty text" name="quantity">
                                        </div>
                                        <button class="add_to_cart_button" type="submit">{{ trans('front.label.add-to-cart') }}</button>
                                    </form>
                                    <div class="product-inner-category">
                                        <p>{{ trans('front.label.category') }}: <a href="#">{{ $product->category->name }}</a>
                                    </div>
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">{{ trans('front.label.description') }}</a></li>
                                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{ trans('front.label.reviews') }}</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <h2>{{ trans('front.label.description') }}</h2>
                                                {!! $product->description !!}
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="profile">
                                                <h2>{{ trans('front.label.reviews') }}</h2>
                                                @if (auth()->user())
                                                    <div class="submit-review">
                                                        <div class="rating-chooser">
                                                            <div class="rating">
                                                                <label>{{ trans('front.label.your-rating') }}</label>
                                                                <p class="text-danger"></p>
                                                                <div class="rateit" id="rating" data-rateit-value="{{ $userRating ? $userRating->rating : null}}" data-rateit-ispreset="true" data-rateit-readonly="false"></div>
                                                            </div>
                                                            <div class="review">
                                                                <label for="review">{{ trans('front.label.your-review') }}</label>
                                                                <div id="review-content">
                                                                    @if ($userRating && $userRating->review)
                                                                        <div id="content">
                                                                            {!! $userRating->review !!}
                                                                        </div>
                                                                        <a href="#" id="edit-review"><i class="fa fa-pencil"></i></a>
                                                                    @endif
                                                                </div>
                                                                <div id="edit">
                                                                    <textarea name="review" id="review">{{ $userRating && $userRating->review ? $userRating->review : '' }}</textarea>
                                                                    <p class="text-danger"></p>
                                                                    <button type="button" id="review-submit">{{ trans('front.label.submit') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p>{{ trans('front.label.login-to-rate') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="fb-root"></div>
                            <div class="fb-like" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                            <div class="fb-comments" data-numposts="5"></div>
                            <div class="related-products-wrapper">
                                <h2 class="related-products-title">{{ trans('front.label.related') }}</h2>
                                <div class="related-products-carousel">
                                @foreach ($relatedProducts as $relatedProduct)
                                    <div class="single-product text-center">
                                        <div class="product-f-image">
                                            <img src="{{ Storage::url($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">
                                            <div class="product-hover">
                                                <a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> {{ trans('front.label.add-to-cart') }}</a>
                                                <a href="#" class="view-details-link"><i class="fa fa-link"></i> {{ trans('front.label.see-detail') }}</a>
                                            </div>
                                        </div>
                                        <h2><a href="#">{{ $relatedProduct->name }}</a></h2>
                                        <div class="rateit" data-rateit-value="{{ $relatedProduct->avg_rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                        <div class="product-carousel-price">
                                            <ins>{{ Format::currency($relatedProduct->price) }}</ins>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    {{ HTML::script('bower_components/ckeditor/ckeditor.js') }}
    <script>
        var data = {
            'review': {{ $userRating &&  $userRating->review ? 1 : 0 }},
            'routeStore': '{{ route('front.rating.store') }}',
            'routeUpdate': '{{ $userRating ? route('front.rating.update', $userRating->id) : '' }}',
            'productId': {{ $product->id }},
            'userId': {{ auth()->id() }},
        }
    </script>
    {{ HTML::script('front/js/product-show.js') }}
    {{ HTML::script('front/js/facebook.js') }}
@endsection
