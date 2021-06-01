<?php if(($_SESSION['rights']=="VK" && report_exist("VK",$_GET['month'],$_GET['year'])&&/*  ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month"))||*/ edit_enabled("vk",$_GET['month'],$_GET['year']))/*)*/ || ($_SESSION['rights']=="boss" && report_exist("VK",$_GET['month'],$_GET['year']))){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    $query = "SELECT id FROM vk WHERE YEAR(obdobie)=".$_GET['year']." AND "."MONTH(obdobie)=".$_GET['month']." ";
    $apply_query = mysqli_query($connect,$query);
    $result=mysqli_fetch_array($apply_query);
    
    addFile("VK","vk",$result['id']);
    deleteFile($_GET['modul'],"VK");
    
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
        
        $query="UPDATE vk SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)=".$_GET['month']." AND YEAR(obdobie)=".$_GET['year'];
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
									
								
                                       <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-body">
                                                 
                                                 <?php
                                               
                                                    $query_BU="SELECT * FROM vk WHERE YEAR(obdobie)=".$_GET['year']." AND MONTH(obdobie)=".$_GET['month']." ";
                                                    $apply_BU=mysqli_query($connect,$query_BU);
                                                    $result_BU=mysqli_fetch_array($apply_BU);
                                               
                                                ?>
                                                 
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Doba vybavovania reklamácií / % podiel nákladov z tržieb:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <label for="doba_reklamacii">Doba vybavovania reklamácií:</label>
                                                        </span>
                                                       <input class="form-control" type="number" step="0.01" placeholder="Počet dní" name="doba_reklamacii" value="<?php echo ($result_BU['doba_vybavovania_reklamacii'])!=""?$result_BU['doba_vybavovania_reklamacii']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="doba_reklamacii" onclick="OptionsSelected(this)" <?php echo ($result_BU['doba_vybavovania_reklamacii_poznamka']!=""?"checked":"") ?>>
                                                          <label for="doba_reklamacii">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="naklady_z_trzieb">Podiel nákladov z tržieb:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.0001" placeholder="%" name="naklady_z_trzieb" value="<?php echo ($result_BU['podiel_nakladov_z_trzieb'])!=""?$result_BU['podiel_nakladov_z_trzieb']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="naklady_z_trzieb" onclick="OptionsSelected(this)" <?php echo ($result_BU['podiel_nakladov_z_trzieb_poznamka']!=""?"checked":"") ?>>
                                                          <label for="naklady_z_trzieb">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteDobaReklamacii" <?php echo ($result_BU['doba_vybavovania_reklamacii_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Doba vybavovania reklamácií)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteDobaReklamacii" id="" cols="auto" rows="3"><?php echo $result_BU['doba_vybavovania_reklamacii_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNakladyZTrzieb" <?php echo ($result_BU['podiel_nakladov_z_trzieb_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Podiel nákladov z tržieb)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNakladyZTrzieb" id="" cols="auto" rows="3"><?php echo $result_BU['podiel_nakladov_z_trzieb_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Index perfektnej dodávky:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="perfektna_dodavka" value="<?php echo ($result_BU['index_perfektnej_dodavky'])!=""?$result_BU['index_perfektnej_dodavky']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="perfektna_dodavka" onclick="OptionsSelected(this)" <?php echo ($result_BU['index_perfektnej_dodavky_poznamka']!=""?"checked":"") ?>>
                                                          <label for="perfektna_dodavka">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePerfektnaDodavka" <?php echo ($result_BU['index_perfektnej_dodavky_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePerfektnaDodavka" id="" cols="auto" rows="3"><?php echo $result_BU['index_perfektnej_dodavky_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerné dni dodania:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="Počet dní" name="dni_dodania" value="<?php echo ($result_BU['priemerne_dni_dodania'])!=""?$result_BU['priemerne_dni_dodania']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="dni_dodania" onclick="OptionsSelected(this)" <?php echo ($result_BU['priemerne_dni_dodania_poznamka']!=""?"checked":"") ?>>
                                                          <label for="dni_dodania">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteDniDodania" <?php echo ($result_BU['priemerne_dni_dodania_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteDniDodania" id="" cols="auto" rows="3"><?php echo $result_BU['priemerne_dni_dodania_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Efektívnosť predaja:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="efektivnost_predaja" value="<?php echo ($result_BU['efektivnost_predaja'])!=""?$result_BU['efektivnost_predaja']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="efektivnost_predaja" onclick="OptionsSelected(this)" <?php echo ($result_BU['efektivnost_predaja_poznamka']!=""?"checked":"") ?>>
                                                          <label for="efektivnost_predaja">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteEfektivnostPredaja" <?php echo ($result_BU['efektivnost_predaja_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEfektivnostPredaja" id="" cols="auto" rows="3"><?php echo $result_BU['efektivnost_predaja_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Sledovanie objemu predaných výrobkov:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="objem_predanych_vyrobkov" value="<?php echo ($result_BU['sledovanie_objemu_predanych_vyrobkov'])!=""?$result_BU['sledovanie_objemu_predanych_vyrobkov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="objem_predanych_vyrobkov" onclick="OptionsSelected(this)" <?php echo ($result_BU['sledovanie_objemu_predanych_vyrobkov_poznamka']!=""?"checked":"") ?>>
                                                          <label for="objem_predanych_vyrobkov">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nove_vyrobky">Z toho nové výrobky:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="%" name="nove_vyrobky" value="<?php echo ($result_BU['nove_vyrobky'])!=""?$result_BU['nove_vyrobky']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nove_vyrobky" onclick="OptionsSelected(this)" <?php echo ($result_BU['nove_vyrobky_poznamka']!=""?"checked":"") ?>>
                                                          <label for="nove_vyrobky">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteObjemPredanychVyrobkov" <?php echo ($result_BU['sledovanie_objemu_predanych_vyrobkov_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Sledovanie objemu predaných výrobkov)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteObjemPredanychVyrobkov" id="" cols="auto" rows="3"><?php echo $result_BU['sledovanie_objemu_predanych_vyrobkov_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNoveVyrobky" <?php echo ($result_BU['nove_vyrobky_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Z toho nové výrobky)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNoveVyrobky" id="" cols="auto" rows="3"><?php echo $result_BU['nove_vyrobky_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Množstvo predaných E-sad:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nove_vyrobky">Ks:</label>
                                                        </span>
                                                       <input class="form-control" type="number" placeholder="ks" name="esady_ks" value="<?php echo ($result_BU['mnozstvo_predanych_esad_ks'])!=""?$result_BU['mnozstvo_predanych_esad_ks']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="esady_ks" onclick="OptionsSelected(this)" <?php echo ($result_BU['mnozstvo_predanych_esad_ks_poznamka']!=""?"checked":"") ?>>
                                                          <label for="esady_ks">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="esady_eur">€:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="€" name="esady_eur" value="<?php echo ($result_BU['mnozstvo_predanych_esad_eur'])!=""?$result_BU['mnozstvo_predanych_esad_eur']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="esady_eur" onclick="OptionsSelected(this)" <?php echo ($result_BU['mnozstvo_predanych_esad_eur_poznamka']!=""?"checked":"") ?>>
                                                          <label for="esady_eur">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteEsadyKs" <?php echo ($result_BU['mnozstvo_predanych_esad_ks_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Množstvo predaných E-sad ks)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEsadyKs" id="" cols="auto" rows="3"><?php echo $result_BU['mnozstvo_predanych_esad_ks_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteEsadyEur" <?php echo ($result_BU['mnozstvo_predanych_esad_eur_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Množstvo predaných E-sad €)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEsadyEur" id="" cols="auto" rows="3"><?php echo $result_BU['mnozstvo_predanych_esad_eur_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Zákazky k:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group col-md-3">
                                                       <input class="form-control" type="date" placeholder="Dátum" name="zakazky_datum" value="<?php echo ($result_BU['zakazky_k_datum'])!=""?$result_BU['zakazky_k_datum']:""; ?>">
                                                      </div>
                                                      <div class="input-group">
                                                        <input class="form-control" type="number" step="0.01" placeholder="€" name="zakazky_eur" value="<?php echo ($result_BU['zakazky_k'])!=""?$result_BU['zakazky_k']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="zakazky_eur" onclick="OptionsSelected(this)" <?php echo ($result_BU['zakazky_k_poznamka']!=""?"checked":"") ?>>
                                                          <label for="zakazky_eur">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="esady_eur">Na sklade:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="€" name="na_sklade" value="<?php echo ($result_BU['zakazky_k_na_sklade'])!=""?$result_BU['zakazky_k_na_sklade']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="na_sklade" onclick="OptionsSelected(this)" <?php echo ($result_BU['zakazky_k_na_sklade_poznamka']!=""?"checked":"") ?>>
                                                          <label for="na_sklade">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteZakazkyEur" <?php echo ($result_BU['zakazky_k_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Zákazky)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteZakazkyEur" id="" cols="auto" rows="3"><?php echo $result_BU['zakazky_k_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNaSklade" <?php echo ($result_BU['zakazky_k_na_sklade_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Zákazky - na sklade)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNaSklade" id="" cols="auto" rows="3"><?php echo $result_BU['zakazky_k_na_sklade_poznamka']; ?></textarea>
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
                                                
                                                    $query = "SELECT path, ID FROM documents WHERE id_indicator=".$result['id']." AND indicator='vk'";
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
        case "doba_reklamacii":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteDobaReklamacii");
            break;
        case "naklady_z_trzieb":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNakladyZTrzieb");
            break;
        case "perfektna_dodavka":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePerfektnaDodavka");
            break;
        case "dni_dodania":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteDniDodania");
            break;
        case "efektivnost_predaja":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteEfektivnostPredaja");
            break;
        case "objem_predanych_vyrobkov":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteObjemPredanychVyrobkov");
            break;
        case "nove_vyrobky":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNoveVyrobky");
            break;
        case "esady_ks":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteEsadyKs");
            break;
        case "esady_eur":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteEsadyEur");
            break;
        case "zakazky_eur":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteZakazkyEur");
            break;
        case "na_sklade":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNaSklade");
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