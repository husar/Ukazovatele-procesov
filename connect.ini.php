<?php

$connect = mysqli_connect('localhost','root','','ukazovatele_procesov');
mysqli_query($connect,"set names 'utf8'");
error_reporting(0);

$connectToMembers = mysqli_connect('localhost','root','','user_manager');
mysqli_query($connectToMembers,"set names 'utf8'");
error_reporting(0);

?>