<?php

error_reporting(E_ALL);

require_once dirname(__FILE__) . '/' . 'logWrapper.php'; 

require_once $config['db_code_path'] . '/' . 'enums.php';
require_once $config['db_code_path'] . '/' . 'abstract_dal.php';
require_once $config['db_code_path'] . '/' . 'db_campaign.php';
require_once $config['db_code_path'] . '/' . 'db_calls.php';

class sms_campaign_manager
{
    var $config;
    var $campaign;
    var $call;

    function __construct() {

        global $config;
        $this->config =& $config;

        $this->campaign = new campaign_table();
        $this->call = new calls_table();

    }

    
    function create_sms_messages_batch(){

        logDebug("find active sms campaign");        
        $campaign = $this->get_active_sms_campaign();

        $this->campaign->update_campaign__num_completed();
        
        if($campaign == null) return;
        
        // clean up campaign
        logDebug("clean up campaign");        
        $this->confirm_sms_calls_sent($campaign);
        
        
        $pending = $this->call->get_pending_sms_calls_count_by_campaignid($campaign->id);
        if(!$pending)
            $this->campaign->update_campaign_status('completed', $campaign->id);
        
        // does campaign have calls to make
        logDebug("does campaign have calls to make");        
        $this->create_sms_call_batch($campaign);
       
        return true;
    }

    
    function get_active_sms_campaign()
    {
        // get list of running campaigns, order by priority, created
        $campaigns = $this->campaign->get_running_sms_campaigns();
       
        if(empty($campaigns)){
            logInfo('no running campaigns, exit the iteration');
        }

        // validate for date range, time range, and there are any calls
        $valid_campaign = false;
        foreach($campaigns as $campaign){
            if($this->validate_campaign($campaign)) {
                $valid_campaign = true;
                break;
            }
        }

        if(!$valid_campaign){
            logInfo("no valid campaigns were found");
            return null;
        } else {
            return $campaign;
        }

    }

    function validate_campaign($campaign)
    {

        // validate date range
        $date_range = $this->campaign->validate_date_range($campaign->id);
        if(empty($date_range)){
            logInfo("Campaign [id=$campaign->id] is outside of the valid date range [$campaign->date_start - $campaign->date_end].");
            return false;
        }

        // validate time range
        $time_range = $this->campaign->validate_time_range($campaign->id);
        if(empty($time_range)){
            logInfo("Campaign [id=$campaign->id] is outside of the valid time range [$campaign->day_start - $campaign->day_end].");
            return false;
        }

        // if there are pending calls for this campaign
        $call_count = $this->campaign->get_available_calls_count($campaign->id);
        if($call_count->call_count <= 0){
            logInfo("Campaign [id=$campaign->id] has no pending calls.");           
            $this->campaign->update_campaign_status('completed', $campaign->id);           
            return false;
        }
        logInfo("Campaign [id=$campaign->id] has $call_count->call_count pending calls.");
        return true;
    }

    function confirm_sms_calls_sent($campaign){
        $sms_calls = $this->call->get_sms_calls_sent_by_campaignid($campaign->id);
        $sent_path = $this->config['sms_sent_dir'];
        foreach($sms_calls as $sms){
            if(file_exists($sent_path.'/'.$sms->call_file)){
                $this->call->update_call_sms_sent($sms->id);
            }
        }
    }

    function create_sms_call_batch($campaign){
        logDebug("create_sms_call_batch()\n");

        logDebug("\$campaign: ".print_r($campaign, true)."\n");
        $sms_message = $campaign->sms_message;
        $use_amount = $campaign->use_amount ? true : false;
        
        $calls = $this->call->get_sms_calls_by_campaignid($campaign->id, $this->config['sms_batch_size']);
        $count = 0;
        foreach($calls as $call){
            
            $sms_message = $campaign->sms_message;
            $use_amount = $campaign->use_amount ? true : false;
            if($use_amount) $sms_message = str_replace ('$$$', $call->amount_owed, $sms_message);
            $file_contents = $this->get_sms_callfile($call->phone, $sms_message);
            
            $file_name = $this->create_sms_callfile($file_contents);

            if($file_name){
                $this->call->update_call_sendsms($call->id, $file_name);
                $count++;
            }
        }
        
        $this->campaign->update_num_completed($campaign->id, $count);

    }

    /*
    * create_callfile($number)
    */
    function create_sms_callfile($file_contents){

        // temp filename in /tmp
        logDebug(system("whoami"));
        logInfo("holaaa");
        $tmpfname = tempnam($this->config['temp_dir'], $this->config['sms_file_prefix']);
        $filename = str_replace($this->config['temp_dir'].'/', '', $tmpfname);
        logInfo("call file name: " . $tmpfname);

        file_put_contents($tmpfname, $file_contents);

        // change the owner to asterisk:asterisk
        if(!chown($tmpfname, 'asterisk')) return null;
        if(!chgrp($tmpfname, 'asterisk')) return null;
        touch($tmpfname, time() + 1);
	chmod($tmpfname, 0666);

        // mv the file to outgoing directory
        if(rename($tmpfname, $this->config['sms_outgoing_dir'].'/'.$filename))
            return $filename;
        
        return null;
    }
    
    /*
     * get_sms_callfile($number, $message)
     */
    function get_sms_callfile($number, $message){
        $sms_file = file_get_contents($this->config['sms_file_template']);
        $sms_file = str_replace('{phone_number}', $number, $sms_file);
        $sms_file = str_replace('{message}', $message, $sms_file);
        return $sms_file;
    }
}
