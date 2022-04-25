<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <input type="text" name="name">
    <input type="email" name="email">
    <input name="login" type="submit" value="login">
    <input name="register" type="submit" value="register">
</form>
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
        echo "<br>" . $dataDB . "   create array";
        $dbArray = explode(";", $dataDB);
        $newDBArray = array();
        print_r($dbArray);
        while (count($dbArray)) {
            list($key, $value) = array_splice($dbArray, 0, 2);
            $newDBArray[$key] = $value;
            echo "<br>" . $key;
        }

        echo "<br>" . $newDBArray['TimurBobylev'];
        return $newDBArray;
    }

    public function verifyUser($data, $name)
    {
        $p = $this->password;
        $token = hash('ripemd128', $p);

        if ($data[$name] == $token) {
            echo "<br>";
            echo "<br>";
            echo "<p> $token Is euqal to " . $data[$name] . "<p/>";

        } else {
            echo "Felaktigt användarnamn och/eller felaktigt lösenord";
        }


    }

}


if (isset($_POST['register']) && $_POST['name'] && $_POST['email']) {
    echo $_POST['register'] . " was clicked";
    $withoutWhiteSpace = str_replace(' ', '', $_POST['name']);
    $init = new NewUser($withoutWhiteSpace, $_POST['email']);
    $init->storeData();
    $dbArray = $init->createArray();
    if (array_key_exists($withoutWhiteSpace, $dbArray)) {
        echo "Nickname is occupyed";
    } else {
        echo "Nickname is free";
        echo $init->appendData();
    }

}

if (isset($_POST['login']) && $_POST['name'] && $_POST['email']) {
    echo $_POST['login'] . " was clicked";
    $withoutWhiteSpace = str_replace(' ', '', $_POST['name']);
    $init = new NewUser($withoutWhiteSpace, $_POST['email']);
    $init->storeData();
    $dbArray = $init->createArray();
    if (array_key_exists($withoutWhiteSpace, $dbArray)) {
        $init->verifyUser($dbArray, $withoutWhiteSpace) . "Name";

    } else {
        echo "<p>Fel<p/>";


    }
}


?>
</body>
</html>

