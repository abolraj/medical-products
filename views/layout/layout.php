<!-- header -->
<?= view('layout/header', $data) ?>
<!-- main -->
<?= view($main_path ?? 'layout/main', $data) ?>
<!-- sidebar -->
<?= view('layout/sidebar', $data) ?>
<!-- footer -->
<?= view('layout/footer', $data) ?>