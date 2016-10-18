@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')

@section('title', 'Frequently Asked Questions')
@section('description', 'We love our customers and love to hear from them. Our FAQs section is the quickest way to get your questions answered.')
@section('keywords', 'faq, customer service flavorgod, faq, faqs, flavorgod faqs, shipping time, gluten-free, kosher')
@section('content')

 <!-- common questions -->

        <!--FAQ section coding starts here-->
        <div class="faq-section section ">
            <div class="container">
                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>Do You Ship Internationally?</h2>
                        <p>Yes, I ship worldwide. I offer a flat rate shipping charge of $17.00 although I pay an average of $22 - $28 due to the size and weight of the box you’ll receive from me if you order my seasonings. You can share the shipping charge with family and friends by purchasing multiple times on one order and splitting the cost.</p>
                    </div>
                </div>
                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>Are your seasonings gluten-free &amp; Kosher?</h2>
                        <p>My seasonings are certified Kosher. They have also been tested in a lab and are Gluten Free.</p>
                    </div>
                </div>
                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>What if I accidently placed an order with the wrong address?</h2>
                        <p>We ask that you please double check your address and personal information prior to completing checkout. If you complete the transaction and feel that your address is inaccurate, then immediately message us through the website and we’ll assist you with updating your shipping information.</p>
                    </div>
                </div>
                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>How Do I Change My Order?</h2>
                        <p>Simply message us through the website and we’ll assist you with the necessary adjustments to your order. My staff will answer the emails in the order they were received.</p>
                    </div>
                </div>
                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>What does “back ordered” mean and how does it affect my order?</h2>
                        <p>The worldwide demand for my seasonings increases by a sizable margin every month. Due to the number of orders I receive each week, my operation can experience a back order of between an average of 7-10 days before the orders are shipped since they are fresh and made to order. As soon as the seasonings are blended and poured into jars, they are packaged and tracking information is emailed to the customer when their orders are shipped.</p>
                    </div>
                </div>
                <div class="row faq-bg faq-ads-bg">
                    <div class="adv-offer">
                         @if(isset($store))
                           @foreach($store->assets as $asset)
                                @if($asset->pivot->getAttribute('relation_type_name') == 'faq_banner_link')
                                    {{ $renderer->storeHtmlText('<a><h4>', $asset->path) }}
                                @endif
                           @endforeach
                        @endif
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
Do you have any free samples available?
                        </h2>
                        <p>
Unfortunately, I do not. All of my seasonings are made to order and once a batch is produced, the seasonings are poured directly into jars and physically attached to an order that had just been placed. Free sample packages tend to sit until their freshness is compromised which means I’d have to throw away seasonings that could have been shipped to a customer.



                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
Are your seasonings appropriate for meal preps?
                        </h2>
                        <p>
Absolutely!! Meal preps have a tendency to become repetitive and flavorless due to eating large quantities of foods in their most natural state for optimal nutrient consumption. Up until recently, athletes were eating for sustenance and to ensure that they were consuming enough calories per day according to their meal plans. Now they can simply cook with their Flavor God seasonings or even shake the seasonings over their meals for an enjoyable experience every time they’re ready to eat.



                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
My package was shipped from New Jersey but aren’t you based in Irvine, California?
                        </h2>
                        <p>
Yes, about a year ago I was running my entire operation by myself. At some point I knew I couldn’t handle shipping thousands of packages alone anymore. A friend of mine offered to help ship some of the packages for me and he owns a shipping warehouse in New Jersey.
                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
Are you hiring?
                        </h2>
                        <p>

I’m not currently hiring but if there comes a time that my operation is large enough to require a sizable work force, I’ll seek more employees.


                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
If I order from an international country, will I be charged a customs tax upon receiving my FlavorGod seasonings?
                        </h2>
                        <p>
Although it has happened a handful of times, we do not expect your customs to charge you a customs tax on the arrival of your package. We have shipped thousands of packages overseas and less than 5% have reported a customs tax. We spend over $23+ in shipping on our behalf to ship to most international countries and only charge our customers a flat rate of $17.00.



                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
Do you offer bulk orders?
                        </h2>
                        <p>
My operation is not currently equipped to handle bulk orders at this time. All of my resources are committed to filling the orders I receive each week. Bulk orders may require a large scale adjustment on my proprietary techniques for blending the seasonings.



                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
Can I pick up my order if I live near you?
                        </h2>
                        <p>

About a year ago, catching up with me was as easy as going to a local farmers market where I live and I’d personally hand you the seasonings as well as provide limitless consultation on their uses. Nowadays, it’s simply no longer possible to meet with me for a pickup because I could be just about anywhere at any time handling the day to day operations of my business.


                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
Where can I find your seasonings in stores?


                        </h2>
                        <p>
My seasonings are currently available only on my website. Since I spare no expense at making sure that your seasonings are made fresh to order, I prefer to stay as close to the operation as possible to ensure optimal quality assurance.



                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
What is the salt content of your seasonings?


                        </h2>
                        <p>
Seasonings in this industry can contain hundreds of milligrams of sodium per serving. This can pose as a risk for many people. My seasonings contain only 100% unprocessed sea salt at only 25-40 milligrams per ¼ teaspoon which is a fraction of what you find commercially (the only seasoning with a higher amount than this is my Himalayan Salt and Pepper seasoning which is an actual salt seasoning)



                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
How safe are your seasonings if I have food allergies or medical conditions?


                        </h2>
                        <p>
Always consult with your doctor if you have any health concerns regarding food allergies or medical conditions. Simply message me through my website if you have any specific questions and either myself or one of my staff will be more than happy to assist you.



                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
Do you have any GMO’s, preservatives, or MSG in your seasonings?


                        </h2>
                        <p>
My seasonings are vegan and do not contain any of the above mentioned substances nor do they contain sugars, refined sodium, fillers, or anti-caking agents which tend to be either synthetic or made with animal by-products. Only the Ranch seasoning is not vegan as it has a dairy component for an authentic Ranch taste (it is still GMO, Preservative and MSG free).



                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
What are the nutritional facts of your seasonings?


                        </h2>
                        <p>
My ingredients list and nutritional facts are available on my website for anyone to read and customers are invited to consult with either myself or any of my staff by messaging us through my website for the best ways to get the most out of your Flavor God seasonings.



                        </p>
                    </div>
                </div>

                <div class="row faq-bg">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                        <h2>
What information do you have regarding your limited edition seasonings?


                        </h2>
                        <p>
Contrary to a commonly held belief that I own a massive corporation with unlimited resources, I’m a small and privately owned business with only a handful of employees and my friend’s shipping warehouse. When resources permit, I’ll spend many weeks or months assembling ingredients and releasing a limited edition seasoning while supplies last. Once they are sold out, I will have to gather resources and funds to produce another batch of limited edition seasonings and be able to have another sale for those customers interested in experiencing the countless benefits of 100% pure herbs and spices and their seemingly limitless applications.

                        </p>
                    </div>
                </div>


            </div>
        </div>
        <!--FAQ section coding ends here-->
@stop