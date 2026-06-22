<?php
session_start();
session_unset();
session_destroy(); // Hapus semua session aktif
header("Location: index.php");
exit();