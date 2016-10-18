@inject('renderer', 'Flavorgod\Http\Services\HtmlRenderer')
@extends('app')

@section('title', 'About FlavorGod Seasongs & Where to Buy')
@section('description', 'Find out how its possible to Paleo Seasoning, GMO Free, MSG Free and delicious flavoring all packed in one bottle!')
@section('keywords', 'paleo, msg free, seasoning, who is chris wallace, chris wallace, healthy seasonings')
@section('content')

        <div class="about-section section">
            <div class="container">
                <!--Video section coding start here-->
                <div class="row white-bg">
                    <div class="col-xs-12">
                        <div class="youtube-video">
                            <img src="images/aboutus-video.jpg" alt="" title="" />
                            <div class="youtube-vieo-btn">
                                <img src="images/press-video-btn.png" alt="" title="" />
                            </div>
                            <a class="fa fa-close" title="Close" href="#"></a>
                            <div class="iframe-video">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/YNC2c1r4lVA" allowfullscreen></iframe>
                            </div>
                        </div>

                    </div>
                </div>
                <!--Video section coding ends here-->
                <!--Aboutus section coding start here-->
                <div class="row white-bg who-flavor">
                    <div class="col-xs-12 pd-col">
                        <h2>Who is Flavor God</h2>
                        <p>When I first began making these seasonings in 2012, I relentlessly experimented to find the impeccable elements that would separate my seasonings from everything else currently available in the market. After endless hours in the state-of-the-art FLAVORGOD facilities, I was able to perfect the blend for multiple seasonings that met every specification I had set out to meet without compromising flavor or quality! My goal is to keep seasonings chemical and filler free, keeping low salt levels, and always staying true to the herbs and spices that I use. Sacrificing nutritional value has never been an option. The health of people and the foods we eat on a daily basis is what truly matters to me.
                        </p>
                        <p>Shortly after I created these seasonings, I began selling them at local farmers markets. My seasonings are crafted with care and shipped to countries all over the world. I’m not a huge corporation. I’m one man with a dream and the support of the best team I could ever ask for. Our dream is to provide creative recipes and healthy seasonings everyone will always enjoy.</p>

                    </div>
                    <div class="col-xs-12 pd-col">
                        <p class="big-font">My mission is and always will be to <span>provide people with unique and delicious seasonings</span> that help them create amazing meals everyday in kitchens all around the world.</p>
                        <p class="small-font">Thank you to all of our fans, customers, and affiliates for supporting us in our journey to share our seasonings across the world!</p>
                    </div>
                </div>
                <!--Aboutus section coding ends here-->
                <!--CTA Banner coding start here-->
                <div class="row">
                    <!--<div class="col-xs-12 adv-offer">-->
                    <!--    <a href="#">-->
                    <!--        <h4>Save 75% NOW with the 7 Bottle Combo Pack </h4>-->
                    <!--    </a>-->
                    <!--</div>-->
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
                <!--CTA Banner coding ends here-->
                <!--Instragram section coding starts here-->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="instragram-content">
                            <div class="row white-bg">
                                <div class="col-xs-4 col-sm-4">
                                    <div class="instagram-img">
                                        <img src="images/instagram-feed-1.jpg" alt="" title="" />
                                        <div class="instagram-icon"><img src="images/instragram-icon.png" alt="Instagram" title="Instagram" /></div>
                                    </div>
                                    <p>Chris prides himself on attention to detail in everything he does. From the photography on his social media to every ounce of food and seasonings he prepares in the kitchen!</p>
                                </div>
                                <div class="col-xs-4 col-sm-4">
                                    <div class="instagram-img">
                                        <img src="images/instagram-feed-2.jpg" alt="" title="" />
                                        <div class="instagram-icon"><img src="images/instragram-icon.png" alt="Instagram" title="Instagram" /></div>
                                    </div>
                                    <p>No matter how many customers or fans @flavorgod gains, Chris makes sure he’s involved in every aspect of the supply chain process. He might have even packaged your shipment!</p>
                                </div>
                                <div class="col-xs-4 col-sm-4">
                                    <div class="instagram-img">
                                        <img src="images/instagram-feed-3.jpg" alt="" title="" />
                                        <div class="instagram-icon"><img src="images/instragram-icon.png" alt="Instagram" title="Instagram" /></div>
                                    </div>
                                    <p>At the end of the day, Chris spends his time coming up with new formulas, recipes, and experiences for all of the fans across the world; the customers who rely on our products, and his friends &amp; family!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Instragram section coding ends here-->
            </div>
        </div>
@stop