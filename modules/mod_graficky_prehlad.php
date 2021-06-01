<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<div class="page-content">
      
      <div class="portlet box blue ">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-search"></i> Vyhľadávanie
											</div>
                                      <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="Zbaliť/Rozbaliť" title=""> </a>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                                            <div class="form-body">
                                                <div class="form-group">
												     <input type="hidden" name="modul" value="polozky">	
                                                    <div class="col-md-3">
                                                    BU
                                                    <select name="bu[]" id="bu" multiple class="chosen-select form-control" >
                                                         <option value="hv_kumulativne" >HV v EUR kumulatívne</option>
                                                         <option value="trzby_vlastne_vyrobky" >Tržby z predaja vl.výrobkov</option>
                                                         <option value="spotreba_materialu" >Spotreba materiálu</option>
                                                         <option value="spotreba_energie" >Spotreba energie</option>
                                                         <option value="mzdove_naklady" >Mzdové náklady</option>
                                                         <option value="priemerny_zarobok" >Priemerný zárobok</option>
                                                         <option value="priemerny_pocet_zamestnancov" >Priemerný evid. počet zamestnancov</option>
                                                         <option value="stav_posledny_den" >Evidenčný stav k posl.dňu v mesiaci</option>
                                                         <option value="fluktuacia" >Fluktuácia zamestnancov</option>
                                                         <option value="pracovny_fond%" >Využitie prac. fondu</option>
                                                         <option value="nadcasove_hodiny%" >Nadčasové hodiny</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                    VK
                                                    <select name="vk[]" id="vk" multiple class="chosen-select form-control" >
                                                         <option value="" ></option>
                                                         <option value="doba_vybavovania_reklamacii_a_podiel" >Doba vybavovania reklamácií / %podiel nákladov z tržieb</option>
                                                         <option value="index_perfektnej_dodavky" >Index perfektnej dodávky</option>
                                                         <option value="priemerne_dni_dodania" >Priemerné dni dodania</option>
                                                         <option value="efektivnost_predaja" >Efektívnosť predaja</option>
                                                         <option value="sledovanie_objemu_predanych_vyrobkov" >Sledovanie objemu predaných výrobkov</option>
                                                         <option value="nove_vyrobky" >Z toho nové výrobky</option>
                                                         <option value="mnozstvo_predanych_esad%" >Množstvo predaných E-sad</option>
                                                         <option value="zakazky_k%" >Zákazky k</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                    QS
                                                    <select name="qs[]" id="qs" multiple class="chosen-select form-control" >
                                                         <option value="" ></option>
                                                         <option value="reklamovane_ks_od_zakaznikov" >Reklamované ks od zákazníkov	</option>
                                                         <option value="uznane_reklamovane_ks_od_zakaznikov" >Uznané reklamované ks od zákazníkov	</option>
                                                         <option value="uznane_naklady_za_reklamovane_ks" >Uznané náklady za reklamované ks	</option>
                                                         <option value="naklady_na_reklamacie_od_zakaznikov" >Náklady na reklamácie od zákazníkov	</option>
                                                         <option value="mnozstvo_zaznamenanych_internych_nvo%" >Množstvo zaznamenaných interných NVO (ks)	</option>
                                                         <option value="naklady_na_interne_chyby" >Náklady na interné chyby /€/	</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                    PL
                                                    <select name="pl[]" id="pl" multiple class="chosen-select form-control" >
                                                         <option value="" ></option>
                                                         <option value="priemerna_doba_obratu_zasob_voci_trzbam" >Priemerná doba obratu zásob voči tržbám	</option>
                                                         <option value="straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam%" >Straty z NVN z odvedenej výroby oproti tržbám	</option>
                                                         <option value="efektivnost_vyroby" >Efektívnosť výroby: reálne hod. ku plánovaným hod. bez zoraďovačov	</option>
                                                         <option value="priemerny_pocet_vyrobnych_pracovnikov_za_obd" >Priemerný počet výrobných pracovníkov za obd.	</option>
                                                         <option value="pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci" >Počet výrob. pracovníkov - stav k posl.dňu v mesiaci	</option>
                                                         <option value="efektivnost_vyroby_trzby_vyrob_pracovnik_den" >Efektívnosť výroby: tržby/výrob. pracovník/deň	</option>
                                                         <option value="denny_prietok_vyroby_esady_ks" >Denný prietok výroby - E-sady (ks)	</option>
                                                         <option value="denny_prietok_vyroby_vyr_pracovnika_den" >Denný prietok výroby/výr. pracovníka/deň (€)	</option>
                                                         <option value="plnenie_vykonovych_noriem" >Plnenie výkonových noriem	</option>
                                                         
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                    PL200
                                                    <select name="pl200[]" id="pl200" multiple class="chosen-select form-control" >
                                                         <option value="" ></option>
                                                         <option value="vyrobene_kusy" >Vyrobené kusy	</option>
                                                         <option value="nto_na_vyrobene_mnozstvo_dielcov" >NTO v /%/ na vyrobené množstvo dielcov	</option>
                                                         <option value="hodnota_nto_za_cele_obdobie" >Hodnota NTO za celé obdobie	</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                    AV
                                                    <select name="av[]" id="av" multiple class="chosen-select form-control" >
                                                         <option value="" ></option>
                                                         <option value="priemerny_pocet_dni_na_spracovanie_dokumentacie_mesiac" >Priemerný počet dní potrebných na spracovanie dokumentácie za mesiac	</option>
                                                         <option value="prirastok_vyrobkov%" >Prírastok výrobkov	</option>
                                                         <option value="naklady_na_investicie" >Náklady na investície	</option>
                                                         
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                    TE
                                                    <select name="te[]" id="te" multiple class="chosen-select form-control" >
                                                         <option value="" ></option>
                                                         <option value="investicie_do_vyvoja" >Investície do vývoja /€ s DPH/	</option>
                                                         <option value="pocet_hodin_venovanych_vyvoju" >Počet hodín venovaných vývoju	</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                    EDV
                                                    <select name="edv[]" id="edv" multiple class="chosen-select form-control" >
                                                         <option value="" ></option>
                                                         <option value="vypadky_siete_lan" >Výpadky siete LAN (min/mesiac)	</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                    EK
                                                    <select name="ek[]" id="ek" multiple class="chosen-select form-control" >
                                                         <option value="" ></option>
                                                         <option value="objem_zasob_materialu" >Objem zásob materiálu /€/	</option>
                                                         <option value="obratka_zasob" >Obrátka zásob	</option>
                                                         <option value="spotreba_materialu_k_trzbam" >Spotreba materiálu</option>
                                                        </select>
                                                    </div>
                                                    
                                                </div>                                              
                                            </div>
                                            
                                                <div class="form-actions right1">
                                                   <button name="showGraphs" type="submit" class="btn blue">Zobraziť</button>
                                                </div>
                                                
                                                
                                                
                                        </form>
                                    </div>
                                </div>  
    <?php
    
        if(isset($_POST['showGraphs'])){
            $bu=$_POST['bu'];
            $vk=$_POST['vk'];
            $qs=$_POST['qs'];
            $pl=$_POST['pl'];
            $pl200=$_POST['pl200'];
            $av=$_POST['av'];
            $te=$_POST['te'];
            $edv=$_POST['edv'];
            $ek=$_POST['ek'];
            $countOfIndicators=count($bu)+count($vk)+count($qs)+count($pl)+count($pl200)+count($av)+count($te)+count($edv)+count($ek);
            $actualIndicator=0;
            
            if(!empty($bu)){
                    $group="bu";
                    foreach($bu as $indicator){
                        $indicatorName="BU - ".$indicator;
                        include "includes/graph_maker.php";
 
                    $actualIndicator++;
                    }
                    }
            if(!empty($vk)){
                    $group="vk";
                    foreach($vk as $indicator){
                        $indicatorName="VK - ".$indicator;
                        include "includes/graph_maker.php";
 
                    $actualIndicator++;
                    }
                    }
            if(!empty($qs)){
                    $group="qs";
                    foreach($qs as $indicator){
                        $indicatorName="QS - ".$indicator;
                        include "includes/graph_maker.php";
 
                    $actualIndicator++;
                    }
                    }
            if(!empty($pl)){
                    $group="pl";
                    foreach($pl as $indicator){
                        $indicatorName="PL - ".$indicator;
                        include "includes/graph_maker.php";
 
                    $actualIndicator++;
                    }
                    }
            if(!empty($pl200)){
                    $group="pl200";
                    foreach($pl200 as $indicator){
                        $indicatorName="PL200 - ".$indicator;
                        include "includes/graph_maker.php";
 
                    $actualIndicator++;
                    }
                    }
            if(!empty($av)){
                    $group="av";
                    foreach($av as $indicator){
                        $indicatorName="AV - ".$indicator;
                        include "includes/graph_maker.php";
 
                    $actualIndicator++;
                    }
                    }
            if(!empty($te)){
                    $group="te";
                    foreach($te as $indicator){
                        $indicatorName="PL200 - ".$indicator;
                        include "includes/graph_maker.php";
 
                    $actualIndicator++;
                    }
                    }
            if(!empty($edv)){
                    $group="edv";
                    foreach($edv as $indicator){
                        $indicatorName="EDV - ".$indicator;
                        include "includes/graph_maker.php";
 
                    $actualIndicator++;
                    }
                    }
            if(!empty($ek)){
                    $group="ek";
                    foreach($ek as $indicator){
                        $indicatorName="EK - ".$indicator;
                        include "includes/graph_maker.php";
 
                    $actualIndicator++;
                    }
                    }
            
        }
    ?>
 </div>
 <script>
    
     $(".chosen-select").chosen({
        no_results_text: "Oops, nothing found!"
     })
    
</script>