<?php 

include_once('starkycms.php');

$output = new Starky;

?>

<!DOCTYPE html><html><head><title><?php echo $output->starky_title(); ?></title></head><body>

<?php

$posts = $output->get_posts();

foreach ($posts as $post): ?>

<h1><?php echo $post['title']; ?></h1>

<p><?php echo $post['content']; ?></p>
<p><?php echo $post['author_name']; ?></p>
<p><?php echo $post['date_published']; ?></p>

<?php endforeach; ?>

</body>
</html>