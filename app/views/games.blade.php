@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')

	<div class="container">
		<h1 class="title">New and updated games</h1>

		<div id="token">{{ Form::token() }}</div>

		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">

					@foreach ($games as $game)
						@foreach ($game->media as $media)

							@if($media->type == 'icons')
								<div class="item">
									<div class="thumb relative">
										@if ($game->default_price == 0)
											<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
										@endif

										<a href="{{ URL::route('game.show', $game->id) }}" class="thumb-image"><img src="assets/games/icons/{{ $media->url }}"></a>

										@if ($game->default_price == 0)
											<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
										@endif
									</div>

									<div class="meta">
										<p>{{ $game->main_title }}</p>
										
										@unless ($game->default_price == 0)
											@foreach($game->prices as $price) 
												@if(Session::get('country_id') == $price->pivot->country_id && Session::get('carrier') == $price->pivot->carrier_id)
													<p class="price">{{ $country->currency_code . ' ' . number_format($price->pivot->price, 2) }}</p>
												@endif
											@endforeach
										@endunless
									</div>

									@if ($game->default_price == 0)
										<!--<div class="button center"><a href="#">Get</a></div>-->
									@else
										<!--<div class="button center"><a href="#">Buy</a></div>-->
									@endif
								</div>
							@endif

						@endforeach
					@endforeach

				</div>
			</div>
		</div>

		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>

	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

	<script>
		FastClick.attach(document.body);

		var load = 0;
		var _token = $('#token input').val();
		var num = {{ $count }};

		$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$(window).scroll(function() {
			$('.ajax-loader').show();

			load++;

			if (load * 6 > num) {
				$('.ajax-loader').hide();
			} else {

				$.ajax({
					url: "{{ url() }}/games/all/more",
					type: "POST",
					data: {
						load: load,
						_token: _token
					},
					success: function(data) {
						$('#scroll').append(data);
						$('.ajax-loader').hide();
					}
				});

			}
		});
	</script>
@stop
