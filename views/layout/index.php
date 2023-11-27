<!DOCTYPE html>
<html lang="en" data-theme="<?=env('APP_THEME','light')?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= env('APP_DESCRIPTION', 'App Description') ?>">
    <title><?= env('APP_TITLE', 'App Title') ?></title>
    <link href="<?=get_asset('/styles/daisy-ui-full.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?=get_asset('/styles/styles.css')?>" rel="stylesheet" type="text/css" />
    <link type="image/png" sizes="96x96" rel="icon" href="/favicon.png">
    <script src="<?=get_asset('/scripts/tailwind-script.js')?>"></script>
    <script src="<?=get_asset('/scripts/jquery-3.7.1.min.js')?>"></script>
    <script src="<?=get_asset('/scripts/scripts.js')?>" defer></script>
</head>

<body class="min-h-screen">
    <!-- handle loading -->
    <?= view('layout/loading', $data)?>
    <?= view($has_layout ? 'layout/layout' : $main_path, $data)?>
</body>

</html>