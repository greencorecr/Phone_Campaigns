<?php //echo '<pre>'.print_r($campaign, true).'</pre>';?>

</br></br></br></br>
<div id="container" class="container">
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>">{_menu_home}</a></li>
    <li><a href="<?=base_url()?>campaigns">{_menu_campaigns}</a></li>
    <li class="active">Resumen de Campaña</li>
  </ol>

    <center>
    <div class="jumbotron">  
    <div class="panel panel-default">
    <div class="panel-body">

    <div class="panel panel-success">
    <div class="panel-heading"><center> 

        <div class="div_buttons">
        <a target="_blank" href="../report/<?=$campaign->id?>"><img src="<?php echo base_url(); ?>assets/images/report.png" title="{_button_report}" class="img-rounded"><span> Reporte</span></a>

        <?php if($campaign->status === 'paused' || $campaign->status === 'pending'): ?>
            <a href="../run/<?=$campaign->id?>"><img src="<?php echo base_url(); ?>assets/images/ejecutar.png" title="{_button_run}" class="img-rounded"><span> Ejecutar</span></a>
        <?php endif; ?>
        <?php if($campaign->status === 'running'): ?>
            <a href="../pause/<?=$campaign->id?>"><img src="<?php echo base_url(); ?>assets/images/pause.png" title="{_button_pause}" class="img-rounded"><span> Pausar</span></a>
        <?php endif; ?>
        <?php if($campaign->status === 'paused' || $campaign->status === 'pending' || $campaign->status === 'running'): ?>
            <a href="../cancel/<?=$campaign->id?>"><img src="<?php echo base_url(); ?>assets/images/back.png" title="{_button_cancel}" class="img-rounded"><span> Cancelar</span></a>
        <?php endif; ?>
        <?php if($campaign->status === 'paused' || $campaign->status === 'pending' || $campaign->status === 'cancelled'): ?>
            <a href="../delete_campaign/<?=$campaign->id?>" 
               onclick="javascript: var del = confirm('delete this this?'); if(!del) return false;"><img src="<?php echo base_url(); ?>assets/images/delete.png" title="{_button_delete}" class="img-rounded"><span> Eliminar</span></a>
        <?php endif; ?>

    </div>

    </center></div>
    <div class="panel-body">


    <div class="main_content">

        <div id="campaign_form">
        <?php
            $icon = "phoneIcon.png";
            if($campaign->campaign_type == 'sms') $icon = "mailIcon.png";
        ?>
       
        <br>
        <div class="row" style="background-color:#DFF0D8; padding: 0.7%;">
            <div class="col-xs-12" style="background-color:#DFF0D8;"></div>
            <br>
            <div class="col-md-2"><label>{_campaign_label_campaign_type} </label></div>
            <div class="col-md-2"><label>{_campaign_label_id} </label></div>
            <div class="col-md-2"><label>{_campaign_label_name} </label></div>  
            <div class="col-md-2"><label>{_campaign_label_status} </label></div>
            <div class="col-md-2"><label>{_campaign_label_start} </label></div>
            <div class="col-md-2"><label>{_campaign_label_end} </label></div>
        </div>
        <div class="row">            
            <div class="col-xs-12"><br></div>
            <div class="col-md-2"><span><img src="<?php echo base_url(); ?>assets/images/<?=$icon?>"></span></div>
            <div class="col-md-2"><?=$campaign->id?></div>
            <div class="col-md-2"><?=$campaign->name?></div>    
            <div class="col-md-2"><?=translate_campaign_status($campaign->status) ?> </div>   
            <div class="col-md-2"><?=date('d/m/y', strtotime($campaign->date_start)) ?> </div> 
            <div class="col-md-2"><?=date('d/m/y', strtotime($campaign->date_end)) ?> </div>  
        </div>
        <br>
        <div class="row" style="background-color:#DFF0D8;">
            <br>   
            <div class="col-md-2"><label>{_campaign_label_hour_start} </label></div>
            <div class="col-md-2"><label>{_campaign_label_hour_end} </label></div>

            <?php if($campaign->campaign_type != 'sms'): ?>
              <div class="col-md-2"><label>{_campaign_label_retries}</label></div>  
            <?php endif; ?>

            <div class="col-md-2"><label>{_campaign_label_completed_calls}</label></div>  
            <div class="col-md-2"><label>{_campaign_label_total_calls}</label></div>            

            <?php if($campaign->campaign_type != 'sms'): ?>

              <div class="col-md-2"><label>{_campaign_label_recording}</label></div>             

            <?php else: ?>
              <div class="col-md-2"><label>{_campaign_label_sms_message}</label></div> 
            <?php endif; ?>

            <?php if($campaign->campaign_type == 'sms'): ?>
            <div class="col-md-2"><label>{_campaign_label_priority}</label></div>
            <?php endif; ?>

        </div>
        <div class="row">            
            <div class="col-xs-12"><br></div>
            <div class="col-md-2"><?=date('H:i', strtotime($campaign->day_start))?></div>
            <div class="col-md-2"><?=date('H:i', strtotime($campaign->day_end))?></div>
            <?php if($campaign->campaign_type != 'sms'): ?>
            <div class="col-md-2"><?=$campaign->retries?></div>
            <?php endif; ?>
            <div class="col-md-2"><?=$campaign->num_complete?></div>
            <div class="col-md-2"><?=$campaign->total_calls?></div>


            <?php if($campaign->campaign_type != 'sms'): ?>

              <div class="col-md-2"><?=$campaign->recording?></div>  

            <?php else: ?>
              <div class="col-md-2">"<?=$campaign->sms_message?>"</div> 
            <?php endif; ?>
        
            <?php if($campaign->campaign_type == 'sms'): ?>      
               <div class="col-md-2"><?=$campaign->priority?></div>      
            <?php endif; ?>
              
        </div>
        <?php if($campaign->campaign_type != 'sms'): ?>
        <br>
        <div class="row" style="background-color:#DFF0D8; padding:1%;"> 
            <?php if($campaign->campaign_type != 'sms'): ?>
            <?php if($campaign->recording2 != null): ?>
              <div class="col-md-2"><div class="col-md-2"><label>{_campaign_label_recording2}</label></div></div> 
              <?php endif; ?>
            <div class="col-md-2"><label>{_campaign_label_priority}</label></div>
            <?php endif; ?>
        </div>
        <div class="row"> 
        <br>
        <?php if($campaign->campaign_type != 'sms'): ?>    
              <?php if($campaign->recording2 != null): ?>
              <div class="col-md-2"><?=$campaign->recording2?></div> 
              <?php endif; ?>
              <div class="col-md-2"><?=$campaign->priority?></div>      
        <?php endif; ?>
        </div>
        <?php endif; ?>

        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>