<header>
    <?= view('layout/header', $data) ?>
</header>

<main>
    <?= view($main_path ?? 'layout/main', $data) ?>
</main>

<aside>
    <?= view('layout/sidebar', $data) ?>
</aside>

<footer>
    <?= view('layout/footer', $data) ?>
</footer>