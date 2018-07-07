<?php
/*
 * @property integer $id
 * @property string $to
 * @property string $subject
 * @property string  $body
 * @property integer $type
 * @property integer $dt
 */

use PHPMailer\PHPMailer\PHPMailer;

class Emails extends CActiveRecord {

	// типы уведомлений (системных сообщений)

	const TYPE_10=10; // Восстановление пароля
	const TYPE_11=11; // +Заказчику после регистрации.
	const TYPE_12=12; // +Заказчику проект принят
	const TYPE_13=13; // +Заказчику об оплате когда выставлен счет
	const TYPE_14=14; // +Заказчику когда готова часть
	const TYPE_15=15; // +Заказчику когда готова вся работа.
	const TYPE_16=16; // Заказчику о сообщении в чате
	const TYPE_17=17; // +Заказчику о завершении заказа
	const TYPE_18=18; // +Исполнителю сообщение рассылки
	const TYPE_19=19; // +Исполнителю о назначении
	const TYPE_20=20; // Исполнителю о сообщении в чате
	const TYPE_21=21; // +Исполнителю о съеме с заказа
	const TYPE_22=22; // Исполнителю о том что срок сдачи части наступил
	const TYPE_23=23; // +Исполнителю о новой доработке
	const TYPE_24=24; // +Исполнителю об оплате заказа
	//const TYPE_25=25; // Заказчику о поступлении оплаты
	const TYPE_26=26; // +Техническому руководителю сообщение рассылки
	
	public static $names_of_email = array(
		self::TYPE_10 =>'Восстановление пароля',
		self::TYPE_11 =>'Заказчику после регистрации',
		self::TYPE_12 =>'Заказчику проект принят',
		self::TYPE_13 =>'Заказчику об оплате когда выставлен счет',
		self::TYPE_14 =>'Заказчику когда готова часть',
		self::TYPE_15 =>'Заказчику когда готова вся работа',
		self::TYPE_16 =>'Заказчику о сообщении в чате',
		self::TYPE_17 =>'Заказчику о завершении заказа',
		self::TYPE_18 =>'Исполнителю сообщение рассылки',
		self::TYPE_19 =>'Исполнителю о назначении',
		self::TYPE_20 =>'Исполнителю о сообщении в чате',
		self::TYPE_21 =>'Исполнителю о съеме с заказа',
		self::TYPE_22 =>'Исполнителю о том что срок сдачи части наступил',
		self::TYPE_23 =>'Исполнителю о новой доработке',
		self::TYPE_24 =>'Исполнителю об оплате заказа',
		//self::TYPE_25 =>'Заказчику о поступлении оплаты',
		self::TYPE_26 =>'Техническому руководителю сообщение рассылки',
	);

	// эти переменные будут использоваться для подстановок в
	// телах писем с системными сообщениями.
	public 	$site;
	public 	$page_psw;
	public 	$support;
	public 	$campaign; //4rm
	public 	$company;
	public 	$name;
	public 	$login;
	public 	$password;
	public 	$page_cabinet;
	public 	$page_order;
	public 	$name_order;
	public 	$num_order;
	public 	$subject_order;
	public 	$price_order;
	public 	$price_order_part;
	public 	$sum_order;
	public 	$message;
	public 	$page_payment;
	public 	$specialization;
	public 	$name_part;
//	public 	$neworder;
	
	public 	$from_id;
	public 	$to_id;

	private $_PHPMailer;
	
	public function tableName() {
		return Company::getId().'_Emails';
	}
    
    public function rules() {
        return array(
            array('to,subject,body,type,dt', 'required'),
            array('id,to,subject,body,type,dt', 'safe'),
        );
    }
    
    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
	
	public function sending_round($limit=100) {
		$this->getDbCriteria()->mergeWith(array(
			'order'=>'id ASC',
			'limit'=>$limit,
		));
		return $this;
	}
        
    public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			//'from' => Yii::t('site','From'),
			'to' => Yii::t('site','To'),
            'subject' => Yii::t('site','Subject'),
			'body' => Yii::t('site','Body'),
			'type' => Yii::t('site','Type'),
			'dt' => Yii::t('site','Date'),
		);
	}
    public function init(){
        parent::init();
		if (array_key_exists('SERVER_NAME', $_SERVER ) ) {
			$this->site				= 'http://'.$_SERVER['SERVER_NAME'].'/';
		}
		$this->page_psw			= '';
		$this->support			= Company::getSupportEmail();
		$this->campaign			= Company::getName();
		$this->company			= Company::getName();
		$this->name				= '';
		$this->login			= '';
		$this->password			= '';
		$this->page_cabinet		= '';
		$this->page_order		= '';
		$this->name_order		= '';
		$this->num_order		= '';
		$this->subject_order	= '';
		$this->price_order		= '';
		$this->price_order_part = '';
		$this->sum_order		= '';
		$this->message			= '';
		$this->page_payment		= '';
		$this->specialization	= '';
		$this->name_part		= '';
    }
		
    public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('to',$this->to,true);
        $criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('dt',$this->dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	private function getPHPMailer()
    {
        if (!isset($this->_PHPMailer)) {
            $mailer = new PHPMailer();
            $mailer->CharSet = 'UTF-8';
            $mailer->isSMTP();
            $mailer->SMTPAuth = true;
            $mailer->isHTML(true);
            $this->_PHPMailer = $mailer;
        }
        return $this->_PHPMailer;
    }

    private function sendByPHPMailer()
    {
        $mailer = $this->getPHPMailer();
        $server = SmtpServer::getActual();
        if (isset($server)) {
            $mailer->Host = $server->address;
            $mailer->Port = $server->port;
            $mailer->Username = $server->login;
            $mailer->Password = $server->password;
            if ($server->secure)
                $mailer->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            else
                $mailer->SMTPSecure = '';

            $mailer->setFrom($server->login, Company::getName());
            $mailer->addAddress($this->to);
            $mailer->Subject = $this->subject;
            $mailer->Body    = $this->body;
            $result =  $mailer->send();
            $server->increaseCounter();
            return $result;
        } else return false;
    }

	public function send()
    {
        if (isset(Yii::app()->params['use_smtp']) && Yii::app()->params['use_smtp']) {
            $this->sendByPHPMailer();
        } else {
            $subject = '=?UTF-8?B?' . base64_encode($this->subject) . '?=';
            $support = Company::getSupportEmail();
            if (strlen($support) < 2) $support = 'no-reply@admintrix.com';
            $from = '=?UTF-8?B?' . base64_encode(Company::getName()) . '?= <' . $support . '>';
            $headers =
                "MIME-Version: 1.0\r\n" .
                "Content-Type: text/html; charset=UTF-8\r\n" .
                "From: $from\r\n";
            return mail($this->to, $subject, $this->body, $headers);
        }
	}
	
    public function sendTo($to, $subject, $body, $type_id = 0, $deffer = false)
	{
		$dictionary = array(
            '%site%',
            '%the link to the password change page%',
            '%support%',
            '%company%',
            '%name%',
            '%Name%',
            '%login%',
            '%password%',
            '%the link to the personal account page%',
            '%Order link%',
            '%order link%',
            '%Job title%',
            '%order no%',
            '%the order number%',
            '%Job title%',
            '%job title%',
            '%Title%',
            '%title%',
            '%from the cost field%',
            '%the amount of charged%',
            '%the amount to be paid%',
            '%message body%',
            '%the link to the payment page%',
            '%specialization%',
            '%the name of the stage%',
            '%new order%',
/*		
			'%сайт%',
			'%ссылка на страницу изменения пароля%',
			'%support%',
			'%компания%',
			'%имя%',
			'%Имя%',
			'%login%',
			'%password%',
			'%ссылка на страницу личного кабинета%',
			'%Ссылка на заказ%',
			'%ссылка на заказ%',
			'%название работы%',
			'%№ заказа%',
			'%номер заказа%',
			'%тема работы%',
			'%тема заказа%',
			'%Наименование%',
			'%наименование%',
			'%из поля стоимость%',
			'%сумма из выставлено к оплате%',
			'%сумма к оплате%',
			'%текст сообщения%',
			'%ссылка на страницу оплаты%',
			'%специальность%',
			'%название части%',
			'%новый заказ%',
*/			
		);

		if($type_id==1 || ($type_id>10 && $type_id<18)) $this->page_order = $this->page_order.'&authmeneger=Customer';
		if($type_id==2 || ($type_id>17 && $type_id<25)) $this->page_order = $this->page_order.'&authmeneger=Author';
		
		$subst = array(
			$this->site,
			$this->page_psw,
			$this->support,
			$this->campaign,
			$this->name,
			$this->name,
			$this->login,
			$this->password,
			$this->page_cabinet,
			$this->page_order,
			$this->page_order,
			$this->name_order,
			$this->num_order,
			$this->num_order,
			$this->subject_order,
			$this->subject_order,
			$this->subject_order,
			$this->subject_order,
			$this->price_order,
			$this->price_order,//_part,
			$this->sum_order,
			$this->message,
			$this->page_payment,
			$this->specialization,
			$this->name_part,
//			$this->neworder,
		);
		// собственно, замены
		foreach($dictionary as $key=>$fraze) {
			$translate = Yii::t('site',$fraze);
//echo '<br>$fraze(0)='.$fraze.' $translate(0)='.$translate; 
			if (strpos( $subject, $translate)) {
				$subject = str_replace( $translate, $subst[$key], $subject);
//echo '<br>subject: '.$fraze.'-->'.$translate; 
			};	
			if (strpos( $body, $translate)) {
				$body = str_replace( $translate, $subst[$key], $body);
//echo '<br>body: '.$fraze.'-->'.$translate; 
			};	
		}	
//		if (isset($_POST['debug'])) {
//echo '<br>$subject(1)='.$subject; 
//echo '<br>$body(1)='.$body; 
//		};
		$body = str_replace( "\n", "<br>\n", $body);
		
		$this->to = $to;
		$this->subject = $subject;
		$this->body = $body;
		$this->type = $type_id;
		$this->dt = time();
		
		if($deffer)
			$this->save();
		else
			$this->send();
	}			
}
