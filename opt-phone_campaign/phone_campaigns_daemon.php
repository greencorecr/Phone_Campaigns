#!/usr/bin/php -q
<?php

/**
 *
 * killall phone_campaigns_daemon.php
 * OR:
 * killall php
 *
 */

// Allowed arguments & their defaults
$runmode = array(
    'no-daemon' => false,
    'help' => false,
    'write-initd' => false,
);

// Scan command line attributes for allowed arguments
foreach ($argv as $k=>$arg) {
    if (substr($arg, 0, 2) == '--' && isset($runmode[substr($arg, 2)])) {
        $runmode[substr($arg, 2)] = true;
    }
}

// Help mode. Shows allowed argumentents and quit directly
if ($runmode['help'] == true) {
    echo 'Usage: '.$argv[0].' [runmode]' . "\n";
    echo 'Available runmodes:' . "\n";
    foreach ($runmode as $runmod=>$val) {
        echo ' --'.$runmod . "\n";
    }
    die();
}

// Make it possible to test in source directory
// This is for PEAR developers only
ini_set('include_path', ini_get('include_path').':..');

// Include Class
error_reporting(E_ALL);
require_once 'System/Daemon.php';
require_once 'config.php';

require_once 'campaign_manager.php';
require_once 'sms_campaign_manager.php';

// Setup
$options = array(
    //'appName' => 'phone_campaigns_daemon',
    'appName' => $config['appName'],
    'appDir' => dirname(__FILE__),
    'appDescription' => 'Runs asterisks phones campaigns',
    'authorName' => 'Jorge Bastias',
    'authorEmail' => 'jorgebastias@hotmail.com',
    'sysMaxExecutionTime' => '0',
    'sysMaxInputTime' => '0',
    'sysMemoryLimit' => '1024M',
    'logVerbosity' => $config['log_level'],
    //'appRunAsGID' => 1000,
    //'appRunAsUID' => 1000,
);

System_Daemon::setOptions($options);

// This program can also be run in the forground with runmode --no-daemon
if (!$runmode['no-daemon']) {
    // Spawn Daemon
    System_Daemon::start();
}

// With the runmode --write-initd, this program can automatically write a
// system startup file called: 'init.d'
// This will make sure your daemon will be started on reboot
if (!$runmode['write-initd']) {
    System_Daemon::info('not writing an init.d script this time');
} else {
    if (($initd_location = System_Daemon::writeAutoRun()) === false) {
        System_Daemon::notice('unable to write init.d script');
    } else {
        System_Daemon::info(
            'sucessfully written startup script: %s',
            $initd_location
        );
    }
}

// Run your code
// Here comes your own actual code

// This variable gives your own code the ability to breakdown the daemon:
$runningOkay = true;

// While checks on 2 things in this case:
// - That the Daemon Class hasn't reported it's dying
// - That your own code has been running Okay
while (!System_Daemon::isDying() && $runningOkay) {

    // What mode are we in?
    $mode = '"'.(System_Daemon::isInBackground() ? '' : 'non-' ).
        'daemon" mode';

    // Log something using the Daemon class's logging facility
    // Depending on runmode it will either end up:
    //  - In the /var/log/phone_campaings_daemon.log
    System_Daemon::info('{appName} running in %s', $mode);

    System_Daemon::info('config: ' . print_r($config, true));



    /*************************************************************************/
    // In the actuall phone campaigns program
    //  - one iteration for attempt, if there are no calls to make, returns false
    $cm = new campaign_manager();
    $runningOkay = $cm->create_phone_call();
    
    $sms = new sms_campaign_manager();
    $runningOkay = $sms->create_sms_messages_batch();
    
    
    
    /*************************************************************************/

    // Should create_phone_call() return false, then
    // the daemon is automatically shut down.
    // An extra log entry would be nice, we're using level 3,
    // which is critical.
    // Level 4 would be fatal and shuts down the daemon immediately,
    // which in this case is handled by the while condition.
    if (!$runningOkay) {
        System_Daemon::err('create_phone_call() produced an error '.
            'or no more calls to be made, so this will be my last run');
    }

    // Relax the system by sleeping for a little bit
    // iterate also clears statcache
    System_Daemon::iterate($config['iteration_sleep']);

}

// Shut down the daemon nicely
// This is ignored if the class is actually running in the foreground
System_Daemon::stop();
