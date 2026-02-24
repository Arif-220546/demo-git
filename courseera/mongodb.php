<?php

require __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

    // Select Database and Collection
    $db = $client->mydb;
    $usersCollection = $db->users;

} catch (Exception $e) {
    die("MongoDB Connection Failed: " . $e->getMessage());
}