<main class="min-h-screen max-w-full mx-auto p-4">
    <h2 class="text-xl mb-5">Your Orders, you can pay or cancel anyone !</h2>
    <ul id="list-orders" class="flex flex-wrap gap-2">
        <?php foreach ($orders as $order) : 
            $product = $order['product'];
            ?>
            <li id="product-<?= $product['id'] ?>" class="card w-80 grow bg-base-100 shadow-xl">
                <figure class="relative">
                    <img class="object-cover w-full h-full" src="<?= path($product['image'], '/images') ?>" alt="Products - <?= $product['name'] ?>" />
                    <?php if ($offers[$product['id']] ?? null) : ?>
                        <div class="absolute opacity-90 bg-base-100 text-error rounded-tr-lg p-4 left-0 bottom-0">
                            <?= $offers[$product['id']]['value'] ?>% <span class="">OFF</span>
                        </div>
                    <?php endif; ?>
                </figure>
                <div class="card-body">
                    <h2 class="card-title flex flex-wrap">
                        Product : <?= $product['name'] ?>
                        <div class="badge badge-primary min-w-max"><?= $order['total_price'] ?> $ </div>
                        <div class="badge badge-primary min-w-max">1 X <?= $order['price'] ?> $ </div>
                        <div class="badge badge-secondary min-w-max">X <span class="quantity"><?= $order['quantity'] ?></span></div>
                        <div class="badge badge-outline badge-secondary min-w-max"><?= $order['created_at'] ?></div>
                        <?php if($order['is_paid']): ?>
                            <div class="badge badge-success min-w-max">paid</div>
                        <?php else: ?>
                            <div class="badge badge-warning min-w-max">pending</div>
                        <?php endif; ?>
                    </h2>
                    <p><?= $product['description'] ?></p>
                    <div class="card-actions justify-end">
                        <?php if ($user && !$order['is_paid']) : ?>
                            <button class="pay-btn btn btn-success" data-order-id="<?=$order['id']?>">Pay Now !</button>
                            <button class="cancel-btn btn btn-warning" data-order-id="<?=$order['id']?>">Cancel !</button>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</main>