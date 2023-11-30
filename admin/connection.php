<?php
    try{
        $conn = new PDO("mysql:host=localhost;dbname=BTTH01_CSE485","root","");
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>