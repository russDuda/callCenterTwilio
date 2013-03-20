<?php
	// Include the Twilio PHP library
	require 'Services/Twilio.php';

	// Twilio REST API version
	$version = '2010-04-01';

	// Set our AccountSid and AuthToken
	$accountSid = 'ACb19363393f835935bbdb6b63b749495b';
	$authToken  = '5996782fcbcdb88ff4c8ae18fd6d6930';

	// Instantiate a new Twilio Rest Client
	$client = new Services_Twilio($sid, $token, $version);

	try {
		// Get Recent Calls
		foreach ($client->account->calls as $call) {
			echo "Call from $call->from to $call->to at $call->start_time of length $call->duration";
		}
	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage();
	}
