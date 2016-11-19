<?php
/**
 * Created by PhpStorm.
 * User: coolfire
 * Date: 09.04.15
 * Time: 17:59
 */
?>



<!-- Slider -->
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div id="carousel" class="carousel slide">

            <div class="carousel-inner">
                <div class="item active">
                    <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/slide-01.jpg">
                </div>
                <div class="item">
                    <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/slide-02.jpg">
                </div>
                <div class="item">
                    <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/slide-03.jpg">
                </div>
            </div>
            <div>
                <a href="#carousel" class="" data-slide="prev" >
                    <span class="glyphicon glyphicon-backward"></span>
                </a>
                <a href="#carousel" class="" data-slide="next" style="float:right;">
                    <span class="glyphicon glyphicon-forward"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="row" style="margin-top:5px;">
            <div class="col-xs-4 col-md-2 col-md-offset-2"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/fiveplus.png"></div>
            <div class="col-xs-8 col-md-8"><p class="atention">100 % Confidential<br>NO PLAGIARISM</p></div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-xs-4 col-md-2 col-md-offset-2"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/deal.png"></div>
            <div class="col-xs-8 col-md-8 "><p class="atention">Free Revisions<br>World-class writers</p></div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-xs-4 col-md-2 col-md-offset-2"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/message.png"></div>
            <div class="col-xs-8 col-md-8"><p class="atention">24/7 Support<br>Delivered on time</p></div>
        </div>
    </div>
</div>
<div id="fast-order" class="row" style="margin-top: 2em; display: none;">
    <form id="go_price" action="/site/page" method="post">
        <div class="col-xs-12 col-md-3" style="padding-bottom: 2em;">
            <select type="text" class="form-control input-lg alternative-select">
                <option value="" selected disabled>Select type</option>
                <optgroup label="Essays">
                    <option value="100016">Annotated bibliography</option>
                    <option value="100017">Argumentative essay</option>
                    <option value="100033">Article</option>
                    <option value="100015">Article review</option>
                    <option value="100019">Biography</option>
                    <option value="100005">Book review</option>
                    <option value="100012">Business plan</option>
                    <option value="100013">Case study</option>
                    <option value="100008">Course work</option>
                    <option value="100001">Creative writing</option>
                    <option value="100018">Critical thinking</option>
                    <option value="100002" selected="">Essay</option>
                    <option value="100024">Literature review</option>
                    <option value="100006">Movie review</option>
                    <option value="100004">Presentation</option>
                    <option value="100030">Report</option>
                    <option value="100003">Research paper</option>
                    <option value="100009">Research proposal</option>
                    <option value="100007">Term paper</option>
                    <option value="100011">Thesis</option>
                    <option value="100028">Thesis proposal</option>
                    <option value="101037">Thesis statement</option>
                </optgroup>
                <optgroup label="Dissertation">
                    <option value="100010">Dissertation</option>
                    <option value="100021">Dissertation abstract</option>
                    <option value="100020">Dissertation chapter</option>
                    <option value="100027">Dissertation conclusion</option>
                    <option value="100023">Dissertation hypothesis</option>
                    <option value="100022">Dissertation introduction</option>
                    <option value="100025">Dissertation methodology</option>
                    <option value="101034">Dissertation proposal</option>
                    <option value="100026">Dissertation results</option>
                </optgroup>
                <optgroup label="Questions &amp; Problems">
                    <option value="101038">Multiple choice questions</option>
                    <option value="101039">Problem solving</option>
                </optgroup>
                <optgroup label="Admissions">
                    <option value="100014">Admission essay</option>
                    <option value="100029">Application letter</option>
                    <option value="100031">Cover letter</option>
                    <option value="100058">Curriculum vitae</option>
                    <option value="100032">Personal statement</option>
                    <option value="100059">Resume</option>
                </optgroup>
                <option value="100999">Other</option>
            </select>
        </div>
        <div class="col-xs-12 col-md-3"> <select type="text" class="form-control input-lg alternative-select">
                <option value="" selected disabled>Select academic level</option>
                <option selected>High school</option>
                <option>Undergraduate</option>
                <option>Bachelor</option>
                <option>Professional</option>
            </select>
        </div>
        <div class="col-xs-12 col-md-3"><input type="text" class="form-control input-lg alternative" placeholder="Size"></div>
        <div class="col-xs-12 col-md-3"><input type="text" class="form-control input-lg alternative" placeholder="Phone number"></div>

        <div class="col-xs-12">
            <button type="button" onclick="document.getElementById('go_price').submit();" class="btn btn-danger btn-lg col-xs-12 col-md-4 col-md-offset-4 alternative show-price-button">Show price</button>
        </div>

    </form>
</div>

<!-- Блок преимущества -->
<div class="row privilege" style="margin-top:3em;">
    <div class="col-xs-12 col-md-3 center">
        <h4><span>1.</span>EASY</h4>
        <p>All you need to do is to fill your details and contacts in a small form on a paper</p>
    </div>
    <div class="col-xs-12 col-md-3 center">
        <h4><span>2.</span>QUICKLY</h4>
        <p>We will contact you within 15 minutes after receiving your order</p>
    </div>
    <div class="col-xs-12 col-md-3 center">
        <h4><span>3.</span>COMFORTABLE</h4>
        <p>Your personal expert writer will consult you online</p>
    </div>
    <div class="col-xs-12 col-md-3 center">
        <h4><span>4.</span>HIGH QUALITY</h4>
        <p>100% authentic works, skilled authors</p>
    </div>

</div>


<!-- Блок Наши авторы -->
<div class="row author" style="margin-top:1em;">
    <div class="col-xs-12 col-md-12" style="background-color: #c3c9cc; height: 1px; margin-bottom: 1em; opacity: 0.5;"></div>
    <div class="col-xs-12 col-md-12 center"><h3>Our authors</h3></div>
    <div class="col-xs-12 col-md-6">
        <div class="row" style="margin-top:2em;">
            <div class="col-xs-12 col-md-1 col-md-offset-2"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/author-01.png"></div>
            <div class="col-xs-12 col-md-7 col-md-offset-2">
                <h5>Liza Benneth</h5>
                <span>Lecturer</span>
                <p>Department of Economics, McMaster University, Canada</p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="row" style="margin-top:2em;">
            <div class="col-xs-12 col-md-1 col-md-offset-2"><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/author-02.png"></div>
            <div class="col-xs-12 col-md-7 col-md-offset-2">
                <h5>Prof. Fr. B. Kerdner</h5>
                <span>Guest Professor</span>
                <p>University of Twente, the Netherlands</p>
            </div>
        </div>
    </div>
</div>


<!-- Блок Отзывы -->
<div class="row" style="margin-top:2em;">
    <div class="col-xs-12 col-md-12 center"><h3>Independent reviews in social networks</h3></div>
    <div class="col-xs-12 col-md-12 center" style="margin-top:2em; padding-bottom:2em;">
        <a href="http://perfect-paper.com/site/page?view=comments"><button type="button" class="btn btn-default btn-lg alternative">Reviews</button></a>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 center">
        <div class="comment">
            <p>I found the entire order process to be very easy, and your writer did his duties at a very high level of competence and helped me get an A! The deadline was really short. It was a great  pleasure working with you and your crew. Good luck to your company and thank you for saving my valuable time and nerves!</p>
        </div>
        <div class="comment-frame"></div>
        <div class="commentator-01"></div>
        <div class="comment-info">Garry<br><span>Nottingham, UK</span></div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 center">
        <div class="comment">
            <p>This company exceeded my expectations with regard to quality and timely delivery! Amazing customer service, and I can tell they really care about your success in study!
                First I hesitated about which company to go with, and now I understand that I was lucky to do the right choice !
            </p>
        </div>
        <div class="comment-frame"></div>
        <div class="commentator-02"></div>
        <div class="comment-info">J. L. Denksis<br><span>USA</span></div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 center">
        <div class="comment">
            <p>I would like to say how impressed I am at your wonderful customer service.! You wrote an amazing paper – it had exactly everything I needed. I’m extremely happy! This was the hardest paper I've had this year – you are a lifesaver. I’ll definitely use your service again in the future.
                Special thanks to support team, I appreciate the way you treat your customers! </p>
        </div>
        <div class="comment-frame"></div>
        <div class="commentator-03"></div>
        <div class="comment-info">Margaret<br><span>Cleveland</span></div>
    </div>
</div>


<!-- Блок Быстрый Заказ -->
<div class="row" style="margin-top:2em;">
    <span class="col-xs-12 col-sm-6 col-md-3 col-md-offset-1"><img class="fastorder" src="<?php echo Yii::app()->theme->baseUrl;?>/img/fastorder.png"></span>
    <div class="">
        <a href="http://perfect-paper.com/site/page?view=order"><button type="button" class="btn btn-danger btn-lg col-xs-12 col-sm-3 col-md-3 col-md-offset-1 alternative show-price-button" style="margin-bottom:5px;">To place a new inquiry</button></a>
    </div>
    <div class="">
        <a href="http://perfect-paper.com/site/page?view=order"><button type="button" class="btn btn-default btn-lg col-xs-12 col-sm-3 col-md-3 col-md-offset-1 alternative show-price-button">To order a callback</button></a>
    </div>
</div>


<!-- Блок Текст -->
<article>
    <div class="row" style="margin-top:2em;">
        <div class="col-xs-12 col-md-12" style="background-color: #c3c9cc; height: 1px;"></div>
        <div class="col-xs-12 col-md-12"><center><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/arrowbottom.png"></center></div>
        <h2 class="center">You Have Found Your Best Academic Helper</h2>
        <ul class="spec-list">
            <li>We know how hard it is to find a trustworthy solution to your academic problems.</li>
            <li>We clearly understand how much depends on your academic success.</li>
            <li>With us, you won't waste your money and efforts.</li>
            <li>We want you to feel safe, happy and self-confident.</li>
            <li>We are ready to offer you a solution that will definitely please you.</li>
        </ul>
        <p>We are talking about exclusive high-quality service that can make all your academic problems disappear. As soon as you start cooperating with us, you will enjoy a lot of free time.
            You will never want to look for any other options as our offer is really tempting. You can see for yourself what our high quality really means!</p>
        <br>
        <h2 class="center">Unprecedented Quality Of Online Writing Help</h2>
        <ul class="spec-list-2">
            <li>We run every paper through the plagiarism detection check to make sure that the customer will get an original work.</li>
            <li>Our service is available round-the-clock, which means that you can contact us and make an order 24/7/365.</li>
        </ul>
        <p>As you can see, you don't risk anything by starting cooperation with Perfect-paper. You only gain a lot and make your first step towards successful life as a professional. Besides, you learn the art of time management and get to know how to delegate your assignments to other people. These skills will be of great use for you in the future as they form the foundation of an effective and respected leader.</p>
        <p>Don't wait any longer and make the right decision – <a href="#">place an order</a> at Paperhelper and enjoy our service!</p>
    </div>
</article>

