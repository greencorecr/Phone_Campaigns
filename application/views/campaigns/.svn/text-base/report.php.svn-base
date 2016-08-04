<?php //echo '<pre>'.print_r($campaign, true).'</pre>'; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{_phone_campaigns} :: <?=$page_title?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="screen" />
</head>
<body style="background-color: white;">

<div id="container">
    <div id="report">
        <h2>{_title_campaign_report}</h2>
        <div id="report_header">
            <div class="field">{_campaign_label_id}: <?=$campaign->id?></div>
            <div class="field">{_campaign_label_name}: <?=$campaign->name?></div>
            <div class="field">{_campaign_label_status}: <?=translate_campaign_status($campaign->status)?></div>
            <div class="field">{_campaign_label_created}: <?=date('d/m/Y', strtotime($campaign->created))?></div>
            <div class="field">{_campaign_label_priority}: <?=$campaign->priority?></div><div class="clearfix"></div>
            <div class="field">{_campaign_label_date_range}: <?=date('d/m/Y', strtotime($campaign->date_start))?> - <?=date('d/m/Y', strtotime($campaign->date_end))?></div>
            <div class="field">{_campaign_label_time_range}: <?=date('H:i', strtotime($campaign->day_start))?> - <?=date('H:i', strtotime($campaign->day_end))?></div>
            <div class="field">{_campaign_label_use_amount}: <?php echo $campaign->use_amount ? 'true' : 'false'; ?></div>
            <div class="clearfix"></div>

            <?php if($campaign->campaign_type == 'phn'): ?>
                <div class="field">{_campaign_label_retries}: <?=$campaign->retries?></div>
                <div class="field">{_campaign_label_recording}: <?=$campaign->recording?></div>
                <?php if($campaign->recording2 != null): ?>
                    <div class="field">{_campaign_label_recording2}: <?=$campaign->recording2?></div>
                <?php endif; ?>
            <?php else: ?>
                <div class="field">{_campaign_label_sms_message}: <?=$campaign->sms_message?></div>
            <?php endif; ?>
            <div class="field">{_campaign_label_completed_calls}: <?=$campaign->num_complete?></div>
            <div class="field">{_campaign_label_total_calls}: <?=$campaign->total_calls?></div>
            
            <div class="clearfix"></div>
                
        </div>
        <div id="report_calls">
            <table>
                <thead>
                    <tr>
                        <th>{_calls_label_phone}</th>
                        <th>{_calls_label_amount_owed}</th>
                        <th>{_calls_label_status}</th>
                        <?php if($campaign->campaign_type == 'phn'): ?>
                        <th>{_calls_label_retries}</th>
                        <?php endif; ?>
                        <th>{_calls_label_call_date}</th>
                        <th>{_calls_label_start_time}</th>
                        <?php if($campaign->campaign_type == 'phn'): ?>
                        <th>{_calls_label_end_time}</th>
                        <th>{_calls_label_duration}</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($campaign->calls as $call): ?>
                    <tr>
                        <td style="text-align: right;"><?=$call->phone?></td>
                        <td style="text-align: right;"><?=$call->amount_owed?></td>
                        <td><?=translate_call_status($call->status)?></td>
                        <?php if($campaign->campaign_type == 'phn'): ?>
                            <td style="text-align: right;"><?=$call->retries?></td>
                        <?php endif; ?>
                        <td style="text-align: right;"><?=is_null($call->call_date) ? '' : date('d/m/Y', strtotime($call->call_date))?></td>
                        <td style="text-align: right;"><?=is_null($call->start_time) ? '' : date('H:i:s', strtotime($call->start_time))?></td>
                        <?php if($campaign->campaign_type == 'phn'): ?>
                            <td style="text-align: right;"><?=is_null($call->end_time) ? '' : date('H:i:s', strtotime($call->end_time))?></td>
                            <td style="text-align: right;"><?=$call->duration?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>