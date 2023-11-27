<dialog id="pay-product-modal" class="modal -modalopen">
    <div class="modal-box">
        <h3 class="font-bold text-lg">
            Take Your Order !
            <span class="badge badge-secondary inline-block">+ <span class="quantity-count">1</span></span>
            <span class="badge-price badge badge-secondary inline-block"><span class="price-value">1</span> $</span>
            <span class="badge-offer badge badge-error inline-block hidden">+ <span class="offer-value">1</span> % OFF</span>
        </h3>
        <p class="py-4">Please select the quantity you want to pay !</p>

        <input class="range range-secondary" type="range" step="1" min="1" max="10" value="1" />
        <div class="range-modifiers text-secondary w-full flex justify-between text-xs px-2">
        </div>

        <label class="label">Phone number :</label>
        <input type="text" class="input input-secondary" value="<?= user('phone') ?>" readonly />

        <div class="modal-action">
            <button class="btn-pay btn btn btn-success">Add To Cart !</button>
            <form method="dialog">
                <!-- if there is a button in form, it will close the modal -->
                <button class="btn btn-secondary">Close</button>
            </form>
        </div>
    </div>
</dialog>

<main class="min-h-screen max-w-full mx-auto p-4">
    <h2 class="text-xl mb-5">Products, you can pick and pay your owns !</h2>
    <ul id="list-products" class="flex flex-wrap gap-2">
        <?php foreach ($products as $product) : ?>
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
                        <?= $product['name'] ?>
                        <div class="badge badge-primary min-w-max"><?= $product['price'] ?> $</div>
                        <div class="badge badge-secondary min-w-max">X <span class="quantity"><?= $product['quantity'] ?></span></div>
                    </h2>
                    <p><?= $product['description'] ?></p>
                    <div class="card-actions justify-end">
                        <?php if ($user) : ?>
                            <button class="pay-btn btn btn-primary" data-product-price="<?=$product['price']?>" data-product-offer="<?=$offers[$product['id']]['value'] ?? 0?>" data-user-id="<?= $user['id'] ?>" data-product-id="<?= $product['id'] ?>" data-quantity="<?= $product['quantity'] ?>">Add To Cart</button>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</main>