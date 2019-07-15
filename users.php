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
    echo $e->getMessage();
}
$users_query = 'SELECT * FROM Users';
$users = $db->query( $users_query )->fetchAll();

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
            Users table
            <a href="/add_user.php">Add user</a>
            <table class="steelBlueCols">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
                <?php
            
                foreach($users as $item){
                    ?>
                <tr>
                    <td>
                        <?php echo $item['id']; ?>
                    </td>
                    <td><?php echo $item['name']; ?></td>
                    <td>
                        <?php echo $item['email']; ?>
                    </td>
                    <td>
                        <?php echo $item['created_at']; ?>
                    </td>
                    <td>
                        <?php echo $item['updated_at']?>
                    </td>
                    <td>
                        <a href="/edit_user.php?id=<?php echo $item['id'];?>">Edit</a><br>
                        <a href="/delete_user.php?id=<?php echo $item['id']; ?>">Delete</a>
                        <!-- <form action="/delete_user.php?id=<?php echo $item['id']; ?>" method="post">
                            <input type="hidden" name="form_type" value="delete_user">
                            <input type="submit" value="Delete">
                        </form> -->
                    </td>
                </tr>
                <?php
                }
                ?>
            </table>

        </div>
    </div>
</body>

</html>