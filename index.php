//There are multiple auth tokens used in this program, please don't abuse it.
//Excuse my crappy coding style ;)
//Commits are directly pulled to my server and go live instantly. Think before you commit. 

<?php

phpinfo();

//Get the POST data from Telegram
$inp = file_get_contents('php://input');

//Log it if needed
/*
$fp = fopen('request.log', 'a');
fwrite($fp,  print_r($inp, TRUE));
fclose($fp);
*/

//Decode the JSON
$input = json_decode(preg_replace('/("\w+"):(-?\d+(\.\d+)?)/', '\\1:"\\2"', $inp), true, 512, JSON_BIGINT_AS_STRING);
//json_decode($inp);

//Get Shit from Fb [Graph API result]
//This token is linked to my account. Someone please look into changing it to a page auth
$resultFB = file_get_contents("https://graph.facebook.com/1549751131951442/feed?access_token=483465641838113|GW7RtlsNHb3U3zcFj39HIQiFF1E");

//Just for testing
/*
echo var_dump(json_decode($resultFB)->{'data'}[0]->{'message'});
*/

//Get the last 10 posts from the JSON encoded result from FB
for($x = 0; $x <= 10; $x++)
	writeMsg(json_decode($resultFB)->{'data'}[$x]->{'message'});

//Function to make the request to Telegram to send the message
function writeMsg($var) {

$url = 'https://api.telegram.org/bot187593023:AAECXd8sx9yyjTC_d65U1ZpbLeoHtuGKTXk/sendMessage';
$url2 = 'https://hookb.in/Zn9grRqY';
$data = array(
    'chat_id' => $input->{'message'}->{'chat'}->{'id'},
    'text' => $var,
    'disable_notification' => 'true'
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url2, false, $context);
if ($result === FALSE) { /* Handle error */ }
var_dump($result);
}
?>
