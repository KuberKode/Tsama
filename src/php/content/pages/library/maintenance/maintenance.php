<?php 

$base = Tsama\Server::GetBaseUrl();

echo '<div class="container">';
echo '<div class="row">'; //row

echo '<div class="col-sm">'; //col1
echo '<div class="jumbotron" style="overflow: visible;"><h1 class="display-1">Maintenance in progress</h1>';
echo '<p class="lead">This website is currently undergoing maintenance. Please check back later.</p><hr class="my-4">';
echo '</div></div>'; //jumbotron , col1
echo '<div class="col-sm"><img src="content/media/visual/images/default/maintenance-tools.svg" width="50%" style="margin: 0 auto; margin-top: 100pt; margin-left: 24px; " /></div>';//col2
echo '</div>'; //row
echo '</div>'; //container

?>