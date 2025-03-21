<?php
session_start();
session_destroy();
header('Location: TelaLogin.php');
exit();
?>