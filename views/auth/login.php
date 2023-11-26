<div class="relative flex flex-col justify-center min-h-screen p-4">
    <div class="w-full p-6 m-auto rounded-md shadow-black shadow-md lg:max-w-lg">
        <?php if ($msg = pop_temp_data('error_message')) : ?>
            <div role="alert" class="error alert alert-error mb-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= $msg ?></span>
            </div>
        <?php endif; ?>
        <?php if ($msg = pop_temp_data('success_message')) : ?>
            <div role="alert" class="error alert alert-success mb-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= $msg ?></span>
            </div>
        <?php endif; ?>
        <h1 class="text-3xl font-semibold text-center text-primary mb-2"> Login | Welcome back ! </h1>
        <form class="space-y-4" action="<?= url('auth.signin') ?>" method="post">
            <div>
                <label class="label" for="username">
                    <span class="text-base label-text">User Name</span>
                </label>
                <input type="text" name="username" placeholder="User Name" id="username" class="w-full input input-bordered input-primary" required />
            </div>
            <div>
                <label class="label" for="password">
                    <span class="text-base label-text">Password</span>
                </label>
                <input type="password" name="password" placeholder="Enter Password" minlength="6" id="password" class="w-full input input-bordered input-primary" required />
            </div>
            <!-- <a href="#" class="text-xs text-gray-600 hover:underline hover:text-blue-600">Forget Password?</a> -->
            <div>
                <button class="btn btn-primary w-full">Login</button>
            </div>
        </form>
    </div>
</div>