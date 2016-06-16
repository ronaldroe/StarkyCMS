<?php 

include_once('../starkycms.php');

$output = new Starky;

?>

<!DOCTYPE html><html><head><title>PAGE</title></head><body>

<?php

$page = $output->get_page();

foreach ($page as $content): ?>

<h1><?php echo $content['title']; ?></h1>

<p><?php echo $content['content']; ?></p>

<?php endforeach; ?>

</body></html>