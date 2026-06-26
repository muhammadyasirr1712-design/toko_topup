<?php
// Mock API untuk simulasi pengecekan username
header('Content-Type: application/json');

// Ambil input dari request
$user_id = $_GET['id'] ?? '';
$zone_id = $_GET['zone'] ?? '';

// Simulasi database sederhana
$data_mock = [
    '2119342758' => [
        '1453' => 'Wann Lopp Dellv :p'
    ],
    '1234567890' => [
        '1234' => 'PlayerPro123'
    ]
];

// Cek apakah ID ada di data mock
if (isset($data_mock[$user_id]) && isset($data_mock[$user_id][$zone_id])) {
    echo json_encode([
        'status' => 'success',
        'username' => $data_mock[$user_id][$zone_id]
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'User tidak ditemukan'
    ]);
}
?>