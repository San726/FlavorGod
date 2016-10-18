@extends('app')
@section('bodyOpenTag', '<body class="loading">')
@section('content')
 <div class="profile-logging-section section">
	  <div class="container">
		  	<div class="row">
		  		<div class="col-md-8 col-md-offset-2">
					@if (count($errors) > 0)
	              		<div class="alert alert-danger" role="alert">
	              			 <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
				        	</ul>
	              		</div>
					@endif
					@if(session('success'))
						<div class="alert alert-success" role="alert">
							{{ session('success') }}
						</div>
					@endif
			            <form action="/auth/register" method="POST" novalidate>
			            {!! csrf_field() !!}
			                <div class="form-group">
			                    <input type="email" name="payer_email" class="form-control" value="{{ old('payer_email') }}" placeholder="Youremail@example.com">
			                </div>
			                <div class="form-group">
			                    <input type="password" name="password" class="form-control" placeholder="new password">
			                </div>
			                <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype Password">
                             </div>
			                <div class="form-group form-group-btn">
			                    <button type="submit" class="btn btn-default">submit</button>
			                </div>
			            </form>
				</div>
		  	</div>
		</div>
	</div>
@stop