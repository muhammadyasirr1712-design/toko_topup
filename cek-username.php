<?php
// cek-username.php
$data = json_encode(['id' => $_POST['user_id'], 'zone' => $_POST['zone_id']]);

$ch = curl_init('http://localhost/sirshop/mock-api.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>