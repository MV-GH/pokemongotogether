<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once "../extraFiles/navHeading.php" ?>
</head>
<body>
	<?php require_once "../extraFiles/navBeginning.php";

		$date= "";
		if (isset($_POST['nrVERD'])) {
			$sql = "delete from activiteit where AID = ?";
			$stmt = $link->prepare($sql);
			$stmt->bindParam(1, $_POST['nrVERD']);
			$stmt->execute();
			echo "<script> history.pushState({}, \"\", \"\");</script>";
		}

		if (isset($_POST['nrUIT'])) {
			$sql = "delete from activiteitheeftgebruiker where AID = ? and GIB = ?";
			$stmt = $link->prepare($sql);
			$stmt->bindParam(1, $_POST['nrUIT']);
			$stmt->bindParam(2, $_SESSION['ID']);
			$stmt->execute();
			echo "<script> history.pushState({}, \"\", \"\");</script>";
		}
		if (isset($_POST['update'])) {
			try {

				$stmt = $link->prepare("update activiteit set Datum= ? , Titel= ? ,  omschrijving= ? , Land= ? , Stad = ? , Postnr = ? , Straatnaam = ? , Straatnummer = ? where AID =?");
				$stmt->bindParam(1, $_POST['Datum']);
				$stmt->bindParam(2, $_POST['Titel']);
				$stmt->bindParam(3, $_POST['Omschrijving']);
				$stmt->bindParam(4, $_POST['Land']);
				$stmt->bindParam(5, $_POST['Stad']);
				$stmt->bindParam(6, $_POST['Postnummer']);
				$stmt->bindParam(7, $_POST['Straatnaam']);
				$stmt->bindParam(8, $_POST['Straatnummer']);
				$stmt->bindParam(9, $_POST['update']);
				$stmt->execute();
				echo "<script> history.pushState({}, \"\", \"\");</script>";
			} catch (Exception $e) {
				print("Er is een foute waarde ingegeven");
			}
		}

		if (isset($_POST['AID'])) {
			$sql = "insert into activiteitheeftgebruiker ( AID, GIB) VALUES (?,?)";
			$stmt = $link->prepare($sql);
			$stmt->bindParam(1, $_POST["AID"]);
			$stmt->bindParam(2, $_SESSION["ID"]);
			$stmt->execute();
			echo "<script> history.pushState({}, \"\", \"\");</script>";
		}

		$sql = "SELECT * FROM activiteit ORDER BY datum DESC ";
		$stmt = $link->query($sql);
		$counter = 0;
	?>
	<link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.min.css">
	<link href="../css/A.css" rel="stylesheet">
	<div align="center">
		<h1 class="titel text-center text-white shadow">Inschrijvingen</h1>
		<?php
			foreach ($stmt as $rij) {

				$aid = $rij['AID'];
				if (isset($_POST["nrEDIT"]) and $_POST["nrEDIT"] == $aid) {
					$date = $rij['Datum'];
					?>
					<form method="post" id='formulier'>
						<div class="Abody">
							<div class="Aheader backgroundGradient">
								<div class="container col-5 pt-2">
									<input class="form-control bg-transparent text-white text-center" width="50px" type='text' name='Titel' value="<?php echo $rij['Titel']; ?>">
								</div>
							</div>
							<div class="container-fluid Amiddle">
								<label for="txtarea" class="mt-lg-3">Omschrijving</label>
								<textarea id="txtarea" class="form-control mb-lg-3" name="Omschrijving" spellcheck="false"><?php echo $rij['Omschrijving']; ?></textarea>
								<div class="form-row">
									<div class="form-group col-md-5">
										<label for="text">Land</label>
										<input id="text" name="Land" type="text" class="form-control" required="required" value="<?php echo $rij['Land']; ?>">
									</div>
									<div class="form-group col-md-3">
										<label for="text2">Postnummer</label>
										<input id="text2" name="Postnummer" type="text" class="form-control" required="required" value="<?php echo $rij['Postnr']; ?>">
									</div>
									<div class="form-group col-md-4">
										<label for="text1">Stad</label>
										<input id="text1" name="Stad" type="text" class="form-control" required="required" value="<?php echo $rij['Stad']; ?>">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="text3">Straatnaam</label>
										<input id="text3" name="Straatnaam" type="text" class="form-control" required="required" value="<?php echo $rij['Straatnaam']; ?>">
									</div>
									<div class="form-group col-md-6">
										<label for="text4">Straatnummer</label>
										<input id="text4" name="Straatnummer" type="text" class="form-control" required="required" value="<?php echo $rij['Straatnummer']; ?>">
									</div>
								</div>
							</div>
							<div class="container-fluid pb-2 pt-2 backgroundGradient">
								<div class="row align-items-center">
									<div class="col-4"></div>
									<div class="col-4">
										<input type='hidden' name='update' value='<?php echo $aid; ?>'>
										<input class='btn btn-outline-light' type='submit' value='Aanpassen'>
									</div>
									<div class="col-4 font-weight-bold">
										<input id="fdate" name="Datum" type="text" class="form-control" required="required">

									</div>
								</div>
							</div>
						</div>
					</form>
					<?php
				} else {

					$stmt2 = $link->prepare("select * from activiteitheeftgebruiker where GIB = ? and AID = ?");
					$stmt2->bindParam(1, $_SESSION["ID"]);
					$stmt2->bindParam(2, $aid);
					$stmt2->execute();
					$count = $stmt2->rowCount();

					$stmt3 = $link->prepare("select * from activiteitheeftgebruiker inner join gebruiker on gebruiker.GIB = activiteitheeftgebruiker.GIB where AID = ?");
					$stmt3->bindParam(1, $aid);
					$stmt3->execute();
					$count3 = $stmt3->rowCount();

					?>
					<div class="flip-card">
						<div class="flip-card-inner" id="A<?php echo $counter; ?>">
							<div class="flip-card-front">
								<div class="Abody" id="<?php echo $counter; ?>">
									<div class="Aheader backgroundGradient">
										<div class="dropup">
											<button class="Atandwiel btnGone shadow-none" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&#9881;</button>
											<div class="dropdown-menu">
												<?php if ($_SESSION['Admin'] == 1) { ?>
													<form method='post'><input type='hidden' name='nrVERD' value='<?php echo $aid; ?>'><input class="dropdown-item" type='submit' value='Verwijderen'>
													</form>
													<form method='post' action="#formulier"><input type='hidden' name='nrEDIT' value='<?php echo $aid; ?>'><input class="dropdown-item" type='submit'
													                                                                                                              value='Aanpassen'>
													</form>
												<?php }
													echo "<button class='dropdown-item' onclick='magic(\"" . "$counter" . "\");' > Lijst deelname</button>";
												?>
											</div>
										</div>
										<div class="Atitel text-uppercase "><?php echo $rij['Titel']; ?></div>
									</div>
									<div class="container-fluid Amiddle" id="B<?php echo $counter; ?>">
										<div class="text-left pt-3"><?php echo nl2br($rij['Omschrijving']); ?></div>
										<br>
										<div class="text-left"><i
													class="fas fa-map-marker-alt"></i> <?php echo $rij['Straatnaam'] . " " . $rij['Straatnummer'] . ", " . $rij['Postnr'] . " " . $rij['Stad'] . ", " . $rij['Land']; ?>
										</div>
										<br>
									</div>
									<div class="container-fluid pb-2 pt-2 backgroundGradient">
										<div class="row align-items-center">
											<div class="col-4"><i class="fas fa-users"></i> <?php echo $count3; ?> Deelnemer(s)</div>
											<div class="col-4">
												<?php
													if ($count >= 1) {
														echo "<p class='text-left text-white d-inline-block mb-0'> U bent ingeschreven.</p><form action='#$counter' class='d-inline-block' method=\"post\"><input type='hidden' value=\"$aid\" name='nrUIT'><input type=\"submit\" class=\"btnGone d-inline-block text-white line\" value=\"Wilt u zich uitschrijven?\">
									</form>";
													} else {
														?>
														<form method="post" action='#<?php echo $counter ?>'><input type='hidden' value="<?php echo $aid; ?>" name='AID'><input type="submit"
														                                                                                                                        class="btn btn-outline-light"
														                                                                                                                        value="Inschrijven">
														</form>
													<?php } ?>
											</div>
											<div class="col-4 font-weight-bold"><i class="far fa-calendar-alt"></i>
												&nbsp;<?php echo str_replace("-", "/", date("d-m-Y", strtotime(substr($rij['Datum'], 0, 10)))); ?>
												&nbsp; <i class="far fa-clock ico-size"></i> <?php echo str_replace(":", "u", substr($rij['Datum'], 10, 6)); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="flip-card-back " id="E<?php echo $counter; ?>">
								<div class="Abody">
									<div class="Aheader backgroundGradient">
										<div class="Atitel text-uppercase ">Lijst deelnemer(s)</div>
									</div>
									<div class="container-fluid Amiddle" id="D<?php echo $counter; ?>">
										<ul class="list-group">
											<?php
												foreach ($stmt3 as $rij2) {
													echo "<li class=\"list-group-item\">" . $rij2["Gebruikersnaam"] . "</li>";
												}
											?>
										</ul>
									</div>
									<div class="container-fluid pb-2 pt-2 backgroundGradient">
										<div class="row align-items-center">
											<div class="col-4"></div>
											<div class="col-4">
												<?php echo "<button class='btn btn-outline-light' onclick='magic2(\"" . "$counter" . "\");' >Terug</button>"; ?>
											</div>
											<div class="col-4 font-weight-bold"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $counter++;
				}
			} ?>
		<div class="container shadow-lg pb-lg-3">
			<p class="subheading"><b>Er bestaat ook een tabel versie van deze pagina</b></p>
			<div class="list-group list-group-horizontal-sm">
				<a href="../activiteiten/activiteitenOverzicht.php" class="list-group-item list-group-item-action flex-fill text-uppercase"><b>Overzicht</b></a>
				<a href="activiteitenInschrijvenOud.php" class="list-group-item list-group-item-action flex-fill text-uppercase"><b>Inschrijven</b></a>
				<?php if ($_SESSION['Admin'] == 1) { ?>
					<a href="../activiteiten/activiteitenWijzigen.php" class="list-group-item list-group-item-action flex-fill text-uppercase"><b>Wijzigen</b></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php require_once "../extraFiles/navEnding.php" ?>
	<script src="../js/jquery.datetimepicker.full.min.js"></script>
	<script type="text/javascript">
        function magic(body5) {
            document.getElementById("D" + body5).classList.remove("FadingAway");
            document.getElementById("B" + body5).classList.add("FadingAway");
            document.getElementById("A" + body5).classList.add("turnover");
            document.getElementById(body5).classList.add("opacity");

            setTimeout(function () {
                document.getElementById(body5).classList.add("d-none");
                document.getElementById("E" + body5).classList.add("d-block");
            }, 3200);
        }

        function magic2(body5) {
            document.getElementById("B" + body5).classList.remove("FadingAway");
            document.getElementById("A" + body5).classList.remove("turnover");
            document.getElementById(body5).classList.remove("opacity");
            document.getElementById("D" + body5).classList.add("FadingAway");

            setTimeout(function () {
                document.getElementById(body5).classList.remove("d-none");
                document.getElementById("E" + body5).classList.remove("d-block");
            }, 3200);
        }

        function expandTextarea(id) {
            document.getElementById(id).addEventListener('keyup', function () {
                this.style.overflow = 'hidden';
                this.style.height = 0;
                this.style.height = this.scrollHeight + 'px';
            }, false);
            document.addEventListener('readystatechange', () => {
                if (document.readyState === 'complete') {
                    document.getElementById(id).style.overflow = 'hidden';
                    document.getElementById(id).style.height = 0;
                    document.getElementById(id).style.height = document.getElementById(id).scrollHeight + 'px';
                }
            });
        }

        expandTextarea('txtarea');

        jQuery('#fdate').datetimepicker({
            value: "<?php echo $date;?>",
            format: 'Y/m/d H:i'
        });
        jQuery.datetimepicker.setLocale('nl');

	</script>
</body>
</html>
