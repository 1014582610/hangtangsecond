
	
	<?php echo form_open_multipart(prep_url(site_url('/picture/add')));?>

	<label for="title">title</label>
    <textarea name="title"></textarea><br />

    <label for="text">page</label>
    <textarea name="page"></textarea><br />
	
	<input type="file" name="userfile" size="20" />

	<br /><br />
	
	<label for="text">description</label>
    <textarea name="description"></textarea><br />

	<input type="submit" value="upload" />

	</form>
	

