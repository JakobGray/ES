<?php
require '../app/init.php';

if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $f = $_GET['f'];
//    $t = $_GET['t'];
    
    $params = [
        'index' => 'autdb',
        'type' => 'model_gene',
        'size' => 50,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => [$f => $q]]
                    ]
                ]
            ]
        ]
    ];
    
    $query = $es->search($params);
//    echo '<pre>' . json_encode($query, JSON_PRETTY_PRINT) . '</pre>';

    if ($query['hits']['total'] >= 1) {
        $results = $query['hits']['hits'];
    } else {
        echo "Nada";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="search_func.php" method="get">
<!--            <label>
                Table
                <input type="text" name="t">
            </label>-->
            <label>
                Field
                <input type="text" name="f">
            </label>
            <label>
                Query
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
                    echo 'ID: ' . $r['_id'] . '<br>';
                    echo 'Symbol: ' . $r['_source']['modelID'] . '<br>';
                    echo 'Description: ' . $r['_source']['construct_def'] . '<br>';
                    ?>
                </div>
                <br>


                <?php
            }
        }
        ?>


    </body>
</html>