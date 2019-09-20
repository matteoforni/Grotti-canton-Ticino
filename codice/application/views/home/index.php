    <div id="map" class="mt-5">

    </div>

    <div class="search my-5">
        <table class="table table-hover table-responsive-sm">
            <tr class="text-center">
                <th scope="col">Nome</th>
                <th scope="col">Via</th>
                <th scope="col">No. Civico</th>
                <th scope="col">Paese</th>
                <th scope="col">CAP</th>
                <th scope="col">Fascia di Prezzo</th>
                <th scope="col">Valutazione</th>
            </tr>
            <?php if(isset($_SESSION['grotti'])): ?>
                <?php foreach ($_SESSION['grotti'] as $row): ?>
                <tr class="text-center">
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['via']; ?></td>
                    <td><?php echo $row['no_civico']; ?></td>
                    <td><?php echo $row['paese']; ?></td>
                    <td><?php echo $row['cap']; ?></td>
                    <td><?php echo $row['fascia_prezzo']; ?></td>
                    <td><?php echo $row['valutazione']; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
    <script>
        let map;
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
                zoom: 7,
                center: center_loc,
                restriction: {
                    latLngBounds: tiBounds,
                    strictBounds: false
                },
            });
        }
    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCOSBrPiB40uF9Oee8IxwUdxoIZu_9XBg&callback=initMap">
    </script>
