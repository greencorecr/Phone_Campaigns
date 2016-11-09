#!/usr/bin/php -q
<?php
require_once 'System/Daemon.php';
require_once 'config.php';

require_once 'campaign_manager.php'; 
require_once 'sms_campaign_manager.php';
require_once 'process_incoming_requests.php';

/**
 * Description of test_driver
 *
 * @author jbastias
 */
class test_driver {

    var $argv;
    var $argc;
    
   function __construct($argv, $argc) {
       $this->argc = $argc;
       $this->argv = $argv;
   }

   function run(){
       if(!$this->parse_command()) echo $this->usage();
   }

   function parse_command(){
       if ($this->argv[1] != 'run') return false;
       if ($this->argv[2] == 'phone') return $this->run_phone_iteration();
       if ($this->argv[2] == 'sms') return $this->run_sms_iteration();
       if ($this->argv[2] == 'process') return $this->run_process_iteration();
       if ($this->argv[2] == 'all') return $this->run_all_iteration();
       return false;
   }
   
   function run_phone_iteration(){
       logDebug("\nphone iteration\n==============================================");
       $cm = new campaign_manager();
       $cm->create_phone_call();
       return true;
   }

   function run_sms_iteration(){
       logDebug("\nsms iteration\n==============================================");
       $sms = new sms_campaign_manager();
       $sms->create_sms_messages_batch();
       return true;
   }
   
   function run_process_iteration(){
       logDebug("\nprocess inbound iteration\n==============================================");
       $process = new process_incoming_requests();
       $process->process_request();
       return true;
   }
   
   function run_all_iteration(){
       
       $this->run_phone_iteration();
       
       $this->run_sms_iteration();
       
       $this->run_process_iteration();
       return true;
   }
   
   function usage(){
       echo "Usage: {$this->argv[0]} run type\n";
       echo "\ttype = phone | sms | process | all\n";
   }
   
}

$driver = new test_driver($argv, $argc);
$driver->run();
