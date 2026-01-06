<?php
// config/config.php

// 1. Detect Protocol (HTTP/HTTPS)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

// 2. Detect Host (e.g., localhost, example.com)
$host = $_SERVER['HTTP_HOST'];

// 3. Detect Path (folder name)
// This is critical. On localhost it might be /fkkmbt/, on hosting it might be / (root)
// We calculate it dynamically relative to this file's location.
// config.php is in /config/, so dirname(__FILE__) is .../config
// We want the parent, which is the root.
$script_name = dirname($_SERVER['SCRIPT_NAME']); 

// Simplified Dynamic Base URL logic
// If running on localhost/fkkmbt/index.php -> BASE_URL = http://localhost/fkkmbt/
// If running on domain.com/index.php -> BASE_URL = http://domain.com/

$base_url = $protocol . "://" . $host . "/";

// Adjust for subdirectories if the script is not at the domain root
// This part can be tricky. A safer bet for generic "upload and play" 
// without complex detection is to let the user or hosting environment define it,
// OR use a relative path logic.
// However, for this project, let's assume:
// Localhost: http://localhost/fkkmbt/
// Hosting: http://yourdomain.com/

if ($host == 'localhost' || $host == '127.0.0.1') {
    $base_url .= 'fkkmbt/';
} else {
    // Modify this if you put it in a subfolder on your hosting
    // e.g., $base_url .= 'subfolder/';
    $base_url .= ''; 
}

// Define the constant
if (!defined('BASE_URL')) {
    define('BASE_URL', $base_url);
}

// Set Default Timezone (WIB)
date_default_timezone_set('Asia/Jakarta');
?>
