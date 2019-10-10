<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="my-5">
                <h1 class="h1 text-center">Grotto creato con successo!</h1>
                <?php if(isset($_SESSION['user'])): ?>
                    <?php if($_SESSION['user']['nome_ruolo'] == 'utente'): ?>
                        <h5 class="h5 text-center">La località verrà valutata da uno dei nostri admin, potrebbe volerci un pò di tempo</h5>
                    <?php endif; ?>
                <?php endif; ?>
                <a class="btn btn-info mt-5 text-center" href="<?php URL ?>home">Alla Home</a>
            </div>
        </div>
    </div>
</div>