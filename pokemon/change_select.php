<?php 
include 'autdb_db.php';
$id = $_POST['id'];

if(isset($id)) {
    $list = get_cols();
    foreach($list[$id] as $name) {
        echo "<option value='" . $name . "'>" . $name . "</option>";
    }
}