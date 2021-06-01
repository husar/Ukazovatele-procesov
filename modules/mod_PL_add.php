<?php if($_SESSION['rights']=="PL"){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    addFile("PL","pl","-1");
    
    deleteFile($_GET['modul'],"PL");

    if(isset($_POST['insert']) || isset($_POST['insert2'])){
        insertData($_SESSION['rights']);
        moveAttahedFile("PL","pl");
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
        
        $query="UPDATE pl SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)='".$_GET['month']."' AND YEAR(obdobie)='".$_GET['year']."' ";
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
                                                   <label class="col-md-3 control-label">Priemerná doba obratu zásob voči tržbám:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="Hodnota" name="doba_obratu" value="<?php echo $_POST['doba_obratu']!=""?$_POST['doba_obratu']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="doba_obratu" onclick="OptionsSelected(this)" <?php echo $_POST['noteDobaObratu']!=""?"checked":""; ?>>
                                                          <label for="doba_obratu">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteDobaObratu" style="<?php echo $_POST['noteDobaObratu']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteDobaObratu" id="" cols="auto" rows="3"><?php echo $_POST['noteDobaObratu']!=""?$_POST['noteDobaObratu']:""; ?></textarea>
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
                                                        <input class="form-control" type="number" step="0.01" placeholder="Hodnota" name="straty_celkom" value="<?php echo $_POST['straty_celkom']!=""?$_POST['straty_celkom']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="straty_celkom" onclick="OptionsSelected(this)" <?php echo $_POST['noteStratyCelkom']!=""?"checked":""; ?>>
                                                          <label for="straty_celkom">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="straty_den">Za deň:</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.001" placeholder="Hodnota" name="straty_den" value="<?php echo $_POST['straty_den']!=""?$_POST['straty_den']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="straty_den" onclick="OptionsSelected(this)" <?php echo $_POST['noteStratyDen']!=""?"checked":""; ?>>
                                                          <label for="straty_den">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteStratyCelkom" style="<?php echo $_POST['noteStratyCelkom']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Celkom)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteStratyCelkom" id="" cols="auto" rows="3"><?php echo $_POST['noteStratyCelkom']!=""?$_POST['noteStratyCelkom']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteStratyDen" style="<?php echo $_POST['noteStratyDen']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Za deň)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteStratyDen" id="" cols="auto" rows="3"><?php echo $_POST['noteStratyDen']!=""?$_POST['noteStratyDen']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                           </div>
                                           <div class="form-group">
                                                   <label class="col-md-3 control-label">Efektívnosť výroby: reálne hod. ku plánovaným hod. bez zoraďovačov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="efektivnost_hodiny" value="<?php echo $_POST['efektivnost_hodiny']!=""?$_POST['efektivnost_hodiny']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="efektivnost_hodiny" onclick="OptionsSelected(this)" <?php echo $_POST['noteEfektivnostHodiny']!=""?"checked":""; ?>>
                                                          <label for="efektivnost_hodiny">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteEfektivnostHodiny" style="<?php echo $_POST['noteEfektivnostHodiny']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEfektivnostHodiny" id="" cols="auto" rows="3"><?php echo $_POST['noteEfektivnostHodiny']!=""?$_POST['noteEfektivnostHodiny']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerný počet výrobných pracovníkov za obd.:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="Hodnota" name="pracovnici_obdobie" value="<?php echo $_POST['pracovnici_obdobie']!=""?$_POST['pracovnici_obdobie']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="pracovnici_obdobie" onclick="OptionsSelected(this)" <?php echo $_POST['notePracovniciObdobie']!=""?"checked":""; ?>>
                                                          <label for="pracovnici_obdobie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePracovniciObdobie" style="<?php echo $_POST['notePracovniciObdobie']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracovniciObdobie" id="" cols="auto" rows="3"><?php echo $_POST['notePracovniciObdobie']!=""?$_POST['notePracovniciObdobie']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Počet výrob. pracovníkov - stav k posl.dňu v mesiaci:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="Hodnota" name="pracovnici_mesiac" value="<?php echo $_POST['pracovnici_mesiac']!=""?$_POST['pracovnici_mesiac']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="pracovnici_mesiac" onclick="OptionsSelected(this)" <?php echo $_POST['notePracovniciMesiac']!=""?"checked":""; ?>>
                                                          <label for="pracovnici_mesiac">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePracovniciMesiac" style="<?php echo $_POST['notePracovniciMesiac']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracovniciMesiac" id="" cols="auto" rows="3"><?php echo $_POST['notePracovniciMesiac']!=""?$_POST['notePracovniciMesiac']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Efektívnosť výroby: tržby/výrob. pracovník/deň:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="efektivnost_trzby" value="<?php echo $_POST['efektivnost_trzby']!=""?$_POST['efektivnost_trzby']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="efektivnost_trzby" onclick="OptionsSelected(this)" <?php echo $_POST['noteEfektivnostTrzby']!=""?"checked":""; ?>>
                                                          <label for="efektivnost_trzby">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteEfektivnostTrzby" style="<?php echo $_POST['noteEfektivnostTrzby']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEfektivnostTrzby" id="" cols="auto" rows="3"><?php echo $_POST['noteEfektivnostTrzby']!=""?$_POST['noteEfektivnostTrzby']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Denný prietok výroby - E-sady (ks):</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="ks" name="prietok_esady" value="<?php echo $_POST['prietok_esady']!=""?$_POST['prietok_esady']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prietok_esady" onclick="OptionsSelected(this)" <?php echo $_POST['notePrietokEsady']!=""?"checked":""; ?>>
                                                          <label for="prietok_esady">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePrietokEsady" style="<?php echo $_POST['notePrietokEsady']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePrietokEsady" id="" cols="auto" rows="3"><?php echo $_POST['notePrietokEsady']!=""?$_POST['notePrietokEsady']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Denný prietok výroby/výr. pracovníka/deň (€):</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="prietok_pracovnik" value="<?php echo $_POST['prietok_pracovnik']!=""?$_POST['prietok_pracovnik']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prietok_pracovnik" onclick="OptionsSelected(this)" <?php echo $_POST['notePrietokPracovnik']!=""?"checked":""; ?>>
                                                          <label for="prietok_pracovnik">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePrietokPracovnik" style="<?php echo $_POST['notePrietokPracovnik']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePrietokPracovnik" id="" cols="auto" rows="3"><?php echo $_POST['notePrietokPracovnik']!=""?$_POST['notePrietokPracovnik']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Plnenie výkonových noriem:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="plnenie_noriem" value="<?php echo $_POST['plnenie_noriem']!=""?$_POST['plnenie_noriem']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="plnenie_noriem" onclick="OptionsSelected(this)" <?php echo $_POST['notePlnenieNoriem']!=""?"checked":""; ?>>
                                                          <label for="plnenie_noriem">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePlnenieNoriem" style="<?php echo $_POST['notePlnenieNoriem']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePlnenieNoriem" id="" cols="auto" rows="3"><?php echo $_POST['notePlnenieNoriem']!=""?$_POST['notePlnenieNoriem']:""; ?></textarea>
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
                                                
                                                    $documents = scandir("documents/waiting/PL/");
                                                
                                                ?>
                                                <div id="priloha">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Prílohy:</label>
                                                        <div class="col-md-7">
                                                            <p>
                                                                <?php 
                                                                        $docIndex=2;
                                                                        while($docIndex<count($documents)){ ?>
                                                                            <button type="submit" class="btn red" style="padding: 0px 4px; font-size: 10px" name="deleteDoc" value="<?php echo $documents[$docIndex]; ?>">x</button> <a href="documents/waiting/PL/<?php echo $documents[$docIndex]; ?>" download><?php echo $documents[$docIndex]; ?></a><br>
                                                                  <?php           $docIndex++;
                                                                       }
                                                                    
                                                                ?>
                                                            </p>
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
<?php } ?>