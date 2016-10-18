@extends('cart.layout') @section('content')
<!---------------------------------------------------------------------------- [1] Contact ------------------------------------------------------------------------------>

<div class="cart-page cart-login">
	<div class="container cart-container">

		<h1>Login</h1>


		<div class="section">
			@if (count($errors) > 0)
				<div class="alert alert-danger" role="alert">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<form action="/cart/auth" method="POST" novalidate>
				{!! csrf_field() !!}

				<div class="">
					<div class="form-group clearfix">
						<div class="col-xs-12">
							<input type="email" id="email" name="payer_email" value="{{ old('payer_email') }}">
							<label for="email">Email</label>
						</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-xs-12">
							<input type="password" id="password" name="password">
							<label for="password">Password</label>
						</div>
					</div>

				</div>
				<div class="col-xs-12">
					<div class="form-group form-group-btn">
						<button type="submit" class="btn btn-default btn-block">Login</button>
					</div>
				</div>
			</form>


			<div>
				<ul class="social-login">
					<li>
						<a href="{{ url('/cart/auth/google/authorize') }}" class="gp" title="Sign-in with Gmail" target="_blank">
							<img src="{{ asset('/images/modal-google-icon.png') }}" alt="Sign-in with Gmail">
						</a>
					</li>
					<li>
						<a href="{{ url('/cart/auth/instagram/authorize') }}" class="tw" title="Sign-in with Instagram" target="_blank">
							<img src="{{ asset('/images/modal-instagram-icon.png') }}" alt="Sign-in with Instagram">
						</a>
					</li>
					<li>
						<a href="{{ url('/cart/auth/facebook/authorize') }}" class="fb" title="Sign-in with Facebook" target="_blank">
							<img src="{{ asset('/images/modal-fb-icon.png') }}" alt="Sign-in with Facebook">
						</a>
					</li>
				</ul>
			</div>
		</div>

	</div>
</div>


<!---------------------------------------------------------------------------- [3] Payment ------------------------------------------------------------------------------>
@stop @section('scripts')
<script type="text/javascript" src="{{ asset('{{ asset('js/pages/cart.js') }}') }}"></script>
@stop