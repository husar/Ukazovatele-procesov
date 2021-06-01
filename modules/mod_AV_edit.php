<?php if(($_SESSION['rights']=="AV" && report_exist("AV",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("av",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("AV",$_GET['month'],$_GET['year']))){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    $query = "SELECT id FROM av WHERE YEAR(obdobie)=".$_GET['year']." AND "."MONTH(obdobie)=".$_GET['month']." ";
    $apply_query = mysqli_query($connect,$query);
    $result=mysqli_fetch_array($apply_query);
    
    addFile("AV","av",$result['id']);
    deleteFile($_GET['modul'],"AV");
    
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
     
        $query="UPDATE av SET sent=1, datetime_sent=NOW() WHERE  MONTH(obdobie)=".$_GET['month']." AND YEAR(obdobie)=".$_GET['year'];
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
                                               
                                                    $query_BU="SELECT * FROM av WHERE YEAR(obdobie)=".$_GET['year']." AND MONTH(obdobie)=".$_GET['month']." ";
                                                    $apply_BU=mysqli_query($connect,$query_BU);
                                                    $result_BU=mysqli_fetch_array($apply_BU);
                                               
                                    ?>
                                      
                                       <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-body">
                                               
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerný počet dní potrebných na spracovanie dokumentácie za mesiac:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="Hodnota" name="dokumentacia" value="<?php echo ($result_BU['priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac'])!=""?$result_BU['priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="dokumentacia" onclick="OptionsSelected(this)" <?php echo ($result_BU['priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac_poznamka']!=""?"checked":"") ?>>
                                                          <label for="dokumentacia">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteDokumentacia" <?php echo ($result_BU['priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteDokumentacia" id="" cols="auto" rows="3"><?php echo $result_BU['priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Prírastok výrobkov:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <label for="kabelaze">Nové kabeláže</label>
                                                        </span>
                                                       <input class="form-control" type="number" placeholder="Počet" name="kabelaze" value="<?php echo ($result_BU['prirastok_vyrobkov_nove_vyrobky/kabelaze'])!=""?$result_BU['prirastok_vyrobkov_nove_vyrobky/kabelaze']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="kabelaze" onclick="OptionsSelected(this)" <?php echo ($result_BU['prirastok_vyrobkov_nove_vyrobky/kabelaze_poznamka']!=""?"checked":"") ?>>
                                                          <label for="kabelaze">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="vyrobky">Inovované výrobky</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="Počet" name="vyrobky" value="<?php echo ($result_BU['prirastok_vyrobkov_inovovane_vyrobky'])!=""?$result_BU['prirastok_vyrobkov_inovovane_vyrobky']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="vyrobky" onclick="OptionsSelected(this)" <?php echo ($result_BU['prirastok_vyrobkov_inovovane_vyrobky_poznamka']!=""?"checked":"") ?>>
                                                          <label for="vyrobky">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="navody">Nové návody</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="Počet" name="navody" value="<?php echo ($result_BU['prirastok_vyrobkov_nove_navody'])!=""?$result_BU['prirastok_vyrobkov_nove_navody']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="navody" onclick="OptionsSelected(this)" <?php echo ($result_BU['prirastok_vyrobkov_nove_navody_poznamka']!=""?"checked":"") ?>>
                                                          <label for="navody">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="empb">Vzorkovanie EMPB</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="Počet" name="empb" value="<?php echo ($result_BU['prirastok_vyrobkov_vzorkovanie-empb'])!=""?$result_BU['prirastok_vyrobkov_vzorkovanie-empb']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="empb" onclick="OptionsSelected(this)" <?php echo ($result_BU['prirastok_vyrobkov_vzorkovanie-empb_poznamka']!=""?"checked":"") ?>>
                                                          <label for="empb">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteKabelaze" <?php echo ($result_BU['prirastok_vyrobkov_nove_vyrobky/kabelaze_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Nové kabeláže)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteKabelaze" id="" cols="auto" rows="3"><?php echo $result_BU['prirastok_vyrobkov_nove_vyrobky/kabelaze_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteVyrobky" <?php echo ($result_BU['prirastok_vyrobkov_inovovane_vyrobky_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Inovované výrobky)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteVyrobky" id="" cols="auto" rows="3"><?php echo $result_BU['prirastok_vyrobkov_inovovane_vyrobky_poznamka	']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNavody" <?php echo ($result_BU['prirastok_vyrobkov_nove_navody_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Nové návody)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNavody" id="" cols="auto" rows="3"><?php echo $result_BU['prirastok_vyrobkov_nove_navody_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteEmpb" <?php echo ($result_BU['prirastok_vyrobkov_vzorkovanie-empb_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Vzorkovanie EMPB)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEmpb" id="" cols="auto" rows="3"><?php echo $result_BU['prirastok_vyrobkov_vzorkovanie-empb_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Náklady na investície:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="investicie" value="<?php echo ($result_BU['naklady_na_investicie'])!=""?$result_BU['naklady_na_investicie']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="investicie" onclick="OptionsSelected(this)" <?php echo ($result_BU['naklady_na_investicie_poznamka']!=""?"checked":"") ?>>
                                                          <label for="investicie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteInvesticie" <?php echo ($result_BU['naklady_na_investicie_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteInvesticie" id="" cols="auto" rows="3"><?php echo $result_BU['naklady_na_investicie_poznamka']; ?></textarea>
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
                                                
                                                    $query = "SELECT path, ID FROM documents WHERE id_indicator=".$result['id']." AND indicator='av'";
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