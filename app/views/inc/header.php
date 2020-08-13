<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <?php require APPROOT . '/views/inc/styles-import.php'; ?>
    <?php require APPROOT . '/views/inc/scripts-import.php'; ?>
    <title><?= SITENAME ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/navbar.php'; ?>
    <?php if(isLoggedIn() && isAdmin()): ?>
        <?php require APPROOT . '/views/admins/admin-inc/admin-navbar.php'; ?>
    <?php endif; ?>
    <div class="mb-3"></div>
    <div class="container">
