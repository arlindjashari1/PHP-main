<?php
require_once __DIR__ . '/config.php';

function current_user() {
    return $_SESSION['user'] ?? null;
}
function is_logged_in() {
    return current_user() !== null;
}
function is_admin() {
    return is_logged_in() && ($_SESSION['user']['role'] ?? '') === 'admin';
}
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php'); exit;
    }
}
function require_admin() {
    if (!is_admin()) {
        header('Location: index.php'); exit;
    }
}