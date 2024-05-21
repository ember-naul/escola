<?php
session_start();
session_destroy();
header("Location: login.php");
echo "<link rel='shortcut icon' href='peixe.ico' type='image/x-icon'>";
?>