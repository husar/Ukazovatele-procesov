<?php

                                                    $reklamovane=array();
                                                    $reklamovane_p=array();
                                                    $uznane=array();
                                                    $uznane_p=array();
                                                    $uznane_naklady=array();
                                                    $uznane_naklady_p=array();
                                                    $naklady_reklamacie=array();
                                                    $naklady_reklamacie_p=array();
                                                    $nvo_av=array();
                                                    $nvo_av_p=array();
                                                    $nvo_pl=array();
                                                    $nvo_pl_p=array();
                                                    $nvo_celkom=array();
                                                    $nvo_celkom_p=array();
                                                    $naklady_chyby=array();
                                                    $naklady_chyby_p=array();
                                                    $sigma=array();
                                                    $sigma_p=array();
                                                    $id=array();
                                                    $num_of_actual_period=0;
                                                    while($num_of_actual_period<$count_of_periods){
                                                        $query_BU="SELECT * FROM qs WHERE YEAR(obdobie)=".$years[$num_of_actual_period]." AND MONTH(obdobie)=".$months[$num_of_actual_period]." ";
                                                        $apply_BU=mysqli_query($connect,$query_BU);
                                                        $result_BU=mysqli_fetch_array($apply_BU);
                                                        array_push($reklamovane,$result_BU['reklamovane_ks_od_zakaznikov']);
                                                        array_push($reklamovane_p,$result_BU['reklamovane_ks_od_zakaznikov_poznamka']);
                                                        array_push($uznane,$result_BU['uznane_reklamovane_ks_od_zakaznikov']);
                                                        array_push($uznane_p,$result_BU['uznane_reklamovane_ks_od_zakaznikov_poznamka']);
                                                        array_push($uznane_naklady,$result_BU['uznane_naklady_za_reklamovane_ks']);
                                                        array_push($uznane_naklady_p,$result_BU['uznane_naklady_za_reklamovane_ks_poznamka']);
                                                        array_push($naklady_reklamacie,$result_BU['naklady_na_reklamacie_od_zakaznikov']);
                                                        array_push($naklady_reklamacie_p,$result_BU['naklady_na_reklamacie_od_zakaznikov_poznamky']);
                                                        array_push($nvo_av,$result_BU['mnozstvo_zaznamenanych_internych_nvo_av']);
                                                        array_push($nvo_av_p,$result_BU['mnozstvo_zaznamenanych_internych_nvo_av_poznamka']);
                                                        array_push($nvo_pl,$result_BU['mnozstvo_zaznamenanych_internych_nvo_pl']);
                                                        array_push($nvo_pl_p,$result_BU['mnozstvo_zaznamenanych_internych_nvo_pl_poznamka']);
                                                        array_push($nvo_celkom,$result_BU['mnozstvo_zaznamenanych_internych_nvo_celkom']);
                                                        array_push($nvo_celkom_p,$result_BU['mnozstvo_zaznamenanych_internych_nvo_celkom_poznamka']);
                                                        array_push($naklady_chyby,$result_BU['naklady_na_interne_chyby']);
                                                        array_push($naklady_chyby_p,$result_BU['naklady_na_interne_chyby_poznamka']);
                                                        array_push($sigma,$result_BU['nv_4_sigma_6210ppm']);
                                                        array_push($sigma_p,$result_BU['nv_4_sigma_6210ppm_poznamka']);
                                                        array_push($id,$result_BU['id']);
                                                        $num_of_actual_period++;
                                                    }

?>