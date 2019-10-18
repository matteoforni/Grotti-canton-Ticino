<?php if(isset($_SESSION['user']) && $_SESSION['user']['nome_ruolo'] == 'admin' && (isset($_SESSION['grotto']) || isset($_SESSION['utente']))): ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="my-5">
                <form method="post" class="text-center border border-light p-5" action="">
                    <?php if(isset($_SESSION['utente']) && isset($_SESSION['ruoli'])): ?>
                        <p class="h4 mb-4">Modifica utente</p>
                        <div class="form-row mb-4">
                            <div class="col">
                                <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Nome" value="<?php echo $_SESSION['utente']['nome'];  ?>">
                                <div id="error-firstname" class="alert alert-danger" role="alert" >Inserire un nome valido</div>
                            </div>
                            <div class="col">
                                <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Cognome" value="<?php echo $_SESSION['utente']['cognome'];  ?>">
                                <div id="error-lastname" class="alert alert-danger" role="alert" >Inserire un cognome valido</div>
                            </div>
                        </div>

                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" aria-describedby="username-helpblock" value="<?php echo $_SESSION['utente']['username'];  ?>">
                        <div id="error-username" class="alert alert-danger" role="alert" >Inserire uno username valido</div>
                        <small id="username-helpblock" class="form-text text-muted mb-4">
                            Minimo 3 caratteri
                        </small>

                        <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail" value="<?php echo $_SESSION['utente']['email'];  ?>">
                        <div id="error-email" class="alert alert-danger" role="alert" >Inserire una email valida</div>

                        <select name="ruoli" id="ruoli" class="mb-4 browser-default custom-select">
                            <?php foreach ($_SESSION['ruoli'] as $ruolo): ?>
                                <option value="<?php echo $ruolo['nome']; ?>" <?php if($ruolo['nome'] == $_SESSION['utente']['nome_ruolo']): ?>selected="selected"<?php endif; ?>><?php echo $ruolo['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-describedby="password-helpblock">
                        <div id="error-password" class="alert alert-danger" role="alert" >Inserire una password valida</div>
                        <small id="password-helpblock" class="form-text text-muted mb-4">
                            Minimo 8 caratteri
                        </small>

                        <div class="form-row mb-4">
                            <div class="col">
                                <a href="<?php URL ?>gestione/updateUtente/<?php echo $_SESSION['utente']['email']; ?>" class="btn btn-warning my-4 btn-block" id="submit">Modifica</a>
                            </div>
                    <?php elseif (isset($_SESSION['grotto']) && isset($_SESSION['fasce_prezzo'])): ?>
                        <p class="h4 mb-4">Modifica grotto</p>
                        <input type="text" id="name" name="name" class="form-control mb-4" placeholder="Nome" value="<?php echo $_SESSION['grotto']['nome']; ?>">
                        <div id="error-name" class="alert alert-danger" role="alert">Inserire uno nome valido</div>

                        <div class="form-row mb-4">
                            <div class="col">
                                <input type="text" id="cap" name="cap" class="form-control" placeholder="CAP" value="<?php echo $_SESSION['grotto']['cap']; ?>">
                                <div id="error-cap" class="alert alert-danger" role="alert" >Inserire un CAP valido</div>
                            </div>
                            <div class="col">
                                <input type="text" id="paese" name="paese" class="form-control" placeholder="Paese" value="<?php echo $_SESSION['grotto']['paese']; ?>">
                                <div id="error-paese" class="alert alert-danger" role="alert" >Inserire un paese valido</div>
                            </div>
                        </div>
                        <div class="form-row mb-4">
                            <div class="col">
                                <input type="text" id="via" name="via" class="form-control" placeholder="Via" value="<?php echo $_SESSION['grotto']['via']; ?>">
                                <div id="error-via" class="alert alert-danger" role="alert" >Inserire una via valido</div>
                            </div>
                            <div class="col">
                                <input type="text" id="no_civico" name="no_civico" class="form-control" placeholder="Numero Civico" value="<?php echo $_SESSION['grotto']['no_civico']; ?>">
                                <div id="error-no_civico" class="alert alert-danger" role="alert" >Inserire un numero civico valido</div>
                            </div>
                        </div>

                        <input type="text" id="telefono" name="telefono" class="form-control mb-4" placeholder="Telefono" value="<?php echo $_SESSION['grotto']['telefono']; ?>">
                        <div id="error-telefono" class="alert alert-danger" role="alert" >Inserire un telefono valido</div>

                        <select name="fascia_prezzo" id="fascia_prezzo" class="mb-4 browser-default custom-select">
                            <?php foreach ($_SESSION['fasce_prezzo'] as $fascia_prezzo): ?>
                                <option value="<?php echo $fascia_prezzo['nome']; ?>"<?php if($fascia_prezzo['nome'] == $_SESSION['grotto']['fascia_prezzo']): ?>selected="selected"<?php endif; ?>><?php echo $fascia_prezzo['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <input type="hidden" id="lat" name="lat" value="">
                        <input type="hidden" id="lng" name="lng" value="">
                        <div class="form-row mb-4">
                            <div class="col">
                                <a href="<?php URL ?>gestione/updateGrotto/<?php echo $_SESSION['grotto']['id']; ?>" class="btn btn-warning my-4 btn-block" id="submit" type="button">Modifica</a>
                            </div>
                    <?php endif; ?>

                        <div class="col">
                            <a href="<?php URL ?>gestione/back" class="btn btn-info my-4 btn-block" type="button">Annulla</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>