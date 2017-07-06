<?php

require_once dirname(__FILE__) . '/' . 'logWrapper.php'; 

require_once $config['db_code_path'] . '/' . 'enums.php';
require_once $config['db_code_path'] . '/' . 'abstract_dal.php';
require_once $config['db_code_path'] . '/' . 'db_campaign.php';
require_once $config['db_code_path'] . '/' . 'db_calls.php';

class campaign_manager
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

    function create_phone_call(){

         // cleanup running campaigns
        $this->cleanup_running_campaigns();

        logDebug('next interation: get the next call');
        $active_calls = $this->campaign->get_all_active_calls_count();
        $max_active_calls = $this->config['max_active_calls'];
        logDebug("active call count: $active_calls");
        logDebug("config, max active calls: $max_active_calls");
        if($active_calls >= $max_active_calls){
            logDebug("the active call counts($active_calls) has reached max call count($max_active_calls)");
            return true;
        }
        
        $campaign = $this->get_active_campaign();
        if(!empty($campaign)){

            logDebug("campaign: " . print_r($campaign, true));

            $call = $this->call->get_next_call($campaign->id, $this->config['hours_between_retries']);

            if(!empty($call)){

                // create call file
                $this->call->update_call_active($call->id); // put call into active state, active = true
                logDebug("update call state to active, active = true");

                $this->create_callfile($call->phone, $call->id, $call->id_campaign);
                logDebug("create call file");

                // increment active call count
                $this->campaign->increment_active_calls($campaign->id);
                logDebug("increment_active_calls: id=$campaign->id, active_calls = $campaign->active_calls");

            } else {
                logInfo("no pending or retry call available");
            }

        } else {
            logInfo("no active campaign found");
        }

        return true;

    }

    function get_active_campaign()
    {
        // get list of running campaigns, order by priority, created
        $campaigns = $this->campaign->get_running_campaigns();
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
            return false;
        }
        logInfo("Campaign [id=$campaign->id] has $call_count->call_count pending calls.");

        return true;
    }

    function cleanup_running_campaigns(){

        $campaigns = $this->campaign->get_running_campaigns();

        $now = $this->campaign->get_server_date();
        logDebug("what's the time?:  " . print_r($now, true));

        $this->campaign->update_campaign__num_completed();
        logDebug("clean up the completed campaigns");

        foreach($campaigns as $campaign){

			// update the number of active calls in the database
		    $this->campaign->update_campaign_active_calls($campaign->id);		

            $call_count = $this->campaign->get_available_calls_count($campaign->id);
            logDebug("\$call_count: $call_count->call_count");

            if($call_count->call_count == 0  || $campaign->date_end < $now){
                $this->campaign->update_campaign_status(campaign_status::completed, $campaign->id);
                logDebug("campaign [id=$campaign->id] status set to completed");
            }
        }
    }

    /*
    * create_callfile($number)
    */
    function create_callfile($number, $call_id, $campaign_id){

        // temp filename in /tmp
        $tmpfname = tempnam($this->config['temp_dir'], $this->config['file_prefix']);
        logInfo("call file name: " . $tmpfname);
        
        // create file contents
        $file_contents = $this->get_callfile($number, $call_id, $campaign_id);
        logInfo("call file contents: \n" . $file_contents);

        file_put_contents($tmpfname, $file_contents);

        // change the owner to asterisk:asterisk
        chown($tmpfname, 'asterisk');
        chgrp($tmpfname, 'asterisk');
        touch($tmpfname, time() + 1);

        // mv the file to outgoing directory
        rename($tmpfname, $this->config['outbound_dir'].str_replace($this->config['temp_dir'], '', $tmpfname));
    }

    /*
     * get_callfile($number, $call_id, $campaign_id)
     */
    function get_callfile($number, $call_id, $campaign_id){
        $call_file = file_get_contents($this->config['call_file_template']);
        $call_file = str_replace('[number]', $number, $call_file);
        $call_file = str_replace('[call_id]', $call_id, $call_file);
        $call_file = str_replace('[campaign_id]', $campaign_id, $call_file);
        $call_file = str_replace('[callerid]', $this->config['callerid'], $call_file);
        return $call_file;
    }

}
