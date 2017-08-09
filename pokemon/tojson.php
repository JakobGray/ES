<?php

$host    = 'localhost';
$db      = 'form';
$user    = 'root';
$pass    = 'MindSpec123';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        ];


$dbh = new PDO($dsn, $user, $pass, $opt);

$sql  = $dbh->query("SELECT * FROM article");
$rows = array();
while ($row = $sql->fetchall()) {
    $rows[] = $row;
}
//echo json_encode($rows, JSON_PRETTY_PRINT);
$art = 'articles.json';
$fp = fopen($art, 'w');
chmod($art, 0755);
fwrite($fp, json_encode($rows));
fclose($fp);


?>