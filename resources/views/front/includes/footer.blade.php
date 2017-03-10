<div class="footer-top-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="footer-about-us">
                    <h2>{!! trans('front.label.branch') !!}</h2>
                    <p>{{ trans('front.faker.lorem') }}</p>
                    <div class="footer-social">
                        <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">{{ trans('front.label.categories') }}</h2>
                    <ul>
                    @foreach ($categories as $category)
                        <li><a href="#">{{ $category->name }}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="footer-newsletter">
                    <h2 class="footer-wid-title">{{ trans('front.newsletter.title') }}</h2>
                    <p>{{ trans('front.newsletter.body') }}</p>
                    <div class="newsletter-form">
                        {!! Form::open() !!}
                            {!! Form::email('email', null, ['placeholder' => trans('front.newsletter.holder') ]) !!}
                            {!! Form::submit(trans('front.newsletter.button'), []) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End footer top area -->
<div class="footer-bottom-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="copyright">
                    <p>{{ trans('front.label.copyright') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-card-icon">
                    <i class="fa fa-cc-discover"></i>
                    <i class="fa fa-cc-mastercard"></i>
                    <i class="fa fa-cc-paypal"></i>
                    <i class="fa fa-cc-visa"></i>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End footer bottom area -->
