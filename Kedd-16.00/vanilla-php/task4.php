<?php
    require_once 'vendor/autoload.php';
    $filename = './data/blogdata.json';
    $file_available = false;
    $postById = null;
    if(file_exists($filename)) {
        $file_available = true;
        $posts = json_decode(file_get_contents($filename,true),true);
        if(isset($_GET['id'])) {
            foreach($posts as $post) {
                if($post['id'] == $_GET['id']) {
                    $postById = $post;
                }
            }
        }
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
    <?php if(!$file_available): ?>
        <p>File does not exist</p>
    <?php else: ?>
        <?php if($postById == null): ?>
            <h1>All blogposts</h1>
            <?php foreach($posts as $post): ?>
                <h1><?=  $post['title'] ?></h1>

            <?php endforeach; ?>
        <?php else: ?>
            <h1><?php echo $postById['title'] ?></h1>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>