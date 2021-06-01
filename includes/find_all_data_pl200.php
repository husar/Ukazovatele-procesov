<?php
                                               
                                                    $vyrobene_kusy=array();
                                                    $vyrobene_kusy_p=array();
                                                    $dielce=array();
                                                    $dielce_p=array();
                                                    $nto=array();
                                                    $nto_p=array();
                                                    $id=array();
                                                    $num_of_actual_period=0;
                                                    while($num_of_actual_period<$count_of_periods){
                                                        $query_BU="SELECT * FROM pl200 WHERE YEAR(obdobie)=".$years[$num_of_actual_period]." AND MONTH(obdobie)=".$months[$num_of_actual_period]." ";
                                                        $apply_BU=mysqli_query($connect,$query_BU);
                                                        $result_BU=mysqli_fetch_array($apply_BU);
                                                        array_push($vyrobene_kusy,$result_BU['vyrobene_kusy']);
                                                        array_push($vyrobene_kusy_p,$result_BU['vyrobene_kusy_poznamka']);
                                                        array_push($dielce,$result_BU['nto_na_vyrobene_mnozstvo_dielcov']);
                                                        array_push($dielce_p,$result_BU['nto_na_vyrobene_mnozstvo_dielcov_poznamka']);
                                                        array_push($nto,$result_BU['hodnota_nto_za_cele_obdobie']);
                                                        array_push($nto_p,$result_BU['hodnota_nto_za_cele_obdobie_poznamka']);
                                                        array_push($id,$result_BU['id']);
                                                        $num_of_actual_period++;
                                                    }
                                               
                                                ?>