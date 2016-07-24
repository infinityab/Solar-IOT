<?php
require_once( 'config.php' );
require_once( 'config2.php' );
require_once( 'template.php' );
require_once( 'functions.php' );
require_once( 'decode-url.php' );
startPhp();     // check if first run

if( $_POST ) {
    require_once( 'handle-post.php' );
}
?>
<html>
 <head>
<?php emitHtmlHead( $title ); ?>
</html>
 </head>
 <body>
<?php emitHeader( $title ); ?>
  <div class="body">
<?php
if( !isset( $devices )) {
?>
   <p class="error">No devices have been defined. Edit config.php</p>
<?php
} else if( isset( $_GET ) && count( $_GET ) > 0 ) {
    require_once( 'show-change-schedule.php' );
} else {
    require_once( 'show-status.php' );
    require_once( 'show-schedule.php' );
}
?>
  </div>
<?php emitFooter(); ?>
 </body>
</html>

