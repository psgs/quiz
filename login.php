<!DOCTYPE html>
<html>
    <?php
    include 'resources/header.php';
    ?>
    <body>
        <div class="container" style="margin-top: 80px">
            <form class="form-signin" role="form" action="" method="POST">
                <h2 class="form-signin-heading">Skriv in din grupp</h2>
                <input type="username" name="grupp" class="form-control" placeholder="Grupp" required="" autofocus="" autocomplete="off" style="margin-top: 20px">
                <div align="right"><button class="btn btn-primary " type="submit" name="subDoLoginAction" style="margin-top: 5px" >Logga in</button></div>

                <?php
                $config = parse_ini_file("config.ini");


                if (isset($_POST['subDoLoginAction'])) {

                    doLogin();
                }

                function doLogin() {
                    session_start();

                    $name = $_POST["grupp"];
                    $name = strtolower($name);
                    $enabled = true;

                    $url = $config['url'];
                    $user = $config['user'];
                    $password = $config['password'];
                    $db = $config['database'];
                    $table = $config['table'];
                    $q = 24;

                    if ($enabled) {
                        $connect = mysql_connect($url, $user, $password) or die("Connection problem.");
                        mysql_select_db($db) or die("Couldn't connect to the database");


                        $query = mysql_query("SELECT * FROM " . $table . " WHERE name='$name'");

                        $numrow = mysql_num_rows($query);

                        if ($numrow == 0) {

                            $s = array();
                            for ($i = 1; $i <= $q; $i++) {
                                $s[] = "`q" . $i . "`";
                            }

                            $sunq = implode(", ", $s);
                            $qs = "INSERT INTO `q_table` (`name`, " . $sunq . ") VALUES ('" . $name . "', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
                            echo $qs;
                            $query = mysql_query($qs);

                            //           header('Location: index.php');
                            $_SESSION['name'] = $name;
                        } else {
                            echo '<br><div class="alert alert-danger">Det finns redan en grupp med det namnet! </div>';
                        }
                    }
                }
                ?>
            </form>
        </div>
    </body>
</html>




