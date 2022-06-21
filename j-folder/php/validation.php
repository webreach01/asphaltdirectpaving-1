<?php

/******************************************************/
/* Validation methods */
/******************************************************/
	/* Name */
	function validateName($name, $min_length) {
		$error_text = "Enter your name";
		// $len = mb_strlen($name, 'UTF-8');
		$len = strlen($name);
		return ($len < $min_length) ? $error_text : "valid";
	}
	
	
	
	
		
	/* Phone */
	function validatePhone($phone) {
		$error_text = "Phone format: xxx-xxx-xxxx";
		$phone_template = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
		return (preg_match($phone_template, $phone) !== 1) ? $error_text : "valid";
	}

	/* Email */
	function validateEmail($email){
		$error_text = "Incorrect email format";
		$email_template = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/";
		return (preg_match($email_template, $email) !== 1) ? $error_text : "valid";
	}
	
	/* News group */
	function validateNewsGroup($newsgroup){
		$error_text = "Select type of newsletter";
		return (!$newsgroup) ? $error_text : "valid";
	}

	// Processing subscribe information
	// Making string from array
	function subscribeGroup($item) {
		$string = '';
		foreach ($item as $val) {
			$string .= strip_tags(trim($val)) . ", ";
		}
		$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
		$string = substr($string, 0, -2);
		return $string;
	}

	/* Message */
	function validateMessage($message, $min_length) {
		$error_text = "The message is too short - min " . $min_length . " characters";
		// $len = mb_strlen($message, 'UTF-8');
		$len = strlen($message);
		return ($len < $min_length) ? $error_text : "valid";
	}
	
	/* File */
	function validateFile($valid_types) {
		$attach_file_size	= 1*1024*1024;
		$error_exist		= false;
		$error_text			= "File: incorrect extension and/or too big file size";
		if (!empty($_FILES["file"])) {
			if (!in_array($_FILES["file"]["type"], $valid_types)) {
				$error_exist = true;
			}
			if (!is_uploaded_file($_FILES["file"]["tmp_name"])) {
				$error_exist = true;
			}
			if ($_FILES["file"]["size"] > $attach_file_size) {
				$error_exist = true;
			}
			return ($error_exist) ? $error_text : "valid";
		} else {
			return "Upload some file";
		}
	}

	/* Generate uniq name for file */
	function generateFileName(){
		return uniqid().'-'.strtolower($_FILES["file"]["name"]);
	}

	/* Upload file */
	function uploadFile(){
		$new_file = 'No file to upload.';
		if (!empty($_FILES["file"])) {
			$new_file = generateFileName();
			move_uploaded_file($_FILES["file"]["tmp_name"], '../upload_file/'.$new_file);
		}
		return $new_file;
	}
	
?>