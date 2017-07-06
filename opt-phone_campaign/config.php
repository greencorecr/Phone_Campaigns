<?php

/****************************
const LOG_EMERG = 0;
const LOG_ALERT = 1;
const LOG_CRIT = 2;
const LOG_ERR = 3;
const LOG_WARNING = 4;
const LOG_NOTICE = 5;
const LOG_INFO = 6;
const LOG_DEBUG = 7;
******************************/

define('DEVELOPMENT', FALSE);

$config = array(
    'appName' => 'phone_campaigns_daemon',
    'temp_dir' => '/tmp',
    'file_prefix' => 'CALLFILE',
    'outbound_dir' => '/var/spool/asterisk/outgoing',
    'max_retries' => 5,
    'call_file_template' => dirname(__FILE__).'/call_file.template',
    'log_level' => 7,

    /* database setting */
    'db_user' => 'root',
//    'db_password' => 'dbtoor',
    'db_password' => 'eiN4damuaeQuin4u',
    'db_name' => 'phone_campaigns',
    'db_host' => 'localhost',
    
    'db_code_path' =>  dirname(__FILE__).'/database',
    'iteration_sleep' => 10,
    'callerid' => '"GCS" <22571015>',
    'hours_between_retries' => 1,
    'max_active_calls' => 15,
  
    // sms messages
    'sms_file_prefix' => 'sendsms_',
    'sms_outgoing_dir' => '/var/spool/sms/outgoing',
    'sms_sent_dir' => '/var/spool/sms/sent',
    'sms_file_template' => dirname(__FILE__).'/sms_template.txt',
    'sms_batch_size' => '10',


);

// print_r($config);
