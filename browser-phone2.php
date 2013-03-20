<?php
// @start snippet
include 'Services/Twilio/Capability.php';

$accountSid = 'ACb19363393f835935bbdb6b63b749495b';
$authToken  = '5996782fcbcdb88ff4c8ae18fd6d6930';
$appSid = 'APe86b3eb8c889c0b7d4878face53e04d1';

//set default client name
$clientName = 'russ';

// get the Twilio Client name from the page request parameters, if given
if (isset($_REQUEST['client'])) {
    $clientName = $_REQUEST['client'];
}

$capability = new Services_Twilio_Capability($accountSid, $authToken);
$capability->allowClientOutgoing($appSid);
$capability->allowClientIncoming($clientName);
$token = $capability->generateToken();
// @end snippet
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>
			Twilio Client Click to Call
		</title>
		<!-- @start snippet -->
		<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<link href="http://static0.twilio.com/packages/quickstart/client.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript"
      src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
    <script type="text/javascript"
      src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js">
    </script>
    <link href="http://static0.twilio.com/packages/quickstart/client.css"
      type="text/css" rel="stylesheet" />
    <script type="text/javascript">
 
      Twilio.Device.setup("<?php echo $token; ?>");
 
      Twilio.Device.ready(function (device) {
        $("#log").text("Client '<?php echo $clientName ?>' is ready");
      });
 
      Twilio.Device.error(function (error) {
        $("#log").text("Error: " + error.message);
      });
 
      Twilio.Device.connect(function (conn) {
        $("#log").text("Successfully established call");
      });
 
      Twilio.Device.disconnect(function (conn) {
        $("#log").text("Call ended");
      });
 
      Twilio.Device.incoming(function (conn) {
        $("#log").text("Incoming connection from " + conn.parameters.From);
        // accept the incoming connection and start two-way audio
        conn.accept();
      });
 
      Twilio.Device.presence(function (pres) {
        if (pres.available) {
          // create an item for the client that became available
          $("<li>", {id: pres.from, text: pres.from}).click(function () {
            $("#number").val(pres.from);
            call();
          }).prependTo("#people");
        }
        else {
          // find the item by client name and remove it
          $("#" + pres.from).remove();
        }
      });
 
      function call() {
        // get the phone number or client to connect the call to
        params = {"PhoneNumber": $("#number").val()};
        Twilio.Device.connect(params);
      }
 
      function hangup() {
        Twilio.Device.disconnectAll();
      }
    </script>
		<script type="text/javascript">
var getQueue = {
				getCall : function() {
					$.ajax({
						url: 'dequeue.php',
						type: 'GET',
						agentname : 'russ',
						success: function(data){
							if((data!=null) && (data!='')) {
								alert(data);
							} else {
								alert("no data returned");
							}
						}

					});
					}
				};
		</script>
		<!-- @end snippet -->
	</head>
	<body>
    <button class="call" onclick="call();">
      Call
    </button>
 <a onclick="getQueue.getCall();">Get Call From Queue</a>
    <button class="hangup" onclick="hangup();">
      Hangup
    </button>
 
    <input type="text" id="number" name="number"
      placeholder="Enter a phone number or client to call"/>
 
    <div id="log">Loading pigeons...</div>
 
    <ul id="people"/>
			
	</body>
</html>
