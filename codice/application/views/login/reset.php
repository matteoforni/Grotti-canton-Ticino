<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="my-5">
                <?php if(!isset($_SESSION['mail_sent']) && !isset($_SESSION['password_change'])): ?>
                    <form class="text-center border border-light p-5" method="post" action="<?php URL ?>reset/sendEmail">

                        <p class="h4 mb-4">Reimposta la tua password</p>

                        <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail">
                        <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password">
                        <input type="password" id="repassword" name="repassword" class="form-control mb-4" placeholder="Ripeti la Password">

                        <button class="btn btn-info btn-block my-4" type="submit" id="submit">Invia</button>

                        <?php
                        if(isset($_SESSION['errors'])){
                            foreach ($_SESSION['errors'] as $item) {
                                echo "<p class='text-danger'>" . $item . "</p><br>";
                            }
                            unset($_SESSION['errors']);
                        }
                        ?>
                    </form>
                <?php elseif(isset($_SESSION['mail_sent']) && !isset($_SESSION['password_change'])): ?>
                    <h1 class="text-center h1">Email inviata!</h1>
                    <h4 class="text-center h4">Controlla la casella di posta di: <?php echo $_SESSION['mail_sent']; ?></h4>
                <?php elseif(!isset($_SESSION['mail_sent']) && isset($_SESSION['password_change'])): ?>
                    <h1 class="text-center h1">Password cambiata!</h1>
                    <h4 class="text-center h4">Puoi eseguire il login con la nuova password <a href="<?php echo URL ?>login">qui</a></h4>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        //Quando la pagina ha caricato completamente aggiungo i listener agli input.
        addResetListeners();
    });
</script>