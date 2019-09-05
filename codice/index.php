<?php

// carico il file di configurazione
require 'application/config/config.php';

// carico le classi dell'applicazione
require 'application/libs/application.php';

// carico la classe che permette di caricare le view
require 'application/libs/viewloader.php';

// carico la classe che permette di mostrare le notifiche a schermo
require 'application/libs/notifier.php';

// carico le liberie di composer
require 'vendor/autoload.php';

// faccio partire il notifier
$GLOBALS["NOTIFIER"] = new Notifier();

// faccio partire l'applicazione
$app = new Application();