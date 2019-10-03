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
                    if(isset($_SESSION['warning'])){
                        foreach ($_SESSION['warning'] as $item) {
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
    var inputs = [false, false, false, false, false, false];
    $(document).ready(function () {
        addRegisterListeners();
        var validator = new Validator();
        var min_value = 0;
        var max_value = 50;

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
        function checkSubmit(){
            for(var i = 0; i < inputs.length; i++){
                if(inputs[i] != true){
                    console.log("false");
                    $('#submit').attr("disabled", true);
                    return;
                }
            }
            $('#submit').attr("disabled", false);
            return;
        }
    });

</script>