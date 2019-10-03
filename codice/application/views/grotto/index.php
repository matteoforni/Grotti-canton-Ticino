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
                    <p class="ml-2">Fascia di prezzo: <?php echo $grotto['fascia_prezzo']; ?><br>
                    Valutazione: <?php echo $grotto['valutazione']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>