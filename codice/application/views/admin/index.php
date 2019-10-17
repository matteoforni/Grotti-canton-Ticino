<?php if(isset($_SESSION['user']) && $_SESSION['user']['nome_ruolo'] == 'admin' && isset($_SESSION['grotti']) && isset($_SESSION['grotti_validati']) && isset($_SESSION['users'])): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="my-5 text-center">
                    <h1 class="h1 d-block">Amministrazione grotti Ticino</h1>
                    <h6 class="h6">Connesso come: <?php echo $_SESSION['user']['nome'] . " " . $_SESSION['user']['cognome'] . " (" .$_SESSION['user']['username'] . ")" ?></h6>

                    <!-- Sezione di gestione degli utenti -->
                    <div class="my-5">
                        <h3 class="h3-responsive">Gestione utenti</h3>
                        <input type="button" class="btn btn-info" value="Gestisci utenti" id="utenti">

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
                                <tr class="text-center table-row" data-href="<?php echo URL; ?>admin/showUser/<?php echo $row['email']; ?>">
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['nome']; ?></td>
                                    <td><?php echo $row['cognome']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['nome_ruolo']; ?></td>
                                    <td><button type="button" class="btn btn-sm btn-warning">Modifica</button></td>
                                    <td><button type="button" class="btn btn-sm btn-danger">Elimina</button></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Sezione di gestione dei grotti -->
                    <div class="my-5">
                        <h3 class="h3-responsive">Gestione Grotti</h3>
                        <input type="button" class="btn btn-info" value="Gestisci Grotti" id="grotti">

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
                                    <td><button type="button" class="btn btn-sm btn-warning">Modifica</button></td>
                                    <td><button type="button" class="btn btn-sm btn-danger">Elimina</button></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Sezione di gestione degli inserimenti -->
                    <div class="my-5">
                        <h3 class="h3-responsive">Gestione Inserimenti</h3>
                        <input type="button" class="btn btn-info" value="Gestisci inserimenti" id="inserimenti">

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
                                    <td><button type="button" class="btn btn-sm btn-success">Accetta</button></td>
                                    <td><button type="button" class="btn btn-sm btn-danger">Elimina</button></td>
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
            //Rendo le righe delle tabelle cliccabili grazie all'attributo data-href
            $(".table-row").click(function() {
                window.location = $(this).data("href");
            });

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

            //Nascondo le tabelle
            $('#utenti_table').hide();
            $('#grotti_table').hide();
            $('#ins_table').hide();

            //Al click del bottone utenti mostro la tabella relativa
            $('#utenti').click(function () {
                if($("#utenti_table").is(":visible")) {
                    $('#utenti_table').hide();
                    $('#utenti_table').find('thead').eq(1).hide();
                }else {
                    $('#utenti_table').show();
                }
            });

            //Al click del bottone grotti mostro la tabella relativa
            $('#grotti').click(function () {
                if($("#grotti_table").is(":visible")) {
                    $('#grotti_table').hide();
                }else {
                    $('#grotti_table').show();
                }
            });

            //Al click del bottone inserimenti mostro la tabella relativa
            $('#inserimenti').click(function () {
                if($("#ins_table").is(":visible")) {
                    $('#ins_table').hide();
                }else {
                    $('#ins_table').show();
                }
            });
        });
    </script>
<?php endif; ?>