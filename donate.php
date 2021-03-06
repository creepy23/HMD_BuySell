<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/PHPMailer.php';
require 'vendor/SMTP.php';
require 'vendor/Exception.php';

if (isset($_POST['descDonate'])) {
	$email = $_SESSION['email'];
	$desc = $_POST['descDonate'];
	$user_id = $_SESSION['buyer_id'];
	$conn = new mysqli("localhost", "proj", "password", "dbpro");

	$query = "select * from user_addr where user_id='{$user_id}';";
	$result = $conn->query($query);
	$result = $result->fetch_assoc();
	$fname = $result['fname'];
	$lname = $result['lname'];
	$contact = $result['phone'];
	$address = $result['address'];

	$query_add = "insert into charity(user_id,description) values('{$user_id}','{$desc}');";
	$result = $conn->query($query_add);

	if ($result) {
		$mail = new PHPMailer(true);
		$subject = "HMD Donation";
		$body = "{$fname} {$lname} wants to make a donation.<br> Description - {$desc}<br> Contact - {$contact}<br> Address - {$address}<br> Email - {$email}.";
		try {
			//$mail->SMTPDebug = 1;                   // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'handmedownapp1@gmail.com';                     // SMTP username
			$mail->Password   = 'nananana';                               // SMTP password
			$mail->SMTPSecure = "ssl";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
			$mail->Port       = 465;                                    // TCP port to connect to

			//Recipients
			$mail->isHTML(true);
			$mail->setFrom('handmedownapp1@gmail.com', 'HMD');
			$mail->addAddress('donation_service@email.com');     // Add a recipient
			$mail->Subject = $subject;
			$mail->Body = $body;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo "<script>console.log('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
		}
		$_SESSION['email'] = $email;
		header('location:home.php');
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Donation</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form" action="donate.php" method="post">
					<span class="login100-form-title p-b-33">
						Donate to Avana
					</span>
					<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="descDonate" placeholder="Description">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button type="submit" class="login100-form-btn">
							Donate
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>



	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<script src="js/main.js"></script>

</body>

</html>