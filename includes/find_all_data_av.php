<?php

                                                    $pocet_dni=array();
                                                    $pocet_dni_p=array();
                                                    $nove_vyrobky=array();
                                                    $nove_vyrobky_p=array();
                                                    $inovovane=array();
                                                    $inovovane_p=array();
                                                    $navody=array();
                                                    $navody_p=array();
                                                    $empb=array();
                                                    $empb_p=array();
                                                    $naklady_investicie=array();
                                                    $naklady_investicie_p=array();
                                                    $id=array();
                                                    $num_of_actual_period=0;
                                                    while($num_of_actual_period<$count_of_periods){
                                                        $query_BU="SELECT * FROM av WHERE YEAR(obdobie)=".$years[$num_of_actual_period]." AND MONTH(obdobie)=".$months[$num_of_actual_period]." ";
                                                        $apply_BU=mysqli_query($connect,$query_BU);
                                                        $result_BU=mysqli_fetch_array($apply_BU);
                                                        array_push($pocet_dni,$result_BU['priemerny_pocet_dni_na_spracovanie_dokumentacie_mesiac']);
                                                        array_push($pocet_dni_p,$result_BU['priemerny_pocet_dni_na spracovanie_dokumentacie_mesiac_poznamka']);
                                                        array_push($nove_vyrobky,$result_BU['prirastok_vyrobkov_nove_vyrobky_kabelaze']);
                                                        array_push($nove_vyrobky_p,$result_BU['prirastok_vyrobkov_nove_vyrobky_kabelaze_poznamka']);
                                                        array_push($inovovane,$result_BU['prirastok_vyrobkov_inovovane_vyrobky']);
                                                        array_push($inovovane_p,$result_BU['prirastok_vyrobkov_inovovane_vyrobky_poznamka']);
                                                        array_push($navody,$result_BU['prirastok_vyrobkov_nove_navody']);
                                                        array_push($navody_p,$result_BU['prirastok_vyrobkov_nove_navody_poznamka']);
                                                        array_push($empb,$result_BU['prirastok_vyrobkov_vzorkovanie_empb']);
                                                        array_push($empb_p,$result_BU['prirastok_vyrobkov_vzorkovanie-empb_poznamka']);
                                                        array_push($naklady_investicie,$result_BU['naklady_na_investicie']);
                                                        array_push($naklady_investicie_p,$result_BU['naklady_na_investicie_poznamka']);
                                                        array_push($id,$result_BU['id']);
                                                        $num_of_actual_period++;
                                                    }

?>