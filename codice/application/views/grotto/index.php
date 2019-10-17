<?php
if(isset($_SESSION['grotto']) && isset($_SESSION['img'])): ?>
    <?php
    $grotto = $_SESSION['grotto'];
    $img = $_SESSION['img'];
    $i = 0;
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="my-5">
                    <h1 class="h1 text-center"><?php echo $grotto['nome']; ?></h1>
                    <div class="my-5">
                        <!-- CAROUSEL -->
                        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($img as $item): ?>
                                    <?php if($i == 0): ?>
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src="<?php echo $item['path']; ?>" alt="<?php echo $item['titolo']; ?>">
                                        </div>
                                    <?php else: ?>
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="<?php echo $item['path']; ?>" alt="<?php echo $item['titolo']; ?>">
                                        </div>
                                    <?php endif; ?>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </div>
                            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="my-5">
                        <h5 class="h5">Contatti</h5>
                        <p class="ml-2">Telefono: <?php echo $grotto['telefono'] ?></p>
                    </div>
                    <div class="my-5">
                        <h5 class="h5">Dove siamo</h5>
                        <p class="ml-2">
                            Indirizzo: <?php echo $grotto['cap'] . " " . $grotto['paese'] . " " . $grotto['via'] . " " . $grotto['no_civico']; ?>
                        </p>
                    </div>
                    <div class="my-5">
                        <h5 class="h5">Valutazioni</h5>
                        <p class="ml-2">Fascia di prezzo: <?php echo $grotto['fascia_prezzo']; ?></p>
                        <span class="ml-2">Valutazione:
                            <div class="rating-container-small ml-2">
                                <div id="valutazione" class="rating-small" data-rate-value=<?php echo $grotto['valutazione']; ?>></div>
                            </div>
                        </span>
                    </div>
                    <?php if(isset($_SESSION['user'])): ?>
                        <div class="my-5 col-md-6 offset-md-3">
                            <form method="post" class="mb-5 text-center border border-light p-5" action="<?php URL ?>grotto/vota">
                                <p class="h3 mb-2">Vota</p>
                                <p class="mb-4">Puoi votare un grotto solo una volta</p>
                                <input type="hidden" id="val" name="val" value="" />
                                <div class="rating-add-container">
                                    <div id="valutazione" name="valutazione" class="rating-add"></div>
                                </div>
                                <input class="btn btn-info mt-4" type="submit" id="submit">
                                <?php
                                if(isset($_SESSION['errors'])){
                                    foreach ($_SESSION['errors'] as $item) {
                                        echo "<p class='text-danger'>" . $item . "</p><br>";
                                    }
                                }
                                ?>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            //Imposto le opzioni per l'aggiunta di un voto
            var optionsAdd = {
                max_value: 5,
                step_size: 0.5,
            };

            //Istanzio la valutazione
            $(".rating-add").rate(optionsAdd);

            //Mantengo sempre centrate le stelle
            var margin = $('.rating-add-container').width()/2 - $('.rating-add').width()/2;
            $(".rating-add").css('margin-left', margin);
            $(window).resize(function () {
                var margin = $('.rating-add-container').width()/2 - $('.rating-add').width()/2;
                $(".rating-add").css('margin-left', margin);
            });

            $(".rating-add").click(function () {
                $("#val").val($(".rating-add").rate("getValue"));
            });

            //Imposto le opzioni per il rating readonly più piccolo
            var optionsSmall = {
                max_value: 5,
                step_size: 0.5,
                readonly: true,
            };

            //Istanzio la valutazione
            $(".rating-small").rate(optionsSmall);
        });
    </script>
<?php endif; ?>