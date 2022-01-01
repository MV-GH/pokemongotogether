<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once("../extraFiles/navHeading.php"); ?>
</head>
<body>
	<?php require_once("../extraFiles/navBeginning.php"); ?>
	<div class="container-fluid">
		<h1 class="titel text-center">Overzicht activiteiten</h1>
		<div class="container shadow-sm pb-lg-3 pt-lg-3 mb-lg-3">
			<div class="list-group list-group-horizontal-sm">
				<a href="../activiteiten/activiteitenOverzicht.php" class="list-group-item list-group-item-action flex-fill text-uppercase active"><b>Overzicht</b></a>
				<a href="activiteitenInschrijvenOud.php" class="list-group-item list-group-item-action flex-fill text-uppercase "><b>Inschrijven</b></a>
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
                                </tr>
                            </thead><tbody>";
			foreach ($stmt as $rij) {
				echo "<td>" . substr($rij['Datum'], 0, 16) . "</td>";
				echo "<td>" . $rij['Titel'] . "</td>";
				echo "<td>" . nl2br($rij['Omschrijving']) . "</td>";
				echo "<td>" . $rij['Land'] . "</td>";
				echo "<td>" . $rij['Stad'] . "</td>";
				echo "<td>" . $rij['Postnr'] . "</td>";
				echo "<td>" . $rij['Straatnaam'] . "</td>";
				echo "<td>" . $rij['Straatnummer'] . "</td></tr>";

			}
			echo "</tbody></table></div>";
		?>
	</div>
	<?php require_once("../extraFiles/navEnding.php"); ?>
</body>
</html>
