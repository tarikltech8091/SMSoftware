@extends('layout.master')
@section('content')
@include('layout.bradecrumb')

<!--error message*******************************************-->
<div class="row page_row">
	<div class="col-md-12">
		@if($errors->count() > 0 )

		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<h6>The following errors have occurred:</h6>
			<ul>
				@foreach( $errors->all() as $message )
				<li>{{ $message }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		@if(Session::has('message'))
		<div class="alert alert-success" role="alert">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{ Session::get('message') }}
		</div> 
		@endif

		@if(Session::has('errormessage'))
		<div class="alert alert-danger" role="alert">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{ Session::get('errormessage') }}
		</div>
		@endif

	</div>
</div>
<!--end of error message*************************************-->

<div class="row page_row">
	<div class="col-md-12">
		<div class="panel panel-body padding_0">
			<div class="sorting_form"><!--header inline form-->
			<form method="get" action="{{url('/accounts/student/payment/summery')}}" enctype="multipart/form-data">
				<?php 
				$program_list =\App\Applicant::ProgramList();

				?>
				<div class="form-group col-md-6">
					<label for="Program">Program</label>
					<select class="form-control program" name="program" >
						<option value="0">All</option>
						@if(!empty($program_list))
						@foreach($program_list as $key => $list)
						<option {{(isset($_GET['program']) && ($list->program_id==$_GET['program'])) ? 'selected':''}} value="{{$list->program_id}}">{{$list->program_title}}</option>
						@endforeach
						@endif
					</select>
				</div>


				<div class="form-group col-md-4">
					<label for="AcademicYear">Batch</label>
					<select class="form-control " name="batch_no" >
						<option value="0">All</option>
						@if(!empty($batch_list))
						@foreach($batch_list as $key => $list)
						<option {{(isset($_GET['batch_no']) && ($list->batch_no == $_GET['batch_no'])) ? 'selected':''}} value="{{$list->batch_no}}">{{$list->batch_no}}</option>
						@endforeach
						@endif
					</select>
				</div>

				<div class="form-group col-md-1" style="margin-top:20px;">
					<button class="btn btn-danger total_registered_student_search" data-toggle="tooltip" title="Search Students">Serach</button>
				</div>
			</form>
			@if(isset($_GET['program']) && isset($_GET['batch_no']))
				<div class="col-md-1 margin_top_20">
					<span class="btn btn-warning" data-toggle="tooltip" title="Download Student Payment Summery List"><a href="{{url('/accounts/student/payment/summery/excel/program-'.$_GET['program'].'/batch-'.$_GET['batch_no'])}}"> <i class="fa fa-print"></i></a></span>
				</div>
			@endif
			</div>
		</div><!--/header inline form-->
	</div>



	<div class="page_row">

		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">Sutdent List</div>
				<div class="panel-body"><!--info body-->

					@if(!empty($all_student_payment_summery_info))
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>SL</th>
								<th>Student ID</th>
								<th>Student Name</th>
								<th>Program</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>Total Receiable</th>
								<th>Total Receiable Paid</th>
								<th>Others Paid</th>
								<th>Due</th>
							</tr>
						</thead>
						<tbody>

							@foreach($all_student_payment_summery_info as $key => $list)
							<?php 
								$student_details=unserialize($list); 
							?>
							<tr>

								<td>{{$key+1}}</td>
								<td>{{$student_details[0]}}</td>
								<td>{{$student_details[1]}}</td>
								<td>{{$student_details[2]}}</td>
								<td>{{$student_details[3]}}</td>
								<td>{{$student_details[4]}}</td>
								<td>{{$student_details[5]}}</td>
								<td>{{$student_details[6]}}</td>
								<td>{{$student_details[7]}}</td>
								<td>{{$student_details[8]}}</td>
							</tr>
							@endforeach

						</tbody>
					</table>
					@else
					<div class="alert alert-success">
						<center><h3 style="font-style:italic">No Data Found !</h3></center>
					</div>
					@endif
				</div><!--/info body-->
			</div>
		</div>
		
	</div>

</div>
<input type="hidden" name="current_page_url" class="current_page_url" value="{{\Request::fullUrl()}}">
<input type="hidden" name="site_url" class="site_url" value="{{url('/')}}">

@stop