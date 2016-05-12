<?php foreach ($pictures as $picture_item): ?>

	<h3><?php echo $picture_item['title']; ?></h3>
	<div class = "main">
		<?php echo $picture_item['address'] ?>
	</div>
	
<?php endforeach; ?>