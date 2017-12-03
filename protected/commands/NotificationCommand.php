<?php

class NotificationCommand extends CConsoleCommand {
    public $date;
    
    public function run($args)
    {
        $this->date = time();
        //$this->date = strtotime("29.11.2017 17:29:00");
        $companies = Company::model()->findAll();
        foreach ($companies as $company) {
            Company::setActive($company);
            $adminsSetting = ProfileSetting::model()->findAll();
            
            foreach ($adminsSetting as $adminSetting) {
                if($adminSetting->max_waiting_time_admin_email) {
                    $this->testAdminMessage('email', $adminSetting->max_waiting_time_admin_email, 
                        $adminSetting->time_work_start, $adminSetting->time_work_end, $adminSetting->user_id);
                }
                if($adminSetting->max_waiting_time_admin_sms) {
                    $this->testAdminMessage('sms', $adminSetting->max_waiting_time_admin_sms, 
                        $adminSetting->time_work_start, $adminSetting->time_work_end, $adminSetting->user_id);
                }

                if($adminSetting->max_waiting_time_manager_email) {
                    $this->testManagerMessage('email', $adminSetting->max_waiting_time_manager_email,
                        $adminSetting->time_work_start, $adminSetting->time_work_end, $adminSetting->user_id);
                }
                if($adminSetting->max_waiting_time_manager_sms) {
                    $this->testManagerMessage('sms', $adminSetting->max_waiting_time_manager_sms,
                        $adminSetting->time_work_start, $adminSetting->time_work_end, $adminSetting->user_id);
                }

                if($adminSetting->max_waiting_time_teh_email) {
                    $this->testTehMessage('email', $adminSetting->max_waiting_time_teh_email,
                        $adminSetting->time_work_start, $adminSetting->time_work_end, $adminSetting->user_id);
                }
                if($adminSetting->max_waiting_time_teh_sms) {
                    $this->testTehMessage('sms', $adminSetting->max_waiting_time_teh_sms,
                        $adminSetting->time_work_start, $adminSetting->time_work_end, $adminSetting->user_id);
                }
            }
        }
    }

    public function testAdminMessage($type, $max_waiting_time, $time_work_start, $time_work_end, $user_id) {
        $events = Events::model()->forManager()->findAll();
        foreach ($events as $event) {
            $eventTime = $this->getWorkMin($this->date, $event->timestamp, $time_work_start, $time_work_end);
            if($eventTime>$max_waiting_time) {
                echo "By User: ".$user_id." send ".$type." about admin\n";
                if($type=='email') $this->sendEmail($user_id, 'admin');
                else $this->sendSMS($user_id, 'admin');
            }
        }
    }

    public function testManagerMessage($type, $max_waiting_time, $time_work_start, $time_work_end, $user_id) {
        $events = Events::model()->forSalesManager()->findAll();
        foreach ($events as $event) {
            $eventTime = $this->getWorkMin($this->date, $event->timestamp, $time_work_start, $time_work_end);
            if($eventTime>$max_waiting_time) {
                echo "By User: ".$user_id." send ".$type." about Manager\n";
                if($type=='email') $this->sendEmail($user_id, 'manager');
                else $this->sendSMS($user_id, 'manager');
            }
        }
    }

    public function testTehMessage($type, $max_waiting_time, $time_work_start, $time_work_end, $user_id) {
        $events = Zakaz::model()->findAll(array('condition'=>'`technicalspec`<>0 AND `is_active`=1'));
        foreach ($events as $event) {
            $eventTime = $this->getWorkMin($this->date, strtotime($event->technicalspec_date), $time_work_start, $time_work_end);

            if($eventTime>$max_waiting_time) {
                echo "By User: ".$user_id." send ".$type." about teh\n";
                if($type=='email') $this->sendEmail($user_id, 'teh');
                else $this->sendSMS($user_id, 'teh');
            }
        }
    }
    
    public function getWorkMin($data_this, $data_event, $date_w_start, $date_w_end) {
        
        if($data_this > strtotime(date("d.m.Y", $data_this)." ".$date_w_end)) //если рабочий день закончен
            $data_this = strtotime(date("d.m.Y", $data_this)." ".$date_w_end); //считаем до его окончания
        
        $time_r = $data_this - $data_event;
        $count_day = (int)(($time_r/(60*60*24))); //сколько прошло дней
        //количество минут в рабочем дне
        $work_min = (int)((strtotime(date("d.m.Y")." ".$date_w_end) - strtotime(date("d.m.Y")." ".$date_w_start)) / 60 );
        $sum_min = $count_day*$work_min;

        //сколько сегодне прошло минут до текущего времени
        $min_this_day = (int)(($data_this - strtotime(date("d.m.Y", $data_this)." ".$date_w_start)) / 60);
        //сколько минут вычеслять в день события
        $min_eve_day = (int)(($data_event - strtotime(date("d.m.Y", $data_event)." ".$date_w_start)) / 60);

        $summ_work_min = ($sum_min + $min_this_day) - $min_eve_day;
        return $summ_work_min;
    }

    public function sendEmail($to, $role) {
        $user = User::model()->findByPk($to);
        if($user && $user->email) {
            $title = $this->getTitle($role);
            $email = new Emails;
            $email->from_id	= 1;
            $email->to_id 	= $user->id;
            $email->name 	= $user->full_name;
            $email->sendTo($user->email, $title, $title);
        }
    }

    public function sendSMS($to, $role) {
        $user = User::model()->findByPk($to);
        if($user && $user->phone_number) {
            $title = $this->getTitle($role);
            include_once __DIR__."/../extensions/yiichat/smsc_api.php";
            send_sms(str_replace(['+', '-'], '', $user->phone_number), $title);
        }
    }

    public function getTitle($role) {
        switch ($role) {
            case 'admin':
                return Yii::t('site', 'Notice about exceeding the expectation from admin');
                break;
            case 'manager':
                return Yii::t('site', 'Notice about exceeding the expectation from manager');
                break;
            default:
            case 'teh':
                return Yii::t('site', 'Notice about exceeding the expectation from corrector');
                break;
        }
    }
}