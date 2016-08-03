<?php 

include_once('../starkycms.php');

$output = new Starky;

?>

<!DOCTYPE html><html><head><title>PAGE</title></head><body>

<?php

$content = $output->get_posts(/*['post_id' => 2]*/); ?>

<h1><?php echo $content['title']; ?></h1>

<p><?php echo $content['content']; ?></p>

<h1>RAW OUTPUT</h1>

<pre>
	<?php print_r( $content ); ?>
</pre>

</body></html>