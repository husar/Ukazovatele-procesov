<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<div class="page-content">
<?php
    include "functions.php";
    
    $datum=$_GET['year']."-".(strlen($_GET['month'])==1?"0":"").$_GET['month']."-01";
    
    enable_editing($_GET['rights'],$_GET['month'],$_GET['year']);

?>
 <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-search"></i> Vyhľadávanie
                                            
											</div>
                                     <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="Zbaliť/Rozbaliť" title=""> </a>
                                            
                                        </div>
                                      
                                    </div>
                                    <div class="portlet-body form">
                                    <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data">
                                                    <div class="form-body">
                                                <div class="form-group">
                                                     
                                                    <div class="col-md-2">
                                                        <select name="months[]" id="months" multiple class="chosen-select form-control" style="width:100px">
                                                         <option value="" disabled selected>Vyber dátum</option>
                                                          <?php
                                                            $fromYear=2020;
                                                            while($fromYear<=date("Y")){
                                                                for($month=1; $month<=12; $month++){
                                                            ?>
                                                            
                                                           <option value="<?php echo $month."/".$fromYear ?>" <?php echo ($fromYear==$_GET['year'] && $month==$_GET['month'])?"disabled ":"" ?> <?php echo (in_array($month."/".$fromYear,$_POST['months'])?"selected ":"") ?> ><?php echo $month."/".$fromYear ?></option>
                                                           <?php 
                                                                }
                                                                $fromYear++;
                                                            }

                                                            ?>


                                                        </select>
                                                        
													</div>
                                                   <div class="col-md-2">
                                                        <a href="javascript:void(0);" id="printPage" class="btn blue" onclick="printPage();">Vytlačiť záznam <i class="fa fa-print" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="http://webserver:8081/Sprava/vedenie/SitePages/Vedenie%20%C3%9Avod.aspx?RootFolder=%2FSprava%2Fvedenie%2FDokumenty%20%20VEDENIE%2FPorada%2FUkazovatele%20procesov%2FU%20procesov%5F<?php echo $_GET['year']; ?>&FolderCTID=0x0120009D90BF38105337418205E486DC8F6397&View={73015F51-590B-477B-A82E-90563D6BD8BD}" id="openSharePoint" class="btn blue" target="_blank">Otvoriť SharePoint <i class="fa fa-user" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="col-md-2"> 
                                                        <input type="checkbox" id="notes" onclick="OptionsSelected(this)">
                                                        <label for="notes">Skryť poznámky</label>
                                                    </div>
                                                    
                                                    <div class="col-md-12"> 
                                                       <button type="submit" class="btn blue" name="insert">Porovnať</button>
                                                    </div> 
                                                    
                                                    </div>
                                                    </div>
                                               
                                    </form>
                                      <form action=""></form>
                                       </div>
                                </div>       
                  <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-tasks" aria-hidden="true"></i><?php echo $_GET['month']."/".$_GET['year']; ?></div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="Zbaliť/Rozbaliť" title=""> </a>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="portlet-body">
                                    
                                    
                                    <div class="table-responsive tableFixHead" style="width: auto; height: 700px; overflow: auto;">
                                      
                                       <table class="table table-bordered">
                                           <thead> 
                                               <?php
                                               
                                                $months=array($_GET['month']);
                                                $years=array($_GET['year']);
                                                
                                                if(isset($_POST['months'])){
                                                    $selectbox=$_POST['months'];
                                                    foreach($selectbox as $selected){
                                                        $date=explode("/",$selected);
                                                        array_push($months,$date[0]);
                                                        array_push($years,$date[1]);
                                                    }    
                                                }
                                                $count_of_periods=count($months);
                                               ?>
                                                
                                                <tr style="background: #ffff4f;"> 
                                                    <th colspan="2" style="text-align:center; vertical-align: middle; font-size: 100%;width:39%;">Ukazovateľ</th> 
                                                    <?php
                                                        $num_of_actual_period=0;
                                                        while($num_of_actual_period<$count_of_periods){
                                                    
                                                    ?>
                                                    <th colspan="4" style="text-align:center; vertical-align: middle; font-size: 100%;"><?php echo $months[$num_of_actual_period]."/".$years[$num_of_actual_period]; ?></th>
                                                    <th style="text-align:center; vertical-align: middle; font-size: 100%; width:25%;" class="note">Poznámka (<?php echo $months[$num_of_actual_period]."/".$years[$num_of_actual_period]; ?>)</th>
                                                    <?php
                                                            
                                                            $num_of_actual_period++;
                                                        } 
                                                    
                                                    ?>
                                                    
                                                </tr>
                                            </thead> 
                                              
                                               <tbody style="background: #a2eb75;"> 
                                               <?php
                                                    
                                                    include "includes/find_all_data_bu.php"
                                                    
                                               
                                                ?>
                                                <tr>
                                                   
                                                    <th rowspan="13" style="text-align:center; vertical-align: middle; font-size: 100%; background: #a2eb75; padding: 0px; border-left: 15px solid <?php echo(edit_enabled("bu",$_GET['month'],$_GET['year']) || !report_exist("BU",$_GET['month'],$_GET['year']))?"red":"green" ?>; width: 10%" id="BU">
                                                    <?php if($_SESSION['rights']=="boss" && report_exist("BU",$_GET['month'],$_GET['year'])){ ?>
                                                    <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=bu&enable_editing=1" style=" font-size:90%;">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                    <br>
                                                    <?php } ?>
                                                    BU <?php attachmentsExists("bu",$id[0]); ?>
                                                    
                                                    <?php if(($_SESSION['rights']=="BU" && report_exist("BU",$_GET['month'],$_GET['year']) && /*($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) || */edit_enabled("bu",$_GET['month'],$_GET['year']))/*)*/ || ($_SESSION['rights']=="boss" && report_exist("BU",$_GET['month'],$_GET['year']))){ ?>
                                                    <br><a href="?modul=BU-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><br>
                                                    <?php }
                                                        if(report_exist("BU",$_GET['month'],$_GET['year']) && isLocked("bu",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("bu",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }
                                                        ?>
                                                    </th>
                                                    
                                                    
                                                </tr>
                                                <tr style="background: #92D050; ">
                                                    <td style="padding: 0px;font-size: 12px"><b>HV v EUR kumulatívne</b> </td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($hv_kumulativne as $value){
                                                    ?>
                                                    <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                    <td class="note" style="padding: 0px;font-size: 12px"><?php echo $hv_kumulativne_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                </tr>                                    
                                                <tr>
                                                    <td style="padding: 0px;font-size: 12px"><b>Tržby z predaja vl.výrobkov</b></td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($trzby_vlastne_vyrobky as $value){
                                                    ?>
                                                    <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                    <td class="note" style="padding: 0px;font-size: 12px"><?php echo $trzby_vlastne_vyrobky_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                </tr>
                                                <tr style="background: #92D050; ">
                                                    <td style="padding: 0px;font-size: 12px"><b>Spotreba materiálu</b></td>
                                                    <?php
                                                    $index=0;
                                                        foreach ($spotreba_materialu as $value){
                                                    ?>
                                                    <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                    <td class="note" style="padding: 0px;font-size: 12px"><?php echo $spotreba_materialu_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0px;font-size: 12px"><b>Spotreba energie</b></td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($spotreba_energie as $value){
                                                    ?>
                                                    <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                    <td class="note" style="padding: 0px;font-size: 12px"><?php echo $spotreba_energie_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                <tr style="background: #92D050; ">
                                                    <td style="padding: 0px;font-size: 12px"><b>Mzdové náklady</b></td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($mzdove_naklady as $value){
                                                    ?>
                                                    <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                    <td class="note" style="padding: 0px;font-size: 12px"><?php echo $mzdove_naklady_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                </tr>
                                                <tr>
                                                    <td  style="padding: 0px;font-size: 12px"><b>Priemerný zárobok</b></td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($priemerny_zarobok as $value){
                                                    ?>
                                                    <td colspan="4"  style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                    <td class="note"  style="padding: 0px;font-size: 12px"><?php echo $priemerny_zarobok_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                </tr>
                                                <tr style="background: #92D050; ">
                                                    <td  style="padding: 0px;font-size: 12px"><b>Priemerný evid. počet zamestnancov</b></td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($priemerny_pocet_zamestnancov as $value){
                                                    ?>
                                                    <td colspan="4"  style="padding: 0px;font-size: 12px"><?php echo number_format($value,0,',',' '); ?></td>
                                                    <td class="note"  style="padding: 0px;font-size: 12px"><?php echo $priemerny_pocet_zamestnancov_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0px;font-size: 12px"><b>Evidenčný stav k posl.dňu v mesiaci</b></td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($eviden_stav_mesiac as $value){
                                                    ?>
                                                    <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,0,',',' '); ?></td>
                                                    <td class="note" style="padding: 0px;font-size: 12px"><?php echo $eviden_stav_mesiac_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                </tr>
                                                <tr style="background: #92D050; ">
                                                    <td style="padding: 0px;font-size: 12px"><b>Fluktuácia zamestnancov /%/</b></td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($fluktuacia as $value){
                                                    ?>
                                                    <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                    <td class="note" style="padding: 0px;font-size: 12px"><?php echo $fluktuacia_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2" style="padding: 0px;;font-size: 12px"><b>Využitie prac. fondu /%/</b></td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($spotreba_materialu as $value){
                                                    ?>
                                                    <td style="padding: 0px; font-size: 12px"><b>str. 100</b></td>
                                                    <td style="padding: 0px;font-size: 12px"><b>str. 200</b></td>
                                                    <td colspan="2" style="padding: 0px;font-size: 12px"><b>mkem celkom</b></td>
                                                    <td class="note" style="padding: 0px;font-size: 12px"><?php echo $prac_fond_100_p[$index].($prac_fond_100_p[$index]!=""?"<br>":"").$prac_fond_200_p[$index].($prac_fond_200_p[$index]!=""?"<br>":"").$prac_fond_celkom_p[$index]; ?></td>
                                                    <?php $index++; } ?>
                                                </tr>
                                                <tr >
                                                    <?php
                                                        $index=0;
                                                        foreach ($prac_fond_100 as $value){
                                                    ?>
                                                        <td style="padding: 0px; background: #92D050;;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                        <td style="padding: 0px; background: #92D050;;font-size: 12px"><?php echo number_format($prac_fond_200[$index],2,',',' '); ?></td>
                                                        <td colspan="2" style="padding: 0px; background: #92D050;;font-size: 12px"><?php echo number_format($prac_fond_celkom[$index],2,',',' '); ?></td>
                                                        <td rowspan="2" class="note" style="padding: 0px;font-size: 12px"><?php echo $nadcas_100_p[$index].($nadcas_100_p[$index]!=""?"<br>":"").$nadcas_200_p[$index].($nadcas_200_p[$index]!=""?"<br>":"").$nadcas_celkom_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0px;font-size: 12px"><b>Nadčasové hodiny</b></td>
                                                    <?php
                                                        $index=0;
                                                        foreach ($nadcas_100 as $value){
                                                    ?>
                                                    <td style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                    <td style="padding: 0px;font-size: 12px"><?php echo number_format($nadcas_200[$index],2,',',' '); ?></td>
                                                    <td colspan="2" style="padding: 0px;font-size: 12px"><?php echo number_format($nadcas_celkom[$index],2,',',' '); ?></td>
                                                    <?php $index++; } ?>
                                                </tr> 
                                                </tbody> 
                                                <tbody style="background: #FFCCCC">
                                                   <?php
                                                    
                                                    include "includes/find_all_data_vk.php"
                                                    
                                               
                                                ?>
                                                    <tr>
                                                        <th rowspan="9" style="text-align:center; vertical-align: middle; font-size: 100%; background: #FFCCCC; border-left: 15px solid <?php echo(edit_enabled("vk",$_GET['month'],$_GET['year']) || !report_exist("VK",$_GET['month'],$_GET['year']))?"red":"green" ?>;" id="VK">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("VK",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=vk&enable_editing=1" style=" font-size:90%;">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        VK <?php attachmentsExists("vk",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="VK" && report_exist("VK",$_GET['month'],$_GET['year'])&&/*  ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month"))||*/ edit_enabled("vk",$_GET['month'],$_GET['year']))/*)*/ || ($_SESSION['rights']=="boss" && report_exist("VK",$_GET['month'],$_GET['year']))){ ?>
                                                        <br><a href="?modul=VK-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php } 
                                                        if(report_exist("VK",$_GET['month'],$_GET['year']) && isLocked("vk",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("vk",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr style="background: #ffacac">
                                                        <td style="padding: 0px;font-size: 12px"><b>Doba vybavovania reklamácií / %podiel nákladov z tržieb</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($vybavovanie_reklamacii as $value){
                                                        ?>
                                                        <td colspan="2" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> dní</td>
                                                        <td colspan="2" style="padding: 0px;font-size: 12px"><?php echo number_format($podiel_nakladov[$index],4,',',' '); ?> %</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $vybavovanie_reklamacii_p[$index].($vybavovanie_reklamacii_p[$index]!=""?"<br>":"").$podiel_nakladov_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr> 
                                                    <tr>
                                                        <td style="padding: 0px;font-size: 12px"><b>Index perfektnej dodávky</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($index_dodavky as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> %</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $index_dodavky_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #ffacac">
                                                        <td style="padding: 0px;font-size: 12px"><b>Priemerné dni dodania</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($dni_dodania as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> dní</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $dni_dodania_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0px;font-size: 12px"><b>Efektívnosť predaja</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($efektivnost_predaja as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> %</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $efektivnost_predaja_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #ffacac">
                                                        <td style="padding: 0px;font-size: 12px"><b>Sledovanie objemu predaných výrobkov</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($objem_predanych_vyrobkov as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $objem_predanych_vyrobkov_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0px;font-size: 12px"><b>Z toho nové výrobky</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($objem_predanych_vyrobkov as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> %</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $objem_predanych_vyrobkov_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #ffacac">
                                                        <td style="padding: 0px;font-size: 12px"><b>Množstvo predaných E-sad</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($esady_ks as $value){
                                                        ?>
                                                        <td colspan="2" style="padding: 0px;font-size: 12px"><?php echo number_format($value,0,',',' '); ?> ks</td>
                                                        <td colspan="2" style="padding: 0px;font-size: 12px"><?php echo number_format($esady_eur[$index],2,',',' '); ?> €</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $esady_ks_p[$index].($esady_ks_p[$index]!=""?"<br>":"").$esady_eur_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0px;font-size: 12px"><b>Zákazky k</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($zakazky_datum as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><b><?php echo $value; ?></b> &emsp; &emsp; <?php echo number_format($zakazky[$index],2,',',' '); ?> € &emsp; &emsp;<b> Na sklade:</b> <?php echo number_format($zakazky_skladom[$index],2,',',' '); ?> €</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $zakazky_p[$index].($zakazky_p[$index]!=""?"<br>":"").$zakazky_skladom_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                </tbody>
                                                <tbody style="background: #9BC2E6">
                                                   <?php

                                                    include "includes/find_all_data_qs.php";

?>
                                                    <tr>
                                                        <th rowspan="9" style="text-align:center; vertical-align: middle; font-size: 100%; background: #9BC2E6; border-left: 15px solid <?php echo(edit_enabled("qs",$_GET['month'],$_GET['year']) || !report_exist("QS",$_GET['month'],$_GET['year']))?"red":"green" ?>;" id="QS">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("QS",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=qs&enable_editing=1" style=" font-size:90%;">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        QS <?php attachmentsExists("qs",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="QS" && report_exist("QS",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("qs",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("QS",$_GET['month'],$_GET['year']))){ ?>
                                                        <br><a href="?modul=QS-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }  
                                                        if(report_exist("QS",$_GET['month'],$_GET['year']) && isLocked("qs",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("qs",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr style="background: #79bfff">
                                                        <td style="padding: 0px;font-size: 12px"><b>Reklamované ks od zákazníkov</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($reklamovane as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> ks</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $reklamovane_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr> 
                                                    <tr>
                                                        <td style="padding: 0px;font-size: 12px"><b>Uznané reklamované ks od zákazníkov</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($uznane as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> ks</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $uznane_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr> 
                                                    <tr style="background: #79bfff">
                                                        <td style="padding: 0px;font-size: 12px"><b>Uznané náklady za reklamované ks</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($uznane_naklady as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $uznane_naklady_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0px;font-size: 12px"><b>Náklady na reklamácie od zákazníkov </b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($naklady_reklamacie as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $naklady_reklamacie_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #79bfff">
                                                        <td rowspan="2" style="padding: 0px;font-size: 12px"><b>Množstvo zaznamenaných interných NVO (ks)</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($nvo_av as $value){
                                                        ?> 
                                                        <td style="padding: 0px;font-size: 12px"><b>AV</b></td>
                                                        <td style="padding: 0px;font-size: 12px"><b>PL</b></td>
                                                        <td colspan="2" style="padding: 0px;font-size: 12px"><b>Celkom</b></td>
                                                        <td rowspan="2" class="note" style="padding: 0px;font-size: 12px"><?php echo $nvo_av_p[$index].($nvo_av_p[$index]!=""?"<br>":"").$nvo_pl_p[$index].($nvo_pl_p[$index]!=""?"<br>":"").$nvo_celkom_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr>
                                                       <?php
                                                            $index=0;
                                                            foreach ($nvo_av as $value){
                                                        ?>
                                                        <td style="padding: 0px; background: #79bfff;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> ks</td>
                                                        <td style="padding: 0px; background: #79bfff;font-size: 12px"><?php echo number_format($nvo_pl[$index],2,',',' '); ?> ks</td>
                                                        <td colspan="2" style="padding: 0px; background: #79bfff;font-size: 12px"><?php echo number_format($nvo_celkom[$index],2,',',' '); ?> ks</td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0px;font-size: 12px"><b>Náklady na interné chyby /€/</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($naklady_chyby as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $naklady_chyby_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #79bfff">
                                                        <td style="padding: 0px;font-size: 12px"><b>NV_4 sigma_6210ppm</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($sigma as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo $value; ?></td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $sigma_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                   
                                                </tbody>
                                                <tbody style="background: #BDD7EE">
                                                   <?php
                                                    
                                                        include "includes/find_all_data_qv.php";
                                                    
                                                    ?>
                                                    <tr>
                                                        <th rowspan="2" style="text-align:center; vertical-align: middle; font-size: 100%; background: #BDD7EE; border-left: 15px solid <?php echo(edit_enabled("qv",$_GET['month'],$_GET['year']) || !report_exist("QV",$_GET['month'],$_GET['year']))?"red":"green" ?>; padding: 0px; height: 20px" id="QV">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("QV",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=qv&enable_editing=1" style=" font-size:90%;">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        QV <?php attachmentsExists("qv",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="QV" && report_exist("QV",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("qv",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("QV",$_GET['month'],$_GET['year']))){ ?>
                                                        <br>
                                                        <a href="?modul=QV-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }   
                                                        if(report_exist("QV",$_GET['month'],$_GET['year']) && isLocked("qv",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("qv",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr >
                                                        <td style=" padding: 0px; height: 80px;font-size: 12px"><b>Slovné hodnotenie riešených projektov</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($hodnotenie as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px; height: 80px;font-size: 12px">
                                                            <div id="shortRecord">
                                                                    <?php 
                                                                        $id=0;
                                                                        $short_length = 100;
                                                                        $short = substr($value, 0, $short_length);
                                                                        echo $short;
                                                                    ?>
                                                            </div>
                                                            <br>    
                                                            <?php if(strlen($value)>200){ ?>
                                                            <button class="btn blue" id="showMoreBtn" name="showMore" onclick="showMore()">Zobraziť viac <i class="fa fa-arrow-down"></i></button>
                                                            <?php } ?>
                                                            <button style="display: none;" class="btn blue" id="showLessBtn" name="showLess" onclick="showLess()">Zobraziť menej <i class="fa fa-arrow-up"></i></button>
                                                            <div id="longRecord" class="fullRecord" style="display: none;">
                                                                <?php echo $value; ?>
                                                            </div>
                                                        </td>
                                                        <td class="note" style="padding: 0px; height: 80px;font-size: 12px"><?php echo $hodnotenie_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                </tbody>
                                                <tbody style="background: #D0CECE">
                                                   <?php
                                               
                                               include "includes/find_all_data_pl.php";
                                               
                                                ?>
                                               
                                                    <tr>
                                                        <th rowspan="10" style="text-align:center; vertical-align: middle; font-size: 100%; background: #D0CECE; border-left: 15px solid <?php echo(edit_enabled("pl",$_GET['month'],$_GET['year']) || !report_exist("PL",$_GET['month'],$_GET['year']))?"red":"green" ?>;" id="PL">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("PL",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=pl&enable_editing=1" style=" font-size:90%;">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        PL <?php attachmentsExists("pl",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="PL" && report_exist("PL",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("pl",$_GET['month'],$_GET['year'])==1)/*) */|| ($_SESSION['rights']=="boss" && report_exist("PL",$_GET['month'],$_GET['year']))){ ?>
                                                        <br><a href="?modul=PL-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }   
                                                        if(report_exist("PL",$_GET['month'],$_GET['year']) && isLocked("pl",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("pl",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr style="background: #b7b7b7">
                                                        <td style=" padding: 0px;font-size: 12px"><b>Priemerná doba obratu zásob voči tržbám</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($doba_obratu as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $doba_obratu_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr >
                                                        <td style=" padding: 0px;font-size: 12px"><b>Straty z NVN z odvedenej výroby oproti tržbám </b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($straty_nvn as $value){
                                                        ?>
                                                        <td colspan="2" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,3,',',' '); ?></td>
                                                        <td colspan="2" style=" padding: 0px;font-size: 12px"><?php echo number_format($oproti_trzbam[$index],3,',',' '); ?></td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $straty_nvn_p[$index].($straty_nvn_p[$index]!=""?"<br>":"").$oproti_trzbam_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #b7b7b7">
                                                        <td style=" padding: 0px;font-size: 12px"><b>Efektívnosť výroby: reálne hod. ku plánovaným hod. bez zoraďovačov</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($efektivnost as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> %</td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $efektivnost_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr >
                                                        <td style=" padding: 0px;font-size: 12px"><b>Priemerný počet výrobných pracovníkov za obd.</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($vyrobny_pracovnici as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $vyrobny_pracovnici_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #b7b7b7">
                                                        <td style=" padding: 0px;font-size: 12px"><b>Počet výrob. pracovníkov - stav k posl.dňu v mesiaci</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($pracovnici_posl_den as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $pracovnici_posl_den_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr>
                                                        <td style=" padding: 0px;font-size: 12px"><b>Efektívnosť výroby: tržby/výrob. pracovník/deň</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($efektivnost_trzby as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $efektivnost_trzby_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #b7b7b7">
                                                        <td style=" padding: 0px;font-size: 12px"><b>Denný prietok výroby - E-sady (ks)</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($prietok_ks as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $prietok_ks_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr>
                                                        <td style=" padding: 0px;font-size: 12px"><b>Denný prietok výroby/výr. pracovníka/deň (€)</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($prietok_eur as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $prietok_eur_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #b7b7b7">
                                                        <td style=" padding: 0px;font-size: 12px"><b>Plnenie výkonových noriem</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($plnenie_noriem as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> %</td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $plnenie_noriem_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                </tbody>
                                                <tbody style="background: #a29a61">
                                                   <?php
                                               
                                                    include "includes/find_all_data_pl200.php";
                                               
                                                ?>
                                                    <tr>
                                                        <th rowspan="4" style="text-align:center; vertical-align: middle; font-size: 100%; background: #a29a61; border-left: 15px solid <?php echo(edit_enabled("pl200",$_GET['month'],$_GET['year']) || !report_exist("PL200",$_GET['month'],$_GET['year']))?"red":"green" ?>;" id="PL200">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("PL200",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=pl200&enable_editing=1" style=" font-size:90%;">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        PL200 <?php attachmentsExists("pl200",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="PL200" && report_exist("PL200",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("pl200",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("PL200",$_GET['month'],$_GET['year']))){ ?>
                                                        <br><a href="?modul=PL200-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }   
                                                        if(report_exist("PL200",$_GET['month'],$_GET['year']) && isLocked("pl200",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("pl200",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr >
                                                        <td style=" padding: 0px;font-size: 12px"><b>Vyrobené kusy</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($vyrobene_kusy as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px; height: 32px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $vyrobene_kusy_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #aca88c">
                                                        <td style=" padding: 0px;font-size: 12px; height: 32px"><b>NTO v /%/ na vyrobené množstvo dielcov </b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($dielce as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> %</td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $dielce_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr >
                                                        <td  style=" padding: 0px;font-size: 12px; height: 32px"><b>Hodnota NTO za celé obdobie</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($nto as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $nto_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                </tbody>
                                                <tbody style="background: #AEAAAA">
                                                   <?php
                                               
                                                    include "includes/find_all_data_pl_smt_tht.php";
                                               
                                                ?>
                                                    <tr>
                                                        <th rowspan="2" style="text-align:center; vertical-align: middle; font-size: 100%; background: #AEAAAA; border-left: 15px solid <?php echo(edit_enabled("pl_smt_tht",$_GET['month'],$_GET['year']) || !report_exist("PL SMT/THT",$_GET['month'],$_GET['year']))?"red":"green" ?>;" id="PL SMT/THT">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("PL SMT/THT",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=pl_smt_tht&enable_editing=1" style="font-size:90%">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        PL SMT/THT <?php attachmentsExists("pl_smt_tht",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="PL SMT/THT" && report_exist("PL SMT/THT",$_GET['month'],$_GET['year']) && /*($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("pl_smt_tht",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("PL SMT/THT",$_GET['month'],$_GET['year']))){ ?>
                                                        <br><a href="?modul=PL SMT/THT-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style="font-size:90%">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }   
                                                        if(report_exist("PL SMT/THT",$_GET['month'],$_GET['year']) && isLocked("pl_smt_tht",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("pl_smt_tht",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr style="height: 95px;">
                                                        <td style="padding: 0px;font-size: 12px"><b>Zásoba vyrobených modulov</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($zasoba as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo $value; ?></td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $zasoba_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                </tbody>
                                                <tbody style="background: #edc44c">
                                                   <?php
                                               
                                                    include "includes/find_all_data_av.php";
                                               
                                                ?>
                                                    <tr>
                                                        <th rowspan="5" style="text-align:center; vertical-align: middle; font-size: 100%; background: #edc44c; border-left: 15px solid <?php echo(edit_enabled("av",$_GET['month'],$_GET['year']) || !report_exist("AV",$_GET['month'],$_GET['year']))?"red":"green" ?>;" id="AV">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("AV",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=av&enable_editing=1" style="font-size: 90%">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        AV <?php attachmentsExists("av",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="AV" && report_exist("AV",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("av",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("AV",$_GET['month'],$_GET['year']))){ ?>
                                                        <br><a href="?modul=AV-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }   
                                                        if(report_exist("AV",$_GET['month'],$_GET['year']) && isLocked("av",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("av",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr >
                                                        <td style=" padding: 0px;font-size: 12px; height: 30px"><b>Priemerný počet dní potrebných na spracovanie dokumentácie za mesiac</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($pocet_dni as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $pocet_dni_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #d4b559">
                                                        <td rowspan="2" style=" padding: 0px;font-size: 12px"><b>Prírastok výrobkov</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($nove_vyrobky as $value){
                                                        ?>
                                                        <td style=" padding: 0px;font-size: 12px"><b>Nové výrobky/ nové kabeláže</b></td>
                                                        <td style=" padding: 0px;font-size: 12px"><b>Inovované výrobky</b></td>
                                                        <td style=" padding: 0px;font-size: 12px"><b>Nové návody</b></td>
                                                        <td style=" padding: 0px;font-size: 12px"><b>Vzorkovanie-EMPB</b></td>
                                                        <td rowspan="2" class="note" style=" padding: 0px;font-size: 12px"><?php echo $nove_vyrobky_p[$index].($nove_vyrobky_p[$index]!=""?"<br>":"").$inovovane_p[$index].($inovovane_p[$index]!=""?"<br>":"").$navody_p[$index].($navody_p[$index]!=""?"<br>":"").$empb_p[$index].($empb_p[$index]!=""?"<br>":""); ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #d4b559">
                                                       <?php
                                                            $index=0;
                                                            foreach ($nove_vyrobky as $value){
                                                        ?>
                                                        <td style=" padding: 0px;font-size: 12px" ><?php echo number_format($value,0,',',' '); ?></td>
                                                        <td style=" padding: 0px;font-size: 12px"><?php echo number_format($inovovane[$index],0,',',' '); ?></td>
                                                        <td style=" padding: 0px;font-size: 12px"><?php echo number_format($navody[$index],0,',',' '); ?></td>
                                                        <td style=" padding: 0px;font-size: 12px"><?php echo number_format($empb[$index],0,',',' '); ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr >
                                                        <td style=" padding: 0px;font-size: 12px; height: 30px"><b>Náklady na investície</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($naklady_investicie as $value){
                                                        ?>
                                                        <td colspan="4" style=" padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style=" padding: 0px;font-size: 12px"><?php echo $naklady_investicie_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                </tbody>
                                                <tbody style="background: #36c9c9">
                                                   <?php
                                               
                                                    include "includes/find_all_data_te.php";
                                               
                                                ?>
                                                    <tr>
                                                        <th rowspan="3" style="text-align:center; vertical-align: middle; font-size: 100%; background: #36c9c9; border-left: 15px solid <?php echo(edit_enabled("te",$_GET['month'],$_GET['year']) || !report_exist("TE",$_GET['month'],$_GET['year']))?"red":"green" ?>; padding: 0px" id="TE">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("TE",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=te&enable_editing=1" style=" font-size:90%;">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        TE <?php attachmentsExists("te",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="TE" && report_exist("TE",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month"))||*/  edit_enabled("te",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("TE",$_GET['month'],$_GET['year']))){ ?>
                                                        <br><a href="?modul=TE-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }   
                                                        if(report_exist("TE",$_GET['month'],$_GET['year']) && isLocked("te",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("te",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0px; height: 38px;font-size: 12px"><b>Investície do vývoja /€ s DPH/</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($investicie as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $investicie_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #20a2a2">
                                                        <td style="padding: 0px;height: 38px;font-size: 12px"><b>Počet hodín venovaných vývoju</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($vyvoj as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> hod</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $vyvoj_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                </tbody>
                                                <tbody style="background: #4faeff">
                                                   <?php
                                               
                                                    include "includes/find_all_data_edv.php";
                                               
                                                ?>
                                                    <tr>
                                                        <th rowspan="2" style="text-align:center; vertical-align: middle; font-size: 100%; background: #4faeff; border-left: 15px solid <?php echo(edit_enabled("edv",$_GET['month'],$_GET['year']) || !report_exist("EDV",$_GET['month'],$_GET['year']))?"red":"green" ?>; padding: 0px" id="EDV">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("EDV",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=edv&enable_editing=1" style=" font-size:90%;">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        EDV <?php attachmentsExists("edv",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="EDV" && report_exist("EDV",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("edv",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("EDV",$_GET['month'],$_GET['year']))){ ?>
                                                        <br><a href="?modul=EDV-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }   
                                                        if(report_exist("EDV",$_GET['month'],$_GET['year']) && isLocked("edv",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("edv",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td  style=" height: 75px; padding: 0px;font-size: 12px"><b>Výpadky siete LAN (min/mesiac)</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($vypadky as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $vypadky_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                </tbody>
                                                <tbody style="background: #F8CBAD">
                                                   <?php
                                               
                                                    include "includes/find_all_data_ek.php";
                                               
                                                ?>
                                                    <tr>
                                                        <th rowspan="4" style="text-align:center; vertical-align: middle; font-size: 100%; background: #F8CBAD; border-left: 15px solid <?php echo(edit_enabled("ek",$_GET['month'],$_GET['year']) || !report_exist("EK",$_GET['month'],$_GET['year']))?"red":"green" ?>; padding: 0px" id="EK">
                                                        <?php if($_SESSION['rights']=="boss" && report_exist("EK",$_GET['month'],$_GET['year'])){ ?>
                                                        <a href="?modul=prehlad&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>&rights=ek&enable_editing=1" style=" font-size:90%;">Povoliť úpravy <i class="fa fa-check" aria-hidden="true"></i></a>
                                                        <br>
                                                        <?php } ?>
                                                        EK <?php attachmentsExists("ek",$id[0]); ?>
                                                        <?php if(($_SESSION['rights']=="EK" && report_exist("EK",$_GET['month'],$_GET['year']) &&/* ($datum>=date('Y-m-01',strtotime(date('Y-m')." -1 month")) ||*/ edit_enabled("ek",$_GET['month'],$_GET['year'])==1)/*)*/ || ($_SESSION['rights']=="boss" && report_exist("EK",$_GET['month'],$_GET['year']))){ ?>
                                                        <br><a href="?modul=EK-edit&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" style=" font-size:90%;">editovať <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }   
                                                        if(report_exist("EK",$_GET['month'],$_GET['year']) && isLocked("ek",$_GET['month'],$_GET['year'])!=""){
                                                        
                                                            echo "<div style=\"font-size: 80%;\"><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ".isLocked("ek",$_GET['month'],$_GET['year'])."</div>";
                                                            
                                                        }?>
                                                        </th>
                                                    </tr>
                                                    <tr >
                                                        <td  style="padding: 0px; height:25px;font-size: 12px"><b>Objem zásob materiálu /€/</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($material as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $material_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr style="background: #f7b588">
                                                        <td style="padding: 0px; height:25px;font-size: 12px"><b>Obrátka zásob</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($obratka as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?></td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $obratka_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                    <tr >
                                                        <td style="padding: 0px; height:25px;font-size: 12px"><b>Spotreba materiálu</b></td>
                                                        <?php
                                                            $index=0;
                                                            foreach ($spotreba_trzby as $value){
                                                        ?>
                                                        <td colspan="4" style="padding: 0px;font-size: 12px"><?php echo number_format($value,2,',',' '); ?> €</td>
                                                        <td class="note" style="padding: 0px;font-size: 12px"><?php echo $spotreba_trzby_p[$index]; ?></td>
                                                        <?php $index++; } ?>
                                                    </tr>
                                                </tbody>
                                            </table>

</div>
									
                                    </div>
                                </div>
						
 </div>
 <script type="text/javascript">
 function printPage(){
        var tableData = '<table border="1" style="font-size:10px">'+document.getElementsByTagName('table')[0].innerHTML+'</table>';
        var data = '<button onclick="window.print()">Vytlačiť tabuľku</button>'+tableData;       
        myWindow=window.open('','','width=auto,height=auto');
        myWindow.innerWidth = screen.width;
        myWindow.innerHeight = screen.height;
        myWindow.screenX = 0;
        myWindow.screenY = 0;
        myWindow.document.write(data);
        myWindow.focus();
    };
 </script>
  <script>
    
     $(".chosen-select").chosen({
        no_results_text: "Oops, nothing found!"
     })
    
</script>
<script>
    function OptionsSelected(me)
{
    var text="";
    var checkBox="";
    
    switch(me.id){
        case "notes":
            checkBox = document.getElementById(me.id);
            text = document.getElementsByClassName("note");
            break;     
    }
    [].forEach.call(document.querySelectorAll('.note'), function (el) {
        if (checkBox.checked == true){
            el.style.display = 'none';
        }
        else{
            el.style.display = '';
        }
});
    /*for(var i = 0;i<text.length;i++){
    if (checkBox.checked == true){
        text.style.display = "none";
    }else{
         text.style.display = "block";
    }
    }*/
}

</script>
<script>
    function showMore() {
      var button = document.getElementById("showMore");
      var short = document.getElementById("shortRecord");
      var long = document.getElementById("longRecord");
      var btnShrt = document.getElementById("showMoreBtn");
      var btnLng = document.getElementById("showLessBtn");       
        long.style.display = "block";
        short.style.display = "none";
        btnLng.style.display = "block";
        btnShrt.style.display = "none";
    }
</script>
<script>
    function showLess() {
      var button = document.getElementById("showMore");
      var short = document.getElementById("shortRecord");
      var long = document.getElementById("longRecord");
      var btnShrt = document.getElementById("showMoreBtn");
      var btnLng = document.getElementById("showLessBtn");
        long.style.display = "none";
        short.style.display = "block";
        btnLng.style.display = "none";
        btnShrt.style.display = "block";
    }
</script>