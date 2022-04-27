<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
<div class="center-container">
    <form action="" method="post">
        <input type="text" name="name" placeholder="Login">
        <input type="password" name="password" placeholder="Lösenord">
        <input name="login" type="submit" value="login">
        <input name="register" type="submit" value="register">
    </form>
</div>

<?php
session_start();

class NewUser
{
    public $name;
    public $password;
    public $dataDB;

    public function __construct($n, $p)
    {
        $this->name = $n;
        $this->password = $p;
    }

    public function storeData()
    {


        fopen('db.txt', 'a+');
        return $this->dataDB = file_get_contents("db.txt");


    }

    public function appendData()
    {
        $n = $this->name;
        $p = $this->password;
        $token = hash('ripemd128', $p);

        $file = fopen('db.txt', 'a+');
        fwrite($file, $n . ";" . $token . ';');
        return "<br>" . $n . $token . "<br>";
    }

    public function createArray()
    {
        $dataDB = $this->dataDB;

        $dbArray = explode(";", $dataDB);
        $newDBArray = array();

        while (count($dbArray)) {
            list($key, $value) = array_splice($dbArray, 0, 2);
            $newDBArray[$key] = $value;

        }


        return $newDBArray;
    }

    public function verifyUser($data, $name)
    {
        $p = $this->password;
        $token = hash('ripemd128', $p);

        if ($data[$name] == $token) {

            header("Location: index.php?");

        } else {
            echo '<footer><div class="error"><p class="error-message">Felaktigt användarnamn och/eller felaktigt lösenord</p></div> </footer>';
        }


    }

}


if (isset($_POST['register']) && $_POST['name'] && $_POST['password']) {
    $toLower = strtolower($_POST['name']);
    $withoutWhiteSpace = str_replace(' ', '', $toLower);
    $init = new NewUser($withoutWhiteSpace, $_POST['password']);
    $init->storeData();
    $dbArray = $init->createArray();
    if (array_key_exists($withoutWhiteSpace, $dbArray)) {
        echo '<footer><div ><p>'.'Användarnamn finns redan'.'</p></div></footer>';
    } else {
        echo '<footer><div ><p class="success">' . $_POST['name'] . " är registrerad som användare" . "</p></div></footer>  ";
        $init->appendData();
    }

}

if (isset($_POST['login']) && $_POST['name'] && $_POST['password']) {

    $toLower = strtolower($_POST['name']);

    $withoutWhiteSpace = str_replace(' ', '', $toLower);
    $init = new NewUser($withoutWhiteSpace, $_POST['password']);
    $init->storeData();
    $dbArray = $init->createArray();
    if (array_key_exists($withoutWhiteSpace, $dbArray)) {
        $init->verifyUser($dbArray, $withoutWhiteSpace) . "Name";
        $_SESSION["name"] = $_POST["name"];
        $_SESSION['home'] = $_SERVER['HTTP_HOST'];


    } else {
        echo '<footer><div ><p>'.'För att logga in, skapa ett konto'.'</p></div></footer>';


    }
}else{
    echo '<footer><div ><p>'.'Inget angett användarnamn eller lösenord'.'</p></div></footer>';
}


?>
</body>
</html>

