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

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>PHP Starter</title>
</head>

<body>
    <div class="layout">
        <div class="bar">
            <div class="user-card">
                <div class="user-image">
                    <img src="./assets/images/user_image.png" alt="User image" />
                </div>

            </div>
        </div>
        <div class="side">
            <div class="vertical-nav">
                <ul>
                    <li class="is-active"><a href="/">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>

        </div>
        <div class="content">
            <?php 
            if(isset($_POST) && ! empty($_POST)){
                $created_date = date('Y-m-d H:i:s');
                $user_insert_query = 'INSERT INTO Users ( name, email, password, created_at ) VALUES ( :name, :email,
                :password, :created_at )';
                $statement = $db->prepare($user_insert_query);
                
                $statement->bindParam(':name', $_POST['name']);
                $statement->bindParam(':email', $_POST['email']);
                $statement->bindParam(':password', $_POST['password']);
                $statement->bindParam(':created_at', $created_date);
                
                $statement->execute();

                 header('Location: /users.php');

            }
            ?>
            Add user
            <form method="post">
                <div>
                    <label for="name">Name: </label>
                    <input type="text" name="name" id="name" />
                </div>
                <div>
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email" />
                </div>
                <div>
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" />
                </div>
                <div>
                    <input type="submit" value="Submit">
                </div>
            </form>

        </div>
    </div>
</body>

</html>