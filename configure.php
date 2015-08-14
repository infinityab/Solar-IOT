<?php
require_once( 'config.php' );
require_once( 'config2.php' );
require_once( 'template.php' );
require_once( 'functions.php' );
require_once( 'decode-url.php' );
?>

<html>

<?php
if( $_POST ) {
    print("calling handle-post.php");
    require_once( 'handle-post.php' );
    print("done calling handle-post.php");
}
?>
 <head>
<?php emitHtmlHead( $title . " &mdash; Configure" ); ?>
 </head>
 <body>
<?php emitHeader( $title . " &mdash; Configure" ); ?>
  <div class="body">
<?php
require_once( 'show-devices.php' );
?>
  </div>
<?php emitFooter(); ?>
 </body>
</html>

