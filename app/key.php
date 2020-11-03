<?php
	function generateKey(){
		$int =  bin2hex(openssl_random_pseudo_bytes(16));
		return $int;

	}
	function encryptData($data, $key){
		$encrypted_string=openssl_encrypt($data,"AES-128-ECB",$key);
		return $encrypted_string;
	}
	function decryptData($data, $key){
		$decrypted_string=openssl_decrypt($data,"AES-128-ECB",$key);
		return $decrypted_string;
	}
	function generateSalt(){
		$salt =  bin2hex(openssl_random_pseudo_bytes(6));
		return $salt;
	}
?>