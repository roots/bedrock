<?php if(!($consumer_key && $consumer_secret && $access_token && $access_secret)): ?>
<p>
    All Twitter functionality must now be authenticated. To authenticate your blog, please visit the <a href="<?php echo get_bloginfo("siteurl") . "/wp-admin/options-general.php?page=oauthtwitter"; ?>" title="OAuth Twitter Settings">OAuth Twitter settings</a> page.
</p>
<?php endif; ?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo htmlentities($instance['title'], ENT_QUOTES); ?>" style="width:100%;" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'screen_name' ); ?>">Screen Name</label>
	<input id="<?php echo $this->get_field_id( 'screen_name' ); ?>" type="text" name="<?php echo $this->get_field_name( 'screen_name' ); ?>" value="<?php echo htmlentities($instance['screen_name'], ENT_QUOTES); ?>" style="width:100%;" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'count' ); ?>">How many tweets?</label>
	<input id="<?php echo $this->get_field_id( 'count' ); ?>" type="number" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo htmlentities($instance['count'], ENT_QUOTES); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'showdate' ); ?>">Show Date?</label>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'showdate' ); ?>" name="<?php echo $this->get_field_name( 'showdate' ); ?>" <?php echo ($instance['showdate']) ? 'checked="checked" ' : ''; ?>>
</p>
