<?php

/**
 * Description of File_model
 *
 * @author jbastias
 */
class File_model extends CI_Model {

    var $summary;
    var $include_amount;

    function  __construct() {
        parent::__construct();
        $this->summary = array(
            'total_rows' => 0,
            'valid_rows' => 0,
            'errors' => array(),
            'valid' => array()
        );
    }

    /*
     *
     */
    function get_summary_data($data)
    {
        foreach($data as $row)
        {
            $this->summary['total_rows']++;
            $is_valid = $this->is_row_valid($row);
            if($is_valid['result']) {
                $this->summary['valid_rows']++;
                $this->summary['valid'][] = $is_valid['row_content'];
            }
            else
                $this->summary['errors'][] = $is_valid['error_msg'] . '[' . $is_valid['row_content'] . ']';
        }
        return $this->summary;
    }


    /*
     *
     */
    function is_row_valid($row)
    {
        $phone = $row[0];
        $row_content = "$phone";
        
        if($this->include_amount && count($row) >= 2){
            $amount = $row[1];
            $row_content .= ", $amount";
        }
        
        $return = array(
            'result' => true,
            'error_msg' => '',
            'row_content' => $row_content
        );

        // 8 digit phone number
        if(strlen($phone) != 8){
            $return['result'] = false;
            $return['error_msg'] = '{_error_invalid_phone}';
            return $return;
        }

        // phone all digits
        if(!ctype_digit($phone)){
            $return['result'] = false;
            $return['error_msg'] = '{_error_invalid_phone_digits}';
            return $return;
        }

        // amount is numeric
        if($this->include_amount){
            if(count($row) < 2 || !is_numeric($amount)){
                $return['result'] = false;
                $return['error_msg'] = '{_error_invalid_amount}';
                return $return;
            }
        }
       
        return $return;
    }

    /*
     *
     */
    function get_file_contents($filename)
    {
        $pd = $this->session->flashdata('post_data');
        $this->include_amount = isset($pd['include_amount']) + 0;
        $ext = substr(strrchr($filename, '.'), 1);
        switch ($ext)
        {
            case 'xls':
                $data = $this->get_excel_file_contents($filename);
                break;
            case 'csv':
                $data = $this->get_csv_file_contents($filename);
                break;
            default:
                $data = array();
        }
        return $data;
    }

    /*
     *
     */
    function get_csv_file_contents($file)
    {
        $csv_data = array();
        if (($handle = fopen('./upload/temp/' . $file, "r")) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                $csv_data[] = $row;
            }
            fclose($handle);
        }
        return $csv_data;
    }

    /*
     *
     */
    function get_excel_file_contents($file)
    {
        require_once './assets/Excel/reader.php';

        // ExcelFile($filename, $encoding);
        $xls = new Spreadsheet_Excel_Reader();

        // Set output Encoding.
        $xls->setOutputEncoding('CP1251');

        $xls->read('./upload/temp/' . $file);

        $numCols = $xls->sheets[0]['numCols'];
        $numRows = $xls->sheets[0]['numRows'];
        $xlsCells = $xls->sheets[0]['cells'];

        $xls_data = array();
        for( $i = 1; $i <= $numRows; $i++ ) {
            $row = array();
            for( $j = 1; $j <= $numCols; $j++ ) {
                if(isset($xlsCells[$i][$j]))
                    $row[] = $xlsCells[$i][$j];
            }
            $xls_data[] = $row;
        }
        return $xls_data;
    }
}
