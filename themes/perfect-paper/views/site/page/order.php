<?php
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/price.js');
$c_id = Company::getId();
$url = '/uploads/c'.$c_id.'/temp/'.$project->unixtime.'/';
$html_string = $project->generateMaterialsList($url, true);
$form=$this->beginWidget('CActiveForm',array(
    'htmlOptions'=>array('class'=>'form-horizontal'),
));
?>
<div class="panel panel-default panel-container-default" xmlns="http://www.w3.org/1999/html">
	<?php
	if ($message) {
		echo '<div class="form-message">'.$message.'</div>';
	}
	echo  $form->hiddenField($project,'unixtime');?>
    <ul class="nav nav-tabs panel-heading clearfix" id="tab-panel">
        <li class="active"><a id="top_tab-1" href="#tab-1" class="col-xs-12 text-center" data-toggle="tab">1. Paper details</a></li>
        <li><a id="top_tab-2" href="#tab-2" class="col-xs-12 text-center" data-toggle="tab">2. Price calculator</a></li>
        <?php if(!$logged) { ?><li><a id="top_tab-3" href="#tab-3" class="col-xs-12 text-center" data-toggle="tab">3. Contact information</a></li><?php } ?>
    </ul>
    <div class="tab-content">
        <div class="panel-body form-container tab-pane active" id="tab-1">
            <div class="form-group">
                <label for="type_of_paper" class="col-sm-3 control-label">Type of paper:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="Please select the most suitable type of paper needed. This will help the writer follow your exact instructions. If the type of paper is not on the list, please choose the option “Other”."></a>
                </label>
                <div class="col-sm-9">
                    <select id="type_of_paper" name="Project[Typeofpaper]" class="form-control">
                        <optgroup label="Essays">
                            <option value="8">Annotated bibliography</option>
                            <option value="9">Argumentative essay</option>
                            <option value="10">Article</option>
                            <option value="11">Article review</option>
                            <option value="12">Biography</option>
                            <option value="13">Book review</option>
                            <option value="14">Business plan</option>
                            <option value="15">Case study</option>
                            <option value="16">Course work</option>
                            <option value="17">Creative writing</option>
                            <option value="18">Critical thinking</option>
                            <option value="19" selected="">Essay</option>
                            <option value="20">Literature review</option>
                            <option value="21">Movie review</option>
                            <option value="22">Presentation</option>
                            <option value="23">Report</option>
                            <option value="24">Research paper</option>
                            <option value="25">Research proposal</option>
                            <option value="26">Term paper</option>
                            <option value="27">Thesis</option>
                            <option value="28">Thesis proposal</option>
                            <option value="29">Thesis statement</option>
                        </optgroup>
                        <optgroup label="Dissertation">
                            <option value="31">Dissertation</option>
                            <option value="32">Dissertation abstract</option>
                            <option value="33">Dissertation chapter</option>
                            <option value="34">Dissertation conclusion</option>
                            <option value="35">Dissertation hypothesis</option>
                            <option value="36">Dissertation introduction</option>
                            <option value="37">Dissertation methodology</option>
                            <option value="38">Dissertation proposal</option>
                            <option value="39">Dissertation results</option>
                        </optgroup>
                        <optgroup label="Questions &amp; Problems">
                            <option value="41">Multiple choice questions</option>
                            <option value="42">Problem solving</option>
                        </optgroup>
                        <optgroup label="Admissions">
                            <option value="44">Admission essay</option>
                            <option value="45">Application letter</option>
                            <option value="46">Cover letter</option>
                            <option value="47">Curriculum vitae</option>
                            <option value="48">Personal statement</option>
                            <option value="49">Resume</option>
                        </optgroup>
                        <option value="51">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="subject" class="col-sm-3 control-label">Subject:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="If your subject is not on the list, please select the option “Other” and specify your subject in the “Paper details” field. This is needed to make sure that we have specialists to help you with your assignment."></a>
                </label>
                <div class="col-sm-9">
                    <select name="Project[specials]" id="subject" class="form-control">
                        <option value="">Choose...</option>
                        <option value="53">Accounting</option>
                        <option value="54">Anthropology</option>
                        <option value="55">Art &amp; architecture</option>
                        <option value="56">Astronomy</option>
                        <option value="57">Biology</option>
                        <option value="58">Business</option>
                        <option value="59">Chemistry</option>
                        <option value="60">Classic English literature</option>
                        <option value="61">Communication</option>
                        <option value="62">Criminal Law</option>
                        <option value="63">Culture</option>
                        <option value="64">Economics</option>
                        <option value="65">Ecology</option>
                        <option value="66">Education</option>
                        <option value="67">Engineering</option>
                        <option value="68">English</option>
                        <option value="69">Environmental studies</option>
                        <option value="70">Family and consumer science</option>
                        <option value="71">Film studies</option>
                        <option value="72">Finance</option>
                        <option value="73">Geology</option>
                        <option value="74">Geography</option>
                        <option value="75">History</option>
                        <option value="76">Human Resource Management</option>
                        <option value="77">Investments</option>
                        <option value="78">Journalism</option>
                        <option value="79">Law</option>
                        <option value="80">Literature</option>
                        <option value="81">Management</option>
                        <option value="82">Marketing</option>
                        <option value="83">Mathematics</option>
                        <option value="84">Medicine</option>
                        <option value="85">Music</option>
                        <option value="86">Nursing</option>
                        <option value="87">Philosophy</option>
                        <option value="88">Physics</option>
                        <option value="89">Political science</option>
                        <option value="90">Poetry</option>
                        <option value="91">Psychology</option>
                        <option value="92">Religious studies</option>
                        <option value="93">Shakespeare studies</option>
                        <option value="94">Sociology</option>
                        <option value="95">Technology</option>
                        <option value="96">Theater studies</option>
                        <option value="97">Tourism</option>
                        <option value="98">Women and gender studies</option>
                        <option value="99">World affairs</option>
                        <option value="100">World literature</option>
                        <option value="101">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Paper format:
                    &nbsp;&nbsp;&nbsp;<!--<a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>-->
                </label>

                <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[Paperformat]" id="Project[paperformat]_MLA" value="102">MLA
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[Paperformat]" id="Project[paperformat]_APA" value="103">APA
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[Paperformat]" id="Project[paperformat]_Chicago" value="104">Chicago / Turabian
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[Paperformat]" id="Project[paperformat]_Harvard" value="105">Harvard
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[Paperformat]" id="Project[paperformat]_Other" value="106">Other
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="checkbox">
                        <label>
                            <input name="Project[abstractpage]" type="checkbox" value="1"> Add an Abstract page to my paper
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="sources" class="col-sm-3 control-label">Sources:
                    &nbsp;&nbsp;&nbsp;<!--<a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>-->
                </label>
                <div class="col-sm-9">
                    <div class="input-group spinner">
                        <button class="btn btn-primary pull-left" type="button">-</button>
                        <input name="Project[Sources]" id="sources" type="text" class="form-control pull-left" value="1">
                        <button class="btn btn-primary pull-left" type="button">+</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="topic" class="col-sm-3 control-label">Topic:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="If you have a topic, please make it clear and concise. Otherwise, leave “Writer’s choice”."></a>
                </label>
                <div class="col-sm-9">
                    <input id="topic" name="Project[title]" type="text" class="form-control" placeholder="Writer's choice">
                </div>
            </div>
            <div class="form-group">
                <label for="paper_details" class="col-sm-3 control-label">Paper details:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="Please make sure to leave a detailed description of your requirements, to decrease chances of revision in you oreder."></a>
                </label>
                <div class="col-sm-9">
                    <textarea name="Project[Paperdetails]" id="paper_details" class="form-control" rows="4"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Additional Materials:
                    &nbsp;&nbsp;&nbsp;<!--<a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>-->
                </label>
                <div class="col-sm-9">
                    <?php
					$this->widget('ext.EAjaxUpload.EAjaxUpload',
                        array(
                            'id' => 'justFileUpload',
                            'config' => array(
                                'action' => $this->createUrl('/project/zakaz/upload', array('unixtime' => $project->unixtime)),
                                'template' => '<div class="qq-uploader"><div class="qq-upload-drop-area"><span>'. ProjectModule::t('Drag and drop files here') .'</span><div class="qq-upload-button">'. ProjectModule::t('Attach materials to the order') .'</div><ul class="qq-upload-list">'.$html_string.'</ul></div></div>',
                                'disAllowedExtensions' => array('exe','scr'),
                                'sizeLimit' => 200 * 1024 * 1024,// maximum file size in bytes
                                'minSizeLimit' => 1,// minimum file size in bytes
                                'onComplete' => "js:function(id, fileName, responseJSON){}"
                            )
                        )
                    ); ?>
				</div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <p>Please upload your additional materials not later than in 2 hours. Mind that we will not
                        start working on your order until you provide us with the required information/files</p>

                    <p>Please provide the names of required sources in Paper Details. Also note that research into
                        absent sources may require additional time, which may slightly extend the deadline.</p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 order-price-block">
                    <span>Approximate price:</span><strong id="appr_price_step2" class="appr_price">$9.97</strong>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button id="click_to_tab" data-tab="2" class="btn btn-danger pull-right">GO to Step 2</button>
                </div>
            </div>
        </div>
        <div class="panel-body form-container tab-pane" id="tab-2">
            <div class="form-group">
                <label class="col-sm-3 control-label">Type of service:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                </label>
                <div class="col-sm-9">
                    <div id="tos" class="btn-group calc_elem" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="Project[Typeofservice]" id="wr_from_scratch" data-val="1" value="110" checked>Writing from scratch
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[Typeofservice]" id="edit_proof" data-val="2" value="111">Editing/proofreading
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Academic Level:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="Make sure to select an appropriate academic level which corresponds to your level of writing."></a>
                </label>
                <div class="col-sm-9">
                    <div id="academ_level" class="btn-group calc_elem" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="Project[AcademicLevel]" id="High_school" value="112" checked>High school
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[AcademicLevel]" id="Undergraduate" value="113">Undergraduate
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[AcademicLevel]" id="Bachelor" value="114">Bachelor
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[AcademicLevel]" id="Professional" value="115">Professional
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="Project[VIPcustomer]" value="1"> I want to order VIP customer service
                            <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="pages_number" class="col-sm-3 control-label">Number of pages:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                </label>
                <div class="col-sm-3">
                    <div class="input-group spinner">
                        <button class="btn btn-primary pull-left calc_elem" type="button">-</button>
                        <input id="pages_number" name="Project[Numberofpages]" type="text" class="form-control pull-left calc_elem" value="1">
                        <button class="btn btn-primary pull-left calc_elem" type="button">+</button>
                    </div>
                </div>
                <label for="slides_number" class="col-sm-3 control-label">Number of slides:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                </label>
                <div class="col-sm-3">
                    <div class="input-group spinner">
                        <button class="btn btn-primary pull-left calc_elem" type="button">-</button>
                        <input id="slides_number" name="Project[Numberofslides]" type="text" class="form-control pull-left calc_elem" value="0">
                        <button class="btn btn-primary pull-left calc_elem" type="button">+</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-4">
                    <div id="spaced" class="btn-group calc_elem" data-toggle="buttons">
                        <label class="btn btn-primary">
                            <input type="radio" class="calc_elem" name="Project[spaced]" data-val="1.7" value="135">Single Spaced
                        </label>
                        <label class="btn btn-primary active">
                            <input type="radio" class="calc_elem" name="Project[spaced]" data-val="1" value="136" checked>Double Spaced
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <p class="bg-info">1 double spaced page = 275 words,<br/>1 single spaced page = 470 words</p></div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">First Draft Deadline:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                </label>
                    <div id="hours" class="col-sm-7 btn-group calc_elem" data-toggle="buttons">
                        <label class="btn btn-primary btn-deadline active">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="threeHours" value="116" checked>3
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="sixHours" value="117">6
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="twelveHours" value="118">12
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="oneDay" value="119">24
                        </label>
                        <div class="col-sm-1"></div>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="twoDays" value="120">2
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="threeDays" value="121">3
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="fourDays" value="122">4
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="fiveDays" value="123">5
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="sevenDays" value="124">7
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="tenDays" value="125">10
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="twentyDays" value="126">20
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="thirtyDays" value="127">30
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[FirstDraftDeadline]" id="twoMonths" value="128">60
                        </label>
                    </div>
                <div class="col-sm-offset-3 col-sm-3">Hours</div>
                <div class="col-sm-6">Days</div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    The deadline for the first draft is <strong>25 Jun 12 AM</strong>.
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                </div>
                <div class="col-sm-offset-3 col-sm-9">
                    We estimate that your final submission deadline is <strong>26 Jun 07 PM</strong>.
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Preferred writer:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                </label>
                <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary" style="padding: 16px 15px !important;">
                            <input type="radio" name="Project[Preferredwriter]" id="option17" value="129">Regular writer
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[Preferredwriter]" id="option18" value="130">Advanced regular<br>writer
                        </label>
                        <label class="btn btn-primary" style="padding: 16px 15px !important;">
                            <input type="radio" name="Project[Preferredwriter]" id="option19" value="131">My previous writer
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="Project[Preferredwriter]" id="option20" value="132">TOP writer:<br>Fullfiled by top 10 writers
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <a href="#">Have a discount?</a> (optional)
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                </div>
            </div>
            <!--<div class="form-group">
                <label class="col-sm-3 control-label">Preferred payment system:
                    <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                </label>
                <div class="col-sm-9">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[Preferredpaymentsystem]" id="option21" value="133">Credit card
                        </label>
                        <label class="btn btn-primary btn-deadline">
                            <input type="radio" name="Project[Preferredpaymentsystem]" id="option22" value="134">PayPal
                        </label>
                    </div>
                </div>
            </div>-->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <p class="bg-info" style="padding: 15px;">Please note that overseas transactions from the territory of the European Union might include additional charges, stipulated by your Government. They will be reflected on the payment page and your bank statement. <strong>PaperHelper.com</strong> does not have the authority to fix or scale down the VAT or any other fees.</p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 order-price-block">
                    <span>Total price:</span><strong id="appr_price_step3" class="appr_price">$17.97</strong>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <a href="#tab-1" id="click_to_tab" data-tab="1"><strong><</strong> Back to Step 1</button></a>
                </div>
				<?php if($logged) { ?>
				<div class="col-sm-6">
					<button id="secure_pay" class="btn btn-danger pull-right">Proceed to Secure Payment</button>
				</div>
				<?php } else { ?>
                <div class="col-sm-6">
                    <button id="click_to_tab"  data-tab="3" class="btn btn-danger pull-right">Go to Step 3</button>
                </div>
				<?php } ?>
            </div>
        </div>
        <div class="panel-body form-container tab-pane" id="tab-3">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#new" data-toggle="tab">I am new here</a></li>
                <li><a href="#sign-in" data-toggle="tab">Sign in</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane form-container active" id="new">
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email:</label>
                        <div class="col-sm-9">
                            <input id="email" name="User[email]" type="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_email" class="col-sm-3 control-label">Confirm email:</label>
                        <div class="col-sm-9">
                            <input id="confirm_email" type="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="col-sm-3 control-label">First Name:</label>
                        <div class="col-sm-9">
                            <input id="first_name" name="User[first_name]" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-sm-3 control-label">Last name:</label>
                        <div class="col-sm-9">
                            <input id="last_name" name="User[last_name]" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pass" class="col-sm-3 control-label">Password:
                            <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                        </label>
                        <div class="col-sm-9">
                            <input id="pass" name="User[password]" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_pass" class="col-sm-3 control-label">Confirm password:</label>
                        <div class="col-sm-9">
                            <input id="confirm_pass" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country" class="col-sm-3 control-label">Country:</label>
                        <div id="countryDiv" class="col-sm-9">
                            <select id="country" name="Profile[country]" class="form-control" onchange="changeCountryCode();">
								<?php
									foreach($countryCodes as $country => $code){
										echo "<option data-val=\"$code\">$country</option>\n";
									}
								?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cellphone" class="col-sm-3 control-label">Cell phone:
                            <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                        </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                            <span class="input-group-addon" id="countryCode">
                                +254
                            </span>
                                <input id="cellphone" name="User[phone_number]" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <!--<i class="clearfix">
                                By proceeding to the next step, you are accepting our <a href="#">Terms of Use</a>, <a href="#">Privacy Policy</a> and <a href="#">Money Back Guarantee</a>.
                            </i>
                            <i class="clearfix">
                                By proceeding to the next step, you express your prior affirmative consent to receive emails and sms from us.
                            </i>-->
                        </div>
                    </div>
                </div>
                <div class="tab-pane form-container" id="sign-in">
                    <div class="form-group">
                        <label for="Login[username]" class="col-sm-3 control-label">Email:
                            <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                        </label>

                        <div class="col-sm-9">
                            <input id="have_email" name="Login[username]" type="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Login[password]" name="have_password" class="col-sm-3 control-label">Password:
                            <a class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="In developing..."></a>
                        </label>
                        <div class="col-sm-9">
                            <input id="have_password" name="Login[password]" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <!--<i class="clearfix">
                                By proceeding to the next step, you are accepting our <a href="#">Terms of Use</a>, <a href="#">Privacy Policy</a> and <a href="#">Money Back Guarantee</a>.
                            </i>
                            <i class="clearfix">
                                By proceeding to the next step, you express your prior affirmative consent to receive emails and sms from us.
                            </i>-->
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <a href="#tab-2" id="click_to_tab" data-tab="2"><strong><</strong> Back to Step 2</button></a>
                    </div>
                    <div class="col-sm-12">
                        <button id="secure_pay" class="btn btn-danger pull-right">Proceed to Secure Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->endWidget();
?>
<script type="text/javascript">
    (function ($) {
        var sin=$('.spinner input');
        $('.spinner .btn:first-of-type').on('click', function() {
            var button=$(this);
            var inp=button.parent().find('input');
			var newVal = parseInt(inp.val(), 10) - 1;
			if (newVal < 0 ) newVal = 0;
            inp.val(newVal);
        });
        $('.spinner .btn:last-of-type').on('click', function() {
            var button=$(this);
            var inp=button.parent().find('input');
            inp.val( parseInt(inp.val(), 10) + 1);
        });
    })(jQuery);

    $('form').on('click','#click_to_tab',function(){
        $('#tab-panel a[href="#tab-'+$(this).data('tab')+'"]').tab('show');
        return false;
    });
    $('a[data-toggle="tab"]').on('hide.bs.tab', function (e) {
        //console.log(e);
        //e.target; // activated tab
        //e.relatedTarget.active(); // previous tab
        //e.preventDefault();
        return true;
    });
</script>

