<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=5.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title><?= isset($page_title) ? $page_title : 'FKKMBT' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <?php if(isset($custom_css)): ?>
        <?php foreach($custom_css as $css): ?>
            <link rel="stylesheet" href="<?= base_url($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Mobile Responsive CSS (CRITICAL) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css') ?>">
    
    <!-- Additional Styles -->
    <?php if(isset($additional_styles)): echo $additional_styles; endif; ?>
</head>
