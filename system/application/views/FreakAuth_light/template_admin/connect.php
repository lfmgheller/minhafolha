
<?php
	$link=mysql_connect("localhost","root","");
if ( ! $link ) {
   die( "Couldn't connect to MySQL: ".mysql_error() );
 }

mysql_select_db("helth",$link);
?>
