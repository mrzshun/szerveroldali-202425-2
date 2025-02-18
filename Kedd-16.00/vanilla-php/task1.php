<?php

    function generateName() : string {
        $familyNames = ['Kovacs','Nagy','Szabo'];
        $givenNames = ['Istvan','Dorottya','Peter','Lujza'];
        return $familyNames[array_rand($familyNames)].' '.$givenNames[array_rand($givenNames)];
    }
    $name = generateName();

    function generateEmail($name) {
        $emailEndings = ['gmail.com','yahoo.com','freemail.com'];
        $nameArray = explode(' ',$name);
        return strtolower($nameArray[1].$nameArray[0])."@".$emailEndings[array_rand($emailEndings)];
    }
    $email = generateEmail($name);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo "Hello ".$name."!" ?></h1>
    <p>Your email address is <?php echo $email; ?></p>
</body>
</html>