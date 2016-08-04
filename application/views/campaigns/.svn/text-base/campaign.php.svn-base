<?php
//echo '<pre>'.print_r($campaign, true).'</pre>';
?>
<div id="container">

    <h2>{_title_campaign}</h2>

    <div class="div_buttons">
   
        <a target="_blank" href="../report/<?=$campaign->id?>">{_button_report}</a>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <?php if($campaign->status === 'paused' || $campaign->status === 'pending'): ?>
            <a href="../run/<?=$campaign->id?>">{_button_run}</a>
        <?php endif; ?>
        <?php if($campaign->status === 'running'): ?>
            <a href="../pause/<?=$campaign->id?>">{_button_pause}</a>
        <?php endif; ?>
        <?php if($campaign->status === 'paused' || $campaign->status === 'pending' || $campaign->status === 'running'): ?>
            <a href="../cancel/<?=$campaign->id?>">{_button_cancel}</a>
        <?php endif; ?>
        <?php if($campaign->status === 'paused' || $campaign->status === 'pending' || $campaign->status === 'cancelled'): ?>
            <a href="../delete_campaign/<?=$campaign->id?>" 
               onclick="javascript: var del = confirm('delete this this?'); if(!del) return false;">{_button_delete}</a>
        <?php endif; ?>

    </div>
    <div class="main_content">

        <div id="campaign_form">
        <?php
            $icon = "phoneIcon.png";
            if($campaign->campaign_type == 'sms') $icon = "mailIcon.png";
        ?>
        <div class="div_labels">{_campaign_label_campaign_type}: </div>
        <div class="div_inputs"><img src="<?php echo base_url(); ?>assets/images/<?=$icon?>"></div><div class="clearfix"></div>
        
        <div class="div_labels">{_campaign_label_id}: </div>
        <div class="div_inputs"><?=$campaign->id?></div><div class="clearfix"></div>
        <div class="div_labels">{_campaign_label_name}: </div>
        <div class="div_inputs"><?=$campaign->name?></div><div class="clearfix"></div>

        <div class="div_labels">{_campaign_label_status}: </div>
        <div class="div_inputs"><?=translate_campaign_status($campaign->status)?></div><div class="clearfix"></div>


        <div class="div_labels">{_campaign_label_start}: </div>
        <div class="div_inputs"><?=date('d/m/y', strtotime($campaign->date_start))?></div><div class="clearfix"></div>
        <div class="div_labels">{_campaign_label_end}: </div>
        <div class="div_inputs"><?=date('d/m/y', strtotime($campaign->date_end))?></div><div class="clearfix"></div>
        <div class="div_labels">{_campaign_label_hour_start}: </div>
        <div class="div_inputs"><?=date('H:i', strtotime($campaign->day_start))?></div><div class="clearfix"></div>
        <div class="div_labels">{_campaign_label_hour_end}: </div>
        <div class="div_inputs"><?=date('H:i', strtotime($campaign->day_end))?></div><div class="clearfix"></div>
        
        <?php if($campaign->campaign_type != 'sms'): ?>
            <div class="div_labels">{_campaign_label_retries}: </div>
            <div class="div_inputs"><?=$campaign->retries?></div><div class="clearfix"></div>
        <?php endif; ?>

        <div class="div_labels">{_campaign_label_completed_calls}: </div>
        <div class="div_inputs"><?=$campaign->num_complete?></div><div class="clearfix"></div>
        <div class="div_labels">{_campaign_label_total_calls}: </div>
        <div class="div_inputs"><?=$campaign->total_calls?></div><div class="clearfix"></div>
       
        <?php if($campaign->campaign_type != 'sms'): ?>
            <div class="div_labels">{_campaign_label_recording}: </div>
            <div class="div_inputs"><?=$campaign->recording?></div><div class="clearfix"></div>
            <?php if($campaign->recording2 != null): ?>
                <div class="div_labels">{_campaign_label_recording2}: </div>
                <div class="div_inputs"><?=$campaign->recording2?></div><div class="clearfix"></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="div_labels">{_campaign_label_sms_message}: </div>
            <div class="div_inputs"><?=$campaign->sms_message?></div><div class="clearfix"></div>
        <?php endif; ?>
                
        <div class="div_labels">{_campaign_label_priority}: </div>
        <div class="div_inputs"><?=$campaign->priority?></div><div class="clearfix"></div>
        </div>

    </div>
</div>