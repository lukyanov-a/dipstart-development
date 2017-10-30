<?php
date_default_timezone_set('Europe/Moscow');

return array(
  
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Cron',
 
    'preload'=>array('log'),
 
    'import'=>array(
        'application.components.*',
        'application.models.*',
		'application.modules.user.*',
		'application.modules.user.models.*',
		
		'application.modules.project.*',
		'application.modules.project.models.*',
		'application.behaviors.*',
    ),

	'modules'=>array(
        'user' => array(
            'tableUsers' => 'Users',
            'tableProfiles' => 'Profiles',
            'tableProfileFields' => 'ProfilesFields',
        ),
		
	),
	
    'components'=>array(
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
            ),
        ),
		
		'cache'=>array(
			//'class'=>'system.caching.CDummyCache',
            'class'=>'system.caching.CMemCache',
            'servers'=>array(
                array('host'=>'localhost', 'port'=>11211, 'weight'=>100),
            ),
        ),
 
        // ���������� � ����
		'db'=>include 'db.php',
		
		'cdr' => [
            'class' => 'application.components.TelphinCdrComponent',
            //'app_id' => '********************************',
            //'app_secret' => '********************************',
            'extension' => 100,
            'count' => 2000,
        ],
    ),
	'timeZone' => 'Europe/Moscow',
);