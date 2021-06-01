<?php

    $indicator_real_name=array("hv_kumulativne"=>"BU - HV v € kumulatívne","trzby_vlastne_vyrobky"=>"BU - Tržby z predaja vl. výrobkov","spotreba_materialu"=>"BU - Spotreba materiálu","spotreba_energie"=>"BU - Spotreba energie","mzdove_naklady"=>"BU - Mzdové náklady", "priemerny_zarobok"=>"BU - Priemerný zárobok", "priemerny_pocet_zamestnancov"=>"BU - Priemerný evid. počet zamestnancov", "stav_posledny_den"=>"BU - Evidenčný stav k posl. dňu v mesiaci", "fluktuacia"=>"BU - Fluktuácia zamestnancov", "pracovny_fond%"=>"BU - Využitie pracovného fondu" , "pracovny_fond_100"=>"str. 100" , "pracovny_fond_200"=>"str. 200" , "pracovny_fond_mkem"=>"mkem celkom",  "nadcasove_hodiny%"=>"BU - Nadčasové hodiny", "doba_vybavovania_reklamacii_a_podiel"=>"VK - Doba vybavovania reklamácií / % podiel nákladov z tržieb", "doba_vybavovania_reklamacii"=>"dní", "podiel_nakladov_z_trzieb"=>"%", "index_perfektnej_dodavky"=>"VK - Index perfektnej dodávky", "priemerne_dni_dodania"=>"VK - Priemerné dni dodania", "efektivnost_predaja"=>"VK - Efektívnosť predaja", "sledovanie_objemu_predanych_vyrobkov"=>"VK - Sledovanie objemu predaných výrobkov", "nove_vyrobky"=>"VK - Nové výrobky", "mnozstvo_predanych_esad%"=>"VK - Množstvo predaných E-sad", "mnozstvo_predanych_esad_ks"=>"ks", "mnozstvo_predanych_esad_eur"=>"€", "zakazky_k%"=>"VK - Zákazky k", "zakazky_k"=>"Celkovo", "zakazky_k_na_sklade"=>"Na sklade", "reklamovane_ks_od_zakaznikov"=>"QS - Reklamované ks od zákazníkov", "uznane_reklamovane_ks_od_zakaznikov"=>"QS - Uznané reklamované ks od zákazníkov", "uznane_naklady_za_reklamovane_ks"=>"QS - Uznané náklady za reklamované ks", "naklady_na_reklamacie_od_zakaznikov"=>"QS - Náklady na reklamácie od zákazníkov", "mnozstvo_zaznamenanych_internych_nvo%"=>"QS - Množstvo zaznamenaných NVO (ks)", "mnozstvo_zaznamenanych_internych_nvo_av"=>"AV", "mnozstvo_zaznamenanych_internych_nvo_pl"=>"PL", "mnozstvo_zaznamenanych_internych_nvo_celkom"=>"Celkom", "naklady_na_interne_chyby"=>"QS - Náklady na interné chyby", "priemerna_doba_obratu_zasob_voci_trzbam"=>"PL - Priemerná doba obratu zásob voči tržbám", "straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam"=>"PL - Straty z NVN z odvedenej výroby oproti tržbám", "straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1"=>"Celkovo", "straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2"=>"Dňa", "efektivnost_vyroby"=>"PL - Efektívnosť výroby: réalne hod. ku plánovaným hod. bez zoraďovačov", "priemerny_pocet_vyrobnych_pracovnikov_za_obd"=>"PL - Priemerný počet výrobných pracovníkov za obdobie", "pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci"=>"PL - Počet výrob. pracovníkov - stav k posl. dňu v mesiaci", "efektivnost_vyroby_trzby_vyrob_pracovnik_den"=>"PL - Efektívnosť výroby: tržby výrob./výrob. pracovník/deň", "denny_prietok_vyroby_esady_ks"=>"PL - Denný prietok výroby - E-sady (ks)", "denny_prietok_vyroby_vyr_pracovnika_den"=>"PL - Denný prietok výroby/výrob. pracovníka/deň (€)", "plnenie_vykonovych_noriem"=>"PL - Plnenie výkonových noriem", "vyrobene_kusy"=>"PL200 - Vyrobené kusy", "nto_na_vyrobene_mnozstvo_dielcov"=>"PL200 - NTO v % na vyrobené množstvo dielcov", "hodnota_nto_za_cele_obdobie"=>"PL200 - Hodnota NTO za celé obdobie", "priemerny_pocet_dni_na_spracovanie_dokumentacie_mesiac"=>"AV - Priemerný počet dní potrebných na spracovanie dokumentácie za mesiac", "prirastok_vyrobkov%"=>"AV - Prírastok výrobkov", "prirastok_vyrobkov_nove_vyrobky_kabelaze"=>"Nové kabeláže", "prirastok_vyrobkov_inovovane_vyrobky"=>"Inovované výrobky", "prirastok_vyrobkov_nove_navody"=>"Nové návody", "prirastok_vyrobkov_vzorkovanie_empb"=>"Vzorkovanie EMPB", "naklady_na_investicie"=>"AV - Náklady na investície", "investicie_do_vyvoja"=>"TE - Investície do vývoja /€ s DPH/", "pocet_hodin_venovanych_vyvoju"=>"TE - Počet hodín venovaných vývoju", "vypadky_siete_lan"=>"EDV - Výpadky siete LAN (min/mesiac)", "objem_zasob_materialu"=>"EK - Objem zásob materiálu", "obratka_zasob"=>"EK - Obrátka zásob", "spotreba_materialu_k_trzbam"=>"EK - Spotreba materiálu");

?>

<h1><?php echo $indicator_real_name[$indicator]; ?></h1>
                            
<?php

    $one_line_graph=true;
    if(strpos($indicator,'%')){
        $query="select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '".$group."' AND COLUMN_NAME like '".$indicator."' AND COLUMN_NAME NOT like '%poznamka' AND COLUMN_NAME NOT like '%datum'";   
        $apply_query = mysqli_query($connect,$query);
        $db_cols=array();
        while($result=mysqli_fetch_array($apply_query)){
            array_push($db_cols,$result['COLUMN_NAME']);
        }
        $one_line_graph=false;
    }elseif($indicator=="doba_vybavovania_reklamacii_a_podiel"){
        $query="select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '".$group."' AND COLUMN_NAME like 'doba_vybavovania_reklamacii' OR COLUMN_NAME like 'podiel_nakladov_z_trzieb'  ";   
        $apply_query = mysqli_query($connect,$query);
        $db_cols=array();
        while($result=mysqli_fetch_array($apply_query)){
            array_push($db_cols,$result['COLUMN_NAME']);
        }
        $one_line_graph=false;
    }

?>
						
    
<div id="linechart_material<?php echo $actualIndicator; ?>" style="height: 500px; width= auto;"></div>

  <script type="text/javascript" src="js/loader.js"></script>
    <script >
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      <?php
      
        $unit=chooseUnit($indicator);
        
      ?>
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Mesiac');
      data.addColumn('number', '<?php echo $one_line_graph?$unit."/mesiac":$indicator_real_name[$db_cols[0]]."/mesiac"; ?>');
        <?php 
        
            if(!$one_line_graph){
                $db_col_index=1;
                while($db_col_index<count($db_cols)){
        ?>
        data.addColumn('number', '<?php echo $indicator_real_name[$db_cols[$db_col_index]]."/mesiac"; ?>');
        <?php 
                    $db_col_index++;    
                } 
            }
        ?>
      /*data.addColumn('number', 'The Avengers');
      data.addColumn('number', 'Transformers: Age of Extinction');*/

      data.addRows([
          <?php
          if($one_line_graph){
              $minYear=date("Y")-2;
              while($minYear<=date("Y")){
                  if($minYear==date("Y")-2){
                      $month=date("m");
                  }else{
                      $month=1;
                  }
                  for($month;$month<=12;$month++){
                        if($minYear==date("Y") && $month>date("m")){
                            break;
                        }
                        $query="SELECT ".$indicator." FROM ".$group." WHERE YEAR(obdobie)=".$minYear." AND MONTH(obdobie)=".$month." ";
                        $apply_query=mysqli_query($connect,$query);
                        $row=mysqli_fetch_array($apply_query);
                        $value=$row[$indicator]==""?0:$row[$indicator]; 

                        echo "['".$month."/".$minYear."',  ".$value."],";

                  }
              $minYear++;
              } 
          }else{
                $col_index=0;
                $main_values=array();
                $col_values=array();
                while($col_index<count($db_cols)){
                    $minYear=date("Y")-2;
                    $counter=0;
                    while($minYear<=date("Y")){
                      if($minYear==date("Y")-2){
                          $month=date("m");
                      }else{
                          $month=1;
                      }
                        for($month;$month<=12;$month++){
                            if($minYear==date("Y") && $month>date("m")){
                                break;
                            }
                            $query="SELECT ".$db_cols[$col_index]." FROM ".$group." WHERE YEAR(obdobie)=".$minYear." AND MONTH(obdobie)=".$month." ";
                            $apply_query=mysqli_query($connect,$query);
                            $row=mysqli_fetch_array($apply_query);
                            array_push($col_values,$row[$db_cols[$col_index]]==""?0:$row[$db_cols[$col_index]]);

    //                        echo "['".$month."/".$minYear."',  ".$value.",4,5],";
                            
                    }
                        $minYear++;
                    }
                    array_push($main_values,$col_values);
                    $col_values=array();
                    $counter++;
                    $col_index++;
                }
                $minYear=date("Y")-2;
                $val_index=0;
                while($minYear<=date("Y")){
                    if($minYear==date("Y")-2){
                          $month=date("m");
                      }else{
                          $month=1;
                      }
                    for($month;$month<=12;$month++){
                        if($minYear==date("Y") && $month>date("m")){
                            break;
                        }
                    $graph_string="['".$month."/".$minYear."'";
                    $db_col_index=0;
                    while($db_col_index<count($db_cols)){
                        $graph_string.=",".$main_values[$db_col_index][$val_index];
                        $db_col_index++;
                    }  
                    $graph_string.="],";
                    echo $graph_string;
                        $val_index++;
                    }
                    $minYear++;
                } 
                
                
        }
          
          ?>
      ]);

      var options = {
        chart: {
          title: ' ',
          subtitle: ''
        },
          colors: ['#AB0D06', '#00108e', '#118911', '#d3d300'],
       /* width: 1500,
        height: 500*/
      };

      var chart = new google.charts.Line(document.getElementById('linechart_material<?php echo $actualIndicator; ?>'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
    </script>
    <?php
/*echo $graph_string;
print_r($main_values);*/
?>