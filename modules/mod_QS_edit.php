<?php if(($_SESSION['rights']=="QS" && report_exist("QS",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("qs",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("QS",$_GET['month'],$_GET['year']))){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    $query = "SELECT id FROM qs WHERE YEAR(obdobie)=".$_GET['year']." AND "."MONTH(obdobie)=".$_GET['month']." ";
    $apply_query = mysqli_query($connect,$query);
    $result=mysqli_fetch_array($apply_query);
    
    addFile("QS","qs",$result['id']);
    deleteFile($_GET['modul'],"QS");
    
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
        
        $query="UPDATE qs SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)=".$_GET['month']." AND YEAR(obdobie)=".$_GET['year'];
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
                                               
                                                    $query_BU="SELECT * FROM qs WHERE YEAR(obdobie)=".$_GET['year']." AND MONTH(obdobie)=".$_GET['month']." ";
                                                    $apply_BU=mysqli_query($connect,$query_BU);
                                                    $result_BU=mysqli_fetch_array($apply_BU);
                                               
                                                ?>
                                               
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Reklamované ks od zákazníkov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="ks" name="reklamovane_od_zakaznikov" value="<?php echo ($result_BU['reklamovane_ks_od_zakaznikov'])!=""?$result_BU['reklamovane_ks_od_zakaznikov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="reklamovane_od_zakaznikov" onclick="OptionsSelected(this)" <?php echo ($result_BU['reklamovane_ks_od_zakaznikov_poznamka']!=""?"checked":"") ?>>
                                                          <label for="reklamovane_od_zakaznikov">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteReklamovaneOdZakaznikov" <?php echo ($result_BU['reklamovane_ks_od_zakaznikov_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteReklamovaneOdZakaznikov" id="" cols="auto" rows="3"><?php echo $result_BU['reklamovane_ks_od_zakaznikov_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Uznané reklamované ks od zákazníkov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="ks" name="uznane_reklamacie" value="<?php echo ($result_BU['uznane_reklamovane_ks_od_zakaznikov'])!=""?$result_BU['uznane_reklamovane_ks_od_zakaznikov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="uznane_reklamacie" onclick="OptionsSelected(this)" <?php echo ($result_BU['uznane_reklamovane_ks_od_zakaznikov_poznamka']!=""?"checked":"") ?>>
                                                          <label for="uznane_reklamacie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteUznaneReklamacie" <?php echo ($result_BU['uznane_reklamovane_ks_od_zakaznikov_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteUznaneReklamacie" id="" cols="auto" rows="3"><?php echo $result_BU['uznane_reklamovane_ks_od_zakaznikov_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Uznané náklady za reklamované ks:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="naklady_reklamacie" value="<?php echo ($result_BU['uznane_naklady_za_reklamovane_ks'])!=""?$result_BU['uznane_naklady_za_reklamovane_ks']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="naklady_reklamacie" onclick="OptionsSelected(this)" <?php echo ($result_BU['uznane_naklady_za_reklamovane_ks_poznamka']!=""?"checked":"") ?>>
                                                          <label for="naklady_reklamacie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteNakladyReklamacie" <?php echo ($result_BU['uznane_naklady_za_reklamovane_ks_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNakladyReklamacie" id="" cols="auto" rows="3"><?php echo $result_BU['uznane_naklady_za_reklamovane_ks_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Náklady na reklamácie od zákazníkov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="naklady_zakaznici" value="<?php echo ($result_BU['naklady_na_reklamacie_od_zakaznikov'])!=""?$result_BU['naklady_na_reklamacie_od_zakaznikov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="naklady_zakaznici" onclick="OptionsSelected(this)" <?php echo ($result_BU['naklady_na_reklamacie_od_zakaznikov_poznamky']!=""?"checked":"") ?>>
                                                          <label for="naklady_zakaznici">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteNakladyZakaznici" <?php echo ($result_BU['naklady_na_reklamacie_od_zakaznikov_poznamky']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNakladyZakaznici" id="" cols="auto" rows="3"><?php echo $result_BU['naklady_na_reklamacie_od_zakaznikov_poznamky']; ?></textarea>
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
                                                       <input class="form-control" type="number" placeholder="ks" name="nvo_av" value="<?php echo ($result_BU['mnozstvo_zaznamenanych_internych_nvo_av'])!=""?$result_BU['mnozstvo_zaznamenanych_internych_nvo_av']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nvo_av" onclick="OptionsSelected(this)" <?php echo ($result_BU['mnozstvo_zaznamenanych_internych_nvo_av_poznamka']!=""?"checked":"") ?>>
                                                          <label for="nvo_av">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nvo_pl">PL</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="ks" name="nvo_pl" value="<?php echo ($result_BU['mnozstvo_zaznamenanych_internych_nvo_pl'])!=""?$result_BU['mnozstvo_zaznamenanych_internych_nvo_pl']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nvo_pl" onclick="OptionsSelected(this)" <?php echo ($result_BU['mnozstvo_zaznamenanych_internych_nvo_pl_poznamka']!=""?"checked":"") ?>>
                                                          <label for="nvo_pl">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nvo_celkom">Celkom</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="ks" name="nvo_celkom" value="<?php echo ($result_BU['mnozstvo_zaznamenanych_internych_nvo_celkom'])!=""?$result_BU['mnozstvo_zaznamenanych_internych_nvo_celkom']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nvo_celkom" onclick="OptionsSelected(this)" <?php echo ($result_BU['mnozstvo_zaznamenanych_internych_nvo_celkom_poznamka']!=""?"checked":"") ?>>
                                                          <label for="nvo_celkom">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNvoAv" <?php echo ($result_BU['mnozstvo_zaznamenanych_internych_nvo_av_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (AV)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNvoAv" id="" cols="auto" rows="3"><?php echo $result_BU['mnozstvo_zaznamenanych_internych_nvo_av_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNvoPl" <?php echo ($result_BU['mnozstvo_zaznamenanych_internych_nvo_pl_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (PL)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNvoPl" id="" cols="auto" rows="3"><?php echo $result_BU['mnozstvo_zaznamenanych_internych_nvo_pl_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNvoCelkom" <?php echo ($result_BU['mnozstvo_zaznamenanych_internych_nvo_celkom_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (celkom)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNvoCelkom" id="" cols="auto" rows="3"><?php echo $result_BU['mnozstvo_zaznamenanych_internych_nvo_celkom_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Náklady na interné chyby:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="naklady_chyby" value="<?php echo ($result_BU['naklady_na_interne_chyby'])!=""?$result_BU['naklady_na_interne_chyby']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="naklady_chyby" onclick="OptionsSelected(this)" <?php echo ($result_BU['naklady_na_interne_chyby_poznamka']!=""?"checked":"") ?>>
                                                          <label for="naklady_chyby">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteNakladyChyby" <?php echo ($result_BU['naklady_na_interne_chyby_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNakladyChyby" id="" cols="auto" rows="3"><?php echo $result_BU['naklady_na_interne_chyby_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">NV_4 sigma_6210ppm:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="text" placeholder="Hodnota" name="sigma" value="<?php echo ($result_BU['nv_4_sigma_6210ppm'])!=""?$result_BU['nv_4_sigma_6210ppm']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="sigma" onclick="OptionsSelected(this)" <?php echo ($result_BU['nv_4_sigma_6210ppm_poznamka']!=""?"checked":"") ?>>
                                                          <label for="sigma">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteSigma" <?php echo ($result_BU['nv_4_sigma_6210ppm_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteSigma" id="" cols="auto" rows="3"><?php echo $result_BU['nv_4_sigma_6210ppm_poznamka']; ?></textarea>
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
                                                
                                                    $query = "SELECT path, ID FROM documents WHERE id_indicator=".$result['id']." AND indicator='qs'";
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