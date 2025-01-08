<x-app-layout>

	<section class="block-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12">

				<h3>Contact Us</h3>
				<p>Lumbersexual meh sustainable Thundercats meditation kogi. Tilde Pitchfork vegan, gentrify minim elit semiotics non messenger bag Austin which roasted Lumbersexual meh sustainable Thundercats meditation kogi. Tilde Pitchfork vegan, gentrify minim elit semiotics non messenger bag Austin which roasted</p>

				<div class="widget contact-info">

					<div class="contact-info-box">
						<div class="contact-info-box-content">
							<h4>News247 Webagency</h4>
							<p>Hungry Center, 3021 Horizon Circle</p>
						</div>
					</div>

					<div class="contact-info-box">
						<div class="contact-info-box-content">
							<h4>Mail Us</h4>
							<p><a href="https://demo.themewinter.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="187b77766c797b6c587b776a7671737d367b7775366d73">[email&#160;protected]</a></p>
						</div>
					</div>

					<div class="contact-info-box">
						<div class="contact-info-box-content">
							<h4>Call Us</h4>
							<p>+253-480-8973</p>
						</div>
					</div>

				</div><!-- Widget end -->

				<h3>Contact Form</h3>


                    @livewire('contactus')


				</div><!-- Content Col end -->

				<div class="col-lg-4 col-md-12">
					<div class="sidebar sidebar-right">
						<div class="widget">
							<h3 class="block-title"><span>Follow Us</span></h3>
							<ul class="social-icon">
                                @if(null !== ($icons = module(39)))
                                    @foreach ($icons as $icon)
                                        <!-- Each list item contains an anchor tag with the URL and icon class -->
                                        <li>
                                            <a href="{{ $icon->extra_field_2 }}" target="_blank">
                                                <i class="{{ $icon->extra_field_1 }}"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
						</div><!-- Widget Social end -->

						<div class="widget color-default">
							<h3 class="block-title"><span>Popular News</span></h3>


                            @if(null!==($posts = module(36)))
                            @foreach ($posts->take(3) as $post)
							<div class="post-overaly-style clearfix">
								<div class="post-thumb">
									<a href="#">
										<img class="img-fluid" src="{{asset('images/'.$post->image)}}" alt="" />
									</a>
								</div>

								<div class="post-content">
						 			<a class="post-cat" href="#">{{ title($post->category) }}</a>
						 			<h2 class="post-title title-small">
						 				<a href="{{route('post.detail',$post->slug)}}">{{ $post->title }}</a>
						 			</h2>
						 			<div class="post-meta">
						 				<span class="post-date">{{ date('M d, Y',strtotime($post->created_at)) }}</span>
						 			</div>
					 			</div><!-- Post content end -->
							</div><!-- Post Overaly Article end -->


                            @endforeach
                            @endif
						</div><!-- Popular news widget end -->

						<div class="widget text-center">
							<img class="banner img-fluid" src="images/banner-ads/ad-sidebar.png" alt="" />
						</div><!-- Sidebar Ad end -->

						<div class="widget m-bottom-0">
							<h3 class="block-title"><span>Newsletter</span></h3>
							<div class="ts-newsletter">
								<div class="newsletter-introtext">
									<h4>Get Updates</h4>
									<p>Subscribe our newsletter to get the best stories into your inbox!</p>
								</div>

								<div class="newsletter-form">
									<form action="#" method="post">
										<div class="form-group">
											<input type="email" name="email" id="newsletter-form-email" class="form-control form-control-lg" placeholder="E-mail" autocomplete="off">
											<button class="btn btn-primary">Subscribe</button>
										</div>
									</form>
								</div>
							</div><!-- Newsletter end -->
						</div><!-- Newsletter widget end -->

					</div><!-- Sidebar right end -->
				</div><!-- Sidebar Col end -->

			</div><!-- Row end -->
		</div><!-- Container end -->
	</section>

</x-app-layout>
