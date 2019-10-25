<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="my-5">
                <form class="text-center border border-light p-5" method="post" action="<?php URL ?>firstLogin/changePassword">

                    <p class="h4 mb-4">Reimposta la tua password</p>

                    <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail" value="<?php echo $_SESSION['user']['email']; ?>" readonly>
                    <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password">
                    <input type="password" id="repassword" name="repassword" class="form-control mb-4" placeholder="Ripeti la Password">

                    <input type="submit" value="Invia" class="btn btn-info">

                    <?php
                    if(isset($_SESSION['errors'])){
                        foreach ($_SESSION['errors'] as $item) {
                            echo "<p class='text-danger'>" . $item . "</p><br>";
                        }
                        unset($_SESSION['errors']);
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
