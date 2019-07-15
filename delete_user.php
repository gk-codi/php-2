<?php
try {
// Create (connect to) SQLite database in file
$db = new PDO( 'sqlite:db.sqlite3' );
// Set errormode to exceptions
$db->setAttribute( PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION );

// Create table users
$db->exec( "CREATE TABLE IF NOT EXISTS Users (
id integer NOT NULL CONSTRAINT Users_pk PRIMARY KEY,
name varchar(255) NOT NULL,
password text NOT NULL,
email text NOT NULL UNIQUE,
created_at datetime NOT NULL,
updated_at datetime NULL,
deleted_at datetime NULL
)" );
}
catch(PDOException $e){
die("Connection failed: " . $e->getMessage());
}

if(isset($_GET['id'])){
    $delete_query = 'DELETE FROM Users WHERE id= :id';
    $statement = $db->prepare($delete_query);

    $statement->bindParam(':id', $_GET['id']);
    $statement->execute();
    
    header('Location: /users.php');
}