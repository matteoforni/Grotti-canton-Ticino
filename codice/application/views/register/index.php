<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="my-5">
                <form method="post" class="text-center border border-light p-5" action="<?php URL ?>register/createUser">

                    <p class="h4 mb-4">Registrati</p>

                    <div class="form-row mb-4">
                        <div class="col">
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Nome" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['firstname']:null;  ?>">
                            <div id="error-firstname" class="alert alert-danger" role="alert" >Inserire un nome valido</div>
                        </div>
                        <div class="col">
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Cognome" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['lastname']:null;  ?>">
                            <div id="error-lastname" class="alert alert-danger" role="alert" >Inserire un cognome valido</div>
                        </div>
                    </div>

                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" aria-describedby="username-helpblock" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['username']:null;  ?>">
                    <div id="error-username" class="alert alert-danger" role="alert" >Inserire uno username valido</div>
                    <small id="username-helpblock" class="form-text text-muted mb-4">
                        Minimo 3 caratteri
                    </small>

                    <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['email']:null;  ?>">
                    <div id="error-email" class="alert alert-danger" role="alert" >Inserire una email valida</div>

                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-describedby="password-helpblock">
                    <div id="error-password" class="alert alert-danger" role="alert" >Inserire una password valida</div>
                    <small id="password-helpblock" class="form-text text-muted mb-4">
                        Minimo 8 caratteri
                    </small>

                    <input type="password" id="repassword" name="repassword" class="form-control" placeholder="Ripeti la password">
                    <div id="error-repassword" class="alert alert-danger" role="alert" >Inserire una password valida</div>

                    <button class="btn btn-info my-4 btn-block" type="submit" id="submit">Registrati</button>

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
<script>
    $(document).ready(function () {
        //Quando la pagina ha caricato completamente aggiungo i listener agli input.
        addRegisterListeners();
    });
</script>