<?php
//iniciarem la sessió
session_start();
//destruirem la sessió
session_destroy();
header("Location: login.php");
exit();
?>
