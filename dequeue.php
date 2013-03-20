<?php
// Download/Install the PHP helper library from twilio.com/docs/libraries.
// This line loads the library
require('Services/Twilio.php');
 
// Your Account Sid and Auth Token from twilio.com/user/account
$sid = 'ACb19363393f835935bbdb6b63b749495b'; 
$token = '5996782fcbcdb88ff4c8ae18fd6d6930'; 
$client = new Services_Twilio($sid, $token);

//check and get if agentName was sent
if (isset($_GET['agentName'])) {
    $agentName = $_GET['agentName'];
}
// Get an object from its sid. If you do not have a sid,
// check out the list resource examples on this page
$member = $client->account->queues->get('QU4befc8e4a983a6e31df7fd4fb4598561')->members->get('Front');

$member->update(array(
        "Url" => "http://dudascoffee.com/twilio/dial_russ.xml",
        "Method" => "POST"
    ));
?>