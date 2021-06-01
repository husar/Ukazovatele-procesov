<?php if($_SESSION['rights']=="PL SMT/THT"){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    addFile("PL SMT THT","pl_smt_tht","-1");
    
    deleteFile($_GET['modul'],"PL SMT THT");
    
    if(isset($_POST['insert']) || isset($_POST['insert2'])){
        insertData($_SESSION['rights']);
        moveAttahedFile("PL SMT THT","pl_smt_tht");
    }
    
    if($_GET['send_mail']==1){    
        $from="webmaster@mkem.sk";
        $to="martak@mkem.sk";
        $subject="Ukazovatele procesov - ".$_SESSION['rights'];
        mb_internal_encoding('UTF-8');
        $encoded_subject = mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n", strlen('Subject: '));
                               
        $msg="<html><body>V systéme pribudol nový ukazovateľ ".$_SESSION['rights']." od (".$_SESSION['fullname']." ), za obdobie ".$_GET['month']."/".$_GET['year'].".<br><a href='http://porada.mkem.sk/index.php?modul=prehlad&month=".$_GET['month']."&year=".$_GET['year']."'>http://porada.mkem.sk/</a></body></html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n". 'Cc: ' /*.kopia*/;
        $headers .= 'From: <'.$from.'>' . "\r\n";
        $m=mail($to,$encoded_subject,$msg,$headers);
        
        $query="UPDATE pl_smt_tht SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)='".$_GET['month']."' AND YEAR(obdobie)='".$_GET['year']."' ";
        mysqli_query($connect,$query);
        
        echo "<script>location.replace('index.php?modul=prehlad&month=".$_GET['month']."&year=".$_GET['year']."');</script>";
    }
?>
 <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-calendar"></i> Pridať záznam</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="Zbaliť/Rozbaliť" title=""> </a>
                                            
                                        </div>
                                    </div>
                                    <div class="portlet-body">
									
								
                                       <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-body">
                                               <div class="form-group">
                                                <label class="col-md-3 control-label">Obdobie:</label>
                                                    <div class="col-md-2">
                                                    <select name="obdobie" id="">
                                                        <option value="<?php echo $period=date('Y-m-01',strtotime(date('Y-m')." -1 month")); ?>" <?php echo $_POST['obdobie']==$period?"selected":""; ?>><?php echo date('m/Y',strtotime(date('Y-m')." -1 month")); ?></option>
                                                        <option value="<?php echo $period=date('Y-m-01'); ?>" <?php echo $_POST['obdobie']==$period?"selected":""; ?>><?php echo date('m/Y'); ?></option>
                                                    </select>
													</div>	
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Zásoba vyrobených modulov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="text" placeholder="Text" name="zasoba" value="<?php echo $_POST['zasoba']!=""?$_POST['zasoba']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="zasoba" onclick="OptionsSelected(this)" <?php echo $_POST['noteZasoba']!=""?"checked":""; ?>>
                                                          <label for="zasoba">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteZasoba" style="<?php echo $_POST['noteZasoba']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteZasoba" id="" cols="auto" rows="3"><?php echo $_POST['noteZasoba']!=""?$_POST['noteZasoba']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
												<div id="priloha">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Vybrať prílohu:</label>
                                                        <div class="col-md-7">
                                                            <input type="file" name="fileToUpload" id="file" class="btn blue">
                                                            <br>
                                                            <input type="submit" value="Nahrať prílohu" name="addFile" class="btn blue">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                
                                                    $documents = scandir("documents/waiting/PL SMT THT/");
                                                
                                                ?>
                                                <div id="priloha">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Prílohy:</label>
                                                        <div class="col-md-7">
                                                            <p>
                                                                <?php 
                                                                        $docIndex=2;
                                                                        while($docIndex<count($documents)){ ?>
                                                                            <button type="submit" class="btn red" style="padding: 0px 4px; font-size: 10px" name="deleteDoc" value="<?php echo $documents[$docIndex]; ?>">x</button> <a href="documents/waiting/PL SMT THT/<?php echo $documents[$docIndex]; ?>" download><?php echo $documents[$docIndex]; ?></a><br>
                                                                  <?php           $docIndex++;
                                                                       }
                                                                    
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
												
												
                                               
                                            </div>
                                            <div class="form-actions right1">
                                                
                                                <button type="submit" class="btn blue" name="insert">Uložiť</button>
                                                <button onclick="javascript: return confirm('Po odoslaní údajov už nebude možné vykonávať zmeny. Naozaj chcete údaje odoslať a zamknúť toto obdobie?'); " type="submit" class="btn blue" name="insert2" href="index.php?modul='.$_SESSION['rights'].'-edit&send_mail=1&month='.date(""m"",strtotime($_POST['obdobie'])).'&year='.date(""Y"",strtotime($_POST['obdobie'])).'">Odoslať a zamknúť</button>
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
        case "zasoba":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteZasoba");
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