<?php

//add_action('init','of_options');
add_action( 'init', 'of_options' );

if ( !function_exists( 'of_options' ) ) {
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories     = array();
		$of_categories_obj = get_categories( 'hide_empty=0' );
		foreach ( $of_categories_obj as $of_cat ) {
			$of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
		}
		$categories_tmp = array_unshift( $of_categories, "Select a category:" );
		
		//Access the WordPress Pages via an Array
		$of_pages     = array();
		$of_pages_obj = get_pages();
		foreach ( $of_pages_obj as $of_page ) {
			$of_pages[$of_page->ID] = $of_page->post_name;
			$of_id                  = $of_page->ID;
		}
		//$of_pages_tmp = array_unshift($of_id = $of_pages, "Select a page:");    
		
		
		
		
		//Testing 
		$of_options_select = array(
			 "one",
			"two",
			"three",
			"four",
			"five" 
		);
		$of_options_radio  = array(
			 "one" => "One",
			"two" => "Two",
			"three" => "Three",
			"four" => "Four",
			"five" => "Five" 
		);
		
		
		
		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets     = array();
		
		if ( is_dir( $alt_stylesheet_path ) ) {
			if ( $alt_stylesheet_dir = opendir( $alt_stylesheet_path ) ) {
				while ( ( $alt_stylesheet_file = readdir( $alt_stylesheet_dir ) ) !== false ) {
					if ( stristr( $alt_stylesheet_file, ".css" ) !== false ) {
						$alt_stylesheets[] = $alt_stylesheet_file;
					}
				}
			}
		}
		
		
		//Background Images Reader
		$bg_images_path = get_stylesheet_directory() . '/images/bg/'; // change this to where you store your bg images
		$bg_images_url  = get_template_directory_uri() . '/images/bg/'; // change this to where you store your bg images
		$bg_images      = array();
		
		if ( is_dir( $bg_images_path ) ) {
			if ( $bg_images_dir = opendir( $bg_images_path ) ) {
				while ( ( $bg_images_file = readdir( $bg_images_dir ) ) !== false ) {
					if ( stristr( $bg_images_file, ".png" ) !== false || stristr( $bg_images_file, ".jpg" ) !== false ) {
						$bg_images[] = $bg_images_url . $bg_images_file;
					}
				}
			}
		}
		
		$bg_images = array(
			 "none" => "None",
			"custom" => "Custom",
			"pattern1.png" => "Pattern 1",
			"pattern2.png" => "Pattern 2",
			"wood.jpg" => "Wood" 
		);
		
		global $smof_data;
		
		$sidebars_arr                    = array();
		$sidebars_arr['Default Sidebar'] = 'Default Sidebar';
		$sidebars                        = '';
		
		if ( !$smof_data )
			$smof_data = array();
		
		if ( array_key_exists( 'sidebar_generator', $smof_data ) ) {
			$sidebars = $smof_data['sidebar_generator'];
			
			if ( is_array( $sidebars ) ) {
				foreach ( $sidebars as $sidebar ) {
					$sidebars_arr[$sidebar['title']] = $sidebar['title'];
				}
			}
		}
		$blog_categories = get_categories();
		
		
		$google_font_array = array(
			 "none" => "Select a font",
			"Arial" => "Helvetica / Arial",
			"Abel" => "Abel",
			"Abril Fatface" => "Abril Fatface",
			"Aclonica" => "Aclonica",
			"Actor" => "Actor",
			"Adamina" => "Adamina",
			"Aguafina Script" => "Aguafina Script",
			"Aladin" => "Aladin",
			"Aldrich" => "Aldrich",
			"Alice" => "Alice",
			"Alike Angular" => "Alike Angular",
			"Alike" => "Alike",
			"Allan" => "Allan",
			"Allerta Stencil" => "Allerta Stencil",
			"Allerta" => "Allerta",
			"Amaranth" => "Amaranth",
			"Amatic SC" => "Amatic SC",
			"Andada" => "Andada",
			"Andika" => "Andika",
			"Annie Use Your Telescope" => "Annie Use Your Telescope",
			"Anonymous Pro" => "Anonymous Pro",
			"Antic" => "Antic",
			"Anton" => "Anton",
			"Arapey" => "Arapey",
			"Architects Daughter" => "Architects Daughter",
			"Arimo" => "Arimo",
			"Artifika" => "Artifika",
			"Arvo" => "Arvo",
			"Asset" => "Asset",
			"Astloch" => "Astloch",
			"Atomic Age" => "Atomic Age",
			"Aubrey" => "Aubrey",
			"Bangers" => "Bangers",
			"Bentham" => "Bentham",
			"Bevan" => "Bevan",
			"Bigshot One" => "Bigshot One",
			"Bitter" => "Bitter",
			"Black Ops One" => "Black Ops One",
			"Bowlby One SC" => "Bowlby One SC",
			"Bowlby One" => "Bowlby One",
			"Brawler" => "Brawler",
			"Bubblegum Sans" => "Bubblegum Sans",
			"Buda" => "Buda",
			"Butcherman Caps" => "Butcherman Caps",
			"Cabin Condensed" => "Cabin Condensed",
			"Cabin Sketch" => "Cabin Sketch",
			"Cabin" => "Cabin",
			"Cagliostro" => "Cagliostro",
			"Calligraffitti" => "Calligraffitti",
			"Candal" => "Candal",
			"Cantarell" => "Cantarell",
			"Cardo" => "Cardo",
			"Carme" => "Carme",
			"Carter One" => "Carter One",
			"Caudex" => "Caudex",
			"Cedarville Cursive" => "Cedarville Cursive",
			"Changa One" => "Changa One",
			"Cherry Cream Soda" => "Cherry Cream Soda",
			"Chewy" => "Chewy",
			"Chicle" => "Chicle",
			"Chivo" => "Chivo",
			"Coda Caption" => "Coda Caption",
			"Coda" => "Coda",
			"Comfortaa" => "Comfortaa",
			"Coming Soon" => "Coming Soon",
			"Contrail One" => "Contrail One",
			"Convergence" => "Convergence",
			"Cookie" => "Cookie",
			"Copse" => "Copse",
			"Corben" => "Corben",
			"Cousine" => "Cousine",
			"Coustard" => "Coustard",
			"Covered By Your Grace" => "Covered By Your Grace",
			"Crafty Girls" => "Crafty Girls",
			"Creepster Caps" => "Creepster Caps",
			"Crimson Text" => "Crimson Text",
			"Crushed" => "Crushed",
			"Cuprum" => "Cuprum",
			"Damion" => "Damion",
			"Dancing Script" => "Dancing Script",
			"Dawning of a New Day" => "Dawning of a New Day",
			"Days One" => "Days One",
			"Delius Swash Caps" => "Delius Swash Caps",
			"Delius Unicase" => "Delius Unicase",
			"Delius" => "Delius",
			"Devonshire" => "Devonshire",
			"Didact Gothic" => "Didact Gothic",
			"Dorsa" => "Dorsa",
			"Dr Sugiyama" => "Dr Sugiyama",
			"Droid Sans Mono" => "Droid Sans Mono",
			"Droid Sans" => "Droid Sans",
			"Droid Serif" => "Droid Serif",
			"EB Garamond" => "EB Garamond",
			"Eater Caps" => "Eater Caps",
			"Expletus Sans" => "Expletus Sans",
			"Fanwood Text" => "Fanwood Text",
			"Federant" => "Federant",
			"Federo" => "Federo",
			"Fjord One" => "Fjord One",
			"Fondamento" => "Fondamento",
			"Fontdiner Swanky" => "Fontdiner Swanky",
			"Forum" => "Forum",
			"Francois One" => "Francois One",
			"Gentium Basic" => "Gentium Basic",
			"Gentium Book Basic" => "Gentium Book Basic",
			"Geo" => "Geo",
			"Geostar Fill" => "Geostar Fill",
			"Geostar" => "Geostar",
			"Give You Glory" => "Give You Glory",
			"Gloria Hallelujah" => "Gloria Hallelujah",
			"Goblin One" => "Goblin One",
			"Gochi Hand" => "Gochi Hand",
			"Goudy Bookletter 1911" => "Goudy Bookletter 1911",
			"Gravitas One" => "Gravitas One",
			"Gruppo" => "Gruppo",
			"Hammersmith One" => "Hammersmith One",
			"Herr Von Muellerhoff" => "Herr Von Muellerhoff",
			"Holtwood One SC" => "Holtwood One SC",
			"Homemade Apple" => "Homemade Apple",
			"IM Fell DW Pica SC" => "IM Fell DW Pica SC",
			"IM Fell DW Pica" => "IM Fell DW Pica",
			"IM Fell Double Pica SC" => "IM Fell Double Pica SC",
			"IM Fell Double Pica" => "IM Fell Double Pica",
			"IM Fell English SC" => "IM Fell English SC",
			"IM Fell English" => "IM Fell English",
			"IM Fell French Canon SC" => "IM Fell French Canon SC",
			"IM Fell French Canon" => "IM Fell French Canon",
			"IM Fell Great Primer SC" => "IM Fell Great Primer SC",
			"IM Fell Great Primer" => "IM Fell Great Primer",
			"Iceland" => "Iceland",
			"Inconsolata" => "Inconsolata",
			"Indie Flower" => "Indie Flower",
			"Irish Grover" => "Irish Grover",
			"Istok Web" => "Istok Web",
			"Jockey One" => "Jockey One",
			"Josefin Sans" => "Josefin Sans",
			"Josefin Slab" => "Josefin Slab",
			"Judson" => "Judson",
			"Julee" => "Julee",
			"Jura" => "Jura",
			"Just Another Hand" => "Just Another Hand",
			"Just Me Again Down Here" => "Just Me Again Down Here",
			"Kameron" => "Kameron",
			"Kelly Slab" => "Kelly Slab",
			"Kenia" => "Kenia",
			"Knewave" => "Knewave",
			"Kranky" => "Kranky",
			"Kreon" => "Kreon",
			"Kristi" => "Kristi",
			"La Belle Aurore" => "La Belle Aurore",
			"Lancelot" => "Lancelot",
			"Lato" => "Lato",
			"League Script" => "League Script",
			"Leckerli One" => "Leckerli One",
			"Lekton" => "Lekton",
			"Lemon" => "Lemon",
			"Limelight" => "Limelight",
			"Linden Hill" => "Linden Hill",
			"Lobster Two" => "Lobster Two",
			"Lobster" => "Lobster",
			"Lora" => "Lora",
			"Love Ya Like A Sister" => "Love Ya Like A Sister",
			"Loved by the King" => "Loved by the King",
			"Luckiest Guy" => "Luckiest Guy",
			"Maiden Orange" => "Maiden Orange",
			"Mako" => "Mako",
			"Marck Script" => "Marck Script",
			"Marvel" => "Marvel",
			"Mate SC" => "Mate SC",
			"Mate" => "Mate",
			"Maven Pro" => "Maven Pro",
			"Meddon" => "Meddon",
			"MedievalSharp" => "MedievalSharp",
			"Megrim" => "Megrim",
			"Merienda One" => "Merienda One",
			"Merriweather" => "Merriweather",
			"Metrophobic" => "Metrophobic",
			"Michroma" => "Michroma",
			"Miltonian Tattoo" => "Miltonian Tattoo",
			"Miltonian" => "Miltonian",
			"Miss Fajardose" => "Miss Fajardose",
			"Miss Saint Delafield" => "Miss Saint Delafield",
			"Modern Antiqua" => "Modern Antiqua",
			"Molengo" => "Molengo",
			"Monofett" => "Monofett",
			"Monoton" => "Monoton",
			"Monsieur La Doulaise" => "Monsieur La Doulaise",
			"Montez" => "Montez",
			"Mountains of Christmas" => "Mountains of Christmas",
			"Mr Bedford" => "Mr Bedford",
			"Mr Dafoe" => "Mr Dafoe",
			"Mr De Haviland" => "Mr De Haviland",
			"Mrs Sheppards" => "Mrs Sheppards",
			"Muli" => "Muli",
			"Neucha" => "Neucha",
			"Neuton" => "Neuton",
			"News Cycle" => "News Cycle",
			"Niconne" => "Niconne",
			"Nixie One" => "Nixie One",
			"Nobile" => "Nobile",
			"Nosifer Caps" => "Nosifer Caps",
			"Nothing You Could Do" => "Nothing You Could Do",
			"Nova Cut" => "Nova Cut",
			"Nova Flat" => "Nova Flat",
			"Nova Mono" => "Nova Mono",
			"Nova Oval" => "Nova Oval",
			"Nova Round" => "Nova Round",
			"Nova Script" => "Nova Script",
			"Nova Slim" => "Nova Slim",
			"Nova Square" => "Nova Square",
			"Numans" => "Numans",
			"Nunito" => "Nunito",
			"Old Standard TT" => "Old Standard TT",
			"Open Sans Condensed" => "Open Sans Condensed",
			"Open Sans" => "Open Sans",
			"Orbitron" => "Orbitron",
			"Oswald" => "Oswald",
			"Over the Rainbow" => "Over the Rainbow",
			"Ovo" => "Ovo",
			"PT Sans Caption" => "PT Sans Caption",
			"PT Sans Narrow" => "PT Sans Narrow",
			"PT Sans" => "PT Sans",
			"PT Serif Caption" => "PT Serif Caption",
			"PT Serif" => "PT Serif",
			"Pacifico" => "Pacifico",
			"Passero One" => "Passero One",
			"Patrick Hand" => "Patrick Hand",
			"Paytone One" => "Paytone One",
			"Permanent Marker" => "Permanent Marker",
			"Petrona" => "Petrona",
			"Philosopher" => "Philosopher",
			"Piedra" => "Piedra",
			"Pinyon Script" => "Pinyon Script",
			"Play" => "Play",
			"Playfair Display" => "Playfair Display",
			"Podkova" => "Podkova",
			"Poller One" => "Poller One",
			"Poly" => "Poly",
			"Pompiere" => "Pompiere",
			"Prata" => "Prata",
			"Prociono" => "Prociono",
			"Puritan" => "Puritan",
			"Quattrocento Sans" => "Quattrocento Sans",
			"Quattrocento" => "Quattrocento",
			"Questrial" => "Questrial",
			"Quicksand" => "Quicksand",
			"Radley" => "Radley",
			"Raleway" => "Raleway",
			"Rammetto One" => "Rammetto One",
			"Rancho" => "Rancho",
			"Rationale" => "Rationale",
			"Redressed" => "Redressed",
			"Reenie Beanie" => "Reenie Beanie",
			"Ribeye Marrow" => "Ribeye Marrow",
			"Ribeye" => "Ribeye",
			"Righteous" => "Righteous",
			"Roboto" => "Roboto",
			"Roboto Slab" => "Roboto Slab",
			"Rock Salt" => "Rock Salt",
			"Rokkitt" => "Rokkitt",
			"Rosario" => "Rosario",
			"Ruslan Display" => "Ruslan Display",
			"Salsa" => "Salsa",
			"Sancreek" => "Sancreek",
			"Sansita One" => "Sansita One",
			"Satisfy" => "Satisfy",
			"Schoolbell" => "Schoolbell",
			"Shadows Into Light" => "Shadows Into Light",
			"Shanti" => "Shanti",
			"Short Stack" => "Short Stack",
			"Sigmar One" => "Sigmar One",
			"Signika Negative" => "Signika Negative",
			"Signika" => "Signika",
			"Six Caps" => "Six Caps",
			"Slackey" => "Slackey",
			"Smokum" => "Smokum",
			"Smythe" => "Smythe",
			"Sniglet" => "Sniglet",
			"Snippet" => "Snippet",
			"Sorts Mill Goudy" => "Sorts Mill Goudy",
			"Special Elite" => "Special Elite",
			"Spinnaker" => "Spinnaker",
			"Spirax" => "Spirax",
			"Stardos Stencil" => "Stardos Stencil",
			"Sue Ellen Francisco" => "Sue Ellen Francisco",
			"Sunshiney" => "Sunshiney",
			"Supermercado One" => "Supermercado One",
			"Swanky and Moo Moo" => "Swanky and Moo Moo",
			"Syncopate" => "Syncopate",
			"Tangerine" => "Tangerine",
			"Tenor Sans" => "Tenor Sans",
			"Terminal Dosis" => "Terminal Dosis",
			"The Girl Next Door" => "The Girl Next Door",
			"Tienne" => "Tienne",
			"Tinos" => "Tinos",
			"Tulpen One" => "Tulpen One",
			"Ubuntu Condensed" => "Ubuntu Condensed",
			"Ubuntu Mono" => "Ubuntu Mono",
			"Ubuntu" => "Ubuntu",
			"Ultra" => "Ultra",
			"UnifrakturCook" => "UnifrakturCook",
			"UnifrakturMaguntia" => "UnifrakturMaguntia",
			"Unkempt" => "Unkempt",
			"Unlock" => "Unlock",
			"Unna" => "Unna",
			"VT323" => "VT323",
			"Varela Round" => "Varela Round",
			"Varela" => "Varela",
			"Vast Shadow" => "Vast Shadow",
			"Vibur" => "Vibur",
			"Vidaloka" => "Vidaloka",
			"Volkhov" => "Volkhov",
			"Vollkorn" => "Vollkorn",
			"Voltaire" => "Voltaire",
			"Waiting for the Sunrise" => "Waiting for the Sunrise",
			"Wallpoet" => "Wallpoet",
			"Walter Turncoat" => "Walter Turncoat",
			"Wire One" => "Wire One",
			"Yanone Kaffeesatz" => "Yanone Kaffeesatz",
			"Yellowtail" => "Yellowtail",
			"Yeseva One" => "Yeseva One",
			"Zeyada" => "Zeyada" 
		);
		
		
		//-----------------------------------------------------------------------------------*/
		// TO DO: Add options/functions that use these */
		//-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr      = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads      = get_option( 'of_uploads' );
		$other_entries    = array(
			 "Select a number:",
			"1",
			"2",
			"3",
			"4",
			"5",
			"6",
			"7",
			"8",
			"9",
			"10",
			"11",
			"12",
			"13",
			"14",
			"15",
			"16",
			"17",
			"18",
			"19" 
		);
		$body_repeat      = array(
			 "no-repeat",
			"repeat-x",
			"repeat-y",
			"repeat" 
		);
		$body_pos         = array(
			 "top left",
			"top center",
			"top right",
			"center left",
			"center center",
			"center right",
			"bottom left",
			"bottom center",
			"bottom right" 
		);
		
		// Image Alignment radio box
		$of_options_thumb_align = array(
			 "alignleft" => "Left",
			"alignright" => "Right",
			"aligncenter" => "Center" 
		);
		
		// Image Links to Options
		$of_options_image_link_to = array(
			 "image" => "The Image",
			"post" => "The Post" 
		);
		
		
		//-----------------------------------------------------------------------------------
		// The Options Array
		//-----------------------------------------------------------------------------------
		
		// Set the Options Array
		global $of_options;
		$of_options = array();
		$prefix     = "vntd_";
		
		//
		//	General Settings
		//
		
		$of_options[] = array(
			 "name" => "General",
			"icon" => "cogs",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Logo Image",
			"desc" => "Upload your website's logo image.",
			"id" => $prefix . "logo_url",
			"std" => "http://veented.com/themes/north/wp-content/uploads/2014/07/logo-dark.png",
			"type" => "upload" 
		);
		
		$of_options[] = array(
			 "name" => "Custom Favicon",
			"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
			"id" => $prefix . "custom_favicon",
			"std" => "http://veented.com/themes/north/wp-content/uploads/2014/07/favicon.png",
			"type" => "upload" 
		);
		
		$of_options[] = array(
			 "name" => "Page Loader",
			"desc" => "Enable or Disable the Page Loader.",
			"id" => $prefix . "loader",
			"std" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			 "name" => "Responsive Design",
			"desc" => "Enable or Disable the theme responsiveness.",
			"id" => $prefix . "responsive",
			"std" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			 "name" => "Scroll to Top Button",
			"desc" => "Enable the Scroll to Top button.",
			"id" => $prefix . "stt",
			"std" => 1,
			"type" => "switch" 
		);
		
		$url          = ADMIN_DIR . 'assets/images/';
		$of_options[] = array(
			 "name" => "Default Page Layout",
			"desc" => "Choose a default page layout for your pages: Fullwidth, Sidebar Right or Sidebar Left",
			"id" => $prefix . "default_layout",
			"std" => "fullwidth",
			"type" => "images",
			"options" => array(
				 'fullwidth' => $url . 'fullwidth.png',
				'sidebar_right' => $url . 'sidebar_right.png',
				'sidebar_left' => $url . 'sidebar_left.png' 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Default Visual Composer Row Template",
			"desc" => "Use a default Visual Composer row template to get all features.",
			"id" => $prefix . "vc_default",
			"std" => 0,
			"type" => "switch" 
		);
		
		
		//
		//	Header Tab
		//					
		
		$of_options[] = array(
			 "name" => "Header",
			"icon" => "columns",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Header Style",
			"desc" => "Choose a style for your Header.",
			"id" => $prefix . "navbar_style",
			"std" => "style1",
			"type" => "select",
			"options" => array(
				 "style1" => "Style 1 - default",
				"style2" => "Style 2 - transparent, turns background color on scroll",
				"style3" => "Style 3 - appear after #first section of the page.",
				"disable" => "Disable" 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Header Color",
			"desc" => "Color scheme of your Header.",
			"id" => $prefix . "navbar_color",
			"std" => "white",
			"type" => "select",
			"options" => array(
				 "white" => "White",
				"dark" => "Dark" 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Sticky Header",
			"desc" => "Enable/disable the sticky header.",
			"id" => $prefix . "sticky_header",
			"std" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			 "name" => "Sticky Header on Mobile Devices",
			"desc" => "Enable/disable the sticky header on mobile devices like iPhone.",
			"id" => $prefix . "sticky_header_mobile",
			"std" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			 "name" => "Page Title",
			"desc" => "Disable or Enable the Page Title area globally.",
			"id" => $prefix . "header_title",
			"std" => 1,
			"folds" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			 "name" => "Breadcrumbs",
			"desc" => "Disable or Enable the Breadcrumbs navigation globally.",
			"id" => $prefix . "breadcrumbs",
			"std" => 1,
			"fold" => $prefix . "header_title",
			"type" => "switch" 
		);
		
		$of_options[] = array(
			 "name" => "Light Logo Image",
			"desc" => "Upload a lighter version of your logo for dark and Style 2 navbar.",
			"id" => $prefix . "logo_light_url",
			"std" => "http://veented.com/themes/north/wp-content/uploads/2014/07/logo.png",
			"type" => "upload" 
		);
		
		
		
		
		
		//
		//	Footer Tab
		//					
		
		$of_options[] = array(
			 "name" => "Footer",
			"icon" => "hdd-o",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Copyright Text",
			"desc" => "Supports HTML",
			"id" => $prefix . "copyright",
			"rows" => "2",
			"std" => "Copyright 2017 <a href='#'>Your Site</a> - All rights reserved.",
			"type" => "textarea" 
		);
		
		
		$of_options[] = array(
			 "name" => "Footer Widgets Area",
			"desc" => "Disable or enable the Footer Widgets globally. Please visit Appearance / Widgets menu to add new widgets!",
			"id" => $prefix . "footer_widgets",
			"std" => "disabled",
			"type" => "select",
			"options" => array(
				 "disabled" => "Disabled",
				"enabled" => "Enabled" 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Footer Skin",
			"desc" => "Color scheme of your Footer.",
			"id" => $prefix . "footer_skin",
			"std" => "white",
			"type" => "select",
			"options" => array(
				 "white" => "White",
				"dark" => "Dark" 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Footer Style",
			"desc" => "Style of your Footer.",
			"id" => $prefix . "footer_style",
			"std" => "centered",
			"type" => "select",
			"folds" => true,
			"options" => array(
				 "centered" => "Centered (default)",
				"classic" => "Classic (copyright text on the left)" 
			) 
		);
		
		
		$of_options[] = array(
			 "name" => "Footer Image",
			"desc" => "Upload the footer's centered image.",
			"id" => $prefix . "footer_img_url",
			"std" => "http://veented.com/themes/north/wp-content/uploads/2014/07/logo-dark.png",
			"fold" => $prefix . "footer_style",
			"folded" => "centered",
			"type" => "upload" 
		);
		
		$of_options[] = array(
			 "name" => "Dark Footer Image",
			"desc" => "Upload the dark footer's centered image. It's optional but works perfectly if you want to use multiple footer skins across your site.",
			"id" => $prefix . "footer_img_dark_url",
			"std" => "http://veented.com/themes/north/wp-content/uploads/2014/07/logo.png",
			"fold" => $prefix . "footer_style",
			"folded" => "centered",
			"type" => "upload" 
		);
		
		$of_options[] = array(
			 "name" => "Social Icon Generator",
			"desc" => "Easily add and arrange social icons for your copyright section (Classic Style).",
			"id" => $prefix . "social_icons",
			"std" => "",
			"fold" => $prefix . "footer_style",
			"folded" => "classic",
			"type" => "socials" 
		);
		
		$of_options[] = array(
			 "name" => "Open social links in a new tab/window?",
			"desc" => "Decide if your social sites should be opened in a new window after clicking an icon.",
			"id" => $prefix . "social_icons_target",
			"std" => 0,
			"fold" => $prefix . "footer_style",
			"folded" => "classic",
			"type" => "switch" 
		);
		
		//
		//	Blog Tab
		//					
		
		$of_options[] = array(
			 "name" => "Blog",
			"icon" => "file-text-o",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			"name" => esc_html__( 'Blog Index Meta Section', 'north' ),
			"desc" => esc_html__( 'Enable the meta section on blog index page.', 'north' ),
			"id" => $prefix . "blog_meta",
			"std" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			"name" => esc_html__( 'Single Post Meta Section', 'north' ),
			"desc" => esc_html__( 'Enable the  blog post meta section on individual post page.', 'north' ),
			"id" => $prefix . "blog_single_meta",
			"std" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			"name" => esc_html__( 'Blog Meta Author', 'north' ),
			"desc" => esc_html__( 'Display the post author in the meta section.', 'north' ),
			"id" => $prefix . "blog_meta_author",
			"std" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			"name" => esc_html__( 'Blog Meta Date', 'north' ),
			"desc" => esc_html__( 'Display the post date in the meta section.', 'north' ),
			"id" => $prefix . "blog_meta_date",
			"std" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			"name" => esc_html__( 'Blog Meta Categories', 'north' ),
			"desc" => esc_html__( 'Display post categories in the meta section.', 'north' ),
			"id" => $prefix . "blog_meta_categories",
			"std" => 1,
			"type" => "switch" 
		);
		
		$of_options[] = array(
			"name" => esc_html__( 'Blog Meta Comments Count', 'north' ),
			"desc" => esc_html__( 'Displays comments count in the meta section.', 'north' ),
			"id" => $prefix . "blog_meta_comments",
			"std" => 1,
			"type" => "switch" 
		);
		
		//
		//	Portfolio Tab
		//					
		
		$of_options[] = array(
			 "name" => "Portfolio",
			"icon" => "briefcase",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Main Portfolio Page",
			"desc" => "Set the default portfolio page for the 'Back to portfolio' link on single portfolio posts.",
			"id" => $prefix . "portfolio_url",
			"options" => $of_pages,
			"type" => "select" 
		);
		
		
		//
		//	Sidebars Tab
		//					
		
		$of_options[] = array(
			 "name" => "Sidebars",
			"icon" => "indent",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Sidebar Manager",
			"desc" => "Easily create new sidebars.",
			"id" => "sidebar_generator",
			"std" => "",
			"type" => "slider" 
		);
		
		//
		//	Appearance 2.0 Tab
		//					
		
		$of_options[] = array(
			 "name" => "Customizer",
			"icon" => "star",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Theme Customizer",
			"type" => "customizer_start" 
		);
		
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		// General Tab
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		
		$of_options[] = array(
			 "name" => "General",
			"type" => "customizer_tab" 
		);
		
		$of_options[] = array(
			 "name" => "Accent Color",
			"desc" => "",
			"id" => $prefix . "accent_color",
			"std" => "#d71818",
			"dep" => "accent",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Background Color",
			"desc" => "",
			"id" => $prefix . "bg_color",
			"std" => "#fff",
			"dep" => "body",
			"type" => "background-color" 
		);
		
		$of_options[] = array(
			 "name" => "Predefined Theme Colors",
			"desc" => "",
			"id" => $prefix . "predefined_colors",
			"std" => "sidebar_right",
			"type" => "color-blocks",
			"options" => array(
				 '#358FE7' => '#358FE7', // dodgerblue
				'#FFD700' => '#FFD700', // gold
				'#F08080' => '#F08080', // lightcoral
				'#B0C4DE' => '#B0C4DE', // lightsteelblue
				'#32CD32' => '#32CD32', // limegreen
				'#FFA500' => '#FFA500', // orange
				'#DB7093' => '#DB7093', // palevioletred
				'#FF0000' => '#FF0000', // red
				'#4682B4' => '#4682B4', // steelblue
				'#9370DB' => '#9370DB', // mediumpurple
				'#9ACD32' => '#9ACD32', // yellowgreen
				'#778899' => '#778899' // lightslategray
			) 
		);
		
		$of_options[] = array(
			 "name" => "Theme Skin",
			"desc" => "",
			"id" => $prefix . "skin",
			"std" => "white",
			"dep" => "body",
			"type" => "select",
			"options" => array(
				 "white" => "White",
				"night" => "Night",
				"dark" => "Dark" 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Theme Tone",
			"desc" => "Tone color of the row/section background overlays.",
			"id" => $prefix . "skin_overlay",
			"std" => "dark",
			"type" => "select",
			"options" => array(
				 "dark" => "Dark",
				"night" => "Night" 
			) 
		);
		
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		// Predefined Theme Styles
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-					
		
		global $smof_data;
		
		
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		// Header Tab	
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-				
		
		$of_options[] = array(
			 "name" => "Header",
			"type" => "customizer_tab" 
		);
		
		$of_options[] = array(
			 "name" => "Navigation Font Color",
			"desc" => "",
			"id" => $prefix . "header_nav_color",
			"std" => "#3e3e3e",
			"dep" => "preview-navigation",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Navigation Hover BG Color",
			"desc" => "",
			"id" => $prefix . "header_hover_bg_color",
			"std" => "#f8f8f8",
			"dep" => "",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Background Color",
			"desc" => "",
			"id" => $prefix . "header_bg_color",
			"std" => "#fff",
			"dep" => "header",
			"type" => "background-color" 
		);
		
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		// Page Title Tab	
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-				
		
		$of_options[] = array(
			 "name" => "Page Title",
			"type" => "customizer_tab" 
		);
		
		$of_options[] = array(
			 "name" => "Title Color",
			"desc" => "",
			"id" => $prefix . "pagetitle_color",
			"std" => "#3e3e3e",
			"dep" => "preview-page-title",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Tagline Color",
			"desc" => "",
			"id" => $prefix . "pagetitle_tagline_color",
			"std" => "#787777",
			"dep" => "preview-page-tagline",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Breadcrumbs Color",
			"desc" => "",
			"id" => $prefix . "breadcrumbs_color",
			"std" => "#6a6a6a",
			"dep" => "preview-breadcrumbs",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Background Color",
			"desc" => "",
			"id" => $prefix . "pagetitle_bg_color",
			"std" => "#fafafa",
			"dep" => "page-title",
			"type" => "background-color" 
		);
		
		$of_options[] = array(
			 "name" => "Bottom Border Color",
			"desc" => "",
			"id" => $prefix . "pagetitle_border_color",
			"std" => "#fafafa",
			"dep" => "page-title",
			"type" => "border-color" 
		);
		
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		// Page Content Tab
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		
		$of_options[] = array(
			 "name" => "Page Content",
			"type" => "customizer_tab" 
		);
		
		$of_options[] = array(
			 "name" => "Text Color",
			"desc" => "",
			"id" => $prefix . "body_color",
			"std" => "#717171",
			"dep" => "body",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Heading Color",
			"desc" => "",
			"id" => $prefix . "heading_color",
			"std" => "#3e3e3e",
			"dep" => "preview-heading",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Link Hover Color",
			"desc" => "",
			"id" => $prefix . "content_hover_color",
			"std" => "#2189a3",
			"dep" => "body-hover-color",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Divider Color",
			"desc" => "",
			"id" => $prefix . "content_divider_color",
			"std" => "#f2f2f2",
			"dep" => "content-border",
			"type" => "border-color" 
		);
		
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		// Footer Tab	
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-				
		
		$of_options[] = array(
			 "name" => "Footer",
			"type" => "customizer_tab" 
		);
		
		$of_options[] = array(
			 "name" => "Text Color",
			"desc" => "",
			"id" => $prefix . "footer_color",
			"std" => "#767676",
			"dep" => "footer",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Top Border Color",
			"desc" => "",
			"id" => $prefix . "footer_border_color",
			"std" => "#fff",
			"dep" => "footer",
			"type" => "border-color" 
		);
		
		$of_options[] = array(
			 "name" => "Background Color",
			"desc" => "",
			"id" => $prefix . "footer_bg_color",
			"std" => "#fff",
			"dep" => "footer",
			"type" => "background-color" 
		);
		
		$of_options[] = array(
			 "name" => "Footer Widgets Skin",
			"desc" => "Choose a skin for your Footer Widgets.",
			"id" => $prefix . "footer_widgets_skin",
			"std" => "default",
			"type" => "select",
			"options" => array(
				 "default" => "Default (according to Footer Skin)",
				"white" => "White",
				"dark" => "Dark" 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Footer Widgets Background Color",
			"desc" => "",
			"id" => $prefix . "footer_widgets_bg_color",
			"std" => "",
			"dep" => "footer-widgets",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Footer Widgets Text Color",
			"desc" => "",
			"id" => $prefix . "footer_widgets_text_color",
			"std" => "",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Footer Widgets Heading Color",
			"desc" => "",
			"id" => $prefix . "footer_widgets_heading_color",
			"std" => "",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Footer Widgets Link Color",
			"desc" => "",
			"id" => $prefix . "footer_widgets_link_color",
			"std" => "",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Footer Widgets Borders Color",
			"desc" => "",
			"id" => $prefix . "footer_widgets_borders_color",
			"std" => "",
			"type" => "color" 
		);
		
		$of_options[] = array(
			 "name" => "Footer Widgets Link Hover BG Color",
			"desc" => "",
			"id" => $prefix . "footer_widgets_link_hover_bg_color",
			"std" => "",
			"type" => "color" 
		);
		
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		// Typography Tab
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-					
		
		
		$of_options[] = array(
			 "name" => "Typography",
			"type" => "customizer_tab" 
		);
		
		$of_options[] = array(
			 "name" => "Primary Heading Font",
			"desc" => "",
			"id" => $prefix . "heading_font",
			"std" => "Oswald",
			"type" => "select_google_font",
			"dep" => "primary-font",
			"preview" => array(
				 "text" => "This is a font preview.",
				"size" => "20px" 
			),
			"options" => $google_font_array 
		);
		
		$of_options[] = array(
			 "name" => "Secondary Body Font",
			"desc" => "",
			"id" => $prefix . "body_font",
			"std" => "Raleway",
			"type" => "select_google_font",
			"dep" => "browser-content",
			"preview" => array(
				 "text" => "This is a font preview.",
				"size" => "20px" 
			),
			"options" => $google_font_array 
		);
		
		$of_options[] = array(
			 "name" => "Primary Font Weight",
			//"desc" => "Make sure that <a href='https://www.google.com/fonts' title='Check it in Google Font Repository!' target='_blank'>your font</a> supports specific weight.",
			"id" => $prefix . "heading_font_weight",
			"std" => "400",
			"type" => "select",
			"class" => 'preview-font-weight half-size',
			"dep" => "preview-heading",
			"options" => array(
				 300,
				400,
				500,
				600,
				700 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Prim. Font Transform",
			"desc" => "",
			"id" => $prefix . "heading_font_transform",
			"std" => "uppercase",
			"type" => "select",
			"class" => 'preview-font-transform half-size',
			"dep" => "preview-heading",
			"options" => array(
				 "uppercase",
				"none" 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Nav Font Weight",
			//"desc" => "Make sure that <a href='https://www.google.com/fonts' title='Check it in Google Font Repository!' target='_blank'>your font</a> supports specific weight.",
			"id" => $prefix . "navigation_font_weight",
			"std" => "600",
			"type" => "select",
			"class" => 'preview-font-weight half-size',
			"dep" => "preview-navigation",
			"options" => array(
				 300,
				400,
				500,
				600,
				700 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Nav Font Transform",
			"desc" => "",
			"id" => $prefix . "navigation_font_transform",
			"std" => "uppercase",
			"type" => "select",
			"class" => 'preview-font-transform half-size',
			"dep" => "preview-navigation",
			"options" => array(
				 "uppercase",
				"none" 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Body Font Size",
			"desc" => "",
			"id" => $prefix . "fs_body",
			"std" => "14",
			"min" => "10",
			"step" => "1",
			"max" => "18",
			"dep" => "body",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Navigation",
			"desc" => "",
			"id" => $prefix . "fs_navigation",
			"std" => "15",
			"min" => "10",
			"step" => "1",
			"max" => "18",
			"dep" => "preview-navigation",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Page Title",
			"desc" => "",
			"id" => $prefix . "fs_page_title",
			"std" => "30",
			"min" => "14",
			"step" => "1",
			"max" => "40",
			"dep" => "preview-page-title",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Page Tagline",
			"desc" => "",
			"id" => $prefix . "fs_page_tagline",
			"std" => "14",
			"min" => "9",
			"step" => "1",
			"max" => "18",
			"dep" => "preview-page-tagline",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Breadcrumbs",
			"desc" => "",
			"id" => $prefix . "fs_breadcrumbs",
			"std" => "13",
			"min" => "9",
			"step" => "1",
			"max" => "20",
			"dep" => "preview-breadcrumbs",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Special Heading",
			"desc" => "",
			"id" => $prefix . "fs_special",
			"std" => "60",
			"min" => "9",
			"step" => "1",
			"max" => "70",
			"dep" => "preview-special-heading",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Heading H1",
			"desc" => "",
			"id" => $prefix . "fs_h1",
			"std" => "36",
			"min" => "9",
			"step" => "1",
			"max" => "50",
			"dep" => "preview-h1",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Heading H2",
			"desc" => "",
			"id" => $prefix . "fs_h2",
			"std" => "30",
			"min" => "9",
			"step" => "1",
			"max" => "50",
			"dep" => "preview-h2",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Heading H3 (Widget Title)",
			"desc" => "",
			"id" => $prefix . "fs_h3",
			"std" => "24",
			"min" => "9",
			"step" => "1",
			"max" => "50",
			"dep" => "preview-h3",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Heading H4",
			"desc" => "",
			"id" => $prefix . "fs_h4",
			"std" => "18",
			"min" => "9",
			"step" => "1",
			"max" => "50",
			"dep" => "preview-h4",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Heading H5",
			"desc" => "",
			"id" => $prefix . "fs_h5",
			"std" => "14",
			"min" => "9",
			"step" => "1",
			"max" => "50",
			"dep" => "preview-h5",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Heading H6",
			"desc" => "",
			"id" => $prefix . "fs_h6",
			"std" => "12",
			"min" => "9",
			"step" => "1",
			"max" => "50",
			"dep" => "preview-h6",
			"type" => "sliderui" 
		);
		
		$of_options[] = array(
			 "name" => "Copyright",
			"desc" => "",
			"id" => $prefix . "fs_copyright",
			"std" => "11",
			"min" => "9",
			"step" => "1",
			"max" => "24",
			"dep" => "footer",
			"type" => "sliderui" 
		);
		
		
		$of_options[] = array(
			 "type" => "customizer_end" 
		);
		
		
		// Theme Preview Window
		
		$of_options[] = array(
			 "name" => "General Preview",
			"id" => "subheading_211",
			"std" => "",
			"type" => "theme_preview" 
		);
		
		
		//
		//	Archives / Search
		//					
		
		$of_options[] = array(
			 "name" => "Archives",
			"type" => "heading",
			"icon" => "search" 
		);
		
		$of_options[] = array(
			 "name" => "Archives Page Layout",
			"desc" => "",
			"id" => $prefix . "archives_layout",
			"std" => "sidebar_right",
			"type" => "images",
			"options" => array(
				 'fullwidth' => $url . 'fullwidth.png',
				'sidebar_right' => $url . 'sidebar_right.png',
				'sidebar_left' => $url . 'sidebar_left.png' 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Search Page Style",
			"desc" => "",
			"id" => $prefix . "search_style",
			"std" => "default",
			"type" => "select",
			"folds" => true,
			"options" => array(
				 "default" => "Default",
				"classic" => "Classic",
				"grid" => "Grid" 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Search Page Layout",
			"desc" => "",
			"id" => $prefix . "search_layout",
			"std" => "sidebar_right",
			"type" => "images",
			"options" => array(
				 'fullwidth' => $url . 'fullwidth.png',
				'sidebar_right' => $url . 'sidebar_right.png',
				'sidebar_left' => $url . 'sidebar_left.png' 
			) 
		);
		
		$of_options[] = array(
			 "name" => "Extra 404 Page Content",
			"desc" => "Choose a page that's content will be displayed at the bottom of the 404 page.",
			"id" => $prefix . "404_content",
			"options" => $of_pages,
			"type" => "select" 
		);
		
		
		
		//
		//	WooCommerce Tab
		//					
		
		if ( class_exists( 'Woocommerce' ) ) {
			
			$of_options[] = array(
				 "name" => "WooCommerce",
				"type" => "heading",
				"icon" => "shopping-cart" 
			);
			
			$of_options[] = array(
				 "name" => "WooCommerce Icon",
				"desc" => "Enable the WooCommerce icon in the Header section.",
				"id" => $prefix . "topbar_woocommerce",
				"std" => 1,
				"folds" => 1,
				"type" => "switch" 
			);
			
			$of_options[] = array(
				 "name" => "Single Product Layout",
				"desc" => "Select a default layout for your single product pages.",
				"id" => $prefix . "woo_single_layout",
				"std" => "fullwidth",
				"type" => "images",
				"options" => array(
					 'fullwidth' => $url . 'fullwidth.png',
					'sidebar_right' => $url . 'sidebar_right.png',
					'sidebar_left' => $url . 'sidebar_left.png' 
				) 
			);
			
			$of_options[] = array(
				 "name" => "Related Work",
				"desc" => "Enable or Disable the Related Products section on single product pages.",
				"id" => $prefix . "woo_related",
				"std" => 1,
				"folds" => 1,
				"type" => "switch" 
			);
			
			
		}
		
		$of_options[] = array(
			 "name" => "Advanced",
			"icon" => "wrench",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Custom CSS Styling",
			"desc" => "Insert you custom CSS rules and attributes here.",
			"id" => $prefix . "custom_css",
			"std" => "",
			"rows" => "14",
			"type" => "textarea" 
		);
		
		$of_options[] = array(
			 "name" => "Tracking Code",
			"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
			"id" => $prefix . "tracking_code",
			"std" => "",
			"rows" => "10",
			"type" => "textarea" 
		);
		
		$of_options[] = array(
			 "name" => "Google Maps",
			"icon" => "map",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Google Maps Api Key",
			"desc" => "Paste your Google Maps Api Key. For more information, check <a href='https://veented.ticksy.com/article/7856/' target='_blank'>this article</a>",
			"id" => $prefix . "google_map_api",
			"std" => "",
			"type" => "text" 
		);
		
		$of_options[] = array(
			 "name" => "Extras",
			"icon" => "rocket",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Premium Plugins",
			"std" => "North now comes with two, awesome premium plugins available for you for free: Essential Grid and Ultimate VC Addons! Please check <a href='https://veented.ticksy.com/article/8523/' target='_blank'>this article</a> for more information.",
			"id" => $prefix . "extras_info",
			"type" => "info" 
		);
		
		//					
		// Backup Tab
		//
		
		
		$of_options[] = array(
			 "name" => "Backup",
			"icon" => "repeat",
			"type" => "heading" 
		);
		
		$of_options[] = array(
			 "name" => "Backup and Restore Options",
			"id" => "of_backup",
			"std" => "",
			"type" => "backup",
			"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.' 
		);
		
		$of_options[] = array(
			 "name" => "Transfer Theme Options Data",
			"id" => "of_transfer",
			"std" => "",
			"type" => "transfer",
			"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						' 
		);
		
	}
}
?>