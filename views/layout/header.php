<header>
    <div class="navbar flex-wrap bg-base-200">
        <div class="flex-1 flex flex-wrap">
            <a class="btn btn-ghost rounded-md text-xl w-max" href="<?= url('home') ?>">
                <?= env('APP_NAME', 'App Name') ?>
            </a>
            <a class="btn btn-ghost rounded-md text-xl" href="<?= url('products.list') ?>">
                All Products
            </a>
        </div>
        <div class="flex-none">
            <?php if (user()) :
                if ($orders = user_orders()) {
                    $unpaid_orders = array_filter($orders, fn ($order) => !$order['is_paid']);
                    $total_price = array_sum(array_column($unpaid_orders, 'total_price'));
                }
            ?>

                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <?php if ($unpaid_orders ?? null) : ?>
                                <span class="user-orders-count badge badge-sm indicator-item rounded-full"><?= count($unpaid_orders) ?></span>
                            <?php endif; ?>
                        </div>
                    </label>
                    <?php if ($unpaid_orders ?? null) : ?>
                        <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
                            <div class="card-body">
                                <span class="font-bold text-lg"><?= count($unpaid_orders) ?> Items</span>
                                <span class="text-info">Total: <span class="user-orders-count"><?= $total_price ?></span>$</span>
                                <div class="card-actions">
                                    <a class="btn btn-primary btn-block" href="<?= url('orders.list') ?>">View Orders</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (user()) : ?>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost rounded-full">
                        <h2>
                            <?= user('username') ?>
                        </h2>
                    </label>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-full">
                        <li><a href="<?= url('auth.logout') ?>">Logout</a></li>
                    </ul>
                </div>
            <?php else : ?>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost rounded-full">
                        <h2>
                            Login / Register
                        </h2>
                    </label>
                    <ul tabindex="0" class="menu menu-sm w-full dropdown-content sm:right-0 mt-3 z-[1] p-2 shadow bg-base-100 rounded-box">
                        <li><a href="<?= url('auth.login') ?>">Login</a></li>
                        <li><a href="<?= url('auth.register') ?>">Register</a></li>
                    </ul>
                </div>
            <?php endif; ?>

        </div>
    </div>
</header>