@extends('admin._layouts.admin')

@section('stylesheets')
	<style>
		/*button{ background: #4288CE !important; }
		button:hover {background: #333333 !important; }*/
		
		p.approved {color: green !important;}
		p.pending {color: #555 !important;}
	
	</style>
@stop

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="games-list">
		<h2>Reviews</h2>
		<div  class="fleft label-dropdown">
			Games 
		</div>
		<div class="fleft ">
		{{ Form::open(array('route' => 'admin.reviews.game','class' => 'simple-form', 'id' => 'submit-game', 'method' => 'get')) }}
			{{ Form::select('selected_game', $games, $selected, array('class' => 'select-filter', 'id' => 'select-game')) }}
		{{ Form::close() }}
		</div>
		<div class="clear"></div>


	<div class="table-responsive">
		<button id="delete-btn" class="btn-delete">Delete</button>
	<form method="POST" action="{{ URL::route('admin.destroy.review') }}">
		{{ Form::token() }}

		@if (count($reviews))

		<table class="table table-striped table-bordered table-hover"  id="review_table">
			<thead>
				<tr>
					<th class="no-sort"><input id="select-all" type="checkbox"></th>
					<th>Game Title</th>
					<th>Name</th>
					<th>Status</th>
					<th>Rating</th>
					<th>Date Created</th>
				</tr>
			</thead>

			<tbody>

				@foreach($reviews as $review)
								
					<tr>
						<td><input class="chckbox" type="checkbox" name="checked[]" value="{{ $review->id }}"></td>
						<td>
							
							<a href="{{ URL::route('review.show', $review->id) }}">
								@if($review->viewed == 0 )

									{{ '<i class="fa fa-envelope"></i>  '. $review->game->main_title }}

								@else

									{{ $review->game->main_title }}

								@endif

							</a>
							<ul class="actions">	
								<li><a href="{{ URL::route('review.show', $review->id) }}">View</a></li>
								<li><a class="red" href="{{ URL::route('reviews.delete', $review->id) }}">Delete</a></li>
							</ul>
							
						</td>

						<td>{{ $review->user->first_name . ' ' . $review->user->last_name }}</td>
						
						<!-- <td>{{ str_limit($review->review, $limit = 200, $end = '...') }}</td> -->

						<td>
							@if($review->status == 1)
								<p class="approved">Approved</p>
								<!-- <input type="checkbox" class="status" name="status[]" value="{{ $review->status }}" checked id="{{ $review->id }}"/> -->
							@else
								<!-- <input type="checkbox" class="status" name="status[]" value="{{ $review->status }}" id="{{ $review->id }}" /> -->
								<p class="pending">Pending</p>
							@endif
						</td>
						<td>		

							@for ($i=$review->rating; $i>= 1 ; $i--)
		                      <i class="fa fa-star"></i>
		                    @endfor      
													
						</td>
						<td>
							{{ Carbon::parse($review->created_at)->format('M j, Y') }} <br>
							{{ Carbon::parse($review->created_at)->format('g:i A') }}
						</td>
					</tr>
				@endforeach				
			</tbody>
		</table>
		@else
			<p>No reviews</p>
		@endif
		
	</div>
		{{ $reviews->links() }}
		<br>
	</div>
	<script>
		$("document").ready(function(){
	        $('.status').on('click', function() {

	        	var id = $(this).attr('id');
	        	var checked = ($(this).is(':checked')) ? 1 : 0;

	        	// alert(id + ' ' + checked)

	            $.ajax({
	                type: "POST",
	                url : "{{ URL::route('admin.reviews.status') }}",
	                data :{
	                	"status": checked,
	                	"id": id
	                },
	                success : function(data){
	                    console.log('data');
	                }
	            });
	    	});
		});
	</script>
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){

			<?php if( Session::has('message') ) : ?>
				var message = "{{ Session::get('message')}}";
				var success = '1';
				getFlashMessage(success, message);
			<?php endif; ?>

			$('#select-game').on('change', function() {
				$('#submit-game').trigger('submit');
			});

			if(!$("input[type='checkbox'].chckbox").is(':checked'))
			{
				$('#delete-btn').prop('disabled', true);
				$('#delete-btn').addClass('btn-disabled');

			}

			$('#delete-btn').on('click', function(e) {				
			    
			    if($("input[type='checkbox'].chckbox").is(':checked')){

			    	if(!confirm("Are you sure you want to delete this item?")) e.preventDefault();
			  
			    } else {

			       alert("Please select the box that you want to delete");
			   
			    }								
				
			});

		   /**  
				* Purpose: Fixed sorting on the rating column
				* Date: 01/22/2015
			
		   $('#review_table').dataTable( {
		      "aoColumnDefs": [
		          { 'bSortable': true, 'aTargets': [ 5 ], "sType": "formatted-num" }
		        
		       ]
			});
			*/

			$('#review_table').dataTable({
		        "order": [[ 5, "desc" ]],
		        "bLengthChange": false,
		        "oLanguage": {
	                "sSearch": "<span>Search  </span> _INPUT_", //search
	            }
		    });

		   $('#select-all').click(function(){			   
		

				if(this.checked) { // check select status

					$('.chckbox').each(function() { //loop through each checkbox

				   		this.checked = true;  //select all checkboxes with class "chckbox"   

					});

				} else {

					$('.chckbox').each(function() { //loop through each checkbox

					    this.checked = false; //deselect all checkboxes with class "chckbox"  

					});  
				}   
				if(!$("input[type='checkbox'].chckbox").is(':checked'))
				{
					$('#delete-btn').prop('disabled', true);
					$('#delete-btn').addClass('btn-delete-disabled');
					$('#delete-btn').removeClass('btn-delete-enabled');
				}
				else 
				{
					$('#delete-btn').prop('disabled', false);
					$('#delete-btn').removeClass('btn-delete-disabled');
					$('#delete-btn').addClass('btn-delete-enabled');
				}
			      
			});

			$('.chckbox').change(function() {
				if(!$("input[type='checkbox'].chckbox").is(':checked'))
				{
					$('#delete-btn').prop('disabled', true);
					$('#delete-btn').addClass('btn-delete-disabled');
					$('#delete-btn').removeClass('btn-delete-enabled');
				}
				else 
				{
					$('#delete-btn').prop('disabled', false);
					$('#delete-btn').removeClass('btn-delete-disabled');
					$('#delete-btn').addClass('btn-delete-enabled');
				}

			}) 


		});

	</script>

@stop