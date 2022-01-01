<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once "../extraFiles/navHeading.php"; ?>
</head>
<body>
	<?php require_once("../extraFiles/navBeginning.php"); ?>
			<div class="container">
				<h1 class="titel text-center">Meldingen Aanmaken</h1>
				<?php
					require_once("../extraFiles/connectie.php");
					if (isset($_POST['verzend'])) {

						$sql = "INSERT INTO melding (GIB, Pokemon, Datum, Land, Postnr, Stad, Straatnaam, Straatnummer) VALUES ( ? , ?, CURRENT_TIMESTAMP, ?, ?, ?, ?, ?)";
						$stmt = $link->prepare($sql);
						$stmt->bindparam(1, $_SESSION["ID"]);
						$stmt->bindparam(2, $_POST['Pokemon']);
						$stmt->bindparam(3, $_POST['Land']);
						$stmt->bindparam(4, $_POST['Postnummer']);
						$stmt->bindparam(5, $_POST['Stad']);
						$stmt->bindparam(6, $_POST['Straatnaam']);
						$stmt->bindparam(7, $_POST['Straatnummer']);
						$stmt->execute();

						?>
						<script>
                            history.pushState({}, "", "");
                            window.onload = function () {
                                myPopup();
                            };
						</script>
						<?php
					}
				?>
				<p class="text-center"> Via het onderstaande formulier kan u een melding <u>aanmaken</u>.</p>
				<div class="small-middle-container">
					<form method="post" class="formstyle">
						<div class="form-group">
							<label for="Pokemon">Pokémon</label>
							<input id="Pokemon" name="Pokemon" type="text" class="form-control" required="required">
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="text">Land</label>
								<input id="text" name="Land" type="text" class="form-control" required="required">
							</div>
							<div class="form-group col-md-3">
								<label for="text1">Stad</label>
								<input id="text1" name="Stad" type="text" class="form-control" required="required">
							</div>
							<div class="form-group col-md-3">
								<label for="text2">Postnummer</label>
								<input id="text2" name="Postnummer" type="text" class="form-control" required="required">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="text3">Straatnaam</label>
								<input id="text3" name="Straatnaam" type="text" class="form-control" required="required">
							</div>
							<div class="form-group col-md-6">
								<label for="text4">Straatnummer</label>
								<input id="text4" name="Straatnummer" type="text" class="form-control" required="required">
							</div>
						</div>
						<div class="form-group">
							<button name="verzend" type="submit" class="btn-block btn-primary">Verzenden</button>
						</div>
					</form>
				</div>
				<div id="popup">Het is verzonden!</div>
			</div>
	<?php require_once("../extraFiles/navEnding.php"); ?>
	<script>function myPopup() {
            var x = document.getElementById('popup');
            x.className = 'show';
            setTimeout(function () {
                x.className = x.className.replace('show', '');
            }, 3000);
        }
	</script>
</body>
</html>
