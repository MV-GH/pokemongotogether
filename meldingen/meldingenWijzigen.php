<!DOCTYPE html>
<html lang="en">
<head>

	<?php require_once "../extraFiles/navHeading.php" ?>
	<?php
		if($_SESSION['Admin']!=1){
			header("location: ../root/index.php");
		}
	?>
</head>
<body>
	<?php require_once "../extraFiles/navBeginning.php" ?>
	<div class="container-fluid">
		<h1 class="titel text-center">Pas de meldingen aan</h1>
		<?php
			require_once("../extraFiles/connectie.php");

			if (isset($_POST['nrVERD'])) {
				$sql = "delete from melding where MID = ?";
				$stmt = $link->prepare($sql);
				$stmt->bindParam(1, $_POST['nrVERD']);
				$stmt->execute();
			}

			if (isset($_POST['update'])) {
				try {
					if (!empty($_POST["Land"])) {
						$stmt = $link->prepare("update melding set Land=? where MID =?");
						$stmt->bindParam(1, $_POST['Land']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Stad"])) {
						$stmt = $link->prepare("update melding set stad=? where MID =?");
						$stmt->bindParam(1, $_POST['Stad']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Postnr"])) {
						$stmt = $link->prepare("update melding set postnr=? where MID =?");
						$stmt->bindParam(1, $_POST['Postnr']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Straatnaam"])) {
						$stmt = $link->prepare("update melding set Straatnaam=? where MID =?");
						$stmt->bindParam(1, $_POST['Straatnaam']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Straatnummer"])) {
						$stmt = $link->prepare("update melding set straatnummer=? where MID =?");
						$stmt->bindParam(1, $_POST['Straatnummer']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Pokemon"])) {
						$stmt = $link->prepare("update melding set Pokemon=? where MID =?");
						$stmt->bindParam(1, $_POST['Pokemon']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					echo "<script>
				                history.pushState({}, \"\", \"\");
				                window.onload = function () {
				                    myPopup();
				                };
							</script>";
				} catch (Exception $e) {
					print("Er is een foute waarde ingegeven");
				}
			}
			$sql = "SELECT * FROM  `melding` inner join gebruiker on melding.gib = gebruiker.gib ORDER BY datum DESC ";
			$stmt = $link->query($sql);
			if (!isset($_POST['nr'])) {
				echo "<div class='table-responsive'>
                            <table class='table table-striped table-bordered'> <thead class='thead-dark'>
                                <tr>
                                    <th scope='col'>Aanpassen</th>
                                    <th scope='col'>Gebruikersnaam</th>
                                    <th scope='col'>Datum</th>
                                    <th scope='col'>Pokémon</th>
                                    <th scope='col'>Land</th>
                                    <th scope='col'>Stad</th>
                                    <th scope='col'>Postnr</th>
                                    <th scope='col'>Straatnaam</th>
                                    <th scope='col'>Straatnummer</th>
                                    <th scope='col'>Verwijderen</th>
                                </tr>
                            </thead><tbody>";
			} else {
				echo "<div class='table-responsive'>
                            <table class='table table-striped table-bordered'> <thead class='thead-dark'>
                                <tr>
                                    <th scope='col'>Aanpassen</th>
                                    <th scope='col'>Gebruikersnaam</th>
                                    <th scope='col'>Datum</th>
                                    <th scope='col'>Pokémon</th>
                                    <th scope='col'>Land</th>
                                    <th scope='col'>Stad</th>
                                    <th scope='col'>Postnr</th>
                                    <th scope='col'>Straatnaam</th>
                                    <th scope='col'>Straatnummer</th>
                                </tr>
                            </thead><tbody>";
			}
			foreach ($stmt as $rij) {

				$nr = $rij['MID'];
				if (isset($_POST['nr'])) {
					if ($_POST['nr'] == $rij['MID']) {
						echo "<tr><form id='formulier' method='post'><td><input type='hidden' name='update' value='$nr'><input type='submit' value='verzenden'></td>";
						echo "<td>" . $rij['Gebruikersnaam'] . "</td>";
						echo "<td>" . substr($rij['Datum'], 0, 16) . "</td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Pokemon' placeholder=\"" . $rij['Pokemon'] . "\"></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Land' placeholder=\"" . $rij['Land'] . "\"></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Stad' placeholder=\"" . $rij['Stad'] . "\"></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Postnr' placeholder=\"" . $rij['Postnr'] . "\"></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Straatnaam' placeholder=\"" . $rij['Straatnaam'] . "\"></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='text' name='Straatnummer' placeholder=\"" . $rij['Straatnummer'] . "\"></form></td></tr>";

					} else {
						echo "<tr><td><form method='post'><input type='hidden' name='nr' value='$nr'><input type='submit' value='aanpassen'></form></td>";
						echo "<td>" . $rij['Gebruikersnaam'] . "</td>";
						echo "<td>" . substr($rij['Datum'], 0, 16) . "</td>";
						echo "<td>" . $rij['Pokemon'] . "</td>";
						echo "<td>" . $rij['Land'] . "</td>";
						echo "<td>" . $rij['Stad'] . "</td>";
						echo "<td>" . $rij['Postnr'] . "</td>";
						echo "<td>" . $rij['Straatnaam'] . "</td>";
						echo "<td>" . $rij['Straatnummer'] . "</td></tr>";
					}
				} else {
					echo "<tr><td><form method='post'><input type='hidden' name='nr' value='$nr'><input type='submit' value='aanpassen'></form></td>";
					echo "<td>" . $rij['Gebruikersnaam'] . "</td>";
					echo "<td>" . substr($rij['Datum'], 0, 16) . "</td>";
					echo "<td>" . $rij['Pokemon'] . "</td>";
					echo "<td>" . $rij['Land'] . "</td>";
					echo "<td>" . $rij['Stad'] . "</td>";
					echo "<td>" . $rij['Postnr'] . "</td>";
					echo "<td>" . $rij['Straatnaam'] . "</td>";
					echo "<td>" . $rij['Straatnummer'] . "</td>";
					echo "<td><form method='post'><input type='hidden' name='nrVERD' value='$nr'><input type='submit' value='verwijderen'></form></td></tr>";
				}

			}
			echo "</tbody></table></div>";
		?>

	<?php require_once "../extraFiles/navEnding.php" ?>
</body>
</html>
</html>