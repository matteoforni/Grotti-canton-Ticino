<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="my-5">
                <form class="text-center border border-light p-5" method="post" action="<?php URL ?>login/checkLogin">

                    <p class="h4 mb-4">Accedi</p>

                    <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail">

                    <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password">

                    <div class="d-flex justify-content-around">
                        <div>
                            <a href="<?php URL ?>reset">Password dimenticata?</a>
                        </div>
                    </div>

                    <button class="btn btn-info btn-block my-4" type="submit" id="submit">Accedi</button>

                    <p>Non hai un account?
                        <a href="<?php URL ?>register">Registrati</a>
                    </p>
                    <?php
                    if(isset($_SESSION['errors'])){
                        foreach ($_SESSION['errors'] as $item) {
                            echo "<p class='text-danger'>" . $item . "</p><br>";
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        //Quando la pagina ha caricato completamente aggiungo i listener agli input.
        addLoginListeners();
    });
</script>