<!DOCTYPE html>
<?php
//require_once 'app/init.php';
//
//if (!empty($_POST)) {
//
//    if (isset($_POST['title'], $_POST['body'], $_POST['keywords'])) {
//
//        $title = $_POST['title'];
//        $body = $_POST['body'];
//        $keywords = explode(',', $_POST['keywords']);
//
//        $indexed = $es->index([
//            'index' => 'articles',
//            'type' => 'article',
//            'body' => [
//                'title' => $title,
//                'body' => $body,
//                'keywords' => $keywords
//            ]
//        ]);
//
//        if ($indexed) {
//            print_r($indexed);
//        }
//    }
//}
//?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<!--                <form class="form-group" action="." method="post">
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
                </form>

        <form action="." method="get">
            <label>
                Search for something
                <input type="text" name="q">
            </label>

            <input type="submit" value="Search">
        </form>-->
<ul>
<?php 
foreach (glob("pokemon/*") as $filename) {
    echo "<li><a href='{$filename}'>{$filename}</a></li>";
}
?>
</ul>
        

    </body>
</html>
