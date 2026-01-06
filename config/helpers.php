<?php
// Function to set flash message
require_once __DIR__ . '/config.php';

if (!function_exists('setFlash')) {
    function setFlash($type, $message) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
}

// Function to get flash message
if (!function_exists('getFlash')) {
    function getFlash() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            $alertType = ($flash['type'] == 'error') ? 'danger' : $flash['type'];
            return '<div class="alert alert-'.$alertType.' alert-dismissible fade show" role="alert">
                        '.$flash['message'].'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
        return '';
    }
}

// Function to redirect
if (!function_exists('redirect')) {
    function redirect($url) {
        // Remove leading slash if any to avoid double slashes with BASE_URL
        $url = ltrim($url, '/');
        header("Location: " . BASE_URL . $url);
        exit;
    }
}
?>
