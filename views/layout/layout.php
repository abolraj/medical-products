<!DOCTYPE html>
<html lang="en" data-theme="<?=env('APP_THEME','light')?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= env('APP_DESCRIPTION', 'App Description') ?>">
    <title><?= env('APP_TITLE', 'App Title') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.7/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com" defer></script>
</head>

<body>
    <header>
        <?= view('layout/header') ?>
    </header>
    <main>
        <?= view($_main_path ?? 'layout/main') ?>
    </main>
    <aside>
        <?= view('layout/sidebar') ?>
    </aside>
    <footer>
        <?= view('layout/footer') ?>
    </footer>
</body>

</html>