<?php
	class User
	{
		public function isAuthenticated()
		{
			if(is_numeric($_SESSION['user_id'])):
				return true;
			else:
				return false;
			endif;
		}
		public function Logout()
		{
			$_SESSION['user_id']=NULL;
			session_destroy();
			session_start();
		

			/*echo '<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="smallModalLabel">Notifikation</h4>
												</div>
												<div class="modal-body">
													<p>Sie wurden erfolgreich abgemeldet.</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
												</div>
											</div>
										</div>
									</div>';*/
			/*echo "<script>$(function () {
					$('#smallModal').modal('show');
					});</script>";*/
			
		}
		public function isAdmin()
		{
			if($this->isAuthenticated() and $_SESSION['admin']==1){
				return true;
			}
		}

		public function isUser()
		{
			if($this->isAuthenticated() and $_SESSION['admin']==0){
				return true;
			}
		}

		public function returnUserLogin($user_id) {
			if($user_id == 0)
				return "Anonýmný používateľ";
			$queryString = "select username from user where 1 and id = '" . $user_id . "' limit 1;";		
			$ResultQ = mysqli_query($connect,$queryString);
			if($ResultQ) {
				if(mysqli_num_rows($ResultQ) == 1) {
					$RowQ = mysqli_fetch_assoc($ResultQ);
					return $RowQ['username'];
				}
				else
					return false;
			}
		}
		
				public function returnUserFullname($user_id,$connect) {
			if($user_id == 0)
				return "Anonýmný používateľ";
			$queryString = "select fullname from user where 1 and id = '" . $user_id . "' limit 1;";		
			$ResultQ = mysqli_query($connect,$queryString);
			if($ResultQ) {
				if(mysqli_num_rows($ResultQ) == 1) {
					$RowQ = mysqli_fetch_assoc($ResultQ);
					return $RowQ['fullname'];
				}
				else
					return false;
			}
		}
		
		public function Authenticate($username=NULL, $passphrase=NULL,$connect)
		{
			$queryString = "select osobne_cislo from employees where 1 AND osobne_cislo = '" . mysqli_real_escape_string($connect,$username) . "' and aktivny = '1';";		
			$ResultQ = mysqli_query($connect,$queryString);
			if($ResultQ){//000
                
				if(mysqli_num_rows($ResultQ)==1){//001
					$RowQ = mysqli_fetch_assoc($ResultQ);
					
					$queryString = "select * from user_groups where 1 and osobne_cislo = '" . $RowQ['osobne_cislo'] . "' and id_skupiny = '9' limit 1;";
                    $ResultR = mysqli_query($connect,$queryString);
                    if($ResultR){//002
						if(mysqli_num_rows($ResultR)==1){
					//	overime si heslo
					$queryString = "select * from employees where 1 and osobne_cislo = '" . $RowQ['osobne_cislo'] . "' and heslo = '" . mysqli_real_escape_string($connect,$passphrase) . "' limit 1;";
					
					$ResultR = mysqli_query($connect,$queryString);
					if($ResultR){//002
						if(mysqli_num_rows($ResultR)==1){//003
							$RowR = mysqli_fetch_assoc($ResultR);
							
							
							
							//	nastavime session
							$_SESSION['user_id'] = $RowR['osobne_cislo'];
							$_SESSION['fullname'] = $RowR['meno']." ".$RowR['priezvisko'];
							$_SESSION['admin'] = $RowR['admin'];
							$_SESSION['default_language'] = $RowR['language'];
							$_SESSION['username'] = $RowR['osobne_cislo'];
                            $_SESSION['rights']=rights($_SESSION['username']);
							
							if($_SESSION['admin'] == 1 ) { //004
								/*echo '<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="smallModalLabel">Notifikation</h4>
												</div>
												<div class="modal-body">
													<p>Sie wurden als Administrator angemeldet. </p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
												</div>
											</div>
										</div>
									</div>';
								echo "<script>$(function () {
										$('#smallModal').modal('show');
										});</script>";*/	
							}//004
							elseif($_SESSION['admin'] == 0 ) { //004b
								/*echo '<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="smallModalLabel">Notifikation</h4>
												</div>
												<div class="modal-body">
													<p>Sie haben sich erfolgreich angemeldet.</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
												</div>
											</div>
										</div>
									</div>';
							echo "<script>$(function () {
									$('#smallModal').modal('show');
									});</script>";*/
							}//004b
							else { 
								/*echo '<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="smallModalLabel">Notifikation</h4>
												</div>
												<div class="modal-body">
													<p>Fehler beim Anmelde!</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
												</div>
											</div>
										</div>
														</div>';
								echo "<script>$(function () {
										$('#smallModal').modal('show');
										});</script>";*/
							}//004c
						}//003
						else{//003b
						/*echo '<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="smallModalLabel">Notifikation</h4>
												</div>
												<div class="modal-body">
													<p>Falsches Passwort eingegeben.</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
												</div>
											</div>
										</div>
									</div>';
			echo "<script>$(function () {
					$('#smallModal').modal('show');
					});</script>";*/
						}//003b
					}//002
                        }
                    }
					else{//002b
						print(mysqli_error());
					}//002b
				}//001
				else{//001b
					
			echo '<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="smallModalLabel">Notifikation</h4>
												</div>
												<div class="modal-body">
													<p>Der Benutzer befindet sich nicht in der Benutzerdatenbank oder es wird ihm der Zugriff verweigert.</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
												</div>
											</div>
										</div>
									</div>';
			echo "<script>$(function () {
					$('#smallModal').modal('show');
					});</script>";
				}//001b
			}//000
			else{
				print(mysqli_error());
			}
			
			
			/*
			$queryString = "select id from user where 1 email = '" . mysqli_real_escape_string($connect,$username) . "' and active = '1';";		
			$ResultQ = mysqli_query($connect,$queryString);
			if($ResultQ):
				if(mysqli_num_rows($ResultQ)==1):
					$RowQ = mysqli_fetch_assoc($ResultQ);
					
					//	overime si heslo
					echo $queryString = "select * from user where 1 and id = '" . $RowQ['id'] . "' and pwd = '" . mysqli_real_escape_string($connect,$passphrase) . "' limit 1;";
					$ResultR = mysqli_query($connect,$queryString);
					if($ResultR):
						if(mysqli_num_rows($ResultR)==1):
							$RowR = mysqli_fetch_assoc($ResultR);
							
							
							
							//	nastavime session
							$_SESSION['user_id'] = $RowR['id'];
							$_SESSION['fullname'] = $RowR['fullname'];
							$_SESSION['admin'] = $RowR['admin'];
							
							$_SESSION['email'] = $RowR['email'];
							
							if($_SESSION['admin'] == 1 ) { 
									header("Location:" . ROOTDIR . "/setup/index.php?module=menu"); 
									exit; 
							}
							elseif($_SESSION['admin'] == 0 ) { 
								header("Location:" . ROOTDIR . "/"); 
								$_SESSION['_message'] = "Boli ste úspešne prihlásený."; 
								exit; 
							}
							else { $_SESSION['_message'] = "Chyba v prihlasovaní.";  }
						
						else:
							$_SESSION['_message'] = "Bolo zadané nesprávne heslo.";
						endif;
					else:
						print(mysql_error());
					endif;
				else:
					$_SESSION['_message'] = "Zadaný užívateľ sa nenachádza v databáze užívateľov alebo ma zakázaný prístup.";					
				endif;			
			else:
				print(mysqli_error());
			endif;
			*/
		}
	}
?>
