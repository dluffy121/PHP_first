<html>
    <head>
        <title>
            User's Page
        </title>
    </head>
    <body>
        <?php
        session_start();
        session_unset();
        session_destroy();
        ?>
        <center>
            <h1>
                Deleted account 
            </h1>
            <input type="button" onclick="location.href = 'Start.php'" value="Home">
        <center>
    </body>
</html>