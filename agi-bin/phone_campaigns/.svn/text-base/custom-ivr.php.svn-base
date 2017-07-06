#!/usr/bin/php -q
<?
set_time_limit(30);
require_once 'phpagi.php';
require_once 'KLogger.php';
require_once 'config.php';

error_reporting(E_ALL);

$log = new KLogger ( __FILE__.".log" , $config['custmer-ivr_log-level'] );
$log->LogDebug('config: ' . print_r($config, true));

try
{
    $agi = new AGI();

    $log->LogDebug('agi request: ' . print_r($agi->request, true));
   
    $attempts = 1;
    $valid_cedula = true;
    do{
        if($attempts >= 2){
            $log->LogDebug('3 attempts failed, exiting script');
            return;
        }
        $attempts++;
        $log->LogDebug('attempts: ' . $attempts);

//        $agi->stream_file('custom/ivr/marque-su-numero-de-cedula-seguido-tecla-numeral');

//        $agi->exec('READ', 'cedula');
        $cedula = _get_var('cedula');
$log->LogDebug('Cedula: ' . $cedula);
        if(strlen($cedula) < 9){
            $agi->stream_file("custom/ivr/marcacion-invalida-intente-de-nuevo");
            $log->LogDebug('invalid cedula length: ' . $cedula);
            $valid_cedula == false;
        } else {
            break;
        }

    } while(true);

    $amount = get_amount_from_server($cedula);
    $log->LogDebug('final amount: ' . $amount);

    if($amount == null){
        // $agi->exec('PlayBack nobody-but-chickens&north-carolina');
        $log->LogWarn('error getting the amount, exiting script');
	$amount = '0';
    }

    if($amount > 0) {
        $agi->stream_file('custom/ivr/la-muni-informa-que-debe');
        $agi->say_number($amount);
        $agi->stream_file('custom/ivr/colones');
    } else {
        $agi->stream_file('custom/ivr/no-deudas');
    }

} catch(Exception $e) {

    $log->LogFatal(" something went wrong " . print_r($e, true));
}

/**
 *  Function:   get_amount_from_server
 *
 *  Description:
 *  - prepares request
 *  - send request and recieve response
 *  - parse response
 *  - return amount
 *
 *  @string $cedula
 *
 *  @return number amount
 *
 */
function get_amount_from_server($cedula){

    global $log, $config, $agi;

    $url = $config['muni_url'];

    $request = prepare_request($cedula);

    $response = send_request($url, $request);

    $amount = null;
    if(empty($response) == true){
        $agi->stream_file('custom/ivr/error-al-marcar-numero-de-cedula');
        $log->LogInfo('empty reponse: ' . $cedula);
    } else if(strstr($response, '<h2>La Cedula no existe en la Base de Datos</h2>')) {
        //$agi->stream_file('custom/no-cedula-en-bd');
        $agi->stream_file('custom/ivr/no-deuda');
        $log->LogInfo('no existe la cedula en la base de datos: ' . $cedula);
    } else {
        $amount = parse_result($response);
        //$amount = '1.0060404E7';
        if(strstr($amount, 'E')){
            $pos = strpos($amount, 'E');
            $num = substr($amount, 0, $pos);
            $exp = substr($amount, $pos + 1);

            $log->LogDebug("convert scientific notation: $amount - $pos - $num - $exp");
            $amount = $num * pow(10, $exp);
        }

        if($amount == null) $log->LogInfo('the cedula returned a null amount: ' . $cedula);
    }
    return $amount;
}


/**
 *  Function:   prepare_request
 *
 *  Description:
 *  - prepares request
 *
 *   cedula types:
 *      01 - Física
 *      02 - Jurídica
 *      03 - Residencia
 *
 *  @string $cedula
 *
 *  @return number amount
 *
 */
function prepare_request($cedula){

    global $log;

    $kind_of_cedula = '02';
    if(strlen($cedula) == 9) {
        $kind_of_cedula = '01';
    }

    $request  = "cboTipo=$kind_of_cedula";
    $request .= "&txtCedula=$cedula";

    $log->LogDebug('request: ' . $request);

    return $request;

}

/**
 *  Function:   send_request
 *
 *  Description:
 *  - sends request to the server
 *  - send request and recieve response
 *
 *  @string $url
 *  @string $request
 *
 *  @return string response content
 *
 */
function send_request($url, $request){

    global $log;

    $log->LogDebug('url: ' . $url);

    $opts = array(
        'http' => array(
            'method' => "POST",
            'header' => "User-Agent: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; bgft)\r\n" .
                        "Content-type: application/x-www-form-urlencoded\r\n" .
                        "Content-length: " . strlen($request)."\r\n",
            'content' => $request
            )
        );

    $log->LogDebug('opts: ' . print_r($opts, true));

    $context = stream_context_create($opts);

    $fp = fopen($url, 'r', false, $context);

    if($fp){
  
        $result = "";
        if($fp) {
            while($fp && !feof($fp)){
                $result .= fread($fp, 4096);
            }
            fclose($fp);
        }

        $log->LogDebug('result: ' . $result);

        return $result;
    } else {
        $log->LogError('able to get results from the server, url: ' . $url);
    }

    return null;

}

/**
 *  Function:   parse_result($html)
 *
 *  Description:
 *  - parse the html response content
 *  - returns amount
 *
 *  @string $html
 *
 *  @return number amount
 *
 */
function parse_result($html){

    global $log;

    $pattern = "/<input type='text' name='txtTotal' value= '(.*)' disabled = 'disabled' size='50' \/>/";
    $subject = $html;

    $log->LogDebug('pattern : ' . $pattern );

    preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);

    $log->LogDebug('matches: ' . print_r($matches, true));

    if(!empty($matches[1]))
        return $matches[1][0];

    return null;
}

/**
 *  Function:   _get_var($varname)
 *
 *  Description:
 *  - get varaible using agi and parses the value
 *
 *  @string $varname
 *
 *  @return variable value
 *
 */
function _get_var($varname){

    global $log, $agi;

    $result = $agi->get_variable($varname);
    $log->LogDebug($varname.'_result: ' . print_r($result, true));

    $result_data = $result['data'];
    $log->LogDebug($varname.': ' . $result_data);

    return $result_data;

}

?>

