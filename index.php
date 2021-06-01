<?php
//include('../../config_app.php');
session_start();
include("connect.ini.php");
include("includes/functions.php");
/*
if($_SESSION['user_id']>2){
	echo "Site under constuction.";
exit;
}
*/

global $user;	

require_once("classes/class.user.php");

$user = new User();

$get_param="";

if(isset($_GET['modul'])){

 $get_param=$_GET['modul'];

	

$tparts = explode("/", $_GET['modul']);

$parameter = explode("/", $_GET['modul']);

	$queryInclude = array();

						for($i=0; $i<=sizeof(explode("/", $_GET['modul'])); $i++){

							if(strlen(implode("/", $tparts))>0){

								$queryInclude[] .= "seo_name='" . implode("/", $tparts). "'";

							}	

							array_pop($tparts);

						}

						

						

					 $queryString="SELECT name,seo_name,module_filename FROM menu WHERE 1 and (" . implode(" or ", $queryInclude) . ") order by char_length(seo_name) DESC LIMIT 1";

					 $applyString=mysqli_query($connect,$queryString);

					 $resultString=mysqli_fetch_array($applyString);

					$modul=$resultString['module_filename'];
					$modul_name=$resultString['name'];
					//$modul_path=$resultString['module_path'];

					 

					

}	

else{

	$modul="mod_home.php";

}


if(empty($modul)){$modul="mod_404.php";}

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
        <title>Ukazovatele procesov</title>
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
		   <link href="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
        <link href="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
		<link href="assets/bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="assets/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>

<script src="js/ckeditor/ckeditor.js"></script>

<link rel="stylesheet" href="css/table.css">
<link rel="stylesheet" href="css/showMore.css">
<style>
input[type=checkbox].bold {
    display:none;
}

input[type=checkbox].bold + label.bold {
    display:inline-block;
    padding: 0 0 0 0px;
    background:url("images/bold_cb.jpg") no-repeat;
    height: 35px;
    width: 35px;;
    background-size: 100%;
}

input[type=checkbox]:checked.bold + label.bold {
    background:url("images/bold.jpg") no-repeat;
    height: 35px;
    width: 35px;
    display:inline-block;
    background-size: 100%;
}
input[type=checkbox].italic {
    display:none;
}

input[type=checkbox].italic + label.italic {
    display:inline-block;
    padding: 0 0 0 0px;
    background:url("images/italic_cb.jpg") no-repeat;
    height: 35px;
    width: 35px;;
    background-size: 100%;
}

input[type=checkbox]:checked.italic + label.italic {
    background:url("images/italic.jpg") no-repeat;
    height: 35px;
    width: 35px;
    display:inline-block;
    background-size: 100%;
}

input[type=checkbox].a_default {
    display:none;
}

input[type=checkbox].a_default + label.a_default {
    display:inline-block;
    padding: 0 0 0 0px;
    background:url("images/a_default_cb.jpg") no-repeat;
    height: 35px;
    width: 70px;;
    background-size: 100%;
}

input[type=checkbox]:checked.a_default + label.a_default {
    background:url("images/a_default.jpg") no-repeat;
    height: 35px;
    width: 70px;
    display:inline-block;
    background-size: 100%;
}
input[type=checkbox].b_text {
    display:none;
}

input[type=checkbox].b_text + label.b_text {
    display:inline-block;
    padding: 0 0 0 0px;
    background:url("images/text_cb.jpg") no-repeat;
    height: 35px;
    width: 35px;;
    background-size: 100%;
}

input[type=checkbox]:checked.b_text + label.b_text {
    background:url("images/text.jpg") no-repeat;
    height: 35px;
    width: 35px;
    display:inline-block;
    background-size: 100%;
}
.form-control {
    width: 100%;
    height: 34px;
     padding: 1px 1px; 
    background-color: #fff;
    border: 1px solid #c2cad8;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
</style>
		</head>
    <!-- END HEAD -->
	<?php
	
	?>


    <body class="<?php if($user->isAuthenticated()){echo 'page-header-fixed page-sidebar-closed-hide-logo page-content-white';} ?>">
	<?php
	if(isset($_POST['username']))	{$user->Authenticate($_POST['username'], $_POST['pwd'],$connectToMembers);}
	//+++++++++++++++LANGUAGE++++++++++++++++++++++++++++++

/*if(isset($_GET['language'])){
	if($_GET['language']=="sk"){$_SESSION['language']="sk";}
	//elseif($_GET['language']=="ch"){$_SESSION['language']="ch";}
	else{$_SESSION['language']="sk";}
}*/
        $_SESSION['language']="sk";
if(isset($_SESSION['language'])){$translation_file="translations/".$_SESSION['language'].".php"; echo "wwww";}
else{
	
	$translation_file="translations/".$_SESSION['default_language'].".php";
	}

include($translation_file);



//********************************
	if($_GET['modul']=="logout")	{$user->Logout();}
		if($user->isAuthenticated()){

	?>
	
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo" style="padding:0px">
                        <a href="">
                            <img src="images/logo_sm.png" alt="logo" class="logo-default" style="margin-left:10%" /> </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                                                                      <!-- BEGIN INBOX DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <!--<li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-default"> 10 </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>Naposledy vložené / upravené záznamy</h3>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
										<?php
											/*$query_history="SELECT *,DATE_FORMAT(`date_time`,'%d.%m.%Y %H:%i:%s') AS `datum` FROM history ORDER BY id DESC LIMIT 10";
											$apply_history=mysqli_query($connect,$query_history);
											while($result_history=mysqli_fetch_array($apply_history)){*/
											?>
                                            <li>
                                                <a href="#">
                                                 
                                                    <span class="subject">
                                                        <span class="from"> <?php
													/*if($result_history['type']==1){echo $translation['history_status_creation'];}
													elseif($result_history['type']==2){echo $translation['history_status_confirmation'];}
													elseif($result_history['type']==3){echo $translation['history_status_disallowing'];}
													else{echo "---";}*/
													?></span>
                                                        <span class="time"><?php //echo $result_history['datum'];?> </span>
                                                    </span>
                                                    <span class="message"> <?php //echo $result_history['artikel'];?> </span>
                                                </a>
                                            </li>
											<?php //} ?>
											
                                            
                                        </ul>
                                    </li>
                                </ul>
                            </li>-->
							<li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
								<?php
								if($translation_file=="translations/sk.php"){
									?>
									<img class="img-circle" width="29" height="29" src="images/slovakia.png">
									<?php
									
								}
								else{
									?>
									<img class="img-circle" width="29" height="29" src="images/switzerland.png">
									<?php
								}
								?>
                                   
									
									
                                    
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    
                                    <li>
                                        <a href="<?php if(substr($_SERVER[REQUEST_URI],strlen($_SERVER[REQUEST_URI])-9,9)=="index.php"){echo $_SERVER[REQUEST_URI]."?language=sk";}else{echo $_SERVER[REQUEST_URI]."&language=sk";}?>">
                                            <img class="img-circle" width="29" height="29" src="images/slovakia.png"> Slovenčina</a>
                                    </li>
									 <li>
                                        <a href="<?php if(substr($_SERVER[REQUEST_URI],strlen($_SERVER[REQUEST_URI])-9,9)=="index.php"){echo $_SERVER[REQUEST_URI]."?language=ch";}else{echo $_SERVER[REQUEST_URI]."&language=ch";}?>">
                                            <img class="img-circle" width="29" height="29" src="images/switzerland.png"> Deutsch</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END INBOX DROPDOWN -->
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                   
									<img class="img-circle" width="29" height="29" avatar="<?php echo $_SESSION['fullname'];?>">
									
                                    <span class="username username-hide-on-mobile"> <?php echo $_SESSION['fullname'];?> </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    
                                    <li>
                                        <a href="?modul=logout">
                                            <i class="icon-key"></i> <?php echo $translation['logout']; ?> </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                          
                            <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                            
                            <li class="nav-item start ">
                                <a href="index.php" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    
                                    
                                </a>
                               
                            </li>
				
								<li class="nav-item open">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-folder"></i>
                                    <span class="title">Úlohy</span>
                                    <span class="arrow  open"></span>
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                <?php if($_SESSION['rights']=="task_adder"){ ?>
								<li class="nav-item">
                                        <a href="?modul=add-task" class="nav-link nav-toggle">
                                            <i class="icon-plus"></i> Pridať úlohu
                                           
                                        </a>
                                      
                                    </li>
                                    <?php } ?>
                                    
                                   
                                    
                                </ul>
                            </li>
																				
							<li class="nav-item open">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-folder"></i>
                                    <span class="title"><?php echo $_SESSION['rights']!="readonly" && $_SESSION['rights']!="task_adder" && $_SESSION['rights']!="boss" ? $_SESSION['rights']:"Ukazovatele procesov"; ?></span>
                                    <span class="arrow  open"></span>
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                <?php if($_SESSION['rights']!="readonly" && $_SESSION['rights']!="task_adder" && $_SESSION['rights']!="boss"){ ?>
								<li class="nav-item">
                                        <a href="?modul=<?php echo $_SESSION['rights']; ?>-add" class="nav-link nav-toggle">
                                            <i class="icon-plus"></i> Pridať 
                                           
                                        </a>
                                      
                                    </li>
                                    
                                    <?php
                                        }
                                        if($_SESSION['rights']=="boss"){
                                    ?>
                                    <li class="nav-item">
                                        <a href="?modul=graficky-prehlad" class="nav-link nav-toggle">
                                            <i class="fa fa-line-chart" aria-hidden="true"></i> Grafický prehľad 
                                           
                                        </a>
                                      
                                    </li>                                                                         
                                    <?php
                                        }
                                        $minYear=2020;
                                        while($minYear<=date("Y")){
            
                                    ?>
                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link nav-toggle">
                                            <i class="icon-calendar"></i> <?php echo $minYear; ?>
                                            <span class="arrow"></span>
                                        </a>
                                        
                                        <ul class="sub-menu" style="display: none;">
                                         
                                            <?php
                                        
                                                for($month=1;$month<=12;$month++){
                                                    if($minYear==date("Y") && $month>date("m")){
                                                        break;
                                                    }
                                        
                                            ?>
                                          
                                            <li class="nav-item">
                                                <a href="?modul=prehlad&month=<?php echo $month ?>&year=<?php echo $minYear; ?>" class="nav-link">
                                                    <?php echo $month."/".$minYear; ?> <i <?php if($_SESSION['rights']!="readonly" && $_SESSION['rights']!="task_adder"){ echo mail_sent($_SESSION['rights'],$month,$minYear)?'class="fa fa-envelope"':'class="fa fa-envelope-open-o"'; }?> aria-hidden="true"></i>
                                                    <?php if(report_exist($_SESSION['rights'],$month,$minYear) && $_SESSION['rights']!="readonly"){ ?>
                                                     <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                    <?php } ?></a>
                                                
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php 
                                        
                                        $minYear++;                                
                                        } 
            
                                    ?>
                                   
                                    
                                </ul>
                            </li>
						  
						  
						  
                                </ul>
                            </li>
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
				
                    <!-- BEGIN CONTENT BODY -->
		
                    <?php include("modules/".$modul); ?>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
               
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner"> 2019 mkem, spol. s r.o.
                    
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>

        <!--[if lt IE 9]>
<script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/respond.min.js"></script>
<script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/excanvas.min.js"></script> 
<script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->


        <!-- BEGIN CORE PLUGINS -->
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
		<script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
		<script src="http://production.mkem.sk/domains/metronic_assets/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
	<script src="http://production.mkem.sk/domains/metronic_assets/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
       <!--  TU DOPLNIT VLASTNY JAVASCRIPT NA GRAFY<script src="http://production.mkem.sk/domains/metronic_assets/assets/pages/scripts/charts-amcharts.min.js" type="text/javascript"></script>-->
        <!-- END PAGE LEVEL SCRIPTS -
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="http://production.mkem.sk/domains/metronic_assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
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
				<script>
		/*
     * LetterAvatar
     * 
     * Artur Heinze
     * Create Letter avatar based on Initials
     * based on https://gist.github.com/leecrossley/6027780
     */
    (function(w, d){


        function LetterAvatar (name, size) {

            name  = name || '';
            size  = size || 60;

            var colours = [
                    "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", 
                    "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"
                ],

                nameSplit = String(name).toUpperCase().split(' '),
                initials, charIndex, colourIndex, canvas, context, dataURI;


            if (nameSplit.length == 1) {
                initials = nameSplit[0] ? nameSplit[0].charAt(0):'?';
            } else {
                initials = nameSplit[0].charAt(0) + nameSplit[1].charAt(0);
            }

            if (w.devicePixelRatio) {
                size = (size * w.devicePixelRatio);
            }
                
            charIndex     = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
            colourIndex   = charIndex % 20;
            canvas        = d.createElement('canvas');
            canvas.width  = size;
            canvas.height = size;
            context       = canvas.getContext("2d");
             
            context.fillStyle = colours[colourIndex - 1];
            context.fillRect (0, 0, canvas.width, canvas.height);
            context.font = Math.round(canvas.width/2)+"px Arial";
            context.textAlign = "center";
            context.fillStyle = "#FFF";
            context.fillText(initials, size / 2, size / 1.5);

            dataURI = canvas.toDataURL();
            canvas  = null;

            return dataURI;
        }

        LetterAvatar.transform = function() {

            Array.prototype.forEach.call(d.querySelectorAll('img[avatar]'), function(img, name) {
                name = img.getAttribute('avatar');
                img.src = LetterAvatar(name, img.getAttribute('width'));
                img.removeAttribute('avatar');
                img.setAttribute('alt', name);
            });
        };


        // AMD support
        if (typeof define === 'function' && define.amd) {
            
            define(function () { return LetterAvatar; });
        
        // CommonJS and Node.js module support.
        } else if (typeof exports !== 'undefined') {
            
            // Support Node.js specific `module.exports` (which can be a function)
            if (typeof module != 'undefined' && module.exports) {
                exports = module.exports = LetterAvatar;
            }

            // But always support CommonJS module 1.1.1 spec (`exports` cannot be a function)
            exports.LetterAvatar = LetterAvatar;

        } else {
            
            window.LetterAvatar = LetterAvatar;

            d.addEventListener('DOMContentLoaded', function(event) {
                LetterAvatar.transform();
            });
        }

    })(window, document);
		</script>
   
<?php 
} 
else{
?>
<div class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="images/logo.png" alt=""  style="height:40px"/> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="index.php" method="post">
                <h3 class="form-title font-green">LOGIN</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span>Zadajte svoje osobné číslo a heslo. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Os.č.</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Os.č." name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Heslo</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Heslo" name="pwd" /> </div>
                <div class="form-actions">
                    <center><button type="submit" class="btn green uppercase">Prihlásiť</button></center>
                 
                </div>
                
             
            </form>
            <!-- END LOGIN FORM -->
          
        </div>
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
		
    
<?php } ?>	
</body>
	
	
				
<!-- Matomo -->
<script type="text/javascript">
  var _paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
_paq.push(['setCustomVariable','1','Name and surname','<?php if(isset($_SESSION['fullname'])){echo $_SESSION['fullname'];}else{echo "neprihlaseny";}?>']); 
 _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  
  (function() {
    var u="//production.mkem.sk/matomo/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>

<!-- End Matomo Code -->
</html>