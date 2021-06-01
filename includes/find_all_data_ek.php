<?php

                                                    $material=array();
                                                    $material_p=array();
                                                    $obratka=array();
                                                    $obratka_p=array();
                                                    $spotreba_trzby=array();
                                                    $spotreba_trzby_p=array();
                                                    $id=array();
                                                    $num_of_actual_period=0;
                                                    while($num_of_actual_period<$count_of_periods){
                                                        $query_BU="SELECT * FROM ek WHERE YEAR(obdobie)=".$years[$num_of_actual_period]." AND MONTH(obdobie)=".$months[$num_of_actual_period]." ";
                                                        $apply_BU=mysqli_query($connect,$query_BU);
                                                        $result_BU=mysqli_fetch_array($apply_BU);
                                                        array_push($material,$result_BU['objem_zasob_materialu']);
                                                        array_push($material_p,$result_BU['objem_zasob_materialu_poznamka']);
                                                        array_push($obratka,$result_BU['obratka_zasob']);
                                                        array_push($obratka_p,$result_BU['obratka_zasob_poznamka']);
                                                        array_push($spotreba_trzby,$result_BU['spotreba_materialu_k_trzbam']);
                                                        array_push($spotreba_trzby_p,$result_BU['spotreba_materialu_k_trzbam_poznamka']);
                                                        array_push($id,$result_BU['id']);
                                                        $num_of_actual_period++;
                                                    }
?>