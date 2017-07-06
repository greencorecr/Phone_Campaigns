<?php //echo "<pre>".print_r($_POST, true)."</pre>"; ?>

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
        <?=validation_errors();?>
        <?php if(isset($errors)) echo  "<div class='error'>$errors</div>"; ?>

        <?=form_open();?>

    <div class="panel">

      <!-- Confirmacion de la creacion de la campanna sms inmediatamente -->  
      <div class="panel-body">
      <div style="padding:1%;">

        <div class="row" style="background-color: #DFF0D8;">
        <div class="col-xs-12" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;">
            <center><label>{_title_new_sms_campaign} Inmediata</label>
        </div>
       </div></br></br>

        <div class="row" style="background-color: #DFF0D8;">
            <div class="col-xs-6 col-md-4" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"><?=form_label('{_campaign_label_name}: ', 'name');?> <?=$post_data['name']?></div>
            <div class="col-xs-6 col-md-4" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"><?=form_label('{_campaign_label_start} de la Campaña: ', 'date_start');?> <?=$post_data['date_start']?></div>
            <div class="col-xs-6 col-md-4" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"><?=form_label('{_campaign_label_end} de la Campaña: ', 'date_end');?> <?=$post_data['date_end']?></div>
        </div>
        <div class="row" style="background-color: #DFF0D8;">
            <div class="col-xs-6 col-md-4" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"> <?=form_label('{_campaign_label_hour_start}: ', 'day_start_hour');?> <?=$post_data['day_start_hour']?>:<?=$post_data['day_start_min']?></div>
            <div class="col-xs-6 col-md-4" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"> <?=form_label('{_campaign_label_hour_end}: ', 'daytime_hour');?> <?=$post_data['day_end_hour']?>:<?=$post_data['day_end_min']?></div>
            <div class="col-xs-6 col-md-4" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"><?=form_label('{_campaign_label_file}: ', 'userfile');?> <?=$upload_data['file_name']?></div>
        </div>
        <div class="row" style="background-color: #DFF0D8;">
            <div class="col-xs-6 col-md-4" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"> <label>{_total_rows}:</label> <?=$summary['total_rows']?> </div>
            <div class="col-xs-6 col-md-4" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"> <label>{_valid_rows}:</label> <?=$summary['valid_rows']?> </div>     
            <div class="col-xs-6 col-md-4" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"><?=form_label('{_campaign_label_priority}: ', 'priority');?> <?=$post_data['priority']?></div>           
        </div>
     
        <div class="row" style="background-color: #DFF0D8;">

            <center><div class="col-xs-12 col-md-12" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"><?=form_label('{_campaign_label_sms_message}: ', 'sms_message');?></div></center>
            <center><div class="col-xs-12 col-md-12" style="padding: 0.5%; border-width: 0.1px; border-color: #bbcfca; border-style: solid;"><?=$post_data['sms_message']?></div></center>  

        </div></br>
        
        <div class="row">
            <a target="_blank" class="btn btn-primary btn-xs" role="button" href="<?=base_url()?>upload/temp/upload_data.txt">{_data}</a>
             <?php if(!empty($summary['errors'])): ?>
                 <a target="_blank" class="btn btn-danger btn-xs" role="button" href="<?=base_url()?>upload/temp/upload_errors.txt">{_errors}</a>      
        <?php endif; ?>
        </div>
        
       
        <?php if($summary['valid_rows'] > $calls_insert_batch_size): ?>
            <div class="row">
                <div style="color: red;"><?='{_split_campaign_warning}'?></div>
            </div>
        <?php endif; ?>   
       
        </div>
       </div>    
       </div> 

        <div class="div_inputs" style="padding:1%;">
            <?=form_button(array('name' => 'confirm_and_run','class' => 'btn btn-success','id' => 'confirm_and_run', 'content' => '{_button_confirm_and_start} Inmediatamente'));?>
            <?=form_button(array('name' => 'cancel', 'class' => 'btn btn-danger', 'id' => 'cancel', 'content' => '{_button_cancel}'));?>
        </div><div class="clearfix"></div>

        <?=form_close();?>  
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>

<script type="text/javascript">

    var base_url = '<?php echo base_url(); ?>';

    $(document).ready(function(){
        /* Redirecciones de vistas dependiendo de si es o no creada la campanna */
        $("#confirm_and_run").click(function(){
            window.location = base_url + 'campaigns/finalize_create_sms_campaign_now/true';
        });
        $("#cancel").click(function(){
            window.location = base_url + 'campaigns';
        });

    });

</script>