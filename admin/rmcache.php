<?php

/*
 * Tecflare Corporation Property
 */

include 'functions/checkLogin.php';
unlink('../memory');
mkdir('../memory');
header('Location: settings.php');
