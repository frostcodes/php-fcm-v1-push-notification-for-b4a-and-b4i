<?php

/**
 * Example of how to send push notifications using PHP to FCM in a B4A or B4I app.
 *
 * @author   Frost Codes (Oluwaseyi Aderinkomi)
 * @link   https://seyi.punchlinetech.com
 * @link   https://punchlinetech.com
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

// Initialize the Firebase Messaging client using the service account credential file
$messaging = (new Factory())
    ->withServiceAccount(__DIR__ . '/service_account.json')
    ->createMessaging();

/**
 * Builds the B4X payload for a notification message.
 *
 * The payload is structured to work with both B4A (Android) and B4i (iOS) apps.
 *
 * - Android: Data-only message with high priority by default.
 * - iOS: Data payload accompanied by a visible notification, APNs priority 10,
 *   default sound, and a cleared badge counter (0).
 *
 * @param string $targetType 'token', 'topic', or 'condition'
 * @param string $target     Device registration token or topic name
 * @param string $title      Notification title
 * @param string $message    Notification body/message text
 * @param bool   $isIosDevice Set to true if target device is running iOS
 * @param array  $customData  Additional key-value pairs for payload
 * @param array  $options     Platform overrides for 'android' or 'apns' payloads
 */
function createB4xMessage(
    string $targetType,
    string $target,
    string $title,
    string $message,
    bool $isIosDevice,
    array $customData = [],
    array $options = []
): CloudMessage {
    $dataArray = array_merge([
        'title' => $title,
        'body'  => $message,
    ], $customData);

    $fcmMessage = CloudMessage::new();

    $fcmMessage = match ($targetType) {
        'topic'     => $fcmMessage->toTopic($target),
        'condition' => $fcmMessage->toCondition($target),
        default     => $fcmMessage->toToken($target),
    };

    $fcmMessage = $fcmMessage->withData($dataArray);

    if ($isIosDevice) {
        $apnsConfig = array_merge([
            'headers' => ['apns-priority' => '10'],
            'payload' => [
                'aps' => [
                    'sound' => 'default',
                    'badge' => 0,
                ],
            ],
        ], $options['apns'] ?? []);

        return $fcmMessage
            ->withNotification(Notification::create($dataArray['title'], $dataArray['body']))
            ->withApnsConfig(ApnsConfig::fromArray($apnsConfig));
    }

    $androidConfig = array_merge([
        'priority' => 'high',
    ], $options['android'] ?? []);

    return $fcmMessage->withAndroidConfig(
        AndroidConfig::fromArray($androidConfig)
    );
}

/**
 * Sends a notification to an FCM topic.
 */
function sendNotificationToTopic(
    string $topic,
    string $title,
    string $message,
    array $customData = [],
    array $options = []
): array {
    global $messaging;

    $fcmMessage = createB4xMessage(
        'topic',
        $topic,
        $title,
        $message,
        str_starts_with($topic, 'ios_'),
        $customData,
        $options
    );

    return $messaging->send($fcmMessage);
}

/**
 * Sends a notification to a single device using its FCM registration token.
 */
function sendNotificationToSingleRecipient(
    string $deviceToken,
    string $title,
    string $message,
    bool $isIosDevice = false,
    array $customData = [],
    array $options = []
): array {
    global $messaging;

    $fcmMessage = createB4xMessage(
        'token',
        $deviceToken,
        $title,
        $message,
        $isIosDevice,
        $customData,
        $options
    );

    return $messaging->send($fcmMessage);
}
