<?php

class campaign_table extends abstract_dal
{

    function __construct() {
        parent::__construct();
        $this->table = 'campaign';
        $this->fields = 'id, name, date_start, date_end, day_start, day_end, retries, num_complete, total_calls, recording, status, priority, active_calls, created';
        $this->keys = 'id';
    }

    function insert($name, $date_start, $date_end, $day_start, $day_end, $retries,
            $num_complete, $total_calls, $recording, $status, $priority, $active_calls, $campaign_type = 'phn') {

        $data = array(
            'name' => $name,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'day_start' => $day_start,
            'day_end' => $day_end,
            'retries' => $retries,
            'num_complete' => $num_complete,
            'total_calls' => $total_calls,
            'recording' => $recording,
            'status' => $status,
            'priority' => $priority,
            'active_calls' => $active_calls,
            'campaign_type' => $campaign_type,  
        );

        $sql = 'insert into campaign (name, date_start, date_end, day_start, day_end,
                    retries, num_complete, total_calls, recording, status, priority, active_calls, campaign_type)
                values (:name, :date_start, :date_end, :day_start, :day_end,
                    :retries, :num_complete, :total_calls, :recording, :status, :priority, :active_calls, :campaign_type)';

        return $this->exclute_non_query($sql, $data);

    }

    function get_by_id($id)
    {
        $sql  = "select id, name, date_start, date_end, day_start, day_end, ";
        $sql .= "retries, num_complete, total_calls, recording, status, priority, active_calls, ";
        $sql .= "created from campaign where id = $id";
        return $this->get_one($sql);
    }

    function get_active_campaign()
    {
        $sql  = "select id, name, date_start, date_end, day_start, day_end, ";
        $sql .= "retries, num_complete, total_calls, recording, status, priority, active_calls, ";
        $sql .= "created from campaign where status = 'running' and campaign_type = 'phn' order by created limit 1";
        return $this->get_one($sql);
    }

    function get_running_campaigns()
    {
        $sql  = "select id, name, date_start, date_end, day_start, day_end, ";
        $sql .= "retries, num_complete, total_calls, recording, status, priority, active_calls, ";
        $sql .= "created from campaign where status = 'running' and campaign_type = 'phn' order by priority, created";
        return $this->get($sql);
    }

    function get_running_sms_campaigns()
    {
        $sql  = "select id, name, date_start, date_end, day_start, day_end, ";
        $sql .= "retries, num_complete, total_calls, recording, status, priority, active_calls, sms_message, use_amount, ";
        $sql .= "created from campaign where status = 'running' and campaign_type = 'sms' order by priority, created";
        return $this->get($sql);
    }

    function validate_date_range($id)
    {
        $sql  = "select id, name, date_start, date_end, day_start, day_end, ";
        $sql .= "retries, num_complete, total_calls, recording, status, priority, active_calls, ";
        $sql .= "created from campaign where id = $id and date_start <= now() and date_end >= now();";
        return $this->get($sql);
    }


    function validate_time_range($id)
    {
        $sql  = "select id, name, date_start, date_end, day_start, day_end, ";
        $sql .= "retries, num_complete, total_calls, recording, status, priority, active_calls, ";
        $sql .= "created from campaign where id = $id and day_start <= time(now()) and day_end >= time(now());";
        return $this->get($sql);
    }

    function get_available_calls_count($id)
    {
        $sql  = "select count(*) as call_count from calls where id_campaign = $id and (status = 'pending' or status = 'retry' or status like 'congested%');";
        $this->log->LogDebug('get_available_calls_count $sql: ' . $sql);
        return $this->get_one($sql);
    }

    function update_campaign_status($status, $id){
        $data = array(':status' => $status, ':id' => $id);
        $sql = 'update campaign set status = :status where id = :id';
        $this->log->LogDebug('update_campaign_status $sql: ' . $sql);
        return $this->exclute_non_query($sql, $data);
    }

    function update_num_completed($id, $num = 1){
        $data = array(':id' => $id, ':num' => $num);
        $sql = 'update campaign set num_complete = num_complete + :num where id = :id';
        $this->log->LogDebug('update_num_completed $sql: ' . $sql);
        return $this->exclute_non_query($sql, $data);
    }

            function increment_active_calls($id){
        $data = array(':id' => $id);
        $sql = 'update campaign set active_calls = active_calls + 1 where id = :id';
        $this->log->LogDebug('increment_active_calls $sql: ' . $sql);
        return $this->exclute_non_query($sql, $data);
    }

    function decrement_active_calls($id){
        $data = array(':id' => $id);
        $sql = 'update campaign set active_calls = active_calls - 1 where id = :id';
        $this->log->LogDebug('decrement_active_calls $sql: ' . $sql);
        return $this->exclute_non_query($sql, $data);
    }

    function get_all_active_calls_count(){
        $sql  = "select sum(active_calls) as active_calls from campaign where status = 'running' and campaign_type = 'phn';";
        $this->log->LogDebug('get_available_calls_count $sql: ' . $sql);
        $result = $this->get_one($sql);
        return $result->active_calls;

    }

    function update_campaign__num_completed(){
        $sql  = "update campaign set num_complete = total_calls where status = 'completed' and total_calls <= num_complete;";
        $this->log->LogDebug('update_campaign__num_completed $sql: ' . $sql);
        
        
        
        return $this->exclute_non_query($sql, array());
    }


	function update_campaign_active_calls($campaignid){

		$sql  = "update calls ";
		$sql .= "set active = 0, "; 
        $sql .= "end_time = date_add(start_time, interval 5 minute) ";
        $sql .= "where active = 1  ";
        $sql .= "and timestampdiff(minute, start_time, now()) > 5 "; 
        $sql .= "and end_time is null ";
        $sql .= "and id_campaign = $campaignid; ";
	
		$this->exclute_non_query($sql, null);	

		$sql  = "select count(*) as count ";
		$sql .= "from calls ";
        $sql .= "where active = 1  ";
        $sql .= "and id_campaign = $campaignid; ";

		$count = $this->get_one($sql);

		$this->log->LogError("sql: $sql");
		$this->log->LogError("count: $count->count");

		$sql  = "update campaign ";
		$sql .= "set active_calls = $count->count "; 
		$sql .= "where id = $campaignid; "; 

		$this->exclute_non_query($sql, null);	

	}

}

