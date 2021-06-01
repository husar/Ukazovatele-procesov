<?php if(($_SESSION['rights']=="PL" && report_exist("PL",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("pl",$_GET['month'],$_GET['year'])==1)/*) */|| ($_SESSION['rights']=="boss" && report_exist("PL",$_GET['month'],$_GET['year']))){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    $query = "SELECT id FROM pl WHERE YEAR(obdobie)=".$_GET['year']." AND "."MONTH(obdobie)=".$_GET['month']." ";
    $apply_query = mysqli_query($connect,$query);
    $result=mysqli_fetch_array($apply_query);
    
    addFile("PL","pl",$result['id']);
    deleteFile($_GET['modul'],"PL");

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
        
        $query="UPDATE pl SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)=".$_GET['month']." AND YEAR(obdobie)=".$_GET['year'];
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
                                               
                                                    $query_BU="SELECT * FROM pl WHERE YEAR(obdobie)=".$_GET['year']." AND MONTH(obdobie)=".$_GET['month']." ";
                                                    $apply_BU=mysqli_query($connect,$query_BU);
                                                    $result_BU=mysqli_fetch_array($apply_BU);
                                               
                                    ?>
								
                                       <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-body">
                                             
                                              <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerná doba obratu zásob voči tržbám:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="Hodnota" name="doba_obratu" value="<?php echo ($result_BU['priemerna_doba_obratu_zasob_voci_trzbam'])!=""?$result_BU['priemerna_doba_obratu_zasob_voci_trzbam']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="doba_obratu" onclick="OptionsSelected(this)" <?php echo ($result_BU['priemerna_doba_obratu_zasob_voci_trzbam_poznamka']!=""?"checked":"") ?>>
                                                          <label for="doba_obratu">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteDobaObratu" <?php echo ($result_BU['priemerna_doba_obratu_zasob_voci_trzbam_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteDobaObratu" id="" cols="auto" rows="3"><?php echo $result_BU['priemerna_doba_obratu_zasob_voci_trzbam_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                               <div class="form-group">
                                                   <label class="col-md-3 control-label">Straty z NVN z odvedenej výroby oproti tržbám :</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                       <span class="input-group-addon">
                                                            <label for="straty_celkom">Celkom:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="Hodnota" name="straty_celkom" value="<?php echo ($result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1'])!=""?$result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="straty_celkom" onclick="OptionsSelected(this)" <?php echo ($result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1_poznamka']!=""?"checked":"") ?>>
                                                          <label for="straty_celkom">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="straty_den">Za deň:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.001" placeholder="Hodnota" name="straty_den" value="<?php echo ($result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2'])!=""?$result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="straty_den" onclick="OptionsSelected(this)" <?php echo ($result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2_poznamka']!=""?"checked":"") ?>>
                                                          <label for="straty_den">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteStratyCelkom" <?php echo ($result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Celkom)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteStratyCelkom" id="" cols="auto" rows="3"><?php echo $result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteStratyDen" <?php echo ($result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Za deň)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteStratyDen" id="" cols="auto" rows="3"><?php echo $result_BU['straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                           </div>
                                           <div class="form-group">
                                                   <label class="col-md-3 control-label">Efektívnosť výroby: reálne hod. ku plánovaným hod. bez zoraďovačov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="efektivnost_hodiny" value="<?php echo ($result_BU['efektivnost_vyroby'])!=""?$result_BU['efektivnost_vyroby']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="efektivnost_hodiny" onclick="OptionsSelected(this)" <?php echo ($result_BU['efektivnost_vyroby_poznamka']!=""?"checked":"") ?>>
                                                          <label for="efektivnost_hodiny">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteEfektivnostHodiny" <?php echo ($result_BU['efektivnost_vyroby_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEfektivnostHodiny" id="" cols="auto" rows="3"><?php echo $result_BU['efektivnost_vyroby_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerný počet výrobných pracovníkov za obd.:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="Hodnota" name="pracovnici_obdobie" value="<?php echo ($result_BU['priemerny_pocet_vyrobnych_pracovnikov_za_obd'])!=""?$result_BU['priemerny_pocet_vyrobnych_pracovnikov_za_obd']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="pracovnici_obdobie" onclick="OptionsSelected(this)" <?php echo ($result_BU['priemerny_pocet_vyrobnych_pracovnikov_za_obd_poznamka']!=""?"checked":"") ?>>
                                                          <label for="pracovnici_obdobie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePracovniciObdobie" <?php echo ($result_BU['priemerny_pocet_vyrobnych_pracovnikov_za_obd_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracovniciObdobie" id="" cols="auto" rows="3"><?php echo $result_BU['priemerny_pocet_vyrobnych_pracovnikov_za_obd_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Počet výrob. pracovníkov - stav k posl.dňu v mesiaci:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="Hodnota" name="pracovnici_mesiac" value="<?php echo ($result_BU['pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci'])!=""?$result_BU['pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="pracovnici_mesiac" onclick="OptionsSelected(this)" <?php echo ($result_BU['pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci_poznamka']!=""?"checked":"") ?>>
                                                          <label for="pracovnici_mesiac">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePracovniciMesiac" <?php echo ($result_BU['pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracovniciMesiac" id="" cols="auto" rows="3"><?php echo $result_BU['pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Efektívnosť výroby: tržby/výrob. pracovník/deň:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="efektivnost_trzby" value="<?php echo ($result_BU['efektivnost_vyroby_trzby/vyrob_pracovnik/den'])!=""?$result_BU['efektivnost_vyroby_trzby/vyrob_pracovnik/den']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="efektivnost_trzby" onclick="OptionsSelected(this)" <?php echo ($result_BU['efektivnost_vyroby_trzby/vyrob_pracovnik/den_poznamka']!=""?"checked":"") ?>>
                                                          <label for="efektivnost_trzby">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteEfektivnostTrzby" <?php echo ($result_BU['efektivnost_vyroby_trzby/vyrob_pracovnik/den_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEfektivnostTrzby" id="" cols="auto" rows="3"><?php echo $result_BU['efektivnost_vyroby_trzby/vyrob_pracovnik/den_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Denný prietok výroby - E-sady (ks):</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="ks" name="prietok_esady" value="<?php echo ($result_BU['denny_prietok_vyroby_esady_ks'])!=""?$result_BU['denny_prietok_vyroby_esady_ks']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prietok_esady" onclick="OptionsSelected(this)" <?php echo ($result_BU['denny_prietok_vyroby_esady_ks_poznamka']!=""?"checked":"") ?>>
                                                          <label for="prietok_esady">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePrietokEsady" <?php echo ($result_BU['denny_prietok_vyroby_esady_ks_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePrietokEsady" id="" cols="auto" rows="3"><?php echo $result_BU['denny_prietok_vyroby_esady_ks_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Denný prietok výroby/výr. pracovníka/deň (€):</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="prietok_pracovnik" value="<?php echo ($result_BU['denny_prietok_vyroby/vyr_pracovnika/den'])!=""?$result_BU['denny_prietok_vyroby/vyr_pracovnika/den']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prietok_pracovnik" onclick="OptionsSelected(this)" <?php echo ($result_BU['denny_prietok_vyroby/vyr_pracovnika/den_poznamka']!=""?"checked":"") ?>>
                                                          <label for="prietok_pracovnik">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePrietokPracovnik" <?php echo ($result_BU['denny_prietok_vyroby/vyr_pracovnika/den_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePrietokPracovnik" id="" cols="auto" rows="3"><?php echo $result_BU['denny_prietok_vyroby/vyr_pracovnika/den_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Plnenie výkonových noriem:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="plnenie_noriem" value="<?php echo ($result_BU['plnenie_vykonovych_noriem'])!=""?$result_BU['plnenie_vykonovych_noriem']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="plnenie_noriem" onclick="OptionsSelected(this)" <?php echo ($result_BU['plnenie_vykonovych_noriem_poznamka']!=""?"checked":"") ?>>
                                                          <label for="plnenie_noriem">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePlnenieNoriem" <?php echo ($result_BU['plnenie_vykonovych_noriem_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePlnenieNoriem" id="" cols="auto" rows="3"><?php echo $result_BU['plnenie_vykonovych_noriem_poznamka']; ?></textarea>
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
                                                
                                                    $query = "SELECT path, ID FROM documents WHERE id_indicator=".$result['id']." AND indicator='pl'";
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
        case "doba_obratu":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteDobaObratu");
            break;    
        case "straty_celkom":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteStratyCelkom");
            break; 
        case "straty_den":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteStratyDen");
            break; 
        case "efektivnost_hodiny":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteEfektivnostHodiny");
            break; 
        case "pracovnici_obdobie":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePracovniciObdobie");
            break; 
        case "pracovnici_mesiac":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePracovniciMesiac");
            break;
        case "efektivnost_trzby":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteEfektivnostTrzby");
            break;
        case "prietok_esady":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePrietokEsady");
            break;
        case "prietok_pracovnik":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePrietokPracovnik");
            break;
        case "plnenie_noriem":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePlnenieNoriem");
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