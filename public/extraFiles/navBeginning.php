<?php
	require "../extraFiles/connectie.php";
	$fag = false; // switch tussen regristrereb en inloggen
	$msg = ''; // fout bericht waanneer fout

	/*Uitloggen en pagina terug naar index zetten*/
	if (isset($_POST['LogOut'])) {
		session_destroy();
		$_SESSION = [];
		echo "<script type=\"text/javascript\">location.href='../index.php';</script>";
	}
	/*
	registreren van lid
		*/
	if (isset($_POST['RegistrerenLid'])) {

		$pass1 = sha1($_POST['Password1']);
		$pass2 = sha1($_POST['Password2']);
		$user = $_POST['Username'];

		$sql = "select * from gebruiker where Gebruikersnaam = ?";
		$stmt = $link->prepare($sql);
		$stmt->bindParam(1, $user);
		$stmt->execute();
		$count = $stmt->rowCount();
		if ($count == 1) {
			$fag = true;
			$msg = 'Gebruikersnaam bestaat al!';
		} else {

			if ($pass1 == $pass2) {
				try {

					$sql = "INSERT INTO `gebruiker` (`Gebruikersnaam`, `Paswoord`, `Email`) VALUES ( :e , :et , :etc )";
					$stmt = $link->prepare($sql);
					$stmt->bindParam(":e", $user, PDO::PARAM_STR);
					$stmt->bindParam(":et", $pass1, PDO::PARAM_STR);
					$stmt->bindParam(":etc", $_POST['Email'], PDO::PARAM_STR);
					$stmt->execute();

				} catch (Exception $e) {


				}
			} else {
				$fag = true;
				$msg = 'Paswoorden komen niet overeen!';
			}
		}
	}
	/*veranderen van inloggen naar regristeren*/
	if (isset($_POST['Registreren'])) {
		$fag = true;
	}

	/*Inloggen*/
	if (isset($_POST['verzendenButton'])) {

		$sql = "select * from gebruiker where Gebruikersnaam = ? and Paswoord= ? ";
		$stmt = $link->prepare($sql);
		$pass = sha1($_POST['Password']);
		$stmt->bindParam(1, $_POST['Username']);
		$stmt->bindParam(2, $pass);
		$stmt->execute();
		$count = $stmt->rowCount();
		$stmt = $stmt->fetch();
		if ($count == 1) {
			$_SESSION['YouLoggedIn'] = 1;
			$_SESSION['Username'] = $stmt['Gebruikersnaam'];
			$_SESSION['ID'] = $stmt['GIB'];
			$_SESSION['Admin'] = $stmt['Beheerder'];

		} else {
			$msg = 'Wachtwoord en/of gebruikersnaam klopt niet.';
		}
	}


	$uri = explode("/", $_SERVER["REQUEST_URI"]); // snijdt de pagina link in stukjes op de /
	$page = end($uri); //pakt de laatste dus index.php bij index

	if (isset($_SESSION['YouLoggedIn'])) {
		if ($_SESSION['YouLoggedIn'] == 1) {
			if ($_SESSION['Admin'] == 1) {
				?>
				<div class="page-wrapper default-theme sidebar-bg bg1 toggled">
				<a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
					<i class="fas fa-bars"></i>
				</a>
				<nav id="sidebar" class="sidebar-wrapper">
					<div class="sidebar-content">
						<div class="sidebar-brand">
							<a href="#">POKÉMON GO TOGETHER</a>
							<div id="close-sidebar">
								<i class="fas fa-times"></i>
							</div>
						</div>
						<div class="sidebar-header">
							<div class="user-pic">
								<img class="img-responsive img-rounded" src="../img/user.jpg" alt="User picture">
							</div>
							<div class="user-info">
                        <span class="user-name"> <strong><?php echo $_SESSION['Username']; ?></strong>
                        </span>
								<span class="user-role"><?php if ($_SESSION['Admin'] == 1) {
										echo "Beheerder";
									} else {
										echo "Gebruiker";
									} ?></span>
								<span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span>
							</div>
						</div>
						<!-- sidebar-header  -->
						<div class="sidebar-search">
							<div>
								<div class="input-group">
									<input type="text" class="form-control search-menu" placeholder="Zoeken...">
									<div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </span>
									</div>
								</div>
							</div>
						</div>
						<!-- sidebar-search  -->
						<div class="sidebar-menu">
							<ul>
								<li class="header-menu">
									<span>Navigatie</span>
								</li>
								<li class="sidebar-dropdown">
									<a href="javascript:void(0)">
										<i class="fa fa-tachometer-alt"></i>
										<span>Dashboard</span>
									</a>
									<div class="sidebar-submenu">
										<ul>
											<li>
												<a href="../index.php">Dashboard
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="sidebar-dropdown">
									<a href="javascript:void(0)">
										<i class="far fa-calendar-alt"></i>
										<span>Activiteiten</span>
									</a>
									<div class="sidebar-submenu">
										<ul>
											<li>
												<a href="../activiteiten/activiteitenToevoegen.php">Toevoegen</a>
											</li>
											<li>
												<a href="../activiteiten/activiteitenInschrijven.php">Inschrijven</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="sidebar-dropdown">
									<a href="javascript:void(0)">
										<i class="far fa-bell"></i>
										<span>Meldingen</span>
									</a>
									<div class="sidebar-submenu">
										<ul>
											<li>
												<a href="../meldingen/meldingenOverzicht.php">Overzicht</a>
											</li>
											<li>
												<a href="../meldingen/meldingenToevoegen.php">Toevoegen</a>
											</li>
											<li>
												<a href="../meldingen/meldingenWijzigen.php">Wijzigen</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="sidebar-dropdown">
									<a href="javascript:void(0)">
										<i class="fa fa-globe"></i>
										<span>Profiel</span>
									</a>
									<div class="sidebar-submenu">
										<ul>
											<li>
												<a href="../profiel/profielWijzigen.php">Gebruikers wijzigen</a>
											</li>
											<li>
												<a href="../profiel/profielInstellingen.php">Instellingen</a>
											</li>
										</ul>
									</div>
								</li>
							</ul>
						</div>
						<!-- sidebar-menu  -->
					</div>
					<!-- sidebar-content  -->
					<div class="sidebar-footer">
						<a href="../meldingen/meldingenOverzicht.php" data-toggle="tooltip" title="Overzicht meldingen" data-delay="500">
							<i class="fa fa-bell"></i>
						</a>
						<a href="../activiteiten/activiteitenInschrijven.php" data-toggle="tooltip" title="Inschrijven" data-delay="500">
							<i class="fa fa-envelope"></i>
						</a>
						<a href="../profiel/profielInstellingen.php" data-toggle="tooltip" title="Instellingen" data-delay="500">
							<i class="fa fa-cog"></i>
						</a>
						<a data-toggle="tooltip" title="Uitloggen" data-delay="500">
							<form method="post">
								<input type="submit" class="btnInvisble" name="LogOut">
							</form>
							<i class="fa fa-power-off"></i>
						</a>
					</div>
				</nav>
				<!-- sidebar-wrapper  -->
				<main class="page-content">
				<?php

			} else {

				?>
				<div class="page-wrapper default-theme sidebar-bg bg1 toggled">
				<a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
					<i class="fas fa-bars"></i>
				</a>
				<nav id="sidebar" class="sidebar-wrapper">
					<div class="sidebar-content">
						<div class="sidebar-brand">
							<a href="#">POKÉMON GO TOGETHER</a>
							<div id="close-sidebar">
								<i class="fas fa-times"></i>
							</div>
						</div>
						<div class="sidebar-header">
							<div class="user-pic">
								<img class="img-responsive img-rounded" src="../img/user.jpg" alt="User picture">
							</div>
							<div class="user-info">
                        <span class="user-name"> <strong><?php echo $_SESSION['Username']; ?></strong>
                        </span>
								<span class="user-role"><?php if ($_SESSION['Admin'] == 1) {
										echo "Beheerder";
									} else {
										echo "Gebruiker";
									} ?></span>
								<span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span>
							</div>
						</div>
						<!-- sidebar-header  -->
						<div class="sidebar-search">
							<div>
								<div class="input-group">
									<input type="text" class="form-control search-menu" placeholder="Zoeken...">
									<div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </span>
									</div>
								</div>
							</div>
						</div>
						<!-- sidebar-search  -->
						<div class="sidebar-menu">
							<ul>
								<li class="header-menu">
									<span>Navigatie</span>
								</li>
								<li class="sidebar-dropdown">
									<a href="javascript:void(0)">
										<i class="fa fa-tachometer-alt"></i>
										<span>Dashboard</span>
									</a>
									<div class="sidebar-submenu">
										<ul>
											<li>
												<a href="../index.php">Dashboard</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="sidebar-dropdown">
									<a href="javascript:void(0)">
										<i class="far fa-calendar-alt"></i>
										<span>Activiteiten</span>
									</a>
									<div class="sidebar-submenu">
										<ul>
											<li>
												<a href="../activiteiten/activiteitenInschrijven.php">Inschrijven</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="sidebar-dropdown">
									<a href="javascript:void(0)">
										<i class="far fa-bell"></i>
										<span>Meldingen</span>
									</a>
									<div class="sidebar-submenu">
										<ul>
											<li>
												<a href="../meldingen/meldingenOverzicht.php">Overzicht</a>
											</li>
											<li>
												<a href="../meldingen/meldingenToevoegen.php">Toevoegen</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="sidebar-dropdown">
									<a href="javascript:void(0)">
										<i class="fa fa-globe"></i>
										<span>Profiel</span>
									</a>
									<div class="sidebar-submenu">
										<ul>
											<li>
												<a href="../profiel/profielInstellingen.php">Instellingen</a>
											</li>
										</ul>
									</div>
								</li>
							</ul>
						</div>
						<!-- sidebar-menu  -->
					</div>
					<!-- sidebar-content  -->
					<div class="sidebar-footer">
						<a href="../meldingen/meldingenOverzicht.php" data-toggle="tooltip" title="Overzicht meldingen" data-delay="500">
							<i class="fa fa-bell"></i>
						</a>
						<a href="../activiteiten/activiteitenInschrijven.php" data-toggle="tooltip" title="Inschrijven" data-delay="500">
							<i class="fa fa-envelope"></i>
						</a>
						<a href="../profiel/profielInstellingen.php" data-toggle="tooltip" title="Instellingen" data-delay="500">
							<i class="fa fa-cog"></i>
						</a>
						<a data-toggle="tooltip" title="Uitloggen" data-delay="500">
							<form method="post">
								<input type="submit" class="btnInvisble" name="LogOut">
							</form>
							<i class="fa fa-power-off"></i>
						</a>
					</div>
				</nav>
				<!-- sidebar-wrapper  -->
				<main class="page-content">
				<?php
			}
		}

	} else if ($page == "index.php") {


		?>
		<div class="page-wrapper default-theme sidebar-bg bg1 toggled">
		<a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
			<i class="fas fa-bars"></i>
		</a>
		<nav id="sidebar" class="sidebar-wrapper">
			<div class="sidebar-content">
				<div class="sidebar-brand">
					<a href="#">POKÉMON GO TOGETHER</a>
					<div id="close-sidebar">
						<i class="fas fa-times"></i>
					</div>
				</div>
				<!-- sidebar-menu  -->
				<div class="sidebar-menu">
					<div class="container">
						<?php if ($fag) { ?>
							<form method="post" style="margin-top: 15vh">
								<h1 class="lead text-white text-center" style="margin-bottom: 30px; font-size: 30px;"><strong>REGISTREREN</strong></h1>
								<div class="form-group">
									<label style="color: white" for="Gebruiker">Gebruikersnaam</label>
									<input id="Gebruiker" name="Username" type="text" class="form-control" required="required">
								</div>
								<div class="form-group">
									<label style="color: white" for="Gebruik">Paswoord</label>
									<input id="Gebruik" name="Password1" type="password" class="form-control" required="required">
								</div>
								<div class="form-group">
									<label style="color: white" for="Gebruik1">Paswoord herhalen</label>
									<input id="Gebruik1" name="Password2" type="password" class="form-control" required="required">
								</div>
								<div class="form-group">
									<label style="color: white" for="mail">E-mailadres</label>
									<input id="mail" name="Email" type="email" class="form-control" required="required">
								</div>
								<div class="form-group">
									<button name="RegistrerenLid" type="submit" class="btn btn-outline-info btn-block">Verzenden</button>
								</div>
							</form>
							<form method="post">
								<button type="submit" class="btn btn-outline-warning btn-block">Terug</button>
							</form>
						<?php } else { ?>
							<form method="post" style="margin-top: 25vh">
								<h1 class="lead text-white text-center" style="margin-bottom: 30px; font-size: 30px;"><strong>LOGIN</strong></h1>
								<div class="form-group">
									<label style="color: white" for="Gebruiker">Gebruikersnaam</label>
									<input id="Gebruiker" name="Username" type="text" class="form-control" required="required">
								</div>
								<div class="form-group">
									<label style="color: white" for="Gebruik">Paswoord</label>
									<input id="Gebruik" name="Password" type="password" class="form-control" required="required">
								</div>
								<div class="form-group">
									<input name="verzendenButton" type="submit" class="btn btn-outline-warning btn-block" value="Verzenden">
								</div>
							</form>
							<form method="post">
								<button type="submit" name="Registreren" class="btn btn-outline-info btn-block">Registreren</button>
							</form>
						<?php }
							echo "<p class=\"text-center text-white mt-lg-3\">$msg</p>" ?>
					</div>
				</div>
			</div>
		</nav>
		<!-- sidebar-wrapper  -->
		<main class="page-content">
		<?php
	} else {
		header("location: ../root/index.php");
	}

?>