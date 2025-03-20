<?= $this->extend('layouts/main') ?>


<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Login Custom</div>
                <div class="card-body">
                    <?php if (session('error') !== null) : ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif ?>

                    <?php if (session('message') !== null) : ?>
                        <div class="alert alert-success">
                            <?= session('message') ?>
                        </div>
                    <?php endif ?>

                    <form action="<?= route_to('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <label for="login" class="form-label">Email or Username</label>
                            <input type="text" class="form-control <?= session('errors.login') ?
                                                                        'is-invalid' : '' ?>" name="login" placeholder="Email or Username">
                            <?php if (session('errors.login')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.login') ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control <?= session('errors.password') ?
                                                                            'is-invalid' : '' ?>" name="password" placeholder="Password">
                            <?php if (session('errors.password')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.password') ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input"
                                    id="remember" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                <label class="custom-control-label" for="remember">Remember Me</label>
                            </div>
                        </div>


                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="<?= route_to('register') ?>">Not have an account?</a>
                    </div>

                    <div class="text-center mt-3">
                        <a href="<?= route_to('forgot') ?>">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>