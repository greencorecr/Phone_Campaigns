<?php

class Campaigns extends CI_Controller {

        function __construct()
        {
            parent::__construct();

//            $this->output->enable_profiler(TRUE);            
            $this->load->helper('language_strings_helper');

            $this->load->model('db/db_calls');
            $this->load->model('db/db_campaign');

            $this->load->model('utils_model');
            $this->load->model('recording_model');
            $this->load->model('file_model');

            // libaries
            $this->load->library('form_validation');

            $config['upload_path'] = $this->config->item('upload_path');
            $config['allowed_types'] = 'xls|csv';
            $this->load->library('upload', $config);

        }

        function Index()
        {
            $data = get_strings();
            $data['campaigns'] = $this->db_campaign->get_campaign_list(); //100);
            $data['page_title'] = 'Campaigns';
            $data['main_content'] = 'campaigns/campaigns';
            $this->parser->parse('includes/template', $data);
        }

        function Campaign($id)
        {
            $data = get_strings();

            $campaign_arr = $this->db_campaign->get_campaign_by_id($id);
            $data['campaign'] = $campaign_arr[0];
            $data['page_title'] = 'Campaign';
            $data['main_content'] = 'campaigns/campaign';

            $this->parser->parse('includes/template', $data);
        }


        function Run($id)
        {
            $this->db_campaign->update_status('running', $id);
            redirect('campaigns');
        }



        function Pause($id)
        {
            $this->db_campaign->update_status('paused', $id);
            redirect('campaigns');
        }

        function Cancel($id)
        {
            $this->db_campaign->update_status('cancelled', $id);
            redirect('campaigns');
        }


        function Report($id){

            $data = get_strings();

            $campaign = $this->db_campaign->get_campaign_by_id($id);
            $campaign = $campaign[0];
            $campaign->calls = $this->db_calls->get_calls_by_campaignid($id);


            $data['campaign'] = $campaign;

            $data['page_title'] = 'Campaigns';
            $data['main_content'] = 'campaigns/new_campaign';
            $this->parser->parse('campaigns/report', $data);


        }

        function New_campaign($data_passed=null)
        {
            $data = get_strings();

            if(isset($data_passed))
                $data = array_merge ($data_passed);

            $data['hours'] = $this->utils_model->get_hours_list();
            $data['minutes'] = $this->utils_model->get_minutes_list();
            $data['recording']  = $this->recording_model->get_recording_list();
            $data['recording2']  = $this->recording_model->get_recording_list();

            // get the defaults for
            // start and end dates
            $data['default_start_date'] = $this->config->item('default_start_date');
            $data['default_end_date'] = $this->config->item('default_end_date');

            // start and end times
            $data['default_start'] = (object)(array(
                'hour' => $this->config->item('default_start_hour'),
                'minute' => $this->config->item('default_start_minute')));
            $data['default_end'] = (object)(array(
                'hour' => $this->config->item('default_end_hour'),
                'minute' => $this->config->item('default_end_minute')));

            // max-retries & default priority
            $data['default_max_retries'] = $this->config->item('default_max_retries');
            $data['default_priority'] = $this->config->item('default_priority');

            $data['page_title'] = 'Campaigns';
            $data['main_content'] = 'campaigns/new_campaign';
            $this->parser->parse('includes/template', $data);
        }

        function Validate_new()
        {
 
            $data = get_strings();

            // field name, error message, validation rules
            $this->form_validation->set_rules('name', 'Campaign name', 'trim|required');
            $this->form_validation->set_rules('date_start', 'Start date', 'required');
            $this->form_validation->set_rules('date_end', 'End date', 'required');
            $this->form_validation->set_rules('day_start_hour', 'Start time hours', 'required');
            $this->form_validation->set_rules('day_start_min', 'Start time minutes', 'required');
            $this->form_validation->set_rules('day_end_hour', 'End time hours', 'required');
            $this->form_validation->set_rules('day_end_min', 'End time minutes', 'required');
            $this->form_validation->set_rules('retries', 'Retries', 'trim|required|integer');
            $this->form_validation->set_rules('recording', 'Recording', 'required');
            //$this->form_validation->set_rules('userfile', 'File name', 'trim|required');
            $this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            $validated = $this->form_validation->run();

            $upload_validated = false;

            if($_FILES["userfile"]["name"])
            {
                // Do the file upload
                $upload_validated = $this->upload->do_upload();

                // Get upload errors
                //$errors
                $data['errors'] = $this->upload->display_errors();

                // Get upload data assuming no errors
                $upload_data= $this->upload->data();

                // move the uploaded temp working directory
                if($data['errors'] == '' && file($upload_data['full_path'])){
                    rename($upload_data['full_path'], $upload_data['file_path'] . 'temp/' . $upload_data['file_name'] );
                }
            }
            else
            {
                $data['errors'] = 'You must select a file (excel or cvs).';
            }

            if(!($validated && $upload_validated))
            {
                if(!isset($data)) $data = array();
                return $this->New_campaign($data);
            }
            $this->session->set_flashdata('upload_data', $upload_data);
            $this->session->set_flashdata('post_data', $_POST);
            redirect('campaigns/confirm_create_campaign');
        }

        
        function Validate_new_sms()
        {
            
            
            //print_r($_POST);
            //exit();
            
            
            $data = get_strings();

            // field name, error message, validation rules
            $this->form_validation->set_rules('name', 'Campaign name', 'trim|required');
            $this->form_validation->set_rules('date_start', 'Start date', 'required');
            $this->form_validation->set_rules('date_end', 'End date', 'required');
            $this->form_validation->set_rules('day_start_hour', 'Start time hours', 'required');
            $this->form_validation->set_rules('day_start_min', 'Start time minutes', 'required');
            $this->form_validation->set_rules('day_end_hour', 'End time hours', 'required');
            $this->form_validation->set_rules('day_end_min', 'End time minutes', 'required');
            $this->form_validation->set_rules('sms_message', 'SMS Message is required and must be shorter than 160 characters.', 'required|max_length[160]');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            $validated = $this->form_validation->run();

            $upload_validated = false;

            if($_FILES["userfile"]["name"])
            {
                // Do the file upload
                $upload_validated = $this->upload->do_upload();

                // Get upload errors
                $data['errors'] = $this->upload->display_errors();

                // Get upload data assuming no errors
                $upload_data = $this->upload->data();

                // move the uploaded temp working directory
                if($data['errors'] == '' && file($upload_data['full_path'])){
                    rename($upload_data['full_path'], $upload_data['file_path'] . 'temp/' . $upload_data['file_name'] );
                }

            }
            else
            {
                $data['errors'] = 'You must select a file (excel or cvs).';
            }

            if(!($validated && $upload_validated))
            {
                if(!isset($data))
                    $data = array();
                return $this->New_campaign($data);
            }

            $this->session->set_flashdata('upload_data', $upload_data);
            $this->session->set_flashdata('post_data', $_POST);
            redirect('campaigns/confirm_create_sms_campaign');
        }

        
        function confirm_create_campaign()
        {

            $data = get_strings();
            $data['_split_campaign_warning'] = str_replace('[batch_size]', 
                    $this->config->item('calls_insert_batch_size'), 
                    $data['_split_campaign_warning']);

            $data['upload_data'] = $this->session->flashdata('upload_data');
            $data['post_data'] = $this->session->flashdata('post_data');

            $this->session->set_flashdata('upload_data', $data['upload_data']);
            $this->session->set_flashdata('post_data', $data['post_data']);

            $upload_contents = $this->file_model->get_file_contents($data['upload_data']['file_name']);

            $data['summary'] = $this->file_model->get_summary_data($upload_contents);

            $data['calls_insert_batch_size'] = $this->config->item('calls_insert_batch_size');
            
            $this->_save_summary_data($data['summary']);

            $data['page_title'] = 'Confirm Create Campaign';
            $data['main_content'] = 'campaigns/confirm_create_campaign';
            $this->parser->parse('includes/template', $data);
        }

        function confirm_create_sms_campaign()
        {

            $data = get_strings();
//            $data['_split_campaign_warning'] = str_replace('[batch_size]', 
//                    $this->config->item('calls_insert_batch_size'), 
//                    $data['_split_campaign_warning']);

            $data['upload_data'] = $this->session->flashdata('upload_data');
            $data['post_data'] = $this->session->flashdata('post_data');

            $this->session->set_flashdata('upload_data', $data['upload_data']);
            $this->session->set_flashdata('post_data', $data['post_data']);

            $upload_contents = $this->file_model->get_file_contents($data['upload_data']['file_name']);

            $data['summary'] = $this->file_model->get_summary_data($upload_contents);

            $data['calls_insert_batch_size'] = $this->config->item('calls_insert_batch_size');
            
            $this->_save_summary_data($data['summary']);

            $data['page_title'] = 'Confirm Create Campaign';
            $data['main_content'] = 'campaigns/confirm_create_sms_campaign';
            $this->parser->parse('includes/template', $data);
        }

        
        
        function _save_summary_data($summary){

            $data = get_strings();

            $errors = "";
            if(!empty($summary['errors'])){
                foreach($summary['errors'] as $error){
                    $errors .= $error . "\n";
                }
            }

            file_put_contents('./upload/temp/upload_errors.txt',
                    $this->parser->parse_string($errors, $data, true));

            $phone_data = "";
            if(!empty($summary['valid'])){
                foreach($summary['valid'] as $valid){
                    $phone_data .= $valid . "\n";
                }
            }

            file_put_contents('./upload/temp/upload_data.txt',
                    $this->parser->parse_string($phone_data, $data, true));

        }

        function error_creating_campaign()
        {
            $data = get_strings();

            $data['page_title'] = 'Error Creating Campaign';
            $data['main_content'] = 'campaigns/error_create_campaign';

            $this->parser->parse('includes/template', $data);
        }


        function Finalize_create_campaign($run=null)
        {
            $upload_data = $this->session->flashdata('upload_data');
            $post_data = $this->session->flashdata('post_data');
            
            if($upload_data == null || $post_data == null){
                 redirect('campaigns/error_creating_campaign');
            }
            $this->_create_campaign($upload_data['file_name'], $post_data, $run);
            
            redirect('campaigns');

        }

        function Finalize_create_sms_campaign($run=null)
        {
            $upload_data = $this->session->flashdata('upload_data');
            $post_data = $this->session->flashdata('post_data');
            
            if($upload_data == null || $post_data == null){
                 redirect('campaigns/error_creating_campaign');
            }
            $this->_create_sms_campaign($upload_data['file_name'], $post_data, $run);

            redirect('campaigns');
            
        }
        
        
        

        function _create_campaign($filename, $post_data, $run){

            $upload_contents = $this->file_model->get_file_contents($filename);
            $batch_size = $this->config->item('calls_insert_batch_size');
            
            $ids = array();
            $counter = 0;
            $batch = 0;
            $incluce_amount = isset($post_data['include_amount']) ? true : false;
            foreach($upload_contents as $row)
            {
                $campaign_name = $post_data['name'];
                if($batch > 0) $campaign_name .= " $batch";
                
                if($counter == 0){
                    $campaign_id = $this->db_campaign->insert_new_campaign(
                            $campaign_name,
                            date('Y-m-d', strtotime($post_data['date_start'])),
                            date('Y-m-d', strtotime($post_data['date_end'])),
                            $post_data['day_start_hour'] . ':' . $post_data['day_start_min'],
                            $post_data['day_end_hour'] . ':' . $post_data['day_end_min'],
                            $post_data['retries'],
                            0,
                            $post_data['recording'],
                            $post_data['priority'],
                            $post_data['recording2'],
                            $incluce_amount
                    );
                    $ids[] = $campaign_id;
                }
                $counter++;
                if($counter >= $batch_size){
                    $counter = 0;
                    $batch++;
                }

                $phone = $row[0];
                $amount = null; 
                if(count($row) >= 2 && $incluce_amount)
                    $amount = $row[1];
                if($this->file_model->is_row_valid($row))
                        $this->db_calls->insert_new_call($campaign_id, $phone, $amount);

            }

            // update calls
            foreach ($ids as $id){
                $this->db_campaign->update_total_call_count($id);
            }
            
            if($run) {
                $this->db_campaign->update_status('running', $campaign_id);
            }
        }

        
        function _create_sms_campaign($filename, $post_data, $run){

            $upload_contents = $this->file_model->get_file_contents($filename);
            $batch_size = $this->config->item('calls_insert_batch_size');
            
            $ids = array();
            $counter = 0;
            $batch = 0;
            $incluce_amount = isset($post_data['include_amount']) ? true : false;
            foreach($upload_contents as $row)
            {
                $campaign_name = $post_data['name'];
                if($batch > 0) $campaign_name .= " $batch";
                
                if($counter == 0){
                    $campaign_id = $this->db_campaign->insert_new_sms_campaign(
                            $campaign_name,
                            date('Y-m-d', strtotime($post_data['date_start'])),
                            date('Y-m-d', strtotime($post_data['date_end'])),
                            $post_data['day_start_hour'] . ':' . $post_data['day_start_min'],
                            $post_data['day_end_hour'] . ':' . $post_data['day_end_min'],
                            0,
                            0,
                            $post_data['sms_message'],
                            $incluce_amount
                    );
                    $ids[] = $campaign_id;
                }
                $counter++;
                if($counter >= $batch_size){
                    $counter = 0;
                    $batch++;
                }

                $phone = $row[0]; $amount = null; if(count($row) >= 2 && $incluce_amount) $amount = $row[1];
                if($this->file_model->is_row_valid($row))
                        $this->db_calls->insert_new_call($campaign_id, $phone, $amount);
            }

            // update calls
            foreach ($ids as $id){
                $this->db_campaign->update_total_call_count($id);
            }
            
            if($run) {
                $this->db_campaign->update_status('running', $campaign_id);
            }
        }
        
        
        
        
        function Update_active_campaigns($running_ids=null){
            $id_list = explode('~', $running_ids);
            $campaigns = $this->db_campaign->get_campaigns_by_id_list($id_list);
            header("content-type: application/json");
            echo json_encode($campaigns);
        }
        
        function Delete_campaign($id){
            $campaigns = $this->db_campaign->delete_campaign($id);
            redirect('campaigns');
        }

        function Send_sms()
        {

            $data = get_strings();

            $data['sms_test_phone_number'] = $this->config->item('sms_test_phone_number');
            $data['sms_test_message'] = $this->config->item('sms_test_message');
            
            $data['page_title'] = 'Send SMS';
            $data['main_content'] = 'campaigns/send_sms';
            $this->parser->parse('includes/popup_template', $data);
        }
        
        function Ajax_send_sms()
        {
            $this->output->enable_profiler(false);            
            
            //$tmpfname = tempnam($this->config['temp_dir'], $this->config['file_prefix']);
            $tmpfname = tempnam('/tmp', 'sendsms_');

            // get template contents
           //            $call_file = file_get_contents('/var/www/phase2/phone_campaigns.gc/assets/sms_template.txt');
            $call_file = file_get_contents('/var/www/html/phone_campaigns/assets/sms_template.txt');
            $call_file = str_replace('{phone_number}', $_POST['phone_number'], $call_file);
            $call_file = str_replace('{message}', $_POST['message'], $call_file);
            file_put_contents($tmpfname, $call_file);

//            system('sudo chown smsd:root '.$tmpfname);
            system('sudo mv '.$tmpfname.' /var/spool/sms/outgoing/'.str_replace('/tmp/', '', $tmpfname));
           
            header("content-type: application/json");
            $result = new stdClass();
            $result->phone =  isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
            $result->msg = isset($_POST['message']) ? $_POST['message'] : '';
            $result->file_contents = $call_file;
            echo json_encode($result);
        }

}

/* End of file campaigns.php */
/* Location: ./system/application/controllers/campaigns.php */

