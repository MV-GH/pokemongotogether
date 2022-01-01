<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once("../extraFiles/navHeading.php"); ?>
	<?php

		if($_SESSION['Admin'] != 1){
			header("location: ../root/index.php");

		}
	?>

	<link href="../css/datetimepicker.css" rel="stylesheet" type="text/css"/>
</head>
<body><!-- <label for="Patum">Datum & Tijd</label>-->
	<?php require_once("../extraFiles/navBeginning.php"); ?>
	<?php
		require_once("../extraFiles/connectie.php");
		if (isset($_POST['verzend'])) {
			if (empty($_POST['Datum'])) {
				$sql = "INSERT INTO `activiteit` ( Titel, `Omschrijving`, `Land`, `Stad`, `Postnr`, `Straatnaam`, `Straatnummer`) VALUES ( ? , ?, ?, ?, ?, ?, ?)";
				$stmt = $link->prepare($sql);
				$stmt->bindparam(1, $_POST['Titel']);
				$stmt->bindparam(2, $_POST['Omschrijving']);
				$stmt->bindparam(3, $_POST['Land']);
				$stmt->bindparam(4, $_POST['Stad']);
				$stmt->bindparam(5, $_POST['Postnummer']);
				$stmt->bindparam(6, $_POST['Straatnaam']);
				$stmt->bindparam(7, $_POST['Straatnummer']);
				$stmt->execute();
			} else {
				$sql = "INSERT INTO `activiteit` (`Datum`, Titel, `Omschrijving`, `Land`, `Stad`, `Postnr`, `Straatnaam`, `Straatnummer`) VALUES (? , ? , ?, ?, ?, ?, ?, ?)";
				$stmt = $link->prepare($sql);
				$stmt->bindparam(1, $_POST['Datum']);
				$stmt->bindparam(2, $_POST['Titel']);
				$stmt->bindparam(3, $_POST['Omschrijving']);
				$stmt->bindparam(4, $_POST['Land']);
				$stmt->bindparam(5, $_POST['Stad']);
				$stmt->bindparam(6, $_POST['Postnummer']);
				$stmt->bindparam(7, $_POST['Straatnaam']);
				$stmt->bindparam(8, $_POST['Straatnummer']);
				$stmt->execute();
			}
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
	<div class="container">
		<h1 class="titel text-center">Activiteiten Aanmaken</h1>
		<p class="text-center"> Via het onderstaande formulier kan u een activiteit <u>aanmaken</u>.</p>
		<div class="small-middle-container">
			<form method="post" id="formulier" class="formstyle">
				<div class="form-group">
					<label for="titel">Titel</label>
					<input id="titel" name="Titel" type="text" required="required" class="form-control">
				</div>
				<div class="form-group">
					<label for="Patum">Datum & Tijd</label>
					<div id="picker"></div>
					<input id="Patum" name="Datum" type="hidden" required="required" class="form-control" value=""></div>
				<div class="form-group">
					<label for="Omschrijving">Omschrijving</label>
					<textarea id="Omschrijving" form="formulier" name="Omschrijving" cols="40" rows="5" required="required" class="form-control"></textarea>
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
					<button name="verzend" type="submit" class="btn-block btn btn-primary">Verzenden</button>
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
	<!-- DataTimePicker-->
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.0/moment-with-locales.min.js"></script>
	<script type="text/javascript" src="../js/datetimepicker.js"></script>
	<script type="text/javascript">
        $(document).ready(function () {
            $('#picker').dateTimePicker(
                {
                    positionShift: {top: 20, left: 0},
                    title: "Kies de datum en de tijd",
                    buttonTitle: "Selecteer",
                    locale: 'nl'

                }
            );

        })
	</script>
</body>
</html>
