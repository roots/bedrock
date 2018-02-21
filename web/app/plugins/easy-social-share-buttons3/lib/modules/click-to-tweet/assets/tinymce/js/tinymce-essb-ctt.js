( function() {
	tinymce.PluginManager.add( 'essb_ctt', function( editor, url ) {

		// Add a button that opens a window
		editor.addButton( 'essb_ctt', {

			text: '',
			tooltip: 'Easy Social Share Buttons: Click To Tweet',
			icon: 'essb-ctt-tweet',
			onclick: function() {
				// Open window
				editor.windowManager.open( {
					title: 'Easy Social Share Buttons: Click To Tweet Shortcode Generator',
					body: [
						{
							type: 'textbox',
							name: 'tweet',
							label: 'Tweetable Quote',
							multiline : true,
							minHeight : 60
						},
						{
							type: 'checkbox',
							checked: true,
							name: 'viamark',
							value: true,
							text: 'Add \"via @YourTwitterName\" to this tweet',
							label: 'Include "via"?',
						},
						{
							type: 'textbox',
							name: 'twitteruser',
							label: 'Via Twitter User'
						},
						{
							type: 'checkbox',
							checked: true,
							name: 'addhastags',
							value: true,
							text: 'Add \"#hashtag\" to this tweet',
							label: 'Include "hashtags"?',
						},
						{
							type: 'textbox',
							name: 'twitterhastags',
							label: 'Hashtags separated with , (comma)'
						},
						{
							type: 'textbox',
							name: 'url',
							label: 'Custom URL attached to quote:'
						},
						{
							type: 'textbox',
							name: 'image',
							label: 'Include image(pic.twitter.com/xxxx only)'
						},
						{
							type: 'listbox',
							name: 'template',
							label: 'Template',
							values: [
							   { text: 'Default (Blue)', value: ''},
							   { text: 'Light', value: 'light'},
							   { text: 'Dark', value: 'dark'},
							   { text: 'Quote', value: 'qlite' }
							]
						}

						
					],
					width: 620,
					height: 355,
					onsubmit: function( e ) {

						// bail without tweet text
						if ( e.data.tweet === '' ) {
							return;
						}

						// build my content
						var essbcttBuild   = '';

						// set initial
						essbcttBuild  += '[easy-tweet tweet="' + e.data.tweet + '"';

						// check for via
						if ( e.data.viamark === false ) {
							essbcttBuild  += ' via="no"';
						}
						
						if (e.data.twitteruser != '') {
							essbcttBuild += ' user="'+e.data.twitteruser+'"';
						}

						if ( e.data.addhastags === false ) {
							essbcttBuild  += ' usehashtags="no"';
						}
						
						if (e.data.twitterhastags != '') {
							essbcttBuild += ' hashtags="'+e.data.twitterhastags+'"';
						}
						if (e.data.url != '') {
							essbcttBuild += ' url="'+e.data.url+'"';
						}
						if (e.data.template != '') {
							essbcttBuild += ' template="'+e.data.template+'"';
						}
						if (e.data.image != '') {
							essbcttBuild += ' image="'+e.data.image+'"';
						}
						
						// close it up
						essbcttBuild  += ']';

						// Insert content when the window form is submitted
						editor.insertContent( essbcttBuild );
					}
				});
			}
		});
	});
})();