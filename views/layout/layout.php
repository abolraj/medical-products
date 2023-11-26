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