<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $updatedData = $_POST['newData'];
    echo $updatedData;
    // please validate the data you are expecting for security
    file_put_contents('./database.json', $updatedData);
    //return the url to the saved file
?>