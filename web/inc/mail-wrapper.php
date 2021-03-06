#!/usr/local/vesta/php/bin/php
<?php

if (empty($argv[1])) {
    echo "Error: not enough arguments\n";
    exit(3);
}

$options = getopt("s:f:");


define('NO_AUTH_REQUIRED',true);
include("/usr/local/vesta/web/inc/main.php");

// Set system language
exec (VESTA_CMD . "v-list-sys-config json", $output, $return_var);
$data = json_decode(implode('', $output), true);
if (!empty( $data['config']['LANGUAGE'])) {
    $_SESSION['language'] = $data['config']['LANGUAGE'];
} else {
    $_SESSION['language'] = 'en';
}
require_once('/usr/local/vesta/web/inc/i18n/'.$_SESSION['language'].'.php');

// Define vars
$from = 'Vesta Control Panel <vesta@'.$_SERVER["HOSTNAME"].'>';
$to = $argv[3]."\n";
$subject = $argv[2]."\n";
$mailtext = file_get_contents("php://stdin");

// Send email
if ((!empty($to)) && (!empty($subject))) {
    send_email($to,$subject,$mailtext,$from);
}

?>
