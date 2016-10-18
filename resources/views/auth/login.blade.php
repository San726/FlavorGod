@extends('app')
@section('bodyOpenTag', '<body class="loading">')
@section('content')
 <div class="profile-logging-section section">
	  <div class="container">
		  	<div class="row">
		  		<div class="col-md-8 col-md-offset-2">					
					@if (count($errors) > 0)
	              		<div class="alert alert-danger" role="alert">
	              		@if(in_array('unverified', $errors->all()))
	              			<p>You have not verified your email. Please check your inbox and follow the verification steps. Can't find the email? <a href="/email/sendverify/{{ old('payer_email') ? old('payer_email') : session('email') }}">Click here to resend</a>.</p>
	              		@else
	              			 <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
				        	</ul>
				    	@endif
	              		</div>
					@endif
			            <form action="/auth/login" method="POST" novalidate>
			            {!! csrf_field() !!}
			                <div class="form-group">
			                    <input type="email" name="payer_email" class="form-control" value="{{ old('payer_email') ? old('payer_email') : session('email') }}" placeholder="Youremail@example.com">
			                </div>
			                <div class="form-group">
			                    <input type="password" name="password" class="form-control" placeholder="password">
			                </div>
			                <div class="form-group form-group-btn">
			                    <button type="submit" class="btn btn-default">Login</button>
			                </div>
			            </form>
				</div>
		  	</div>
		</div>
	</div>
@stop