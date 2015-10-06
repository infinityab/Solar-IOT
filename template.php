<?php

function emitHtmlHead( $title ) {
?>
  <title><?= $title ?></title>
  <link href="css/default.css" rel="stylesheet" type="text/css" />
<?php
}

function emitHeader( $title ) {
    global $baseUrl;
?>
  <div class="h1">
   <h1><a href="<?= $baseUrl ?>/"><?= $title ?></a></h1>
  </div>
  <div class="tabs">
   <ul>
    <li><a href="<?= $baseUrl ?>/">Home</a></li>
    <li><a href="<?= $baseUrl ?>/configure.php">Configure</a></li>
    <li><a href="<?= $baseUrl ?>/logs.php">Logs</a></li>
    <li><a href="<?= $baseUrl ?>/graphic-logs.php">Graphic logs</a></li>
    <li><a href="<?= $baseUrl ?>/help.php" onclick="javascript:void window.open(
       '<?= $baseUrl . "/help.php" ?>','popUpwindow',' width=1100,height=950,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
          return false;">Help</a></li>
   </ul>
  </div> 
<?php
}

function emitFooter() {
?>
  <div class="footnote">
   <p>Licensed under <a href="LICENSE">GPLv3</a>.
      More info: <a href="https://github.com/infinityab/Rasptimer-Solar-Timer-Scheduler">https://github.com/infinityab/Rasptimer-Solar-Timer-Scheduler</a>.</p>
  </div>
<?php
}
