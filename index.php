<?php
//define('YII_ENABLE_ERROR_HANDLER',false);
//define('YII_ENABLE_EXCEPTION_HANDLER', false);
error_reporting(E_ALL ^ E_NOTICE);

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

if(!isset($_SERVER['SLIM_MODE']) || !($_SERVER['SLIM_MODE'] == "production")) {
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}


require_once($yii);
//xhprof_enable();

//custom WebApplication
require_once(dirname(__FILE__).'/protected/config/DSApplication.php');
$app = new DSApplication($config);
$app->run();
//end custom WebApplication

// Yii::createWebApplication($config)->run(); //standard WebApp


//$xhprof_data = xhprof_disable();
//$XHPROF_ROOT = realpath(dirname(__FILE__) .'/../xhprof');
//include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
//include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

// save raw data for this profiler run using default
// implementation of iXHProfRuns.
//$xhprof_runs = new XHProfRuns_Default();

// save the run under a namespace "xhprof_foo"
//$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_dipstart");

/*echo "---------------\n".
    "Assuming you have set up the http based UI for \n".
    "XHProf at some address, you can view run at \n".
    "<a href='http://xhprof.coolfire.pp.ua/xhprof_html/index.php?run=$run_id&source=xhprof_dipstart'>here</a>\n".
    "---------------\n";
*/