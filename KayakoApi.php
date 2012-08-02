<?php

/**
 * Description of KayakoApi
 *
 * @author Abhinav Kumar <abhinav.kumar@kayako.com>
 */

if(!class_exists('KayakoApi')):

class KayakoApi {

	private $baseUrl;

	private $username;

	private $password;

	private $apiKey;

	private $secretKey;

	private $signature;

	private $encodedSignature;

	private $salt;

	private $sessionId;


	public function __construct($baseUrl = '', $apiKey = '', $secretKey = '') {

		if(substr($baseUrl, -1, 1) == '?')
			$baseUrl = substr ($baseUrl, 0, -1);

		$this->baseUrl		= $baseUrl;
		$this->apiKey		= $apiKey;
		$this->secretKey	= $secretKey;

		// Generates a random string of ten digits
		$this->salt = mt_rand();

		// Computes the signature by hashing the salt with the secret key as the key
		$this->signature = hash_hmac('sha256', $salt, $this->baseUrl, true);

		// base64 encode...
		$this->encodedSignature = base64_encode($signature);

		// urlencode...
		$encodedSignature = urlencode($encodedSignature);
	}

	public function login($username, $password) {
		$loginURL = $this->baseUrl . '/staffapi/index.php?/Core/Default/Login';
		$args = array(
			'username'		=>	$username,
			'password'		=>	$password
		);
		$response = wp_remote_post($loginURL, $args);

		if (is_wp_error($response)) {
			echo 'Nope you are not in';
		} else {
			echo 'Success';
		}
	}

	public function createTicket($data) {

	 return $this->login('admin', 'admin');

		echo $url = $this->baseUrl . '/Tickets/Ticket';

		$response = wp_remote_post( $url, array(
			'salt'			=> $this->salt,
			'apikey'		=> $this->apiKey,
			'signature'		=> $this->encodedSignature,
			'method'		=> 'POST',
			'timeout'		=> 45,
			'redirection'	=> 5,
			'httpversion'	=> '1.0',
			'blocking'		=> true,
			'headers'		=> array(),
			'body'			=> $data,
			'cookies'		=> array()
			)
		);

		if( is_wp_error( $response ) ) {
		echo 'Something went wrong!';
		var_dump($response);
		} else {
		echo 'Response:<pre>';
		print_r( $response );
		echo '</pre>';
		}
	}

}
endif;