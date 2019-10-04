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
                            <a href="">Password dimenticata?</a>
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
    //Array contenente gli input andati a buon fine o che hanno riportato problemi.
    var inputs = [false, false];

    $(document).ready(function () {
        //Quando la pagina ha caricato completamente aggiungo i listener agli input.
        addLoginListeners();

        //Genero un nuovo validatore e le lunghezze minime e massime.
        var validator = new Validator();
        var min_value = 0;
        var max_value = 50;

        //All'evento keydown verifico il contenuto degli input
        $("#email").keydown(function() {
            var input = this.value;
            if(validator.email(input)){
                $('#email').addClass("has-success");
                $('#email').removeClass("has-error");
                $('#error-email').css("display", "none");
                inputs[0] = true;
            }else{
                $('#email').addClass("has-error");
                $('#email').removeClass("has-success");
                $('#error-email').css("display", "block");
                inputs[0] = false;
            }
            checkSubmit()
        });
        $("#password").keydown(function() {
            var input = this.value;
            if(validator.password(input, min_value, max_value)){
                $('#password').addClass("has-success");
                $('#password').removeClass("has-error");
                $('#error-password').css("display", "none");
                inputs[1] = true;
            }else{
                $('#password').addClass("has-error");
                $('#password').removeClass("has-success");
                $('#error-password').css("display", "block");
                inputs[1] = false;
            }
            checkSubmit()
        });

        //Disattivo il bottone e lo riattivo solo se tutti gli input sono corretti.
        function checkSubmit(){
            for(var i = 0; i < inputs.length; i++){
                if(inputs[i] != true){
                    $('#submit').attr("disabled", true);
                    return;
                }
            }
            $('#submit').attr("disabled", false);
            return;
        }
    });
</script>