<?php
require 'vendor/autoload.php';
// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md


use Twilio\Rest\Client;

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = ("AC6beeec3608fc6e228231942687bc8935");
$token = ("dd911c10fbda5981e3ae60525f75930a");
$twilio = new Client($sid, $token);

$message = $twilio->messages
    ->create(
        "+46708880569", // to
        [
            "body" => "Bra jobbat!",
            "from" => "+13343578271"
        ]
    );

// print ($message->sid);
?>

<h1> Tack för att du handlar hos oss, kolla mobilen för bekräftelse!</h1>