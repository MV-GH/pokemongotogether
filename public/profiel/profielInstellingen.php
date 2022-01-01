<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once "../extraFiles/navHeading.php" ?>
</head>
<body>
	<?php require_once "../extraFiles/navBeginning.php" ?>
	<?php
		$msg = '';

		if (isset($_POST['emailveranderen'])) {
			$stmt5 = $link->prepare("update gebruiker set Email = ? where GIB = ?");
			$stmt5->bindParam(1, $_POST['Email']);
			$stmt5->bindParam(2, $_SESSION['ID']);
			$stmt5->execute();
		}
		if (isset($_POST['Gebveranderen'])) {

			$sql = "select * from gebruiker where lower(Gebruikersnaam) = lower(?)";
			$stmt2 = $link->prepare($sql);
			$stmt2->bindParam(1, $_POST['Geb']);
			$stmt2->execute();
			$count = $stmt2->rowCount();
			if ($count == 1) {
				$msg = 'Gebruikersnaam bestaat al!';
				echo "<script type='text/javascript'> document.addEventListener(\"DOMContentLoaded\", function(event) { test2(); });</script>";
			} else {
				$stmt5 = $link->prepare("update gebruiker set Gebruikersnaam = ? where GIB = ?");
				$stmt5->bindParam(1, $_POST['Geb']);
				$stmt5->bindParam(2, $_SESSION['ID']);
				$stmt5->execute();
				session_destroy();
				$_SESSION = [];
				echo "<script type=\"text/javascript\">location.href='../index.php';</script>";

			}
		}
		$stmt = $link->prepare("select * from gebruiker where GIB = ?");
		$stmt->bindParam(1, $_SESSION['ID']);
		$stmt->execute();
		$stmt = $stmt->fetch();

		if (isset($_POST['wwveranderen'])) {

			if (password_verify($_POST['PasswordOld'], $stmt['Paswoord'])) {
				if ($_POST['PasswordNew'] == $_POST['PasswordNew2']) {
					$pw = password_hash($_POST['PasswordNew'], PASSWORD_DEFAULT);
					$stmt5 = $link->prepare("update gebruiker set Paswoord = ? where GIB = ?");
					$stmt5->bindParam(1, $pw);
					$stmt5->bindParam(2, $_SESSION['ID']);
					$stmt5->execute();
				} else {
					$msg = "De nieuwe paswoorden komen niet overeen.";
					echo "<script type='text/javascript'> document.addEventListener(\"DOMContentLoaded\", function(event) { test(); });</script>";
				}

			} else {
				$msg = "Het oude passwoord is niet correct.";
				echo "<script type='text/javascript'> document.addEventListener(\"DOMContentLoaded\", function(event) { test(); });</script>";
			}

		}
		function dateDiffInDays($date1)
		{
			// Calulating the difference in timestamps
			$diff = strtotime($date1) - time();

			// 1 day = 24 hours
			// 24 * 60 * 60 = 86400 seconds
			return abs(round($diff / 86400));
		}


	?>
	<div class="container">
		<h1 class="titel text-center">Instellingen</h1>
		<ul id="tabsJustified" class="nav nav-tabs">
			<li class="nav-item"><a href="" id="li1" data-target="#lijst1" data-toggle="tab" class="nav-link small text-uppercase subtitle active">Account gegevens</a></li>
			<li class="nav-item"><a href="" data-target="#lijst2" data-toggle="tab" class="nav-link small text-uppercase subtitle">E-mailadres veranderen</a></li>
			<li class="nav-item"><a href="" id="li3" data-target="#lijst3" data-toggle="tab" class="nav-link small text-uppercase subtitle">Wachtwoord veranderen </a></li>
			<li class="nav-item"><a href="" id="li4" data-target="#lijst4" data-toggle="tab" class="nav-link small text-uppercase subtitle">Gebruikersnaam veranderen</a></li>
		</ul>
		<br>
		<div id="tabsJustifiedContent" class="tab-content">
			<div id="lijst1" class="tab-pane fade show active">
				<div class="container-fluid mt-lg-5">
					<p class="subheading d-inline mr-5">Gebruikersnaam:</p>
					<p class="subtext d-inline ml-5"><?php echo $stmt['Gebruikersnaam']; ?></p>
					<hr>
					<p class="subheading d-inline mr-5">Leeftijd account :</p>
					<p class="subtext d-inline ml-5"><?php echo dateDiffInDays($stmt['AanmaakDatum']) . " dagen"; ?></p>
					<hr>
					<p class="subheading d-inline mr-5">E-mailadres:</p>
					<p class="subtext d-inline ml-5"><?php echo $stmt['Email']; ?></p>
					<hr>
				</div>
			</div>
			<div id="lijst2" class="tab-pane fade">
				<form method="post">
					<div class="form-group">
						<label class="subheading" for="mail">E-mailadres</label>
						<input id="mail" name="Email" type="email" class="form-control" required="required">
					</div>
					<div class="form-group">
						<button name="emailveranderen" type="submit" class="btn btn-outline-danger btn-lg">Verzenden</button>
					</div>
				</form>
			</div>
			<div id="lijst3" class="tab-pane fade">
				<form method="post">
					<div class="form-group">
						<label class="subheading" for="mail">Oud passwoord</label>
						<input id="mail" name="PasswordOld" type="password" class="form-control" required="required">
						<label class="subheading mt-lg-5" for="pass1">Nieuw passwoord</label>
						<input id="pass1" name="PasswordNew" type="password" class="form-control" required="required">
						<label class="subheading" for="pass2"> nieuw passwoord herhalen</label>
						<input id="pass2" name="PasswordNew2" type="password" class="form-control" required="required">
					</div>
					<div class="form-group">
						<button name="wwveranderen" type="submit" class="btn btn-outline-success btn-lg">Verzenden</button>
					</div>
				</form>
				<p class="text-center text-danger" style="font-size: 20px"><?php echo $msg; ?></p>
			</div>
			<div id="lijst4" class="tab-pane fade">
				<form method="post">
					<p class="text-center mt-lg-3 mb-lg-3" style="font-size: 18px">Bij een succesvolle verandering wordt u automatisch uitgelogd.</p>
					<div class="form-group">
						<label class="subheading" for="mail">Gebruikersnaam</label>
						<input id="mail" name="Geb" type="text" class="form-control" required="required">
					</div>
					<div class="form-group">
						<button name="Gebveranderen" type="submit" class="btn btn-outline-warning btn-lg">Verzenden</button>
					</div>
				</form>
				<p class="text-center text-danger" style="font-size: 20px"><?php echo $msg; ?></p>
			</div>
		</div>
	</div>
	<?php require_once "../extraFiles/navEnding.php" ?>
</body>
</html>
<script type="text/javascript">
    function test() {
        var element = document.getElementById("lijst3");
        element.classList.add("active");
        element.classList.add("show");
        var element = document.getElementById("lijst1");
        element.classList.remove("active");
        element.classList.remove("show");
        var element = document.getElementById("li1");
        element.classList.remove("active");
        var element = document.getElementById("li3");
        element.classList.add("active");
    }
</script>
<script type="text/javascript">
    function test2() {
        var element = document.getElementById("lijst4");
        element.classList.add("active");
        element.classList.add("show");
        var element = document.getElementById("lijst1");
        element.classList.remove("active");
        element.classList.remove("show");
        var element = document.getElementById("li1");
        element.classList.remove("active");
        var element = document.getElementById("li4");
        element.classList.add("active");
    }
</script>
