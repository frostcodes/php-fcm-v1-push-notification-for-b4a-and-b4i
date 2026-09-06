<?php

/**
 * Example of how to send push notifications using PHP to FCM in a B4A or B4I app.
 *
 * @author Frost Codes (Oluwaseyi Aderinkomi)
 * @link https://seyi.punchlinetech.com
 * @link https://punchlinetech.com
 *
 * Support my work 👇👇
 * LINK 1: https://flutterwave.com/donate/xua1z1xmabji
 *
 * LINK 2: https://paystack.com/pay/rbhzwdgozj
 */
require_once __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

// Messaging instance should be created with the Firebase service account key file.
$messaging = (new Factory())
    ->withServiceAccount(__DIR__ . '/service_account.json')
    ->createMessaging();

function strStartsWith($fullStr, $strToFind)
{
    $len = strlen($strToFind);

    return substr($fullStr, 0, $len) === $strToFind;
}

/**
 * Builds the B4X payload for a notification message.
 *
 * The payload is structured to work with both B4A and B4i apps.
 *
 * - Android: data-only message with high priority.
 * - iOS: data message plus a visible notification, APNs priority 10, default
 *   sound, and a cleared badge.
 */
function createB4xMessage($targetType, $target, $title, $message, $isIosDevice, $customData)
{
    $dataArray = array_merge(array(
        'title' => $title,
        'body'  => $message,
    ), $customData);

    $fcmMessage = CloudMessage::withTarget($targetType, $target)
        ->withData($dataArray);

    if ($isIosDevice) {
        return $fcmMessage
            ->withNotification(Notification::create($dataArray['title'], $dataArray['body']))
            ->withApnsConfig(
                ApnsConfig::new()
                    ->withImmediatePriority()
                    ->withDefaultSound()
                    ->withBadge(0)
            );
    }

    return $fcmMessage->withAndroidConfig(
        AndroidConfig::new()->withHighMessagePriority()
    );
}

/**
 * Sends a notification to an FCM topic.
 */
function sendNotificationToTopic($topic, $title, $message, $customData = array())
{
    global $messaging;

    $fcmMessage = createB4xMessage(
        'topic',
        $topic,
        $title,
        $message,
        strStartsWith($topic, 'ios_'),
        $customData
    );

    return $messaging->send($fcmMessage);
}

/**
 * Sends a notification to a single device using its FCM registration token.
 */
function sendNotificationToSingleRecipient($deviceToken, $title, $message, $isIosDevice = false, $customData = array())
{
    global $messaging;

    $fcmMessage = createB4xMessage(
        'token',
        $deviceToken,
        $title,
        $message,
        $isIosDevice,
        $customData
    );

    return $messaging->send($fcmMessage);
}
