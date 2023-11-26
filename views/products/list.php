<dialog id="pay-product-modal" class="modal -modalopen">
    <div class="modal-box">
        <h3 class="font-bold text-lg">
            Take Your Order !
            <span class="badge badge-secondary">+ <span class="quantity-count">1</span></span>
        </h3>
        <p class="py-4">Please select the quantity you want to pay !</p>

        <input class="range range-secondary" type="range" step="1" min="1" max="10" value="1"/>
        <div class="range-modifiers text-secondary w-full flex justify-between text-xs px-2">
        </div>

        <div class="modal-action">
            <button class="btn-pay btn btn btn-success">Pay It !</button>
            <form method="dialog">
                <!-- if there is a button in form, it will close the modal -->
                <button class="btn btn-secondary">Close</button>
            </form>
        </div>
    </div>
</dialog>

<main class="min-h-screen max-w-screen-lg mx-auto p-4">
    <h2 class="text-xl mb-5">Products, you can pick and pay your owns !</h2>
    <ul id="list-products" class="flex flex-wrap gap-2">
        <?php foreach ($products as $product) : ?>
            <li id="product-<?= $product['id'] ?>" class="card w-80 grow bg-base-100 shadow-xl">
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
                        <?php if ($user) : ?>
                            <button class="pay-btn btn btn-primary" data-user-id="<?= $user['id'] ?>" data-product-id="<?= $product['id'] ?>" data-quantity="<?= $product['quantity'] ?>">Add To Cart</button>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</main>