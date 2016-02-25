<?php

/*
 * Tecflare Corporation Property
 */

class Blog
{
    public function add_post($name, $value, $author)
    {
        include '../config.php';
        $conn = new mysqli($hostname, $usename, $password, $database);
        $sql = "INSERT INTO Posts (id, name, author, value) VALUES ('".rand(1, 99999)."', '".$name."','".$author."','".$value."')";
        $conn->query($sql);
        $conn->close();
    }

    public function remove_post($name)
    {
        include '../config.php';
        $conn = new mysqli($hostname, $usename, $password, $database);
        $sql = "DELETE FROM Posts WHERE name='".$name."'";
        $conn->query($sql);
        $conn->close();
    }
}
class Store
{
    public function new_product($name, $desc, $price)
    {
        include '../config.php';
        $conn = new mysqli($hostname, $usename, $password, $database);
        $sql = "INSERT INTO Items (id, name, cost, description) VALUES ('".rand(1, 99999)."', '".$name."','".$price."','".$desc."')";
        $conn->query($sql);
        $conn->close();
    }

    public function remove_product($name)
    {
        include '../config.php';
        $conn = new mysqli($hostname, $usename, $password, $database);
        $sql = "DELETE FROM Items WHERE name='".$name."'";
        $conn->query($sql);
        $conn->close();
    }
}
class Users
{
    public function new_user($user, $pass)
    {
        include '../config.php';
        $conn = new mysqli($hostname, $usename, $password, $database);
        $sql = "INSERT INTO Administrators (id, username, password) VALUES ('".rand(1, 99999)."', '".$user."','".md5($pass)."')";
        $conn->query($sql);
        $conn->close();
    }

    public function remove_user($user)
    {
        include '../config.php';
        $conn = new mysqli($hostname, $usename, $password, $database);
        $sql = "DELETE FROM Administrators WHERE username='".$user."'";
        $conn->query($sql);
        $conn->close();
    }
}
