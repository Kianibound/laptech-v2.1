<?php
// tests/bootstrap.php

// جلوگیری از اجرای کدهای HTML و session
ob_start();

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Mock کردن session برای جلوگیری از خطا
if (!isset($_SESSION)) {
    $_SESSION = [];
}

// Load functions (بدون اجرای HTML)
require_once __DIR__ . '/../bcfunctions.php';

// پاک کردن output buffer
ob_end_clean();