<?php

                                                     $vypadky=array();
                                                    $vypadky_p=array();
                                                    $id=array();
                                                    $num_of_actual_period=0;
                                                    while($num_of_actual_period<$count_of_periods){
                                                        $query_BU="SELECT * FROM edv WHERE YEAR(obdobie)=".$years[$num_of_actual_period]." AND MONTH(obdobie)=".$months[$num_of_actual_period]." ";
                                                        $apply_BU=mysqli_query($connect,$query_BU);
                                                        $result_BU=mysqli_fetch_array($apply_BU);
                                                        array_push($vypadky,$result_BU['vypadky_siete_lan']);
                                                        array_push($vypadky_p,$result_BU['vypadky_siete_lan_poznamka']);
                                                        array_push($id,$result_BU['id']);
                                                        $num_of_actual_period++;
                                                    }
?>