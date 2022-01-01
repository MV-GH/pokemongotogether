<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once("../extraFiles/navHeading.php"); ?>
</head>
<body>
	<?php require_once("../extraFiles/navBeginning.php");
		if (isset($_POST['nr'])) {
			$sql = "insert into activiteitheeftgebruiker ( AID, GIB) VALUES (?,?)";
			$stmt = $link->prepare($sql);
			$stmt->bindParam(1, $_POST["AID"]);
			$stmt->bindParam(2, $_SESSION["ID"]);
			$stmt->execute();
			echo "<script> history.pushState({}, \"\", \"\");</script>";
		}
	?>
	<div class="container-fluid">
		<h1 class="titel text-center">Inschrijving activiteiten</h1>
		<div class="container shadow-sm pb-lg-3 pt-lg-3 mb-lg-3">
			<div class="list-group list-group-horizontal-sm">
				<a href="../activiteiten/activiteitenOverzicht.php" class="list-group-item list-group-item-action flex-fill text-uppercase"><b>Overzicht</b></a>
				<a href="activiteitenInschrijvenOud.php" class="list-group-item list-group-item-action flex-fill text-uppercase active"><b>Inschrijven</b></a>
				<?php if ($_SESSION['Admin'] == 1) { ?>
					<a href="../activiteiten/activiteitenWijzigen.php" class="list-group-item list-group-item-action flex-fill text-uppercase"><b>Wijzigen</b></a>
				<?php } ?>
			</div>
		</div>
		<?php
			require_once("../extraFiles/connectie.php");
			$sql = "SELECT * FROM activiteit ORDER BY datum DESC ";
			$stmt = $link->query($sql);
			echo "<div class='table-responsive'>
                        <table class='table table-striped table-bordered'> <thead class='thead-dark'>
                                <tr>
                                    <th scope='col'>Datum & Tijd</th>
                                    <th scope='col'>Titel</th>
                                    <th scope='col'>Omschrijving</th>
                                    <th scope='col'>Land</th>
                                    <th scope='col'>Stad</th>
                                    <th scope='col'>Postnr</th>
                                    <th scope='col'>Straatnaam</th>
                                    <th scope='col'>Straatnummer</th>
                                    <th scope='col'>Inschrijven</th>
                                </tr>
                            </thead><tbody>";
			foreach ($stmt as $rij) {
				$aid = $rij['AID'];
				echo "<td>" . substr($rij['Datum'], 0, 16) . "</td>";
				echo "<td>" . $rij['Titel'] . "</td>";
				echo "<td>" . nl2br($rij['Omschrijving']) . "</td>";
				echo "<td>" . $rij['Land'] . "</td>";
				echo "<td>" . $rij['Stad'] . "</td>";
				echo "<td>" . $rij['Postnr'] . "</td>";
				echo "<td>" . $rij['Straatnaam'] . "</td>";
				echo "<td>" . $rij['Straatnummer'] . "</td>";
				$stmt2 = $link->prepare("select * from activiteitheeftgebruiker where GIB = ? and AID = ?");
				$stmt2->bindParam(1, $_SESSION["ID"]);
				$stmt2->bindParam(2, $aid);
				$stmt2->execute();
				$count = $stmt2->rowCount();
				if ($count >= 1) {
					echo "<td> U bent ingeschreven. </td></tr>";
				} else {
					echo "<td><form method='post'><input type='hidden' value=\"$aid\" name='AID'><input type='submit' value='Inschrijven' name='nr'></form></td></tr>";
				}

			}
			echo "</tbody></table></div>";
		?>
	</div>
	<?php require_once("../extraFiles/navEnding.php"); ?>
</body>
</html>
