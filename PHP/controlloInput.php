<?php
	class controlloInput {
		public function validName($name){
			if(isset($name) && !empty($name)){
				if(preg_match("/^[a-zA-Z ]{3,18}$/",$name)){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}

		public function validTesto($testo) {
			if(isset($testo) && !empty($testo)) {
				if(preg_match("/^[a-zA-Z0-9&,#,;,.,, ]+$/",$testo)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public function FormatDate($data){
			if (isset($data) && !empty($data)){
				$dataFormata = date_create($data);
				$dataStringa = $dataFormata->format('Y-m-d');
				return $dataStringa;
			} else {
				return $data;
			}
		}

		/**
		 * Controlla se la data inserita è scritta nel formato gg-mm-aaaa
		 * @param string $data
		 */
		public function checkDateFormat($data){
			if (isset($data) && !empty($data) && preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/",$data))
				return true;

			return false;
		}

		public function checkBirthdate($data){
			$now = time();
			$dob = strtotime($data);
			$difference = $now - $dob;
			//There are 31556926 seconds in a year.
			$age = floor($difference / 31556926);

			return $age >= 18;
		}

		/**
		 * Controlla se la data inserita è succissiva o ad oggi
		 * @param string $data
		 */
		public function validDate($dataString){
			$data = date_create($dataString);
			$oggi = date("Y-m-d");
			if($data>$oggi){
				return true;
			}
			else{
				return false;
			}
		}

		public function validPass($pass){
			if(isset($pass) && !empty($pass)){
				if(preg_match("/^[a-zA-Z0-9]+$/",$pass)){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}

		public function validEmail($email){
			if(isset($email) && !empty($email)){
				$email = filter_var($email, FILTER_SANITIZE_EMAIL);
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					return true;
				}
				else {
					return false;
				}
			}
			else{
				return false;
			}
		}

		public function validPhone($phone){
			if(isset($phone) && !empty($phone)){
				if(preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/",$phone)){
					return true;
				}
				else {
					return false;
				}
			}
			else{
				return false;
			}
		}

		public function validAddress($address){
			if(isset($address) && !empty($address)){
				if(preg_match("/^([a-zA-Z ]{3,11})\s([a-zA-Z ]+\s)+(\d{1,3}([\/][a-zA-Z ])?)$/",$address)){
					return true;
				}
				else {
					return false;
				}
			}
			else{
				return false;
			}
		}

		public function validTarga($targa) {
			if(isset($targa) && !empty($targa)) {
				if(preg_match("/^[a-zA-Z]{2}[0-9]{3}[a-zA-Z]{2}$/",$targa)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public function validNumeri($cifra) {
			if(isset($cifra) && !empty($cifra)) {
				if(preg_match("/^[0-9]{1,7}$/",$cifra)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

	#flag fine documento
	}
?>
