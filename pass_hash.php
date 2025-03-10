<?php
$plainPassword = '123'; // Enter password here
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
echo $hashedPassword;

// Open this in browser with xampp apache and mysql open and copy the hash
?>
