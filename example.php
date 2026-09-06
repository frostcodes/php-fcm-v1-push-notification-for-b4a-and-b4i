<?php

/**
 * FCM sending examples for B4A and B4I.
 *
 * Update the topic or token before running this file. Each send call creates
 * one notification, so keep only the example you want to test enabled.
 */

error_reporting(E_ALL);

require_once __DIR__ . '/firebase.utils.php';

/*
 * TOPIC EXAMPLE
 *
 * B4A topic: use a normal topic name.
 * B4I topic: prefix the topic with "ios_". This enables the iOS notification
 * and APNs settings configured in firebase.utils.php.
 */
// $topic = 'ios_test_topic';
$topic = 'test_topic';

$title = 'NOTIFICATION_TITLE @ ' . date('H:i:s');
$message = 'NOTIFICATION_BODY @ ' . date('H:i:s');

// No custom data.
var_dump(sendNotificationToTopic($topic, $title, $message));

// With custom data. Enable this instead of the call above to avoid sending twice.
// var_dump(sendNotificationToTopic(
//     $topic,
//     $title,
//     $message,
//     array('action' => 'no_action')
// ));

/*
 * FCM TOKEN EXAMPLES
 *
 * Replace the placeholder with the receiving device's current FCM registration
 * token. Uncomment one call below when you want to send directly to that device.
 */
// $sampleFcmUserToken = 'XXXXXXXXXXXXXXXX';
// $tokenTitle = 'TOKEN NOTIFICATION_TITLE @ ' . date('H:i:s');
// $tokenMessage = 'TOKEN NOTIFICATION_BODY @ ' . date('H:i:s');

// No custom data.
// var_dump(sendNotificationToSingleRecipient(
//     $sampleFcmUserToken,
//     $tokenTitle,
//     $tokenMessage
// ));

// With custom data. Set the fourth argument to true for a B4I device.
// var_dump(sendNotificationToSingleRecipient(
//     $sampleFcmUserToken,
//     $tokenTitle,
//     $tokenMessage,
//     false,
//     array('action' => 'no_action')
// ));
