<!DOCTYPE html>
<html lang="en">
<head>
	<?php require "../extraFiles/navHeading.php"; ?>
	<?php
		if ($_SESSION['Admin'] != 1) {
			header("location: ../root/index.php");
		}
	?>
</head>
<body>
	<?php require "../extraFiles/navBeginning.php"; ?>
	<div class="container-fluid">
		<h1 class="titel text-center">Pas de activiteiten aan</h1>
		<div class="container shadow-sm pb-lg-3 pt-lg-3 mb-lg-3">
			<div class="list-group list-group-horizontal-sm">
				<a href="../activiteiten/activiteitenOverzicht.php" class="list-group-item list-group-item-action flex-fill text-uppercase"><b>Overzicht</b></a>
				<a href="activiteitenInschrijvenOud.php" class="list-group-item list-group-item-action flex-fill text-uppercase "><b>Inschrijven</b></a>
				<?php if ($_SESSION['Admin'] == 1) { ?>
					<a href="../activiteiten/activiteitenWijzigen.php" class="list-group-item list-group-item-action flex-fill text-uppercase active"><b>Wijzigen</b></a>
				<?php } ?>
			</div>
		</div>
		<?php
			require("../extraFiles/connectie.php");

			function br2nl($input)
			{
				return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n", "", str_replace("\r", "", htmlspecialchars_decode($input))));
			}

			if (isset($_POST['nrVERD'])) {
				$sql = "delete from activiteit where AID = ?";
				$stmt = $link->prepare($sql);
				$stmt->bindParam(1, $_POST['nrVERD']);
				$stmt->execute();
			}

			if (isset($_POST['update'])) {
				try {
					if (!empty($_POST["Land"])) {
						$stmt = $link->prepare("update activiteit set Land=? where AID =?");
						$stmt->bindParam(1, $_POST['Land']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Stad"])) {
						$stmt = $link->prepare("update activiteit set stad=? where AID =?");
						$stmt->bindParam(1, $_POST['Stad']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Postnr"])) {
						$stmt = $link->prepare("update activiteit set postnr=? where AID =?");
						$stmt->bindParam(1, $_POST['Postnr']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Straatnaam"])) {
						$stmt = $link->prepare("update activiteit set straatnaam=? where AID =?");
						$stmt->bindParam(1, $_POST['Straatnaam']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Straatnummer"])) {
						$stmt = $link->prepare("update activiteit set straatnummer=? where AID =?");
						$stmt->bindParam(1, $_POST['Straatnummer']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Omschrijving"])) {
						$stmt = $link->prepare("update activiteit set omschrijving=? where AID =?");
						$stmt->bindParam(1, $_POST['Omschrijving']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Titel"])) {
						$stmt = $link->prepare("update activiteit set Titel=? where AID =?");
						$stmt->bindParam(1, $_POST['Titel']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}

				} catch (Exception $e) {
					print("Er is een foute waarde ingegeven");
				}
			}
			$sql = "SELECT * FROM activiteit ORDER BY datum DESC ";
			$stmt = $link->query($sql);
			if (!isset($_POST['nr'])) {
				echo "<div class='table-responsive'>
                            <table class='table table-striped table-bordered'> <thead class='thead-dark'>
                                <tr>                                    
                                    <th scope='col'>Datum</th>
                                    <th scope='col'>Titel</th>
                                    <th scope='col'>Omschrijving</th>
                                    <th scope='col'>Land</th>
                                    <th scope='col'>Stad</th>
                                    <th scope='col'>Postnr</th>
                                    <th scope='col'>Straatnaam</th>
                                    <th scope='col'>Straatnummer</th>
                                    <th scope='col'>Aanpassen</th>
                                    <th scope='col'>Verwijderen</th>
                                    </tr>
                            </thead><tbody>";
			} else {
				echo "<div class='table-responsive'>
                            <table class='table table-striped table-bordered'> <thead class='thead-dark'>
                                <tr>
                                    <th scope='col'>Datum</th>
                                    <th scope='col'>Titel</th>
                                    <th scope='col'>Omschrijving</th>
                                    <th scope='col'>Land</th>
                                    <th scope='col'>Stad</th>
                                    <th scope='col'>Postnr</th>
                                    <th scope='col'>Straatnaam</th>
                                    <th scope='col'>Straatnummer</th>
                                    <th scope='col'>Aanpassen</th>
                                    </tr>
                            </thead><tbody>";
			}
			foreach ($stmt as $rij) {

				$nr = $rij['AID'];
				if (isset($_POST['nr'])) {
					if ($_POST['nr'] == $rij['AID']) {
						echo "<form id='formulier' method='post'><tr><td>" . substr($rij['Datum'], 0, 16) . "</td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Titel' placeholder=\"" . $rij['Titel'] . "\"></td>";
						echo "<td><textarea class=\"form-control form-control-sm\" form='formulier' name='Omschrijving' cols=\"30\" rows=\"5\" placeholder=\"" . br2nl($rij['Omschrijving']) . "\"></textarea></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Land' placeholder=\"" . $rij['Land'] . "\"></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Stad' placeholder=\"" . $rij['Stad'] . "\"></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Postnr' placeholder=\"" . $rij['Postnr'] . "\"></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Straatnaam' placeholder=\"" . $rij['Straatnaam'] . "\"></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Straatnummer' placeholder=\"" . $rij['Straatnummer'] . "\"></td>";
						echo "<td><input type='hidden' name='update' value='$nr'><input type='submit' value='verzenden'></form></td></tr>";

					} else {

						echo "<tr><td>" . substr($rij['Datum'], 0, 16) . "</td>";
						echo "<td>" . $rij['Titel'] . "</td>";
						echo "<td>" . nl2br($rij['Omschrijving']) . "</td>";
						echo "<td>" . $rij['Land'] . "</td>";
						echo "<td>" . $rij['Stad'] . "</td>";
						echo "<td>" . $rij['Postnr'] . "</td>";
						echo "<td>" . $rij['Straatnaam'] . "</td>";
						echo "<td>" . $rij['Straatnummer'] . "</td>";
						echo "<td><form method='post'><input type='hidden' name='nr' value='$nr'><input type='submit' value='aanpassen'></form></td></tr>";
					}
				} else {
					echo "<tr><td>" . substr($rij['Datum'], 0, 16) . "</td>";
					echo "<td>" . $rij['Titel'] . "</td>";
					echo "<td>" . nl2br($rij['Omschrijving']) . "</td>";
					echo "<td>" . $rij['Land'] . "</td>";
					echo "<td>" . $rij['Stad'] . "</td>";
					echo "<td>" . $rij['Postnr'] . "</td>";
					echo "<td>" . $rij['Straatnaam'] . "</td>";
					echo "<td>" . $rij['Straatnummer'] . "</td>";
					echo "<td><form method='post'><input type='hidden' name='nr' value='$nr'><input type='submit' value='aanpassen'></form></td>";
					echo "<td><form method='post'><input type='hidden' name='nrVERD' value='$nr'><input type='submit' value='verwijderen'></form></td></tr>";
				}

			}
			echo "</tbody></table></div>";

		?>
	</div>
	<?php require_once("../extraFiles/navEnding.php"); ?>
</body>
</html>