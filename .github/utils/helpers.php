<?php
function redirect($path) {
    header("Location: {$path}");
    exit;
}
function is_logged_in() {
    return isset($_SESSION['user_id']);
}
