<?php //echo '<pre>'.print_r($campaigns, true).'</pre>'; ?>

</br></br></br></br>
<div id="container" class="container">
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>">{_menu_home}</a></li>
    <li class="active">{_menu_campaigns}</li>
  </ol>

   
    <div class="div_buttons">
        <a class="btn btn-success btn-sm pull-right" href="campaigns/new_campaign"><span class="glyphicon glyphicon-plus"> {_button_new}<span></a>
    </div>
    </br></br>
    
    <div class="jumbotron">  
    <div class="panel panel-default">
    <div class="panel-body">

    <div id="div_campaigns" class="main_content">
      <div class="table-responsive">
        <table id="campaigns_table" class="table">
            <thead>
                <tr>
                    <th class="text-center" width="5%">{_colheading_type}</th>
                    <th class="text-center" width="15%">{_colheading_name}</th>
                    <th class="text-center" width="10%">{_colheading_priority}</th>
                    <th class="text-center" width="10%">{_colheading_created}</th>
                    <th class="text-center" width="10%">{_colheading_status}</th>
                    <th class="text-center" width="3%">&nbsp;</th>
                    <th width="47%">{_colheading_calls_summary}</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($campaigns as $campaign): ?>
                <?php
                    $icon = "phoneIcon.png";
                    if($campaign->campaign_type == 'sms') $icon = "mailIcon.png";
                ?>
                <tr class="success">
                    <td class="text-center">
                        <img src="<?php echo base_url(); ?>assets/images/<?=$icon?>">
                    </td>
                    <td class="text-center"><a href="campaigns/campaign/<?=$campaign->id?>"><?=$campaign->name?></a></td>
                    <td class="text-center" style="text-align: center;"><?=$campaign->priority?></td>
                    <td class="text-center"><?=date('d/m/y', strtotime($campaign->created))?></td>
                    <td class="text-center" style="text-align: center;"><?=translate_campaign_status($campaign->status)?></td>
                    <td class="text-center">&nbsp;</td>
                    <?php if($campaign->total_calls == 0): ?>
                        <td>{_no_calls}</td>
                    <?php else: ?>
                        <?php
                        $percent_complete = number_format(100 * ($campaign->num_complete/$campaign->total_calls), 0);
                        $percent_not_complete = 100 - $percent_complete;
                        ?>
                        <td class="text-center">
                            <table style="width: 300px; border: solid 0px black; border-collapse: collapse;">
                                <tr>
                                    <td id="complete" style="padding: 0px; margin: 0px; background-color: red; border: solid 0px black; width: <?=(2*$percent_complete)?>px;"></td>
                                    <td id="not-complete" style="padding: 0px; margin: 0px;  background-color: grey; border: solid 0px black; width: <?=(2*$percent_not_complete)?>px;"></td>
                                    <td id="summary" style="padding-left: 5px; width: 100px;"><?=$campaign->num_complete?>/<?=$campaign->total_calls?> (<?=$percent_complete?>)%</td>
                                </tr>
                            </table>
                            </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
           </table>
      	  </div>
    	 </div>
	    </div>
       </div> 
      </div>
     </div>



<script type="text/javascript">

<?php $lang =  $this->config->item('language'); ?>
var running = "<?php echo $lang == 'english' ? 'running' : 'en progreso' ; ?>";
var completed = "<?php echo $lang == 'english' ? 'completed' : 'completado' ; ?>";

<!--
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
}

function get_running_ids(){
    var ids = new Array();
    $("#campaigns_table tr td:nth-child(5):contains('" + running + "')").each(function(){
        var href = $(this).prev().prev().prev().children('a').attr('href');
        var pos = href.lastIndexOf('/');
        var id = href.substr(pos + 1);
        console.log(id);
        ids.push(id);
     });     
     var strIds = "";
     for(var i in ids){
         if(strIds.length > 0) strIds += "~";
         strIds += String(ids[i]);
     }
     return strIds;
}

function update_active_campaigns(){
    var ids = get_running_ids();
    $.getJSON('campaigns/update_active_campaigns/' + ids , function(json) {
        $.each(json, function(i,campaign){
            var id = campaign.id;
            var id_cell = $("#campaigns_table tr td a[href='campaigns/campaign/" + id + "']").parent();
            var status_cell = id_cell.next().next().next();
            status_cell.text(campaign.status);
            var activity_cell = status_cell.next().next();
            var num_complete = campaign.num_complete;
            var total_calls = campaign.total_calls;
            var percent_complete = Math.round(100 * (num_complete/total_calls));
            var percent_not_complete = 100 - percent_complete;
            activity_cell.children("table").find("td:nth-child(1)").css("width", String(2 * percent_complete) + "px");
            activity_cell.children("table").find("td:nth-child(2)").css("width", String(2 * percent_not_complete) + "px");
            activity_cell.children("table").find("td:nth-child(3)")
                .text(num_complete + "/" + total_calls + " (" + percent_complete + "%)" );
       });
    });
    setTimeout("update_active_campaigns()", 30000); // 30 seconds
}

$(document).ready(function(){
    $("#campannas").addClass("active");	
    window.onload = timedRefresh(1000 * 60 * 5); // 5 minutes
    update_active_campaigns(); 
    $("#campaigns_table tr td:nth-child(4):contains('" + completed + "')").css("color", "red");
});
-->


</script>

