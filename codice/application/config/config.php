<?php

/**
 * Configurazione
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configurazione di : warning reporting
 * Utile per vedere tutti i piccoli problemi in fase di sviluppo, in produzione solo quelli gravi
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configurazione di : URL del progetto
 */
define('URL', 'http://10.20.143.204/Grotti-canton-Ticino/codice/');

/**
 * Configurazione del DSN per il database
 */
define('DSN', 'mysql:host=127.0.0.1;dbname=grotti;charset=utf8mb4');

/**
 * Configurazione del nome utente dell'account di mysql
 */
define('USER', 'grotti_user');

/**
 * Configurazione della password dell'account di mysql
 */
define('PASSWORD', 'GrottiUser&2019');

/**
 * Configurazione della chiave delle API di Google Maps/Geocoding
 */
define('API_KEY', 'AIzaSyAr7KuBtEj8NW_rUUOQT--axYuJ3D6VeeA');

/**
 * Configurazione dell'email del sito
 */
define('EMAIL', 'grottiticino@gmail.com');

/**
 * Configurazione del percorso di salvataggio delle immagini
 */
define('IMG_PATH', './application/assets/img/');