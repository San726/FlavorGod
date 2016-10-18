{{-- modal 1 --}}
<div class="modal fade profile-modal" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-vip">
        <div class="modal-content">
            <div class="modal-header">
                <strong>SHARE DISCOUNT LINK WITH FRIENDS & FAMILY</strong>
            </div>
            <div class="modal-body">
                <ul class="social-icons">
                    <li>
                        <a href="#"><i class="fa fa-envelope"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                </ul>
                <div class="modal-text-block">
                    <div class="img-left">
                        <img src="{{ asset('images/flavor-god-bottles.png') }}" alt="flavor god bottles">
                    </div>
                    <div class="text-content">
                        <h5>BEST SEASONNING EVER</h5>
                        <p>I give to you Flavorgod. The best seasoning for your meals you will get ever. Try them with this 15% off link. You can thank me later</p>
                        <a href="#">http://flavorgod.com/?refer-a-friend=k021jd</a>
                    </div>
                </div>
                <form action="#" class="vip-form">
                    <div class="form-group">
                        <textarea placeholder="Write your own message" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group form-link">
                        <label>Input comma seperated emails or <img src="{{ asset('images/icon-gmail.png') }}" alt="gmail icon"> <a href="#">Import Contacts</a></label>
                        <input type="email" placeholder="Enter friends email addresses ">
                    </div>
                    <div class="form-group submit-hold">
                        <button type="submit" class="btn btn-default">send</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
