<div id="map" class="mt-5">

</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="search my-5">
                <table id="search" class="table table-hover table-responsive-md">
                    <thead>
                    <tr class="text-center">
                        <th scope="col">Nome</th>
                        <th scope="col">Indirizzo</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Fascia di Prezzo</th>
                        <th scope="col">Valutazione</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($_SESSION['grotti'])): ?>
                        <?php foreach ($_SESSION['grotti'] as $row): ?>
                            <tr class="text-center click-row" data-href="<?php echo URL; ?>grotto/show/<?php echo $row['id']; ?>">
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
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function($) {
        //Imposto le opzioni
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


        $(".click-row").click(function() {
            window.location = $(this).data("href");
        });
    });

    let map;
    var infowindowOpen = null;
    function initMap() {
        let center_loc = {
            lat: 46.029898,
            lng: 8.962658
        };
        let tiBounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(45.796048, 8.344110),
            new google.maps.LatLng(46.539085, 9.470215)
        );
        map = new google.maps.Map(window.document.getElementById('map'), {
            zoom: 9,
            center: center_loc,
            restriction: {
                latLngBounds: tiBounds,
                strictBounds: false
            },
        });
        setMarkers(map,<?php echo json_encode($_SESSION["grotti"]); ?>);
        google.maps.event.addListener(map, "click", function(event) {
            if(infowindowOpen != null){
                infowindowOpen.close();
                map.setZoom(10);
                infowindowOpen = null;
            }
        });
    }
    $(document).ready(function () {
        $('#search').DataTable({
            "searching": false,
            "bLengthChange": false,
            "info" : false,
            "iDisplayLength": 15
        });
        $('.dataTables_length').addClass('bs-select');

    });

    function setMarkers(map, locations) {
        <?php foreach ($_SESSION['grotti'] as $row): ?>

        var contentString = `
                <div class='content modal-body'>
                    <h1 id="nome" style='color:black;'>  <?php echo $row['nome']; ?></h1>
                    <strong id="indirizzo">Indirizzo</strong> <?php echo(" " . $row['cap'] . " " . $row['paese'] . ", " .$row['via'] . " " . $row['no_civico']); ?>
                    <br><br>
                    <strong id="telefono">Telefono</strong><?php echo " " . $row['telefono']; ?>
                    <br><br>
                    <strong id="valutazione">Valutazione</strong>
                    <div class="rating-container">
                        <div id="valutazione" class="rating" data-rate-value=<?php echo $row['valutazione']; ?>></div>
                    </div>
                </div>`;

        var infowindow<?php echo $row['id']; ?> = new google.maps.InfoWindow({
            content: contentString
        });

        var luogo = {lat: <?php echo floatval($row['lat']); ?>, lng: <?php echo floatval($row['lon']); ?> };

        var marker<?php echo $row['id']; ?> = new google.maps.Marker({
            position: luogo,
            map: map,
            animation: google.maps.Animation.DROP,
            title: <?php echo "'" . $row['nome'] . "'"; ?>
        });

        marker<?php echo $row['id']; ?>.addListener('click', function() {

            if (infowindowOpen != null){
                infowindowOpen.close();
            }
            infowindow<?php echo $row['id']; ?>.open(map, marker<?php echo $row['id']; ?>);
            infowindowOpen = infowindow<?php echo $row['id']; ?>;

            map.setZoom(13);
            map.setCenter(marker<?php echo $row['id']; ?>.getPosition());
        });
        <?php endforeach; ?>
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo API_KEY ?>&callback=initMap">
</script>