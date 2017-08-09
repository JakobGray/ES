<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
            <select name="t" id="table">
                <option disabled selected value> -- select an option -- </option>
                <?php
                $tables = get_tables();
                foreach ($tables as $table) {
                    echo "<option value='" . $table . "'>" . $table . "</option>";
                }
                ?>
            </select>
            
            <select name="f" id="field">
  
            </select>

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
<script>
    $('#table').change(function () {
        var id = $(this).val(); //get the current value's option
        $.ajax({
            type: 'POST',
            url: 'change_select.php',
            data: {'id': id},
            success: function (data) {
                //in here, for simplicity, you can substitue the HTML for a brand new select box for countries
                //1.
                $("#field").html(data);

                //2.
                // iterate through objects and build HTML here
            }
        });
    });
</script>