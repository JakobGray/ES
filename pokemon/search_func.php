<?php
require '../app/init.php';
include 'autdb_db.php';

if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $f = $_GET['f'];
    $t = $_GET['t'];

    $params = [
        'index' => 'autdb',
        'type' => $t,
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
        <h1>Search AUTDB database</h1>
        <form action="search_func.php" method="get">
            <select name="t">
                <?php
                $tables = get_tables();
                foreach ($tables as $table) {
                    echo "<option value='" . $table . "'>" . $table . "</option>";
                }
                ?>
            </select>

            <select name="f">
                <option value="gene_symbol">Gene Symbol</option>
            </select>

            <form id='pre_ajax' class='ajax' action = '.' method ='POST' accept-charset ='UTF-8' enctype ='multipart/form-data'>
                <fieldset>
                    <legend>Enter Article ID</legend>
                    <!--<input type = 'hidden' name = 'action' value = 'show_article_add'>-->

                    <label for = 'pmid' >PMID*:</label>
                    <input type = 'number' name = 'pmid' maxlength = '50'>

                    <input type = "submit" value = "Verify"/>
                </fieldset>
            </form>


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
                    echo 'Description: ' . $r['_source']["$f"] . '<br>';
                    ?>
                </div>
                <br>
                <?php
            }
        }
        ?>
    </body>
</html>