@extends('cart.layout')
@section('content')
    <!--viplist section coding starts here-->
    <div class="viplist-section section">
        <div class="container">
            <!--vipform coding starts here-->
            <div class="row viplist-form col-xs-6 ">
                <div class="col-xs-12 pdlf0">
                    <h5>Contact <span>information</span></h5>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                             <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="#" method="POST" novalidate>
			                {!! csrf_field() !!}
			                <div class="form-group">
			                    <input type="text" name="first_name" class="form-control" value="{{ session('first_name') ? session('first_name') : '' }}" placeholder="first name">
			                </div>
			                <div class="form-group">
			                    <input type="text" name="last_name" class="form-control" value="{{ session('last_name') ? session('last_name') : '' }}" placeholder="last name">
			                </div>
			                <div class="form-group">
                                <input type="text" name="email" class="form-control"  value="{{ session('email') ? session('email') : '' }}" placeholder="email">
                             </div>
                             <div class="form-group">
                                <input type="text" name="phone" class="form-control" value="{{ session('phone') ? session('phone') : '' }}" placeholder="phone">
                             </div>
			                <div class="form-group form-group-btn">
			                    <button type="submit" class="btn btn-default">submit</button>
			                </div>
			            </form>
			            <a href="#" class="btn btn-default">Paypal</a>
			            <a href="#" class="btn btn-default">Credit Card</a>
                </div>
            </div>
            <!--vipform coding ends here-->
        </div>
    </div>
@stop