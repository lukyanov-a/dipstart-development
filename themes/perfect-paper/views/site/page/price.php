<?php
//Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/mmenu/src/js/jquery.mmenu.oncanvas.js',CClientScript::POS_END);
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/price-simple.js',CClientScript::POS_END);
Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/price.css');
?>
    <div class="wrapper mbody">
		  <div class="item-page">

  <p style="margin:0;"><div class="moduletable main-calc">
    
    <div class="calc">
		      <h2>Price calculator</h2>
		      <hr>
		      <p>Find out how much your order will cost.</p>
              <div class="item">
                  <p>1. Select Academic Level</p>
                  <button onclick="selectAcademicLevel('High_school')">H. School</button>
                  <button onclick="selectAcademicLevel('Undergraduate')">Undergrad</button>
                  <button onclick="selectAcademicLevel('Bachelor')">Master</button>
                  <button onclick="selectAcademicLevel('Professional')">Doctoral</button>
              </div>
              <div class="item">
                  <p>2. Select Undergrad Deadline</p>
				  <select id="hsduedate" name="hsduedate" onchange="calculateTotalHs()">
					  <option value="selectDays">Select Days</option>
					  <option value="twoMonths">60 Days</option>
					  <option value="thirtyDays">30 Days</option>
					  <option value="twentyDays">20 Days</option>
					  <option value="tenDays">10 Days</option>
					  <option value="sevenDays">7 Days</option>
					  <option value="fiveDays">5 Days</option>
					  <option value="fourDays">4 Days</option>
					  <option value="threeDays">3 Days</option>
					  <option value="twoDays">2 Days</option>
					  <option value="oneDay">1 Day</option>
					  <option value="twelveHours">12 Hours</option>
					  <option value="eightHours">8 Hours</option>
					  <option value="sixHours">6 Hours</option>
					  <option value="threeHours">3 Hours</option>
				 </select>
              </div>
              <div class="item">
                  <p>3. Number of pages</p>
		            <div class="col-sm-9">
                        <div class="input-group spinner">
							<button class="btn btn-primary pull-left" type="button" onclick="minus()">-</button>
                            <input name="sources" id="sources" type="text" class="form-control pull-left" value="1" onchange="calculateTotalHs()">
                            <button class="btn btn-primary pull-left" type="button" onclick="plus()">+</button>
                        </div>
                    </div>
              </div>
              <p class="submit-cost">Approximate cost: <span id="price">0</span></p>
              <button onclick="window.location.href = 'http://perfect-paper.com/site/page?view=order';">Proceed to Order</button>
    </div>
	</p>
	</div></div>
					
		<div class="clear"></div>
	<div class="clear" style="height: 0;"></div>
