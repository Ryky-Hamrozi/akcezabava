<?php

use JonnyW\PhantomJs\Client;

require_once('vendor/autoload.php');

if(!$_REQUEST['url']) {
	echo "Musí být zadaná url";
}

$client = Client::getInstance();
$client->getEngine()->setPath(__DIR__ . '/bin/phantomjs.exe');
$request = $client->getMessageFactory()->createRequest($_REQUEST['url'], 'GET');

/**
 * @see JonnyW\PhantomJs\Http\Response
 **/
$response = $client->getMessageFactory()->createResponse();

// Send the request
$client->send($request, $response);

if($response->getStatus() === 200) {

	// Dump the requested page content
	echo $response->getContent();
}


?>


