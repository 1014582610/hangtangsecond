<?php foreach ($videos as $video_item): ?>

	<h3><?php echo $video_item['title']; ?></h3>
	<div class = "main">
		<?php echo $video_item['address'] ?>
	</div>
	
<?php endforeach; ?>