<?php
include('../../../config_app.php');
session_start();
include("../connect.ini.php");

?>

<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>SMD ZÁZNAMY</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
     
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
		<link href="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="http://production.mkem.sk/domains/metronic_assets/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="http://production.mkem.sk/domains/metronic_assets/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="http://production.mkem.sk/domains/metronic_assets/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="http://production.mkem.sk/domains/metronic_assets/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="http://production.mkem.sk/domains/metronic_assets/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
		 <link href="http://production.mkem.sk/domains/metronic_assets/assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
		 <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		  
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->
	

    <body class="login">
	
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="../images/smd-zaznamy-logo-big.png" alt=""  style="height:40px"/> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
		<?php
		if(isset($_POST['username'])){
			$query_insert="INSERT INTO USER(username,fullname,pwd,admin,active) VALUES('".$_POST['username']."','".$_POST['fullname']."','".$_POST['pwd']."','0','0')";
			$apply_insert=mysqli_query($connect,$query_insert);
			if($apply_insert){
				echo '<div class="alert alert-success">Registrácia prebehla úspešne. Prihlásiť sa môžete až po aktivacií konta administrátorom.</div>';
			}
			else{
				echo '<div class="alert alert-danger">Nepodarilo sa zaregistrovať používateľa.</div>';
			}
			
		}
		?>
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="" method="post">
                <h3 class="form-title font-green">Registrácia</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span>Zadajte svoje osobné číslo, meno a heslo. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Os. číslo</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Os. číslo" name="username" /> </div>
				<div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Meno a priezvisko</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Meno a priezvisko" name="fullname" /> </div>	
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Heslo</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Heslo" name="pwd" /> </div>
                <div class="form-actions">
                    <center><button type="submit" class="btn green uppercase">Zaregistrovať sa</button></center>
                 
                </div>
                
             
            </form>
            <!-- END LOGIN FORM -->
          
        </div>
       
        <!--[if lt IE 9]>
<script src="http://production.mkem.sk/domains//assets/global/plugins/respond.min.js"></script>
<script src="http://production.mkem.sk/domains//assets/global/plugins/excanvas.min.js"></script> 
<script src="http://production.mkem.sk/domains//assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
		
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/pages/scripts/login.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
		
    
	
</body>
	
	

</html>