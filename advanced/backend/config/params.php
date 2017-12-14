<?php
$adminmenu = require(__DIR__. '/menu.php');
return [
    'adminEmail' => 'admin@example.com',
    'admin.passwordResetTokenExpire' => 3600,
    'menu' => $adminmenu
];
