<?php

class App extends CI_Controller {

	function __construct()
    	{
            parent::__construct();

            $this->load->helper('language_strings_helper');

    	}

	function index()
	{
            $data = get_strings();

            $data['page_title'] = 'Home';
            $data['main_content'] = 'home/home';
            $this->parser->parse('includes/template', $data);
	}

        
}

/* End of file app.php */
/* Location: ./system/application/controllers/app.php */
