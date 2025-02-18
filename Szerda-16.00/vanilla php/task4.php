<?php
    require_once 'vendor/autoload.php';
    $filename = './data/blogdata.json';
    $fileExists = true;
    if(file_exists($filename)) {
        $posts = json_decode(file_get_contents($filename,true),true);
        $postById = null;
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            foreach($posts as $post) {
                if($post['id'] == $id) {
                    $postById = $post;
                }
            }
        }
    }
    else {
        $fileExists = false;
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
    <?php if($fileExists == false): ?>
        <h1>Nincs fájl!</h1>
    <?php else: ?>
        <?php if($postById == null): ?>
            <h1>Blogposztok listája:</h1>
            <?php foreach($posts as $post): ?>
                <h2><?=$post['title']?></h2>
                <p><?=$post['author']?></p>
                <p><?=$post['description']?></p>
                <p><a href="task4.php?id=<?=$post['id']?>" >More... </a></p>
            <?php endforeach; ?>
        <?php else: ?>
            <h1><?=$postById['title']?></h1>            
            <p><?=$postById['author']?></p>
            <p><?=$postById['description']?></p>
            <p><?=$postById['text']?></p>
            <p><a href="task4.php" >Back</a></p>
            <?php endif; ?>

    <?php endif; ?>
</body>
</html>