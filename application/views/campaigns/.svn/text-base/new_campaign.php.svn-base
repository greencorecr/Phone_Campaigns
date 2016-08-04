<div id="container">
    <h2>{_title_new_campaign}</h2>

     <div class="main_content">

        <div id="campaign_form">
        <?=validation_errors();?>
        <?php if(isset($errors)) echo  "<div class='error'>$errors</div>"; ?>

        <?=form_open_multipart('campaigns/validate_new');?>
        
        <div class="div_labels"><?=form_label('{_campaign_label_type}: ', 'campaign_type');?></div>
        <div class="div_inputs"><?=form_radio(array(
            'id' => 'campaign_type'
           ,'name' => 'campaign_type'
           ,'value' => 'phn'
           ,'checked' => 'checked'));?> phone Campaign
        <?=form_radio(array(
            'id' => 'campaign_type'
           ,'name' => 'campaign_type'
           ,'value' => 'sms'));?> SMS Campaign
        </div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_name}: ', 'name');?></div>
        <div class="div_inputs"><?=form_input('name', set_value('name', ''));?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_start}: ', 'date_start');?></div>
        <div class="div_inputs"><?=form_input(array(
                    'type' => 'date', 'id' => 'date_start', 'name' => 'date_start'
                   ,'value' => set_value('date_start', $default_start_date)
                   ,'style' => 'width: 85px'));?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_end}: ', 'date_end');?></div>
        <div class="div_inputs"><?=form_input(array(
                    'type' => 'date', 'id' => 'date_end', 'name' => 'date_end'
                   ,'value' => set_value('date_start', $default_end_date)
                   ,'style' => 'width: 85px'));?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_hour_start}: ', 'day_start_hour');?></div>
        <div class="div_inputs"><?=form_dropdown('day_start_hour', $hours, $default_start->hour);?>:
                                <?=form_dropdown('day_start_min', $minutes, $default_start->minute);?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_hour_end}: ', 'day_end_hour');?></div>
        <div class="div_inputs"><?=form_dropdown('day_end_hour', $hours, $default_end->hour);?>:
                                <?=form_dropdown('day_end_min', $minutes, $default_end->minute);?></div><div class="clearfix"></div>

        <div id="phone_campaign">
                                
            <div class="div_labels"><?=form_label('{_campaign_label_retries}: ', 'retries');?></div>
            <div class="div_inputs"><?=form_input('retries', set_value('retries', $default_max_retries), 'style="width: 50px;"');?></div><div class="clearfix"></div>
            <div class="div_labels"><?=form_label('{_campaign_label_recording}: ', 'recording');?></div>
            <div class="div_inputs"><?=form_dropdown('recording', $recording);?>
            <br /><a id="showRecording2" href="#">{_show_additional_recording}</a>
            </div><div class="clearfix"></div>

            <div class="div_labels" style="display: none;"><?=form_label('{_campaign_label_recording2}: ', 'recording2');?></div>
            <div class="div_inputs" style="display: none;"><?=form_dropdown('recording2', $recording2);?></div><div class="clearfix"  style="display: none;"></div>

        </div>
                                
        <div class="div_labels"><?=form_label('{_use_amount}:', 'include_amount');?></div>
        <div class="div_inputs"><?=form_checkbox('include_amount', 'true', true);?>
            <span id='sms_amount_message' style='display: none;'>{_sms_message_amount}</span></div><div class="clearfix"></div>
                                
        <div id="sms_campaign" style="display: none;">
        
            <div class="div_labels"><?=form_label('{_campaign_label_sms_message}: ', 'sms_message');?></div>
            <div class="div_inputs"><?=form_textarea(array(
                     'name' => 'sms_message'
                    ,'id' => 'sms_message'
                    ,'rows' => '3'
                    ,'cols' => '55'
                    ,'value' => set_value('sms_message', '')));?>
                    <img id="send_test_sms" src="<?php echo base_url(); ?>assets/images/mailIcon.png"></div>
            <div class="clearfix"></div>
            
        </div>

        <div class="div_labels"><?=form_label('{_campaign_label_file}: ', 'userfile');?></div>
        <div class="div_inputs"><?=form_upload('userfile');?><img id="question" src="<?php echo base_url(); ?>assets/images/question_mark_icon.gif"></div><div class="clearfix"></div>
        
        <div class="div_labels"><?=form_label('{_campaign_label_priority}: ', 'priority');?></div>
        <div class="div_inputs"><?=form_input('priority', set_value('priority', $default_priority), 'style="width: 50px;"');?></div><div class="clearfix"></div>
        <div class="div_labels">&nbsp;</div>
        <div class="div_inputs"><?=form_submit(array('id' => 'submit', 'name' => 'submit',
            'value' => '{_button_submit}'));?></div><div class="clearfix"></div>
        <?=form_close();?>
        </div>  

    </div>

</div>

<div id="basic-modal-content">
    <h1>{_popup_title}</h1>
    <p>{_popup_content}</p>
    {_sample_csv}:<br />
    <div style="background-color: #eeeeee; color: #000000; border: solid 1px black;">
    <pre>
    "87651234", "2310.95"
    "88773344", "223105.07"
    ...
    </pre>
    </div>
    {_sample_xls}:<br />
    <img src="<?php echo base_url(); ?>assets/images/sample_excel.jpg">
</div>

<div id="send_test_sms_message">
    <iframe src="<?php echo base_url(); ?>campaigns/send_sms" style='width: 100%; height: 350px;'></iframe> 
</div>

<!-- preload the images -->
<div style='display:none'>
        <img src='<?php echo base_url(); ?>assets/images/x.png' alt='' />
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/jquery.simplemodal.js"></script>

<script type="text/javascript" language="javascript">

var initPage = function(){
    var campaign_type = 'phn';
    var recording2 = null;
    <?php
        if(isset($_POST['campaign_type']))
            echo 'campaign_type = \''.$_POST['campaign_type'].'\';'."\n";
        if(isset($_POST['recording2']) && $_POST['recording2'] )
            echo "recording2 = 'show';\n";
    ?>
    if(campaign_type == 'sms'){
        $('input[name=campaign_type][value=sms]').attr('checked', 'checked');
    }
    if($('input[type=radio]:checked').val() == 'sms') show_sms();
    
    if(recording2){
        $('#showRecording2').trigger('click');
    }
    
}


var show_sms = function(){
    $("#phone_campaign").hide();
    //$('input[name=include_amount]').attr('checked', false);
    $("#sms_campaign").show();
    $("#sms_amount_message").show();
};

var show_phn = function(){
    $("#phone_campaign").show();
    $("#sms_campaign").hide();
    $("#sms_amount_message").hide();
};

$(document).ready(function(){

    $("#date_start").dateinput();
    $("#date_end").dateinput();

    $('#submit').click(function(){
        var $form = $('form:first');
        var $action = $form.attr('action');
        var $type = $('#campaign_type:checked').val();
        if($type == 'sms'){
            if(!$action.match('_sms$')) $action += '_sms';
        } else {
            $action = $action.replace('_sms', '');
        }
        $form.attr('action', $action);
    });

    $('#question').hover(function(){
           $(this).css("cursor", "pointer"); 
        },
        function(){
           $(this).css("cursor", "default");
        }
     ).click(function(){
        $('#basic-modal-content').modal();
        return false;
    });

    $('#send_test_sms').hover(function(){
           $(this).css("cursor", "pointer");  
        },
        function(){
           $(this).css("cursor", "default");
        }
     ).click(function(){
        $('#send_test_sms_message').modal();
        return false;
    });

    $('#showRecording2').click(function(){
        var $this = $(this);
        var $first = $this.parent().next().next();
        var $select = $first.next().children('select');
        if($first.is(':visible')){
            $select.val('');
            $first.hide().next().hide().next().hide();
            $this.text('<?php echo "{_show_additional_recording}"; ?>');
        } else {
            $first.show().next().show().next().show();
            $this.text('<?php echo "{_hide_additional_recording}"; ?>');
        }
            
    });

    $('input[type=radio]').click(function(){
        var $this = $(this);
        if($this.val() == 'sms'){
            show_sms();
        } else {
            show_phn();
        }
    });


    initPage();
    

});
</script>


<?php // echo "<pre>".print_r($_POST, true).print_r($_FILES, true)."</pre>"; ?>