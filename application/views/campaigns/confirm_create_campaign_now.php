
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

        <?=form_open('campaigns/finalize_create_campaign');?>

        <div class="panel panel-primary">
            <div class="panel-heading"><center>{_title_new_campaign} Telefónica Inmediata</center></div>
            <div class="panel-body">

        <div class="row">
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"><?=form_label('{_campaign_label_name}: ', 'name');?> <?=$post_data['name']?></div>
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"><?=form_label('{_campaign_label_start} de la Campaña: ', 'date_start');?> <?=$post_data['date_start']?></div>
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"><?=form_label('{_campaign_label_end} de la Campaña: ', 'date_end');?> <?=$post_data['date_end']?></div>
        </div>
        <div class="row">
            <div class="col-xs-12" style="background-color:#d9edf7;"> <br /></div>
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"> <?=form_label('{_campaign_label_hour_start}: ', 'day_start_hour');?> <?=$post_data['day_start_hour']?>:<?=$post_data['day_start_min']?></div>
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"> <?=form_label('{_campaign_label_hour_end}: ', 'daytime_hour');?> <?=$post_data['day_end_hour']?>:<?=$post_data['day_end_min']?></div>
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"><?=form_label('{_campaign_label_file}: ', 'userfile');?> <?=$upload_data['file_name']?></div>
        </div>
        <div class="row">
            <div class="col-xs-12" style="background-color:#d9edf7;"> <br /></div>
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"> <label>{_total_rows}:</label> <?=$summary['total_rows']?> </div>
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"> <label>{_valid_rows}:</label> <?=$summary['valid_rows']?> </div>     
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"><?=form_label('{_campaign_label_priority}: ', 'priority');?> <?=$post_data['priority']?></div>           
        </div>
        <div class="row">
            <div class="col-xs-12" style="background-color:#d9edf7;"> <br /></div>
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"> <?=form_label('{_campaign_label_retries}: ', 'retries');?> <?=$post_data['retries']?></div>            
            <?php if($post_data['recording2'] == null): ?>
            <div class="col-xs-6 col-md-8" style="background-color:#99c4f4;"> <?=form_label('{_campaign_label_recording}: ', 'recording');?> <?=$post_data['recording']?></div>     
            <?php endif; ?>
            <?php if($post_data['recording2'] != null): ?>
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"> <?=form_label('{_campaign_label_recording}: ', 'recording');?> <?=$post_data['recording']?></div>     
            <div class="col-xs-6 col-md-4" style="background-color:#99c4f4;"> <?=form_label('{_campaign_label_recording2}: ', 'recording2');?> <?=$post_data['recording2']?></div>
            <?php endif; ?>
        
        </div></br>
        <div class="row">
            <a target="_blank" class="btn btn-info btn-xs" role="button" href="<?=base_url()?>upload/temp/upload_data.txt">{_data}</a>
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
 
        <div class="div_labels">&nbsp;</div>
        <div class="div_inputs">
            <?=form_button(array('name' => 'confirm_and_run','class' => 'btn btn-success', 'id' => 'confirm_and_run', 'content' => '{_button_confirm_and_start} Inmediatamente'));?>
            <?=form_button(array('name' => 'cancel','class' => 'btn btn-warning', 'id' => 'cancel', 'content' => '{_button_cancel}'));?>
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

        $("#confirm_and_run").click(function(){
            window.location = base_url + 'campaigns/finalize_create_campaign_now/true';
        });
        $("#cancel").click(function(){
            window.location = base_url + 'campaigns';
        });

    });

</script>