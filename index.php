//There are multiple auth tokens used in this program, please don't abuse it.
//Excuse my crappy coding style ;)
//Commits are directly pulled to my server and go live instantly. Think before you commit. 

<?php

//Get the POST data from Telegram
$inp = file_get_contents('php://input');

//Log it if needed
/*
$fp = fopen('request.log', 'a');
fwrite($fp,  print_r($inp, TRUE));
fclose($fp);
*/

//Decode the JSON
$input = json_decode($inp);

//Get Shit from Fb [Graph API result]
//This token is linked to my account. Someone please look into changing it to a page auth
$resultFB = file_get_contents("https://graph.facebook.com/tinkerhub/posts?access_token=CAACEdEose0cBAEBrnEz1SSABxEBMgzmd3BUT0oZAWTIVBxWdhOI5Ra68SG25vd89fot6IGGJCdIgxlp5RWv0NxvosPH5tdycEB0EoOy5kC680SzDQZCDpggj1uRn8KOn50f0VfTXFXhfqUfdWAvTCuCBvjFwVpb8BAMv7BICvYifIZCApSCkOBvAAAyXlrhxKFxre0ZB9wZDZD");

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
$data = array(
    'chat_id' => $input->{'message'}->{'chat'}->{'id'},
    'text' =>  $var
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }
var_dump($result);
}
?>
