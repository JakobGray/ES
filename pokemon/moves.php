<?php
require '../app/init.php';

if (isset($_GET['q'])) {
    $q = $_GET['q'];
    
    $params = [
        'index' => 'pokemon',
        'type' => 'moves',
        'size' => 50,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['name' => $q]],
                        ['match' => ['power' => $q]]
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
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="moves.php" method="get">
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
                    echo 'Title: ' . $r['_source']['name'] . '<br>';
                    echo 'ID: ' . $r['_id'] . '<br>';
                    echo 'Power: ' . $r['_source']['power'] . '<br>';
                    echo 'PP: ' . $r['_source']['pp'] . '<br>';
                    echo 'Accuracy: ' . $r['_source']['accuracy'];
                    ?>
                </div>
                <br>


                <?php
            }
        }
        ?>


    </body>
</html>