<?php if($_SESSION['rights']=="VK"){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    addFile("VK","vk","-1");
    
    deleteFile($_GET['modul'],"VK");
    
    if(isset($_POST['insert']) || isset($_POST['insert2'])){
        insertData($_SESSION['rights']);
        moveAttahedFile("VK","vk");
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
        
        $query="UPDATE vk SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)='".$_GET['month']."' AND YEAR(obdobie)='".$_GET['year']."' ";
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
                                                   <label class="col-md-3 control-label">Doba vybavovania reklamácií / % podiel nákladov z tržieb:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <label for="doba_reklamacii">Doba vybavovania reklamácií:</label>
                                                        </span>
                                                       <input class="form-control" type="number" step="0.01" placeholder="Počet dní" name="doba_reklamacii" value="<?php echo $_POST['doba_reklamacii']!=""?$_POST['doba_reklamacii']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="doba_reklamacii" onclick="OptionsSelected(this)" <?php echo $_POST['noteDobaReklamacii']!=""?"checked":""; ?>>
                                                          <label for="doba_reklamacii">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="naklady_z_trzieb">Podiel nákladov z tržieb:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.0001" placeholder="%" name="naklady_z_trzieb" value="<?php echo $_POST['naklady_z_trzieb']!=""?$_POST['naklady_z_trzieb']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="naklady_z_trzieb" onclick="OptionsSelected(this)" <?php echo $_POST['noteNakladyZTrzieb']!=""?"checked":""; ?>>
                                                          <label for="naklady_z_trzieb">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteDobaReklamacii" style="<?php echo $_POST['noteDobaReklamacii']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Doba vybavovania reklamácií)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteDobaReklamacii" id="" cols="auto" rows="3"><?php echo $_POST['noteDobaReklamacii']!=""?$_POST['noteDobaReklamacii']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNakladyZTrzieb" style="<?php echo $_POST['noteNakladyZTrzieb']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Podiel nákladov z tržieb)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNakladyZTrzieb" id="" cols="auto" rows="3"><?php echo $_POST['noteNakladyZTrzieb']!=""?$_POST['noteNakladyZTrzieb']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Index perfektnej dodávky:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="perfektna_dodavka" value="<?php echo $_POST['perfektna_dodavka']!=""?$_POST['perfektna_dodavka']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="perfektna_dodavka" onclick="OptionsSelected(this)" <?php echo $_POST['notePerfektnaDodavka']!=""?"checked":""; ?>>
                                                          <label for="perfektna_dodavka">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePerfektnaDodavka" style="<?php echo $_POST['notePerfektnaDodavka']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePerfektnaDodavka" id="" cols="auto" rows="3"><?php echo $_POST['notePerfektnaDodavka']!=""?$_POST['notePerfektnaDodavka']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerné dni dodania:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="Počet dní" name="dni_dodania" value="<?php echo $_POST['dni_dodania']!=""?$_POST['dni_dodania']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="dni_dodania" onclick="OptionsSelected(this)" <?php echo $_POST['noteDniDodania']!=""?"checked":""; ?>>
                                                          <label for="dni_dodania">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteDniDodania" style="<?php echo $_POST['noteDniDodania']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteDniDodania" id="" cols="auto" rows="3"><?php echo $_POST['noteDniDodania']!=""?$_POST['noteDniDodania']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Efektívnosť predaja:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="efektivnost_predaja" value="<?php echo $_POST['efektivnost_predaja']!=""?$_POST['efektivnost_predaja']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="efektivnost_predaja" onclick="OptionsSelected(this)" <?php echo $_POST['noteEfektivnostPredaja']!=""?"checked":""; ?>>
                                                          <label for="efektivnost_predaja">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteEfektivnostPredaja" style="<?php echo $_POST['noteEfektivnostPredaja']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEfektivnostPredaja" id="" cols="auto" rows="3"><?php echo $_POST['noteEfektivnostPredaja']!=""?$_POST['noteEfektivnostPredaja']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Sledovanie objemu predaných výrobkov:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="objem_predanych_vyrobkov" value="<?php echo $_POST['objem_predanych_vyrobkov']!=""?$_POST['objem_predanych_vyrobkov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="objem_predanych_vyrobkov" onclick="OptionsSelected(this)" <?php echo $_POST['noteObjemPredanychVyrobkov']!=""?"checked":""; ?>>
                                                          <label for="objem_predanych_vyrobkov">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nove_vyrobky">Z toho nové výrobky:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="%" name="nove_vyrobky" value="<?php echo $_POST['nove_vyrobky']!=""?$_POST['nove_vyrobky']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nove_vyrobky" onclick="OptionsSelected(this)" <?php echo $_POST['noteEfektivnostPredaja']!=""?"checked":""; ?> >
                                                          <label for="nove_vyrobky">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteObjemPredanychVyrobkov" style="<?php echo $_POST['noteObjemPredanychVyrobkov']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Sledovanie objemu predaných výrobkov)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteObjemPredanychVyrobkov" id="" cols="auto" rows="3"><?php echo $_POST['noteObjemPredanychVyrobkov']!=""?$_POST['noteObjemPredanychVyrobkov']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNoveVyrobky" style="<?php echo $_POST['noteNoveVyrobky']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Z toho nové výrobky)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNoveVyrobky" id="" cols="auto" rows="3"><?php echo $_POST['noteNoveVyrobky']!=""?$_POST['noteNoveVyrobky']:""; ?></textarea>
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
                                                       <input class="form-control" type="number" placeholder="ks" name="esady_ks" value="<?php echo $_POST['esady_ks']!=""?$_POST['esady_ks']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="esady_ks" onclick="OptionsSelected(this)" <?php echo $_POST['noteEsadyKs']!=""?"checked":""; ?>>
                                                          <label for="esady_ks">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="esady_eur">€:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="€" name="esady_eur" value="<?php echo $_POST['esady_eur']!=""?$_POST['esady_eur']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="esady_eur" onclick="OptionsSelected(this)"  <?php echo $_POST['noteEsadyEur']!=""?"checked":""; ?>>
                                                          <label for="esady_eur">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteEsadyKs" style="<?php echo $_POST['noteEsadyKs']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Množstvo predaných E-sad ks)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEsadyKs" id="" cols="auto" rows="3"><?php echo $_POST['noteEsadyKs']!=""?$_POST['noteEsadyKs']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteEsadyEur" style="<?php echo $_POST['noteEsadyEur']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Množstvo predaných E-sad €)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEsadyEur" id="" cols="auto" rows="3"><?php echo $_POST['noteEsadyEur']!=""?$_POST['noteEsadyEur']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Zákazky k:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group col-md-3">
                                                       <input class="form-control" type="date" placeholder="Dátum" name="zakazky_datum" value="<?php echo $_POST['zakazky_datum']!=""?$_POST['zakazky_datum']:""; ?>">
                                                      </div>
                                                      <div class="input-group">
                                                        <input class="form-control" type="number" step="0.01" placeholder="€" name="zakazky_eur" value="<?php echo $_POST['zakazky_eur']!=""?$_POST['zakazky_eur']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="zakazky_eur" onclick="OptionsSelected(this)" <?php echo $_POST['noteZakazkyEur']!=""?"checked":""; ?>>
                                                          <label for="zakazky_eur">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="esady_eur">Na sklade:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="€" name="na_sklade" value="<?php echo $_POST['na_sklade']!=""?$_POST['na_sklade']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="na_sklade" onclick="OptionsSelected(this)" <?php echo $_POST['noteEsadyEur']!=""?"checked":""; ?>>
                                                          <label for="noteNaSklade">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteZakazkyEur" style="<?php echo $_POST['noteZakazkyEur']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Zákazky)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteZakazkyEur" id="" cols="auto" rows="3"><?php echo $_POST['noteZakazkyEur']!=""?$_POST['noteZakazkyEur']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNaSklade" style="<?php echo $_POST['noteNaSklade']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Zákazky - na sklade)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNaSklade" id="" cols="auto" rows="3"><?php echo $_POST['noteNaSklade']!=""?$_POST['noteNaSklade']:""; ?></textarea>
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
                                                
                                                    $documents = scandir("documents/waiting/VK/");
                                                
                                                ?>
                                                <div id="priloha">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Prílohy:</label>
                                                        <div class="col-md-7">
                                                            <p>
                                                                <?php 
                                                                        $docIndex=2;
                                                                        while($docIndex<count($documents)){ ?>
                                                                            <button type="submit" class="btn red" style="padding: 0px 4px; font-size: 10px" name="deleteDoc" value="<?php echo $documents[$docIndex]; ?>">x</button> <a href="documents/waiting/VK/<?php echo $documents[$docIndex]; ?>" download><?php echo $documents[$docIndex]; ?></a><br>
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
<?php } ?>