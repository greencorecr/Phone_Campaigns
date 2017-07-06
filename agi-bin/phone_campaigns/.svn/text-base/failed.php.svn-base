#!/usr/bin/php -q
<?
require_once 'abstract_agi.php';

class failed extends abstract_agi
{
    function __construct() {
        parent::__construct();
    }

    function specifics()
    {
        $this->log->LogDebug("****************>>>>>>>>>>>>>>: failed.php");

        /* http://www.voip-info.org/wiki/view/Asterisk+Reason+variable
         * 0 - Failed (not busy or congested)
         * 1 - Hung up
         * 3 - Ring timeout
         * 5 - Busy
         * 8 - Congestion
         */
        $reason = $this->get_var('reason');
        $this->log->LogDebug("call failed: $reason");        

        //if($reason != 8){

            // update call not answered result from database
            $this->call->update_call_not_answered(
                    $this->row_call, $this->row_campaign->retries, $this->agi->request['agi_uniqueid']);
            $this->log->LogDebug("failed: the call was not answered");

            $this->row_call = $this->call->get_call_by_callid($this->row_call->id);
            $this->log->LogDebug("failed: refresh the object[id={$this->row_call->id}]");

            $this->log->LogDebug("failed: before campaign info: " . print_r($this->row_campaign, true));
            $this->log->LogDebug("failed: before call info: " . print_r($this->row_call, true));

             // update campaign completed calls
            if($this->row_call->status == calls_status::answered ||
               $this->row_call->status == calls_status::failed){
                $this->campaign->update_num_completed($this->row_campaign->id);
                $this->log->LogDebug("failed: update campaign num_complete + 1");
            }

            $this->log->LogDebug("failed: after campaign info: " . print_r($this->row_campaign, true));
            $this->log->LogDebug("failed: after call info: " . print_r($this->row_call, true));


       // } else {
       //     $this->call->update_call_congested($this->row_call->id);
       // }

        // update call info in database
        $this->call->update_call_not_active($this->row_call->id); // put call into NON active state, active = false
        $this->log->LogDebug("failed: update_call_not_active(id={$this->row_call->id})");

        // update campaign active_calls
        $this->campaign->decrement_active_calls($this->row_campaign->id);
        $this->log->LogDebug("failed: decrement_active_calls({$this->row_campaign->id})");
        
    }

}

$failed = new failed();
$failed->run_script();

