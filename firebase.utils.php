<?php
/**
* Example of how to send push notifications using PHP to FCM in a B4A or B4I app
* 
* @author Frost Codes ( Oluwaseyi Aderinkomi )
* @link https://seyi.punchlinetech.com
* @link https://punchlinetech.com
*
* Support my work 👇👇
*
* LINK 1: https://flutterwave.com/donate/xua1z1xmabji
*
* LINK 2: https://paystack.com/pay/rbhzwdgozj
*/


require_once __DIR__ . '/vendor/autoload.php';
require_once 'class.fcm.data.php';

use phpFCMv1\Client;
use phpFCMv1\Config;
use phpFCMv1\Data;
use phpFCMv1\Recipient;

// Client instance should be created with path to service account key file
$fcmClient = new Client('service_account.json');

$fcmAndroidConfig = new Config\AndroidConfig();
$fcmAndroidConfig->setPriority(Config\AndroidConfig::PRIORITY_HIGH);


// Convert all array values to strings
function castArrayValuesToString($mixedValArray){
	return array_map('strval', $mixedValArray);
}

function strStartsWith($fullStr, $strToFind){
	$len = strlen($strToFind);
	return (substr($fullStr, 0, $len) === $strToFind);
}

// Send a notification to a FCM topic
function sendNotificationToTopic($topic, $title, $message, $customData = array()){
	global $fcmClient, $fcmAndroidConfig;
	$customMessageFields = array();
	
	
	$data = new Data();
	$recipient = new Recipient();
	$recipient->setTopicRecipient($topic);
	
	$dataArray = array_merge(array(
		'title'    => $title,
		'body'     => $message,
	), $customData);
	
	$dataArray = castArrayValuesToString($dataArray);
	
	if(strStartsWith($topic, 'ios_')){
        // B4i
		$badge = 0;
		$iosalert = array('title' => $dataArray['title'], 'body' => $dataArray['body']);
		$customMessageFields['notification'] = $iosalert;
		
		$customMessageFields['apns'] = array(
			'headers' => array('apns-priority' => '10'),
			'payload' => array('aps' => array('sound' => 'default', 'badge' => $badge))
		);
		
		$data->setCustomData($dataArray, $customMessageFields);
		$fcmClient->build($recipient, null, $data);
		
		return $fcmClient->fire();
	}  
	
    // B4a
	$data->setCustomData($dataArray, $customMessageFields);
	$fcmClient->build($recipient, null, $data, $fcmAndroidConfig);
	
	return $fcmClient->fire();
}

// Send a notification to a single device using the device token
function sendNotificationToSingleRecipient($deviceToken, $title, $message, $isIosDevice = false, $customData = array()){
	global $fcmClient, $fcmAndroidConfig;
	$customMessageFields = array();
	
	
	$data = new Data();
	$recipient = new Recipient();
	$recipient->setSingleRecipient($deviceToken);
	
	$dataArray = array_merge(array(
		'title'    => $title,
		'body'     => $message,
	), $customData);
	
	$dataArray = castArrayValuesToString($dataArray);
	
	if($isIosDevice){
        // B4i
		$badge = 0;
		$iosalert = array('title' => $dataArray['title'], 'body' => $dataArray['body']);
		$customMessageFields['notification'] = $iosalert;
		
		$customMessageFields['apns'] = array(
			'headers' => array('apns-priority' => '10'),
			'payload' => array('aps' => array('sound' => 'default', 'badge' => $badge))
		);
		
		$data->setCustomData($dataArray, $customMessageFields);
		$fcmClient->build($recipient, null, $data);
		
		return $fcmClient->fire();
	}
	
    // B4a
	$data->setCustomData($dataArray, $customMessageFields);
	$fcmClient->build($recipient, null, $data, $fcmAndroidConfig);
	
	return $fcmClient->fire();
}

// TOPIC EXAMPLES
// $topic = 'ios_test_topic';
$topic = 'test_topic';
$title = 'NOTIFICATION_TITLE @ '. date('H:i:s');
$message = 'NOTIFICATION_BODY @  '. date('H:i:s');

var_dump(sendNotificationToTopic($topic, $title, $message)); // No custom data
var_dump(sendNotificationToTopic($topic, $title, $message, array('action' => 'no_action'))); // With custom data


// FCM TOKEN EXAMPLES

$sampleFcmUserToken = 'XXXXXXXXXXXXXXXX';
$tokenTitle = 'TOKEN NOTIFICATION_TITLE @ '. date('H:i:s');
$tokenMessage = 'TOKEN NOTIFICATION_BODY @  '. date('H:i:s');


var_dump(sendNotificationToSingleRecipient($sampleFcmUserToken, $tokenTitle, $tokenMessage)); // No custom data
var_dump(sendNotificationToSingleRecipient($sampleFcmUserToken, $tokenTitle, $tokenMessage, false, array('action' => 'no_action'))); // With custom data
