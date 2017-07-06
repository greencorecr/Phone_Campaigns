#!/usr/bin/php -q
<?
require_once 'abstract_agi.php';

class no_answer extends abstract_agi
{
    function __construct() {
        parent::__construct();
    }

    function specifics()
    {
        $this->log->LogDebug("****************>>>>>>>>>>>>>>: no-answer.php");

        // set call result, for hangup.php
        $this->agi->set_variable('call_result', 'NOT answered');
        $this->log->LogDebug("no-answer: set_variable, NOT answered");

        // update call not answered result from database
        $this->call->update_call_not_answered(
                $this->row_call, $this->row_campaign->retries, $this->agi->request['agi_uniqueid']);
        $this->log->LogDebug("no-answer: update_call_not_answered {$this->row_call->id}");

     }

}

$no_answer = new no_answer();
$no_answer->run_script();

