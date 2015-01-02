@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')

	<div class="container">
		<h1 class="title">{{{ $news }}}</h1>

		<div id="scroll" class="clearfix">
			@include('_partials/year')
		</div>

		<div class="ajax-loader"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}

	<script>
		FastClick.attach(document.body);

		$(window).scroll(function() {
			if ($(window).scrollTop() == $(document).height() - $(window).height()) {
				$('.ajax-loader').show();

				$.ajax({
					url: "/loadmore/" + {{ $news->id }},

					success: function(html) {
						if (html) {
							$("#scroll").append(html);
							$('.ajax-loader').hide();
						} else {
							$('.ajax-loader').html('<p class="center">No more games to show.</p>');
						}
					}
				});
			}
		});
	</script>
@stop
