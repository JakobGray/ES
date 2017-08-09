<?php

require_once '../app/init.php';

//connect to mysql db
try {
    $pdo = new PDO("mysql:host=localhost;dbname=autdb", "root", "MindSpec123");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}


try {
    // Get list of tables
    $query3 = "SHOW TABLES";
    $statement3 = $pdo->prepare($query3);
    $statement3->execute();
    $tablelist = $statement3->fetchAll(PDO::FETCH_ASSOC);
    $statement3->closeCursor();

    foreach ($tablelist as $table) {
        // Get columns of table
        $query = "DESCRIBE " . $table['Tables_in_autdb'];

        $statement = $pdo->prepare($query);
        $statement->execute();
        $headers = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        // Get all entries of table
        $query2 = "SELECT * FROM " . $table['Tables_in_autdb'];

        $statement2 = $pdo->prepare($query2);
        $statement2->execute();
        $result = $statement2->fetchAll(PDO::FETCH_ASSOC);
        $statement2->closeCursor();


        foreach ($result as $index => $res) {
            // Create array of column names of table
            $obj = array();
            foreach ($headers as $col) {
                $obj[$col['Field']] = $res[$col['Field']];
            }

            $indexed = $es->index([
                'index' => 'autdb',
                'type' => $table['Tables_in_autdb'],
                'body' => $obj
            ]);
        }
    }
} catch (PDOException $e) {
    die("ERROR: Could not able to execute $query. " . $e->getMessage());
}