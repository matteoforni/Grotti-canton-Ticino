<?php if(isset($_SESSION['fasce_prezzo'])): ?>
    <?php
    $fasce_prezzo = $_SESSION['fasce_prezzo'];
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="my-5">
                    <form method="post" class="text-center border border-light p-5" action="<?php URL ?>add/addGrotto">

                        <p class="h4 mb-4">Aggiungi un grotto</p>

                        <input type="text" id="name" name="name" class="form-control mb-4" placeholder="Nome" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['username']:null;  ?>">
                        <div id="error-name" class="alert alert-danger" role="alert">Inserire uno nome valido</div>

                        <div class="form-row mb-4">
                            <div class="col">
                                <input type="text" id="cap" name="cap" class="form-control" placeholder="CAP" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['firstname']:null;  ?>">
                                <div id="error-cap" class="alert alert-danger" role="alert" >Inserire un CAP valido</div>
                            </div>
                            <div class="col">
                                <input type="text" id="paese" name="paese" class="form-control" placeholder="Paese" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['lastname']:null;  ?>">
                                <div id="error-paese" class="alert alert-danger" role="alert" >Inserire un paese valido</div>
                            </div>
                        </div>
                        <div class="form-row mb-4">
                            <div class="col">
                                <input type="text" id="via" name="via" class="form-control" placeholder="Via" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['firstname']:null;  ?>">
                                <div id="error-via" class="alert alert-danger" role="alert" >Inserire una via valido</div>
                            </div>
                            <div class="col">
                                <input type="text" id="no_civico" name="no_civico" class="form-control" placeholder="Numero Civico" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['firstname']:null;  ?>">
                                <div id="error-no_civico" class="alert alert-danger" role="alert" >Inserire un numero civico valido</div>
                            </div>
                        </div>

                        <input type="text" id="telefono" name="telefono" class="form-control mb-4" placeholder="Telefono" value="<?php echo (isset($_SESSION['data']) && $_SESSION['data'] != null)?$_SESSION['data']['email']:null;  ?>">
                        <div id="error-telefono" class="alert alert-danger" role="alert" >Inserire un telefono valido</div>

                        <select name="fascia_prezzo" id="fascia_prezzo" class="mb-4 browser-default custom-select">
                            <option value="" disabled selected>Scegli una fascia di prezzo</option>
                            <?php foreach ($fasce_prezzo as $fascia_prezzo): ?>
                                <option value="<?php echo $fascia_prezzo['nome']; ?>"><?php echo $fascia_prezzo['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>


                        <p class="font-weight-bold">Valutazione: </p>

                        <input type="hidden" id="val" name="val" value="" />
                        <div class="rating-container">
                            <div id="valutazione" name="valutazione" class="rating"></div>
                        </div>

                        <input type="hidden" id="lat" name="lat" value="">
                        <input type="hidden" id="lng" name="lng" value="">

                        <div class="form-row mb-4">
                            <div class="col">
                                <p class="btn btn-info my-4 btn-block" id="submit"> Aggiungi </p>
                            </div>
                            <div class="col">
                                <button class="btn btn-info my-4 btn-block" type="submit" id="check">Verifica</button>
                            </div>
                        </div>

                        <?php
                        if(isset($_SESSION['errors'])){
                            foreach ($_SESSION['errors'] as $item) {
                                echo "<p class='text-danger'>" . $item . "</p><br>";
                            }
                        }
                        ?>
                    </form>
                    <div id="map">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<script src="./application/assets/js/grotto.js"></script>-->
    <script>
        var nocivico;
        var via;
        var paese;
        var cap;
        var submitInvoked = false;
        $(document).ready(function () {

            //Imposto le opzioni
            var options = {
                max_value: 5,
                step_size: 0.5,
            };

            //Istanzio la valutazione
            $(".rating").rate(options);

            //Ad ogni click setto come value dell'input nascosto val il valore della valutazione
            $(".rating").click(function () {
                var value = String($(".rating").rate("getValue"));
                $('#val').val(value);
            });

            //Mantengo sempre centrate le stelle
            var margin = $('.rating-container').width()/2 - $('.rating').width()/2;
            $(".rating").css('margin-left', margin);
            $(window).resize(function () {
                var margin = $('.rating-container').width()/2 - $('.rating').width()/2;
                $(".rating").css('margin-left', margin);
            });

            //Quando la pagina ha caricato completamente aggiungo i listener agli input.
            addGrottoListeners();
        });

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
            var geocoder = new google.maps.Geocoder();
            $('#submit').click(function () {
                submitInvoked = true;
                geocodeAddress(geocoder, map);
            });
            $('#check').click(function () {
                geocodeAddress(geocoder, map);
            });
        }

        //Al click di "verifica" prendo i valori dell'indirizzo
        $('#check').click(function () {
            nocivico = document.getElementById('no_civico').value;
            via = document.getElementById('via').value;
            paese = document.getElementById('paese').value;
            cap = document.getElementById('cap').value;
        });

        function submitForm(lat, long){
            $('#lat').val(lat);
            $('#lng').val(long);
            $('#submit').submit();
        }

        function geocodeAddress(geocoder, resultsMap) {
            var nazione = "Ticino, Switzerland";
            if(nocivico != '' && via != '' && paese != '' && cap != ''){
                var address = nocivico + "," + via + "," + paese + "," + cap + "," + nazione;
                geocoder.geocode({'address': address}, function (results, status) {
                    if (status === 'OK') {
                        resultsMap.setCenter(results[0].geometry.location);
                        marker = new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location
                        });
                        map.setZoom(16);
                        map.panTo(marker.position);
                        var lat = results[0].geometry.location.lat();
                        var lng = results[0].geometry.location.lng();
                        if(submitInvoked){
                            submitForm(lat, lng);
                        }
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo API_KEY ?>&callback=initMap">
    </script>
<?php endif; ?>

