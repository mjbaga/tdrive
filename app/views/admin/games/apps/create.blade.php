@extends('admin._layouts.admin')

@section('content')
	<article>

		{{ Form::open(array('route' => array('admin.games.store.app', $game->id), 'class' => 'large-form tab-container', 'id' => 'tab-container')) }}
			<div class='panel-container'>
				<h3 class="center">{{ $game->main_title }} App</h3>

				<br>

				@if(Session::has('message'))
				    <div class="flash-success">
				        <p>{{ Session::get('message') }}</p>
				    </div>
				@endif
				<br>
				<li>
					{{ Form::label('title', 'Title:') }}	
					{{ Form::text('title', $game->main_title) }}
					{{ $errors->first('title', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('carrier_id', 'Carrier:') }}
			  		{{ Form::select('carrier_id', $carriers, null, array('id' => 'carrier')) }}				
					{{ $errors->first('carrier_id', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('language_id', 'Language:') }}
					<select name="language_id" id="language">
						@foreach($languages as $language)
							<option value="{{ str_pad($language->id, 2, '0', STR_PAD_LEFT) }}" data-isocode="{{ strtolower($language->iso_code) }}">{{ $language->language }}</option>
						@endforeach
					</select>
				</li>
				<li>
					{{ Form::label('app_id', 'App ID:') }}	
					{{ Form::text('app_id', null, array('id' => 'app_id')) }}
					{{ $errors->first('app_id', '<p class="error">:message</p>') }}
				</li>
				
				<li>
					{{ Form::label('content', 'Content:') }}	
					{{ Form::textarea('content', null, array('id' => 'content')) }}
					{{ $errors->first('content', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('excerpt', 'Excerpt:') }}	
					{{ Form::textarea('excerpt') }}
					{{ $errors->first('excerpt', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('currency_code', 'Currency:') }}
			  		{{ Form::select('currency_code', $currencies, array('value'=>'USD')) }}				
					{{ $errors->first('currency_code', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('price', 'Price: ') }}
					{{ Form::text('price', $default_price) }}
					{{ $errors->first('price', '<p class="error">:message</p>') }}
				</li>
				<br>
			</div>
			{{ Form::submit('Save') }}
		{{ Form::close() }}
	</article>
	{{ HTML::script('js/form-functions.js') }}
	<script type="text/javascript">
		CKEDITOR.replace('content');
	</script>
	<script>
	var gid = '{{ str_pad($game->id, 4, "0", STR_PAD_LEFT) }}',
		app_text = $('#app_id'),
		carrier = $('#carrier'),
		language = $('#language')
		title = $('#title');

	var app_id = gid + carrier.find('option:first').val() + language.find('option:first').val();

	$(document).ready(function() {
		app_text.val(app_id);
	});

	carrier.on('change', function() {
		app_id = gid + $(this).find('option:selected').val() + language.find('option:selected').val();

		app_text.val(app_id);
	});

	language.on('change', function() {
		app_id = gid + carrier.find('option:selected').val() + language.find('option:selected').val();

		app_text.val(app_id);

	});

	</script>
@stop