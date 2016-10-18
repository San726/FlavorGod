@extends('app')

@section('content')
 <div class="profile-logging-section section">
	  <div class="container">
		  	<div class="row">
		  		<div class="col-md-8 col-md-offset-2">
					<h4 class="modal-title" id="modalSignupLabel">Reset Password</h4>
					<div class="alert alert-danger error-list" role="alert">
					</div>
			            <form action="/password/reset" method="POST" novalidate>
			            {!! csrf_field() !!}
			             <input type="hidden" name="token" value="{{ $token }}">
			              @if (count($errors) > 0)
			              		<div class="alert alert-danger" role="alert">
			              			 <ul>
							            @foreach ($errors->all() as $error)
							                <li>{{ $error }}</li>
							            @endforeach
						        	</ul>
			              		</div>
						    @endif
			                <div class="form-group">
			                    <input type="email" name="payer_email" class="form-control" value="{{ $email }}" placeholder="Youremail@example.com">
			                </div>
			                <div class="form-group">
			                    <input type="password" name="password" class="form-control" placeholder="new password">
			                </div>
			                <div class="form-group">
			                    <input type="password" name="password_confirmation" class="form-control" placeholder="confirm new password">
			                </div>
			                <div class="form-group form-group-btn">
			                    <button type="submit" class="btn btn-default">Reset Password</button>
			                </div>
			            </form>
				</div>
		  	</div>
		</div>
	</div>
@stop