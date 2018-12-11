<?php
$default_options = array(
    // Splash Settings
	'splashPreloaderColor' => '7f2ae8',
    'columns' => '3',
	'thumbRecommendedSize' => '250',
	'coverThumbRatio' => '1',
	'spaceX' => '20',
	'coverTitleForBookmark' => 'My Bookmarks',
	'coverTitleForPreferred' => 'Preferred',
	'coverHoverEffectEnable' => '1',
	'coverTitleEnable' => '1',
	'coverTitleFontSize' => '30',
    'coverTitleTextColor' => 'ffffff',
	'coverCollectoinAmount' => '1',
	'coverSocialShareEnabled' => '1',
    'coverTitleBgColor1' => 'CD51DC',
	'coverTitleBgColor2' => '295EE6',
    'coverTitleBgAlpha' => '60',
	// Collection Page
	'collectionPreloaderColor' => '7f2ae8',
	'collectionBgColor' => 'f4f4f4',
	'collectionHeaderBgColor' => 'ffffff',
	'collectionHeaderTextColor' => '000000',
	'collectionHeaderControllIconColor' => 'ffffff',
	'collectionHeaderControllBgColor' => '7d7d7d',
	'collectionThumbRecomendedWidth' => '400',
	'collectionThumbInPadding' => '20',
	'collectionThumbTitleEnable' => '1',
	'collectionthumbHoverTitleFontSize' =>'18',
	'collectionthumbHoverTitleTextColor' => 'ffffff',
	'collectionThumbSubMenuVisibility' => '1',
	'collectionThumbSubMenuIconColor' => 'ffffff',
	'collectionthumbHoverBgColor' => '000000',
	'collectionthumbHoverBgAlpha' => '80',
    // Slider Page
    'sliderPreloaderColor' => 'ffffff',
	'sliderBgColor' => '000000',
	'sliderNavigationColor' => '000000',
	'sliderNavigationColorOpacity' => '70',
	'sliderNavigationIconColor' => 'ffffff',
	'sliderItemTitleFontSize' => '30',
	'sliderItemTitleTextColor' => 'ffffff',
	'sliderThumbBarEnable' => '1',
	'sliderInfoEnable' => '1',
	'sliderLikesEnabled' => '1',
	'sliderBookmarksEnabled' => '1',
    'sliderInfoBoxBgColor' => 'ffffff',
    'sliderInfoBoxBgAlpha' => '100',
	'sliderInfoBoxTitleTextColor' => '000000',
    'sliderInfoBoxTextColor' => '4f4f4f',
    'sliderItemDownload' => '1',
    'sliderItemDiscuss' => '1',
    'sliderSocialShareEnabled' => '1',
    // Custom CSS
    'customCSS' => ''
);
$options_tree = array(
    array('label' => 'Collections Page (Splash page)',
        'fields' => array(
	        'splashPreloaderColor' => array('label' => 'Preloader Color',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => 'Set custom color for gallery'
	        ),
	        'columns' => array('label' => 'Thumbnail Columns',
		        'tag' => 'input',
		        'attr' => 'type="number" min="1" max="10"',
		        'text' => 'Number of columns in a row'
	        ),
	        'thumbRecommendedSize' => array('label' => 'Minimum Thumbnail Width',
		        'tag' => 'input',
		        'attr' => 'type="number" min="100" max="300"',
		        'text' => 'The module will ignore the number of columns.'
	        ),
	        'coverThumbRatio' => array('label' => 'Thumbnail ratio',
		        'tag' => 'input',
		        'attr' => 'type="number" min="0.1" max="2" step="0.1"',
		        'text' => 'Height / Width = Ratio'
	        ),
	        'spaceX' => array('label' => 'Space between thumbnails',
		        'tag' => 'input',
		        'attr' => 'type="number" min="5" max="30"',
		        'text' => ''
	        ),
	        'coverHoverEffectEnable' => array('label' => 'Enable 3D hover effect',
		        'tag' => 'checkbox',
		        'attr' => 'data-watch="change"',
		        'text' => ''
	        ),
	        'coverTitleEnable' => array('label' => 'Show collection title',
		        'tag' => 'checkbox',
		        'attr' => 'data-watch="change"',
		        'text' => ''
	        ),
	        'coverTitleFontSize' => array('label' => 'Collection Title - font size',
		        'tag' => 'input',
		        'attr' => 'type="number" min="14" max="36" step="1" data-coverTitleEnable="is:1"',
		        'text' => ''
	        ),
	        'coverTitleTextColor' => array('label' => 'Collection Title - text color',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color" data-coverTitleEnable="is:1"',
		        'text' => ''
	        ),
	        'coverCollectoinAmount' => array('label' => 'Show the number of items in the collection',
		        'tag' => 'checkbox',
		        'attr' => 'data-watch="change"',
		        'text' => ''
	        ),
	        'coverSocialShareEnabled' => array('label' => 'Show share button for collection',
		        'tag' => 'checkbox',
		        'attr' => 'data-watch="change"',
		        'text' => ''
	        ),
	        'coverTitleBgColor1' => array('label' => 'Cover Hover color 1',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => 'For Albums / Categories covers - gradient color'
	        ),
	        'coverTitleBgColor2' => array('label' => 'Cover Hover color 2',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => 'For Albums / Categories covers - gradient color'
	        ),
	        'coverTitleBgAlpha' => array('label' => 'Cover Hover - transparency',
		        'tag' => 'input',
		        'attr' => 'type="number" min="0" max="100" step="10"',
		        'text' => 'For Albums / Categories covers'
	        ),
	        'coverTitleForBookmark' => array('label' => 'Label for Bookmarks Cover (My Bookmarks)',
		        'tag'   => 'input',
		        'attr'  => '',
		        'text'  => ''
	        ),
	        'coverTitleForPreferred' => array('label' => 'Label for Preferred Cover (Preferred)',
		        'tag'   => 'input',
		        'attr'  => '',
		        'text'  => ''
	        ),
        )
    ),
	array('label' => 'Collection Window Settings',
		'fields' => array(
			'collectionPreloaderColor' => array('label' => 'Preloader Color',
				'tag' => 'input',
				'attr' => 'type="text" data-type="color"',
				'text' => 'Set custom color for gallery'
			),
			'collectionBgColor' => array('label' => 'Collection Window color',
				'tag' => 'input',
				'attr' => 'type="text" data-type="color"',
				'text' => ''
			),
			'collectionHeaderBgColor' => array('label' => 'Header background color',
				'tag' => 'input',
				'attr' => 'type="text" data-type="color"',
				'text' => ''
			),
			'collectionHeaderTextColor' => array('label' => 'Header title and description - text color',
				'tag' => 'input',
				'attr' => 'type="text" data-type="color"',
				'text' => ''
			),
			'collectionHeaderControllIconColor' => array('label' => 'Header close button icon color',
				'tag' => 'input',
				'attr' => 'type="text" data-type="color"',
				'text' => ''
			),
			'collectionHeaderControllBgColor' => array('label' => 'Header close button background color',
				'tag' => 'input',
				'attr' => 'type="text" data-type="color"',
				'text' => ''
			),
			'collectionThumbRecomendedWidth' => array('label' => 'Thumbnail recommended Width',
				'tag' => 'input',
				'attr' => 'type="number" min="150" max="400"',
				'text' => ''
			),
			'collectionThumbInPadding' => array('label' => 'Space between thumbnails',
				'tag' => 'input',
				'attr' => 'type="number" min="0" max="20"',
				'text' => ''
			),
			'collectionThumbTitleEnable' => array('label' => 'Show thumbnails title',
				'tag' => 'checkbox',
				'attr' => 'data-watch="change"',
				'text' => ''
			),
			'collectionthumbHoverTitleFontSize' => array('label' => 'Thumbnails Title - font size scale',
				'tag' => 'input',
				'attr' => 'type="number" min="10" max="20" step="1" data-collectionThumbTitleEnable="is:1"',
				'text' => ''
			),
			'collectionthumbHoverTitleTextColor' => array('label' => 'Thumbnails Title - text color',
				'tag' => 'input',
				'attr' => 'type="text" data-type="color" data-collectionThumbTitleEnable="is:1"',
				'text' => ''
			),
			'collectionThumbSubMenuVisibility' => array('label' => 'Show thumbnails sub-menu',
				'tag' => 'checkbox',
				'attr' => 'data-watch="change"',
				'text' => 'Link & Like & Bookmark Buttons'
			),
			'collectionThumbSubMenuIconColor' => array('label' => 'Sub-menu button icon color',
				'tag' => 'input',
				'attr' => 'type="text" data-type="color" data-collectionThumbSubMenuVisibility="is:1"',
				'text' => ''
			),
			'collectionthumbHoverBgColor' => array('label' => 'Thumbnails hover color',
				'tag' => 'input',
				'attr' => 'type="text" data-type="color"',
				'text' => ''
			),
			'collectionthumbHoverBgAlpha' => array('label' => 'Thumbnails hover color - alpha channel',
				'tag' => 'input',
				'attr' => 'type="number" min="0" max="100" step="10"',
				'text' => ''
			)
		)
	),
    array('label' => 'Lightbox Settings',
        'fields' => array(
            'sliderBgColor' => array('label' => 'Slider Window Color',
                'tag' => 'input',
                'attr' => 'type="text" data-type="color"',
                'text' => 'Set the background color for the slider window'
            ),
	        'sliderPreloaderColor' => array('label' => 'Preloader Color',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => 'Set custom color for gallery'
	        ),
	        'sliderNavigationColor' => array('label' => 'Main Controls Color',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => 'Background Color'
	        ),
	        'sliderNavigationColorOpacity' => array('label' => 'Main Controls - transparency for background',
		        'tag' => 'input',
		        'attr' => 'type="number" min="10" max="100" step="10"',
		        'text' => ''
	        ),
	        'sliderNavigationIconColor' => array('label' => 'Main Controls Icon Color',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => 'Icon Color'
	        ),
	        'sliderItemTitleFontSize' => array('label' => 'Item Title - font size',
		        'tag' => 'input',
		        'attr' => 'type="number" min="14" max="36" step="1"',
		        'text' => ''
	        ),
	        'sliderItemTitleTextColor' => array('label' => 'Item Title - text color',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => ''
	        ),
	        'sliderThumbBarEnable' => array('label' => 'Show Thumbnails Bar',
		        'tag' => 'checkbox',
		        'attr' => 'data-watch="change"',
		        'text' => ''
	        ),
	        'sliderInfoEnable' => array('label' => 'Show Info Button',
                'tag' => 'checkbox',
                'attr' => 'data-watch="change"',
                'text' => 'Enable description bar for item'
            ),
            'sliderSocialShareEnabled' => array('label' => 'Show Share Buttons',
                'tag' => 'checkbox',
                'attr' => 'data-watch="change"',
                'text' => ''
            ),
	        'sliderLikesEnabled' => array('label' => 'Show Like Button',
		        'tag' => 'checkbox',
		        'attr' => 'data-watch="change"',
		        'text' => ''
	        ),
	        'sliderBookmarksEnabled' => array('label' => 'Show Bookmarks Button',
		        'tag' => 'checkbox',
		        'attr' => 'data-watch="change"',
		        'text' => ''
	        ),
            'sliderItemDownload' => array('label' => 'Show Download Button',
                'tag' => 'checkbox',
                'attr' => 'data-watch="change"',
                'text' => 'Download original file'
            ),
            'sliderItemDiscuss' => array('label' => 'Show Comments Button',
                'tag' => 'checkbox',
                'attr' => 'data-watch="change" ',
                'text' => ''
            ),
	        'sliderInfoBoxBgColor' => array('label' => 'Slider Info Bar background color',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => 'Set the background color for the slider window'
	        ),
	        'sliderInfoBoxBgAlpha' => array('label' => 'Slider Info Bar background - alpha channel ',
		        'tag' => 'input',
		        'attr' => 'type="number" min="0" max="100" step="10" ',
		        'text' => ''
	        ),
	        'sliderInfoBoxTitleTextColor' => array('label' => 'Slider Info Bar - Title color',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => ''
	        ),
	        'sliderInfoBoxTextColor' => array('label' => 'Slider Info Bar - Description color',
		        'tag' => 'input',
		        'attr' => 'type="text" data-type="color"',
		        'text' => ''
	        )
        )
    ),
    array('label' => 'Advanced Settings',
        'fields' => array('customCSS' => array('label' => 'Custom CSS',
            'tag' => 'textarea',
            'attr' => 'cols="20" rows="10"',
            'text' => 'You can enter custom style rules into this box if you\'d like. IE: <i>a{color: red !important;}</i>
                                                                      <br />This is an advanced option! This is not recommended for users not fluent in CSS... but if you do know CSS, 
                                                                      anything you add here will override the default styles'
        )
            /*,
            'loveLink' => array(
                'label' => 'Display LoveLink?',
                'tag' => 'checkbox',
                'attr' => '',
                'text' => 'Selecting "Yes" will show the lovelink icon (codeasily.com) somewhere on the gallery'
            )*/
        )
    )
);
