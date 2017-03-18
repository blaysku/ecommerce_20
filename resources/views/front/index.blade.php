@extends('front.template')
@section('css')
    @parent
    {!! HTML::style('/bower_components/jquery.rateit/scripts/rateit.css') !!}
@endsection
@section('title', trans('front.label.home-page'))
@section('main')
    <div class="slider-area">
        <div class="zigzag-bottom"></div>
        <div id="slide-list" class="carousel carousel-fade slide" data-ride="carousel">
            <div class="slide-bulletz">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ol class="carousel-indicators slide-indicators">
                                <li data-target="#slide-list" data-slide-to="0" class="active"></li>
                                <li data-target="#slide-list" data-slide-to="1"></li>
                                <li data-target="#slide-list" data-slide-to="2"></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="single-slide">
                        <div class="slide-bg slide-one"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>{{ trans('front.faker.title1') }}</h2>
                                                <p>{{ trans('front.faker.lorem') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-slide">
                        <div class="slide-bg slide-two"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>{{ trans('front.faker.title2') }}</h2>
                                                <p>{{ trans('front.faker.lorem') }}</p>
                                                <a href="#" class="readmore">{{ trans('front.label.learn-more') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-slide">
                        <div class="slide-bg slide-three"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>{{ trans('front.faker.title3') }}</h2>
                                                <p>{{ trans('front.faker.lorem') }}</p>
                                                <a href="#" class="readmore">{{ trans('front.label.learn-more') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End slider area -->
    <div class="promo-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo">
                        <i class="fa fa-refresh"></i>
                        <p>{{ trans('front.service.return') }}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo">
                        <i class="fa fa-truck"></i>
                        <p>{{ trans('front.service.freeship') }}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo">
                        <i class="fa fa-lock"></i>
                        <p>{{ trans('front.service.secure') }}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo">
                        <i class="fa fa-gift"></i>
                        <p>{{ trans('front.service.new-product') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End promo area -->
    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest-product">
                        <h2 class="section-title">{{ trans('front.label.trending') }}</h2>
                        <div class="product-carousel">
                            @foreach ($trendings as $product)
                                <div class="single-product">
                                    <div class="product-f-image">
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                        <div class="product-hover">
                                            <a href="#" class="add-to-cart-link" product-id = "{{ $product->id }}"><i class="fa fa-shopping-cart"></i>{{ trans('front.label.add-to-cart') }}</a>
                                            <a href="{{ route('front.product.show', $product->id) }}" class="view-details-link"><i class="fa fa-link"></i>{{ trans('front.label.see-detail') }}</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h2><a href="#">{{ $product->name }}</a></h2>
                                        <div class="rateit" data-rateit-value="{{ $product->avg_rating }}" data-rateit-readonly="true"></div>
                                        <div class="product-carousel-price">
                                            <ins>{{ Format::currency($product->price) }}</ins>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->
    <div class="brands-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="brand-wrapper">
                        <h2 class="section-title">{{ trans('front.label.brand') }}</h2>
                        <div class="brand-list">
                            <img src="{{ asset('front/img/services_logo_1.jpg') }}" alt="">
                            <img src="{{ asset('front/img/services_logo_2.jpg') }}" alt="">
                            <img src="{{ asset('front/img/services_logo_3.jpg') }}" alt="">
                            <img src="{{ asset('front/img/services_logo_4.jpg') }}" alt="">
                            <img src="{{ asset('front/img/services_logo_1.jpg') }}" alt="">
                            <img src="{{ asset('front/img/services_logo_2.jpg') }}" alt="">
                            <img src="{{ asset('front/img/services_logo_3.jpg') }}" alt="">
                            <img src="{{ asset('front/img/services_logo_4.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End brands area -->
    <div class="product-widget-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">{{ trans('front.label.top-sellers') }}</h2>
                        @foreach ($topSellers as $product)
                            <div class="single-wid-product">
                                <a href="{{ route('front.product.show', $product->id) }}"><img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-thumb"></a>
                                <h2><a href="{{ route('front.product.show', $product->id) }}">{{ $product->name }}</a></h2>
                                <div class="rateit" data-rateit-value="{{ $product->avg_rating }}" data-rateit-readonly="true"></div>
                                <div class="product-wid-price">
                                    <ins>{{ Format::currency($product->price) }}</ins>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">{{ trans('front.label.top-rating') }}</h2>
                        @foreach ($topRatings as $product)
                            <div class="single-wid-product">
                                <a href="{{ route('front.product.show', $product->id) }}"><img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-thumb"></a>
                                <h2><a href="{{ route('front.product.show', $product->id) }}">{{ $product->name }}</a></h2>
                                <div class="rateit" data-rateit-value="{{ $product->avg_rating }}" data-rateit-readonly="true"></div>
                                <div class="product-wid-price">
                                    <ins>{{ Format::currency($product->price) }}</ins>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">{{ trans('front.label.top-new') }}</h2>
                        @foreach ($topNews as $product)
                            <div class="single-wid-product">
                                <a href="{{ route('front.product.show', $product->id) }}"><img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-thumb"></a>
                                <h2><a href="{{ route('front.product.show', $product->id) }}">{{ $product->name }}</a></h2>
                                <div class="rateit" data-rateit-value="{{ $product->avg_rating }}" data-rateit-readonly="true"></div>
                                <div class="product-wid-price">
                                    <ins>{{ Format::currency($product->price) }}</ins>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End product widget area -->
@endsection
@section('js')
    @parent
    {!! HTML::script('/bower_components/jquery.rateit/scripts/jquery.rateit.min.js') !!}
    <script>
        var data = {
            addToCartRoute: "http://localhost:8000/product/add-to-cart",
        };
    </script>
@stop
