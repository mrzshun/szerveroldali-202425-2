<?php
    require_once 'vendor/autoload.php';
    $faker = Faker\Factory::create();
    $blogposts = [];
    for($i=0; $i<100; $i++) {
        $blogposts[$i] = [
            'id'            => $faker->randomNumber(5,true),
            'title'         => $faker->sentence(),
            'description'   => $faker->sentences(3,true),
            'text'          => $faker->paragraphs(5,true),
            'author'        => $faker->name(),
        ];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Blogposts:</h1>
    <pre>
        <?php
            echo json_encode($blogposts,JSON_PRETTY_PRINT);
        ?>
    </pre>
</body>
</html>