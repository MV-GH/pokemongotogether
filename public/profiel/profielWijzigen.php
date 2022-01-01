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
		<h1 class="titel text-center">Pas de gebruikers aan</h1>
		<?php
			require("../extraFiles/connectie.php");
			/*#todo change GIB TO GID*/
			if (isset($_POST['nrVERD'])) {
				$sql = "delete from gebruiker where GIB = ?";
				$stmt = $link->prepare($sql);
				$stmt->bindParam(1, $_POST['nrVERD']);
				$stmt->execute();
			}

			if (isset($_POST['update'])) {
				try {
					if (!empty($_POST["Email"])) {
						$stmt = $link->prepare("update gebruiker set Email=? where GIB =?");
						$stmt->bindParam(1, $_POST['Email']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!is_null($_POST["lijstBeheerder"])) {
						$stmt = $link->prepare("update gebruiker set Beheerder=? where GIB =?");
						$stmt->bindParam(1, $_POST['lijstBeheerder']);
						$stmt->bindParam(2, $_POST['update']);
						$stmt->execute();
					}
					if (!empty($_POST["Password"])) {
						if ($_POST["Password"] == $_POST["Password2"]) {
							$stmt = $link->prepare("update gebruiker set Paswoord=sha1( ? ) where GIB =?");
							$stmt->bindParam(1, $_POST['Password']);
							$stmt->bindParam(2, $_POST['update']);
							$stmt->execute();
						} else {
							echo "<script type='text/javascript'> alert('Paswoorden komen niet overeen! Paswoord van de gebruiker wordt niet veranderd.')</script>";
						}
					}

				} catch (Exception $e) {
					print("Er is een foute waarde ingegeven");
				}
			}
			$sql = "SELECT * FROM gebruiker ORDER BY AanmaakDatum DESC ";
			$stmt = $link->query($sql);
			if (!isset($_POST['nr'])) {
				echo "<div class='table-responsive'>
                            <table class='table table-striped table-bordered'> <thead class='thead-dark'>
                                <tr>                                    
                                    <th scope='col'>Gebruikersnaam</th>
                                    <th scope='col'>Paswoord</th>
                                    <th scope='col'>AanmaakDatum</th>
                                    <th scope='col'>Beheerder</th>
                                    <th scope='col'>E-mailadres</th>                                    
                                    <th scope='col'>Aanpassen</th>
                                    <th scope='col'>Verwijderen</th>
                                    </tr>
                            </thead><tbody>";
			} else {
				echo "<div class='table-responsive'>
                            <table class='table table-striped table-bordered'> <thead class='thead-dark'>
                                <tr>
                                    <th scope='col'>Gebruikersnaam</th>
                                    <th scope='col'>Paswoord</th>
                                    <th scope='col'>Paswoord herhalen</th>
                                    <th scope='col'>Beheerder</th>
                                    <th scope='col'>E-mailadres</th>          
                                    <th scope='col'>Aanpassen</th>
                                    </tr>
                            </thead><tbody>";
			}
			foreach ($stmt as $rij) {

				$nr = $rij['GIB'];
				if ($rij['Beheerder'] == 1) {
					$beheerder = "Ja";
				} else {
					$beheerder = "Nee";
				}

				if (isset($_POST['nr'])) {
					if ($_POST['nr'] == $rij['GIB']) {
						echo "<form method='post'><tr><td>" . $rij['Gebruikersnaam'] . "</td>";
						echo "<td><input class=\"form-control form-control-sm\" type='password' name='Password' ></td>";
						echo "<td><input class=\"form-control form-control-sm\" type='password' name='Password2' ></td>";
						if ($rij['Beheerder'] == 1) {
							echo "<td><select class=\"form-control\" name='lijstBeheerder'><option  value='1'> Ja</option><option  value='0'>Nee</option></select></td>";
						} else {
							echo "<td><select class=\"form-control\" name='lijstBeheerder'><option  value='0'>Nee</option><option  value='1'> Ja</option></select></td>";
						}
						echo "<td><input class=\"form-control form-control-sm\" type='email' name='Email' placeholder=\"" . $rij['Email'] . "\"></td>";
						echo "<td><input type='hidden' name='update' value='$nr'><input type='submit' value='verzenden'></form></td></tr>";

					} else {

						echo "<tr><td>" . $rij['Gebruikersnaam'] . "</td>";
						echo "<td>" . $rij['Paswoord'] . "</td>";
						echo "<td>"  . "</td>";
						echo "<td>" . $beheerder . "</td>";
						echo "<td>" . $rij['Email'] . "</td>";
						echo "<td><form method='post'><input type='hidden' name='nr' value='$nr'><input type='submit' value='aanpassen'></form></td>";

					}
				} else {

					echo "<tr><td>" . $rij['Gebruikersnaam'] . "</td>";
					echo "<td>" . $rij['Paswoord'] . "</td>";
					echo "<td>" . substr($rij['AanmaakDatum'], 0, 10) . "</td>";
					echo "<td>" . $beheerder . "</td>";
					echo "<td>" . $rij['Email'] . "</td>";
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