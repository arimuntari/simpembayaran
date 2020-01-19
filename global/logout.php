<?php
session_start();
session_destroy();

echo "<script>alert('LogOut Sukses'); document.location='../login.php'; </script>";
?>