@extends('app')
@section('title', 'Contact Us')
@section('description', 'Have questions about your Flavorgod order? Message us, we love to hear form you.')
@section('keywords', 'contact us, contact flavorgod, distributor, wholesale, shipping')

@section('content')
 <!-- contact flavorgod -->

        <!--contact section coding start here-->
        <div class="contact-section section">
            <div class="container">
                <div class="col-xs-12 col-md-6  white-bg">
                    <div class="pd-col">
                        <h2>How do I contact Flavorgod?</h2>
                        <p>The future pleasure your taste buds will experience is only a few clicks away, but if you have any questions about my seasonings that haven’t been answered on this website already OR you’re interested in purchasing my products in bulk OR you have an interest to reach out to the @flavorgod publicist and management team, <span>simply fill out the form on this page or email <a class="red" href="mailto:support@flavorgod.com">support@flavorgod.com</a>.</span>
                        </p>
                        <p><span>Someone will be in touch as soon as possible…</span></p>

                    </div>
                    <div class="pd-col big-font">
                        <p>Due to <span>the incredible demand</span> over the last 30 days we are currently back ordered by 5-10 business days. We are taking the necessary steps <span>to speed up shipping</span> in the foreseeable future. Once you place your order, please allow us those 10 days to make your items FRESH for your specific order, and then send tracking to the email you used at checkout.</p>
                        <p><span>Thank you so much for your business and your patience.</span></p>
                        <div class="owner-name"><img src="images/red-cursive.png" alt="" title="" /></div>
                    </div>
                </div>

                <!--contact form coding start here-->
                <div class="col-xs-12 col-md-6 contact-form">
                     @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                             <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('SupportMessageSuccess'))
                        <div class="alert alert-success" role="alert"> {{ session('SupportMessageSuccess') }} </div>
                    @endif
                    <div class="wholesale_link">
                    Use our <a href="/wholesale">FLAVORGOD Wholesale Form</a> to inquire about Wholesale.
                    </div>
                    
                    <div class="">
                        <form method="POST" action="/support" novalidate>
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <div class="radio-box">
                                    <h4><span>PLEASE SELECT ONE OF THE FOLLOWING OPTIONS</span></h4>
                                    <div class="custom-radio">
                                        <input type="radio" name="enquiry_type" id="general-enquiry" value="general-enquiry" tabindex="1">
                                        <label for="general-enquiry">General  Inquiry</label>
                                    </div>
                                    <div class="custom-radio">
                                        <input type="radio" name="enquiry_type" id="tracking-support" value="tracking-support" tabindex="2">
                                        <label for="tracking-support">Tracking Support</label>
                                    </div>
                                    <div class="custom-radio">
                                        <input type="radio" name="enquiry_type" id="ebook-support" value="ebook-support" tabindex="3">
                                        <label for="ebook-support">Ebook Support</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="txtemail" placeholder="Example@gmail.com" tabindex="4">
                                <!--<label for="txtemail">Email</label>-->
                            </div>
                            <div class="form-group">
                                <input type="text" name="first_name" id="txtfname" placeholder="First Name" tabindex="5">
                            </div>
                            <div class="form-group">
                                <input type="text"  name="last_name" id="txtlname" placeholder="Last Name" tabindex="6">
                            </div>
                            <div class="form-group">
                                <textarea id="txtaddress" name="message" placeholder="Sample Message" tabindex="7"></textarea>
                            </div>
                            <button type="submit" class="btn btn-default btn-block" title="SUBMIT" tabindex="8">Submit</button>
                        </form>
                    </div>
                </div>
                <!--contact form coding ends here-->

            </div>
        </div>
        <!--contact section coding ends here-->
@stop