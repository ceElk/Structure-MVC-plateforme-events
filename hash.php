<?php
$password = 'admin123';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Mot de passe : $password\n";
echo "Hash : $hash\n";
echo "\n";
echo "Vérification : " . (password_verify($password, $hash) ? 'OK' : 'FAIL') . "\n";