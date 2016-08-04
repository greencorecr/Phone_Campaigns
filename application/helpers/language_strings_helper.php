<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_strings'))
{
    function get_strings(){
        $CI =& get_instance();
        $CI->load->library('parser');
        $lang = $CI->lang->load('strings', $CI->config->item('language'), true);
        return $lang;
    }
}

if ( ! function_exists('translate_campaign_status'))
{
    function translate_campaign_status($status){

        $CI =& get_instance();

        $lang = $CI->config->item('language');

        if($lang == 'english')
            return $status;

        $campaign_status_dictory = array(
            'pending' => 'pendiente',
            'running' => 'en progreso',
            'paused' => 'en pausa',
            'completed' => 'completado',
            'cancelled' => 'cancelado',
            );

        if($lang == 'spanish')
            return $campaign_status_dictory[$status];

        return $status;

    }
}

if ( ! function_exists('translate_call_status'))
{
    function translate_call_status($status){

        $CI =& get_instance();

        $lang = $CI->config->item('language');

        if($lang == 'english')
            return $status;

        $call_status_dictory = array(
            'pending' => 'pendiente',
            'answered' => 'contestada',
            'confirmed' => 'confirmada',
            'retry' => 'reintentar',
            'failed' => 'fallida',
            'congested' => 'congestionado',
            );

        if($lang == 'spanish')
            return $call_status_dictory[$status];

        return $status;

    }
}
