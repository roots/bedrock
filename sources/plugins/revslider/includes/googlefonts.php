<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 * @since 	  5.1.0
 * @lastfetch 30.09.2015
 */
 
if( !defined( 'ABSPATH') ) exit();

/**
*** CREATED WITH SCRIPT SNIPPET AND DATA TAKEN FROM https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&fields=items(family%2Csubsets%2Cvariants)&key={YOUR_API_KEY}
foreach($list as $l){
	echo "'".$l['family'] ."' => array("."\n";
	echo "'variants' => array(";
	foreach($l['variants'] as $k => $v){
		if($k > 0) echo ", ";
		if($v == 'regular') $v = '400';
		echo "'".$v."'";
	}
	echo "),\n";
	echo "'subsets' => array(";
	foreach($l['subsets'] as $k => $v){
		if($k > 0) echo ", ";
		echo "'".$v."'";
	}
	echo ")\n),\n";
}
**/

$googlefonts = array(
"Open Sans" => array(
'variants' => array('300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Roboto" => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '900', '900italic'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Lato" => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext')
),
"Oswald" => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Slabo 27px" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Roboto Condensed" => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Source Sans Pro" => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900', '900italic'),
'subsets' => array('vietnamese', 'latin', 'latin-ext')
),
"Lora" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Montserrat" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"PT Sans" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Raleway" => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin')
),
"Open Sans Condensed" => array(
'variants' => array('300', '300italic', '700'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Droid Sans" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Ubuntu" => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Roboto Slab" => array(
'variants' => array('100', '300', '400', '700'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Droid Serif" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Merriweather" => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext')
),
"Arimo" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('hebrew', 'greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"PT Sans Narrow" => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Noto Sans" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'devanagari', 'vietnamese', 'latin', 'latin-ext')
),
"Titillium Web" => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900'),
'subsets' => array('latin', 'latin-ext')
),
"PT Serif" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Bitter" => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Indie Flower" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Poiret One" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Yanone Kaffeesatz" => array(
'variants' => array('200', '300', '400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Arvo" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Dosis" => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext')
),
"Oxygen" => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Playfair Display" => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Cabin" => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin')
),
"Lobster" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'vietnamese', 'latin', 'latin-ext')
),
"Fjalla One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Noto Serif" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Hind" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Inconsolata" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Muli" => array(
'variants' => array('300', '300italic', '400', 'italic'),
'subsets' => array('latin')
),
"Nunito" => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin')
),
"Abel" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Bree Serif" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Vollkorn" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Archivo Narrow" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Josefin Sans" => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Francois One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Signika" => array(
'variants' => array('300', '400', '600', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Fira Sans" => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('greek', 'cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Ubuntu Condensed" => array(
'variants' => array('400'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Libre Baskerville" => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Cuprum" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Shadows Into Light" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Maven Pro" => array(
'variants' => array('400', '500', '700', '900'),
'subsets' => array('latin')
),
"Asap" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Pacifico" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Play" => array(
'variants' => array('400', '700'),
'subsets' => array('greek', 'cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Exo 2" => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Anton" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Crimson Text" => array(
'variants' => array('400', 'italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin')
),
"Alegreya" => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext')
),
"Orbitron" => array(
'variants' => array('400', '500', '700', '900'),
'subsets' => array('latin')
),
"Rokkitt" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Quicksand" => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin')
),
"Varela Round" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Merriweather Sans" => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'latin-ext')
),
"PT Sans Caption" => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Karla" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Exo" => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext')
),
"Amatic SC" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Dancing Script" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Questrial" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Sigmar One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Monda" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Istok Web" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Pathway Gothic One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Righteous" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Abril Fatface" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Josefin Slab" => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin')
),
"Patua One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Bangers" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Andada" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Architects Daughter" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Source Code Pro" => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('latin', 'latin-ext')
),
"Crete Round" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext')
),
"ABeeZee" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Noticia Text" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('vietnamese', 'latin', 'latin-ext')
),
"Quattrocento Sans" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Gloria Hallelujah" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Hammersmith One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"News Cycle" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Gudea" => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext')
),
"BenchNine" => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Ropa Sans" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext')
),
"EB Garamond" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Armata" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Kaushan Script" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Pontano Sans" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Chewy" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Old Standard TT" => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin')
),
"Fredoka One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Archivo Black" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Sanchez" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext')
),
"Cantarell" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Tinos" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('hebrew', 'greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Covered By Your Grace" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Alfa Slab One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Comfortaa" => array(
'variants' => array('300', '400', '700'),
'subsets' => array('greek', 'cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Passion One" => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin', 'latin-ext')
),
"Coming Soon" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Cabin Condensed" => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin')
),
"Satisfy" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Slackey" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Lobster Two" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Cinzel" => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin')
),
"Philosopher" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'latin')
),
"Economica" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Quattrocento" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Voltaire" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Courgette" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Kreon" => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin')
),
"Permanent Marker" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Russo One" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Ruda" => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin', 'latin-ext')
),
"Didact Gothic" => array(
'variants' => array('400'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Lateef" => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin')
),
"Paytone One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Shadows Into Light Two" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Jockey One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Varela" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Rock Salt" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Bevan" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Handlee" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Vidaloka" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Alegreya Sans" => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('vietnamese', 'latin', 'latin-ext')
),
"Cardo" => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('greek', 'greek-ext', 'latin', 'latin-ext')
),
"Playball" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Changa One" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Sintony" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Days One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Droid Sans Mono" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Domine" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Antic Slab" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Nobile" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Amiri" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('arabic', 'latin')
),
"Chivo" => array(
'variants' => array('400', 'italic', '900', '900italic'),
'subsets' => array('latin')
),
"Pinyon Script" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Amaranth" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Tangerine" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Actor" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Cookie" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Advent Pro" => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('greek', 'latin', 'latin-ext')
),
"Jura" => array(
'variants' => array('300', '400', '500', '600'),
'subsets' => array('greek', 'cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Gentium Book Basic" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Cabin Sketch" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Scada" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Patrick Hand" => array(
'variants' => array('400'),
'subsets' => array('vietnamese', 'latin', 'latin-ext')
),
"Squada One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Playfair Display SC" => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Signika Negative" => array(
'variants' => array('300', '400', '600', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Great Vibes" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Fauna One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Special Elite" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Marvel" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Sorts Mill Goudy" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext')
),
"Molengo" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Luckiest Guy" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Enriqueta" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Marck Script" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Fugaz One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Homenaje" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Damion" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Roboto Mono" => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Glegoo" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Viga" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Basic" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Calligraffitti" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Rambla" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Niconne" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Oleo Script" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Marmelad" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Volkhov" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Allerta" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Audiowide" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Candal" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Bad Script" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin')
),
"Neuton" => array(
'variants' => array('200', '300', '400', 'italic', '700', '800'),
'subsets' => array('latin', 'latin-ext')
),
"Copse" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Carme" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Average" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Nothing You Could Do" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Doppio One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Arapey" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Julius Sans One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Limelight" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Homemade Apple" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Boogaloo" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Reenie Beanie" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Lusitana" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Overlock" => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext')
),
"Waiting for the Sunrise" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Syncopate" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Cherry Cream Soda" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Coda" => array(
'variants' => array('400', '800'),
'subsets' => array('latin', 'latin-ext')
),
"Bubblegum Sans" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Cantata One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Electrolize" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Six Caps" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Coustard" => array(
'variants' => array('400', '900'),
'subsets' => array('latin')
),
"Quantico" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Convergence" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Just Another Hand" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Walter Turncoat" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Gentium Basic" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Alice" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Rajdhani" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Kameron" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Cutive" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Telex" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Alegreya Sans SC" => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('vietnamese', 'latin', 'latin-ext')
),
"PT Serif Caption" => array(
'variants' => array('400', 'italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Trocchi" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Share" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Goudy Bookletter 1911" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Sacramento" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Berkshire Swash" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Montserrat Alternates" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Neucha" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin')
),
"Contrail One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Carrois Gothic" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Nixie One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Michroma" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Adamina" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Podkova" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Crafty Girls" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Alex Brush" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Antic" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Ultra" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Ubuntu Mono" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Aldrich" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"VT323" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Mako" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Black Ops One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Ceviche One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Source Serif Pro" => array(
'variants' => array('400', '600', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Oranienbaum" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Acme" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Fontdiner Swanky" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Rochester" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Gochi Hand" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Prata" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Rancho" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Belleza" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Khula" => array(
'variants' => array('300', '400', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Lilita One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Fredericka the Great" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Allerta Stencil" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Port Lligat Slab" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Allura" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Arbutus Slab" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Rosario" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Spinnaker" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Delius" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Denk One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Freckle Face" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Duru Sans" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Yellowtail" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Racing Sans One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Aclonica" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Schoolbell" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Work Sans" => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext')
),
"Radley" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext')
),
"Fanwood Text" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Ek Mukta" => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Kalam" => array(
'variants' => array('300', '400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Megrim" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Frijole" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Alegreya SC" => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext')
),
"Marcellus" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Allan" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Parisienne" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Magra" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"PT Mono" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Forum" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Alef" => array(
'variants' => array('400', '700'),
'subsets' => array('hebrew', 'latin')
),
"Marcellus SC" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Puritan" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Inder" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Alike" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Cousine" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('hebrew', 'greek', 'greek-ext', 'cyrillic', 'cyrillic-ext', 'vietnamese', 'latin', 'latin-ext')
),
"Average Sans" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Sansita One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Hanuman" => array(
'variants' => array('400', '700'),
'subsets' => array('khmer')
),
"Tauri" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Metrophobic" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Gruppo" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Press Start 2P" => array(
'variants' => array('400'),
'subsets' => array('greek', 'cyrillic', 'latin', 'latin-ext')
),
"Sarala" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Carter One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"IM Fell English" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Annie Use Your Telescope" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Fenix" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Henny Penny" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Lustria" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Tenor Sans" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Lemon" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Gilda Display" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Yesteryear" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Yantramanav" => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Londrina Solid" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Voces" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Englebert" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Unica One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Chelsea Market" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Petit Formal Script" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Halant" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Grand Hotel" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Caudex" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'latin', 'latin-ext')
),
"Anaheim" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Corben" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Knewave" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Bowlby One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Italianno" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Nova Square" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Capriola" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Sue Ellen Francisco" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Unkempt" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Mallanna" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Imprima" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Kotta One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Baumans" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Cinzel Decorative" => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin')
),
"Cambay" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Anonymous Pro" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek', 'cyrillic', 'latin', 'latin-ext')
),
"Lily Script One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Leckerli One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Brawler" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Crushed" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Finger Paint" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Just Me Again Down Here" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Rubik One" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Simonetta" => array(
'variants' => array('400', 'italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext')
),
"Love Ya Like A Sister" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Kelly Slab" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"The Girl Next Door" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Headland One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Vast Shadow" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Rufina" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Patrick Hand SC" => array(
'variants' => array('400'),
'subsets' => array('vietnamese', 'latin', 'latin-ext')
),
"Montez" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"IM Fell DW Pica" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Merienda One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Poller One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Iceland" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Judson" => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('vietnamese', 'latin', 'latin-ext')
),
"Give You Glory" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Lekton" => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Merienda" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Quando" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Ovo" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Oxygen Mono" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Andika" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Belgrano" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Mate" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Fjord One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Gravitas One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Graduate" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Mr Dafoe" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Salsa" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Teko" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Titan One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Shanti" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Orienta" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Wire One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Over the Rainbow" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Pompiere" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Mr De Haviland" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Bentham" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Slabo 13px" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Strait" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"GFS Didot" => array(
'variants' => array('400'),
'subsets' => array('greek')
),
"Monoton" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Seaweed Script" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Martel" => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Share Tech" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Khand" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Kranky" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Creepster" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Qwigley" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Tienne" => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin')
),
"Aladin" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"La Belle Aurore" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Short Stack" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Poppins" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Amethysta" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Norican" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Mystery Quest" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Bowlby One SC" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Prociono" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Poly" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Khmer" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Kristi" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Happy Monkey" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Gafata" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Carrois Gothic SC" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Clicker Script" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Cantora One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Skranji" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Loved by the King" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Stalemate" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Italiana" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Prosto One" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Yeseva One" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Mountains of Christmas" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Federo" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Delius Swash Caps" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Euphoria Script" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Oregano" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext')
),
"UnifrakturMaguntia" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Oleo Script Swash Caps" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Caesar Dressing" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Unna" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Sniglet" => array(
'variants' => array('400', '800'),
'subsets' => array('latin', 'latin-ext')
),
"Krona One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Ledger" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Nova Mono" => array(
'variants' => array('400'),
'subsets' => array('greek', 'latin')
),
"Meddon" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Junge" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Expletus Sans" => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin')
),
"Geo" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Herr Von Muellerhoff" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Arizonia" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Griffy" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Dawning of a New Day" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Mate SC" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Cambo" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Numans" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Kite One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Gabriela" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Cutive Mono" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Stardos Stencil" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Averia Sans Libre" => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Bilbo Swash Caps" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Life Savers" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Cedarville Cursive" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Chau Philomene One" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext')
),
"Shojumaru" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Kavoon" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Rationale" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"IM Fell English SC" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Mouse Memoirs" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Sofia" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Buenard" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Concert One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Keania One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Oldenburg" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Cherry Swash" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Averia Gruesa Libre" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Asul" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Karma" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Medula One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Codystar" => array(
'variants' => array('300', '400'),
'subsets' => array('latin', 'latin-ext')
),
"Metamorphous" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Flamenco" => array(
'variants' => array('300', '400'),
'subsets' => array('latin')
),
"Coda Caption" => array(
'variants' => array('800'),
'subsets' => array('latin', 'latin-ext')
),
"Zeyada" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Vibur" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Trade Winds" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Engagement" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Ruslan Display" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Holtwood One SC" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Raleway Dots" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Condiment" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Maiden Orange" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Biryani" => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"IM Fell French Canon" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Dorsa" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Esteban" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Quintessential" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Uncial Antiqua" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"IM Fell DW Pica SC" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Suwannaphum" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Rubik" => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Averia Serif Libre" => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Rosarivo" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext')
),
"Tulpen One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Balthazar" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Amarante" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"IM Fell Double Pica" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Donegal One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Delius Unicase" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Rouge Script" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Stoke" => array(
'variants' => array('300', '400'),
'subsets' => array('latin', 'latin-ext')
),
"Artifika" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Fresca" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Timmana" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"New Rocker" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Ruluko" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Paprika" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Londrina Outline" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Sunshiney" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Stint Ultra Expanded" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Inika" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Share Tech Mono" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Gurajada" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Catamaran" => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('tamil', 'latin', 'latin-ext')
),
"Sonsie One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"IM Fell Great Primer" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Habibi" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Swanky and Moo Moo" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Miniver" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Cagliostro" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Piedra" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Galindo" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Monofett" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Overlock SC" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Text Me One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Fondamento" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext')
),
"McLaren" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Sancreek" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Nova Round" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Sail" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Trykker" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"IM Fell French Canon SC" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Aguafina Script" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Rye" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Nosifer" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Stint Ultra Condensed" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Redressed" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Milonga" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"IM Fell Great Primer SC" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Wallpoet" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Bilbo" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Linden Hill" => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin')
),
"Fira Mono" => array(
'variants' => array('400', '700'),
'subsets' => array('greek', 'cyrillic', 'cyrillic-ext', 'latin', 'latin-ext')
),
"Buda" => array(
'variants' => array('300'),
'subsets' => array('latin')
),
"Nokora" => array(
'variants' => array('400', '700'),
'subsets' => array('khmer')
),
"Jacques Francois" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Wendy One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Autour One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Snowburst One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Port Lligat Sans" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Rammetto One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Alike Angular" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Averia Libre" => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin')
),
"Snippet" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Spirax" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Ramabhadra" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Scheherazade" => array(
'variants' => array('400', '700'),
'subsets' => array('arabic', 'latin')
),
"Dynalight" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Pirata One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Angkor" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Offside" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Bigshot One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Kurale" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'devanagari', 'latin', 'latin-ext')
),
"MedievalSharp" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Nova Slim" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"League Script" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Sarina" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"IM Fell Double Pica SC" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Antic Didone" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Battambang" => array(
'variants' => array('400', '700'),
'subsets' => array('khmer')
),
"Atomic Age" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Mandali" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Wellfleet" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Julee" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Della Respira" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Iceberg" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"UnifrakturCook" => array(
'variants' => array('700'),
'subsets' => array('latin')
),
"Mrs Saint Delafield" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Kenia" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Glass Antiqua" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Miltonian Tattoo" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Sarpanch" => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Ribeye" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Bokor" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Astloch" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Trochut" => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin')
),
"Modern Antiqua" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Montserrat Subrayada" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Spicy Rice" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Germania One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Elsie" => array(
'variants' => array('400', '900'),
'subsets' => array('latin', 'latin-ext')
),
"Lovers Quarrel" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Jolly Lodger" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Ruthie" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Nova Flat" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Montaga" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Palanquin Dark" => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Joti One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Seymour One" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Devonshire" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"GFS Neohellenic" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek')
),
"Vampiro One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Gorditas" => array(
'variants' => array('400', '700'),
'subsets' => array('latin')
),
"Passero One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Irish Grover" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Palanquin" => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Plaster" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Galdeano" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Butcherman" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Martel Sans" => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Smythe" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Sofadi One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Peralta" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Croissant One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Chango" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Lancelot" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Combo" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Geostar Fill" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Bubbler One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Petrona" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Ranchers" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Elsie Swash Caps" => array(
'variants' => array('400', '900'),
'subsets' => array('latin', 'latin-ext')
),
"Akronim" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Ribeye Marrow" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Almendra" => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext')
),
"Eagle Lake" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Warnes" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Itim" => array(
'variants' => array('400'),
'subsets' => array('vietnamese', 'thai', 'latin', 'latin-ext')
),
"Nova Oval" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Margarine" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Miltonian" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Monsieur La Doulaise" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Molle" => array(
'variants' => array('italic'),
'subsets' => array('latin', 'latin-ext')
),
"Jacques Francois Shadow" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Goblin One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Asset" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Rum Raisin" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Nova Cut" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Nova Script" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Emilys Candy" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Smokum" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Fascinate Inline" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Faster One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Original Surfer" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Freehand" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Chicle" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Moul" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Laila" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Mrs Sheppards" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Butterfly Kids" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Aubrey" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Diplomata" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Geostar" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Eater" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Ewert" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Erica One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Felipa" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Revalia" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Romanesco" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Federant" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Londrina Shadow" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Emblema One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Londrina Sketch" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Purple Purse" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Marko One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Supermercado One" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Jaldi" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Princess Sofia" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Underdog" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Meie Script" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Miss Fajardose" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Metal Mania" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Fascinate" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Risque" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Dangrek" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Koulen" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Diplomata SC" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Odor Mean Chey" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Sirin Stencil" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Bigelow Rules" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Sevillana" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Macondo Swash Caps" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Siemreap" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Mr Bedfort" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Vesper Libre" => array(
'variants' => array('400', '500', '700', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Rozha One" => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Arbutus" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Ramaraja" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Hind Vadodara" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('gujarati', 'latin', 'latin-ext')
),
"Dr Sugiyama" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Content" => array(
'variants' => array('400', '700'),
'subsets' => array('khmer')
),
"Stalinist One" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Arya" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Chela One" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Ruge Boogie" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Metal" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Ranga" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Bayon" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Macondo" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Kdam Thmor" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"NTR" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Dekko" => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Bonbon" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Taprom" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Suranna" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Jim Nightshade" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Flavors" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Kantumruy" => array(
'variants' => array('300', '400', '700'),
'subsets' => array('khmer')
),
"Almendra SC" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Moulpali" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Amita" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Preahvihear" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Chenla" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Almendra Display" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Pragati Narrow" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Eczar" => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Sumana" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Dhurjati" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Tenali Ramakrishna" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Tillana" => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Sree Krushnadevaraya" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Gidugu" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Sura" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Fasthand" => array(
'variants' => array('400'),
'subsets' => array('khmer')
),
"Suravaram" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Rubik Mono One" => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext')
),
"Hanalei" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Peddana" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Inknut Antiqua" => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Kadwa" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin')
),
"Sahitya" => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin')
),
"Unlock" => array(
'variants' => array('400'),
'subsets' => array('latin')
),
"Fruktur" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Chonburi" => array(
'variants' => array('400'),
'subsets' => array('vietnamese', 'thai', 'latin', 'latin-ext')
),
"Lakki Reddy" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
),
"Hanalei Fill" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Caveat" => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext')
),
"Hind Siliguri" => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('bengali', 'latin', 'latin-ext')
),
"Rhodium Libre" => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Asar" => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Caveat Brush" => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext')
),
"Modak" => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext')
),
"Ravi Prakash" => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin')
)
);

ksort($googlefonts);
?>