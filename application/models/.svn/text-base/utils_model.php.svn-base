<?php

/**
 * Description of Utils_model
 *
 * @author jbastias
 */
class Utils_model extends CI_Model {

    function  __construct() {
        parent::__construct();
    }

    function get_hours_list(){
        $hours = array('' => 'HH');
        for($hour = 0; $hour < 24; $hour++){
            if($hour < 10) $hour = '0' . $hour;
            $hours[$hour] = $hour;
        }
        return $hours;
    }

    function get_minutes_list(){
        $mins = array('' => 'MM');
        for($min = 0; $min < 60; $min++){
            if($min < 10) $min = '0' . $min;
            $mins[$min] = $min;
        }
        return $mins;
    }
    
}