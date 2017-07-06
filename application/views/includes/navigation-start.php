<?php
//echo "<pre>";
//print_r($_SERVER);
//$root = str_replace('/phone_campaigns/', '', $_SERVER['REQUEST_URI']);
$root = str_replace('/phase2/phone_campaigns.gc/', '', $_SERVER['REQUEST_URI']);
//echo '$root: ' . $root . "<br />";
//echo stripos($root, 'reports');
//echo "!!! " . base_url() , "   !!!";
//echo "</pre>";
?>

<!-- Encargado de dar formato al nav de la pagina -->

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="<?=base_url()?>"><img style="margin-top: -4%" src="<?=base_url()?>/assets/images/greencore.png" width="200px" height="30px"></a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
<!--          <li id="inicio"><a href="<?=base_url()?>" <?php echo $root == '' ? 'id="current"' : ''?>>{_menu_home}</a></li>
          <li id="campannas"><a href="<?=base_url()?>campaigns" <?php echo stripos($root, 'campaigns') === 0 ? 'id="current"' :
''?>>{_menu_campaigns}</a></li> -
          <li id="nuevo"><a href="<?=base_url()?>campaigns/new_campaign">Nueva Campaña</a></li> -->
        </ul>
      </div>
    </div>
  </nav>

