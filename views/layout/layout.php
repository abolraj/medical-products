<!-- header -->
<?= view('layout/header', $data) ?>
<div class="flex flex-wrap justify-center ">
    <!-- main -->
    <?= view($main_path ?? 'layout/main', $data) ?>
    <!-- sidebar -->
    <?= view('layout/sidebar', $data) ?>
</div>
<!-- footer -->
<?= view('layout/footer', $data) ?>