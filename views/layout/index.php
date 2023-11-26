<!DOCTYPE html>
<html lang="en" data-theme="<?=env('APP_THEME','light')?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= env('APP_DESCRIPTION', 'App Description') ?>">
    <title><?= env('APP_TITLE', 'App Title') ?></title>
    <link href="<?=get_asset('/styles/daisy-ui-full.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?=get_asset('/styles/styles.css')?>" rel="stylesheet" type="text/css" />
    <script src="<?=get_asset('/scripts/tailwind-script.js')?>" defer></script>
</head>

<body>
    <?= view($has_layout ? 'layout/layout' : $main_path)?>
</body>

</html>