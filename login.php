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

    public function appendData() {
        $n = $this->name;
        $p = $this->password;
        $token = hash('ripemd128', $p);

        $file = fopen('db.txt', 'a+');
        fwrite($file, $n . ";" . $token . ';');
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
            echo "<br>".$key;
        }
        var_dump($newDBArray);
        echo "<br>".$newDBArray['TimurBobylev'];
        return $newDBArray;
    }


}


if (isset($_POST['register']) && $_POST['name'] && $_POST['email']) {
    echo $_POST['register'] . " was clicked";
    $init = new NewUser(str_replace(' ', '', $_POST['name']), $_POST['email']);

    $usersDB = $init->storeData();
    echo "<br>".$usersDB . "<br>"."hjhjkkhjkhjkjhk"."<br>";
    echo gettype($usersDB), "\n";
    $init->createArray();

}





if
(isset($_POST['login'])) {
    echo $_POST['login'] . " was clicked";
}

?>
</body>
</html>

