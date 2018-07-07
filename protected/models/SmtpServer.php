<?php
/**
 * This is the model class for table "SmtpServers".
 *
 * The followings are the available columns in table '*_SmtpServers':
 * @property integer $id       уникальный идентификатор
 * @property string  $address  адрес
 * @property integer $port     порт
 * @property boolean $secure   шифрование
 * @property string  $login    логин
 * @property string  $password пароль
 * @property integer $limit    писем в час
 * @property integer $start    начало текущего диапозона
 * @property integer $counter  писем отправлено
 */

class SmtpServer extends CActiveRecord
{
    /* @var SmtpServer */
    private static $_actual;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return Company::getId().'_SmtpServers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['address, port, login, password, limit', 'required'],
            ['port, limit', 'numerical', 'integerOnly' => true],
            ['secure', 'boolean'],
            ['address, login, password', 'length', 'max' => 255],
            ['port', 'default', 'setOnEmpty' => true, 'value' => 25],
            // The following rule is used by search().
            ['id, address, port, secure, login, limit', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('site','ID'),
            'address' => Yii::t('site','Address'),
            'port' => Yii::t('site', 'Port'),
            'secure' => Yii::t('site', 'Encryption'),
            'login' => Yii::t('site', 'Username'),
            'password' => Yii::t('site', 'Password'),
            'limit' => Yii::t('site', 'Letters per hour'),
            'start' => Yii::t('site', 'Start of current range'),
            'counter' => Yii::t('site', 'Letters sent'),
        );
    }

    /**
     * @param string $type
     * @param mixed|null $code
     * @return string formatted value
     */
    public static function itemAlias($type, $code = null) {
        $_items = [
            'secure' => [
                0 => Yii::t('site','off'),
                1 => Yii::t('site','on'),
            ],
        ];
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical use case:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('address', $this->address,true);
        $criteria->compare('port', $this->port);
        $criteria->compare('secure', $this->secure);
        $criteria->compare('login', $this->login,true);
        $criteria->compare('limit', $this->limit);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SmtpServer the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return null|SmtpServer
     */
    public static function getActual()
    {
        $model = self::$_actual;
        if (isset($model) && $model->counter < $model->limit)
            return $model;
        else
            return self::$_actual = self::model()->find('start + INTERVAL 1 HOUR < NOW() OR counter < `limit`');
    }
}