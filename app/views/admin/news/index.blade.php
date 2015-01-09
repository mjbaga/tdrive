@extends('admin._layouts.admin')

@section('content')

	<div class="item-listing" id="news-list">
		<h2>News</h2>
		<a href="{{ URL::route('admin.news.create') }}" class="mgmt-link">Create News</a>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif

		<br><br><br><br>

		<table  class="table table-striped table-bordered table-hover"  id="news_table">
			<thead>
				<tr>
					<th><input type="checkbox"></th>
					<th>Title</th>
					<th>Languages</th>
					<th>Category</th>
					<th>Date</th>
				</tr>
			</thead>

			<tbody>

				@forelse($news as $data)
					
					<tr>
						<td><input type="checkbox"></td>
						<td>
							<a href="#">{{ $data->main_title }}</a>
							<ul class="actions">
								<li><a href="{{ URL::route('admin.news.edit', $data->id) }}">Edit</a></li>
								<li><a href="">View</a></li>
								<li>
								{{ Form::open(array('route' => array('admin.news.destroy', $data->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}

								</li>
							</ul>
						</td>
						<td>
							@foreach($data->languages as $row)
								{{ $row->language }}
							@endforeach
						</td>

						<td>								
							{{ $data->NewsCategory->category }}								
						</td>
						<td>{{ $data->created_at }}</td>
						
					</tr>
							
			@empty
				<tr class="tall-tr">
					<td colspan="6"><p>You haven't created any news yet.</p></td>
				</tr>
			@endforelse

			</tbody>
		
		</table>
	
		<br>
		
	</div>

@stop

@section('scripts')

	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}

	<script>
	$(document).ready(function(){
		$('#news_table').DataTable();
		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});
	});

	</script>
@stop