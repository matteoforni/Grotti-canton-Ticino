<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="my-5">
                <form method="post" class="text-center border border-light p-5" action="<?php URL ?>register/createUser">

                    <p class="h4 mb-4">Registrati</p>

                    <div class="form-row mb-4">
                        <div class="col">
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Nome">
                        </div>
                        <div class="col">
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Cognome">
                        </div>
                    </div>

                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" aria-describedby="username-helpblock">
                    <small id="username-helpblock" class="form-text text-muted mb-4">
                        Minimo 3 caratteri
                    </small>

                    <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail">

                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-describedby="password-helpblock">
                    <small id="password-helpblock" class="form-text text-muted mb-4">
                        Minimo 8 caratteri
                    </small>

                    <input type="password" id="repassword" name="repassword" class="form-control" placeholder="Ripeti la password">

                    <button class="btn btn-info my-4 btn-block" type="submit">Registrati</button>
                </form>
            </div>
        </div>
    </div>
</div>