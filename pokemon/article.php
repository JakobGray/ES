<?php
require '../app/init.php';

//try {
//    $pdo = new PDO("mysql:host=localhost;dbname=form", "user", "pass");
//    // Set the PDO error mode to exception
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
//    die("ERROR: Could not connect. " . $e->getMessage());
//}

if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $q = '*' . $q . '*';
    
    $params = [
        'index' => 'autdb',
        'type' => 'article',
        'size' => 50,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['wildcard' => ['title' => $q]]
                    ]
                ]
            ]
        ]
    ];
    
    $query = $es->search($params);
//    echo '<pre>' . json_encode($query, JSON_PRETTY_PRINT) . '</pre>';

    if ($query['hits']['total'] >= 1) {
        $results = $query['hits']['hits'];
    }
//    try {
////insert into mysql table
//        $q = '%' . $q . '%';
//        $query = "SELECT * FROM article where title LIKE :q";
//
//        $statement = $pdo->prepare($query);
//        $statement->bindValue(':q', $q);
//        $statement->execute();
//        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
//        $statement->closeCursor();
////        print_r($results);
//    } catch (PDOException $e) {
//        die("ERROR: Could not able to execute $query. " . $e->getMessage());
//    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="article.php" method="get">
            <label>
                Search for something
                <input type="text" name="q">
            </label>

            <input type="submit" value="Search">
        </form>

        <?php
        if (isset($results)) {
            foreach ($results as $r) {
                ?>
                <div class="result">
                    <?php
                    echo 'Title: ' . $r['_source']['title'] . '<br>';
//                    echo $r['title'];
                    ?>
                </div>
                <br>


                <?php
            }
        }
        ?>


    </body>
</html>