<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once "../extraFiles/navHeading.php" ?>
</head>
<body>
	<?php require_once "../extraFiles/navBeginning.php" ?>
	<div class="container-fluid">
		<div align="center" style="margin-top:10px">
			<h1 class="titel">Overzicht Meldingen</h1>
			<?php
				require_once("../extraFiles/connectie.php");
				$sql = "SELECT * FROM  `melding` inner join gebruiker on melding.gib = gebruiker.gib ORDER BY datum DESC ";
				$stmt = $link->query($sql);
				echo "<div class='table-responsive'>
                        <table class='table table-striped table-bordered'> <thead class='thead-dark'>
                                <tr>
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
				foreach ($stmt as $rij) {
					echo "<tr>";
					echo "<td>" . $rij['Gebruikersnaam'] . "</td>";
					echo "<td>" . substr($rij['Datum'], 0, 16) . "</td>";
					echo "<td>" . $rij['Pokemon'] . "</td>";
					echo "<td>" . $rij['Land'] . "</td>";
					echo "<td>" . $rij['Stad'] . "</td>";
					echo "<td>" . $rij['Postnr'] . "</td>";
					echo "<td>" . $rij['Straatnaam'] . "</td>";
					echo "<td>" . $rij['Straatnummer'] . "</td></tr>";

				}
				echo "</tbody></table></div>";;
			?>
		</div>
	</div>
	<?php require_once("../extraFiles/navEnding.php"); ?>
</body>
</html>
