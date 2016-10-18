@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer') @extends('app') @section('bodyClass') product slimmer @stop @section('content')
<div class="productpage-breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Shop</a></li>
            <li class="breadcrumb-item active">3 Bottle - The Party Pack</li>
        </ol>
    </div>
</div>
<div class="container productpage">
    <div class="row">
        <div class="col-sm-6 product-slider">
            <div class="owl-carousel product-carousel">
                <div class="item"><img src="/images/gallery-pro-yellow.png"></div>
                <div class="item"><img src="/images/gallery-pro-red.png"></div>
                <div class="item"><img src="/images/gallery-pro-green.png"></div>
                <div class="item"><img src="/images/gallery-pro-red.png"></div>
                <div class="item"><img src="/images/gallery-pro-yellow.png"></div>
                <div class="item"><img src="/images/gallery-pro-green.png"></div>
            </div>
        </div>
        <div class="col-sm-6 product-details">
            <div class="product-title">
                <h2>3 Bottle - The Party Pack</h2>
                <h3>(Pizza,Taco Tuesday, Ranch) <span class="rattingpan"><span class="reviewlink"><span class="ratings fourhalf"></span> 162 Reviews</span></span></h3> </div>
            <div class="sale-price">
                <div class="price-text">
                    Sale Price:
                </div>
                <div class="price-number">
                    <span class="price-value">$34.99</span>
                    <span class="msrp">$84.97</span>
                </div>
            </div>
            <div class="seasoning">
                <h4>SEASONING BEST WITH</h4>
                <div class="seasons">
                    <uL>
                        <li><img src="/images/donut.png"><span class="sflavor">CHICKEN</span></li>
                        <li><img src="/images/donut.png"><span class="sflavor">FISH</span></li>
                        <li><img src="/images/donut.png"><span class="sflavor">SALAD</span></li>
                        <li><img src="/images/donut.png"><span class="sflavor">DONUT</span></li>
                    </uL>
                </div>
            </div>
            <p>Tacos, Pizza and Ranch! As a foodie these are some of my favorite flavors! My newest Combo Pack features these flavors that are quickly becoming a few of my customers favorite seasonings!</p>
            <div class="bunddle">
                <span class="bimg"><img src="/images/all3.jpg"></span>
                <div>
                    <p>Want to swap products? No problem.</p>
                    <button class="button-border-red">CUSTOMIZE BUNDLE</button>
                </div>
            </div>
            <div class="addcart">
                <div class="qty"><span>QTY</span>
                    <input type="number" value="0" min="0"><span class="qtyplus"><i class="fa fa-plus" aria-hidden="true"></i></span><span class="qtyminus"><i class="fa fa-minus" aria-hidden="true"></i></span></div>
                <button class="button-red">ADD TO CART</button>
            </div>
            <p class="shipfee">FREE US Shipping on orders over $50 | Canada Shipping (+$9) | International Shipping (+$17)</p>
        </div>
    </div>
    <div class="product-description-row">
        <div class="col-sm-8 product-tabs">
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#home">Product Description</a></li>
                <li><a data-toggle="pill" href="#menu1">What’s Included</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <h3>3 Bottle - The Party Pack</h3>
                    <p>Tacos, Pizza and Ranch! As a foodie these are some of my favorite flavors! My newest Combo Pack features these flavors that are quickly becoming a few of my customers favorite seasonings! My Pizza seasoning infuses your meals with the flavors that satisfy the Italian cuisine aficionado in all of us. The taco seasoning is my newest runaway favorite for turning every day into Taco Tuesday! And finally, my Ranch seasoning is perfect for all of your snacks, appetizers, and party platters! My Party Pack is your ultimate set of flavors for entertaining family and friends! Let the PARTY BEGIN!!</p>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
        Pizza Seasoning</a>
      </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse">
                                <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
        Taco Tuesday Seasoning</a>
      </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse">
                                <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
        Ranch Seasoning</a>
      </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                                <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 product-pack">
            <h2>COMPLETE THE PACK</h2>
            <label class="packcard" for="packcard1"><span class="pimg"><img src="/images/all3.jpg"></span>
                <span class="cbox"><input type="checkbox" id="packcard1"><span> </span> Your Item</span>
                <div>
                    <h5>3 Bottle - The Party Pack</h5>
                    <small>$29.99</small>
                    <span>$19.99</span></div>
            </label>
            <label class="packcard" for="packcard2"><span class="pimg"><img src="/images/all3.jpg"></span>
                <span class="cbox"><input type="checkbox" id="packcard2"><span> </span> Your Item</span>
                <div>
                    <h5>3 Bottle - The Party Pack</h5>
                    <small>$29.99</small>
                    <span>$19.99</span></div>
            </label>
            <label class="packcard" for="packcard3"><span class="pimg"><img src="/images/all3.jpg"></span>
                <span class="cbox"><input type="checkbox" id="packcard3"><span> </span> Your Item</span>
                <div>
                    <h5>3 Bottle - The Party Pack</h5>
                    <small>$29.99</small>
                    <span>$19.99</span></div>
            </label>
            <h4>TOTAL PRICE: <span>$61.00</span></h4>
            <button class="button-border-red">ADD ALL 3 TO CART</button>
        </div>
    </div>
</div>
<div class="similarproduct">
    <h2>YOU MAY ALSO LIKE</h2>
    <div class="container">
        <div class="owl-carousel sameproduct-carousel">
            <div class="item">
                <div class="prod-card-single">
                    <a href="#" class="prode-img" title="Everything Seasoning">
                        <img class="lazy" src="/images/bottle.jpg">
                        <div class="prode-overlay">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <span class="ctop">VIEW DETAILS</span>
                                    <span class="cbottom">ADD TO CART</span>
                                </div>
                            </div>
                        </div>
                        <div class="prode-cat">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <img src="/images/COMBO_icon_circle.png">
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="prode-descr">
                        <h2><a href="#" class="prod-img" title="Everything Seasoning">Fiesta Sweet & Tangy Seasoning</a></h2>
                        <h3><small>$29.99</small><span>$19.99</span></h3>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="prod-card-single">
                    <a href="#" class="prode-img" title="Everything Seasoning">
                        <img class="lazy" src="/images/bottle.jpg">
                        <div class="prode-overlay">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <span class="ctop">VIEW DETAILS</span>
                                    <span class="cbottom">ADD TO CART</span>
                                </div>
                            </div>
                        </div>
                        <div class="prode-cat">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <img src="/images/COMBO_icon_circle.png">
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="prode-descr">
                        <h2><a href="#" class="prod-img" title="Everything Seasoning">Dynamite Seasoning</a></h2>
                        <h3><small>$29.99</small><span>$19.99</span></h3>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="prod-card-single">
                    <a href="#" class="prode-img" title="Everything Seasoning">
                        <img class="lazy" src="/images/bottle.jpg">
                        <div class="prode-overlay">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <span class="ctop">VIEW DETAILS</span>
                                    <span class="cbottom">ADD TO CART</span>
                                </div>
                            </div>
                        </div>
                        <div class="prode-cat">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <img src="/images/COMBO_icon_circle.png">
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="prode-descr">
                        <h2><a href="#" class="prod-img" title="Everything Seasoning">Cajun Lovers Seasoning</a></h2>
                        <h3><small>$29.99</small><span>$19.99</span></h3>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="prod-card-single">
                    <a href="#" class="prode-img" title="Everything Seasoning">
                        <img class="lazy" src="/images/bottle.jpg">
                        <div class="prode-overlay">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <span class="ctop">VIEW DETAILS</span>
                                    <span class="cbottom">ADD TO CART</span>
                                </div>
                            </div>
                        </div>
                        <div class="prode-cat">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <img src="/images/COMBO_icon_circle.png">
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="prode-descr">
                        <h2><a href="#" class="prod-img" title="Everything Seasoning">Cajun Lovers Seasoning</a></h2>
                        <h3><small>$29.99</small><span>$19.99</span></h3>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="prod-card-single">
                    <a href="#" class="prode-img" title="Everything Seasoning">
                        <img class="lazy" src="/images/bottle.jpg">
                        <div class="prode-overlay">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <span class="ctop">VIEW DETAILS</span>
                                    <span class="cbottom">ADD TO CART</span>
                                </div>
                            </div>
                        </div>
                        <div class="prode-cat">
                            <div class="cat-table">
                                <div class="cat-tables">
                                    <img src="/images/COMBO_icon_circle.png">
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="prode-descr">
                        <h2><a href="#" class="prod-img" title="Everything Seasoning">Cajun Lovers Seasoning</a></h2>
                        <h3><small>$29.99</small><span>$19.99</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-faq">
    <div class="row">
        <h2 class="longtitle">FREQUENTLY ASKED QUESTIONS</h2>
    </div>
    <div class="row qas">
        <div class="container">
            <div class="col-sm-6 ques">
                <h2>Q</h2>
                <ul class="qnum">
                    <li>DO YOU SHIP INTERNATIONALLY?</li>
                    <li>ARE YOUR SEASONINGS GLUTEN FREE & KOSHER?</li>
                    <li>HOW DO I CHANGE MY ORDER?</li>
                    <li>DO YOU HAVE ANY FREE SAMPLES AVAILABLE?</li>
                    <li>DO YOU OFFER BULK ORDERS?</li>
                    <li>WHERE CAN I FIND YOUR SEASONINGS IN STORES?</li>
                    <li>CAN I PICK UP MY ORDER IF I LIVE NEAR YOU?</li>
                </ul>
            </div>
            <div class="col-sm-6 answer">
                <div class="">
                    <h2>A</h2>
                    <p>Yes, I ship worldwide. I offer a flat rate shipping charge of $17.00 although I pay an average of $22 - $28 due to the size and weight of the box you’ll receive from me if you order my seasonings. You can share the shipping charge with family and friends by purchasing multiple times on one order and splitting the cost.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="reviews">
    <div class="row">
        <h2 class="longtitle">RATINGS & REVIEWS</h2>
    </div>
    <div class="row row-eq-height">
        <div class="col-sm-4 bg">
            <span class="ratings fourhalf"></span> <span class="numberrating">4.7</span>
            <p>162 REVIEWS</p>
            <h4>WRITE A REVIEW</h4>
            <h5>Tell us what do you think about this product. We value your feedback.</h5>
            <button class="button-white" data-toggle="modal" data-target="#wrtreview">WRITE A REVIEW</button>
            <!-- Write Review Modal -->
            <div class="modal fade" id="wrtreview" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">WRITE A PRODUCT REVIEW</h4>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div>
                                    <p class="overal">Overal Rating <span class="asterik">*</span></p>
                                    <p>First Name <span class="asterik">*</span></p>
                                    <input type="text" placeholder="Ex: Great Taste">
                                    <p>Last Name <span class="asterik">*</span></p>
                                    <input type="text" placeholder="Ex: Great Taste">
                                    <p>Your Email <span class="asterik">*</span></p>
                                    <input type="email" placeholder="Ex: your@email.com">
                                    <p>Review Title <span class="asterik">*</span></p>
                                    <input type="text" placeholder="Ex: Great Taste">
                                    <p>Review <span class="asterik">*</span></p>
                                    <textarea placeholder="Ex: I am so glad that I have tried this product…"></textarea>
                                    <div class="cbox">
                                        <input type="checkbox" id="chef">
                                        <label for="chef"> </label> I am a professional chef</div>
                                    <p>Name of the restaurant your work <span class="asterik">*</span></p>
                                    <input type="text" placeholder="Ex: Hilton Hotels">
                                    <p class="requiredfield">Fields indicated with ( * ) are required</p>
                                </div>
                                <button class="button-red">SUBMIT</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8 review">
            <div class="row row-eq-height">
                <div class="col-sm-3 namedate">
                    <div class="cat-table">
                        <div class="cat-tables">
                            By Tony
                            <br> On August 24,2016
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 feedback">
                    <span class="ratings fourhalf"></span>
                    <h3>Love it! Tastes great!</h3>
                    <p>Hands down the best food seasoning i have ever had, they taste great on almost anything. I can’t wait to try out the holy bbq on my chicken tomorrow and to try the beef jerky.</p>
                </div>
            </div>
            <div class="row row-eq-height">
                <div class="col-sm-3 namedate">
                    <div class="cat-table">
                        <div class="cat-tables">
                            By Tony
                            <br> On August 24,2016
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 feedback">
                    <span class="ratings fourhalf"></span>
                    <h3>Love it! Tastes great!</h3>
                    <p>Hands down the best food seasoning i have ever had, they taste great on almost anything. I can’t wait to try out the holy bbq on my chicken tomorrow and to try the beef jerky.</p>
                </div>
            </div>
            <div class="row row-eq-height">
                <div class="col-sm-3 namedate">
                    <div class="cat-table">
                        <div class="cat-tables">
                            By Tony
                            <br> On August 24,2016
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 feedback">
                    <span class="ratings fourhalf"></span>
                    <h3>Love it! Tastes great!</h3>
                    <p>Hands down the best food seasoning i have ever had, they taste great on almost anything. I can’t wait to try out the holy bbq on my chicken tomorrow and to try the beef jerky.</p>
                </div>
            </div>
            <div class="row row-eq-height">
                <div class="col-sm-3 namedate">
                    <div class="cat-table">
                        <div class="cat-tables">
                            By Tony
                            <br> On August 24,2016
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 feedback">
                    <span class="ratings fourhalf"></span>
                    <h3>Love it! Tastes great!</h3>
                    <p>Hands down the best food seasoning i have ever had, they taste great on almost anything. I can’t wait to try out the holy bbq on my chicken tomorrow and to try the beef jerky.</p>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="recipie">
    <div class="recipie-details">
        <div class="container">
            <div class="col-sm-7 details">
                <h3>Lettuce-Wrap Turkey Tacos RECIPIE</h3>
                <ul>
                    <li>1 lb ground turkey</li>
                    <li>2 tbsp extra virgin olive oil</li>
                    <li>2 tbsp FlavorGod Taco Tuesday</li>
                    <li>1 tsp FlavorGod Pink S+P</li>
                    <li>cherry tomatoes, halved avocado, sliced cilantro, minced romaine lettuce</li>
                </ul>
                <p>Heat olive oil in large skillet over medium heat, then add ground turkey. Cook until browned and no longer pink, then add pink s+p and taco tuesday seasonings. Cook 2 more minutes.</p>
                <p>Assemble tacos by spooning some taco turkey mixture into romaine leaves, topping with tomatoes, avocaodo, and cilantro.</p>
            </div>
            <div class="col-sm-5 recipie-slider">
                <h4>Lettuce-Wrap Turkey Tacos <div class="owlprev" onclick="$('.recipie-carousel').trigger('.recipie-carousel.prev');"></div><div class="owlnext" onclick="$('.recipie-carousel').trigger('.recipie-carousel.next')"></div></h4>
                <div class="owl-carousel recipie-carousel">
                    <div class="item"><img src="/images/lettuce-slider.jpg"></div>
                    <div class="item"><img src="/images/lettuce-slider.jpg"></div>
                    <div class="item"><img src="/images/lettuce-slider.jpg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="book">
        <div class="container">
            <div class="col-sm-6">
                <p>Choose from hundreds of different recipes for your next meal.</p>
                <button class="button-grey" data-toggle="modal" data-target="#ebook">VIEW RECIPE E-BOOKS</button>
                <!-- Write Review Modal -->
                <div class="modal fade" id="ebook" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">RECIPE E-BOOKS</h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-sm-6 ritem">
                                            <label class="col-sm-6" for="ritem1"><span class="pimg"><img src="/images/ebook.jpg"></span>
                                                <span class="cbox"><small>SELECT</small><input type="checkbox" id="ritem1"><span> </span></span>
                                                <div>
                                                    <div class="cat-table">
                                                        <div class="cat-tables">
                                                            <h5>Italian Zest Ebook</h5>
                                                            <span>SALE PRICE: </span>
                                                            <span>$9.95</span>
                                                            <small>$29.95</small></div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-sm-6 ritem">
                                            <label class="col-sm-6" for="ritem2"><span class="pimg"><img src="/images/ebook.jpg"></span>
                                                <span class="cbox"><small>SELECT</small><input type="checkbox" id="ritem2"><span> </span></span>
                                                <div>
                                                    <div class="cat-table">
                                                        <div class="cat-tables">
                                                            <h5>Garlic Herb & Himalayan Salt Seasoning Recipe Book</h5>
                                                            <span>SALE PRICE: </span>
                                                            <span>$9.95</span>
                                                            <small>$29.95</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-sm-6 ritem">
                                            <label class="col-sm-6" for="ritem3"><span class="pimg"><img src="/images/ebook.jpg"></span>
                                                <span class="cbox"><small>SELECT</small><input type="checkbox" id="ritem3"><span> </span></span>
                                                <div>
                                                    <div class="cat-table">
                                                        <div class="cat-tables">
                                                            <h5>Garlic Herb & Himalayan Salt Seasoning Recipe Book</h5>
                                                            <span>SALE PRICE: </span>
                                                            <span>$9.95</span>
                                                            <small>$29.95</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-sm-6 ritem">
                                            <label class="col-sm-6" for="ritem4"><span class="pimg"><img src="/images/ebook.jpg"></span>
                                                <span class="cbox"><small>SELECT</small><input type="checkbox" id="ritem4"><span> </span></span>
                                                <div>
                                                    <div class="cat-table">
                                                        <div class="cat-tables">
                                                            <h5>Garlic Herb & Himalayan Salt Seasoning Recipe Book</h5>
                                                            <span>SALE PRICE: </span>
                                                            <span>$9.95</span>
                                                            <small>$29.95</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-sm-6 ritem">
                                            <label class="col-sm-6" for="ritem5"><span class="pimg"><img src="/images/ebook.jpg"></span>
                                                <span class="cbox"><small>SELECT</small><input type="checkbox" id="ritem5"><span> </span></span>
                                                <div>
                                                    <div class="cat-table">
                                                        <div class="cat-tables">
                                                            <h5>Garlic Herb & Himalayan Salt Seasoning Recipe Book</h5>
                                                            <span>SALE PRICE: </span>
                                                            <span>$9.95</span>
                                                            <small>$29.95</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-sm-6 ritem">
                                            <label class="col-sm-6" for="ritem6"><span class="pimg"><img src="/images/ebook.jpg"></span>
                                                <span class="cbox"><small>SELECT</small><input type="checkbox" id="ritem6"><span> </span></span>
                                                <div>
                                                    <div class="cat-table">
                                                        <div class="cat-tables">
                                                            <h5>Garlic Herb & Himalayan Salt Seasoning Recipe Book</h5>
                                                            <span>SALE PRICE: </span>
                                                            <span>$9.95</span>
                                                            <small>$29.95</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-sm-6 ritem">
                                            <label class="col-sm-6" for="ritem7"><span class="pimg"><img src="/images/ebook.jpg"></span>
                                                <span class="cbox"><small>SELECT</small><input type="checkbox" id="ritem7"><span> </span></span>
                                                <div>
                                                    <div class="cat-table">
                                                        <div class="cat-tables">
                                                            <h5>Garlic Herb & Himalayan Salt Seasoning Recipe Book</h5>
                                                            <span>SALE PRICE: </span>
                                                            <span>$9.95</span>
                                                            <small>$29.95</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-sm-6 ritem">
                                            <label class="col-sm-6" for="ritem8"><span class="pimg"><img src="/images/ebook.jpg"></span>
                                                <span class="cbox"><small>SELECT</small><input type="checkbox" id="ritem8"><span> </span></span>
                                                <div>
                                                    <div class="cat-table">
                                                        <div class="cat-tables">
                                                            <h5>Garlic Herb & Himalayan Salt Seasoning Recipe Book</h5>
                                                            <span>SALE PRICE: </span>
                                                            <span>$9.95</span>
                                                            <small>$29.95</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <button class="button-red">ADD TO CART</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="lastimg">
    <div class="container">
        <img class="img-compare" src="/images/compare.jpg" />
    </div>
</div>

@section('styles')
<link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}" type="text/css" /> @stop @section('lib-scripts')
<script type="text/javascript" src="{{ asset('js/libs/owl.carouselbeta.min.js') }}"></script>
@stop @section('scripts')
<script>
    $(".ritem input[type='checkbox']").each(function() {
        if ($(this).is(":checked")) {
            $(this).parent().parent().css('border-color', '#db2f2f');
            $(this).parent().children('small').html('SELECTED');
            $(this).parent().children('span').css('border-color', '#b4292c');
            $(this).parent().css('background-color', '#db2f2f');
        } else {
            $(this).parent().parent().css('border-color', '#afafaf');
            $(this).parent().children('small').html('SELECT');
            $(this).parent().children('span').css('border-color', '#9d9d9d');
            $(this).parent().css('background-color', '#afafaf');
        }
    });
    $(".ritem input[type='checkbox']").change(function() {
        if ($(this).is(":checked")) {
            $(this).parent().parent().css('border-color', '#db2f2f');
            $(this).parent().children('small').html('SELECTED');
            $(this).parent().children('span').css('border-color', '#b4292c');
            $(this).parent().css('background-color', '#db2f2f');
        } else {
            $(this).parent().parent().css('border-color', '#afafaf');
            $(this).parent().children('small').html('SELECT');
            $(this).parent().children('span').css('border-color', '#9d9d9d');
            $(this).parent().css('background-color', '#afafaf');
        }
    });

    $(".product-carousel").owlCarousel({
        items: 1,
        nav: false,
        dots: true,
        autoplay: true
    });

    $(".recipie-carousel").owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        autoplay: true
    });
    $(".sameproduct-carousel").owlCarousel({
        items: 5,
        nav: true,
        margin: 20,
        dots: false,
        autoplay: true
    });



    // the following to the end is whats needed for the thumbnails.
    jQuery(document).ready(function() {


        // 1) ASSIGN EACH 'DOT' A NUMBER
        dotcount = 1;

        jQuery('.product-carousel .owl-dot').each(function() {
            jQuery(this).addClass('dotnumber' + dotcount);
            jQuery(this).attr('data-info', dotcount);
            dotcount = dotcount + 1;
        });

        // 2) ASSIGN EACH 'SLIDE' A NUMBER
        slidecount = 1;

        jQuery('.product-carousel .owl-item').not('.cloned').each(function() {
            jQuery(this).addClass('slidenumber' + slidecount);
            slidecount = slidecount + 1;
        });

        // SYNC THE SLIDE NUMBER IMG TO ITS DOT COUNTERPART (E.G SLIDE 1 IMG TO DOT 1 BACKGROUND-IMAGE)
        jQuery('.product-carousel .owl-dot').each(function() {

            grab = jQuery(this).data('info');

            slidegrab = jQuery('.slidenumber' + grab + ' img').attr('src');

            jQuery(this).css("background-image", "url(" + slidegrab + ")");

        });


    });
</script>
@stop @endsection
