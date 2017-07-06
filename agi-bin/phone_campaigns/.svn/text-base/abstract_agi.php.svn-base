<?
set_time_limit(30);
require_once 'phpagi.php';
require_once 'KLogger.php';
require_once 'config.php';

require_once $config['db_code_path'] . '/' . 'enums.php';
require_once $config['db_code_path'] . '/' . 'abstract_dal.php';
require_once $config['db_code_path'] . '/' . 'db_campaign.php';
require_once $config['db_code_path'] . '/' . 'db_calls.php';
error_reporting(E_ALL);

abstract class abstract_agi{

    var $config;
    var $campaign;
    var $call;
    var $log;
    var $agi;

    var $row_campaign;
    var $row_call;


    function __construct() {

        global $config;
        $this->config =& $config;

        $this->campaign = new campaign_table();
        $this->call = new calls_table();

        $this->log = new KLogger ( dirname(__FILE__)."/phone_campaigns.log" , KLogger::DEBUG );
        $this->log->LogInfo('------------------------------------------------------------------------------');

        $this->agi = new AGI();

    }

    function setup_script()
    {
        $this->log->LogDebug('agi request: ' . print_r($this->agi->request, true));

        // get variables from asterisk
        $campaignid = $this->get_var('campaign_id');
        $callid = $this->get_var('call_id');
        $number = $this->get_var('number');

        // get campaign from database
        $this->row_campaign = $this->campaign->get_by_id($campaignid);
        if(!empty($this->row_campaign))
            $this->log->LogDebug("campaign: " . print_r($this->row_campaign, true));
        else
            $this->log->LogError("no campaign, \$campaignid = $campaignid");

        // get call from database
        $this->row_call = $this->call->get_call_by_callid($callid);
        if(!empty($this->row_call))
            $this->log->LogDebug("call: " . print_r($this->row_call, true));
        else
            $this->log->LogError("no call found, \$callid = $callid");

    }

    function get_var($varname){

        $result = $this->agi->get_variable($varname);
        $this->log->LogDebug($varname.'_result: ' . print_r($result, true));

        $result_data = $result['data'];
        $this->log->LogDebug($varname.': ' . $result_data);

        return $result_data;

    }

    function get_recording_path($campaign_recording){

        $pos = strrpos($campaign_recording, '.');

        $recording = substr($campaign_recording, 0, $pos);

        $return_val = $this->config['recordings_subdir']. $recording;

        $this->log->LogDebug("$pos - $recording - $return_val");

        return $return_val;

    }

    abstract function specifics();

    function run_script()
    {
        $this->setup_script();
        $this->specifics();
    }








}




/*
 * - get call info from pbx
 * - get call info from database
 * - find the call state (first time, retry 0 - retry max, no answer)
 * - update the database
 * - play the file
 * - look for confirmation
 */

//try
//{
//    $agi = new AGI();
//    $log->LogDebug('agi request: ' . print_r($agi->request, true));
//
//    // set call result, for hangup.php
//    $agi->set_variable('call_result', 'answered');
//
//    // get variables from asterisk
//    $campaignid = _get_var('campaign_id');
//    $callid = _get_var('call_id');
//    $number = _get_var('number');
//
//    // get database tables objects
//    $campaign_table = new campaign_table();
//    $calls_table = new calls_table();
//
//    // get campaign from database
//    $campaign = $campaign_table->get_by_id($campaignid);
//    if(!empty($campaign))
//        $log->LogDebug("campaign: " . print_r($campaign, true));
//    else
//        $log->LogError("no campaign, \$campaignid = $campaignid");
//
//    // get call from database
//    $call = $calls_table->get_call_by_callid($callid);
//    if(!empty($callid))
//        $log->LogDebug("call: " . print_r($call, true));
//    else
//        $log->LogError("no call found, \$callid = $callid");
//
//    // update call answered result from database
//    $calls_table->update_call_answered($agi->request['agi_uniqueid'], $call->id);
//
//    // play amount and the welcome message
//    //$agi->stream_file('custom/muni-informa-debe');
//    $agi->stream_file(get_recording_path($campaign->recording));
//    $agi->say_number($call->amount_owed);
//    $agi->stream_file('custom/colones');
//
//    // play confirm message, record conformation
//    $agi->stream_file('press-1', '#');
//    $confirm = $agi->wait_for_digit(10000);
//    $log->LogDebug("confirm: " . print_r($confirm, true));
//
//} catch(Exception $e) {
//    $log->LogFatal(" something went wrong " . print_r($e, true));
//}
