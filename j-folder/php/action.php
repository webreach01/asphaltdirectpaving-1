<?php
	if (!isset($_SESSION)) session_start();
	header("Content-Type: text/html; charset=utf-8");

	if (!$_POST) exit;

	require dirname(__FILE__)."/validation.php";


/************************************************/
/* Your data */
/************************************************/
	/* Your email goes here */
	$your_email = "stevedirectpaving@gmail.com";
	// $your_email = "devtest7281@gmail.com";

	/* Your name or your company name goes here */
	$your_name = "Asphalt Direct Paving";

	/* Message subject */
	$your_subject = "Website Contact";

/************************************************/
/* Settings */
/************************************************/
	/* Select validation for fields */
	/* If you want to validate field - true, if you don't - false */
	$validate_name		= true;
	$validate_address   = false;
	$validate_phone     = true;
	$validate_email		= true;
	$validate_time      = false;
	$validate_preferred = false;
	$validate_message	= false;
	$validate_captcha	= true;
   $validate_newsletter	= false;

	/* Select the action */
	/* If you want to do the action - true, if you don't - false */
	$send_letter = true;

/************************************************/
/* Variables */
/************************************************/
	/* Error variables */
	$error_text		= array();
	$error_message	= '';

	/* POST data */
	$name	 = (isset($_POST["name"]))			? strip_tags(trim($_POST["name"]))			: false;
	$address	 = (isset($_POST["address"]))			? strip_tags(trim($_POST["address"]))			: false;
	$phone	 = (isset($_POST["phone"]))			? strip_tags(trim($_POST["phone"]))			: false;
	$email	 = (isset($_POST["email"]))			? strip_tags(trim($_POST["email"]))			: false;
	$time	 = (isset($_POST["time"]))			? strip_tags(trim($_POST["time"]))			: false;
	$preferred = (isset($_POST["preferred"]))   ? strip_tags(trim($_POST["preferred"]))		: false;
	$newsletter	 = (isset($_POST["news_group"]))		? subscribeGroup($_POST["news_group"])		  : false;
	$message = (isset($_POST["message"]))		? strip_tags(trim($_POST["message"]))		: false;
	$captcha = (isset($_POST["captcha_code"]))	? strip_tags(trim($_POST["captcha_code"]))	: false;

	$name	 = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
	$address = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
	$phone	 = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
	$email	 = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
	$time	 = htmlspecialchars($time, ENT_QUOTES, 'UTF-8');
	$preferred	 = htmlspecialchars($preferred, ENT_QUOTES, 'UTF-8');
	$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
	$captcha = htmlspecialchars($captcha, ENT_QUOTES, 'UTF-8');

	$name	 = substr($name, 0, 50);
	$address = substr($address, 0, 60);
	$phone	 = substr($phone, 0, 20);
	$email	 = substr($email, 0, 40);
	$time	 = substr($time, 0, 20);
	$preferred = substr($preferred, 0, 40);
	$message = substr($message, 0, 1000);

/************************************************/
/* CSRF protection */
/************************************************/

/************************************************/
/* Validation */
/************************************************/
	
	
	/* Name */
	if ($validate_name){
		$result = validateName($name, 1);
		if ($result !== "valid") {
			$error_text[] = $result;
		}
	}
	
	
	
	
	
	/* Phone */
	if ($validate_phone){
		$result = validatePhone($phone);
		if ($result !== "valid") {
			$error_text[] = $result;
		}
	}

	/* Email */
	if ($validate_email){
		$result = validateEmail($email);
		if ($result !== "valid") {
			$error_text[] = $result;
		}
	}

	/* Message */
	if ($validate_message){
		$result = validateMessage($message, 20);
		if ($result !== "valid") {
			$error_text[] = $result;
		}
	}
	
	/* Captcha */
	if ($validate_captcha) {
		if ($captcha != $_SESSION['code']) {
			$error_text[] = "Incorrect captcha";
		}
	}

	/* If validation error occurs */
	if ($error_text) {
		foreach ($error_text as $val) {
			$error_message .= '<li>' . $val . '</li>';
		}
		echo '<div class="error-message unit"><i class="fa fa-close"></i>Oops! The following errors occurred:<ul>' . $error_message . '</ul></div>';
		exit;
	}
/************************************************/
/* Upload file to the server */
/************************************************/
	/* Upload file */
	if ($upload_file) {
		$file_name = uploadFile();
	}

/************************************************/
/* Sending email */
/************************************************/
	if ($send_letter) {

		/* Send email using sendmail function */
		/* If you want to use sendmail - true, if you don't - false */
		/* If you will use sendmail function - do not forget to set '$smtp' variable to 'false' */
		$sendmail = true;
		if ($sendmail) {
			require dirname(__FILE__)."/phpmailer/PHPMailerAutoload.php";
			require dirname(__FILE__)."/message.php";
			$mail = new PHPMailer;
			$mail->isSendmail();
			$mail->IsHTML(true);
			$mail->From = "info@asphaltdirectpaving.com";
			$mail->CharSet = "UTF-8";
			$mail->FromName = $name;
			$mail->Encoding = "base64";
			$mail->ContentType = "text/html";
			$mail->addAddress($your_email, $your_name);
			$mail->Subject = $your_subject;
			$mail->Body = $letter;
			$mail->AltBody = "Use an HTML compatible email client";
			$mail->AddAttachment("../upload_file/".$file_name);
		}

		/* Send email using smtp function */
		/* If you want to use smtp - true, if you don't - false */
		/* If you will use smtp function - do not forget to set '$sendmail' variable to 'false' */
		$smtp = false;
		if ($smtp) {
			require dirname(__FILE__)."/phpmailer/PHPMailerAutoload.php";
			require dirname(__FILE__)."/message.php";
			$mail = new PHPMailer;
			$mail->isSMTP();											// Set mailer to use SMTP
			$mail->Host = "smtp1.example.com;smtp2.example.com";		// Specify main and backup server
			$mail->SMTPAuth = true;										// Enable SMTP authentication
			$mail->Username = "your-username";							// SMTP username
			$mail->Password = "your-password";							// SMTP password
			$mail->SMTPSecure = "tls";									// Enable encryption, 'ssl' also accepted
			$mail->Port = 465;											// SMTP Port number e.g. smtp.gmail.com uses port 465
			$mail->IsHTML(true);
			$mail->From = $email;
			$mail->CharSet = "UTF-8";
			$mail->FromName = $name;
			$mail->Encoding = "base64";
			$mail->Timeout = 200;
			$mail->SMTPDebug = 0;
			$mail->ContentType = "text/html";
			$mail->addAddress($your_email, $your_name);
			$mail->Subject = $your_subject;
			$mail->Body = $letter;
			$mail->AltBody = "Use an HTML compatible email client";
			$mail->AddAttachment("../upload_file/".$file_name);
		}

		/* Multiple email recepients */
		/* If you want to add multiple email recepients - true, if you don't - false */
		/* Enter email and name of the recipients */
		$recipients = false;
		if ($recipients) {
			$recipients = array("mannypomg@gmail.com" => "Manny",
								
								);
			foreach ($recipients as $email => $name) {
				$mail->AddBCC($email, $name);
			}
		}

		/* if error occurs while email sending */
		if(!$mail->send()) {
			echo '<div class="error-message unit"><i class="fa fa-close"></i>Mailer Error: ' . $mail->ErrorInfo . '</div>';
			exit;
		}
	}
	
	$files = glob("../upload_file/*");				// get all file names
foreach($files as $file){					// iterate files
	if(is_file($file)) {
		unlink($file);					// delete file
	}
}


/************************************************/
/* Success message */
/************************************************/
	echo '<div class="success-message unit"><i class="fa fa-check"></i>Your message has been sent</div>';
?>
