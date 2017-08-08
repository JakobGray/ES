<?php

//connect to mysql db
try {
    $pdo = new PDO("mysql:host=localhost;dbname=autdb", "root", "MindSpec123");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

function get_tables() {
    global $pdo;
    try {
        // Get list of tables
        $query3 = "SHOW TABLES";
        $statement3 = $pdo->prepare($query3);
        $statement3->execute();
        $tablelist = $statement3->fetchAll(PDO::FETCH_ASSOC);
        $statement3->closeCursor();

        foreach ($tablelist as $table) {
            $result[] = $table['Tables_in_autdb'];
        }
        return $result;
    } catch (PDOException $e) {
        die("ERROR: Could not able to execute $query. " . $e->getMessage());
    }
}

function get_cols() {
    global $pdo;
    $lists;
    try {
        // Get list of tables
        $query3 = "SHOW TABLES";
        $statement3 = $pdo->prepare($query3);
        $statement3->execute();
        $tablelist = $statement3->fetchAll(PDO::FETCH_ASSOC);
        $statement3->closeCursor();

        foreach ($tablelist as $table) {
            $result[] = $table['Tables_in_autdb'];
        }

        foreach ($result as $table) {
            // Get columns of table
            $query = "DESCRIBE " . $table;

            $statement = $pdo->prepare($query);
            $statement->execute();
            $headers = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            
            foreach($headers as $header) {
                $lists[$table][] = $header['Field'];
            }
                    
        }
        return $lists;
    } catch (PDOException $e) {
        die("ERROR: Could not able to execute $query. " . $e->getMessage());
    }
}
