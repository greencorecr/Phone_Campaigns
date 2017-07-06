<?php

class calls_table extends abstract_dal
{

    function __construct() {

        parent::__construct();

        $this->table = 'calls';
        $this->fields = 'id, id_campaign, phone, amount_owed, status, uniqueid, call_date, start_time, end_time, retries, duration, active';
        $this->keys = 'id';

    }

    function insert($id_campaign, $phone, $amount_owed, $status, $uniqueid, $call_date,
                    $start_time, $end_time, $retries, $duration, $active) {

        $data = array(
            'id_campaign' => $id_campaign,
            'phone' => $phone,
            'amount_owed' => $amount_owed,
            'status' => $status,
            'uniqueid' => $uniqueid,
            'call_date' => $call_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'retries' => $retries,
            'duration' => $duration,
            'active' => $active,
        );

        $sql = 'insert into calls (id_campaign, phone, amount_owed, status, uniqueid,
                    call_date, start_time, end_time, retries, duration, active)
                values (:id_campaign, :phone, :amount_owed, :status, :uniqueid,
                    :call_date, :start_time, :end_time, :retries, :duration, :active)';

        return $this->exclute_non_query($sql, $data);

    }


    function update($id_campaign, $phone, $amount_owed, $status, $uniqueid, $call_date,
                    $start_time, $end_time, $retries, $duration, $active) {

        $data = array(
            'id_campaign' => $id_campaign,
            'phone' => $phone,
            'amount_owed' => $amount_owed,
            'status' => $status,
            'uniqueid' => $uniqueid,
            'call_date' => $call_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'retries' => $retries,
            'duration' => $duration,
            'active' => $active,
        );

        $sql = 'insert into calls (id_campaign, phone, amount_owed, status, uniqueid,
                    call_date, start_time, end_time, retries, duration, active)
                values (:id_campaign, :phone, :amount_owed, :status, :uniqueid,
                    :call_date, :start_time, :end_time, :retries, :duration, :active)';

        return $this->exclute_non_query($sql, $data);

    }


    function get_next_call_old($campaignid)
    {
        $sql  = "select id, id_campaign, phone, amount_owed, status, uniqueid, ";
        $sql .= "call_date, start_time, end_time, retries, duration, active from calls ";
        $sql .= "where id_campaign = $campaignid and (status = 'pending' ";
        $sql .= "or status = 'retry')";
        return $this->get_one($sql);
    }


    function get_next_call($campaignid, $hours)
    {
        $sql  = "select id, id_campaign, phone, amount_owed, status, uniqueid, ";
        $sql .= "call_date, start_time, end_time, retries, duration, active from calls ";
        $sql .= "where id_campaign = $campaignid and active = false and (status = 'pending' ";
//        $sql .= "where id_campaign = $campaignid and (status = 'pending' ";
//        $sql .= "or (status = 'retry' and now() >= date_add(start_time, interval $hours hour))) ";
        $sql .= "or (status = 'retry' and now() >= date_add(start_time, interval 1 minute)) ";
        $sql .= "or (status = 'congested' and now() >= date_add(start_time, interval 1 minute))) ";
        $sql .= "order by status, retries";
        return $this->get_one($sql);
    }


    function get_call_by_campaign_and_number($campaignid, $number)
    {
        $sql  = "select id, id_campaign, phone, amount_owed, status, uniqueid, ";
        $sql .= "call_date, start_time, end_time, retries, duration, active from calls ";
        $sql .= "where id_campaign = $campaignid and phone = '$number'";
        return $this->get_one($sql);
    }


    function get_call_by_callid($id)
    {
        $sql  = "select id, id_campaign, phone, amount_owed, status, uniqueid, ";
        $sql .= "call_date, start_time, end_time, retries, duration, active from calls ";
        $sql .= "where id = $id";
        return $this->get_one($sql);
    }
    
    function get_pending_sms_calls_count_by_campaignid($campaignid){
        $sql  = "select count(*) as pending from calls ";
        $sql .= "where id_campaign = $campaignid and call_file is null; ";
        $calls = $this->get_one($sql);
        return $calls->pending;
    }
    
    
    function get_sms_calls_by_campaignid($campaignid, $batch_size){
        $sql  = "select id, id_campaign, phone, amount_owed from calls ";
        $sql .= "where id_campaign = $campaignid and call_file is null limit $batch_size; ";
        return $this->get($sql);
    }

    function get_sms_calls_sent_by_campaignid($campaignid){
        $sql  = "select id, call_file from calls ";
        $sql .= "where id_campaign = $campaignid and call_file is not null and call_file_sent = false; ";
        return $this->get($sql);
    }
    
    
    
    function update_call_answered($uniqueid, $id)
    {
        $sql  = "update calls set status = 'answered', uniqueid = :uniqueid, call_date = now(), start_time = now() ";
        $sql .= "where id = :id ";

        $this->exclute_non_query($sql, array(':uniqueid' => $uniqueid, ':id' => $id));
    }


    function update_call_not_answered($call, $max_retries, $uniqueid)
    {
        // not answered, schedule retry
        if($call->status == 'pending' || $call->status == 'retry' || $call->status == 'congested'){
            $status = 'retry';
            $retries = $call->retries + 1;
        }

        // fail if reached max retries
        if($retries > $max_retries){
            $status = 'failed';
            $retries--;
        }

        $sql  = "update calls set status = :status, retries = :retries, uniqueid = :uniqueid, call_date = now(), start_time = now() ";
        $sql .= "where id = :id ";

        $this->exclute_non_query($sql, array(':status' => $status, ':retries' => $retries, ':uniqueid' => $uniqueid, ':id' => $call->id));
    }




    function update_call_status($status, $uniqueid, $id)
    {
        $sql  = "update calls set status = :status, uniqueid = :uniqueid, call_date = now(), start_time = now() ";
        $sql .= "where id = :id ";

        $this->exclute_non_query($sql, array(':status' => $status, ':uniqueid' => $uniqueid, ':id' => $id));
    }


    function update_call_end($id)
    {
        $sql  = "update calls set end_time = now(), duration = time_to_sec(timediff(now(),start_time)) ";
        $sql .= "where id = :id ";

        $this->exclute_non_query($sql, array(':id' => $id));
    }

    function update_call_active($id)
    {
        $sql  = "update calls set active = true ";
        $sql .= "where id = :id ";
        $this->log->LogDebug('update_call_active $sql: ' . $sql);
        $this->exclute_non_query($sql, array(':id' => $id));
    }

    function update_call_sendsms($id, $call_file)
    {
        $sql  = "update calls set call_file = :call_file, status = 'sent', call_date = now(), ";
        $sql .= "start_time = now(), end_time = now() ";
        $sql .= "where id = :id ; ";
        
        $this->log->LogDebug('update_call_sendsms $sql: ' . $sql);
        $this->exclute_non_query($sql, array(':id' => $id, 'call_file' => $call_file));
    }
    
    function update_call_sms_sent($id)
    {
        $sql  = "update calls set status = 'confirmed', call_file_sent = true ";
        $sql .= "where id = :id ; ";
        
        $this->log->LogDebug('update_call_sendsms $sql: ' . $sql);
        $this->exclute_non_query($sql, array(':id' => $id));
    }
    
    
    function update_call_not_active($id)
    {
        $sql  = "update calls set active = false ";
        $sql .= "where id = :id ";
        $this->log->LogDebug('update_call_not_active $sql: ' . $sql);
        $this->exclute_non_query($sql, array(':id' => $id));
    }

    function update_call_congested($id)
    {
        $sql  = "update calls set status = 'congested', start_time = now() ";
        $sql .= "where id = :id ";
        $this->log->LogDebug('update_call_not_active $sql: ' . $sql);
        $this->exclute_non_query($sql, array(':id' => $id));
    }


}

