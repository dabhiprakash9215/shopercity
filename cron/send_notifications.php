<?php
require 'firebase_auth.php';

$projectId = "shopercity-ea0ae";
$serviceAccountPath = __DIR__ . "/service-account.json";
// print_r($serviceAccountPath);
// die;
$accessToken = getFirebaseAccessToken($serviceAccountPath);

$deviceToken = "fMR4IlykHFCGc5GZFl5vFF:APA91bHvT_YSq8yDkF5IbySf1twZ_6fBb3L5ieH3E3h0AlWeuQfcR_994wH8Gk9nvgxRPT1Y1Oon2NHInGUZfMTr402NQWXTKIwad-V60srkAhn6voPhe0U";

$payload = [
    "message" => [
        "token" => $deviceToken,
        "notification" => [
            "title" => "🔥 Test Notification",
            "body"  => "FCM HTTP v1 working successfully 🎉"
        ],
        "android" => [
            "priority" => "HIGH"
        ],
        "webpush" => [
            "headers" => [
                "Urgency" => "high"
            ]
        ]
    ]
];

$ch = curl_init("https://fcm.googleapis.com/v1/projects/shopercity-ea0ae/messages:send");
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $accessToken",
        "Content-Type: application/json"
    ],
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);
curl_close($ch);

echo "<pre>";
print_r($response);
echo "</pre>";

die;
require_once '../db/connection.php'; // conn connection

date_default_timezone_set('Asia/Kolkata');
$qry = "SELECT * FROM notifications WHERE status = 1";
$sql = mysqli_query($conn, $qry);
$notifications = mysqli_fetch_all($sql, MYSQLI_ASSOC);

foreach ($notifications as $notification) {

    // 🔹 Location type
    switch ($notification['notification_type']) {
        case 'city':
            $column = 'city_id';
            break;
        case 'district':
            $column = 'district_id';
            break;
        case 'state':
            $column = 'state_id';
            break;
        default:
            continue 2;
    }

    // 🔹 Decode JSON ["201","203"]
    $locationIds = json_decode($notification['notification_location'], true);
    if (!is_array($locationIds) || empty($locationIds)) {
        continue;
    }

    // 🔹 Safe IN clause
    $locationIds = array_map('intval', $locationIds);
    $idList = implode(',', $locationIds);

    $qry2 = "
        SELECT DISTINCT notification_token
        FROM user_locations
        WHERE $column IN ($idList)
        AND notification_token IS NOT NULL
    ";

    $sql2 = mysqli_query($conn, $qry2);

    // $tokens = [];
    while ($row = mysqli_fetch_assoc($sql2)) {
        $tokens = $row['notification_token'];
        return sendPushNotification(
            $tokens,
            $notification['notification_title'],
            'New offer available near you 🎉'
        );
    }

    // 🔔 SEND NOTIFICATION

}


function sendPushNotification($token, $title, $body)
{
    $serverKey = 'BALA3EAA75KX1OcNiYCaA3EhYHbEt7njsfk8LkqrlEbBxNccc3Sxm_NmQCxqRs5MMR6SAfesgdsl8UyCUa2Zmis';

    $payload = [
        "to" => $token,
        "notification" => [
            "title" => $title,
            "body" => $body,
            "sound" => "default"
        ],
        "priority" => "high"
    ];

    $headers = [
        'Authorization: key=' . $serverKey,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
