
<div id="container">

    <h2>{_title_new_campaign}</h2>

     <div class="main_content">
        <div id="campaign_form">
        <?=validation_errors();?>
        <?php if(isset($errors)) echo  "<div class='error'>$errors</div>"; ?>

        <?=form_open('campaigns/finalize_create_campaign');?>
        <div class="div_labels"><?=form_label('{_campaign_label_name}: ', 'name');?></div>
        <div class="div_inputs"><?=$post_data['name']?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_start}: ', 'date_start');?></div>
        <div class="div_inputs"><?=$post_data['date_start']?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_end}: ', 'date_end');?></div>
        <div class="div_inputs"><?=$post_data['date_end']?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_hour_start}: ', 'day_start_hour');?></div>
        <div class="div_inputs"><?=$post_data['day_start_hour']?>:<?=$post_data['day_start_min']?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_hour_end}: ', 'daytime_hour');?></div>
        <div class="div_inputs"><?=$post_data['day_end_hour']?>:<?=$post_data['day_end_min']?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_retries}: ', 'retries');?></div>
        <div class="div_inputs"><?=$post_data['retries']?></div><div class="clearfix"></div>
        <div class="div_labels"><?=form_label('{_campaign_label_recording}: ', 'recording');?></div>
        <div class="div_inputs"><?=$post_data['recording']?></div><div class="clearfix"></div>

        <?php if($post_data['recording2'] != null): ?>
            <div class="div_labels"><?=form_label('{_campaign_label_recording2}: ', 'recording2');?></div>
            <div class="div_inputs"><?=$post_data['recording2']?></div><div class="clearfix"></div>
        <?php endif; ?>

        <div class="div_labels"><?=form_label('{_campaign_label_file}: ', 'userfile');?></div>
        <div class="div_inputs"><?=$upload_data['file_name']?>

            <br /> - {_total_rows}: <?=$summary['total_rows']?>
            <br /> - {_valid_rows}: <?=$summary['valid_rows']?>
            <br /><a target="_blank" href="<?=base_url()?>upload/temp/upload_data.txt">{_data}</a>

            <?php if(!empty($summary['errors'])): ?>
            <br /><a target="_blank" href="<?=base_url()?>upload/temp/upload_errors.txt">{_errors}</a>
            <?php endif; ?>

        </div><div class="clearfix"></div>
        <?php if($summary['valid_rows'] > $calls_insert_batch_size): ?>
            <div class="div_labels">&nbsp;</div>
            <div class="div_inputs"><?='{_split_campaign_warning}'?></div><div class="clearfix"></div>
        <?php endif; ?>                
        
        <div class="div_labels"><?=form_label('{_campaign_label_priority}: ', 'priority');?></div>
        <div class="div_inputs"><?=$post_data['priority']?></div><div class="clearfix"></div>
        
        <div class="div_labels">&nbsp;</div>
        <div class="div_inputs">
            <?=form_button(array('name' => 'confirm_and_run', 'id' => 'confirm_and_run', 'content' => '{_button_confirm_and_start}'));?>
            <?=form_submit(array('name' => 'confirm', 'id' => 'confirm', 'value' => '{_button_confirm}'));?>
            <?=form_button(array('name' => 'cancel', 'id' => 'cancel', 'content' => '{_button_cancel}'));?>
        </div><div class="clearfix"></div>

        <?=form_close();?>
        </div>

     </div>

</div>

<script type="text/javascript">

    var base_url = '<?php echo base_url(); ?>';

    $(document).ready(function(){

        $("#confirm_and_run").click(function(){
            window.location = base_url + 'campaigns/finalize_create_campaign/true';
        });
        $("#cancel").click(function(){
            window.location = base_url + 'campaigns';
        });

    });

</script>