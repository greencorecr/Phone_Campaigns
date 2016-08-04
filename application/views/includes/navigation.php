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

<div id="navcontainer">
<ul id="navlist">
<li><a href="<?=base_url()?>" <?php echo $root == '' ? 'id="current"' : ''?>>{_menu_home}</a></li>
<li><a href="<?=base_url()?>campaigns" <?php echo stripos($root, 'campaigns') === 0 ? 'id="current"' : ''?>>{_menu_campaigns}</a></li>
</ul>
</div>
