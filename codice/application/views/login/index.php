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

                    <button class="btn btn-info btn-block my-4" type="submit">Accedi</button>

                    <p>Non hai un account?
                        <a href="<?php URL ?>register">Registrati</a>
                    </p>
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
        addLoginListeners();
        var validator = new Validator();
        var min_value = 0;
        var max_value = 50;
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
        });
    });
</script>