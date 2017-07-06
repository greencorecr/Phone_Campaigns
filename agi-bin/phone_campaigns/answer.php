#!/usr/bin/php -q
<?
require_once 'abstract_agi.php';

class answer extends abstract_agi
{
    function __construct() {
        parent::__construct();
    }

    function specifics()
    {
        $this->log->LogDebug("****************>>>>>>>>>>>>>>: answer.php");
  
        $confirm = $this->agi->wait_for_digit(6000); //prueba 

        // set call result, for hangup.php
        $this->agi->set_variable('call_result', 'answered');
        $this->log->LogDebug("answer: set_variable, answered");

        // update call answered result from database
        $this->call->update_call_answered($this->agi->request['agi_uniqueid'], $this->row_call->id);
        $this->log->LogDebug("answer: update_call_answered {$this->row_call->id}");

        // play amount and the welcome message
       // $this->agi->stream_file('custom/muni-informa-debe');
        $this->agi->stream_file($this->get_recording_path($this->row_campaign->recording));
                
        if($this->row_call->amount_owed != null){
        
            $this->agi->say_number($this->row_call->amount_owed);
            $this->agi->stream_file('custom/ivr/colones');

            // play confirm message, record conformation
            //$this->agi->stream_file('press-1', '#');

            $this->agi->stream_file('custom/presione_uno', '#');
            
        }
        
        // if the the second recording is present, the play the recording
        if($this->row_campaign->recording2 != null){
            $this->agi->stream_file($this->get_recording_path($this->row_campaign->recording2));
        }
        
   //     $confirm = $this->agi->wait_for_digit(10000);
  //      $this->log->LogDebug("confirm: " . print_r($confirm, true));

    }

}

$answer = new answer();
$answer->run_script();
