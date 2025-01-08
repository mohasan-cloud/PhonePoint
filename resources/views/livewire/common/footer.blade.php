<footer class="bb-footer margin-t-50">

    <div class="footer-container">
        <div class="footer-top padding-tb-50">
            <div class="container">
                <div class="row m-minus-991" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="col-sm-12 col-lg-3 bb-footer-cat">
                        <div class="bb-footer-widget bb-footer-company">
                            <img src="{{ asset(getSetting()->footer_logo) }}" class="bb-footer-logo" alt="{{ getSetting()->site_name }}">
                            <img src="{{ asset(getSetting()->footer_logo) }}" class="bb-footer-dark-logo" alt="{{ getSetting()->site_name }}">
                          
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-2 bb-footer-info">
                        <div class="bb-footer-widget">
                            <h4 class="bb-footer-heading">Category</h4>
                            <div class="bb-footer-links bb-footer-dropdown">
                                <ul class="align-items-center">
                                    @if(null !== ($categories = module(107)))
                                    @foreach ($categories->take(6) as $category)
                                        <li class="bb-footer-link">
                                            <a href="{{ url('Category/' . $category->slug) }}">{{ $category->title }}</a>
                                        </li>
                                    @endforeach
                                @endif
                                
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-2 bb-footer-account">
                        <div class="bb-footer-widget">
                            <h4 class="bb-footer-heading">Company</h4>
                            <div class="bb-footer-links bb-footer-dropdown">
                                <ul class="align-items-center">
                                    <li class="bb-footer-link">
                                        <a href="{{ url('/about_us') }}">About us</a>
                                    </li>
                                    <li class="bb-footer-link">
                                        <a href="{{ url('/delivery') }}">Delivery</a>
                                    </li>
                                    <li class="bb-footer-link">
                                        <a href="{{ url('/legalNotice') }}">Legal Notice</a>
                                    </li>
                                    <li class="bb-footer-link">
                                        <a href="{{ url('/Terms_&_Conditions') }}">Terms & conditions</a>
                                    </li>
                                    
                                    <li class="bb-footer-link">
                                        <a href="{{ url('/contact_us') }}">Contact us</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-2 bb-footer-service">
                        <div class="bb-footer-widget">
                            <h4 class="bb-footer-heading">Account</h4>
                            <div class="bb-footer-links bb-footer-dropdown">
                                <ul class="align-items-center">
                                  
                                    <li class="bb-footer-link">
                                        <a href="{{ url('/login') }}">Sign In</a>
                                    </li>
                                    @auth
                                    <li class="bb-footer-link">
                                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                                    </li>  
                                    @endauth
                                    @auth
                                    <li class="bb-footer-link">
                                        <a href="{{ url('/cart') }}">View Cart</a>
                                    </li>  
                                    @endauth
                                    <li class="bb-footer-link">
                                        <a href="{{ url('/Return_Policy') }}">Return Policy</a>
                                    </li>
                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-3 bb-footer-cont-social">
                        <div class="bb-footer-contact">
                            <div class="bb-footer-widget">
                                <h4 class="bb-footer-heading">Contact</h4>
                                <div class="bb-footer-links bb-footer-dropdown">
                                    <ul class="align-items-center">
                                        <li class="bb-footer-link bb-foo-location">
                                            <span class="mt-15px">
                                                <i class="ri-map-pin-line"></i>
                                            </span>
                                            <p>{{ getSetting()->address }}</p>
                                        </li>
                                        <li class="bb-footer-link bb-foo-call">
                                            <span>
                                                <i class="ri-whatsapp-line"></i>
                                            </span>
                                            <a href="https://wa.me/{{ preg_replace('/\D/', '', getSetting()->phone_1) }}" target="_blank">
                                                {{ getSetting()->phone_1 }}
                                            </a>
                                        </li>
                                        
                                        <li class="bb-footer-link bb-foo-mail">
                                            <span>
                                                <i class="ri-mail-line"></i>
                                            </span>
                                            <a href="mailto:  {{ getSetting()->email_1 }}">{{ getSetting()->email_1 }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="bb-footer-social">
                            <div class="bb-footer-widget">
                                <div class="bb-footer-links bb-footer-dropdown">
                                    <ul class="align-items-center">
                                        <li class="bb-footer-link">
                                            <a href="{{ getSetting()->facebook }}"><i class="ri-facebook-fill"></i></a>
                                        </li>
                                        <li class="bb-footer-link">
                                            <a href="{{ getSetting()->twitter }}"><i class="ri-twitter-fill"></i></a>
                                        </li>
                                        <li class="bb-footer-link">
                                            <a href="{{ getSetting()->linkedin }}"><i class="ri-linkedin-fill"></i></a>
                                        </li>
                                        <li class="bb-footer-link">
                                            <a href="{{ getSetting()->Instagram }}"><i class="ri-instagram-line"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="bb-bottom-info">
                        <div class="footer-copy">
                            <div class="footer-bottom-copy ">
                                <div class="bb-copy">Copyright © <span id="copyright_year"></span>
                                    <a class="site-name" href="https://www.linkedin.com/in/mohasan-saeed-5968b629b/">MohasanSaeed</a> all rights reserved.
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
