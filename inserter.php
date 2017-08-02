<?php

require_once 'app/init.php';

//connect to mysql db
try {
    $pdo = new PDO("mysql:host=localhost;dbname=pokemon", "root", "MindSpec123");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
//
//
////read the json file contents
//$jsondata = file_get_contents('skills.json');
//
////convert json object to php associative array
//$data = json_decode($jsondata, true, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
//
////print_r($data);
//
////get the employee details
//foreach($data as $move) {
//$accuracy = $move['accuracy'];
//$category = stripslashes($move['category']);
//$cname = stripslashes($move['cname']);
//$ename = $move['ename'];
//$id = $move['id'];
//$jname = stripslashes($move['jname']);
//$power = $move['power'];
//$pp = $move['pp'];
//$type = stripslashes($move['type']);
//
//try {
////insert into mysql table
//    $query = "INSERT INTO moves(id, name, accuracy, power, pp)
//    VALUES(:id, :ename, :accuracy, :power, :pp)";
//    
//    $statement = $pdo->prepare($query);
//            $statement->bindValue(':id', $id);
//            $statement->bindValue(':ename', $ename);
//            $statement->bindValue(':accuracy', $accuracy);
//            $statement->bindValue(':power', $power);
//            $statement->bindValue(':pp', $pp);
//            $statement->execute();
//            $statement->closeCursor();
//    
//} catch (PDOException $e) {
//    die("ERROR: Could not able to execute $query. " . $e->getMessage());
//}
//}
////connect to mysql db
//try {
//    $pdo = new PDO("mysql:host=localhost;dbname=pokemon", "root", "MindSpec123");
//    // Set the PDO error mode to exception
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
//    die("ERROR: Could not connect. " . $e->getMessage());
//}
//
//
try {
//insert into mysql table
    $query = "SELECT * FROM moves";

    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
} catch (PDOException $e) {
    die("ERROR: Could not able to execute $query. " . $e->getMessage());
}
foreach ($result as $move) {

    $indexed = $es->index([
        'index' => 'pokemon',
        'type' => 'moves',
        'id' => $move['id'],
        'body' => [
            'name' => $move['name'],
            'power' => $move['power'],
            'pp' => $move['pp'],
            'accuracy' => $move['accuracy']
        ]
    ]);

    if ($indexed) {
        print_r($indexed);
    }
}












////read the json file contents
//$jsondata = file_get_contents('pokedex.json');
//
////convert json object to php associative array
//$data = json_decode($jsondata, true);
//
//foreach ($data as $move) {
//    $name = $move['ename'];
//    $id = $move['id'];
//    $attack = $move['base']['Attack'];
//    $defense = $move['base']['Defense'];
//    $hp = $move['base']['HP'];
//    $spatk = $move['base']['Sp.Atk'];
//    $spdef = $move['base']['Sp.Def'];
//    $speed = $move['base']['Speed'];
////    $egg = $move['skills']['egg'];
////    $level_up = $move['skills']['level_up'];
////    $tm = $move['skills']['tm'];
////    $transfer = $move['skills']['transfer'];
////    $tutor = $move['skills']['tutor'];
//
//    $egg = isset($move['skills']['egg']) ? $move['skills']['egg'] : NULL;
//    $level_up = isset($move['skills']['level_up']) ? $move['skills']['level_up'] : NULL;
//    $tm = isset($move['skills']['tm']) ? $move['skills']['tm'] : NULL;
//    $transfer = isset($move['skills']['transfer']) ? $move['skills']['transfer'] : NULL;
//    $tutor = isset($move['skills']['tutor']) ? $move['skills']['tutor'] : NULL;
//
//    $indexed = $es->index([
//        'index' => 'pokemon',
//        'type' => 'pokemon',
//        'id' => $id,
//        'body' => [
//            'name' => $name,
//            'base' => [
//                'Attack' => $attack,
//                'Defense' => $defense,
//                'HP' => $hp,
//                'Sp.Atk' => $spatk,
//                'Sp.Def' => $spdef,
//                'Speed' => $speed,
//            ],
//            'skills' => [
//                'egg' => [$egg],
//                'level_up' => [$level_up],
//                'tm' => [$tm],
//                'transfer' => [$transfer],
//                'tutor' => [$tutor]
//            ]
//        ]
//    ]);
//}
?>