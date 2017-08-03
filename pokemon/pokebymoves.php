<?php
require '../app/init.php';

if (isset($_GET['q'])) {
    $q = $_GET['q'];

    $params = [
        'index' => 'pokemon',
        'type' => 'moves',
        'size' => 500,
        'body' => [
            'query' => [
                'bool' => [
                    'must' => [
                        ['match_phrase' => ['name' => $q]]
                    ]
                ]
            ]
        ]
    ];

    $query = $es->search($params);

    if ($query['hits']['total'] == 1) {
        $preresults = $query['hits']['hits'];

        foreach ($preresults as $r) {
            $ids[] = $r['_id'];
        }


        foreach ($ids as $id) {
            $params2 = [
                'index' => 'pokemon',
                'type' => 'pokemon',
                'size' => 500,
                'body' => [
                    'query' => [
                        'bool' => [
                            'should' => [
                                ['match' => ['skills.egg' => $id]],
                                ['match' => ['skills.level_up' => $id]],
                                ['match' => ['skills.tm' => $id]],
                                ['match' => ['skills.transfer' => $id]],
                                ['match' => ['skills.tutor' => $id]]
                            ]
                        ]
                    ]
                ]
            ];

            $query2 = $es->search($params2);
//    echo '<pre>' . json_encode($query, JSON_PRETTY_PRINT) . '</pre>';

            if ($query2['hits']['total'] >= 1) {
                $results[] = $query2['hits']['hits'];
            }
        }
    } else if ($query['hits']['total'] > 1) {
        echo "Not specific enough";
    } else {
        echo "Move not found";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="pokebymoves.php" method="get">
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
                    foreach ($r as $poke) {
                        echo 'Pokemon: ' . $poke['_source']['name'] . '<br>';
                    }
                    ?>
                </div>
                <br>


                <?php
            }
        }
        ?>


    </body>
</html>

