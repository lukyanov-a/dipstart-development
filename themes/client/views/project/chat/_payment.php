<?php
if (User::model()->isCustomer()) {
	$to_recive = ProjectPayments::model()->findByAttributes(array('order_id'=>$order->id))->to_receive;
	if ($to_recive>0) {
		if(Company::getPaymentCash()==1) {
			echo '<div class="col-xs-12 block-for-upload-chek">';
			?>
			<div class="to-pay">
				<span class="text-to-pay"><?=ProjectModule::t('To pay:')?><span> <span class="value-to-pay"><? echo $to_recive; ?></span><!--<span class="rub">&#8381;</span>-->
			</div>
			<?php
			$check_list = '';
			if (count($images) > 0) {
				echo '<div class="chek-is-approving">'.ProjectModule::t('Your payment at checkout ...').'</div>';
				$i = 1;
				foreach ($images as $item) {
					$link = CHtml::link(ProjectModule::t('Check').' ' . $i++, PaymentImage::getFolder() . $item->image, array ('target' => '_blank' )) . ' ';
					$check_list .= '<li>'.$link.'</li>';
				}
			}
			$this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
					'id' => 'paymentImageUploader',
					'postParams' => array(
						'id' => $order->id,
					),
					'config' => array(
						'action' => $this->createUrl('zakaz/uploadPayment', array('id' => $order->id)),
						'template' => '<div class="qq-uploader"><div class="qq-upload-drop-area"><span>'. ProjectModule::t('Drag and drop files here') .'</span><div class="qq-upload-button">'. ProjectModule::t('Upload check scan') .'</div><ul class="qq-upload-list">'.$check_list.'</ul></div></div>',
						'disAllowedExtensions' => array('exe'),
						'sizeLimit' => 10 * 1024 * 1024,// maximum file size in bytes
						'minSizeLimit' => 10,// minimum file size in bytes
						'onComplete' => "js:function(id, fileName, responseJSON){}"
					)
				)
			);
			echo '</div>';
		}
		
		if(Company::getPayment2Chekout()!=0) {
			$user = User::model()->with('profile')->findByPk($order->user_id);
		// 2Checkout form
		?>
		<div class="to-pay">
			<span class="text-to-pay"><?=ProjectModule::t('To pay')?><span> <span class="value-to-pay"><? echo $to_recive; ?></span> <!--<span class="rub">&#8381;</span>-->
		</div>
		<!--<form action='https://sandbox.2checkout.com/checkout/purchase' method='post'>-->
		<form action='https://2checkout.com/checkout/purchase' method='post'>
		  <input type='hidden' name='sid' value='<?php echo Campaign::getPayment2Chekout(); ?>' />
		  <input type='hidden' name='mode' value='2CO' />
		  <input type='hidden' name='li_0_type' value='product' />
		  <input type='hidden' name='li_0_name' value='order<?=$order->id; ?>' />
		  <input type='hidden' name='li_0_price' value='<?=$to_recive; ?>' />
		  <input type='hidden' name='li_0_product_id' value='<?=$order->id; ?>' />
		  <input type='hidden' name='x_receipt_link_url' value=<?='http://'.$_SERVER["HTTP_HOST"].'/project/payment/affiliatePayment'; ?> />

		  <input type='hidden' name='card_holder_name' value='<?=$user->full_name; ?>' />
		  <input type='hidden' name='country' value='<?=$user->profile->country; ?>' />
		  <input type='hidden' name='email' value='<?=$user->email; ?>' />
		  <input type='hidden' name='phone' value='<?=$user->phone_number; ?>' />
		  <!--<input type='hidden' name='card_holder_name' value='Checkout Shopper' />
		  <input type='hidden' name='street_address' value='123 Test Address' />
		  <input type='hidden' name='street_address2' value='Suite 200' />
		  <input type='hidden' name='city' value='Columbus' />
		  <input type='hidden' name='state' value='OH' />
		  <input type='hidden' name='zip' value='43228' />
		  <input type='hidden' name='country' value='USA' />
		  <input type='hidden' name='email' value='example@2co.com' />
		  <input type='hidden' name='phone' value='614-921-2450' />-->
		  
		  <input name='submit' type='submit' value='<?=ProjectModule::t('Pay online')?>' />
		</form>
		<?php
		}
		echo '<hr>';
	}
}