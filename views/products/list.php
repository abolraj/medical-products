<main class="min-h-screen max-w-screen-lg mx-auto p-4">
    <h2 class="text-xl mb-5">Products, you can pick and pay your owns !</h2>
    <ul id="list-products" class="flex flex-wrap gap-2">
        <?php foreach ($products as $product) : ?>
            <li id="product-<?=$product['id']?>" class="card w-80 grow bg-base-100 shadow-xl">
                <figure>
                    <img class="object-cover w-full h-full" src="<?= path($product['image'], '/images') ?>" alt="Products - <?= $product['name'] ?>" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title flex flex-wrap">
                        <?= $product['name'] ?>
                        <div class="badge badge-primary min-w-max"><?= $product['price'] ?> $</div>
                        <div class="badge badge-secondary min-w-max">X <span class="quantity"><?= $product['quantity'] ?></span></div>
                    </h2>
                    <p><?= $product['description'] ?></p>
                    <div class="card-actions justify-end">
                        <?php if($user): ?>
                            <button class="pay-btn btn btn-primary" data-user-id="<?=$user['id']?>" data-product-id="<?=$product['id']?>">Add To Cart</button>
                        <?php endif;?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</main>