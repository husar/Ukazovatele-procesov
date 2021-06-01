<?php if(($_SESSION['rights']=="BU" && report_exist("BU",$_GET['month'],$_GET['year']) && /*($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) || */edit_enabled("bu",$_GET['month'],$_GET['year']))/*)*/ || ($_SESSION['rights']=="boss" && report_exist("BU",$_GET['month'],$_GET['year']))){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    $query = "SELECT id FROM bu WHERE YEAR(obdobie)=".$_GET['year']." AND "."MONTH(obdobie)=".$_GET['month']." ";
    $apply_query = mysqli_query($connect,$query);
    $result=mysqli_fetch_array($apply_query);
    
    addFile("BU","bu",$result['id']);
    deleteFile($_GET['modul'],"BU");
    
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
     
        $query="UPDATE bu SET sent=1, datetime_sent=NOW() WHERE  MONTH(obdobie)=".$_GET['month']." AND YEAR(obdobie)=".$_GET['year'];
        mysqli_query($connect,$query);
        
        echo "<script>location.replace('index.php?modul=prehlad&month=".$_GET['month']."&year=".$_GET['year']."');</script>";
        
    }
    
  /*  if($_GET['obdobie']!=""){    
        
        echo $query="UPDATE bu SET sent=1 WHERE MONTH(obdobie)=".date("m",strtotime($_GET['obdobie']))." AND YEAR(obdobie)=".date("Y",strtotime($_GET['obdobie']));
        mysqli_query($connect,$query);
        
    }*/
    
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
 
                                               
                                                    $query_BU="SELECT * FROM bu WHERE YEAR(obdobie)=".$_GET['year']." AND MONTH(obdobie)=".$_GET['month']." ";
                                                    $apply_BU=mysqli_query($connect,$query_BU);
                                                    $result_BU=mysqli_fetch_array($apply_BU);
                                               
                                    ?>
                                       <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-body">
                                                 
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">HV v EUR kumulatívne:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="hv_v_eur_kumulativne" value="<?php echo ($result_BU['hv_kumulativne'])!=""?$result_BU['hv_kumulativne']:""; ?>" >
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="hv" onclick="OptionsSelected(this)" <?php echo ($result_BU['hv_kumulativne_poznamka']!=""?"checked":"") ?>>
                                                          <label for="hv">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteHV" <?php echo ($result_BU['hv_kumulativne_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteHV" id="" cols="auto" rows="3"><?php echo $result_BU['hv_kumulativne_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Tržby z predaja vl. výrobkov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="trzby_predaj_vyrobkov" value="<?php echo ($result_BU['trzby_vlastne_vyrobky'])!=""?$result_BU['trzby_vlastne_vyrobky']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="predaj_vyrobkov" onclick="OptionsSelected(this)" <?php echo ($result_BU['trzby_vlastne_vyrobky_poznamka']!=""?"checked":"") ?>>
                                                          <label for="predaj_vyrobkov">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePredajVyrobkov" <?php echo ($result_BU['trzby_vlastne_vyrobky_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePredajVyrobkov" id="" cols="auto" rows="3"><?php echo $result_BU['trzby_vlastne_vyrobky_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Spotreba materiálu:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="spotreba_materialu" value="<?php echo ($result_BU['spotreba_materialu'])!=""?$result_BU['spotreba_materialu']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="spotreba_materialu" onclick="OptionsSelected(this)" <?php echo ($result_BU['spotreba_materialu_poznamka']!=""?"checked":"") ?>>
                                                          <label for="spotreba_materialu">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteSpotrebaMaterialu" <?php echo ($result_BU['spotreba_materialu_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteSpotrebaMaterialu" id="" cols="auto" rows="3"><?php echo $result_BU['spotreba_materialu_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Spotreba energie:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="spotreba_energie" value="<?php echo ($result_BU['spotreba_energie'])!=""?$result_BU['spotreba_energie']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="spotreba_energie" onclick="OptionsSelected(this)" <?php echo ($result_BU['spotreba_energie_poznamka']!=""?"checked":"") ?>>
                                                          <label for="spotreba_energie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteSpotrebaEnergie" <?php echo ($result_BU['spotreba_energie_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteSpotrebaEnergie" id="" cols="auto" rows="3"><?php echo $result_BU['spotreba_energie_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Mzdové náklady:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="mzdove_naklady" value="<?php echo ($result_BU['mzdove_naklady'])!=""?$result_BU['mzdove_naklady']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="mzdove_naklady" onclick="OptionsSelected(this)" <?php echo ($result_BU['mzdove_naklady_poznamka']!=""?"checked":"") ?>>
                                                          <label for="mzdove_naklady">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteMzdoveNaklady" <?php echo ($result_BU['mzdove_naklady_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteMzdoveNaklady" id="" cols="auto" rows="3"><?php echo $result_BU['mzdove_naklady_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerný zárobok:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="priemerny_zarobok" value="<?php echo ($result_BU['priemerny_zarobok'])!=""?$result_BU['priemerny_zarobok']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="priemerny_zarobok" onclick="OptionsSelected(this)" <?php echo ($result_BU['priemerny_zarobok_poznamka']!=""?"checked":"") ?>>
                                                          <label for="priemerny_zarobok">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePriemernyZarobok" <?php echo ($result_BU['priemerny_zarobok_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePriemernyZarobok" id="" cols="auto" rows="3"><?php echo $result_BU['priemerny_zarobok_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerný evid. počet zamestnancov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="Počet" name="priemerny_pocet_zamestnancov" value="<?php echo ($result_BU['priemerny_pocet_zamestnancov'])!=""?$result_BU['priemerny_pocet_zamestnancov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="priemerny_pocet_zamestnancov" onclick="OptionsSelected(this)" <?php echo ($result_BU['priemerny_pocet_zamestnancov_poznamka']!=""?"checked":"") ?>>
                                                          <label for="priemerny_pocet_zamestnancov">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePriemernyPocetZamestnancov" <?php echo ($result_BU['priemerny_pocet_zamestnancov_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePriemernyPocetZamestnancov" id="" cols="auto" rows="3"><?php echo $result_BU['priemerny_pocet_zamestnancov_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Evidenčný stav k posl. dňu v mesiaci:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="Počet" name="ev_stav" value="<?php echo ($result_BU['stav_posledny_den'])!=""?$result_BU['stav_posledny_den']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="ev_stav" onclick="OptionsSelected(this)" <?php echo ($result_BU['stav_posledny_den_poznamka']!=""?"checked":"") ?>>
                                                          <label for="ev_stav">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteEvStav" <?php echo ($result_BU['stav_posledny_den_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEvStav" id="" cols="auto" rows="3"><?php echo $result_BU['stav_posledny_den_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Fluktuácia zamestnancov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="fluktacia" value="<?php echo ($result_BU['fluktuacia'])!=""?$result_BU['fluktuacia']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="fluktacia" onclick="OptionsSelected(this)" <?php echo ($result_BU['fluktuacia_poznamka']!=""?"checked":"") ?>>
                                                          <label for="fluktacia">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteFluktacia" <?php echo ($result_BU['fluktuacia_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteFluktacia" id="" cols="auto" rows="3"><?php echo $result_BU['fluktuacia_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Využitie prac. fondu:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <label for="prac_fond_100">str. 100</label>
                                                        </span>
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="prac_fond_100" value="<?php echo ($result_BU['pracovny_fond_100'])!=""?$result_BU['pracovny_fond_100']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prac_fond_100" onclick="OptionsSelected(this)" <?php echo ($result_BU['pracovny_fond_100_poznamka']!=""?"checked":"") ?>>
                                                          <label for="prac_fond_100">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="prac_fond_200">str. 200</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="%" name="prac_fond_200" value="<?php echo ($result_BU['pracovny_fond_200'])!=""?$result_BU['pracovny_fond_200']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prac_fond_200" onclick="OptionsSelected(this)" <?php echo ($result_BU['pracovny_fond_200_poznamka']!=""?"checked":"") ?>>
                                                          <label for="prac_fond_200">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="prac_fond_celkom">celkom</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="%" name="prac_fond_celkom" value="<?php echo ($result_BU['pracovny_fond_mkem'])!=""?$result_BU['pracovny_fond_mkem']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prac_fond_celkom" onclick="OptionsSelected(this)" <?php echo ($result_BU['pracovny_fond_mkem_poznamka']!=""?"checked":"") ?>>
                                                          <label for="prac_fond_celkom">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="notePracFond100" <?php echo ($result_BU['pracovny_fond_100_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (str. 100)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracFond100" id="" cols="auto" rows="3"><?php echo $result_BU['pracovny_fond_100_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="notePracFond200" <?php echo ($result_BU['pracovny_fond_200_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (str. 200)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracFond200" id="" cols="auto" rows="3"><?php echo $result_BU['pracovny_fond_200_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="notePracFondCelkom" <?php echo ($result_BU['pracovny_fond_mkem_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (celkom)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracFondCelkom" id="" cols="auto" rows="3"><?php echo $result_BU['pracovny_fond_mkem_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Nadčasové hodiny:</label>
                                                    <div class="col-md-8">
                                                      <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <label for="nadcas_100">str. 100</label>
                                                        </span>
                                                       <input class="form-control" type="number" step="0.01" placeholder="Počet" name="nadcas_100" value="<?php echo ($result_BU['nadcasove_hodiny_100'])!=""?$result_BU['nadcasove_hodiny_100']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nadcas_100" onclick="OptionsSelected(this)" <?php echo ($result_BU['nadcasove_hodiny_100_poznamka']!=""?"checked":"") ?>>
                                                          <label for="nadcas_100">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nadcas_200">str. 200</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="Počet" name="nadcas_200" value="<?php echo ($result_BU['nadcasove_hodiny_200'])!=""?$result_BU['nadcasove_hodiny_200']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nadcas_200" onclick="OptionsSelected(this)" <?php echo ($result_BU['nadcasove_hodiny_200_poznamka']!=""?"checked":"") ?>>
                                                          <label for="nadcas_200">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nadcas_celkom">celkom</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="Počet" name="nadcas_celkom" value="<?php echo ($result_BU['nadcasove_hodiny_mkem'])!=""?$result_BU['nadcasove_hodiny_mkem']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nadcas_celkom" onclick="OptionsSelected(this)" <?php echo ($result_BU['nadcasove_hodiny_mkem_poznamka']!=""?"checked":"") ?>>
                                                          <label for="nadcas_celkom">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNadcas100" <?php echo ($result_BU['nadcasove_hodiny_100_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (str. 100)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNadcas100" id="" cols="auto" rows="3"><?php echo $result_BU['nadcasove_hodiny_100_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNadcas200" <?php echo ($result_BU['nadcasove_hodiny_200_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (str. 200)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNadcas200" id="" cols="auto" rows="3"><?php echo $result_BU['nadcasove_hodiny_200_poznamka']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNadcasCelkom" <?php echo ($result_BU['nadcasove_hodiny_mkem_poznamka']!=""?"":"style=\"display:none;\"") ?>>
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (celkom)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNadcasCelkom" id="" cols="auto" rows="3"><?php echo $result_BU['nadcasove_hodiny_mkem_poznamka']; ?></textarea>
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
                                                
                                                    $query = "SELECT path, ID FROM documents WHERE id_indicator=".$result['id']." AND indicator='bu'";
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
        case "hv":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteHV");
            break;
        case "predaj_vyrobkov":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePredajVyrobkov");
            break;
        case "spotreba_materialu":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteSpotrebaMaterialu");
            break;
        case "spotreba_energie":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteSpotrebaEnergie");
            break;
        case "mzdove_naklady":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteMzdoveNaklady");
            break;
        case "priemerny_zarobok":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePriemernyZarobok");
            break;
        case "priemerny_pocet_zamestnancov":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePriemernyPocetZamestnancov");
            break;
        case "ev_stav":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteEvStav");
            break;
        case "fluktacia":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteFluktacia");
            break;
        case "prac_fond_100":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePracFond100");
            break;
        case "prac_fond_200":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePracFond200");
            break;
        case "prac_fond_celkom":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("notePracFondCelkom");
            break;
        case "nadcas_100":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNadcas100");
            break;
        case "nadcas_200":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNadcas200");
            break;
        case "nadcas_celkom":
            checkBox = document.getElementById(me.id);
            text = document.getElementById("noteNadcasCelkom");
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