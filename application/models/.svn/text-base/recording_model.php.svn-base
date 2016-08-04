<?php

/**
 * Description of Recording_model
 *
 * @author jbastias
 */
class Recording_model extends CI_Model {

    function  __construct() {
        parent::__construct();
    }

    function get_recording_list()
    {
        $this->load->helper('directory');
        $dir = $this->config->item('recordings_dir');
        $map = directory_map($dir);
        $files = array('' => '{_choose_recording}');
        foreach($map as $file)
        {
            if(is_array($file) || $file == '') continue;
            $files[$file] = $file;
        }
        return $files;
    }
   
}