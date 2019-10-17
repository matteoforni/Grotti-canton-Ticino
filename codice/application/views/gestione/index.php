<?php if(isset($_SESSION['user']) && $_SESSION['user']['nome_ruolo'] == 'admin' && (isset($_SESSION['grotto']) || isset($_SESSION['utente']))): ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="my-5">
                <?php if(isset($_SESSION['utente'])): ?>

                <?php elseif ($_SESSION['grotto']): ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>