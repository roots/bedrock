jQuery(document).ready(function(){

function remove_gallery() {
	jQuery('#vntd-gallery-remove').live('click', function() {
		jQuery('#gallery_images').val('');
		jQuery('.vntd-gallery-thumbs img, .vntd-gallery-or').remove();
		jQuery('#vntd-gallery-add').text("Create Gallery");
		jQuery(this).hide();		
	});
}

remove_gallery();

wp.media.shibaMlibEditGallery = {
     
    frame: function() {
        if ( this._frame )
            return this._frame;
 
        var selection = this.select();
        this._frame = wp.media({
            id:         'my-frame',                
            frame:      'post',
            state:      'gallery-edit',
            title:      wp.media.view.l10n.editGalleryTitle,
            editing:    true,
            multiple:   true,
            toolbar:    'select',
            selection:  selection
        });
        
        this._frame.on( 'update', 
                       function() {
            var controller = wp.media.shibaMlibEditGallery._frame.states.get('gallery-edit');
            var library = controller.get('library');
            
            // Need to get all the attachment ids for gallery
            var ids = library.pluck('id');            
            var urls = library.pluck('url');

            // Remove the old thumbnails
            jQuery('.vntd-gallery-thumbs img').remove();
            
            // Update gallery IDs
         	jQuery('#gallery_images').val(ids);
         	jQuery('#vntd-gallery-add').text("Change Images");
         	jQuery('.insert-hide').hide();
         	jQuery('.insert-show').show();
         	
         	// Thumbs         	
        	var attachment_thumbs = selection.map( function( attachment ) {
        	          attachment = attachment.toJSON();
        	          console.log('attachment:', attachment);
        	          jQuery('.vntd-gallery-thumbs').append('<img src="'+attachment.sizes.thumbnail.url+'" alt>');
        	}).join(' ');
        	
        	// Show Thumbs
       	
            // send ids to server
            wp.media.post( 'shiba-mlib-gallery-update', {
                nonce:      wp.media.view.settings.post.nonce, 
                html:       wp.media.shibaMlibEditGallery.link,
                post_id:    wp.media.view.settings.post.id,
                ids:        ids
            }).done( function() {
                window.location = wp.media.shibaMlibEditGallery.link;
            });
         
        });
        return this._frame;
    },
 
    init: function() {
        jQuery('#vntd-gallery-add').live('click', function( event ) {
            event.preventDefault();
 
            wp.media.shibaMlibEditGallery.frame().open();
 
        });
    },
    
    // Gets initial gallery-edit images. Function modified from wp.media.gallery.edit
    // in wp-includes/js/media-editor.js.source.html
    select: function() {
        var shortcode = wp.shortcode.next( 'gallery', wp.media.view.settings.shibaMlib.shortcode ),
            defaultPostId = wp.media.gallery.defaults.id,
            attachments, selection;
     
        // Bail if we didn't match the shortcode or all of the content.
        if ( ! shortcode )
            return;
     
        // Ignore the rest of the match object.
        shortcode = shortcode.shortcode;
     
        if ( _.isUndefined( shortcode.get('id') ) && ! _.isUndefined( defaultPostId ) )
            shortcode.set( 'id', defaultPostId );
     
        attachments = wp.media.gallery.attachments( shortcode );
        selection = new wp.media.model.Selection( attachments.models, {
            props:    attachments.props.toJSON(),
            multiple: true
        });
         
        selection.gallery = attachments.gallery;
     
        // Fetch the query's attachments, and then break ties from the
        // query to allow for sorting.
        selection.more().done( function() {
            // Break ties with the query.
            selection.props.set({ query: false });
            selection.unmirror();
            selection.props.unset('orderby');
        });
     
        return selection;
    },    
    
}; 
    jQuery( wp.media.shibaMlibEditGallery.init );
    
});