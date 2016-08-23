
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/jquery.simplemodal.js"></script>
</br></br></br></br>
<div id="container" class="container">
    <ol class="breadcrumb">
    <li><a href="<?=base_url()?>">{_menu_home}</a></li>
    <li><a href="<?=base_url()?>campaigns">{_menu_campaigns}</a></li>
    <li class="active">{_title_new_campaign}</li>
  </ol>

    <div class="jumbotron">  
    <div class="panel panel-default">
    <div class="panel-body">
    
     <div class="main_content">

        <div id="campaign_form">
        <button type="button" id="btn_modal" style="display:none;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalError"></button>
        <?php if(isset($errors)) echo  

'<!-- Modal -->
  <div class="modal fade" id="myModalError" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          
        <div class="alert alert-danger">
        <strong>¡Error!</strong> Revise los siguiente errores. </div>
        </div>
        <div class="modal-body">'.validation_errors().' <div class="error">'.$errors.'</div>          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript"> jQuery(function(){ jQuery("#btn_modal").click(); }); </script>';?>
        
        <?=form_open_multipart('campaigns/validate_new');?> 

        <!-- radio button -->
        <center>
        <h4><?=form_label('{_campaign_label_type} ', 'campaign_type');?></h4>


        <label class="radio-inline">
         <?=form_radio(array(
            'id' => 'campaign_type'
           ,'name' => 'campaign_type'
           ,'value' => 'phn'
           ,'checked' => 'checked'));
        ?> 
       Campaña Telefónica
       </label>

        <label class="radio-inline">
        <?=form_radio(array(
            'id' => 'campaign_type'
           ,'name' => 'campaign_type'
           ,'value' => 'sms'));
        ?>         
        Campaña SMS
        </label>
        </center>
        <!-- radio button -->

        <div class="clearfix"></div></br>


        <!-- labels & inputs -->

        <!-- siempre visibles -->
        <h4><?=form_label('{_campaign_label_name} ', 'name');?></h4>

        <?=form_input(array(
        'type'=>'text', 'name' => 'name', 'value' => '', 'class' => 'form-control', 'placeholder' => "Nombre de Campaña"));?>
        <div class="clearfix"></div>

        <!-- datepicker date_start -->
        <h4><?=form_label('{_campaign_label_start} ', 'date_start');?></h4>
        
                    <div class="col-xs-14 date">
                    <div class="input-group input-append date" id="date_picker_start">
                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input(array(
                    'type' => 'date', 'id' => 'date_start', 'name' => 'date_start'
                   ,'value' => set_value('date_start', $default_start_date)
                   ,'class' => 'form-control', 'style' => ' text-align: center'));?>
                   </div>
                   </div>

             <div class="clearfix"></div>



        <!-- datepicker end_start -->      
        <h4><?=form_label('{_campaign_label_end} ', 'date_end');?></h4>
        

                    <div class="col-xs-14 date">
                    <div class="input-group input-append date" id="date_picker_end">
                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input(array(
                    'type' => 'date', 'id' => 'date_end', 'name' => 'date_end'
                   ,'value' => set_value('date_end', $default_end_date)
                   ,'class' => 'form-control', 'style' => ' text-align: center'));?>
                   
                   </div>
                   </div>

               <div class="clearfix"></div>


     
        <!-- select hour_start -->
        <?php //estilo labels
        $attributes = array('style' => 'margin-left: 15%;');
        $attributes2 = array('style' => 'margin-left: 4%');?> 

        <center>
        <h4><?=form_label('{_campaign_label_hour_start} ', 'day_start_hour', $attributes2);?> 
            <?=form_label('{_campaign_label_hour_end} ', 'day_end_hour', $attributes);?></h4>
        
        <?=form_dropdown('day_start_hour', $hours, $default_start->hour, 
        'class="form-control" style="width: 12%; text-align:center; display:inline;"');?><h3 style="display:inline;"> : </h3>
                                <?=form_dropdown('day_start_min', $minutes, $default_start->minute, 
        'class="form-control" style="width: 12%; text-align:center; display:inline;"');?>       
        <!-- select hour_start-->


        <!-- select hour_end -->  
        <?=form_dropdown('day_end_hour', $hours, $default_end->hour,
        'class="form-control" style="width: 12%; text-align:center; display:inline; margin-left: 1%;"');?><h3 style="display:inline;"> : </h3>
                                <?=form_dropdown('day_end_min', $minutes, $default_end->minute,
        'class="form-control" style="width: 12%; text-align:center; display:inline;"');?>
        </center>
        <div class="clearfix"></div>
        <!-- select hour_end -->  
        <!-- siempre visibles -->                    
          
     
         <!-- siempre visibles -->        
        <h4><?=form_label('{_campaign_label_priority} ', 'priority');?></h4>
        <?=form_input('priority', set_value('priority', $default_priority), 'class="form-control"');?></div><div class="clearfix"></div>
        
        <!-- siempre visibles -->

        <!-- seccion de llamadas / se oculta y se dibuja -->
        <div id="phone_campaign">
                                
            <h4><?=form_label('{_campaign_label_retries} ', 'retries');?></h4>
            <?=form_input('retries', set_value('retries', $default_max_retries), 'class="form-control"');?><div class="clearfix"></div>

            <h4><?=form_label('{_campaign_label_recording} ', 'recording');?></h4>

            <div class="div_inputs"><?=form_dropdown('recording', $recording,'','class="form-control" id="recording1-dropdown" style="text-align:center;"');?>
            </br>
            
            <a id="showRecording2" href="#" class="btn btn-primary btn-sm" style="width: 185px;">{_show_additional_recording}</a>
            </div>
        </br>
            <div class="clearfix"></div>

            <div class="div_labels" style="display: none;"><h4><?=form_label('{_campaign_label_recording2} ', 'recording2');?></h4></div>
            <div class="div_inputs" style="display: none;"><?=form_dropdown('recording2', $recording2,'','class="form-control" id="recording2-dropdown" style="text-align:center;"');?></div><div class="clearfix"  style="display: none;"></div>

        </div>
        <!-- seccion de llamadas / se oculta y se dibuja -->

        

             
        <!-- seccion de SMS / se oculta y se dibuja por default oculto -->                        
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
        <!-- seccion de SMS / se oculta y se dibuja -->

       

        <!-- siempre visibles -->
        <h4><?=form_label('{_campaign_label_file} ', 'userfile');?> <img id="question" style="display:inline;" src="<?php echo base_url(); ?>assets/images/question_mark_icon.gif"></h4>
        
        <div style="position:relative;">
        <a class='btn btn-primary btn-sm' style="width: 185px;" href='javascript:;'>
            Adjuntar Archivo <?=form_upload('userfile','','style="position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:`progid:DXImageTransform.Microsoft.Alpha(Opacity=0)`;opacity:0;background-color:transparent;color:transparent;" size="40"  onchange="$(`#upload-file-info`).html($(this).val());"');?>
        </a>
        &nbsp;
        <span class='label label-info' id="upload-file-info"></span>
        </div>


           

        <div class="clearfix"></div>
        <!-- siempre visibles -->
        <h4><?=form_label('{_use_amount}', 'include_amount');?></h4>

            <div class="checkbox"><?=form_checkbox('include_amount', 'true', true, 'style="margin-left: 1px;"');?>
            <label><span id='sms_amount_message' style='display: none;'>{_sms_message_amount}</span></label></div><div class="clearfix"></div>
        
        <div class="div_labels">&nbsp;</div>
        <div class="div_inputs"><?=form_submit(array('id' => 'submit', 'name' => 'submit',
            'value' => '{_button_submit}', 'class' => 'btn btn-success btn-sm', 'style' => 'width: 185px;'));?></div>
        <div class="clearfix"></div>
        <?=form_close();?>

</div> <!-- fin phone_campaigns -->         
</div> <!-- fin main_content -->
</div> <!-- fin panel-body -->
</div> <!-- fin panel panel-default -->
</div> <!-- fin jumbotron -->
</div> <!-- fin de container -->

<!-- modal de sugerencia del archivo a subir -->
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
<!-- modal de sugerencia del archivo a subir -->


<!-- modal del mesaje de prueba hace llamada a una vista para mostrar mediante un iframe-->
<div id="send_test_sms_message">
    <iframe src="<?php echo base_url(); ?>campaigns/send_sms" style='width: 100%; height: 350px;'></iframe> 
</div>
<!-- modal del mesaje de prueba hace llamada a una vista para mostrar mediante un iframe-->


<!-- preload the images / carga la equis de exit de las modales -->
<div style='display:none'>
        <img src='<?php echo base_url(); ?>assets/images/x.png' alt='' />
</div>
<!-- preload the images / carga la equis de exit de las modales -->



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

    // datapicker
    $("#date_start").dateinput();
    $("#date_end").dateinput();

    //idioma español para el datepicker
    $.fn.datepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
        daysMin: ["Dom", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
    };

    $('#date_picker_start')
        .datepicker({
            autoclose: true,
            language: 'es',
            format: 'mm/dd/yy'});

    $('#date_picker_end')
        .datepicker({
            autoclose: true,
            language: 'es',
            format: 'mm/dd/yy'});          
    
    //quitar un datepicker que no esta en uso, pero se requiere de una funcion datainput(), para el nuevo datepicker
    $('#date_end').click(function(){
       $('#calroot ').hide();
    });

    $('#date_start').click(function(){
       $('#calroot ').hide();
    });
    // datapicker

    // hace submit dependiendo del tipo de campaña 
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
    // hace submit dependiendo del tipo de campaña


    // hace visible la modal y viseversa de la sugerencia del archivo
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
    // hace visible/oculta la modal de la sugerencia del archivo


    // hace visible/oculta la modal de la prueba del envio SMS
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
    // hace visible/oculta la modal de la prueba del envio SMS


    // hace visible la segunda opcion de grabacion
    $('#showRecording2').click(function(){
        var $this = $(this);
        var $first = $this.parent().next().next().next();
        var $select = $first.next().children('select');
        var className = $this.attr('class');


        if($first.is(':visible')){
            $select.val('');
            $first.hide().next().hide().next().hide();
            $this.text('<?php echo "{_show_additional_recording}"; ?>');

            //cambia las clases para el boton de agregar grabacion
            if(className == "btn btn-primary btn-sm"){
            $this.removeClass("btn btn-primary btn-sm");
            $this.addClass("btn btn-danger btn-sm");
            $('html, body').animate({ // move the scroll
                scrollTop: ($this.offset().top)},300); 
            }
            else{ 
                if(className == "btn btn-danger btn-sm"){
                $this.removeClass("btn btn-danger btn-sm");
                $this.addClass("btn btn-primary btn-sm");
                $('html, body').animate({
                    scrollTop: ($this.offset().top)},300);
                }
            }


        } else {
           
            $first.show().next().show().next().show();
            $this.text('<?php echo "{_hide_additional_recording}"; ?>');

            //cambia las clases para el boton de agregar grabacion
            if(className == "btn btn-primary btn-sm"){
            $this.removeClass("btn btn-primary btn-sm");
            $this.addClass("btn btn-danger btn-sm");
            $('html, body').animate({
                scrollTop: ($this.offset().top)},300);
            }
            else{ 
                if(className == "btn btn-danger btn-sm"){
                $this.removeClass("btn btn-danger btn-sm");
                $this.addClass("btn btn-primary btn-sm");
                $('html, body').animate({
                    scrollTop: ($this.offset().top)},300);
                }
            }
        }
            
    });
    // hace visible la segunda opcion de grabacion



    // hace visible/oculta la parte de SMS y llamadas
    $('input[type=radio]').click(function(){
        var $this = $(this);
        if($this.val() == 'sms'){
            show_sms();
        } else {
            show_phn();
        }
    });
    // hace visible/oculta la parte de SMS y llamadas


    initPage(); 
    

});

</script>


<?php // echo "<pre>".print_r($_POST, true).print_r($_FILES, true)."</pre>"; ?>