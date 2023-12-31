<aside class="text-center w-full">
    <?php if (isset($order_bys)) : ?>
        <form class="flex flex-wrap p-2 pl-4 mx-auto my-2 w-max sm:h-16 max-w-full justify-center gap-2 rounded-md bg-base-200 items-center">
            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="30" height="30">
                <path d="M24,8c0,.553-.447,1-1,1H10c-.552,0-1-.447-1-1s.448-1,1-1h13c.553,0,1,.447,1,1Zm-4,4H10c-.552,0-1,.447-1,1s.448,1,1,1h10c.553,0,1-.447,1-1s-.447-1-1-1Zm-3,5h-7c-.552,0-1,.447-1,1s.448,1,1,1h7c.553,0,1-.447,1-1s-.447-1-1-1Zm-3,5h-4c-.552,0-1,.447-1,1s.448,1,1,1h4c.553,0,1-.447,1-1s-.447-1-1-1ZM9.122,3.293L6.414,.586C5.635-.193,4.365-.193,3.586,.586L.879,3.293c-.391,.391-.391,1.023,0,1.414s1.023,.391,1.414,0l1.707-1.707V23c0,.553,.448,1,1,1s1-.447,1-1V3l1.708,1.707c.195,.195,.451,.293,.707,.293s.512-.098,.707-.293c.391-.391,.391-1.023,0-1.414Z" />
            </svg>

            <label for="order-by" class="label grow text-left">Order By</label>
            <select name="order" id="order-by" class="select grow">
                <?php foreach ($order_bys as $title => $order_by) : ?>
                    <option value="<?= $order_by[0] . ' ' . $order_by[1] ?>" <?= ($order_by[0] . ' ' . $order_by[1]) === @$_GET['order'] ? 'selected' : '' ?>><?= $title ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-primary sm:aspect-square h-full grow">Sort</button>
        </form>
    <?php endif; ?>
</aside>