<?php
    function generateName() : string {
        $familyNames = ['Kovacs','Szabo','Varga','Kiss'];
        $givenNames = ['Dorottya','Zoltan','Lujza','Peter'];
        return $familyNames[array_rand($familyNames)].' '. $givenNames[array_rand($givenNames)];
    }
    function generateEmail($name) : string {
        $emailEndings = ['gmail.com','yahoo.com','example.com'];
        $nameArray = explode(' ',$name);
        $simpleName = strtolower(substr($name[1],0,1).$nameArray[0]);
        $email = $simpleName.'@'. $emailEndings[array_rand($emailEndings)];
        return $email;
    }
    $name = generateName();
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
    <h1>Hello <?php echo $name?></h1>
    <p>Your email address is <?=$email?></p>
</body>
</html>