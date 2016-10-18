@extends('app')
@section('title', 'Reviews from real customers!')
@section('description', 'Flavorgod is loved by millions! Checkout our Instagram page @flavorgod to see real reviews by customers like yourselves!')
@section('keywords', 'flavorgod reviews, how is flavorgod, is flavorgod healthy, healthy seasoning options')
@section('content')
<!-- consumer reviews -->
<!--Review section coding starts here-->
<style>
@media (max-width: 768px){
h1.title{
display: none !important;
}
}
</style>
<div class="review-section section">
      <div class="container">
            <div class="row">
                  <div class="col-xs-12 text-center">
                        <h2>What everyone is talking about</h2>
                  </div>
            </div>
            <section class="on-social">
                  <div class="row white-bg">
                        <!-- Instagram & Facebook             -->
                        <div class="col-xs-12 no-mobile">
                              <h3 class="text-center">ON SOCIAL MEDIA</h3>
                              <div class="on-instagram">
                                    
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/instagram.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo1.jpg" alt="">
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo2.jpg" alt="">
                                          </div>
                                    </div>
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo3.jpg" alt="">
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/instagram.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo4.jpg" alt="">
                                          </div>
                                    </div>
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/instagram.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo5.jpg" alt="">
                                                
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/instagram.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo6.jpg" alt="">
                                          </div>
                                    </div>
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/instagram.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo7.jpg" alt="">
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo8.jpg" alt="">
                                          </div>
                                    </div>
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo9.jpg" alt="">
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/instagram.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo10.jpg" alt="">
                                          </div>
                                    </div>
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo11.jpg" alt="">
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo12.jpg" alt="">
                                          </div>
                                    </div>
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo13.jpg" alt="">
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo14.jpg" alt="">
                                          </div>
                                    </div>
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo15.jpg" alt="">
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo16.jpg" alt="">
                                          </div>
                                    </div>
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo17.jpg" alt="">
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo18.jpg" alt="">
                                          </div>
                                    </div>
                                    <div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo19.jpg" alt="">
                                          </div>
                                          <div class="col-xs-4 col-md-2">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/facebook.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo20.jpg" alt="">
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <!-- Youtube -->
                        <div class="col-xs-12 no-mobile">
                              <h3 class="text-center">ON YOUTUBE</h3>
                              <div class="on-youtube">
                                    <div class="col-xs-5 col-md-3">
                                          <a href="#video1" class="" data-toggle="modal">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/youtube-small.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/youtube/video1.jpg" alt="">
                                          </a>
                                    </div>
                                    <div class="col-xs-5 col-md-3">
                                          <a href="#video2" class="" data-toggle="modal">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/youtube-small.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/youtube/video2.jpg" alt="">
                                          </a>
                                    </div>
                                    <div class="col-xs-5 col-md-3">
                                          <a href="#video3" class="" data-toggle="modal">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/youtube-small.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/youtube/video3.jpg" alt="">
                                          </a>
                                    </div>
                                    <div class="col-xs-5 col-md-3">
                                          <a href="#video4" class="" data-toggle="modal">
                                                <img class="logos" src="https://flavorgod.s3.amazonaws.com/static/reviews/logos/youtube-small.png" alt="">
                                                <img src="https://flavorgod.s3.amazonaws.com/static/reviews/youtube/video4.jpg" alt="">
                                          </a>
                                    </div>
                              </div>
                        </div>
                  </section>
                  
                  <h3 class="text-center">EVERYWHERE</h3>
                  
                  <div class="row review-bg white-bg">
                        <div class="col-xs-12 col-md-8 no-mobile">
                              <h3>Customer Reviews</h3>
                              <div class="review-single">
                                    <div class="col-xs-2 col-md-1 no-right">
                                          <img class="avatar" src="https://flavorgod.s3.amazonaws.com/static/reviews/avatar/alex.png" alt="">
                                    </div>
                                    <div class="col-xs-10 col-md-11">
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          
                                          <div class="review-author">By <a target="_blank" href="https://www.instagram.com/alex_wrx15"><strong>@alex_wrx15</strong></a></div>
                                          
                                          Hands down the best food seasoning i have ever had, they taste great on almost anything. I can’t wait to try out the holy bbq on my chicken tomorrow and to try the beef jerky.
                                    </div>
                              </div>
                              <div class="review-single">
                                    <div class="col-xs-2 col-md-1 no-right">
                                          <img class="avatar" src="https://flavorgod.s3.amazonaws.com/static/reviews/avatar/anna.jpg" alt="">
                                    </div>
                                    <div class="col-xs-10 col-md-11">
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          
                                          <div class="review-author">By <a target="_blank" href="https://www.instagram.com/annamagurany"><strong>@annamagurany</strong></a></div>
                                          
                                          Omg, game changer. Takes care of my sweet tooth so well seriously 😍 have been loving all my prep meals lately, I actually look forward to every single one!
                                    </div>
                              </div>
                              <div class="review-single">
                                    <div class="col-xs-2 col-md-1 no-right">
                                          <img class="avatar" src="https://flavorgod.s3.amazonaws.com/static/reviews/avatar/anjelica.jpg" alt="">
                                    </div>
                                    <div class="col-xs-10 col-md-11">
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          
                                          <div class="review-author">By <a target="_blank" href="https://www.instagram.com/anjelicawithaj"><strong>@anjelicawithaj</strong></a></div>
                                          
                                          The first thing we pack! Obsessed ❤️👅Camping with out main squeeze 😍Flavorgod makes everything taste amazing. Veggies come alive and turkey burgers over the campfire are 10x more delicious. Thank you flavorgod!
                                    </div>
                              </div>
                              <div class="review-single">
                                    <div class="col-xs-2 col-md-1 no-right">
                                          <img class="avatar" src="https://flavorgod.s3.amazonaws.com/static/reviews/avatar/njx6.jpg" alt="">
                                    </div>
                                    <div class="col-xs-10 col-md-11">
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          
                                          <div class="review-author">By <a target="_blank" href="https://www.instagram.com/njx6"><strong>@njx6</strong></a></div>
                                          
                                          @flavorgod i received these and I cannot tell you how happy I am!!! I have tried both in the last two days and I am hooked!!! I cannot believe these have no calories and they make my overnight oats so much better!!! Thanks for getting these to me so quick and you have yourself a new, and returning customer!
                                    </div>
                              </div>
                              <div class="review-single">
                                    <div class="col-xs-2 col-md-1 no-right">
                                          <img class="avatar" src="https://flavorgod.s3.amazonaws.com/static/reviews/avatar/debra.jpg" alt="">
                                    </div>
                                    <div class="col-xs-10 col-md-11">
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          
                                          <div class="review-author">By <a target="_blank" href="https://www.instagram.com/biggestlittlecityvegan"><strong>@biggestlittlecityvegan</strong></a></div>
                                          
                                    I can’t even tell you how obsessed I am with these spices. I ran out of my favorites everything spicy and the garlic lovers and I thought my food had went on bland mode. New ones garlic and herb salt and cajun lovers. We’ll see if I fall in love again. If you have not trued these @flavorgod seasonings you’ve got to step up. No preservatives, no msg, no sugar, and low sodium.                              </div>
                              </div>
                              <div class="review-single">
                                    <div class="col-xs-2 col-md-1 no-right">
                                          <img class="avatar" src="https://flavorgod.s3.amazonaws.com/static/reviews/avatar/bod.jpg" alt="">
                                    </div>
                                    <div class="col-xs-10 col-md-11">
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          
                                          <div class="review-author">By <a target="_blank" href="https://www.instagram.com/biggestlittlecityvegan"><strong>@jbod_insane</strong></a></div>
                                          
                                          Man oh man oh man! I can’t get enough of this stuff.. The amount of feels I get once a new order comes in is the kind of stuff you read about in romance novels! Okay maybe not that dramatic but I am in love with this stuff! @flavorgod has become a staple in the Bodden household and the collection just keeps growing! I am at least a 4 star chef using this stuff… At least! If you have not tried it yet! Do yourself a goodness and do it! Hope everyone’s having a good week! Do good today! And do it great!
                                    </div>
                              </div>
                              <div class="review-single">
                                    <div class="col-xs-2 col-md-1 no-right">
                                          <img class="avatar" src="https://flavorgod.s3.amazonaws.com/static/reviews/avatar/thin.jpg" alt="">
                                    </div>
                                    <div class="col-xs-10 col-md-11">
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                          
                                          <div class="review-author">By <a target="_blank" href="https://www.instagram.com/thin2fat2fit"><strong>@thin2fat2fit</strong></a></div>
                                          
                                          This is my first time trying #flavorgod seasoning on the frill and OH MY GISH! You can tell the quality of this product just by the smell! I wish you’ll could smell what I’m smelling right now. I’m so glad i bought as many seasonings as I did… I think the grill and I just became best friends. Thanks @flavorgod
                                    </div>
                              </div>
                        </div>
                        <div class="customer-images col-xs-12 col-md-4 no-mobile">
                              <h3>Customer Images</h3>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo20.jpg" alt="">
                              </div>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo18.jpg" alt="">
                              </div>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo17.jpg" alt="">
                              </div>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo16.jpg" alt="">
                              </div>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo15.jpg" alt="">
                              </div>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo14.jpg" alt="">
                              </div>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo13.jpg" alt="">
                              </div>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo11.jpg" alt="">
                              </div>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo10.jpg" alt="">
                              </div>
                              <div class="col-xs-6">
                                    <img src="https://flavorgod.s3.amazonaws.com/static/reviews/instagram/photo9.jpg" alt="">
                              </div>
                        </div>
                        <div class="col-xs-12 text-center">
                              <p>Want to review Flavorgod? <a href="/vipreview">Learn more</a>
                              </p>
                        </div>
                  </div>

            </div>
      </div>
      <div class="videos-modals youtube-modals">
            
            <!-- Modal HTML -->
            <div id="video1" class="modal fade">
                  <div class="modal-dialog">
                        <div class="modal-content">
                              <div class="modal-body">
                                    <iframe class="iframe_video" width="560" height="315" src="//www.youtube.com/embed/LqRQup46arw" frameborder="0" allowfullscreen></iframe>
                              </div>
                        </div>
                  </div>
            </div>
            <!-- Modal HTML -->
            <div id="video2" class="modal fade">
                  <div class="modal-dialog">
                        <div class="modal-content">
                              <div class="modal-body">
                                    <iframe class="iframe_video" width="560" height="315" src="//www.youtube.com/embed/KP-hj5l4ZDA" frameborder="0" allowfullscreen></iframe>
                              </div>
                        </div>
                  </div>
            </div>
            <!-- Modal HTML -->
            <div id="video3" class="modal fade">
                  <div class="modal-dialog">
                        <div class="modal-content">
                              <div class="modal-body">
                                    <iframe class="iframe_video" width="560" height="315" src="//www.youtube.com/embed/RlmJGkCbeKM" frameborder="0" allowfullscreen></iframe>
                              </div>
                        </div>
                  </div>
            </div>
            <!-- Modal HTML -->
            <div id="video4" class="modal fade">
                  <div class="modal-dialog">
                        <div class="modal-content">
                              <div class="modal-body">
                                    <iframe class="iframe_video" width="560" height="315" src="//www.youtube.com/embed/Wq_3yFD6OFk" frameborder="0" allowfullscreen></iframe>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>
<script src="{{ asset('js/libs/owl.carousel.min.js') }}" type="text/javascript"></script>
<script>
$('.on-instagram').owlCarousel({
nav : false,
slideSpeed : 300,
paginationSpeed : 400,
autoplay: false,
items: 3,
responsive: {
0:{
items:2,
nav:false
},
600:{
items:3,
nav:false
},
1000:{
items:5,
nav:false,
loop:false
}
}
});
$('.on-youtube').owlCarousel({
nav : false,
slideSpeed : 300,
paginationSpeed : 400,
autoplay: false,
items: 2,
responsive: {
0:{
items:3,
nav:false
},
600:{
items:3,
nav:false
},
1000:{
items:3,
nav:false,
loop:false
}
}
});
</script>
<!--Review section coding ends here-->
@stop