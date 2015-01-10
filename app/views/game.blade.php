@extends('_layouts/single')

@section('stylesheets')
	{{ HTML::style("css/slick.css"); }}
	{{ HTML::style("css/jquery.fancybox.css"); }}
	{{ HTML::style("css/idangerous.swiper.css"); }}
@stop

@section('content')

	{{ HTML::image("images/games/{$game->slug}.jpg", $game->main_title, array('id' => 'featured')) }}

	<div id="top" class="clearfix container">
		<div class="thumb">
			{{ HTML::image("images/games/thumb-{$game->slug}.jpg", $game->main_title) }}
		</div>

		<div class="title">
			<h3>{{{ $game->main_title }}}</h3>

			<ul class="categories clearfix">

				@foreach ($game->categories as $item)
					<li><a href="{{ route('category.show', $item->id) }}">{{ $item->category }}</a></li>
				@endforeach

			</ul>

			<p>Release: {{{ $game->release_date }}}</p>
		</div>
	</div><!-- end #top -->

	<div id="buttons" class="container clearfix">
		<div class="downloads">
			<div class="vcenter">
				<p class="count">100</p>
				<p class="words"><span>Thousand</span> Downloads</p>
			</div>
		</div>

		<div class="ratings">
			<div class="vcenter">
				<p class="count">4.3</p>

				<div class="stars">
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="total">453,962 Total</p>
			</div>
		</div>

		<a href="#" class="buy">
			<div>
				<p class="image clearfix">{{ HTML::image('images/buy.png', 'Buy', array('class' => 'auto')) }}<span>Buy Now</span></p>
				<p class="price">P{{{ $game->default_price }}}.00</p>
			</div>
		</a>

		<!--<a href="#" class="download">
			<div>
				<p class="clearfix">{{ HTML::image('images/download.png', 'Download', array('class' => 'auto')) }}<span>Download</span></p>
			</div>
		</a>-->
	</div><!-- end #buttons -->

	<div id="description" class="container">

		@foreach($game->contents as $item)
			{{ $item->pivot->content }}
		@endforeach

		<!--<p>Stack as many cats as possible. All kinds of cats will appear. Fat cats, kittens, even cats with top hats!</p>	
		<p>Touch and tilt, but be careful. The tower may fall apart!</p>	
		<p>Mew Mew Tower Premium is a simple and exciting game enjoyed by all ages.</p>	
		<p>Test you skills and luck with friends in 2 player mode! Cute backgrounds are also unlockable wallpapers!</p>	-->
	</div><!-- end #description -->

	<div id="screenshots" class="container">
		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">

				@foreach($related_games as $game)
					@foreach($game->categories as $category)

						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc1.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc1.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc2.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc2.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc3.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc3.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc1.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc1.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc2.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc2.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc3.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc3.jpg', 'Mew Mew Tower') }}</a></div>

					@endforeach
				@endforeach

			</div>
		</div>
	</div>

	<div id="statistics" class="container">
		<div class="top clearfix">
			<p class="count">4.3</p>

			<div class="stars-container">
				<div class="stars">
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="total">5,649,796 Total</p>
			</div>

			<div class="social clearfix">
				<a href="#" class="share">
					{{ HTML::image('images/share.png', 'Share', array('class' => 'auto')) }}
					<span>Share</span>
				</a>

				<a href="#" class="likes">
					{{ HTML::image('images/likes.png', 'Likes', array('class' => 'auto')) }}
					<span>10,000,000 liked this</span>
				</a>
			</div>
		</div>

		<div class="bottom">
			<div class="five clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span></span>
					<p class="total">3,677,764</p>
				</div>
			</div>

			<div class="four clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span></span>
					<p class="total">1,009,887</p>
				</div>
			</div>

			<div class="three clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span></span>
					<p class="total">443,260</p>
				</div>
			</div>

			<div class="two clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span></span>
					<p class="total">189,961</p>
				</div>
			</div>

			<div class="one clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span></span>
					<p class="total">328,887</p>
				</div>
			</div>
		</div>
	</div><!-- end #statistics -->

	<div id="review" class="container">

		@if (Auth::check())

			{{ Form::open(array(URL::to(Request::segment(1)))) }}

				{{ Form::token() }}

				<div class="control">
					<input type="text" name="username" placeholder="username">
				</div>

				<div class="control">
					<input type="text" name="subject" placeholder="subject">
				</div>

				<div class="captcha control clearfix">
					{{ HTML::image(Captcha::img(), 'Captcha image') }}
					{{ Form::text('captcha', null, array('placeholder' => 'Type what you see...')) }}

					<?php if (Request::getMethod() == 'POST') {
						$rules =  array('captcha' => array('required', 'captcha'));
						$validator = Validator::make(Input::all(), $rules);

						if ($validator->fails()) {
							echo '<p class="captcha-error"><i class="fa fa-close"></i> Incorrect</p>';
						} else {
							echo '<p class="captcha-correct"><i class="fa fa-check"></i> Matched</p>';
						}
					} ?>
				</div>

				<div class="control">
					<textarea name="message" placeholder="message"></textarea>
				</div>

				<div class="control">
					<input type="submit" value="Submit">
				</div>
			</form>

		@else

			<div class="button">
				<a href="{{ route('users.login') }}">Login to write a review <i class="fa fa-pencil"></i></a>
			</div>

		@endif

	</div><!-- end #review -->

	<div id="reviews" class="container">
		
		@forelse($reviews as $data)
			<div class="entry clearfix">
				{{-- HTML::image('images/avatars/jaypee-onza.jpg', 'Jaypee Onza') --}}

				{{-- dd($data->toArray())  --}}
				<div>
					<p class="name">{{ $data->first_name }}</p>

					<div class="stars">
						@for ($i=1; $i <= 5 ; $i++)
		                    <i class="fa fa-star{{ ($i <= Review::getRatingsPerUser($data->id)) ? '' : '-empty'}}"></i>
		                 @endfor    
						<!-- <a href="#"><i class="fa fa-star"></i></a>
						<a href="#"><i class="fa fa-star"></i></a>
						<a href="#"><i class="fa fa-star"></i></a>
						<a href="#"><i class="fa fa-star"></i></a> -->
					</div>

					<p class="date">August 8, 2014</p>

					<p class="message">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
				</div>
			</div>
		@empty
			<p>No reviews yet.</p>
		@endforelse

		

		<div class="link center"><a href="{{ route('reviews', $game->id) }}">See all reviews &raquo;</a></div>
	</div><!-- end #reviews -->

	<div id="related-games" class="container">
		<h1 class="title">Related games</h1>

		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">

				@foreach($related_games as $game)

					<div class="swiper-slide item">
						<div class="thumb relative">
							@if ($game->default_price == 0)
								{{ HTML::image('images/ribbon.png', 'Free', array('class' => 'free auto')) }}
							@endif

							<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image("images/games/thumb-{$game->slug}.jpg") }}</a>
						</div>

						<div class="meta">
							<p class="name">{{{ $game->main_title }}}</p>

							@unless ($game->default_price == 0)
								<p class="price">P{{{ $game->default_price }}}.00</p>
							@endunless
						</div>

						@if ($game->default_price == 0)
							<div class="button center"><a href="#">Get</a></div>
						@else
							<div class="button center"><a href="#">Buy</a></div>
						@endif
					</div>

				@endforeach

			</div>
		</div>

		<div class="more"><a href="{{ route('games.all') }}">More +</a></div>
	</div><!-- end #related-games -->

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/slick.min.js"); }}
	{{ HTML::script("js/jquery.fancybox.js"); }}
	{{ HTML::script("js/idangerous.swiper.min.js"); }}

	<script>
		FastClick.attach(document.body);

		$('.thumbs-container').each(function() {
			$(this).swiper({
				slidesPerView: 'auto',
				offsetPxBefore: 0,
				offsetPxAfter: 10,
				calculateHeight: true
			})
		})

		$('.fancybox').fancybox({ padding: 0 });
	</script>
@stop
