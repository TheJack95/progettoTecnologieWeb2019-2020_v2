<?php
	class controlloInput {
		public static function validName($name){
			if(isset($name) && !empty($name)){
				if(preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ ]{3,50}$/",$name)){
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

		public static function validTesto($testo) {
			if(isset($testo) && !empty($testo)) {
				if(preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9€?$@&#()'!,+\-;:=_.\s]{20,}$/",$testo)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public static function validTestoCorto($testoCorto) {
			if(isset($testoCorto) && !empty($testoCorto)) {
				if(preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9€?$@&#()'!,+\-;:=_.\s]{3,}$/",$testoCorto)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public static function validDescr($descr) {
			if(isset($descr) && !empty($descr)) {
				if(preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9€?$@&#()'!,+\-;:=_.\s]{10,}$/",$descr)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public static function FormatDate($data){
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
		public static function checkDateFormat($data){
			if (isset($data) && !empty($data) && preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/",$data))
				return true;

			return false;
		}

		public static function checkBirthdate($data){
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
		public static function validDate($dataString){
			$data = date_create($dataString);
			$oggi = date("Y-m-d");
			if($data>$oggi){
				return true;
			}
			else{
				return false;
			}
		}

		public static function validPass($pass){
			if(isset($pass) && !empty($pass)){
				if(preg_match("/^[a-zA-Z0-9]{4,}$/",$pass)){
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

		public static function validEmail($email){
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

		public static function validPhone($phone){
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

		public static function validAddress($address){
			if(isset($address) && !empty($address)){
				if(preg_match("/^([a-zA-ZÀ-ÖØ-öø-ÿ ]{3,11})\s([a-zA-ZÀ-ÖØ-öø-ÿ ]+\s)+(\d{1,3}([\/][a-zA-ZÀ-ÖØ-öø-ÿ ])?)$/",$address)){
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

		public static function validTarga($targa) {
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

		public static function validCilindrata($cifra) {
			if(isset($cifra) && !empty($cifra)) {
				if(preg_match("/^[0-9]{3,}$/",$cifra)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public static function validPrezzo($prezzo) {
			if(isset($prezzo) && !empty($prezzo)) {
				if(preg_match("/^[0-9]{2,}$/",$prezzo)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public static function validKm($km) {
			if(isset($km) && !empty($km)) {
				if(preg_match("/^[0-9]{1,}$/",$km)) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
?>
