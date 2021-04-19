<?php
    require_once('assets/vendors/vendor/autoload.php');
    $google_client = new Google_Client();
    $google_client->setClientId('158567667651-kf38js0b6f7rb7u3s51eu2amgqs5jrqh.apps.googleusercontent.com');
    $google_client->setClientSecret('vAev39POfSodoZLqYIIeZlA1');
    $google_client->setRedirectUri('https://practicasueb.azurewebsites.net/index.php');
    $google_client->addScope('email');
    $google_client->addScope('profile');
?>