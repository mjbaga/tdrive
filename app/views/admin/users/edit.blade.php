@extends('admin._layouts.admin')

@section('content')

	{{ Form::model($user, array('route' => array('admin.users.update', $user->id), 'method' => 'put', 'class' => 'small-form')) }}
		<h2>Edit User</h2>
		<ul>
			<li>
				{{ Form::label('first_name', 'First Name: ') }}
				{{ Form::text('first_name') }}
				{{ $errors->first('first_name') }}
			</li>
			<li>
				{{ Form::label('last_name', 'Last Name: ') }}
				{{ Form::text('last_name') }}
				{{ $errors->first('last_name') }}
			</li>
			<li>
				{{ Form::label('email', 'Email: ') }}
				{{ Form::text('email') }}
				{{ $errors->first('email') }}
			</li>
			<li>
				{{ Form::label('mobile_no', 'Mobile No.:') }}
				{{ Form::text('mobile_no') }}
				{{ $errors->first('mobile_no', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('js/form-functions.js') }}

<script>
$(document).ready(function(){
	
	<?php if( Session::has('message') ) : ?>
		var message = "{{ Session::get('message')}}";
		var status = "{{ Session::get('sof') }}"
		
		var success = (status === 'success') ? '0' :'1';
	
		getFlashMessage(success, message);
	<?php endif; ?>
});
</script>
@stop