<div id="container">
    
     <div class="main_content" style='width: 90%; margin: auto;' >
        <div id="campaign_sms_form">
            <div><h4><?=form_label('{_label_phone_number} ', 'phone_number');?></h4>
                 <?=form_input(array(
                         'name' => 'phone_number'
                        ,'class' => 'form-control'
                        ,'id' => 'phone_number'
                        ,'length' => '10'
                        ,'size' => '10'
                        ,'value' => set_value('phone_number', $sms_test_phone_number)));?></div><div class="clearfix"></div>

            <div><h4><?=form_label('{_label_amount} ', 'amount');?></h4>
                 <?=form_input(array(
                         'name' => 'amount'
                        ,'id' => 'amount'
                        ,'class' => 'form-control'
                        ,'length' => '6'
                        ,'size' => '6'
                        ,'value' => set_value('amount', '100')));?></div><div class="clearfix"></div>
                        
                        
            <div><h4><?=form_label('{_label_message} ', 'message');?></h4>
                 <?=form_textarea(array(
                         'name' => 'message'
                        ,'id' => 'message'
                        ,'class' => 'form-control'
                        ,'rows' => '5'
                        ,'cols' => '50'
                        ,'value' => set_value('message', $sms_test_message)));?></div>
                        <h5>*{_sms_message_amount}</h5><div class="clearfix"></div>
            <div><label></label><h4><div id="errorMessage"></div></h4><div class="clearfix"></div>
            <div><label></label>
            <br />
            <?=form_submit(array('name' => 'submit','id' => 'submit', 'class' => 'btn btn-success btn-sm', 'style' => 'width: 185px;', 'value' => '{_button_submit}'));?></div><div class="clearfix"></div>
            <label></label><div id="results"></div></div><div class="clearfix"></div>

        </div>
    </div>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/jquery.simplemodal.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $(".footer").css("display", "none");
        
        $('#cancel').click(function(){
            alert('say what!!!');
        });
        
        $('#submit').click(function(){

            $("#errorMessage").empty();

            var phoneNumber = $('#phone_number').val();
            var message = $('#message').val();

            var eightDigits = new RegExp('^\\d{8}$');
            var oneSixtyChars = new RegExp('^.{1,160}$');

            var valid = true;

            if(!eightDigits.test(phoneNumber)){
                $("#errorMessage").append("must be a valid phone number.<br />");
                valid = false;
            }

            if(!oneSixtyChars.test(message)){
                $("#errorMessage").append("message must be between 1 and 160 in length.<br />");
                valid = false;
            }

            if (!valid) return;
            
            //var msg = $('#message').val()+" ".replace(' ', $('#amount').val());
            //alert(msg);
            var msg = $('#message').val().replace('$$$', $('#amount').val());
            
            $.post("ajax_send_sms", { phone_number: $('#phone_number').val(), message: msg },
                function(data){
                    $('#results').html('{_message sent}!<br />' + data.phone + "<br />" + data.msg);
            }, "json");
            
        });

        $('#phone_number').keyup( function(event) {
            var $this = $(this);
            if($this.val().length > 8)
                $this.val($this.val().substr(0, 8));			
        });

        $('#message').keyup( function(event) {
            var $this = $(this);
            if($this.val().length > 160)
                $this.val($this.val().substr(0, 160));
        });

    });

</script>