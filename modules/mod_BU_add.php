<?php if($_SESSION['rights']=="BU"){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    addFile("BU","bu","-1");
    
    deleteFile($_GET['modul'],"BU");
    
    if(isset($_POST['insert']) || isset($_POST['insert2'])){
      
        insertData($_SESSION['rights']);
        moveAttahedFile("BU","bu");
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
        
        $query="UPDATE bu SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)='".$_GET['month']."' AND YEAR(obdobie)='".$_GET['year']."' ";
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
									
								
                                       <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data" name="BUform">
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
                                                   <label class="col-md-3 control-label">HV v EUR kumulatívne:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="hv_v_eur_kumulativne" value="<?php echo $_POST['hv_v_eur_kumulativne']!=""?$_POST['hv_v_eur_kumulativne']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="hv" onclick="OptionsSelected(this)" <?php echo $_POST['noteHV']!=""?"checked":""; ?>>
                                                          <label for="hv">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteHV" style="<?php echo $_POST['noteHV']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteHV" id="" cols="auto" rows="3"><?php echo $_POST['noteHV']!=""?$_POST['noteHV']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Tržby z predaja vl. výrobkov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="trzby_predaj_vyrobkov" value="<?php echo $_POST['trzby_predaj_vyrobkov']!=""?$_POST['trzby_predaj_vyrobkov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="predaj_vyrobkov" onclick="OptionsSelected(this)" <?php echo $_POST['notePredajVyrobkov']!=""?"checked":""; ?>>
                                                          <label for="predaj_vyrobkov">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePredajVyrobkov" style="<?php echo $_POST['notePredajVyrobkov']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePredajVyrobkov" id="" cols="auto" rows="3"><?php echo $_POST['noteHV']!=""?$_POST['noteHV']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Spotreba materiálu:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="spotreba_materialu" value="<?php echo $_POST['spotreba_materialu']!=""?$_POST['spotreba_materialu']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="spotreba_materialu" onclick="OptionsSelected(this)" <?php echo $_POST['noteSpotrebaMaterialu']!=""?"checked":""; ?>>
                                                          <label for="spotreba_materialu">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteSpotrebaMaterialu" style="<?php echo $_POST['noteSpotrebaMaterialu']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteSpotrebaMaterialu" id="" cols="auto" rows="3"><?php echo $_POST['noteSpotrebaMaterialu']!=""?$_POST['noteSpotrebaMaterialu']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Spotreba energie:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="spotreba_energie" value="<?php echo $_POST['spotreba_energie']!=""?$_POST['spotreba_energie']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="spotreba_energie" onclick="OptionsSelected(this)" <?php echo $_POST['noteSpotrebaEnergie']!=""?"checked":""; ?>>
                                                          <label for="spotreba_energie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteSpotrebaEnergie" style="<?php echo $_POST['noteSpotrebaEnergie']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteSpotrebaEnergie" id="" cols="auto" rows="3"><?php echo $_POST['noteSpotrebaEnergie']!=""?$_POST['noteSpotrebaEnergie']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Mzdové náklady:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="mzdove_naklady" value="<?php echo $_POST['mzdove_naklady']!=""?$_POST['mzdove_naklady']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="mzdove_naklady" onclick="OptionsSelected(this)" <?php echo $_POST['noteMzdoveNaklady']!=""?"checked":""; ?>>
                                                          <label for="mzdove_naklady">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteMzdoveNaklady" style="<?php echo $_POST['noteMzdoveNaklady']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteMzdoveNaklady" id="" cols="auto" rows="3"><?php echo $_POST['noteSpotrebaEnergie']!=""?$_POST['noteMzdoveNaklady']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerný zárobok:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="priemerny_zarobok" value="<?php echo $_POST['priemerny_zarobok']!=""?$_POST['priemerny_zarobok']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="priemerny_zarobok" onclick="OptionsSelected(this)" <?php echo $_POST['notePriemernyZarobok']!=""?"checked":""; ?>>
                                                          <label for="priemerny_zarobok">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePriemernyZarobok" style="<?php echo $_POST['notePriemernyZarobok']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePriemernyZarobok" id="" cols="auto" rows="3"><?php echo $_POST['notePriemernyZarobok']!=""?$_POST['notePriemernyZarobok']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Priemerný evid. počet zamestnancov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="Počet" name="priemerny_pocet_zamestnancov" value="<?php echo $_POST['priemerny_pocet_zamestnancov']!=""?$_POST['priemerny_pocet_zamestnancov']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="priemerny_pocet_zamestnancov" onclick="OptionsSelected(this)" <?php echo $_POST['notePriemernyPocetZamestnancov']!=""?"checked":""; ?>>
                                                          <label for="priemerny_pocet_zamestnancov">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="notePriemernyPocetZamestnancov" style="<?php echo $_POST['notePriemernyPocetZamestnancov']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePriemernyPocetZamestnancov" id="" cols="auto" rows="3"><?php echo $_POST['notePriemernyPocetZamestnancov']!=""?$_POST['notePriemernyPocetZamestnancov']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Evidenčný stav k posl. dňu v mesiaci:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" placeholder="Počet" name="ev_stav" value="<?php echo $_POST['ev_stav']!=""?$_POST['ev_stav']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="ev_stav" onclick="OptionsSelected(this)" <?php echo $_POST['noteEvStav']!=""?"checked":""; ?>>
                                                          <label for="ev_stav">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteEvStav" style="<?php echo $_POST['noteEvStav']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEvStav" id="" cols="auto" rows="3"><?php echo $_POST['noteEvStav']!=""?$_POST['noteEvStav']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Fluktuácia zamestnancov:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="fluktacia" value="<?php echo $_POST['fluktacia']!=""?$_POST['fluktacia']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="fluktacia" onclick="OptionsSelected(this)" <?php echo $_POST['noteFluktacia']!=""?"checked":""; ?>>
                                                          <label for="fluktacia">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteFluktacia" style="<?php echo $_POST['noteFluktacia']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteFluktacia" id="" cols="auto" rows="3"><?php echo $_POST['noteFluktacia']!=""?$_POST['noteFluktacia']:""; ?></textarea>
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
                                                       <input class="form-control" type="number" step="0.01" placeholder="%" name="prac_fond_100" value="<?php echo $_POST['prac_fond_100']!=""?$_POST['prac_fond_100']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prac_fond_100" onclick="OptionsSelected(this)" <?php echo $_POST['notePracFond100']!=""?"checked":""; ?>>
                                                          <label for="prac_fond_100">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="prac_fond_200">str. 200</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="%" name="prac_fond_200" value="<?php echo $_POST['prac_fond_200']!=""?$_POST['prac_fond_200']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prac_fond_200" onclick="OptionsSelected(this)" <?php echo $_POST['notePracFond200']!=""?"checked":""; ?>>
                                                          <label for="prac_fond_200">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="prac_fond_celkom">celkom</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="%" name="prac_fond_celkom" value="<?php echo $_POST['prac_fond_celkom']!=""?$_POST['prac_fond_celkom']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="prac_fond_celkom" onclick="OptionsSelected(this)" <?php echo $_POST['notePracFondCelkom']!=""?"checked":""; ?>>
                                                          <label for="prac_fond_celkom">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="notePracFond100" style="<?php echo $_POST['notePracFond100']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (str. 100)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracFond100" id="" cols="auto" rows="3"><?php echo $_POST['notePracFond100']!=""?$_POST['notePracFond100']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="notePracFond200" style="<?php echo $_POST['notePracFond200']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (str. 200)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracFond200" id="" cols="auto" rows="3"><?php echo $_POST['notePracFond200']!=""?$_POST['notePracFond200']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="notePracFondCelkom" style="<?php echo $_POST['notePracFondCelkom']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (celkom)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="notePracFondCelkom" id="" cols="auto" rows="3"><?php echo $_POST['notePracFondCelkom']!=""?$_POST['notePracFondCelkom']:""; ?></textarea>
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
                                                       <input class="form-control" type="number" step="0.01" placeholder="Počet" name="nadcas_100" value="<?php echo $_POST['nadcas_100']!=""?$_POST['nadcas_100']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nadcas_100" onclick="OptionsSelected(this)" <?php echo $_POST['noteNadcas100']!=""?"checked":""; ?>>
                                                          <label for="nadcas_100">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nadcas_200">str. 200</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="Počet" name="nadcas_200" value="<?php echo $_POST['nadcas_200']!=""?$_POST['nadcas_200']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nadcas_200" onclick="OptionsSelected(this)" <?php echo $_POST['noteNadcas200']!=""?"checked":""; ?>>
                                                          <label for="nadcas_200">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="nadcas_celkom">celkom</label>
                                                        </span>
                                                        <input class="form-control" type="number" step="0.01" placeholder="Počet" name="nadcas_celkom" value="<?php echo $_POST['nadcas_celkom']!=""?$_POST['nadcas_celkom']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="nadcas_celkom" onclick="OptionsSelected(this)" <?php echo $_POST['noteNadcasCelkom']!=""?"checked":""; ?>>
                                                          <label for="nadcas_celkom">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNadcas100" style="<?php echo $_POST['noteNadcas100']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (str. 100)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNadcas100" id="" cols="auto" rows="3"><?php echo $_POST['noteNadcas100']!=""?$_POST['noteNadcas100']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNadcas200" style="<?php echo $_POST['noteNadcas200']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (str. 200)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNadcas200" id="" cols="auto" rows="3"><?php echo $_POST['noteNadcas200']!=""?$_POST['noteNadcas200']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNadcasCelkom" style="<?php echo $_POST['noteNadcasCelkom']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (celkom)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNadcasCelkom" id="" cols="auto" rows="3"><?php echo $_POST['noteNadcasCelkom']!=""?$_POST['noteNadcasCelkom']:""; ?></textarea>
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
                                                
                                                    $documents = scandir("documents/waiting/BU/");
                                                
                                                ?>
                                                <div id="priloha">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Prílohy:</label>
                                                        <div class="col-md-7">
                                                            <p>
                                                                <?php 
                                                                        $docIndex=2;
                                                                        while($docIndex<count($documents)){ ?>
                                                                            
                                                                            <button type="submit" class="btn red" style="padding: 0px 4px; font-size: 10px" name="deleteDoc" value="<?php echo $documents[$docIndex]; ?>">x</button> <a href="documents/waiting/BU/<?php echo $documents[$docIndex]; ?>" download><?php echo $documents[$docIndex]; ?></a><br>
                                                                            
                                                                            
                                                                            
                                                                     <?php  $docIndex++; }
                                                                    
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
<?php } ?>