<?php

/**
 * Description of Db_calls
 *
 * @author jbastias
 */
class Db_calls extends CI_Model {

    var $table;

    function  __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->table = 'calls';
    }



    function insert_new_call($id_campaign, $phone, $amount_owed)
    {

        return $this->insert($id_campaign, $phone, $amount_owed, 'pending', '', null,
                    null, null, 0, 0);

     }




    function insert($id_campaign, $phone, $amount_owed, $status, $uniqueid, $call_date,
                    $start_time, $end_time, $retries, $duration)
    {

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
        );

        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }
    
    function get()
    {
        $results = $this->db->get($this->table);
        return $results->result();
    }

    function get_calls_by_campaignid($campaignid)
    {
        $this->db->where('id_campaign', $campaignid);
        $results = $this->db->get($this->table);
        return $results->result();
    }


    
}