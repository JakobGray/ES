<!DOCTYPE html>
<?php
require_once 'app/init.php';

if (!empty($_POST)) {

    if (isset($_POST['title'], $_POST['body'], $_POST['keywords'])) {

        $title = $_POST['title'];
        $body = $_POST['body'];
        $keywords = explode(',', $_POST['keywords']);

        $indexed = $es->index([
            'index' => 'articles',
            'type' => 'article',
            'body' => [
                'title' => $title,
                'body' => $body,
                'keywords' => $keywords
            ]
        ]);

        if ($indexed) {
            print_r($indexed);
        }
    }
}

if (isset($_GET['q'])) {
    $q = $_GET['q'];

//    $params = [
//        'index' => 'pokemon',
//        'type' => 'moves',
//        'id' => $q
//    ];
//
//// Get doc at /my_index/my_type/my_id
//    $query = $es->get($params);
//    
//    echo '<pre>' . json_encode($query, JSON_PRETTY_PRINT) . '</pre>';
//    
//    if (sizeof($query['_source']) >= 1) {
//        $results = $query['_source'];
//    }

    $query = $es->search([
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
    ]);

//    echo '<pre>' . print_r($query) . '</pre>';

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
        <!--        <form class="form-group" action="." method="post">
                    <label>
                        Title
                        <input type="text" name="title">
                    </label>
                    <label>
                        Body
                        <textarea rows="5" name="body"></textarea>
                    </label>
                    <label>
                        Keywords
                        <input type="text" name="keywords">
                    </label>
                    <input type="submit" name="submit">
                </form>-->

        <form action="." method="get">
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
                echo 'Power: ' . $r['_source']['power'] . '<br>';
                echo 'PP: ' . $r['_source']['pp'] . '<br>';
                echo 'Accuracy: ' . $r['_source']['accuracy'];
                ?>
                <?php
//                echo 'Title: ' . $results['name'] . '<br>';
//                echo 'Power: ' . $results['power'] . '<br>';
//                echo 'PP: ' . $results['pp'] . '<br>';
//                echo 'Accuracy: ' . $results['accuracy'];
                ?>
                </div>
                <br>


        <?php
    }
}
?>


    </body>
</html>
