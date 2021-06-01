<?php

                                                    $investicie=array();
                                                    $investicie_p=array();
                                                    $vyvoj=array();
                                                    $vyvoj_p=array();
                                                    $id=array();
                                                    $num_of_actual_period=0;
                                                    while($num_of_actual_period<$count_of_periods){
                                                        $query_BU="SELECT * FROM te WHERE YEAR(obdobie)=".$years[$num_of_actual_period]." AND MONTH(obdobie)=".$months[$num_of_actual_period]." ";
                                                        $apply_BU=mysqli_query($connect,$query_BU);
                                                        $result_BU=mysqli_fetch_array($apply_BU);
                                                        array_push($investicie,$result_BU['investicie_do_vyvoja']);
                                                        array_push($investicie_p,$result_BU['investicie_do_vyvoja_poznamka']);
                                                        array_push($vyvoj,$result_BU['pocet_hodin_venovanych_vyvoju']);
                                                        array_push($vyvoj_p,$result_BU['pocet_hodin_venovanych_vyvoju_poznamka']);
                                                        array_push($id,$result_BU['id']);
                                                        $num_of_actual_period++;
                                                    }

?>