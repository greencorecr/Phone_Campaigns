#!/usr/bin/php -q
<?
require_once 'abstract_agi.php';

class hangup extends abstract_agi
{
    function __construct() {
        parent::__construct();
    }

    function specifics()
    {
        $this->log->LogDebug("****************>>>>>>>>>>>>>>: hangup.php");

        $call_result = $this->get_var('call_result');

        // update call info in database
        $this->call->update_call_end($this->row_call->id);
        $this->log->LogDebug("hangup: update_call_end(id={$this->row_call->id})");
        $this->call->update_call_not_active($this->row_call->id); // put call into NON active state, active = false
        $this->log->LogDebug("hangup: update_call_not_active(id={$this->row_call->id})");

        $this->row_call = $this->call->get_call_by_callid($this->row_call->id);
        $this->log->LogDebug("failed: refresh the object[id={$this->row_call->id}]");
   
        $this->campaign->decrement_active_calls($this->row_campaign->id);
        $this->log->LogDebug("hangup: decrement_active_calls({$this->row_campaign->id}})");

        $this->log->LogDebug("hangup: before campaign info: " . print_r($this->row_campaign, true));
        $this->log->LogDebug("hangup: before call info: " . print_r($this->row_call, true));

        // update campaign completed calls
        if($this->row_call->status == calls_status::answered ||
           $this->row_call->status == calls_status::failed){
            $this->campaign->update_num_completed($this->row_campaign->id);
            $this->log->LogDebug("hangup: update campaign num_complete + 1");
        }
        $this->log->LogDebug("hangup: after campaign info: " . print_r($this->row_campaign, true));
        $this->log->LogDebug("hangup: after call info: " . print_r($this->row_call, true));

    }

}

$hangup = new hangup();
$hangup->run_script();
