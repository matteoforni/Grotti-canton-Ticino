<?php if(isset($_SESSION['user']) && $_SESSION['user']['nome_ruolo'] == 'admin' && isset($_SESSION['grotti']) && isset($_SESSION['grotti_validati']) && isset($_SESSION['users'])): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="my-5 text-center">
                    <h1 class="h1 d-block">Amministrazione grotti Ticino</h1>
                    <h6 class="h6">Connesso come: <?php echo $_SESSION['user']['nome'] . " " . $_SESSION['user']['cognome'] . " (" .$_SESSION['user']['username'] . ")" ?></h6>
                    
                    <?php
                        if(isset($_SESSION['errors'])){
                            foreach ($_SESSION['errors'] as $error) {
                                echo "<p class='text-danger'>" . $error . "</p>";
                            }
                            unset($_SESSION['errors']);
                        }
                    ?>
                    
                    <!-- Sezione di gestione degli utenti -->
                    <div class="my-5" id="utenti">
                        <h3 class="h3-responsive">Gestione utenti</h3>

                        <table id="utenti_table" class="table table-hover table-responsive-md">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Email</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Cognome</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Ruolo</th>
                                    <th scope="col">Modifica</th>
                                    <th scope="col">Elimina</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($_SESSION['users'] as $row): ?>
                                <tr class="text-center table-row">
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['nome']; ?></td>
                                    <td><?php echo $row['cognome']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['nome_ruolo']; ?></td>
                                    <td><a type="button" class="btn btn-sm btn-warning" href="<?php echo URL; ?>admin/updateUser/<?php echo $row['email']; ?>">Modifica</a></td>
                                    <td><a type="button" class="btn btn-sm btn-danger" href="<?php echo URL; ?>gestione/elimina/utente/<?php echo $row['email']; ?>">Elimina</a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="card col-md-4 offset-md-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">Aggiungi un utente</h5>
                                <p class="card-text">Aggiungi un nuovo utente, gli verrà inviata la password via email.</p>
                                <a class="card-link btn btn-info btn-sm" href="<?php echo URL; ?>newUser">Aggiungi</a>
                            </div>
                        </div>
                    </div>

                    <!-- Sezione di gestione dei grotti -->
                    <div class="my-5" id="grotti">
                        <h3 class="h3-responsive">Gestione Grotti</h3>

                        <table id="grotti_table" class="table table-hover table-responsive-md">
                            <thead>
                            <tr class="text-center">
                                <th scope="col">Nome</th>
                                <th scope="col">Indirizzo</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Fascia di Prezzo</th>
                                <th scope="col">Valutazione</th>
                                <th scope="col">Modifica</th>
                                <th scope="col">Elimina</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($_SESSION['grotti_validati'] as $row): ?>
                                <tr class="text-center table-row" data-href="<?php echo URL; ?>admin/showGrotto/<?php echo $row['id']; ?>">
                                    <td><?php echo $row['nome']; ?></td>
                                    <td><?php echo($row['cap'] . " " . $row['paese'] . ", " .$row['via'] . " " . $row['no_civico']); ?></td>
                                    <td><?php echo $row['telefono']; ?></td>
                                    <td><?php echo $row['fascia_prezzo']; ?></td>
                                    <td>
                                        <p class="hidden"><?php echo $row['valutazione']; ?></p>
                                        <div class="rating-container-small">
                                            <div id="valutazione" class="rating" data-rate-value=<?php echo $row['valutazione']; ?>></div>
                                        </div>
                                    </td>
                                    <td><a type="button" class="btn btn-sm btn-warning" href="<?php echo URL; ?>admin/updateGrotto/<?php echo $row['id']; ?>">Modifica</a></td>
                                    <td><a type="button" class="btn btn-sm btn-danger" href="<?php echo URL; ?>gestione/elimina/grotto/<?php echo $row['id']; ?>">Elimina</a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="card col-md-4 offset-md-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">Aggiungi un grotto</h5>
                                <p class="card-text">Aggiungi un nuovo grotto tramite la pagina apposita.</p>
                                <a class="card-link btn btn-info btn-sm" href="<?php echo URL; ?>add">Aggiungi</a>
                            </div>
                        </div>
                    </div>

                    <!-- Sezione di gestione degli inserimenti -->
                    <div class="my-5" id="inserimenti">
                        <h3 class="h3-responsive">Gestione Inserimenti</h3>
                        <table id="ins_table" class="table table-hover table-responsive-md">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Nome</th>
                                    <th scope="col">Indirizzo</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Fascia di Prezzo</th>
                                    <th scope="col">Accetta</th>
                                    <th scope="col">Elimina</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($_SESSION['grotti'] as $row): ?>
                                <tr class="text-center table-row" data-href="<?php echo URL; ?>admin/showGrotto/<?php echo $row['id']; ?>">
                                    <td><?php echo $row['nome']; ?></td>
                                    <td><?php echo($row['cap'] . " " . $row['paese'] . ", " .$row['via'] . " " . $row['no_civico']); ?></td>
                                    <td><?php echo $row['telefono']; ?></td>
                                    <td><?php echo $row['fascia_prezzo']; ?></td>
                                    <td><a type="button" class="btn btn-sm btn-warning" href="<?php echo URL; ?>gestione/acceptGrotto/<?php echo $row['id']; ?>">Accetta</a></td>
                                    <td><a type="button" class="btn btn-sm btn-danger" href="<?php echo URL; ?>gestione/elimina/grotto/<?php echo $row['id']; ?>">Elimina</a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            //Imposto le opzioni della valutazione
            var options = {
                max_value: 5,
                step_size: 0.5,
                readonly: true,
            };

            //Istanzio la valutazione
            $(".rating").rate(options);

            //Mantengo sempre centrate le stelle
            var margin = $('.rating-container-small').width()/2 - $('.rating').width()/2;
            $(".rating").css('margin-left', margin);
            $(window).resize(function () {
                var margin = $('.rating-container-small').width()/2 - $('.rating').width()/2;
                $(".rating").css('margin-left', margin);
            });

            //Genero le datatables con i loro attributi
            $('#utenti_table').DataTable({
                "searching": false,
                "bLengthChange": false,
                "info" : false,
                "iDisplayLength": 5,
                "oLanguage": {
                    "sEmptyTable": "Nessun dato da mostrare"
                }
            });
            $('#grotti_table').DataTable({
                "searching": false,
                "bLengthChange": false,
                "info" : false,
                "iDisplayLength": 5,
                "oLanguage": {
                    "sEmptyTable": "Nessun dato da mostrare"
                }
            });
            $('#ins_table').DataTable({
                "searching": false,
                "bLengthChange": false,
                "info" : false,
                "iDisplayLength": 5,
                "oLanguage": {
                    "sEmptyTable": "Nessun dato da mostrare"
                }
            });
            $('.dataTables_length').addClass('bs-select');

        });
    </script>
<?php endif; ?>