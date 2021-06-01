<?php if($_SESSION['rights']=="QS"){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    addFile("QS","qs","-1");
    
    deleteFile($_GET['modul'],"QS");
    
    if(isset($_POST['insert']) || isset($_POST['insert2'])){
        insertData($_SESSION['rights'],"QS");
        moveAttahedFile("QS","qs");
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
        
        $query="UPDATE qs SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)='".$_GET['month']."' AND YEAR(obdobie)='".$_GET['year']."' ";
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
                                                   <label class="col-md-3 control-label">Reklamované ks od zákazníkov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="ks" name="reklamovane_od_zakaznikov" value="<?php echo $_POST['reklamovane_od_zakaznikov']!=""?$_POST['reklamovane_od_zakaznikov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="reklamovane_od_zakaznikov" onclick="OptionsSelected(this)" <?php echo $_POST['noteReklamovaneOdZakaznikov']!=""?"checked":""; ?>>
                                                          <label for="reklamovane_od_zakaznikov">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteReklamovaneOdZakaznikov" style="<?php echo $_POST['noteReklamovaneOdZakaznikov']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteReklamovaneOdZakaznikov" id="" cols="auto" rows="3"><?php echo $_POST['noteReklamovaneOdZakaznikov']!=""?$_POST['noteReklamovaneOdZakaznikov']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Uznané reklamované ks od zákazníkov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="ks" name="uznane_reklamacie" value="<?php echo $_POST['uznane_reklamacie']!=""?$_POST['uznane_reklamacie']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="uznane_reklamacie" onclick="OptionsSelected(this)" <?php echo $_POST['noteUznaneReklamacie']!=""?"checked":""; ?>>
                                                          <label for="uznane_reklamacie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteUznaneReklamacie" style="<?php echo $_POST['noteUznaneReklamacie']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteUznaneReklamacie" id="" cols="auto" rows="3"><?php echo $_POST['noteUznaneReklamacie']!=""?$_POST['noteUznaneReklamacie']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Uznané náklady za reklamované ks:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="naklady_reklamacie" value="<?php echo $_POST['naklady_reklamacie']!=""?$_POST['naklady_reklamacie']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="naklady_reklamacie" onclick="OptionsSelected(this)" <?php echo $_POST['noteNakladyReklamacie']!=""?"checked":""; ?>>
                                                          <label for="naklady_reklamacie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteNakladyReklamacie" style="<?php echo $_POST['noteNakladyReklamacie']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNakladyReklamacie" id="" cols="auto" rows="3"><?php echo $_POST['noteNakladyReklamacie']!=""?$_POST['noteNakladyReklamacie']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Náklady na reklamácie od zákazníkov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="naklady_zakaznici" value="<?php echo $_POST['naklady_zakaznici']!=""?$_POST['naklady_zakaznici']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="naklady_zakaznici" onclick="OptionsSelected(this)" <?php echo $_POST['noteNakladyZakaznici']!=""?"checked":""; ?>>
                                                          <label for="naklady_zakaznici">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteNakladyZakaznici" style="<?php echo $_POST['noteNakladyZakaznici']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNakladyZakaznici" id="" cols="auto" rows="3"><?php echo $_POST['noteNakladyZakaznici']!=""?$_POST['noteNakladyZakaznici']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Množstvo zaznamenaných interných NVO:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <label for="nvo_av">AV</label>
                                                        </span>
                                                       <input class="form-control" type="number" placeholder="ks" name="nvo_av" value="<?php echo $_POST['nvo_av']!=""?$_POST['nvo_av']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nvo_av" onclick="OptionsSelected(this)" <?php echo $_POST['noteNvoAv']!=""?"checked":""; ?>>
                                                          <label for="nvo_av">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nvo_pl">PL</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="ks" name="nvo_pl" value="<?php echo $_POST['nvo_pl']!=""?$_POST['nvo_pl']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nvo_pl" onclick="OptionsSelected(this)" <?php echo $_POST['noteNvoPl']!=""?"checked":""; ?>>
                                                          <label for="nvo_pl">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nvo_celkom">Celkom</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="ks" name="nvo_celkom" value="<?php echo $_POST['nvo_celkom']!=""?$_POST['nvo_celkom']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nvo_celkom" onclick="OptionsSelected(this)" <?php echo $_POST['noteNvoCelkom']!=""?"checked":""; ?>>
                                                          <label for="nvo_celkom">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNvoAv" style="<?php echo $_POST['noteNvoAv']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (AV)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNvoAv" id="" cols="auto" rows="3"><?php echo $_POST['noteNvoAv']!=""?$_POST['noteNvoAv']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNvoPl" style="<?php echo $_POST['noteNvoPl']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (PL)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNvoPl" id="" cols="auto" rows="3"><?php echo $_POST['noteNvoPl']!=""?$_POST['noteNvoPl']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNvoCelkom" style="<?php echo $_POST['noteNvoCelkom']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (celkom)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNvoCelkom" id="" cols="auto" rows="3"><?php echo $_POST['noteNvoCelkom']!=""?$_POST['noteNvoCelkom']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Náklady na interné chyby:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="naklady_chyby" value="<?php echo $_POST['naklady_chyby']!=""?$_POST['naklady_chyby']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="naklady_chyby" onclick="OptionsSelected(this)" <?php echo $_POST['noteNakladyChyby']!=""?"checked":""; ?>>
                                                          <label for="naklady_chyby">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteNakladyChyby" style="<?php echo $_POST['noteNakladyChyby']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNakladyChyby" id="" cols="auto" rows="3"><?php echo $_POST['noteNakladyChyby']!=""?$_POST['noteNakladyChyby']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">NV_4 sigma_6210ppm:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="text" placeholder="Hodnota" name="sigma" value="<?php echo $_POST['sigma']!=""?$_POST['sigma']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="sigma" onclick="OptionsSelected(this)" <?php echo $_POST['noteSigma']!=""?"checked":""; ?>>
                                                          <label for="sigma">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteSigma" style="<?php echo $_POST['noteSigma']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteSigma" id="" cols="auto" rows="3"><?php echo $_POST['noteSigma']!=""?$_POST['noteSigma']:""; ?></textarea>
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
                                                
                                                    $documents = scandir("documents/waiting/QS/");
                                                
                                                ?>
                                                <div id="priloha">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Prílohy:</label>
                                                        <div class="col-md-7">
                                                            <p>
                                                                <?php 
                                                                        $docIndex=2;
                                                                        while($docIndex<count($documents)){ ?>
                                                                            <button type="submit" class="btn red" style="padding: 0px 4px; font-size: 10px" name="deleteDoc" value="<?php echo $documents[$docIndex]; ?>">x</button> <a href="documents/waiting/QS/<?php echo $documents[$docIndex]; ?>" download><?php echo $documents[$docIndex]; ?></a><br>
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
        case "reklamovane_od_zakaznikov":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteReklamovaneOdZakaznikov");
            break;
        case "uznane_reklamacie":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteUznaneReklamacie");
            break;
        case "naklady_reklamacie":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNakladyReklamacie");
            break;
        case "naklady_zakaznici":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNakladyZakaznici");
            break;
        case "nvo_av":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNvoAv");
            break;
        case "nvo_pl":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNvoPl");
            break;
        case "nvo_celkom":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNvoCelkom");
            break;
        case "naklady_chyby":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNakladyChyby");
            break;
        case "sigma":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteSigma");
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