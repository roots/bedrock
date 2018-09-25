/*
* ---------------------------------------------------------------- 
*  Veented TinyMCE Quick Shortcodes Button
* ----------------------------------------------------------------  
*/

(function() {
	// Load plugin specific language pack

	tinymce.create('tinymce.plugins.vntdtinymce', {


		init : function(ed, url) {
			
			vntd_url = url;
			
			ed.addButton('vntd_shortcodes_button', {
				type: 'splitbutton',
				title : 'Add Custom Shortcode',
				tooltip: 'Quick Shortcodes',
				cmd : 'mcepshortcodes',
				onclick: function() {
	                ed.insertContent('Main button');
	            },
	            menu: [
	            {
	            	text: 'Buttons',
	            	menu: [
	            	{
	            	    text: 'Large Button',
	            	    onclick: function(){
	            	        ed.insertContent('[button label="Button text" url="#" color="accent, white, green, orange, red, blue, light-blue, dark, black" size="large"]');
	            	    }
	            	},	            	
	            	{
	            	    text: 'Standard Button',
	            	    onclick: function(){
	            	        ed.insertContent('[button label="Button text" url="#" color="accent, white, green, orange, red, blue, light-blue, dark, black"]');
	            	    }
	            	},
	            	{
	            	    text: 'Small Button',
	            	    onclick: function(){
	            	        ed.insertContent('[button label="Button text" url="#" color="accent, white, green, orange, red, blue, light-blue, dark, black" size="small"]');
	            	    }
	            	},
	            	{
	            	    text: 'Tiny Button',
	            	    onclick: function(){
	            	        ed.insertContent('[button label="Button text" url="#" color="accent, white, green, orange, red, blue, light-blue, dark, black" size="tiny"]');
	            	    }
	            	},
	            	{
	            	    text: 'Button with Icon',
	            	    onclick: function(){
	            	        ed.insertContent('[button label="Button text" url="#" icon="flag"]');
	            	    }
	            	}
	            	]                	
	            
	            },
                {
                	text: 'Separators',
                	menu: [
                	{
                	    text: 'Line Separator',
                	    onclick: function(){
                	        ed.insertContent('[separator]');
                	    }
                	},
                	{
                	    text: 'Separator with Text Label',
                	    onclick: function(){
                	        ed.insertContent('[separator label="Your Text" align="center"]');
                	    }
                	},
                	{
                	    text: 'White Space',
                	    onclick: function(){
                	        ed.insertContent('[spacer height="40"]');
                	    }
                	}
                	]                	
                
                },
            	{
            	    text: 'Highlight',
            	    menu: [
            	    {
            	        text: 'Accent Color',
            	        onclick: function(){
            	            ed.insertContent('[highlight]Highlighted text[/highlight]');
            	        }
            	    },
            	    {
            	        text: 'Custom Color',
            	        onclick: function(){
            	            ed.insertContent('[highlight bgcolor="#555" color="#ccc"]Highlighted text[/highlight]');
            	        }
            	    }
            	    ]
            	},
            	{
            	    text: 'Icon List',
            	    menu: [
            	    {
            	        text: 'No Background',
            	        onclick: function(){
            	            ed.insertContent('[list icon="check, heart, check-square, certificate, flag, plus, square-o, heart, caret-right" color="accent, dark"]<br/><br/>[li]List item[/li]<br/><br/>[li]List item[/li]<br/><br/>[li]List item[/li]<br/><br/>[/list]');
            	        }
            	    },
            	    {
            	        text: 'With Background',
            	        onclick: function(){
            	            ed.insertContent('[list icon="check, heart, check-square, certificate, flag, plus, square-o, heart, caret-right" background="yes" color="accent, dark"]<br/><br/>[li]List item[/li]<br/><br/>[li]List item[/li]<br/><br/>[li]List item[/li]<br/><br/>[/list]');
            	        }
            	    }
            	    ]
                
                },                                
                {
                	text: 'Social Icons',
                	menu: [
                	{
                	    text: 'Popular Icons',
                	    onclick: function(){
                	        ed.insertContent('[social_icons style="square, round" facebook="http://siteurl.com" twitter="" googleplus="" rss=""]');
                	    }
                	},
                	{
                	    text: 'All Available Icons',
                	    onclick: function(){
                	        ed.insertContent('[social_icons style="square, round" facebook="http://facebook.com" twitter="http://twitter.com" googleplus="" linkedin="" rss="" tumblr="" pinterest="" youtube="" email="" dribbble="" instagram=""]');
                	    }
                	}
                	]               
                
                },                                
                {
                	text: 'Progress Bars',
                	menu: [
                	{
                	    text: 'Accent Color',
                	    onclick: function(){
                	        ed.insertContent('[vc_progress_bar values="90|Development,80|Design,70|Marketing" bgcolor="accent"]');
                	    }
                	},
                	{
                	    text: 'Grey Color',
                	    onclick: function(){
                	        ed.insertContent('[vc_progress_bar values="90|Development,80|Design,70|Marketing" bgcolor="grey"]');
                	    }
                	}
                	]               
                
                }
	            ],
				image : 'shortcodes.png'
			});
			
			ed.addMenuItem('insertValueOfMyNewDropdown', {
			        icon: 'date',
			        text: 'Do something with this new dropdown',

			        context: 'insert'
			    });
			
		},

		getInfo : function() {
			return {
				longname : 'vntd_shortcodes_button',
				author : 'Veented',
				authorurl : 'http://themeforest.net/user/Veented/',
				infourl : 'http://www.tinymce.com/',
				version : "2.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('vntd_shortcodes_button', tinymce.plugins.vntdtinymce);
})();