<?php if(($_SESSION['rights']=="PL200" && report_exist("PL200",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("pl200",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("PL200",$_GET['month'],$_GET['year']))){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    $query = "SELECT id FROM pl200 WHERE YEAR(obdobie)=".$_GET['year']." AND "."MONTH(obdobie)=".$_GET['month']." ";
    $apply_query = mysqli_query($connect,$query);
    $result=mysqli_fetch_array($apply_query);
    
    addFile("PL200","pl200",$result['id']);
    deleteFile($_GET['modul'],"PL200");
    
    if(isset($_POST['update']) || isset($_POST['update2'])){
        updatePeriodData($_SESSION['rights'],$_GET['month'],$_GET['year']);
    }
    
    if(isset($_POST['update2'])){    
        $from="webmaster@mkem.sk";
        $to="martak@mkem.sk";
        $subject="Ukazovatele procesov - ".$_SESSION['rights']. " (zmena)";
        mb_internal_encoding('UTF-8');
        $encoded_subject = mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n", strlen('Subject: '));
                               
        $msg="<html><body>V systéme bol upravený ukazovateľ ".$_SESSION['rights']." od (".$_SESSION['fullname']." ), za obdobie ".$_GET['month']."/".$_GET['year'].".<br><a href='http://porada.mkem.sk/index.php?modul=prehlad&month=".$_GET['month']."&year=".$_GET['year']."'>http://porada.mkem.sk/</a></body></html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n". 'Cc: ' /*.kopia*/;
        $headers .= 'From: <'.$from.'>' . "\r\n";
        $m=mail($to,$encoded_subject,$msg,$headers);
        
        $query="UPDATE pl200 SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)=".$_GET['month']." AND YEAR(obdobie)=".$_GET['year'];
        mysqli_query($connect,$query);
        
        echo "<script>location.replace('index.php?modul=prehlad&month=".$_GET['month']."&year=".$_GET['year']."');</script>";
    }

?>
 <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-calendar"></i> <?php echo $_GET['month']."/".$_GET['year']; ?></div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="Zbaliť/Rozbaliť" title=""> </a>
                                            
                                        </div>
                                    </div>
                                    <div class="portlet-body">
									
								<?php
                                               
                                                    $query_BU="SELECT * FROM pl200 WHERE YEAR(obdobie)=".$_GET['year']." AND MONTH(obdobie)=".$_GET['month']." ";
                                                    $apply_BU=mysqli_query($connect,$query_BU);
                                                    $result_BU=mysqli_fetch_array($apply_BU);
                                               
                                    ?>
                                      
                                       <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-body">
                                               
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Vyrobené kusy:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="vyrobene_kusy" value="<?php echo ($result_BU['vyrobene_kusy'])!=""?$result_BU['vyrobene_kusy']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="vyrobene_kusy" onclick="OptionsSelected(this)" <?php echo ($result_BU['vyrobene_kusy_poznamka']!=""?"checked":"") ?>>
                                                          <label for="vyrobene_kusy">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteVyrobeneKusy" <?php echo ($result_BU['vyrobene_kusy_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteVyrobeneKusy" id="" cols="auto" rows="3"><?php echo $result_BU['vyrobene_kusy_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                           <div class="form-group">
                                                   <label class="col-md-3 control-label">NTO v /%/ na vyrobené množstvo dielcov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="nto" value="<?php echo ($result_BU['nto_na_vyrobene_mnozstvo_dielcov'])!=""?$result_BU['nto_na_vyrobene_mnozstvo_dielcov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nto" onclick="OptionsSelected(this)" <?php echo ($result_BU['nto_na_vyrobene_mnozstvo_dielcov_poznamka']!=""?"checked":"") ?>>
                                                          <label for="nto">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteNTO" <?php echo ($result_BU['nto_na_vyrobene_mnozstvo_dielcov_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNTO" id="" cols="auto" rows="3"><?php echo $result_BU['nto_na_vyrobene_mnozstvo_dielcov_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Hodnota NTO za celé obdobie:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="nto_obdobie" value="<?php echo ($result_BU['hodnota_nto_za_cele_obdobie'])!=""?$result_BU['hodnota_nto_za_cele_obdobie']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nto_obdobie" onclick="OptionsSelected(this)" <?php echo ($result_BU['hodnota_nto_za_cele_obdobie_poznamka']!=""?"checked":"") ?>>
                                                          <label for="nto_obdobie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteNTOObdobie" <?php echo ($result_BU['hodnota_nto_za_cele_obdobie_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNTOObdobie" id="" cols="auto" rows="3"><?php echo $result_BU['hodnota_nto_za_cele_obdobie_poznamka']; ?></textarea>
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
                                                
                                                    $query = "SELECT path, ID FROM documents WHERE id_indicator=".$result['id']." AND indicator='pl200'";
                                                    $apply_query = mysqli_query($connect,$query);
                                                
                                                ?>
                                                <div id="priloha">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Prílohy:</label>
                                                        <div class="col-md-7">
                                                            <p>
                                                                <?php 
                                                                    while($documents = mysqli_fetch_array($apply_query)){
                                                                        $pos=strpos($documents['path'],'/',10);
                                                                        $pos=strpos($documents['path'],'/',$pos+1); ?>
                                                                        <button type="submit" class="btn red" style="padding: 0px 4px; font-size: 10px" name="deleteDoc" value="<?php echo $documents['ID']; ?>">x</button> <a href="<?php echo $documents['path']; ?>" download><?php echo substr($documents['path'],$pos+1); ?></a><br>
                                                             <?php       }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                </div>
                                            <div class="form-actions right1">
                                                
                                                <button onclick="javascript: return confirm('Naozaj chcete zmeniť údaje za obdobie <?php echo $_GET['month']."/".$_GET['year']; ?>?'); " type="submit" class="btn blue" name="update">Uložiť</button>
                                                <button onclick="javascript: return confirm('Po odoslaní údajov už nebude možné vykonávať zmeny. Naozaj chcete údaje odoslať a zamknúť toto obdobie?'); " type="submit" class="btn blue" name="update2" href="index.php?modul='.$_SESSION['rights'].'-edit&month='.$_GET['month'].'&year='.$_GET['year'].'">Odoslať a zamknúť</button>
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
        case "vyrobene_kusy":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteVyrobeneKusy");
            break; 
        case "nto":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNTO");
            break; 
        case "nto_obdobie":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNTOObdobie");
            break; 
    }
    
    if (checkBox.checked == true){
        text.style.display = "block";
    }else{
         text.style.display = "none";
    }
}

</script>
<?php } elseif($_GET['success_edit']!=""){?>
   <div class="page-content">
    <div class="portlet box blue">
    <h1>Údaje boli uložené správne a mailová notifikácia bola odoslaná. Obdobie je zamknuté.</h1>
    </div>
</div>
    
<?php }else{ ?>
    <div class="page-content">
    <div class="portlet box red">
    <h1>Editácia tohto obdobia už nie je možná. Obdobie je zamknuté.</h1>
    </div>
</div>
<?php } ?>