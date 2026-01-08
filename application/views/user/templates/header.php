<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= isset($page_title) ? $page_title : 'Dashboard' ?> - FKKMBT</title>
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css') ?>">
    
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        body {
            padding-bottom: 80px !important; /* Space for bottom nav */
        }
        .container {
            padding-top: 0 !important;
        }
        main.container {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
    </style>
</head>
<body class="bg-light">
