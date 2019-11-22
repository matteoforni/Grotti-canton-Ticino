<?php if(isset($_SESSION['user']) && $_SESSION['user']['nome_ruolo'] == 'admin' && isset($_SESSION['grotti']) && isset($_SESSION['grotti_validati']) && isset($_SESSION['users']) && isset($_SESSION['immagini'])): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="my-5 text-center">
                    <h1 class="h1 d-block">Amministrazione grotti Ticino</h1>
                    <h6 class="h6">Connesso come: <?php echo $_SESSION['user']['nome'] . " " . $_SESSION['user']['cognome'] . " (" .$_SESSION['user']['username'] . ")" ?></h6>
                    <ul class="list-group list-group-horizontal list-group-flush">
                        <li class="list-group-item ml-auto"><a data-smoothie class="text-dark" href="#utenti">Utenti</a></li>
                        <li class="list-group-item"><a data-smoothie class="text-dark" href="#grotti">Grotti</a></li>
                        <li class="list-group-item"><a data-smoothie class="text-dark" href="#inserimenti">Inserimenti</a></li>
                        <li class="list-group-item mr-auto"><a data-smoothie class="text-dark" href="#immagini">Immagini</a></li>
                    </ul>
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
                                    <td><a href="<?php echo URL; ?>admin/updateUser/<?php echo $row['email']; ?>"><i class="fas fa-user-edit"></i></a></td>
                                    <td><a class="delete-utente" data-id="<?php echo $row['email']; ?>"><i class="fas fa-trash-alt"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="card col-md-4 offset-md-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">Aggiungi un utente</h5>
                                <p class="card-text">Aggiungi un nuovo utente, gli verrà inviata la password via email.</p>
                                <a class="card-link btn btn-info btn-sm" href="<?php echo URL; ?>newUser"><i class="fas fa-user-plus"></i></a>
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
                                <tr class="text-center table-row">
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
                                    <td><a href="<?php echo URL; ?>admin/updateGrotto/<?php echo $row['id']; ?>"><i class="fas fa-edit"></i></a></td>
                                    <td><a class="delete-grotto" data-id="<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="card col-md-4 offset-md-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">Aggiungi un grotto</h5>
                                <p class="card-text">Aggiungi un nuovo grotto tramite la pagina apposita.</p>
                                <a class="card-link btn btn-info btn-sm" href="<?php echo URL; ?>add"><i class="fas fa-map-marked-alt"></i></a>
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
                                <tr class="text-center table-row">
                                    <td><?php echo $row['nome']; ?></td>
                                    <td><?php echo($row['cap'] . " " . $row['paese'] . ", " .$row['via'] . " " . $row['no_civico']); ?></td>
                                    <td><?php echo $row['telefono']; ?></td>
                                    <td><?php echo $row['fascia_prezzo']; ?></td>
                                    <td><a href="<?php echo URL; ?>gestione/acceptGrotto/<?php echo $row['id']; ?>"><i class="fas fa-check-square"></i></a></td>
                                    <td><a class="delete-grotto" data-id="<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Sezione di gestione delle immagini -->
                    <div class="my-5" id="immagini">
                        <h3 class="h3-responsive">Gestione Immagini</h3>
                        <table id="img_table" class="table table-hover table-responsive-md">
                            <thead>
                            <tr class="text-center">
                                <th scope="col">ID</th>
                                <th scope="col">Path</th>
                                <th scope="col">Nome del Grotto</th>
                                <th scope="col">Elimina</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($_SESSION['immagini'] as $row): ?>
                                <tr class="text-center table-row click-row-img">
                                    <td class="click-elem-img" data-href="<?php echo $row['path']; ?>"><?php echo $row['id']; ?></td>
                                    <td class="click-elem-img" data-href="<?php echo $row['path']; ?>"><?php echo $row['path']; ?></td>
                                    <td class="click-elem-img" data-href="<?php echo $row['path']; ?>"><?php echo $_SESSION['grotti_validati'][array_search($row['grotto'], array_column($_SESSION['grotti_validati'], 'id'))]['nome']; ?></td>
                                    <td><a class="delete-img" data-id="<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale che mostra il bottone di conferma dell'eliminazione dell'utente -->
    <div class="modal fade" id="delete-utente-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-utente-label"><i class="fas fa-exclamation-triangle"></i> Attenzione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="modal-body-del-utente">Sei sicuro di volere eliminare l'utente?</h4>
                </div>
                <div class="modal-footer">
                    <a type="button" id="delete-utente-a" class="btn btn-danger" href="">Elimina</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale che mostra il bottone di conferma dell'eliminazione di un grotto -->
    <div class="modal fade" id="delete-grotto-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label"><i class="fas fa-exclamation-triangle"></i> Attenzione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Sei sicuro di voler eliminare il grotto?</h4>
                </div>
                <div class="modal-footer">
                    <a type="button" id="delete-grotto-a" class="btn btn-danger" href="">Elimina</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale che mostra il bottone di conferma dell'eliminazione di un immagine -->
    <div class="modal fade" id="delete-img-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label"><i class="fas fa-exclamation-triangle"></i> Attenzione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Sei sicuro di voler eliminare l'immagine?</h4>
                </div>
                <div class="modal-footer">
                    <a type="button" id="delete-img-a" class="btn btn-danger" href="">Elimina</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale che mostra l'immagine selezionata -->
    <div class="modal fade" id="img-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label-img"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modal-body-img" src="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var url =
            //Genero lo smooth scroll
            smoothie();

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
                    "sEmptyTable": "Nessun utente da mostrare"
                }
            });
            $('#grotti_table').DataTable({
                "searching": false,
                "bLengthChange": false,
                "info" : false,
                "iDisplayLength": 5,
                "oLanguage": {
                    "sEmptyTable": "Nessun grotto da mostrare"
                }
            });
            $('#ins_table').DataTable({
                "searching": false,
                "bLengthChange": false,
                "info" : false,
                "iDisplayLength": 5,
                "oLanguage": {
                    "sEmptyTable": "Nessun nuovo inserimento da mostrare"
                }
            });
            $('#img_table').DataTable({
                "searching": false,
                "bLengthChange": false,
                "info" : false,
                "iDisplayLength": 5,
                "oLanguage": {
                    "sEmptyTable": "Nessuna immagine da mostrare"
                }
            });
            $('.dataTables_length').addClass('bs-select');

            $('.delete-utente').click(function () {
                var val = "<?php echo URL; ?>" + "gestione/elimina/utente/" + $(this).data("id");
                $('#delete-utente-a').attr('href', val);
                $('#delete-utente-modal').modal();
            });

            $('.delete-grotto').click(function () {
                var val = "<?php echo URL; ?>" + "gestione/elimina/grotto/" + $(this).data("id");
                $('#delete-grotto-a').attr('href', val);
                $('#delete-grotto-modal').modal();
            });

            $('.delete-img').click(function () {
                var val = "<?php echo URL; ?>" + "gestione/elimina/immagine/" + $(this).data("id");
                $('#delete-img-a').attr('href', val);
                $('#delete-img-modal').modal();
            });

            $(".click-elem-img").click(function() {
                $('#modal-body-img').attr('src', $(this).data("href"));
                $('#modal-label-img').attr('content', $(this).data("href"));
                $('#img-modal').modal();
            });
        });
    </script>
<?php endif; ?>