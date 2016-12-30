<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
		name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('count'); ?>">No. of notices to display: </label>
	<input type="number" size="2" id="<?php echo $this->get_field_id('count'); ?>" 
		name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $count; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('type'); ?>">Type: </label>
	<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type') ?>">
		<option value="static" <?php selected( $type, 'static' );?> >Static</option>
		<option value="scroll" <?php selected( $type, 'scroll' );?> >Scroll</option>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('dir'); ?>">Direction: </label>
	<select id="<?php echo $this->get_field_id('dir'); ?>" name="<?php echo $this->get_field_name('dir') ?>">
		<option value="up" <?php selected( $dir, 'up' );?> >Upwards</option>
		<option value="down" <?php selected( $dir, 'down' );?> >Downwards</option>
	</select>
</p>