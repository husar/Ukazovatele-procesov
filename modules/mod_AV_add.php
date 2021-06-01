<?php if($_SESSION['rights']=="AV"){ ?>
<div class="page-content">
<?php
    include "functions.php";
    
    addFile("AV","av","-1");
    
    deleteFile($_GET['modul'],"AV");
    
    if(isset($_POST['insert']) || isset($_POST['insert2'])){
        insertData($_SESSION['rights']);
        moveAttahedFile("AV","av");
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
        
        $query="UPDATE av SET sent=1, datetime_sent=NOW() WHERE MONTH(obdobie)='".$_GET['month']."' AND YEAR(obdobie)='".$_GET['year']."' ";
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
                                                   <label class="col-md-3 control-label">Priemerný počet dní potrebných na spracovanie dokumentácie za mesiac:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="Hodnota" name="dokumentacia" value="<?php echo $_POST['dokumentacia']!=""?$_POST['dokumentacia']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="dokumentacia" onclick="OptionsSelected(this)" <?php echo $_POST['noteDokumentacia']!=""?"checked":""; ?>>
                                                          <label for="dokumentacia">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteDokumentacia" style="<?php echo $_POST['noteDokumentacia']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteDokumentacia" id="" cols="auto" rows="3"><?php echo $_POST['noteDokumentacia']!=""?$_POST['noteDokumentacia']:""; ?></textarea>
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
                                                       <input class="form-control" type="number" placeholder="Počet" name="kabelaze" value="<?php echo $_POST['kabelaze']!=""?$_POST['kabelaze']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="kabelaze" onclick="OptionsSelected(this)" <?php echo $_POST['noteKabelaze']!=""?"checked":""; ?>>
                                                          <label for="kabelaze">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                      <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="vyrobky">Inovované výrobky</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="Počet" name="vyrobky" value="<?php echo $_POST['vyrobky']!=""?$_POST['vyrobky']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="vyrobky" onclick="OptionsSelected(this)" <?php echo $_POST['noteVyrobky']!=""?"checked":""; ?>>
                                                          <label for="vyrobky">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="navody">Nové návody</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="Počet" name="navody" value="<?php echo $_POST['navody']!=""?$_POST['navody']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="navody" onclick="OptionsSelected(this)" <?php echo $_POST['noteNavody']!=""?"checked":""; ?>>
                                                          <label for="navody">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                        <div class="input-group">
                                                      <span class="input-group-addon">
                                                            <label for="empb">Vzorkovanie EMPB</label>
                                                        </span>
                                                        <input class="form-control" type="number" placeholder="Počet" name="empb" value="<?php echo $_POST['empb']!=""?$_POST['empb']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="empb" onclick="OptionsSelected(this)" <?php echo $_POST['noteEmpb']!=""?"checked":""; ?>>
                                                          <label for="empb">Pridať poznámku</label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteKabelaze" style="<?php echo $_POST['noteKabelaze']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Nové kabeláže)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteKabelaze" id="" cols="auto" rows="3"><?php echo $_POST['noteKabelaze']!=""?$_POST['noteKabelaze']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteVyrobky" style="<?php echo $_POST['noteVyrobky']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Inovované výrobky)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteVyrobky" id="" cols="auto" rows="3"><?php echo $_POST['noteVyrobky']!=""?$_POST['noteVyrobky']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteNavody" style="<?php echo $_POST['noteNavody']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Nové návody)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteNavody" id="" cols="auto" rows="3"><?php echo $_POST['noteNavody']!=""?$_POST['noteNavody']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="noteEmpb" style="<?php echo $_POST['noteEmpb']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka (Vzorkovanie EMPB)</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteEmpb" id="" cols="auto" rows="3"><?php echo $_POST['noteEmpb']!=""?$_POST['noteEmpb']:""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3 control-label">Náklady na investície:</label>
                                                    <div class="col-md-6">
                                                      <div class="input-group">
                                                       <input class="form-control" type="number" step="0.01" placeholder="€" name="investicie" value="<?php echo $_POST['investicie']!=""?$_POST['investicie']:""; ?>">
                                                        <span class="input-group-addon">
                                                         <input type="checkbox" id="investicie" onclick="OptionsSelected(this)" <?php echo $_POST['noteInvesticie']!=""?"checked":""; ?>>
                                                          <label for="investicie">Pridať poznámku</label>
                                                        </span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="noteInvesticie" style="<?php echo $_POST['noteInvesticie']!=""?"":"display:none;" ?>">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Poznámka</label>
                                                        <div class="col-md-7">
                                                        <textarea class="form-control" name="noteInvesticie" id="" cols="auto" rows="3"><?php echo $_POST['noteInvesticie']!=""?$_POST['noteInvesticie']:""; ?></textarea>
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
                                                
                                                    $documents = scandir("documents/waiting/AV/");
                                                
                                                ?>
                                                <div id="priloha">
                                                    <div  class="form-group" >
                                                        <label class="col-md-3 control-label">Prílohy:</label>
                                                        <div class="col-md-7">
                                                            <p>
                                                                <?php 
                                                                        $docIndex=2;
                                                                        while($docIndex<count($documents)){ ?>
                                                                            <button type="submit" class="btn red" style="padding: 0px 4px; font-size: 10px" name="deleteDoc" value="<?php echo $documents[$docIndex]; ?>">x</button> <a href="documents/waiting/AV/<?php echo $documents[$docIndex]; ?>" download><?php echo $documents[$docIndex]; ?></a><br>
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
<?php } ?>