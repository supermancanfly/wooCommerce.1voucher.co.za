<?php

// get feed items from api
function nfh_1612812067_getfeed() {

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => NFH_INSTA_FEED,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return json_decode($response);

}









