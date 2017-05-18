<?php

/**
 * поведение для сохранения изменений полей с выбором времени
 */
class TimepickBehavior extends CActiveRecordBehavior
{
    protected $dateTimeIncomeFormat = 'yyyy-MM-dd HH:mm:ss';
    protected $dateTimeOutcomeFormat = 'dd.MM.yyyy HH:mm';
    protected $dateIncomeFormat = 'yyyy-MM-dd HH:mm:ss';
    protected $dateOutcomeFormat = 'dd.MM.yyyy';

	protected function getTimestamp($varname) {
	    if ($this->Owner->$varname != '') {
            if ($this->Owner->$varname == '0000-00-00 00:00:00') return '';
            if (strlen($this->Owner->$varname) == 19) return Yii::app()->dateFormatter->format($this->dateTimeOutcomeFormat, CDateTimeParser::parse($this->Owner->$varname, $this->dateTimeIncomeFormat));
            elseif (strlen($this->Owner->$varname) == 10) return Yii::app()->dateFormatter->format($this->dateOutcomeFormat, CDateTimeParser::parse($this->Owner->$varname, $this->dateTimeIncomeFormat));
        }
	}
	
	protected function setTimestamp($varname, $datetime) {
		if ($datetime != ''){
            if (strlen($datetime) == 16) $this->Owner->$varname = Yii::app()->dateFormatter->format($this->dateTimeIncomeFormat, CDateTimeParser::parse($datetime, $this->dateTimeOutcomeFormat));
            elseif (strlen($datetime) == 10) $this->Owner->$varname = Yii::app()->dateFormatter->format($this->dateTimeIncomeFormat, CDateTimeParser::parse($datetime, $this->dateOutcomeFormat));
        }
	}
}