<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'PQSIS',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
/*
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'password',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),
*/
	// application components
	'components'=>array(
		'session'=>array(
			'class'=>'CDbHttpSession',
			'connectionID'=>'db',
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'commonUtil'=>array(
			'class'=>'CommonUtil',
		),
	    'formDao'=>array(
			'class'=>'FormDao',
		),
		'maintenanceDao'=>array(
			'class'=>'MaintenanceDao',
		),
		'reportDao'=>array(
			'class'=>'ReportDao',
		),
		'functionDao'=>array(
			'class'=>'FunctionDao',
		),
        'planningAheadDao'=>array(
            'class'=>'PlanningAheadDao',
        ),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
				'connectionString' => 'pgsql:host=192.168.0.120;port=5455;dbname=PQSIS',
				'emulatePrepare' => true,
				'username' => 'postgres',
				'password' => 'P@ssw0rd',
				'charset' => 'utf8',		
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'info, error, warning',
					'categories'=>'cu_crc.*',
					'logPath'=>$_SERVER['DOCUMENT_ROOT'] . '/pqsis/logs',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(

	'db_username' =>'', //username
    'db_password' => '', //password

//path to database file
	'report_save_path' => "\\\\192.168.0.120\\ShareFolder\\JKTech\\Project\\CLP\\PQSIS_DEV\\Report",
	'system_version_path' => dirname(__FILE__)."\\system_version.txt",
	'latest_version_path'=> dirname(__FILE__)."\\latest_version.txt", 
		// this is used in contact page
		//'adminEmail'=>'sammylee@jktech-ltd.com',
	),
);