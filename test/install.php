<?php

/*
 * Tecflare Corporation Property
 */

error_reporting(E_ALL);
/*
 * Tecflare Corporation Property
 */

    $host = "127.0.0.1";
    $username = "root";
    $password = "test";
    $database = "test";

//Verify Connection
$link = mysqli_connect($host, $username, $password, $database);
/* check connection */
if (mysqli_connect_errno()) {
    header('Location: index.php?error');
    die();
}
/* check if server is alive */
if (!mysqli_ping($link)) {
    header('Location: index.php?error');
    die();
}
$conn = new mysqli($hostname, $username, $password, $database);
 $sql = 'CREATE TABLE Administrators (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(1000),
password VARCHAR(1000)
)';
echo 'CREATE TABLE Administrators';
$conn->query($sql);
 $sql = 'CREATE TABLE Settings (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
code VARCHAR(1000),
value VARCHAR(1000)
)';
echo 'CREATE TABLE Settings';
$conn->query($sql);
 $sql = 'CREATE TABLE Storage (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(99999),
value TEXT
)';
echo 'CREATE TABLE Storage';
$conn->query($sql);
 $sql = 'CREATE TABLE Blockedips (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
blocked VARCHAR(99999),
value TEXT
)';
echo 'CREATE TABLE Blockedips';
$conn->query($sql);
 $sql = 'CREATE TABLE Posts (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(99999),
author VARCHAR(99999),
value TEXT
)';
echo 'CREATE TABLE Posts';
$conn->query($sql);
 $sql = 'CREATE TABLE Pages (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(99999),
value TEXT
)';
echo 'CREATE TABLE Pages';
$conn->query($sql);
 $sql = 'CREATE TABLE Items (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(99999),
cost VARCHAR(99999),
description TEXT
)';
echo 'CREATE TABLE Items';
$conn->query($sql);
 $sql = 'CREATE TABLE Orders (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
email VARCHAR(99999),
Products TEXT
)';
echo 'CREATE TABLE Orders';
 $sql = 'CREATE TABLE Comments (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(99999),
about TEXT
)';
echo 'CREATE TABLE Comments';
$conn->query($sql);
 $sql = 'CREATE TABLE dragdrop (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
value TEXT
)';
echo 'CREATE TABLE dragdrop';
$conn->query($sql);
 $sql = "CREATE TABLE Plugins (
filename varchar(127) collate utf8_bin default NULL,
		action tinyint(1) default '0',
		PRIMARY KEY  (`filename`)
)";
echo 'CREATE TABLE Plugins';
$conn->query($sql);
$sql = "INSERT INTO Administrators (id, usename, password) VALUES ('1', '".$conn->real_escape_string(addslashes($_POST['username_p']))."', '".md5($conn->real_escape_string(password_hash($_POST['password_p'], PASSWORD_BCRYPT)))."')";
$conn->query($sql);
$sql = "INSERT INTO Settings (id, code, value) VALUES ('1', 'title','Multisite Central')";
$conn->query($sql);
$sql = "INSERT INTO Settings (id, code, value) VALUES ('2', 'maintainanceMode','0')";
$conn->query($sql);
$sql = "INSERT INTO Settings (id, code, value) VALUES ('3', 'welcomemsg','Welcome to Multisite')";
$conn->query($sql);
$conn->query($sql);
$sql = "INSERT INTO Settings (id, code, value) VALUES ('4', 'mail','noemail@gmail.com')";
$conn->query($sql);
$sql = "INSERT INTO Settings (id, code, value) VALUES ('5', 'api','')";
$conn->query($sql);
$conn->close();
echo 'CREATED and FILLED tables COMPLETE!!!!';
$data = '<?php
            $hostname="'.$host.'";
            $username="'.$usename.'";
            $password="'.$password.'";
            $db_name="'.$database.'";
            ?>';
        $file = '../config.php';

        $handle = fopen($file, 'a');
        if (fwrite($handle, $data) === false) {
            echo 'Can not write to ('.$file.')';
        }

        fclose($handle);
header('Location: index.php?install');
die();
/* close connection */
mysqli_close($link);
echo 'Finished Writing Config';
