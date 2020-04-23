<?php


// Dashboard columns. 2 or 3
$config['supervisor_cols'] = 2;

// Refresh Dashboard every x seconds. 0 to disable
$config['refresh'] = 10;

// Enable or disable Alarm Sound
$config['enable_alarm'] = true;

// Show hostname after server name
$config['show_host'] = false;

$config['supervisor_servers'] = array(
        'Org1创世.HBCC1' => array(
                'url' => 'http://119.253.85.164/RPC2',
                'port' => '9901'
        ),
        'Org1创世.HBCC2' => array(
                'url' => 'http://119.253.85.164/RPC2',
                'port' => '9902'
        ),
	'Org11建行.JAVA1' => array(
		'url' => 'http://119.253.85.165/RPC2',
		'port' => '9901',
	),
	'Org11建行.JAVA2' => array(
		'url' => 'http://119.253.85.165/RPC2',
                'port' => '9902'
	),
	'Org11建行.HBCC1' => array(
                'url' => 'http://119.253.85.165/RPC2',
                'port' => '9903'
        ),
	'Org11建行.HBCC2' => array(
                'url' => 'http://119.253.85.165/RPC2',
                'port' => '9904'
        ),
        'Org12润辰.JAVA1' => array(
                'url' => 'http://119.253.85.166/RPC2',
                'port' => '9901',
        ),
        'Org12润辰.JAVA2' => array(
                'url' => 'http://119.253.85.166/RPC2',
                'port' => '9902'
        ),
        'Org12润辰.HBCC1' => array(
                'url' => 'http://119.253.85.166/RPC2',
                'port' => '9903'
        ),
        'Org12润辰.HBCC2' => array(
                'url' => 'http://119.253.85.166/RPC2',
                'port' => '9904'
        ),
        'ORG19苏菜.JAVA1' => array(
                'url' => 'http://112.74.159.29/RPC2',
                'port' => '9191',
        ),
        'ORG19苏菜.JAVA2' => array(
                'url' => 'http://112.74.159.29/RPC2',
                'port' => '9192'
        ),
        'ORG19苏菜.JAVA3' => array(
                'url' => 'http://112.74.159.29/RPC2',
                'port' => '9193'
        ),
        'ORG20南钢.JAVA1' => array(
                'url' => 'http://112.74.228.240/RPC2',
                'port' => '9201',
        ),
        'ORG20南钢.JAVA2' => array(
                'url' => 'http://112.74.230.216/RPC2',
                'port' => '9201'
        ),
        'ORG20南钢.Platform1' => array(
                'url' => 'http://112.74.228.240/RPC2',
                'port' => '9022'
        ),
        'ORG20南钢.Platform2' => array(
                'url' => 'http://112.74.230.216/RPC2',
                'port' => '9202',
        ),
        'ORG20南钢.Keylist' => array(
                'url' => 'http://112.74.228.240/RPC2',
                'port' => '9023'
        ),
        '运维1' => array(
                'url' => 'http://119.253.85.167/RPC2',
                'port' => '9901'
        ),

);

// Set timeout connecting to remote supervisord RPC2 interface
$config['timeout'] = 3;

// Path to Redmine new issue url
$config['redmine_url'] = 'http://redmine.url/path_to_new_issue_url';

// Default Redmine assigne ID
$config['redmine_assigne_id'] = '69';


