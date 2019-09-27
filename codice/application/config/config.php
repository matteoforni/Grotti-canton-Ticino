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
define('URL', 'http://localhost/Grotti-canton-Ticino/codice/');
define('DSN', 'mysql:host=127.0.0.1;dbname=grotti;charset=utf8mb4');
define('USER', 'grotti_user');
define('PASSWORD', 'GrottiUser&2019');
define('API_KEY', 'AIzaSyCCOSBrPiB40uF9Oee8IxwUdxoIZu_9XBg');