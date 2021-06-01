<?php

function attachmentsExists($indicator,$id_indicator){
    global $connect;
    $query="SELECT * FROM documents WHERE id_indicator=".$id_indicator." AND indicator='".$indicator."'";
    $apply_query=mysqli_query($connect,$query);
    if(mysqli_num_rows($apply_query)>0){
        echo "<i class=\"fa fa-paperclip\" aria-hidden=\"true\" style=\"font-size:18px\"></i>";
    }
}

function chooseUnit($indicator){
    $eur=array("hv_kumulativne","trzby_vlastne_vyrobky","spotreba_materialu","spotreba_energie","mzdove_naklady","priemerny_zarobok","sledovanie_objemu_predanych_vyrobkov","uznane_naklady_za_reklamovane_ks","naklady_na_reklamacie_od_zakaznikov","naklady_na_interne_chyby","efektivnost_vyroby_trzby_vyrob_pracovnik_den","denny_prietok_vyroby_vyr_pracovnika_den","vyrobene_kusy","hodnota_nto_za_cele_obdobie","naklady_na_investicie","investicie_do_vyvoja","objem_zasob_materialu","spotreba_materialu_k_trzbam");
        $ks=array("priemerny_pocet_zamestnancov","stav_posledny_den","reklamovane_ks_od_zakaznikov","uznane_reklamovane_ks_od_zakaznikov","priemerny_pocet_vyrobnych_pracovnikov_za_obd","pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci","denny_prietok_vyroby_esady_ks");
        $percentage=array("fluktuacia","index_perfektnej_dodavky","efektivnost_predaja","nove_vyrobky","efektivnost_vyroby","plnenie_vykonovych_noriem","nto_na_vyrobene_mnozstvo_dielcov");
        $days=array("priemerne_dni_dodania","priemerna_doba_obratu_zasob_voci_trzbam","priemerny_pocet_dni_na_spracovanie_dokumentacie_mesiac",);
        $unit="hod";
        if($indicator=="vypadky_siete_lan"){
            $unit="min";
        }elseif(in_array($indicator,$eur)){
            $unit="€";
        }elseif(in_array($indicator,$ks)){
            $unit="ks";
        }elseif(in_array($indicator,$percentage)){
            $unit="%";
        }elseif(in_array($indicator,$days)){
            $unit="dní";
        }elseif($indicator=="obratka_zasob"){
            $unit="obratka zásob";
        }
    
    return $unit;
}

function moveAttahedFile($indicator,$db_indicator){
    global $connect;
    $old_path="documents/waiting/".$indicator."/";
    $month=date('m', strtotime($_POST['obdobie']));
    $year=date('Y', strtotime($_POST['obdobie']));
    $new_path="documents/".$indicator."/".$year."_".$month;
    $documents = scandir($old_path);
    $docIndex=2;
    while($docIndex<count($documents)){
        $path=$new_path."/".$documents[$docIndex];
        rename($old_path, "documents/".$indicator."/".pathinfo($new_path, PATHINFO_BASENAME));
        $docIndex++;
        $query = "SELECT id FROM ".$db_indicator." WHERE YEAR(obdobie)=".$year." AND "."MONTH(obdobie)=".$month." ";
        $apply_query = mysqli_query($connect,$query);
        $result=mysqli_fetch_array($apply_query);
        $query="INSERT INTO documents(indicator, id_indicator, path) VALUES ('".$db_indicator."',".$result['id'].", '".$path."') ";
        $apply_query = mysqli_query($connect,$query);
    }
    mkdir("documents/waiting/".$indicator."/", 0777, true);
}

function deleteFile($modul,$indicator){
    global $connect;
    
    if(isset($_POST['deleteDoc'])){
        if(strpos($_GET['modul'],'edit')>0){
            updatePeriodData($_SESSION['rights'],$_GET['month'],$_GET['year']);
            $query="SELECT path FROM documents WHERE ID=".$_POST['deleteDoc']." ";
            $apply_query = mysqli_query($connect,$query);
            $result=mysqli_fetch_array($apply_query);
            unlink($result['path']);
            $query = "DELETE FROM documents WHERE ID=".$_POST['deleteDoc']." ";
            mysqli_query($connect,$query);
            //echo "<script>location.replace(\"index.php?modul=".$modul."&month=".$_GET['month']."&year=".$_GET['year']."\");</script>";
        }else{
            unlink("documents/waiting/".$indicator."/".$_POST['deleteDoc']);
        }
    }
}

function addFile($directory,$indicator,$id_indicator){
    global $connect;
    
    if(isset($_POST['addFile'])){
        if(strpos($_GET['modul'],'edit')>0){
            updatePeriodData($_SESSION['rights'],$_GET['month'],$_GET['year']);
            $file = $_FILES['fileToUpload']['name'];
            $image_temp = $_FILES['fileToUpload']['tmp_name'];
            $path="documents/".$directory."/".$_GET['year']."_".$_GET['month']."/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if(!file_exists($path.$file)){    
                if(move_uploaded_file($image_temp, $path.$file)){
                    /*$query = "SELECT ID From documents WHERE indicator=av AND id_indicator=".$result['id']." AND path=".$path.$file." ";
                    $apply_query = mysqli_query($connect,$query)
                    $a*/
                    $query="INSERT INTO documents(indicator, id_indicator, path) VALUES ('".$indicator."',".$id_indicator.", '".$path.$file."') ";
                    $apply_query = mysqli_query($connect,$query);
                }
            }else{
                echo '<div class="alert alert-danger">Príloha s týmto názvom je pre toto obdobie už nahratá.</div>';
            }
        }else{
            $file = $_FILES['fileToUpload']['name'];
            $image_temp = $_FILES['fileToUpload']['tmp_name'];
            $path="documents/waiting/".$directory."/";
            if(!file_exists($path.$file)){    
                move_uploaded_file($image_temp, $path.$file);
            }else{
                echo '<div class="alert alert-danger">Príloha s týmto názvom je pre toto obdobie už nahratá.</div>';
            }
        }
    }
}

function isLocked($rights,$month,$year){
    global $connect;
    
    $query_a="SELECT sent, datetime_sent FROM ".$rights." WHERE MONTH(obdobie)=".$month." AND YEAR(obdobie)=".$year." ";
    $apply_query_a=mysqli_query($connect, $query_a);
    $row_a=mysqli_fetch_array($apply_query_a);
    
    return $row_a['datetime_sent'];
}

function edit_enabled($rights,$month,$year){
    global $connect;
    
    $query_a="SELECT edit_exception, sent FROM ".$rights." WHERE MONTH(obdobie)=".$month." AND YEAR(obdobie)=".$year." ";
    $apply_query_a=mysqli_query($connect, $query_a);
    $row_a=mysqli_fetch_array($apply_query_a);
    
    if($row_a['edit_exception']==1 || $row_a['sent']==0){
        return true;
    }
    
    return false;
}

function enable_editing($rights,$month,$year){
    global $connect;
    
    if($_GET['enable_editing']==1){
        $query="UPDATE ".$rights." SET edit_exception=1 WHERE MONTH(obdobie)=".$month." AND YEAR(obdobie)=".$year." ";
        mysqli_query($connect, $query);
    }
    
}

function mail_sent($rights,$month,$year){
    
    global $connect;
    
    $table="";
    
    switch($rights){
        case "BU":
            $table="bu";
            break;
        case "VK":
            $table="vk";
            break;
        case "QS":
            $table="qs";
            break;
        case "QV":
            $table="qv";
            break;
        case "PL":
            $table="pl";
            break;
        case "PL200":
            $table="pl200";
            break;
        case "PL SMT/THT":
            $table="pl_smt_tht";
            break;
        case "AV":
            $table="av";
            break;
        case "TE":
            $table="te";
            break;
        case "EDV":
            $table="edv";
            break;
        case "EK":
            $table="ek";
            break;
            
    }
    
    echo $query="SELECT sent FROM ".$table." WHERE MONTH(obdobie)=".$month." AND YEAR(obdobie)=".$year." ";
    $apply_query=mysqli_query($connect,$query);
    $result=mysqli_fetch_array($apply_query);
    if($result['sent']==1){
        return true;
    }
    return false;
}

function report_exist($rights,$month,$year){
    
    global $connect;
    
    $table="";
    
    switch($rights){
        case "BU":
            $table="bu";
            break;
        case "VK":
            $table="vk";
            break;
        case "QS":
            $table="qs";
            break;
        case "QV":
            $table="qv";
            break;
        case "PL":
            $table="pl";
            break;
        case "PL200":
            $table="pl200";
            break;
        case "PL SMT/THT":
            $table="pl_smt_tht";
            break;
        case "AV":
            $table="av";
            break;
        case "TE":
            $table="te";
            break;
        case "EDV":
            $table="edv";
            break;
        case "EK":
            $table="ek";
            break;
            
    }
    
    $query="SELECT * FROM ".$table." WHERE MONTH(obdobie)=".$month." AND YEAR(obdobie)=".$year." ";
    $apply_query=mysqli_query($connect,$query);
    if(mysqli_num_rows($apply_query)==1){
        return true;
    }
    return false;
}

function updatePeriodData($rights,$month,$year){
    
    global $connect;
    
    if($rights=="boss"){
        $endPosition = strpos($_GET['modul'],'-');
        $rights= substr($_GET['modul'],0,$endPosition);
    }
    
    switch ($rights){
        case "BU":
            $kumulativne=str_replace(",",".",$_POST['hv_v_eur_kumulativne']!=""?$_POST['hv_v_eur_kumulativne']:'NULL');
            $predaj_vyrobkov=str_replace(",",".",$_POST['trzby_predaj_vyrobkov']!=""?$_POST['trzby_predaj_vyrobkov']:'NULL');
            $material=str_replace(",",".",$_POST['spotreba_materialu']!=""?$_POST['spotreba_materialu']:'NULL');
            $energie=str_replace(",",".",$_POST['spotreba_energie']!=""?$_POST['spotreba_energie']:'NULL');
            $mzdy=str_replace(",",".",$_POST['mzdove_naklady']!=""?$_POST['mzdove_naklady']:'NULL');
            $zarobok=str_replace(",",".",$_POST['priemerny_zarobok']!=""?$_POST['priemerny_zarobok']:'NULL');
            $poc_zam=str_replace(",",".",$_POST['priemerny_pocet_zamestnancov']!=""?$_POST['priemerny_pocet_zamestnancov']:'NULL');
            $ev_stav=str_replace(",",".",$_POST['ev_stav']!=""?$_POST['ev_stav']:'NULL');
            $fluktuacia=str_replace(",",".",$_POST['fluktacia']!=""?$_POST['fluktacia']:'NULL');
            $fond_100=str_replace(",",".",$_POST['prac_fond_100']!=""?$_POST['prac_fond_100']:'NULL');
            $fond_200=str_replace(",",".",$_POST['prac_fond_200']!=""?$_POST['prac_fond_200']:'NULL');
            $fond_celkom=str_replace(",",".",$_POST['prac_fond_celkom']!=""?$_POST['prac_fond_celkom']:'NULL');
            $nadcas_100=str_replace(",",".",$_POST['nadcas_100']!=""?$_POST['nadcas_100']:'NULL');
            $nadcas_200=str_replace(",",".",$_POST['nadcas_200']!=""?$_POST['nadcas_200']:'NULL');
            $nadcas_celkom=str_replace(",",".",$_POST['nadcas_celkom']!=""?$_POST['nadcas_celkom']:'NULL');
            
            $query="UPDATE bu SET hv_kumulativne=".$kumulativne.", hv_kumulativne_poznamka='".$_POST['noteHV']."', trzby_vlastne_vyrobky=".$predaj_vyrobkov.", trzby_vlastne_vyrobky_poznamka='".$_POST['notePredajVyrobkov']."', spotreba_materialu=".$material.", spotreba_materialu_poznamka='".$_POST['noteSpotrebaMaterialu']."', spotreba_energie=".$energie.", spotreba_energie_poznamka='".$_POST['noteSpotrebaEnergie']."', mzdove_naklady=".$mzdy.", mzdove_naklady_poznamka='".$_POST['noteMzdoveNaklady']."', priemerny_zarobok=".$zarobok.", priemerny_zarobok_poznamka='".$_POST['notePriemernyZarobok']."', priemerny_pocet_zamestnancov=".$poc_zam.", priemerny_pocet_zamestnancov_poznamka='".$_POST['notePriemernyPocetZamestnancov']."', stav_posledny_den=".$ev_stav.", stav_posledny_den_poznamka='".$_POST['noteEvStav']."', fluktuacia=".$fluktuacia.", fluktuacia_poznamka='".$_POST['noteFluktacia']."', pracovny_fond_100=".$fond_100.", pracovny_fond_100_poznamka='".$_POST['notePracFond100']."', pracovny_fond_200=".$fond_200.", pracovny_fond_200_poznamka='".$_POST['notePracFond200']."', pracovny_fond_mkem=".$fond_celkom.", pracovny_fond_mkem_poznamka='".$_POST['notePracFondCelkom']."', nadcasove_hodiny_100=".$nadcas_100.", nadcasove_hodiny_100_poznamka='".$_POST['noteNadcas100']."', nadcasove_hodiny_200=".$nadcas_200.", nadcasove_hodiny_200_poznamka='".$_POST['noteNadcas200']."', nadcasove_hodiny_mkem=".$nadcas_celkom.", nadcasove_hodiny_mkem_poznamka='".$_POST['noteNadcasCelkom']."', datetime_edited=NOW(), edit_exception=0 "; 
            
            break;
            
        case "VK":
            $reklamacie=str_replace(",",".",$_POST['doba_reklamacii']!=""?$_POST['doba_reklamacii']:'NULL');
            $trzby=str_replace(",",".",$_POST['naklady_z_trzieb']!=""?$_POST['naklady_z_trzieb']:'NULL');
            $dodavka=str_replace(",",".",$_POST['perfektna_dodavka']!=""?$_POST['perfektna_dodavka']:'NULL');
            $dodanie=str_replace(",",".",$_POST['dni_dodania']!=""?$_POST['dni_dodania']:'NULL');
            $efektivnost=str_replace(",",".",$_POST['efektivnost_predaja']!=""?$_POST['efektivnost_predaja']:'NULL');
            $objem=str_replace(",",".",$_POST['objem_predanych_vyrobkov']!=""?$_POST['objem_predanych_vyrobkov']:'NULL');
            $vyrobky=str_replace(",",".",$_POST['nove_vyrobky']!=""?$_POST['nove_vyrobky']:'NULL');
            $esady_ks=str_replace(",",".",$_POST['esady_ks']!=""?$_POST['esady_ks']:'NULL');
            $esady_eur=str_replace(",",".",$_POST['esady_eur']!=""?$_POST['esady_eur']:'NULL');
            $datum=str_replace(",",".",$_POST['zakazky_datum']!=""?"'".$_POST['zakazky_datum']."'":'NULL');
            $zakazky=str_replace(",",".",$_POST['zakazky_eur']!=""?$_POST['zakazky_eur']:'NULL');
            $sklad=str_replace(",",".",$_POST['na_sklade']!=""?$_POST['na_sklade']:'NULL');
            
            $query="UPDATE vk SET doba_vybavovania_reklamacii=".$reklamacie.", doba_vybavovania_reklamacii_poznamka='".$_POST['noteDobaReklamacii']."', podiel_nakladov_z_trzieb=".$trzby.", podiel_nakladov_z_trzieb_poznamka='".$_POST['noteNakladyZTrzieb']."', index_perfektnej_dodavky=".$dodavka.", index_perfektnej_dodavky_poznamka='".$_POST['notePerfektnaDodavka']."', priemerne_dni_dodania=".$dodanie.", priemerne_dni_dodania_poznamka='".$_POST['noteDniDodania']."', efektivnost_predaja=".$efektivnost.", efektivnost_predaja_poznamka='".$_POST['noteEfektivnostPredaja']."', sledovanie_objemu_predanych_vyrobkov=".$objem.", sledovanie_objemu_predanych_vyrobkov_poznamka='".$_POST['noteObjemPredanychVyrobkov']."', nove_vyrobky=".$vyrobky.", nove_vyrobky_poznamka='".$_POST['noteNoveVyrobky']."', mnozstvo_predanych_esad_ks=".$esady_ks.", mnozstvo_predanych_esad_ks_poznamka='".$_POST['noteEsadyKs']."', mnozstvo_predanych_esad_eur=".$esady_eur.", mnozstvo_predanych_esad_eur_poznamka='".$_POST['noteEsadyEur']."', zakazky_k_datum=".$datum.", zakazky_k=".$zakazky.", zakazky_k_poznamka='".$_POST['noteZakazkyEur']."', zakazky_k_na_sklade=".$sklad.", zakazky_k_na_sklade_poznamka='".$_POST['noteNaSklade']."', datetime_edited=NOW(), edit_exception=0  ";
             
            break;
            
        case "QS":
            $reklamovane_zakaznici=str_replace(",",".",$_POST['reklamovane_od_zakaznikov']!=""?$_POST['reklamovane_od_zakaznikov']:'NULL');
            $uznane_reklamacie=str_replace(",",".",$_POST['uznane_reklamacie']!=""?$_POST['uznane_reklamacie']:'NULL');
            $naklady_reklamacie=str_replace(",",".",$_POST['naklady_reklamacie']!=""?$_POST['naklady_reklamacie']:'NULL');
            $naklady_zakaznici=str_replace(",",".",$_POST['naklady_zakaznici']!=""?$_POST['naklady_zakaznici']:'NULL');
            $nvo_av=str_replace(",",".",$_POST['nvo_av']!=""?$_POST['nvo_av']:'NULL');
            $nvo_pl=str_replace(",",".",$_POST['nvo_pl']!=""?$_POST['nvo_pl']:'NULL');
            $nvo_celkom=str_replace(",",".",$_POST['nvo_celkom']!=""?$_POST['nvo_celkom']:'NULL');
            $naklady_chyby=str_replace(",",".",$_POST['naklady_chyby']!=""?$_POST['naklady_chyby']:'NULL');
            
            $query="UPDATE qs SET reklamovane_ks_od_zakaznikov=".$reklamovane_zakaznici.", reklamovane_ks_od_zakaznikov_poznamka='".$_POST['noteReklamovaneOdZakaznikov']."', uznane_reklamovane_ks_od_zakaznikov=".$uznane_reklamacie.", uznane_reklamovane_ks_od_zakaznikov_poznamka='".$_POST['noteUznaneReklamacie']."', uznane_naklady_za_reklamovane_ks=".$naklady_reklamacie.", uznane_naklady_za_reklamovane_ks_poznamka='".$_POST['noteNakladyReklamacie']."', naklady_na_reklamacie_od_zakaznikov=".$naklady_zakaznici.", naklady_na_reklamacie_od_zakaznikov_poznamky='".$_POST['noteNakladyZakaznici']."', mnozstvo_zaznamenanych_internych_nvo_av=".$nvo_av.", mnozstvo_zaznamenanych_internych_nvo_av_poznamka='".$_POST['noteNvoAv']."', mnozstvo_zaznamenanych_internych_nvo_pl=".$nvo_pl.", mnozstvo_zaznamenanych_internych_nvo_pl_poznamka='".$_POST['noteNvoPl']."', mnozstvo_zaznamenanych_internych_nvo_celkom=".$nvo_celkom.", mnozstvo_zaznamenanych_internych_nvo_celkom_poznamka='".$_POST['noteNvoCelkom']."', naklady_na_interne_chyby=".$naklady_chyby.", naklady_na_interne_chyby_poznamka='".$_POST['noteNakladyChyby']."', nv_4_sigma_6210ppm='".$_POST['sigma']."', nv_4_sigma_6210ppm_poznamka='".$_POST['noteSigma']."', datetime_edited=NOW(), edit_exception=0  ";

            break;
            
        case "QV":
            
            $query="UPDATE qv SET slovne_hodnotenie_riesenych_projektov='".$_POST['hodnotenie']."', slovne_hodnotenie_riesenych_projektov_poznamka='".$_POST['noteHodnotenie']."', datetime_edited=NOW(), edit_exception=0  ";
            
            break;
            
        case "PL":
            $doba_obratu=str_replace(",",".",$_POST['doba_obratu']!=""?$_POST['doba_obratu']:'NULL');
            $straty_celkom=str_replace(",",".",$_POST['straty_celkom']!=""?$_POST['straty_celkom']:'NULL');
            $straty_den=str_replace(",",".",$_POST['straty_den']!=""?$_POST['straty_den']:'NULL');
            $efektivnost_hodiny=str_replace(",",".",$_POST['efektivnost_hodiny']!=""?$_POST['efektivnost_hodiny']:'NULL');
            $pracovnici_obdobie=str_replace(",",".",$_POST['pracovnici_obdobie']!=""?$_POST['pracovnici_obdobie']:'NULL');
            $pracovnici_mesiac=str_replace(",",".",$_POST['pracovnici_mesiac']!=""?$_POST['pracovnici_mesiac']:'NULL');
            $efektivnost_trzby=str_replace(",",".",$_POST['efektivnost_trzby']!=""?$_POST['efektivnost_trzby']:'NULL');
            $prietok_esady=str_replace(",",".",$_POST['prietok_esady']!=""?$_POST['prietok_esady']:'NULL');
            $prietok_pracovnik=str_replace(",",".",$_POST['prietok_pracovnik']!=""?$_POST['prietok_pracovnik']:'NULL');
            $plnenie_noriem=str_replace(",",".",$_POST['plnenie_noriem']!=""?$_POST['plnenie_noriem']:'NULL');
            
            $query="UPDATE `pl` SET `priemerna_doba_obratu_zasob_voci_trzbam`=".$doba_obratu.", `priemerna_doba_obratu_zasob_voci_trzbam_poznamka`='".$_POST['noteDobaObratu']."', `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1`=".$straty_celkom.", `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1_poznamka`='".$_POST['noteStratyCelkom']."', `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2`=".$straty_den.", `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2_poznamka`='".$_POST['noteStratyDen']."', `efektivnost_vyroby`=".$efektivnost_hodiny.", `efektivnost_vyroby_poznamka`='".$_POST['noteEfektivnostHodiny']."', `priemerny_pocet_vyrobnych_pracovnikov_za_obd`=".$pracovnici_obdobie.", `priemerny_pocet_vyrobnych_pracovnikov_za_obd_poznamka`='".$_POST['notePracovniciObdobie']."', `pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci`=".$pracovnici_mesiac.", `pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci_poznamka`='".$_POST['notePracovniciMesiac']."', `efektivnost_vyroby_trzby_vyrob_pracovnik_den`=".$efektivnost_trzby.", `efektivnost_vyroby_trzby/vyrob_pracovnik/den_poznamka`='".$_POST['noteEfektivnostTrzby']."', `denny_prietok_vyroby_esady_ks`=".$prietok_esady.", `denny_prietok_vyroby_esady_ks_poznamka`='".$_POST['notePrietokEsady']."', `denny_prietok_vyroby_vyr_pracovnika_den`=".$prietok_pracovnik.", `denny_prietok_vyroby/vyr_pracovnika/den_poznamka`='".$_POST['notePrietokPracovnik']."', `plnenie_vykonovych_noriem`=".$plnenie_noriem.", `plnenie_vykonovych_noriem_poznamka`='".$_POST['notePlnenieNoriem']."', `datetime_edited`=NOW(), edit_exception=0  "; 
            
            break;
            
        case "PL200":
            
            $vyrobene_kusy=str_replace(",",".",$_POST['vyrobene_kusy']!=""?$_POST['vyrobene_kusy']:'NULL');
            $nto=str_replace(",",".",$_POST['nto']!=""?$_POST['nto']:'NULL');
            $nto_obdobie=str_replace(",",".",$_POST['nto_obdobie']!=""?$_POST['nto_obdobie']:'NULL');
            
            $query="UPDATE `pl200` SET `vyrobene_kusy`=".$vyrobene_kusy.", `vyrobene_kusy_poznamka`='".$_POST['noteVyrobeneKusy']."', `nto_na_vyrobene_mnozstvo_dielcov`=".$nto.", `nto_na_vyrobene_mnozstvo_dielcov_poznamka`='".$_POST['noteNTO']."', `hodnota_nto_za_cele_obdobie`=".$nto_obdobie.", `hodnota_nto_za_cele_obdobie_poznamka`='".$_POST['noteNTOObdobie']."', `datetime_edited`=NOW(), edit_exception=0  ";
            
            break;
            
        case "PL SMT/THT":
            
            $query="UPDATE `pl_smt_tht` SET`zasoba_vyrobenych_modulov`='".$_POST['zasoba']."', `zasoba_vyrobenych_modulov_poznamka`='".$_POST['noteZasoba']."', `datetime_edited`=NOW(), edit_exception=0 ";

            break;
            
        case "AV":
            
            $dokumentacia=str_replace(",",".",$_POST['dokumentacia']!=""?$_POST['dokumentacia']:'NULL');
            $kabelaze=str_replace(",",".",$_POST['kabelaze']!=""?$_POST['kabelaze']:'NULL');
            $vyrobky=str_replace(",",".",$_POST['vyrobky']!=""?$_POST['vyrobky']:'NULL');
            $navody=str_replace(",",".",$_POST['navody']!=""?$_POST['navody']:'NULL');
            $empb=str_replace(",",".",$_POST['empb']!=""?$_POST['empb']:'NULL');
            $investicie=str_replace(",",".",$_POST['investicie']!=""?$_POST['investicie']:'NULL');
            
            $query="UPDATE `av` SET `priemerny_pocet_dni_na_spracovanie_dokumentacie_mesiac`=".$dokumentacia.", `priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac_poznamka`='".$_POST['noteDokumentacia']."', `prirastok_vyrobkov_nove_vyrobky_kabelaze`=".$kabelaze.", `prirastok_vyrobkov_nove_vyrobky/kabelaze_poznamka`='".$_POST['noteKabelaze']."', `prirastok_vyrobkov_inovovane_vyrobky`=".$vyrobky.", `prirastok_vyrobkov_inovovane_vyrobky_poznamka`='".$_POST['noteVyrobky']."', `prirastok_vyrobkov_nove_navody`=".$navody.", `prirastok_vyrobkov_nove_navody_poznamka`='".$_POST['noteNavody']."', `prirastok_vyrobkov_vzorkovanie_empb`=".$empb.", `prirastok_vyrobkov_vzorkovanie-empb_poznamka`='".$_POST['noteEmpb']."', `naklady_na_investicie`=".$investicie.", `naklady_na_investicie_poznamka`='".$_POST['noteInvesticie']."', `datetime_edited`=NOW(), edit_exception=0  ";
            
            /*if(isset($_POST['fileToUpload'])){
                $target_dir = "documents/AV/".$year."_".$month;
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
            }*/
     
            break;
            
        case "TE":
            
            $investicie=str_replace(",",".",$_POST['investicie']!=""?$_POST['investicie']:'NULL');
            $hodiny=str_replace(",",".",$_POST['hodiny']!=""?$_POST['hodiny']:'NULL');
            
            $query="UPDATE `te` SET `investicie_do_vyvoja`=".$investicie.", `investicie_do_vyvoja_poznamka`='".$_POST['noteInvesticie']."', `pocet_hodin_venovanych_vyvoju`=".$hodiny.", `pocet_hodin_venovanych_vyvoju_poznamka`='".$_POST['noteHodiny']."', `datetime_edited`=NOW(), edit_exception=0  ";

            break;
            
        case "EDV":
            
            $vypadky=str_replace(",",".",$_POST['vypadky']!=""?$_POST['vypadky']:'NULL');
            
            $query="UPDATE `edv` SET `vypadky_siete_lan`=".$vypadky.", `vypadky_siete_lan_poznamka`='".$_POST['noteVypadky']."', `datetime_edited`=NOW(), edit_exception=0  ";
            
            break;
            
        case "EK":
            
            $objem_zasob=str_replace(",",".",$_POST['objem_zasob']!=""?$_POST['objem_zasob']:'NULL');
            $obratka_zasob=str_replace(",",".",$_POST['obratka_zasob']!=""?$_POST['obratka_zasob']:'NULL');
            $spotreba=str_replace(",",".",$_POST['spotreba']!=""?$_POST['spotreba']:'NULL');
            
            $query="UPDATE `ek` SET `objem_zasob_materialu`=".$objem_zasob.", `objem_zasob_materialu_poznamka`='".$_POST['noteObjemZasob']."', `obratka_zasob`=".$obratka_zasob.", `obratka_zasob_poznamka`='".$_POST['noteObratkaZasob']."', `spotreba_materialu_k_trzbam`=".$spotreba.", `spotreba_materialu_k_trzbam_poznamka`='".$_POST['noteSpotreba']."', `datetime_edited`=NOW(), edit_exception=0  ";  
            
            break;
    }
    
   $query.="WHERE YEAR(obdobie)=".$year." AND MONTH(obdobie)=".$month." ";
    
    if(mysqli_query($connect,$query)){
        if(isset($_POST['update'])){
            echo '<div class="alert alert-success">Údaje boli upravené.   <a href="index.php?modul='.$_SESSION['rights'].'-edit&send_mail=1&month='.$_GET['month'].'&year='.$_GET['year'].'" class="btn blue">Odoslať a zamknúť</a></div>';
        }elseif(isset($_POST['update2'])){
            echo "<script>window.location.replace('index.php?modul=".$_SESSION['rights']."-edit&success_edit=1&month=".$_GET['month']."&year=".$_GET['year']."');</script>";
        }
            
    }else{
            echo '<div class="alert alert-danger">Údaje sa nepodarilo zmeniť.</div>';
    }
    
    
}

function select_min_and_max_filled_year(){
    
    global $connect;
    
    $query="SELECT YEAR(LEAST(MIN(av.obdobie), MIN(bu.obdobie), MIN(edv.obdobie), MIN(ek.obdobie), MIN(pl.obdobie), MIN(pl200.obdobie), MIN(pl_smt_tht.obdobie), MIN(qs.obdobie), MIN(qv.obdobie), MIN(te.obdobie), MIN(vk.obdobie))) as min_year, YEAR(GREATEST(MAX(av.obdobie), MAX(bu.obdobie), MAX(edv.obdobie), MAX(ek.obdobie), MAX(pl.obdobie), MAX(pl200.obdobie), MAX(pl_smt_tht.obdobie), MAX(qs.obdobie), MAX(qv.obdobie), MAX(te.obdobie), MAX(vk.obdobie))) as max_year FROM av, bu, edv, ek, pl, pl200, pl_smt_tht, qs, qv, te, vk";
    $apply_query=mysqli_query($connect, $query);
    $result=mysqli_fetch_array($apply_query);
    $years=array($result['min_year'], $result['max_year']);
    
    return $years;
    
}

function select_all_from_period($month,$year){
    global $connect;
    
    echo $query="SELECT * FROM av, bu, edv, ek, pl, pl200, pl_smt_tht, qs, qv, te, vk WHERE YEAR(av.obdobie)=".$year." AND MONTH(av.obdobie)=".$month." AND YEAR(bu.obdobie)=".$year." AND MONTH(bu.obdobie)=".$month." AND YEAR(edv.obdobie)=".$year." AND MONTH(edv.obdobie)=".$month." AND YEAR(ek.obdobie)=".$year." AND MONTH(av.obdobie)=".$month." AND YEAR(av.obdobie)=".$year." AND MONTH(av.obdobie)=".$month." AND YEAR(av.obdobie)=".$year."  AND MONTH(ek.obdobie)=".$month." AND YEAR(pl.obdobie)=".$year." AND MONTH(pl.obdobie)=".$month." AND YEAR(pl200.obdobie)=".$year." AND MONTH(pl200.obdobie)=".$month." AND YEAR(pl_smt_tht.obdobie)=".$year." AND MONTH(pl_smt_tht.obdobie)=".$month." AND YEAR(qs.obdobie)=".$year." AND MONTH(qs.obdobie)=".$month." AND YEAR(qv.obdobie)=".$year." AND MONTH(qv.obdobie)=".$month." AND YEAR(te.obdobie)=".$year." AND MONTH(te.obdobie)=".$month." AND YEAR(vk.obdobie)=".$year." AND MONTH(vk.obdobie)=".$month." ";
    $apply_query=mysqli_query($connect,$query);
    
    return mysqli_fetch_array($apply_query);
}

function insertData($rights){
    global $connect;
    
    switch ($rights){
        case "BU":
            $kumulativne=$_POST['hv_v_eur_kumulativne']!=""?$_POST['hv_v_eur_kumulativne']:'NULL';
            $predaj_vyrobkov=$_POST['trzby_predaj_vyrobkov']!=""?$_POST['trzby_predaj_vyrobkov']:'NULL';
            $material=$_POST['spotreba_materialu']!=""?$_POST['spotreba_materialu']:'NULL';
            $energie=$_POST['spotreba_energie']!=""?$_POST['spotreba_energie']:'NULL';
            $mzdy=$_POST['mzdove_naklady']!=""?$_POST['mzdove_naklady']:'NULL';
            $zarobok=$_POST['priemerny_zarobok']!=""?$_POST['priemerny_zarobok']:'NULL';
            $poc_zam=$_POST['priemerny_pocet_zamestnancov']!=""?$_POST['priemerny_pocet_zamestnancov']:'NULL';
            $ev_stav=$_POST['ev_stav']!=""?$_POST['ev_stav']:'NULL';
            $fluktuacia=$_POST['fluktacia']!=""?$_POST['fluktacia']:'NULL';
            $fond_100=$_POST['prac_fond_100']!=""?$_POST['prac_fond_100']:'NULL';
            $fond_200=$_POST['prac_fond_200']!=""?$_POST['prac_fond_200']:'NULL';
            $fond_celkom=$_POST['prac_fond_celkom']!=""?$_POST['prac_fond_celkom']:'NULL';
            $nadcas_100=$_POST['nadcas_100']!=""?$_POST['nadcas_100']:'NULL';
            $nadcas_200=$_POST['nadcas_200']!=""?$_POST['nadcas_200']:'NULL';
            $nadcas_celkom=$_POST['nadcas_celkom']!=""?$_POST['nadcas_celkom']:'NULL';
            
            $query="INSERT INTO bu(hv_kumulativne, hv_kumulativne_poznamka, trzby_vlastne_vyrobky, trzby_vlastne_vyrobky_poznamka, spotreba_materialu, spotreba_materialu_poznamka, spotreba_energie, spotreba_energie_poznamka, mzdove_naklady, mzdove_naklady_poznamka, priemerny_zarobok, priemerny_zarobok_poznamka, priemerny_pocet_zamestnancov, priemerny_pocet_zamestnancov_poznamka, stav_posledny_den, stav_posledny_den_poznamka, fluktuacia, fluktuacia_poznamka, pracovny_fond_100, pracovny_fond_100_poznamka, pracovny_fond_200, pracovny_fond_200_poznamka, pracovny_fond_mkem, pracovny_fond_mkem_poznamka, nadcasove_hodiny_100, nadcasove_hodiny_100_poznamka, nadcasove_hodiny_200, nadcasove_hodiny_200_poznamka, nadcasove_hodiny_mkem, nadcasove_hodiny_mkem_poznamka, datetime_created, obdobie) "; 
            
            $query.= "VALUES(".$kumulativne.", '".$_POST['noteHV']."', ".$predaj_vyrobkov.", '".$_POST['notePredajVyrobkov']."', ".$material.", '".$_POST['noteSpotrebaMaterialu']."', ".$energie.", '".$_POST['noteSpotrebaEnergie']."', ".$mzdy.", '".$_POST['noteMzdoveNaklady']."', ".$zarobok.", '".$_POST['notePriemernyZarobok']."', ".$poc_zam.", '".$_POST['notePriemernyPocetZamestnancov']."', ".$ev_stav.", '".$_POST['noteEvStav']."', ".$fluktuacia.", '".$_POST['noteFluktacia']."', ".$fond_100.", '".$_POST['notePracFond100']."', ".$fond_200.", '".$_POST['notePracFond200']."', ".$fond_celkom.", '".$_POST['notePracFondCelkom']."', ".$nadcas_100.", '".$_POST['noteNadcas100']."', ".$nadcas_200.", '".$_POST['noteNadcas200']."', ".$nadcas_celkom.", '".$_POST['noteNadcasCelkom']."', NOW(), '".$_POST['obdobie']."') ";
            
            break;
            
        case "VK":
            $reklamacie=$_POST['doba_reklamacii']!=""?$_POST['doba_reklamacii']:'NULL';
            $trzby=$_POST['naklady_z_trzieb']!=""?$_POST['naklady_z_trzieb']:'NULL';
            $dodavka=$_POST['perfektna_dodavka']!=""?$_POST['perfektna_dodavka']:'NULL';
            $dodanie=$_POST['dni_dodania']!=""?$_POST['dni_dodania']:'NULL';
            $efektivnost=$_POST['efektivnost_predaja']!=""?$_POST['efektivnost_predaja']:'NULL';
            $objem=$_POST['objem_predanych_vyrobkov']!=""?$_POST['objem_predanych_vyrobkov']:'NULL';
            $vyrobky=$_POST['nove_vyrobky']!=""?$_POST['nove_vyrobky']:'NULL';
            $esady_ks=$_POST['esady_ks']!=""?$_POST['esady_ks']:'NULL';
            $esady_eur=$_POST['esady_eur']!=""?$_POST['esady_eur']:'NULL';
            $datum=$_POST['zakazky_datum']!=""?"'".$_POST['zakazky_datum']."'":'NULL';
            $zakazky=$_POST['zakazky_eur']!=""?$_POST['zakazky_eur']:'NULL';
            $sklad=$_POST['na_sklade']!=""?$_POST['na_sklade']:'NULL';
            
            $query="INSERT INTO vk (doba_vybavovania_reklamacii, doba_vybavovania_reklamacii_poznamka, podiel_nakladov_z_trzieb, podiel_nakladov_z_trzieb_poznamka, index_perfektnej_dodavky, index_perfektnej_dodavky_poznamka, priemerne_dni_dodania, priemerne_dni_dodania_poznamka, efektivnost_predaja, efektivnost_predaja_poznamka, sledovanie_objemu_predanych_vyrobkov, sledovanie_objemu_predanych_vyrobkov_poznamka, nove_vyrobky, nove_vyrobky_poznamka, mnozstvo_predanych_esad_ks, mnozstvo_predanych_esad_ks_poznamka, mnozstvo_predanych_esad_eur, mnozstvo_predanych_esad_eur_poznamka, zakazky_k_datum, zakazky_k, zakazky_k_poznamka, zakazky_k_na_sklade, zakazky_k_na_sklade_poznamka, datetime_created, obdobie) ";
            
            $query.="VALUES (".$reklamacie.", '".$_POST['noteDobaReklamacii']."', ".$trzby.", '".$_POST['noteNakladyZTrzieb']."', ".$dodavka.", '".$_POST['notePerfektnaDodavka']."', ".$dodanie.", '".$_POST['noteDniDodania']."', ".$efektivnost.", '".$_POST['noteEfektivnostPredaja']."', ".$objem.", '".$_POST['noteObjemPredanychVyrobkov']."', ".$vyrobky.", '".$_POST['noteNoveVyrobky']."', ".$esady_ks.", '".$_POST['noteEsadyKs']."', ".$esady_eur.", '".$_POST['noteEsadyEur']."', ".$datum.", ".$zakazky.", '".$_POST['noteZakazkyEur']."', ".$sklad.", '".$_POST['noteNaSklade']."', NOW(),  '".$_POST['obdobie']."') ";
            
            break;
            
        case "QS":
            $reklamovane_zakaznici=$_POST['reklamovane_od_zakaznikov']!=""?$_POST['reklamovane_od_zakaznikov']:'NULL';
            $uznane_reklamacie=$_POST['uznane_reklamacie']!=""?$_POST['uznane_reklamacie']:'NULL';
            $naklady_reklamacie=$_POST['naklady_reklamacie']!=""?$_POST['naklady_reklamacie']:'NULL';
            $naklady_zakaznici=$_POST['naklady_zakaznici']!=""?$_POST['naklady_zakaznici']:'NULL';
            $nvo_av=$_POST['nvo_av']!=""?$_POST['nvo_av']:'NULL';
            $nvo_pl=$_POST['nvo_pl']!=""?$_POST['nvo_pl']:'NULL';
            $nvo_celkom=$_POST['nvo_celkom']!=""?$_POST['nvo_celkom']:'NULL';
            $naklady_chyby=$_POST['naklady_chyby']!=""?$_POST['naklady_chyby']:'NULL';
            
            $query="INSERT INTO qs (reklamovane_ks_od_zakaznikov, reklamovane_ks_od_zakaznikov_poznamka, uznane_reklamovane_ks_od_zakaznikov, uznane_reklamovane_ks_od_zakaznikov_poznamka, uznane_naklady_za_reklamovane_ks, uznane_naklady_za_reklamovane_ks_poznamka, naklady_na_reklamacie_od_zakaznikov, naklady_na_reklamacie_od_zakaznikov_poznamky, mnozstvo_zaznamenanych_internych_nvo_av, mnozstvo_zaznamenanych_internych_nvo_av_poznamka, mnozstvo_zaznamenanych_internych_nvo_pl, mnozstvo_zaznamenanych_internych_nvo_pl_poznamka, mnozstvo_zaznamenanych_internych_nvo_celkom, mnozstvo_zaznamenanych_internych_nvo_celkom_poznamka, naklady_na_interne_chyby, naklady_na_interne_chyby_poznamka, nv_4_sigma_6210ppm, nv_4_sigma_6210ppm_poznamka, datetime_created, obdobie) ";
            
            $query.="VALUES (".$reklamovane_zakaznici.", '".$_POST['noteReklamovaneOdZakaznikov']."', ".$uznane_reklamacie.", '".$_POST['noteUznaneReklamacie']."', ".$naklady_reklamacie.", '".$_POST['noteNakladyReklamacie']."', ".$naklady_zakaznici.", '".$_POST['noteNakladyZakaznici']."', ".$nvo_av.", '".$_POST['noteNvoAv']."', ".$nvo_pl.", '".$_POST['noteNvoPl']."', ".$nvo_celkom.", '".$_POST['noteNvoCelkom']."', ".$naklady_chyby.", '".$_POST['noteNakladyChyby']."', '".$_POST['sigma']."', '".$_POST['noteSigma']."', NOW(), '".$_POST['obdobie']."') ";
            
            break;
        case "QV":
            
            $query="INSERT INTO `qv` (`slovne_hodnotenie_riesenych_projektov`, `slovne_hodnotenie_riesenych_projektov_poznamka`, `datetime_created`, `obdobie`)";
            $query.= "VALUES ('".$_POST['hodnotenie']."', '".$_POST['noteHodnotenie']."', NOW(), '".$_POST['obdobie']."')";
            
            break;
        case "PL":
            $doba_obratu=$_POST['doba_obratu']!=""?$_POST['doba_obratu']:'NULL';
            $straty_celkom=$_POST['straty_celkom']!=""?$_POST['straty_celkom']:'NULL';
            $straty_den=$_POST['straty_den']!=""?$_POST['straty_den']:'NULL';
            $efektivnost_hodiny=$_POST['efektivnost_hodiny']!=""?$_POST['efektivnost_hodiny']:'NULL';
            $pracovnici_obdobie=$_POST['pracovnici_obdobie']!=""?$_POST['pracovnici_obdobie']:'NULL';
            $pracovnici_mesiac=$_POST['pracovnici_mesiac']!=""?$_POST['pracovnici_mesiac']:'NULL';
            $efektivnost_trzby=$_POST['efektivnost_trzby']!=""?$_POST['efektivnost_trzby']:'NULL';
            $prietok_esady=$_POST['prietok_esady']!=""?$_POST['prietok_esady']:'NULL';
            $prietok_pracovnik=$_POST['prietok_pracovnik']!=""?$_POST['prietok_pracovnik']:'NULL';
            $plnenie_noriem=$_POST['plnenie_noriem']!=""?$_POST['plnenie_noriem']:'NULL';
            
            $query="INSERT INTO `pl` ( `priemerna_doba_obratu_zasob_voci_trzbam`, `priemerna_doba_obratu_zasob_voci_trzbam_poznamka`, `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1`, `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1_poznamka`, `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2`, `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2_poznamka`, `efektivnost_vyroby`, `efektivnost_vyroby_poznamka`, `priemerny_pocet_vyrobnych_pracovnikov_za_obd`, `priemerny_pocet_vyrobnych_pracovnikov_za_obd_poznamka`, `pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci`, `pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci_poznamka`, `efektivnost_vyroby_trzby_vyrob_pracovnik_den`, `efektivnost_vyroby_trzby/vyrob_pracovnik/den_poznamka`, `denny_prietok_vyroby_esady_ks`, `denny_prietok_vyroby_esady_ks_poznamka`, `denny_prietok_vyroby_vyr_pracovnika_den`, `denny_prietok_vyroby/vyr_pracovnika/den_poznamka`, `plnenie_vykonovych_noriem`, `plnenie_vykonovych_noriem_poznamka`, `datetime_created`, `obdobie`) "; 
            
            $query.="VALUES (".$doba_obratu.", '".$_POST['noteDobaObratu']."', ".$straty_celkom.", '".$_POST['noteStratyCelkom']."', ".$straty_den.", '".$_POST['noteStratyDen']."', ".$efektivnost_hodiny.", '".$_POST['noteEfektivnostHodiny']."', ".$pracovnici_obdobie.", '".$_POST['notePracovniciObdobie']."', ".$pracovnici_mesiac.", '".$_POST['notePracovniciMesiac']."', ".$efektivnost_trzby.", '".$_POST['noteEfektivnostTrzby']."', ".$prietok_esady.", '".$_POST['notePrietokEsady']."', ".$prietok_pracovnik.", '".$_POST['notePrietokPracovnik']."', ".$plnenie_noriem.", '".$_POST['notePlnenieNoriem']."', NOW(), '".$_POST['obdobie']."') ";
            
            break;
        case "PL200":
            
            $vyrobene_kusy=$_POST['vyrobene_kusy']!=""?$_POST['vyrobene_kusy']:'NULL';
            $nto=$_POST['nto']!=""?$_POST['nto']:'NULL';
            $nto_obdobie=$_POST['nto_obdobie']!=""?$_POST['nto_obdobie']:'NULL';
            
            $query="INSERT INTO `pl200` (`vyrobene_kusy`, `vyrobene_kusy_poznamka`, `nto_na_vyrobene_mnozstvo_dielcov`, `nto_na_vyrobene_mnozstvo_dielcov_poznamka`, `hodnota_nto_za_cele_obdobie`, `hodnota_nto_za_cele_obdobie_poznamka`, `datetime_created`, `obdobie`) ";
            
           $query.="VALUES (".$vyrobene_kusy.", '".$_POST['noteVyrobeneKusy']."', ".$nto.", '".$_POST['noteNTO']."', ".$nto_obdobie.", '".$_POST['noteNTOObdobie']."', NOW(), '".$_POST['obdobie']."')";
            
            break;
        case "PL SMT/THT":
            
            $query="INSERT INTO `pl_smt_tht` (`zasoba_vyrobenych_modulov`, `zasoba_vyrobenych_modulov_poznamka`, `datetime_created`, `obdobie`) ";
            
            $query.="VALUES ('".$_POST['zasoba']."', '".$_POST['noteZasoba']."', NOW(), '".$_POST['obdobie']."')";
            
            break;
        case "AV":
            
            $dokumentacia=$_POST['dokumentacia']!=""?$_POST['dokumentacia']:'NULL';
            $kabelaze=$_POST['kabelaze']!=""?$_POST['kabelaze']:'NULL';
            $vyrobky=$_POST['vyrobky']!=""?$_POST['vyrobky']:'NULL';
            $navody=$_POST['navody']!=""?$_POST['navody']:'NULL';
            $empb=$_POST['empb']!=""?$_POST['empb']:'NULL';
            $investicie=$_POST['investicie']!=""?$_POST['investicie']:'NULL';
            
            $query="INSERT INTO `av` (`priemerny_pocet_dni_na_spracovanie_dokumentacie_mesiac`, `priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac_poznamka`, `prirastok_vyrobkov_nove_vyrobky_kabelaze`, `prirastok_vyrobkov_nove_vyrobky/kabelaze_poznamka`, `prirastok_vyrobkov_inovovane_vyrobky`, `prirastok_vyrobkov_inovovane_vyrobky_poznamka`, `prirastok_vyrobkov_nove_navody`, `prirastok_vyrobkov_nove_navody_poznamka`, `prirastok_vyrobkov_vzorkovanie_empb`, `prirastok_vyrobkov_vzorkovanie-empb_poznamka`, `naklady_na_investicie`, `naklady_na_investicie_poznamka`, `datetime_created`, `obdobie`) ";
            
            $query.="VALUES (".$dokumentacia.", '".$_POST['noteDokumentacia']."', ".$kabelaze.", '".$_POST['noteKabelaze']."', ".$vyrobky.", '".$_POST['noteVyrobky']."', ".$navody.", '".$_POST['noteNavody']."', ".$empb.", '".$_POST['noteEmpb']."', ".$investicie.", '".$_POST['noteInvesticie']."', NOW(), '".$_POST['obdobie']."') ";
            
            break;
        case "TE":
            
            $investicie=$_POST['investicie']!=""?$_POST['investicie']:'NULL';
            $hodiny=$_POST['hodiny']!=""?$_POST['hodiny']:'NULL';
            
            $query="INSERT INTO `te` ( `investicie_do_vyvoja`, `investicie_do_vyvoja_poznamka`, `pocet_hodin_venovanych_vyvoju`, `pocet_hodin_venovanych_vyvoju_poznamka`, `datetime_created`, `obdobie`) ";
            
            $query.="VALUES (".$investicie.", '".$_POST['noteInvesticie']."', ".$hodiny.", '".$_POST['noteHodiny']."', NOW(), '".$_POST['obdobie']."') ";
            
            break;
        case "EDV":
            
            $vypadky=$_POST['vypadky']!=""?$_POST['vypadky']:'NULL';
            
            $query="INSERT INTO `edv` (`vypadky_siete_lan`, `vypadky_siete_lan_poznamka`, `datetime_created`, `obdobie`) ";
            
            $query.="VALUES ( ".$vypadky.", '".$_POST['noteVypadky']."', NOW(), '".$_POST['obdobie']."') ";
            
            break;
        case "EK":
            
            $objem_zasob=$_POST['objem_zasob']!=""?$_POST['objem_zasob']:'NULL';
            $obratka_zasob=$_POST['obratka_zasob']!=""?$_POST['obratka_zasob']:'NULL';
            $spotreba=$_POST['spotreba']!=""?$_POST['spotreba']:'NULL';
            
            $query="INSERT INTO `ek` (`objem_zasob_materialu`, `objem_zasob_materialu_poznamka`, `obratka_zasob`, `obratka_zasob_poznamka`, `spotreba_materialu_k_trzbam`, `spotreba_materialu_k_trzbam_poznamka`, `datetime_created`, `obdobie`) ";
            
            $query.="VALUES (".$objem_zasob.", '".$_POST['noteObjemZasob']."', ".$obratka_zasob.", '".$_POST['noteObratkaZasob']."', ".$spotreba.", '".$_POST['noteSpotreba']."', NOW(), '".$_POST['obdobie']."') ";
            
            break;
        
    }
    
    if(mysqli_query($connect,$query)){
        
        if(isset($_POST['insert'])){
            echo '<div class="alert alert-success">Údaje boli zaznamenané.   <a href="index.php?modul='.$_SESSION['rights'].'-add&send_mail=1&obdobie='.$_POST['obdobie'].'" class="btn blue">Odoslať a zamknúť</a></div>';
        }elseif(isset($_POST['insert2'])){
            echo "<script>window.location.replace('index.php?modul=".$_SESSION['rights']."-add&send_mail=1&month=".date("m",strtotime($_POST['obdobie']))."&year=".date("Y",strtotime($_POST['obdobie']))."');</script>";
        }
    }elseif(mysqli_error($connect)=="Duplicate entry '".$_POST['obdobie']."' for key 'obdobie'"){
        $month = date("m",strtotime($_POST['obdobie']));
        $year = date("Y",strtotime($_POST['obdobie']));
        echo '<div class="alert alert-danger">Údaje sa nepodarilo zaznamenať, záznam pre toto obdobie už existuje. <a href="index.php?modul=prehlad&month='.$month.'&year='.$year.'">PREHĽAD</a></div>';
    }
    else{
         echo '<div class="alert alert-danger">Údaje sa nepodarilo zaznamenať.</div>';
    }
    
    
}

function rights($person_number){
    switch ($person_number){
        case 359:
        case 592:
            return "BU";
        case 79:
            return "VK";
        case 132:
            return "QS";
        case 292:
            return "QV";
        case 9:
        case 26:
            return "PL";
        case 460:
            return "PL200";
        case 671:
            return "PL SMT/THT";
        case 10:
            return "AV";
        case 556:
            return "TE";
        case 553:
            return "EDV";
        case 23:
            return "EK";
        case 376:
            return "task_adder";
        case 357:
            return "boss";
        default:
            return "readonly";
    }
}

/*
SEO URL
*/
function url_slug($str, $options = array()) {
	// Make sure string is in UTF-8 and strip invalid UTF-8 characters
	$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
	
	$defaults = array(
		'delimiter' => '-',
		'limit' => null,
		'lowercase' => true,
		'replacements' => array(),
		'transliterate' => true,
	);
	
	// Merge options
	$options = array_merge($defaults, $options);
	
	$char_map = array(
		// Latin
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
		'ß' => 'ss', 
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
		'ÿ' => 'y',

		// Latin symbols
		'©' => '(c)',

		// Greek
		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
		'Ϋ' => 'Y',
		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

		// Turkish
		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 

		// Russian
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
		'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
		'я' => 'ya',

		// Ukrainian
		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

		// Czech
		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
		'Ž' => 'Z', 
		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
		'ž' => 'z', 

		// Polish
		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
		'Ż' => 'Z', 
		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
		'ż' => 'z',

		// Latvian
		'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
		'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
		'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
		'š' => 's', 'ū' => 'u', 'ž' => 'z'
	);
	
	// Make custom replacements
	$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
	
	// Transliterate characters to ASCII
	if ($options['transliterate']) {
		$str = str_replace(array_keys($char_map), $char_map, $str);
	}
	
	// Replace non-alphanumeric characters with our delimiter
	$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
	
	// Remove duplicate delimiters
	$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
	
	// Truncate slug to max. characters
	$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
	
	// Remove delimiter from ends
	$str = trim($str, $options['delimiter']);
	
	return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 function pagination($query, $per_page = 10,$page = 1, $url='?',$connect){         
    	$query = "SELECT COUNT(*) as `num` FROM {$query}";
		
    	$row = mysqli_fetch_array(mysqli_query($connect,$query));
    	$total = $row['num'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination pagination-lg'>";
                    $pagination .= "";
					if($page<2){
					$pagination.= "<li><a>Predchádzajúca</a></li>";
					}
					else{
					$pagination.= "<li><a href='{$url}/$prev'>Predchádzajúca</a></li>";
					}
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li class='active'><a>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}/$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='active'><a>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}/$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'><a>..</a></li>";
    				$pagination.= "<li><a href='{$url}/$lpm1'>$lpm1</a></li>";
    				$pagination.= "";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}/1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}/2'>2</a></li>";
    				$pagination.= "<li class='dot'><a>..</a></li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='active'><a>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}/$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'><a>..</a></li>";
    				$pagination.= "<li><a href='{$url}/$lpm1'>$lpm1</a></li>";
    				$pagination.= "";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}/1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}/2'>2</a></li>";
    				$pagination.= "<li class='dot'><a>..</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='active'><a>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}/$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}/$next'>Ďalšia</a></li>";
                $pagination.= "";
    		}else{
    			$pagination.= "<li><a>Ďalšia</a></li>";
                $pagination.= "";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
    } 
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function pagination_search($query, $per_page = 10,$page = 1, $url='?',$connect){         
    	$query = "SELECT COUNT(*) as `num` FROM {$query}";
		
    	$row = mysqli_fetch_array(mysqli_query($connect,$query));
    	$total = $row['num'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination pagination-lg'>";
                    $pagination .= "";
					if($page<2){
					$pagination.= "<li><a>Predchádzajúca</a></li>";
					}
					else{
					$pagination.= "<li><a href='{$url}$prev'>Predchádzajúca</a></li>";
					}
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li class='active'><a>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='active'><a>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'><a>..</a></li>";
    				$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
    				$pagination.= "";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}2'>2</a></li>";
    				$pagination.= "<li class='dot'><a>..</a></li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='active'><a>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'><a>..</a></li>";
    				$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
    				$pagination.= "";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}2'>2</a></li>";
    				$pagination.= "<li class='dot'><a>..</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='active'><a>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}$next'>Ďalšia</a></li>";
                $pagination.= "";
    		}else{
    			$pagination.= "<li><a>Ďalšia</a></li>";
                $pagination.= "";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
    } 
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//***********************************************************************************************************



?>