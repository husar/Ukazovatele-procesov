<div class="page-content">
<?php
$datum=date('Y-m-d');
if(isset($_GET['typ_zariadenia'])){
	$query_part=" WHERE id=".$_GET['typ_zariadenia'];
}
else{
	$query_part="";
}
							$query_kategorie="SELECT * FROM kategorie".$query_part;
							$apply_kategorie=mysqli_query($connect,$query_kategorie);
							while($result_kategorie=mysqli_fetch_array($apply_kategorie)){
							?>
 <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i> Typ zariadenia - <?php echo $result_kategorie['kategoria']; ?></div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="Zbaliť/Rozbaliť" title=""> </a>
                                            
                                        </div>
                                    </div>
                                    <div class="portlet-body">
									<?php
									$poc=0;
										$query_zariadenia="SELECT * FROM zariadenia WHERE kategoria=".$result_kategorie['id'];
										$apply_zariadenia=mysqli_query($connect,$query_zariadenia);
										while($result_zariadenia=mysqli_fetch_array($apply_zariadenia)){
											$poc=$poc+1;
									?>
									<h2> <?php echo $result_zariadenia['nazov']." - ".$result_zariadenia['typove_oznacenie']; ?></h2>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                               
                                                <tbody>
												<tr>
                                                        <td><strong>Názov zariadenia</strong></td>
                                                        <td> <?php echo $result_zariadenia['nazov']; ?></td>
                                                       
                                                    </tr>
													<tr>
                                                        <td><strong>Typové označenie</strong></td>
                                                        <td> <?php echo $result_zariadenia['typove_oznacenie']; ?></td>
                                                       
                                                    </tr>
													<tr>
                                                        <td><strong>Názov organizácie</strong></td>
                                                        <td> <?php echo $result_zariadenia['nazov_organizacie']; ?></td>
                                                       
                                                    </tr>
													<tr>
                                                        <td><strong>IČO</strong></td>
                                                        <td> <?php echo $result_zariadenia['ico']; ?></td>
                                                       
                                                    </tr>
													<tr>
                                                        <td><strong>Výrobné čislo</strong></td>
                                                        <td> <?php echo $result_zariadenia['vyrobne_cislo']; ?></td>
                                                       
                                                    </tr>
													<tr>
                                                        <td><strong>Výrobca</strong></td>
                                                        <td> <?php echo $result_zariadenia['vyrobca']; ?></td>
														
                                                       
                                                    </tr>
													<tr>
                                                        <td><strong>Rok výroby</strong></td>
                                                        <td> <?php echo $result_zariadenia['rok_vyroby']; ?></td>
                                                       
                                                    </tr>
													<tr>
                                                        <td><strong>Miesto</strong></td>
                                                        <td> <?php echo $result_zariadenia['miesto']; ?></td>
                                                       
                                                    </tr>
												<?php
													$query_vlastnosti="SELECT * FROM vlastnosti WHERE zariadenie=".$result_zariadenia['id'];
													$apply_vlastnosti=mysqli_query($connect,$query_vlastnosti);
													while($result_vlastnosti=mysqli_fetch_array($apply_vlastnosti)){
												?>
                                                    <tr>
                                                        <td> <strong><?php echo $result_vlastnosti['nazov_vlastnosti'];?> </strong></td>
                                                        <td> <?php echo $result_vlastnosti['hodnota'];?> </td>
                                                        
                                                    </tr>
													<?php } ?>
                                                </tbody>
                                            </table>
											
															
                                        </div>
										<?php
										$query_popis="SELECT* FROM zaznamy WHERE zariadenie=".$result_zariadenia['id']." GROUP BY popis";
										$apply_popis=mysqli_query($connect,$query_popis);
										while($result_popis=mysqli_fetch_array($apply_popis)){
											
											$query_zaznamy="SELECT DATE_FORMAT(`datum`,'%d.%m.%Y') AS `datum_f`,datum,zariadenie,typ,popis FROM zaznamy WHERE zariadenie=".$result_zariadenia['id']." AND typ=1 AND popis='".$result_popis['popis']."' ORDER BY id DESC LIMIT 1 ";
											$apply_zaznamy=mysqli_query($connect,$query_zaznamy);
											while($result_zaznamy=mysqli_fetch_array($apply_zaznamy)){
										?>
										<a href="#" class="icon-btn">
                                                                <i class="fa fa-calendar"></i> <?php echo $result_zaznamy['popis']; ?>
                                                                <div style="padding:5px"> Posledná <?php echo $result_zaznamy['datum_f']; ?></div>
                                        </a>
										<?php } ?>
										
										<?php
											$query_zaznamy="SELECT DATE_FORMAT(`datum`,'%d.%m.%Y') AS `datum_f`,datum,zariadenie,typ,popis FROM zaznamy WHERE zariadenie=".$result_zariadenia['id']." AND typ=2 AND popis='".$result_popis['popis']."' ORDER BY id DESC LIMIT 1 ";
											$apply_zaznamy=mysqli_query($connect,$query_zaznamy);
											while($result_zaznamy=mysqli_fetch_array($apply_zaznamy)){
										?>
										<a href="#" class="icon-btn">
                                                                <i class="fa fa-calendar"></i> <?php echo $result_zaznamy['popis']; ?>
                                                                <div style="padding:5px"> Nasledujúca <?php echo $result_zaznamy['datum_f']; ?></div>
																<?php
																if($datum>=$result_zaznamy['datum']){
																?>
																	<span class="badge badge-danger"> ! </span>	
																<?php } ?>
                                        </a>
										<?php 
											} 
										}
										?>
														
															<a class="btn btn-primary pull-right">Zobraziť všetky termíny</a>
															<hr>
										<?php } ?>
										<?php
										if($poc==0){echo "V evidencii sa nenachádzaju žiadne zariadenia vybranej kategórie.";}
										?>
										
                                    </div>
                                </div>
<?php } ?>								
 </div>