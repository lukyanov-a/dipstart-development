<?php
class EventsCommand extends CConsoleCommand {
	
	const INTERVAL = 5; // �������� ������� ������� � �������
	const EMAILS_COUNT = 100; // ���������� 100 ����� �� ���
	
    public function run($args) {
		$companies = Company::model()->findAll('frozen=:p',array(':p'=>'0'));
		
		foreach($companies as $company) {
			Company::setActive($company);
			self::executor();
			self::manager();
			self::send_deffered_emails();
		}
    }
			
	// ������� � ����������� - ���������� ������ �� ����� ����������� �� ���� (����� �� �����������)
	public function executor() {
		$usersModel = User::model()->findAllNotificationExecutors();
		if (is_array($usersModel))
			foreach ($usersModel as $user) {
				foreach ($user->zakaz_executor as $zakaz) {
					if(isset($user->profile)) $time = explode(':', $user->profile->notification_time); // ����� X, �� ������� ���� ���������� (���������� ����� � �����), ������ "5;48"
					else $time[0] = 0;
					if (count($time)<2) $time[1] = 0;
					$date = date('Y-m-d H:i',strtotime($zakaz->author_informed));
					$date = strtotime($date)-(int)$time[0]*60*60-(int)$time[1]*60;
					$dateStart = strtotime(date('Y-m-d H:i',$date)) - (self::INTERVAL * 60);
					if (time() > $dateStart && time() <= $date ) {
						echo 'Email zakaz #'.$zakaz->id."\n";
						$templatesModel = Templates::model()->findByAttributes(array('type_id'=>'32'));
						if($templatesModel) {
							$email = new Emails;
							$email->from_id	= 1;
							$email->to_id 	= $user->id;
							$email->name 	= $user->full_name;
							$email->sendTo($user->email, $templatesModel->title, $templatesModel->text);
						}
					}
					
					// Send message executor, when completion of the point
					foreach ($zakaz->parts as $stage) {
						if(isset($user->profile)) $time = explode(':', $user->profile->notification_time); // ����� X, �� ������� ���� ���������� (���������� ����� � �����), ������ "5;48"
						else $time[0] = 0;
						if (count($time)<2) $time[1] = 0;
						$date = date('Y-m-d H:i',strtotime($stage->date));
						$date = strtotime($date)-(int)$time[0]*60*60-(int)$time[1]*60;
						$dateStart = strtotime(date('Y-m-d H:i',$date)) - (self::INTERVAL * 60);
						if (time() > $dateStart && time() <= $date ) {
							echo 'Email stage zakaz #'.$stage->id."\n";
							$templatesModel = Templates::model()->findByAttributes(array('type_id'=>'33'));
							if($templatesModel) {
								$email = new Emails;
								$email->from_id	= 1;
								$email->to_id 	= $user->id;
								$email->name 	= $user->full_name;
								$email->sendTo($user->email, $templatesModel->title, $templatesModel->text);
							}
						}
					}
				}
				
			}
	}
	
	protected function processEventItems($items, $field, $event, $item_id = 'id') {
		foreach ($items as $item) {
			$dateStart = strtotime(date('Y-m-d H:i',time())) - (self::INTERVAL * 60);
			if (strtotime(date('Y-m-d H:i',strtotime($item->$field))) >= $dateStart && strtotime(date('Y-m-d H:i',strtotime($item->$field))) < strtotime(date('Y-m-d H:i',time()))) {
				EventHelper::$event($item->$item_id);
			}
		}
	}
	
	//������� ������� � ��������� ����� ��������� �����
	public function manager() {
		Yii::import('application.modules.project.components.EventHelper');
		// ���� �������������� ��������������
		$projectsModel = Zakaz::model()->findAll('status<>:status', array(':status'=>5));
		$this->processEventItems($projectsModel, 'manager_informed', 'managerInformed');
		
		// � ����� ������ �������������� ������
		$projectsPartsModel = ZakazParts::model()->findAllByAttributes(array('status_id'=>'1'));
		$this->processEventItems($projectsPartsModel, 'date', 'stageExpired', 'proj_id');

		// ���� �������������� ���������
		$profileModel = Profile::model()->findAll();
		$this->processEventItems($profileModel, 'manager_informed', 'salesManagerInformed', 'user_id');
	}
	
	//���������� n ����� �� ������ ��� ��������
	public function send_deffered_emails(){
		$emails = Emails::model()->sending_round(self::EMAILS_COUNT)->findAll();
		foreach($emails as $email){
			if($email->send()) $email->delete();
		}
	}
}