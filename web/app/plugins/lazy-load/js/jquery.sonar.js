/*
	An elem for determining if an elem is within a certain 
	distance from the edge above or below the screen, and attaching
	a function to execute once the elem is in view.
	
	General Usage:
	
	*	Place the library anywhere in your JavaScript code before you 
		intend to call the function.
	
	* 	To initialize Sonar with a different default distance, modify
		the sonar = Sonar() line immediately following the Sonar
		library definition. Example:
		
		sonar=Sonar(100); // Initializes Sonar with a 100px default distance.
	
	Note:
	
	* The default distance is 0 pixels.
	
	
	sonar.detect() Usage
	
	*	Use sonar.detect(elem, distance) to check if the 
		elem is within screen boundaries.
		
		@elem - The elem you want to detect visibility.
		@distance - The distance from the screen edge that should
		count in the check. Uses default distance if not specified.

	*	Note: sonar.detect() adds a property to 
		ojbects called sonarElemTop. Test to ensure there
		aren't any conflicts with your code. If there
		are, rename sonarElemTop to something else in the code.

	*	sonar.detect() returns:
		true if the elem is within the screen boundaries
		false if th elem is out of the screen boundaries
	
	Example:
	
	Here's how to check if an advertisment is visible on a 
	page that has the id, "ad".
	
	if (sonar.detect(document.getElementById("ad")))
	{
		alert('The ad is visible on screen!');
	}
	else
	{
		alert ('The ad is not on screen!);
	}

	sonar.add() Usage
	
	*	This method stores elems that are then polled 
		on user scroll by the Sonar.detect() method.

	*	Polling initializes once the sonar.add() method is passed
		an elem with the following properties:

		obj : A reference to the elem to observe until it is within
		      the specified distance (px).

		id : An alternative to the obj parameter, an "id" can be used
		     to grab the elem to observe.

		call: 	The function to call when the elem is within the 
		    	specified distance (px). The @elem argument will 
				include the elem that triggered the callback.

		px : The specified distance to include as being visible on 
		     screen. This property is optional (default is 0).

	Example: 

	sonar.add(
	{	
		obj: document.getElementById("0026-get-out-the-way"), 
		call: function(elem) // elem will include the elem that triggered the function.
		{ 
			swfelem.embedSWF("../player.swf", "0026-get-out-the-way", "640", "500", "9.0.0", 
			{}, {file: "0026-get-out-the-way.flv", fullscreen: true}, 
			{allowfullscreen: true, allowscriptaccess: "always"});
		},
		px: 400
	});
	
	You can also specify an id tag to be grabbed instead of the elem:
	
	sonar.add(
	{	
		id: "0026-get-out-the-way", 
		call: function(elem) // elem will include the elem that triggered the function.
		{ 
			swfelem.embedSWF("../player.swf", "0026-get-out-the-way", "640", "500", "9.0.0", 
			{}, {file: "0026-get-out-the-way.flv", fullscreen: true}, 
			{allowfullscreen: true, allowscriptaccess: "always"});
		},
		px: 400
	});

	Notes:

	*	Setting the body or html of your page to 100% will cause sonar to have
		an invalid height calculation in Firefox. It is recommended that you 
		do not set this CSS property.
	  
		Example:
	  
		html, body {
			height:100%;  // Do not do this.
		}
	
	*	If you want to set the default distance to something other 
		than 0, either update the property directly in the code or 
		you can do this:

		sonar.blip.d = 100;  // Where 100 = 100 pixels above and below the screen edge.

	*	Sleep well at night knowing Sonar automatically cleans up the 
		event listeners on the scroll event once all calls have executed.
	  
	Code History:

	v3 :: 8/14/2009 - David Artz (david.artz@corp.aol.com)
	* Fixed a bug in the polling code where splicing caused our
	  for loop to skip over the next iteration in the loop. This
	  caused some images in the poll to be detected when they
	  should have been.
	* Re-factored Sonar to use the "Module" JavaScript library
	  pattern, making our private variables and functions more
	  private and inaccessible from the public interface.
	* Updated the sonar.add() function to return true or false,
	  useful for determining if Sonar added the elem to the
	  poll or executed its callback immediately.

	v2 :: 3/24/2009 - David Artz (david.artz@corp.aol.com)
	* Added support for IE 8.
	* Updated the way scroll top and screen height are detected, now 
	  works in IE/FF/Safari quirks mode.
	* Added null check for IE, it was polling for an elem that had recently
	  been spliced out of the array. Nasty.
	* Modified for loop to use standard syntax. for (i in x) is known to be 
	  buggy with JS frameworks that override arrays.
	* Added sonar.b property to cache the body element (improving lookup time).
	
	v1 :: 11/18/2008 - David Artz (david.artz@corp.aol.com)
	* Officially released code for general use.

*/

(function( $, win, doc, undefined ){

$.fn.sonar = function( distance, full ){
	// No callbacks, return the results from Sonar for 
	// the first element in the stack.
	if ( typeof distance === "boolean" ) {
		full = distance;
		distance = undefined;
	}
	
	return $.sonar( this[0], distance, full );	
};

var body = doc.body,
	$win = $(win),

	onScreenEvent = "scrollin",
	offScreenEvent = "scrollout",

	detect = function( elem, distance, full ){
		
		if ( elem ) {
		
			// Cache the body elem in our private global.
			body || ( body = doc.body );
			
			var parentElem = elem, // Clone the elem for use in our loop.
				
				elemTop = 0, // The resets the calculated elem top to 0.
				
				// Used to recalculate elem.sonarElemTop if body height changes.
				bodyHeight = body.offsetHeight,
				
				// NCZ: I don't think you need innerHeight, I believe all major browsers support clientHeight.
				screenHeight = win.innerHeight || doc.documentElement.clientHeight || body.clientHeight || 0, // Height of the screen.
				
				// NCZ: I don't think you need pageYOffset, I believe all major browsers support scrollTop.
				scrollTop = doc.documentElement.scrollTop || win.pageYOffset || body.scrollTop || 0, // How far the user scrolled down.
				elemHeight = elem.offsetHeight || 0; // Height of the element.
			
			// If our custom "sonarTop" variable is undefined, or the document body
			// height has changed since the last time we ran sonar.detect()...
			if ( !elem.sonarElemTop || elem.sonarBodyHeight !== bodyHeight ) {

				// Loop through the offsetParents to calculate it.
				if ( parentElem.offsetParent ) {
					do {
						elemTop += parentElem.offsetTop;
					}
					while ( parentElem = parentElem.offsetParent );
				}
				
				// Set the custom property (sonarTop) to avoid future attempts to calculate
				// the distance on this elem from the top of the page.
				elem.sonarElemTop = elemTop;
				
				// Along the same lines, store the body height when we calculated 
				// the elem's top.
				elem.sonarBodyHeight = bodyHeight;
			}
			
			// If no distance was given, assume 0.
			distance = distance === undefined ? 0 : distance;
		
			// Dump all calculated variables.
/*
			console.dir({
				elem: elem,
				sonarElemTop: elem.sonarElemTop,
				elemHeight: elemHeight,
				scrollTop: scrollTop,
				screenHeight: screenHeight,
				distance: distance,
				full: full
			});
*/
			
			// If elem bottom is above the screen top and 
			// the elem top is below the screen bottom, it's false.
			// If full is specified, it si subtracted or added
			// as needed from the element's height.
			return (!(elem.sonarElemTop + (full ? 0 : elemHeight) < scrollTop - distance) &&
					!(elem.sonarElemTop + (full ? elemHeight : 0) > scrollTop + screenHeight + distance));
		}
	}, 

	// Container for elems needing to be polled.
	pollQueue = {},
	
	// Indicates if scroll events are bound to the poll.
	pollActive = 0,
	
	// Used for debouncing.
	pollId,
	
	// Function that handles polling when the user scrolls.
	poll = function(){
		
		// Debouncing speed optimization. Essentially prevents
		// poll requests from queue'ing up and overloading 
		// the scroll event listener.
		pollId && clearTimeout( pollId );
		pollId = setTimeout(function(){
				
			var elem,
				elems,
				screenEvent,
				options,
				detected,
				i, l;
			
			for ( screenEvent in pollQueue ) {
				
				elems = pollQueue[ screenEvent ];
				
				for (i = 0, l = elems.length; i < l; i++) {
					
					options = elems[i];
					elem = options.elem;
					
					// console.log("Polling " + elem.id);
					
					detected = detect( elem, options.px, options.full );
					
					// If the elem is not detected (offscreen) or detected (onscreen)
					// remove the elem from the queue and fire the callback.
					if ( screenEvent === offScreenEvent ? !detected : detected ) {
//							// console.log(screenEvent);
						if (!options.tr) {
							
							if ( elem[ screenEvent ] ) {
								// console.log("triggered:" + elem.id);
								// Trigger the onscreen or offscreen event depending
								// on the desired event.
								$(elem).trigger( screenEvent );
								
								options.tr = 1;
								
							// removeSonar was called on this element, clean it up
							// instead of triggering the event.
							} else {
								// console.log("Deleting " + elem.id);
								
								// Remove this object from the elem poll container.
								elems.splice(i, 1);
		
								// Decrement the counter and length because we just removed
								// one from it.
								i--;
								l--;
							}
						}
					} else {
						options.tr = 0;
					}
				}
			}
			
		}, 0 ); // End setTimeout performance tweak.
	},
	
	removeSonar = function( elem, screenEvent ){
		// console.log("Removing " + elem.id);
		elem[ screenEvent ] = 0;
	},

	addSonar = function( elem, options ) {
	// console.log("Really adding " + elem.id);
		// Prepare arguments.
		var distance = options.px,
			full = options.full,
			screenEvent = options.evt,
			parent = win, // Getting ready to accept parents: options.parent || win,
			detected = detect( elem, distance, full /*, parent */ ),
			triggered = 0;
		
		elem[ screenEvent ] = 1;
		
		// If the elem is not detected (offscreen) or detected (onscreen)
		// trigger the event and fire the callback immediately.
		if ( screenEvent === offScreenEvent ? !detected : detected ) {
			// console.log("Triggering " + elem.id + " " + screenEvent );
			// Trigger the onscreen event at the next possible cycle.
			// Artz: Ask the jQuery team why I needed to do this.
			setTimeout(function(){
				$(elem).trigger( screenEvent === offScreenEvent ? offScreenEvent : onScreenEvent );
			}, 0);
			triggered = 1;
		// Otherwise, add it to the polling queue.
		} 
		
		// console.log("Adding " + elem.id + " to queue.");
		// Push the element and its callback into the poll queue.
		pollQueue[ screenEvent ].push({ 
			elem: elem, 
			px: distance, 
			full: full, 
			tr: triggered/* , 
			parent: parent */
		});

		// Activate the poll if not currently activated.
		if ( !pollActive ) {
			$win.bind( "scroll", poll );
			pollActive = 1;
		}
	
			
			// Call the prepare function if there, used to 
			// prepare the element if we detected it.
			// Artz: Not implemented yet...used to preprocess elements in same loop.
			/*
			if ( prepCallback ) {
				prepCallback.call( elem, elem, detected );
			}
			*/
	};
	
	// Open sonar function up to the public.
	$.sonar = detect;
	
	pollQueue[ onScreenEvent ] = [];
	$.event.special[ onScreenEvent ] = {
				
		add: function( handleObj ) {
			var data = handleObj.data || {},
				elem = this;
			
			if (!elem[onScreenEvent]){
				addSonar(this, {
					px: data.distance,
					full: data.full,
					evt: onScreenEvent /*,
					parent: data.parent */
				});
			}
		},
		
		remove: function( handleObj ) {
			removeSonar( this, onScreenEvent );
		}
		
	};
	
	pollQueue[ offScreenEvent ] = [];
	$.event.special[ offScreenEvent ] = {
		
		add: function( handleObj ) {
			
			var data = handleObj.data || {},
				elem = this;
			
			if (!elem[offScreenEvent]){
				addSonar(elem, {
					px: data.distance,
					full: data.full,
					evt: offScreenEvent /*,
					parent: data.parent */
				});
			}
		},
		
		remove: function( handleObj ) {
			removeSonar( this, offScreenEvent );
		}
	};

	// console.log(pollQueue);
})( jQuery, window, document );