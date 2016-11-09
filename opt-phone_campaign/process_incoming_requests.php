<?php

error_reporting(E_ALL);

require_once dirname(__FILE__) . '/' . 'logWrapper.php'; 

require_once $config['db_code_path'] . '/' . 'enums.php';
require_once $config['db_code_path'] . '/' . 'abstract_dal.php';
require_once $config['db_code_path'] . '/' . 'db_campaign.php';
require_once $config['db_code_path'] . '/' . 'db_calls.php';

/**
 * Description of process_incoming_requests
 *
 * @author jbastias
 */
class process_incoming_requests {

    var $status_codes = array(
        '000' => 'NUEVO',
        '001' => 'Aprobado',
        '003' => 'RECHAZADO',
        '004' => 'SUSPENSO',
        '005' => 'DEVUELTO',
        '006' => 'AUTORIZADO',
        '007' => 'CUMPLE REQUISITOS',
        '008' => 'ADJUNTAR Y REVISAR',
        );
    
    function process_request(){
        
        logDebug("get all the files in the inbound dir\n");
        
    }
    
}

?>
