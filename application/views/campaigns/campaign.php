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

    <div class="panel ">
    <div class="panel-heading"><center> 

        <div class="div_buttons"> <!-- seccion de botones para las acciones sobre las campannas, como por ejemplo: reporte, eliminar, ejecutar, etc -->
        <a style="text-decoration: none;" target="_blank" href="../report/<?=$campaign->id?>"><img src="<?php echo base_url(); ?>assets/images/report.png" title="{_button_report}" class="img-rounded"><span> Reporte</span></a>

        <?php if($campaign->status === 'paused' || $campaign->status === 'pending'): ?>
            <a style="text-decoration: none;" href="../run/<?=$campaign->id?>"><img src="<?php echo base_url(); ?>assets/images/ejecutar.png" title="{_button_run}" class="img-rounded"><span> Ejecutar</span></a>
        <?php endif; ?>
        <?php if($campaign->status === 'running'): ?>
            <a style="text-decoration: none;" href="../pause/<?=$campaign->id?>"><img src="<?php echo base_url(); ?>assets/images/pause.png" title="{_button_pause}" class="img-rounded"><span> Pausar</span></a>
        <?php endif; ?>
        <?php if($campaign->status === 'paused' || $campaign->status === 'pending' || $campaign->status === 'running'): ?>
            <a style="text-decoration: none;" href="../cancel/<?=$campaign->id?>"><img src="<?php echo base_url(); ?>assets/images/back.png" title="{_button_cancel}" class="img-rounded"><span> Cancelar</span></a>
        <?php endif; ?>
        <?php if($campaign->status === 'paused' || $campaign->status === 'pending'  || $campaign->status === 'completed' || $campaign->status === 'cancelled'): ?>


        <a href="" style="text-decoration: none;" data-toggle="modal" data-target="#confirm-delete"><img src="<?php echo base_url(); ?>assets/images/delete.png" title="{_button_delete}" class="img-rounded"> <span> Eliminar</span></a>

        <!-- modal para la confirmacion del borrado de una campanna deseada -->
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">   <div class="alert alert-danger"> <strong class="text-danger">¿Desea Eliminar la Campaña "<?=$campaign->name?>"?</strong> </div> </div>
           
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a href="../delete_campaign/<?=$campaign->id?>" class="btn btn-danger btn-ok">Eliminar</a>
            </div>
        </div>
        </div>
        </div>          
              
        <?php endif; ?>

    </div>

    </center></div>

    <!-- seccion del resumen de la campanna -->
    <div class="panel-body">
    <div class="main_content">

        <div id="campaign_form">
        <?php
            $icon = "phoneIcon.png";
            if($campaign->campaign_type == 'sms') $icon = "mailIcon.png";
        ?>
       
        <br>
        <div class="row">
            <div class="col-xs-12" style="background-color:#45A215;"></div>
            <br>
            <div class="col-md-2"><label>{_campaign_label_campaign_type} <br><br><img  style="margin-top: 5%;"src="<?php echo base_url(); ?>assets/images/<?=$icon?>"></label></div>
            <div class="col-md-2"><label>{_campaign_label_id} <br><br><h5><?=$campaign->id?></h5></label></div>
            <div class="col-md-2"><label>{_campaign_label_name} <br><br><h5><?=$campaign->name?></h5></label></div>  
            <div class="col-md-2"><label>{_campaign_label_status} <br><br><h5><?=translate_campaign_status($campaign->status) ?></h5></label></div>
            <div class="col-md-2"><label>{_campaign_label_start} <br><br><h5><?=date('d/m/y', strtotime($campaign->date_start))?></h5></label></div>
            <div class="col-md-2"><label>{_campaign_label_end} <br><br><h5><?=date('d/m/y', strtotime($campaign->date_end))?></h5></label></div>
        </div>
 
        <br>
        <div class="row">
            <div class="col-xs-12" style="background-color:#45A215;"></div>
            <br>   
            <div class="col-md-2" ><label>{_campaign_label_hour_start} <br><br><h5><?=date('H:i', strtotime($campaign->day_start))?></h5></label></div>
            <div class="col-md-2"><label>{_campaign_label_hour_end} <br><br><h5><?=date('H:i', strtotime($campaign->day_end))?></h5></label></div>

            <?php if($campaign->campaign_type != 'sms'): ?>
              <div class="col-md-2"><label>{_campaign_label_retries} <br><br><h5><?=$campaign->retries?></h5></label></div>  
            <?php endif; ?>

            <div class="col-md-2"><label>{_campaign_label_completed_calls}<br><h5><?=$campaign->num_complete?></h5></label></div>  
            <div class="col-md-2"><label>{_campaign_label_total_calls}<br><br><h5><?=$campaign->total_calls?></h5></label></div>            
 
            <?php if($campaign->campaign_type != 'sms'): ?>

              <div class="col-md-2"><label>{_campaign_label_recording} <br><br><h5><?=$campaign->recording?></h5></label></div>             

            <?php else: ?>
              <div class="col-md-2"><label>{_campaign_label_sms_message} <br><h5>"<?=$campaign->sms_message?>"</h5></label></div> 
            <?php endif; ?>

            <?php if($campaign->campaign_type == 'sms'): ?>
            <div class="col-md-2"><label>{_campaign_label_priority} <br><br><h5><?=$campaign->priority?></h5></label></div>
            <?php endif; ?>

        </div>

        <?php if($campaign->campaign_type != 'sms'): ?>
        <br>
        <div class="row" ><div class="col-xs-12" style="background-color:#45A215;"></div><br> 
            <?php if($campaign->campaign_type != 'sms'): ?>
            <?php if($campaign->recording2 != null): ?>
              <div class="col-md-2"><div class="col-md-2"><label>{_campaign_label_recording2} <br><h5><?=$campaign->recording2?></h5></label></div></div> 
              <?php endif; ?>
            <div class="col-md-2"><label>{_campaign_label_priority} <br><br><h5><?=$campaign->priority?></h5></label></div>
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

