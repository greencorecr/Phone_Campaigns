</br></br></br></br>
<!-- vista de inicio de la aplicacion -->
<div class="container">

  <ol class="breadcrumb">
    <li class="active">{_menu_home}</li>     
  </ol>

<div class="jumbotron">
  <div class="panel panel-default">
    <div class="panel-body">
    <blockquote>
	<center> <a href="campaigns">
    	 <img style="margin-left: -0.8%;" height="115px" width="115px" id="img-phone" src="<?php echo base_url(); ?>assets/images/phone.png" alt="..." class="img-circle"></a> 
	 <h4></br><button class="button" onclick="javascript:location.href='campaigns'"><span>{_button_go_campaigns}</span></button></h4>
    	</center> 
    </blockquote> 
   </div>
</div>
    <center><div class="panel-footer"><h5>{_desc_campaigns}</h5></div></center>

  </div>
</div>

<script>

$(document).ready(function(){
        $("#inicio").addClass("active"); 
});

</script>
