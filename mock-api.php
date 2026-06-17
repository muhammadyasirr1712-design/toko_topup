<?php
// mock-api.php
header('Content-Type: application/json');

// Membaca data yang dikirim dari browser
$input = json_decode(file_get_contents('php://input'), true);

// Simulasi data (Ganti ID ini dengan ID yang ingin Anda tes)
if (isset($input['id']) && $input['id'] == '2119342758') {
    echo json_encode([
        'success' => true,
        'username' => 'wann lopp dellv',
        'server' => '(Brazil)'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Akun tidak ditemukan'
    ]);
}
?>