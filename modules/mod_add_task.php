
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<?php if($_SESSION['rights']=="task_adder"){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    if(isset($_POST['insert'])){
        insertData($_SESSION['rights']);
    }
    
    if($_GET['send_mail']==1){    
        $from="webmaster@mkem.sk";
        $to="martak@mkem.sk";
        $subject="Ukazovatele procesov - ".$_SESSION['rights'];
        mb_internal_encoding('UTF-8');
        $encoded_subject = mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n", strlen('Subject: '));
                               
        $msg="<html><body>V systéme pribudol nový ukazovateľ ".$_SESSION['rights']." od (".$_SESSION['fullname']." ), za obdobie ".date("m",strtotime($_GET['obdobie']))."/".date("Y",strtotime($_GET['obdobie'])).".<br><a href='http://up.mkem.sk/index.php?modul=prehlad&month=".date("m",strtotime($_GET['obdobie']))."&year=".date("Y",strtotime($_GET['obdobie']))."'>http://up.mkem.sk/</a></body></html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n". 'Cc: ' /*.kopia*/;
        $headers .= 'From: <'.$from.'>' . "\r\n";
        $m=mail($to,$encoded_subject,$msg,$headers);
        
        $query="UPDATE av SET sent=1 WHERE obdobie='".$_GET['obdobie']."' ";
        mysqli_query($connect,$query);
        
        echo "<script>location.replace('index.php?modul=prehlad&month=".date("m",strtotime($_GET['obdobie']))."&year=".date("Y",strtotime($_GET['obdobie']))."');</script>";
    }

    
?>
 <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-calendar"></i> Pridať úlohu</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="Zbaliť/Rozbaliť" title=""> </a>
                                            
                                        </div>
                                    </div>
                                    <div class="portlet-body">
									
								
                                       <form class="form-horizontal" role="form" method="POST" >
                                            <div class="form-body">
                                                
												<div class="form-group">
                                                    <label class="col-md-3 control-label">Názov úlohy</label>
                                                    <div class="col-md-9">
													
													<input class="form-control" size="16" type="text"  name="task_name" value="<?php echo $_POST['task_name']?>" required>
                                                        
													</div>
														
                                                </div>
												<div class="form-group">
                                                    <label class="col-md-3 control-label">Popis</label>
                                                    <div class="col-md-9">
                                                        <textarea name="task_info" form="usrform" style="width:100%;" rows="5"><?php echo $_POST['task_info']?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Priradení zamestnanci</label>
                                                    <div class="col-md-9">
													<select name="employees[]" id="employees" multiple class="chosen-select form-control" style="width:100%;">
                                                       <option value=""></option>;
                                                <?php
                                                        
                                                    $query = "SELECT meno,priezvisko,osobne_cislo FROM employees WHERE osobne_cislo IN (359, 592, 79, 132, 292, 9, 26, 460, 671, 10, 556, 553, 23, 376, 357) ORDER BY priezvisko";
                                                    $selected_employees = mysqli_query($connectToMembers, $query);
                                                           
                                                    while($row = mysqli_fetch_array($selected_employees)){
                                                        
                                                        echo "<option value=\"".$row['osobne_cislo']."\">".$row['priezvisko']." ".$row['meno']."</option>";
                                                        
                                                    }
                                                        
                                                ?>
                                                
												    </select>
                                                        
													</div>
														
                                                </div>
                                                
                                                <div  class="form-group" >
                                                    <label class="col-md-3 control-label">Splniť úlohu do</label>
                                                    <div class="col-md-2">
													
													<input class="form-control" size="16" type="date" name="deadline" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $_POST['deadline']; ?>" >
                                                        
													</div>
														
                                                </div>
                                                                                                                                   
                                            </div>
                                            <div class="form-actions right1">
                                                
                                                <button type="submit" class="btn blue" name="create_task">Zaznamenať</button>
                                            </div>
                                            <div class="form-actions right1">
                                                
                                            </div>
                                        </form>
									
                                    </div>
                                </div>
						
 </div>
<script>
    function OptionsSelected(me)
{
    var text="";
    var checkBox="";
    
    switch(me.id){
        case "dokumentacia":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteDokumentacia");
            break;    
        case "kabelaze":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteKabelaze");
            break; 
        case "vyrobky":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteVyrobky");
            break; 
        case "navody":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNavody");
            break; 
        case "empb":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteEmpb");
            break; 
        case "investicie":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteInvesticie");
            break; 
    }
    
    if (checkBox.checked == true){
        text.style.display = "block";
    }else{
         text.style.display = "none";
    }
}

</script>
<?php } ?>


 <script>
    
     $(".chosen-select").chosen({
        no_results_text: "Oops, nothing found!"
     })
    
</script>