<?php

/**
 * Description of Db_campaign
 *
 * @author jbastias
 */
class Db_campaign extends CI_Model {

    var $table;

    function  __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->table = 'campaign';
    }

    
    function insert_new_campaign($name, $date_start, $date_end, $day_start, $day_end, $retries,
            $total_calls, $recording, $priority, $recording2, $use_amount)
    {
        return $this->insert($name, $date_start, $date_end, $day_start, $day_end, $retries,
            0, $total_calls, $recording, 'pending', $priority, $recording2, $use_amount);
    }

    
    
    function insert_new_sms_campaign($name, $date_start, $date_end, $day_start, $day_end, $retries,
            $total_calls, $sms_message, $use_amount)
    {
        $priority = 1;
        return $this->insert($name, $date_start, $date_end, $day_start, $day_end, $retries,
            0, $total_calls, null, 'pending', $priority, null, $use_amount, 'sms', $sms_message);
    }

    
    
    
    function insert($name, $date_start, $date_end, $day_start, $day_end, $retries,
            $num_complete, $total_calls, $recording, $status, $priority, 
            $recording2, $use_amount, $campaign_type = 'phn', $sms_message = null) {

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
            'recording2' => $recording2,
            'status' => $status,
            'priority' => $priority,
            'campaign_type' => $campaign_type,
            'sms_message' => $sms_message,
            'use_amount' => $use_amount
        );

        //print_r($data);
        //exit();
        
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();

    }

    function get()
    {
        $results = $this->db->get($this->table);
        return $results->result();
    }

    function get_campaign_list($limit='all')
    {

        $this->db->order_by('created desc');

        if($limit == 'all')
            $results = $this->db->get($this->table);
        else
            $results = $this->db->get($this->table, $limit);
        //if(!$all)

        return $results->result();
    }


    function get_campaign_by_id($id)
    {
        $this->db->where('id', $id);
        $results = $this->db->get($this->table, 1);
        return $results->result();
    }

    function get_campaigns_by_id_list($id_list)
    {
        $this->db->where_in('id', $id_list);
        $results = $this->db->get($this->table);
        return $results->result();
    }


    function update_status($status, $id)
    {
        $data = array('status' => $status);
        $this->db->where('id', $id);
        //echo $this->db->
        $this->db->update('campaign', $data);
    }

    
    function update_total_call_count($id)
    {
        $this->db->query("update campaign set total_calls = (select count(*) from calls where id_campaign = $id) where id = $id;");
    }
    
    
    
    function get_server_date()
    {
        $results = $this->db->query('now() as now');
        return $results->result();
    }
    
    function delete_campaign($id)
    {
        // delete calls
        $this->db->where('id_campaign', $id);
        $this->db->delete('calls');
        
        // delete campaign record
        $this->db->where('id', $id);
        $this->db->delete('campaign');
        
    }

}