<?php


include("connect.ini.php");



$ds          = DIRECTORY_SEPARATOR;  //1

$code=""; 
$user_id=$_GET['user_id'];

$storeFolder = 'logos';   //2

 

if (!empty($_FILES)) {

     

    $tempFile = $_FILES['file']['tmp_name'];          //3             

      

    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4

     

    $targetFile =  $targetPath. $_FILES['file']['name'];  //5

 

    if(move_uploaded_file($tempFile,$targetFile)){
$query="INSERT INTO logos(logo_path,publish,date_time,user_id) VALUES('".$_FILES['file']['name']."','1',NOW(),'".$user_id."')";
$apply=mysqli_query($connect,$query);

} //6

     

}


?>     

