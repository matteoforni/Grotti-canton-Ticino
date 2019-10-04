<?php if(isset($_SESSION['fasce_prezzo'])): ?>
    <?php
        $fasce_prezzo = $_SESSION['fasce_prezzo'];
    ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="my-5">
                <form method="post" class="text-center border border-light p-5" action="<?php URL ?>add/addGrotto">

                    <p class="h4 mb-4">Aggiungi un grotto</p>

                    <input type="text" id="name" name="name" class="form-control mb-4" placeholder="Nome" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['username']:null;  ?>">
                    <div id="error-name" class="alert alert-danger" role="alert">Inserire uno nome valido</div>

                    <div class="form-row mb-4">
                        <div class="col">
                            <input type="text" id="cap" name="cap" class="form-control" placeholder="CAP" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['firstname']:null;  ?>">
                            <div id="error-cap" class="alert alert-danger" role="alert" >Inserire un CAP valido</div>
                        </div>
                        <div class="col">
                            <input type="text" id="paese" name="paese" class="form-control" placeholder="Paese" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['lastname']:null;  ?>">
                            <div id="error-paese" class="alert alert-danger" role="alert" >Inserire un paese valido</div>
                        </div>
                    </div>
                    <div class="form-row mb-4">
                        <div class="col">
                            <input type="text" id="via" name="via" class="form-control" placeholder="Via" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['firstname']:null;  ?>">
                            <div id="error-via" class="alert alert-danger" role="alert" >Inserire una via valido</div>
                        </div>
                        <div class="col">
                            <input type="text" id="no_civico" name="no_civico" class="form-control" placeholder="Numero Civico" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['firstname']:null;  ?>">
                            <div id="error-no_civico" class="alert alert-danger" role="alert" >Inserire un numero civico valido</div>
                        </div>
                    </div>

                    <input type="text" id="telefono" name="telefono" class="form-control mb-4" placeholder="Telefono" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['email']:null;  ?>">
                    <div id="error-telefono" class="alert alert-danger" role="alert" >Inserire un telefono valido</div>

                    <select name="fascia_prezzo" id="fascia_prezzo" class="mb-4 browser-default custom-select">
                        <option value="" disabled selected>Scegli una fascia di prezzo</option>
                        <?php foreach ($fasce_prezzo as $fascia_prezzo): ?>
                            <option value="<?php echo $fascia_prezzo['nome']; ?>"><?php echo $fascia_prezzo['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>


                    <p class="font-weight-bold">Valutazione: </p>

                    <input type="hidden" id="val" name="val" value="" />
                    <div class="rating-container">
                        <div id="valutazione" name="valutazione" class="rating"></div>
                    </div>

                    <button class="btn btn-info my-4 btn-block" type="submit" id="submit">Aggiungi</button>

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
    var inputs = [false, false, false, false, false, false];

    $(document).ready(function () {

        //Imposto le opzioni
        var options = {
            max_value: 5,
            step_size: 0.5,
        };

        //Istanzio la valutazione
        $(".rating").rate(options);

        //Ad ogni click setto come value dell'input nascosto val il valore della valutazione
        $(".rating").click(function () {
            var value = String($(".rating").rate("getValue"));
            $('#val').val(value);
        });

        //Mantengo sempre centrate le stelle
        var margin = $('.rating-container').width()/2 - $('.rating').width()/2;
        $(".rating").css('margin-left', margin);
        $(window).resize(function () {
            var margin = $('.rating-container').width()/2 - $('.rating').width()/2;
            $(".rating").css('margin-left', margin);
        });

        //Quando la pagina ha caricato completamente aggiungo i listener agli input.
        addRegisterListeners();

        //Genero un nuovo validatore e le lunghezze minime e massime.
        var validator = new Validator();
        var min_value = 0;
        var max_value = 50;

        //All'evento keydown verifico il contenuto degli input
        $("#firstname").keydown(function() {
            var input = this.value;
            if(validator.firstname(input, min_value, max_value)){
                $('#firstname').addClass("has-success");
                $('#firstname').removeClass("has-error");
                $('#error-firstname').css("display", "none");
                inputs[0] = true;
            }else{
                $('#firstname').addClass("has-error");
                $('#firstname').removeClass("has-success");
                $('#error-firstname').css("display", "block");
                inputs[0] = false;
            }
        });
        $("#lastname").keydown(function() {
            var input = this.value;
            if(validator.lastname(input, min_value, max_value)){
                $('#lastname').addClass("has-success");
                $('#lastname').removeClass("has-error");
                $('#error-lastname').css("display", "none");
                inputs[1] = true;
            }else{
                $('#lastname').addClass("has-error");
                $('#lastname').removeClass("has-success");
                $('#error-lastname').css("display", "block");
                inputs[1] = false;
            }
            checkSubmit()
        });
        $("#username").keydown(function() {
            var input = this.value;
            if(validator.username(input, min_value, max_value)){
                $('#username').addClass("has-success");
                $('#username').removeClass("has-error");
                $('#error-username').css("display", "none");
                inputs[2] = true;
            }else{
                $('#username').addClass("has-error");
                $('#username').removeClass("has-success");
                $('#error-username').css("display", "block");
                inputs[2] = false;
            }
            checkSubmit()
        });
        $("#email").keydown(function() {
            var input = this.value;
            if(validator.email(input)){
                $('#email').addClass("has-success");
                $('#email').removeClass("has-error");
                $('#error-email').css("display", "none");
                inputs[3] = true;
            }else{
                $('#email').addClass("has-error");
                $('#email').removeClass("has-success");
                $('#error-email').css("display", "block");
                inputs[3] = false;
            }
            checkSubmit()
        });
        $("#password").keydown(function() {
            var input = this.value;
            if(validator.password(input, min_value, max_value)){
                $('#password').addClass("has-success");
                $('#password').removeClass("has-error");
                $('#error-password').css("display", "none");
                inputs[4] = true;
            }else{
                $('#password').addClass("has-error");
                $('#password').removeClass("has-success");
                $('#error-password').css("display", "block");
                inputs[4] = false;
            }
            checkSubmit()
        });
        $("#repassword").keydown(function() {
            var input = this.value;
            if(validator.password(input, min_value, max_value)){
                $('#repassword').addClass("has-success");
                $('#repassword').removeClass("has-error");
                $('#error-repassword').css("display", "none");
                inputs[5] = true;
            }else{
                $('#repassword').addClass("has-error");
                $('#repassword').removeClass("has-success");
                $('#error-repassword').css("display", "block");
                inputs[5] = false;
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
<?php endif; ?>

