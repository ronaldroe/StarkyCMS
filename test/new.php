<?php 
include_once('../starkycms.php');

$output = new Starky;

if($_POST){$output->new_post($_POST);}
 ?>

 <form action="" method="POST">
 	<input name="title" type="text" />
 	<textarea name="content"></textarea>
 	<input name="author_id" value="1" type="hidden" />
 	<input name="post_type" value="post" type="hidden" />
 	<input type="submit" value="submit" />
 </form>