/************************************************************************************
 * jquery.themepunch.essential.js - jQuery Plugin for esg Portfolio Slider
 * @version: 2.1.0 (06.07.2016)
 * @requires jQuery v1.7 or later (tested on 1.9)
 * @author ThemePunch
************************************************************************************/
//! ++++++++++++++++++++++++++++++++++++++

(function(jQuery,undefined){


	  //! ANIMATION MATRIX
	  // PREPARE THE HOVER ANIMATIONS
	  var esgAnimmatrix = [
	  						['.esg-none',				0, {autoAlpha:1,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0},{autoAlpha:1,ease:punchgs.Power2.easeOut, overwrite:"all"}, 0, {autoAlpha:1,overwrite:"all"} ],

	    					['.esg-fade',				0.3, {autoAlpha:0,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0},{autoAlpha:1,ease:punchgs.Power2.easeOut, overwrite:"all"}, 0.3, {autoAlpha:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
	    					['.esg-fadeout',			0.3, {autoAlpha:1,ease:punchgs.Power2.easeOut, overwrite:"all"}, {autoAlpha:0,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0}, 0.3, {autoAlpha:1,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],

							['.esg-covergrowup',		0.3, {autoAlpha:1,top:"100%",marginTop:-10,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0},{autoAlpha:1,top:"0%", marginTop:0, ease:punchgs.Power2.easeOut, overwrite:"all"}, 0.3, {autoAlpha:1,top:"100%",marginTop:-10,bottom:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ,true],



				 			['.esg-flipvertical',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationX:180,autoAlpha:0,z:-0.001,transformOrigin:"50% 50%"}, {rotationX:0,autoAlpha:1,scale:1,z:0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} , 0.5,{rotationX:180,autoAlpha:0,scale:1,z:-0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,true],
			 				['.esg-flipverticalout',	0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationX:0,autoAlpha:1,z:0.001,transformOrigin:"50% 50%"},{rotationX:-180,scale:1,autoAlpha:0,z:-150,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,0.5,{rotationX:0,autoAlpha:1,scale:1,z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"} ],

			 				['.esg-fliphorizontal',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationY:180,autoAlpha:0,z:-0.001,transformOrigin:"50% 50%"}, {rotationY:0,autoAlpha:1,scale:1,z:0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} , 0.5, {rotationY:180,autoAlpha:0,scale:1,z:-0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,true],
				 			['.esg-fliphorizontalout',	0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,z:0.001,transformOrigin:"50% 50%"}, {rotationY:-180,scale:1,autoAlpha:0,z:-150,ease:punchgs.Power3.easeInOut,overwrite:"all"} , 0.5, {rotationY:0,autoAlpha:1,scale:1,z:0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} ],

			 				['.esg-flipup',				0.5, {x:0,y:0,scale:0.8,rotationZ:0,rotationX:90,rotationY:0,skewX:0,skewY:0,autoAlpha:0,z:0.001,transformOrigin:"50% 100%"}, {scale:1,rotationX:0,autoAlpha:1,z:0.001,ease:punchgs.Power2.easeOut,overwrite:"all"} , 0.3, {scale:0.8,rotationX:90,autoAlpha:0,z:0.001,ease:punchgs.Power2.easeOut,overwrite:"all"} ,true],
			 				['.esg-flipupout',			0.5, {rotationX:0,autoAlpha:1,y:0,ease:punchgs.Bounce.easeOut,overwrite:"all"} ,{x:0,y:0,scale:1,rotationZ:0,rotationX:-90,rotationY:0,skewX:0,skewY:0,autoAlpha:1,z:0.001,transformOrigin:"50% 0%"} , 0.3, {rotationX:0,autoAlpha:1,y:0,ease:punchgs.Bounce.easeOut,overwrite:"all"} ],


			 				['.esg-flipdown',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:-90,rotationY:0,skewX:0,skewY:0,autoAlpha:0,z:0.001,transformOrigin:"50% 0%"},{rotationX:0,autoAlpha:1,y:0,ease:punchgs.Bounce.easeOut,overwrite:"all"} ,0.3, {rotationX:-90,z:0,ease:punchgs.Power2.easeOut,autoAlpha:0,overwrite:"all"},true ],
			 				['.esg-flipdownout',		0.5, {scale:1,rotationX:0,autoAlpha:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}, {x:0,y:0,scale:0.8,rotationZ:0,rotationX:90,rotationY:0,skewX:0,skewY:0,autoAlpha:0,z:0.001,transformOrigin:"50% 100%"}, 0.3, {scale:1,rotationX:0,autoAlpha:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],

			 				['.esg-flipright',			0.5, {x:0,y:0,scale:0.8,rotationZ:0,rotationX:0,rotationY:90,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"0% 50%"},{scale:1,rotationY:0,autoAlpha:1,ease:punchgs.Power2.easeOut,overwrite:"all"} ,0.3,{autoAlpha:0,scale:0.8,rotationY:90,ease:punchgs.Power3.easeOut,overwrite:"all"} ,true],
			 				['.esg-fliprightout',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationY:0,autoAlpha:1,transformOrigin:"100% 50%"},{scale:1,rotationY:-90,autoAlpha:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ,0.3,{scale:1,z:0,rotationY:0,autoAlpha:1,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-flipleft',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:-90,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"100% 50%"},{rotationY:0,autoAlpha:1,z:0.001,scale:1,ease:punchgs.Power3.easeOut,overwrite:"all"} ,0.3,{autoAlpha:0,rotationY:-90,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ,true],
			 				['.esg-flipleftout',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationY:0,autoAlpha:1,transformOrigin:"0% 50%"},{scale:1,rotationY:90,autoAlpha:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ,0.3,{scale:1,z:0,rotationY:0,autoAlpha:1,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-turn',				0.5, {x:50,y:0,scale:0,rotationZ:0,rotationX:0,rotationY:-40,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{scale:1,x:0,rotationY:0,autoAlpha:1,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,0.3,{scale:0,rotationY:-40,autoAlpha:1,z:0,x:50,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,true],
			 				['.esg-turnout',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{scale:1,rotationY:40,scale:0.6,autoAlpha:0,x:-50,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,0.3,{scale:1,rotationY:0,z:0,autoAlpha:1,x:0, rotationX:0, rotationZ:0, ease:punchgs.Power3.easeInOut,overwrite:"all"} ],

			 				['.esg-slide',				0.5, {x:-10000,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,x:0, y:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,x:-10000,y:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideout',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,x:0, y:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,x:0,y:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],

			 				['.esg-slideright',			0.5, {xPercent:-50,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:-50,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-sliderightout',		0.5, {autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:50,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-scaleleft',			0.5, {x:0,y:0,scaleX:0,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"100% 50%"},{autoAlpha:1,x:0, scaleX:1, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,x:0,z:0,scaleX:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-scaleright',			0.5, {x:0,y:0,scaleX:0,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"0% 50%"},{autoAlpha:1,x:0, scaleX:1, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,x:0,z:0,scaleX:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],

			 				['.esg-slideleft',			0.5, {xPercent:50,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:50,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideleftout',		0.5, {autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:-50,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"}],

			 				['.esg-slideup',			0.5, {x:0,yPercent:50,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,yPercent:50,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideupout',			0.5, {autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:0,yPercent:-50,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-slidedown',			0.5, {x:0,yPercent:-50,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,yPercent:-50,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slidedownout',		0.5, {autoAlpha:1,yPercent:0, z:0,ease:punchgs.Power3.easeOut,overwrite:"all"},{x:0,yPercent:50,scale:1,rotationZ:0,rotationX:0,z:10,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,yPercent:0,z:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-slideshortright',	0.5, {x:-30,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,x:-30,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideshortrightout',	0.5, {autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:30,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,x:30, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-slideshortleft',		0.5, {x:30,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,x:30,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideshortleftout',	0.5, {autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:-30,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"}],

			 				['.esg-slideshortup',		0.5, {x:0,y:30,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,y:30,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideshortupout',	0.5, {autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:0,y:-30,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-slideshortdown',		0.5, {x:0,y:-30,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,y:-30,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideshortdownout',	0.5, {autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:0,y:30,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],


			 				['.esg-skewright',			0.5, {xPercent:-100,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:60,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,skewX:-60,xPercent:-100,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-skewrightout',		0.5, {autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:100,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:-60,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"}],

			 				['.esg-skewleft',			0.5, {xPercent:100,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:-60,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:100,z:0,skewX:60,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-skewleftout',		0.5, {autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:-100,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:60,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"}],

			 				['.esg-shifttotop',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,y:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],

			 				['.esg-rollleft',			0.5, {xPercent:50,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:90,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:50,z:0,rotationZ:90,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-rollleftout',		0.5, {autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:50,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:90,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-rollright',			0.5, {xPercent:-50,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:-90,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:-50,rotationZ:-90,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-rollrightout',		0.5, {autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:-50,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:-90,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-falldown',			0.4, {x:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0, yPercent:-100},{autoAlpha:1,yPercent:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.4,{yPercent:-100,autoAlpha:0,z:0,ease:punchgs.Power2.easeOut,delay:0.2,overwrite:"all"} ],
			 				['.esg-falldownout',		0.4, {autoAlpha:1,yPercent:0,ease:punchgs.Back.easeOut,overwrite:"all"},{x:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0, yPercent:100},0.4,{autoAlpha:1,yPercent:0,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-rotatescale',		0.3, {x:0,y:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:80,scale:0.6,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1,rotationZ:0,ease:punchgs.Back.easeOut,overwrite:"all"},0.3,{autoAlpha:0,scale:0.6,z:0,rotationZ:80,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-rotatescaleout',		0.3, {autoAlpha:1,scale:1,rotationZ:0,ease:punchgs.Back.easeOut,overwrite:"all"},{x:0,y:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:80,scale:0.6,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,scale:1,rotationZ:0,ease:punchgs.Back.easeOut,overwrite:"all"}],

			 				['.esg-zoomintocorner',		0.5, {x:0, y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"20% 50%"},{autoAlpha:1,scale:1.2, x:0, y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:1,autoAlpha:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoomouttocorner',	0.5, {x:0, y:0,scale:1.2,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"80% 50%"},{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:1.2,autoAlpha:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoomtodefault',		0.5, {x:0, y:0,scale:1.2,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:1.2,autoAlpha:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],

			 				['.esg-zoomback',			0.5, {x:0, y:0,scale:0.2,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:0.2,autoAlpha:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoombackout',		0.5, {autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"},{x:0, y:0,scale:0.2,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.5,{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"}],

			 				['.esg-zoomfront',			0.5, {x:0, y:0,scale:1.5,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:1.5,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoomfrontout',		0.5, {autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"},{x:0, y:0,scale:1.5,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.5,{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"}],

			 				['.esg-flyleft',			0.8, {x:-80, y:0,z:0,scale:0.3,rotationZ:0,rotationY:75,rotationX:10,skewX:0,skewY:0,autoAlpha:0.01,transformOrigin:"30% 10%"},{x:0, y:0, rotationY:0,  z:0.001,rotationX:0,rotationZ:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"},0.8,{autoAlpha:0.01,x:-40, y:0,z:300,rotationY:60,rotationX:20,overwrite:"all"}],
			 				['.esg-flyleftout',			0.8, {x:0, y:0, rotationY:0,  z:0.001,rotationX:0,rotationZ:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"},{x:-80, y:0,z:0,scale:0.3,rotationZ:0,rotationY:75,rotationX:10,skewX:0,skewY:0,autoAlpha:0.01,transformOrigin:"30% 10%"},0.8,{x:0, y:0, rotationY:0,  z:0.001,rotationX:0,rotationZ:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"}],

			 				['.esg-flyright',			0.8, {scale:1,skewX:0,skewY:0,autoAlpha:0,x:80, y:0,z:0,scale:0.3,rotationZ:0,rotationY:-75,rotationX:10,transformOrigin:"70% 20%"},{x:0, y:0, rotationY:0,  z:0.001,rotationX:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"},0.8,{autoAlpha:0,x:40, y:-40,z:300,rotationY:-60,rotationX:-40,overwrite:"all"}],
			 				['.esg-flyrightout',		0.8, {x:0, y:0, rotationY:0,  z:0.001,rotationX:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"},{scale:1,skewX:0,skewY:0,autoAlpha:0,x:80, y:0,z:0,scale:0.3,rotationZ:0,rotationY:-75,rotationX:10,transformOrigin:"70% 20%"},0.8,{x:0, y:0, rotationY:0,  z:0.001,rotationX:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"}],

			 				['.esg-mediazoom',			0.3, {x:0, y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1.4, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"},0.3,{autoAlpha:1,x:0, y:0,scale:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoomandrotate',		0.6, {x:0, y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1.4, x:0, y:0, rotationZ:30,ease:punchgs.Power2.easeOut,overwrite:"all"},0.4,{x:0, y:0,scale:1,z:0,rotationZ:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],

			 				['.esg-pressback',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{rotationY:0,autoAlpha:1,scale:0.8,ease:punchgs.Power3.easeOut,overwrite:"all"} ,0.3,{rotationY:0,autoAlpha:1,z:0,scale:1,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-3dturnright',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformPerspective:600},{x:-40,y:0,scale:0.8,rotationZ:2,rotationX:5,rotationY:-28,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"100% 50% 40%",transformPerspective:600,ease:punchgs.Power3.easeOut,overwrite:"all"} ,0.3,{z:0,x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,force3D:"auto",ease:punchgs.Power2.easeOut,overwrite:"all"} ,true]
			 			   ];

	////////////////////////////////////////
	// THE REVOLUTION PLUGIN STARTS HERE //
	///////////////////////////////////////


	jQuery.fn.extend({

		// OUR PLUGIN HERE :)
		tpessential: function(options) {



				////////////////////////////////
				// SET DEFAULT VALUES OF ITEM //
				////////////////////////////////
				//! DEFAULT OPTIONS
				jQuery.fn.tpessential.defaults = {

					forceFullWidth:"off",
					forceFullScreen:"off",
					fullScreenOffsetContainer:"",
					row:3,
					column:4,
					space:10,						//Spaces between the Grid Elements

					pageAnimation:"fade",			//horizontal-flipbook,  vertical-flipbook,
													//horizontal-flip, vertical-flip,
													//fade,
													//horizontal-slide, vertical-slide,

					animSpeed:600,
					delayBasic:0.08,

					smartPagination:"on",
					paginationScrollToTop:"off",
					paginationScrollToTopOffset:200,

					layout:"even",					//masonry, even, cobbles
					rtl:"off",						// RTL MANAGEMENT

					aspectratio:"auto",				//16:9, 4:3, 1:1, ....

					bgPosition:"center center",		//left,center,right,  top,center,bottom,  50% 50%
					bgSize:"cover",					//cover,contain,normal
					videoJsPath:"",
					overflowoffset:0,
					mainhoverdelay:0,			// The Delay before an Item act on Hover at all.
					rowItemMultiplier:[],
					filterGroupClass:"",
					filterType:"",
					filterLogic:"or",
					showDropFilter:"hover",
					evenGridMasonrySkinPusher:"on",

					loadMoreType:"none",		//none, button, scroll
					loadMoreItems:[],
					loadMoreAmount:5,
					loadMoreTxt : "Load More",
					loadMoreNr:"on",
					loadMoreEndTxt: "No More Items for the Selected Filter",
					loadMoreAjaxUrl:"",
					loadMoreAjaxToken:"",
					loadMoreAjaxAction:"",


					lazyLoad:"off",
					lazyLoadColor:"#ff0000",

					gridID:0,

					mediaFilter:"", 		

					spinner:"",
					spinnerColor:"",

					lightBoxMode:"single",

					cobblesPattern:"",

					searchInput:".faqsearch",

					googleFonts:'',
					googleFontJS:'//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',

					ajaxContentTarget:"",			// In Which Container (ID!) the Content should be loaded
					ajaxScrollToOnLoad:"off",		// On Load the Container should roll up to a position
					ajaxScrollToOffset:100,
					ajaxCallback:"",				// The call back should be called after content is loaded
					ajaxCallbackArgument:"on",		// Extend the Call back function with the object of infos
					ajaxCssUrl:"",					// Load CSS when Ajax loaded 1st time
					ajaxJsUrl:"",					// Load JS when Ajax loaded 1st time
					ajaxCloseButton:"on",
					ajaxNavButton:"on",
					ajaxCloseTxt:"Close",			// The Text what we write default on the Button
					ajaxCloseType:"type1",			// type1 / type2 to show only the buttons, or with text together the buttons
					ajaxClosePosition:"tr",			// Position of the Button  (tl,t,tr,bl,b,br)
					ajaxCloseInner:"true",			// Inner or Outer of the Position
					ajaxCloseStyle:"light",			// Style - Light or Dark
					ajaxTypes:[],					// AWAITING OF OBJECT  type:"type of content", func:jQuery function

					cookies: {
						search:"off",
						filter:"off",
						pagination:"off",
						loadmore:"off",
						timetosave:"30"
					}

				};

					options = jQuery.extend({}, jQuery.fn.tpessential.defaults, options);
					if (typeof WebFontConfig=="undefined") WebFontConfig = new Object();

				return this.each(function() {


					var opt=options;


					var container = jQuery(this);

					opt.contPadTop = parseInt(container.css('paddingTop'),0);
					opt.contPadBottom = parseInt(container.css('paddingBottom'),0);
					
					if (container == undefined) return false;

					container.parent().css({'position':'relative'});

					if (opt.layout=="cobbles") {
						opt.layout = "even";
						opt.evenCobbles = "on";
					} else {
						opt.evenCobbles = "off";
					}

					if (opt.get!="true" && opt.get!=true) {

						opt.get=true;

						// SELECTOR CONTAINER FOR FILTER GROUPS
						if (opt.filterGroupClass==undefined || opt.filterGroupClass.length==0) {
							opt.filterGroupClass = "#" + container.attr('id');
						} else
						   opt.filterGroupClass = "."+opt.filterGroupClass;

						 
						//opt.filterGroupClass = jQuery(opt.filterGroupClass);



						// REPORT SOME IMPORTAN INFORMATION ABOUT THE SLIDER
						if (window.tplogs==true)
							try{
								console.groupCollapsed("Essential Grid  2.0.5 Initialisation on "+container.attr('id'));
								console.groupCollapsed("Used Options:");
								console.info(options);
								console.groupEnd();
								console.groupCollapsed("Tween Engine:")
							} catch(e) {}

						// CHECK IF punchgs.TweenLite IS LOADED AT ALL
						if (punchgs.TweenLite==undefined) {
							if (window.tplogs==true)
							    try {console.error("GreenSock Engine Does not Exist!");} catch(e) {}
							return false;
						}

						punchgs.force3D = true;

						if (window.tplogs==true)
							try {console.info("GreenSock Engine Version in Essential Grid:"+punchgs.TweenLite.version);} catch(e) {}

						punchgs.TweenLite.lagSmoothing(2000, 16);
						punchgs.force3D = "auto";

						if (window.tplogs==true)
							try {
								console.groupEnd();
								console.groupEnd();
								} catch(e) {}


						// FULLSCREEN MODE TESTING
						jQuery("body").data('fullScreenMode',false);
						jQuery(window).on ('mozfullscreenchange webkitfullscreenchange fullscreenchange',function(){
						     jQuery("body").data('fullScreenMode',!jQuery("body").data('fullScreenMode'));

						})


						// CREATE THE SPINNER
						opt.esgloader = buildLoader(container.parent(),opt);

						if (opt.firstshowever==undefined) jQuery(opt.filterGroupClass+'.esg-navigationbutton,'+opt.filterGroupClass+' .esg-navigationbutton').css({visibility:"hidden"});
						// END OF THE SPINNER FUN


						// END OF TEST ELEMENTS


						container.parent().append('<div class="esg-relative-placeholder" style="width:100%;height:auto"></div>');
						container.wrap('<div class="esg-container-fullscreen-forcer" style="position:relative;left:0px;top:0px;width:100%;height:auto;"></div>');
						var offl = container.parent().parent().find('.esg-relative-placeholder').offset().left;

						if (opt.forceFullWidth=="on" || opt.forceFullScreen=="on")
							container.closest('.esg-container-fullscreen-forcer').css({left:(0-offl),width:jQuery(window).width()});

						opt.animDelay = (opt.delayBasic==0) ? "off" : "on" ;

						opt.container = container;
						opt.mainul = container.find('ul').first(),
						opt.mainul.addClass("mainul").wrap('<div class="esg-overflowtrick"></div>');

						// MANIPULATE LEFT / RIGHT BUTTONS
						var ensl = jQuery(opt.filterGroupClass+'.esg-navbutton-solo-left,'+opt.filterGroupClass+' .esg-navbutton-solo-left');
						var ensr = jQuery(opt.filterGroupClass+'.esg-navbutton-solo-right,'+opt.filterGroupClass+' .esg-navbutton-solo-right');

						if (ensl.length>0) {
							ensl.css({marginTop:(0-ensl.height()/2)});
							ensl.appendTo(container.find('.esg-overflowtrick'));
						}

						if (ensr.length>0) {
							ensr.css({marginTop:(0-ensr.height()/2)});
							ensr.appendTo(container.find('.esg-overflowtrick'));
						}


						punchgs.CSSPlugin.defaultTransformPerspective = 1200;

						opt.animSpeed=opt.animSpeed/1000;
						opt.delayBasic=opt.delayBasic/100;


						setOptions(container,opt);

						opt.filter = opt.statfilter;

						opt.origcolumn = opt.column;
						opt.currentpage = 0;

						//opt.started=true;

						container.addClass("esg-layout-"+opt.layout);

						/******************************
							-	CHECK VIDEO API'S	-
						********************************/
						var vhandlers = loadVideoApis(container,opt);


						/**********************************************************************
							-	CHECK IF GRID IS FULLSCREEN AND SET PREDEFINED HEIGHT	-
						**********************************************************************/

						if (opt.layout=="even" && opt.forceFullScreen=="on") {
							var coh = jQuery(window).height();
							if (opt.fullScreenOffsetContainer!=undefined) {
								try{
									var offcontainers = opt.fullScreenOffsetContainer.split(",");
									if (offcontainers)
										jQuery.each(offcontainers,function(index,searchedcont) {
											coh = coh - jQuery(searchedcont).outerHeight(true);
											if (coh<opt.minFullScreenHeight) coh=opt.minFullScreenHeight;
										});
								} catch(e) {}
							}

							var esgo = container.find('.esg-overflowtrick').first();
							var ul = container.find('ul').first();
							esgo.css({display:"block",height:coh+"px"});
							ul.css({display:"block",height:coh+"px"});
							container.closest('.eg-grid-wrapper, .myportfolio-container').css({height:"auto"}).removeClass("eg-startheight");
						}


						/******************************
							-	GOOGLE FONTS PRELOADING	-
						********************************/
						//! GOOGLE FONTS LOADING
						function gridInit(container,opt) {
							mainPreparing(container,opt);
							opt.initialised="ready";
							jQuery('body').trigger('essentialready',container.attr('id'));
						}

						if (opt.googleFonts.length!=0 && opt.layout=="masonry") {
							var fontstoload = opt.googleFonts.length;
							var loadit = true;

							jQuery('head').find('*').each(function(){
								if (jQuery(this).attr('src')!=undefined && jQuery(this).attr('src').indexOf('webfont.js') >0)
										loadit = false;
							});
							if (WebFontConfig.active==undefined && loadit) {
								WebFontConfig = {
									google: { families: opt.googleFonts  },
									active: function() {
												gridInit(container,opt)
									},
									inactive: function() {
											gridInit(container,opt)
									},
									timeout:1500
								};
								var wf = document.createElement('script');
								wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
								   '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
								wf.type = 'text/javascript';
								wf.async = 'true';
								var s = document.getElementsByTagName('script')[0];
								s.parentNode.insertBefore(wf, s);
							} else {
								gridInit(container,opt)
							}
						/**********************************************
							-	WITHOUT GOOGLE FONT, START THE GRID	-
						**********************************************/

						} else {
							gridInit(container,opt)
						}



						/***********************************
							-	LOAD MORE ITEMS HANDLING	-
						************************************/

						//! LOAD MORE ITEMS

						if (opt.loadMoreType=="button") {
							container.append('<div class="esg-loadmore-wrapper" style="text-align:center"><div class="esg-navigationbutton esg-loadmore">LOAD MORE</div></div>');
							opt.lmbut = opt.container.find('.esg-loadmore');
							opt.lmtxt = opt.loadMoreTxt+" ("+checkMoreToLoad(opt).length+")";
														
							if (opt.loadMoreNr=="off")
								opt.lmtxt = opt.loadMoreTxt;

							opt.lmbut.html(opt.lmtxt);

							opt.lmbut.click(function() {
								if (opt.lmbut.data('loading')!=1)
								 loadMoreItems(opt);
							});

							if (checkMoreToLoad(opt).length==0) 
								opt.lmbut.remove();
						}

						else

						if (opt.loadMoreType=="scroll") {

							container.append('<div style="display:inline-block" class="esg-navigationbutton esg-loadmore">LOAD MORE</div>');

							opt.lmbut = opt.container.find('.esg-loadmore');
							opt.lmtxt = opt.loadMoreTxt+" ("+checkMoreToLoad(opt).length+")";
							if (opt.loadMoreNr=="off")
								opt.lmtxt = opt.loadMoreTxt;
							opt.lmbut.html(opt.lmtxt);




							jQuery(document, window).scroll(function() {								
								checkBottomPos(opt,true);

							});
							
							if (checkMoreToLoad(opt).length==0) 
								opt.lmbut.remove();
						}

						checkAvailableFilters(container,opt);
						tabBlurringCheck(container,opt);
					}

				})


		},

		//! METHODS
		// APPEND NEW ELEMENT
		esappend: function(options) {
						// CATCH THE CONTAINER
						var container=jQuery(this);
						prepareItemsInGrid(opt,true);
						//setItemsOnPages(opt);
						organiseGrid(opt,"esappend");
						prepareSortingAndOrders(container);

						return opt.lastslide;

				},
		esskill: function() {
						var container = jQuery(this);
						container.find('*').each(function() {
							jQuery(this).off('click, focus, focusin, hover, play, ended, stop, pause, essentialready');
							jQuery(this).remove();
						});
						container.remove();
						container.html();
						container = null;
				},

		// METHODE CURRENT
		esreadsettings: function(options) {
						options = options == undefined ? new Object : options;
						// CATCH THE CONTAINER
						var container=jQuery(this);
						var opt = getOptions(container);
						return opt;
				},

		// METHODE CURRENT
		esredraw: function(options) {
						options = options == undefined ? new Object : options;
						// CATCH THE CONTAINER
						var container=jQuery(this);
						var opt = getOptions(container);
						if (opt===undefined) return;
						if (options!=undefined) {
							if (options.space!=undefined)  opt.space=parseInt(options.space,0);
							if (options.row!=undefined)  opt.row=parseInt(options.row,0);
							if (options.rtl!=undefined) opt.rtl=options.rtl;
							if (options.aspectratio!=undefined)  opt.aspectratio=options.aspectratio;
							if (options.forceFullWidth!=undefined) {
								opt.forceFullWidth = options.forceFullWidth;
								if (opt.forceFullWidth=="on") {
									var offl = container.parent().parent().find('.esg-relative-placeholder').offset().left;
									container.closest('.esg-container-fullscreen-forcer').css({left:(0-offl),width:jQuery(window).width()});
								}
								else
								container.closest('.esg-container-fullscreen-forcer').css({left:0,width:"auto"});
							}

							if (options.rowItemMultiplier!=undefined) opt.rowItemMultiplier = options.rowItemMultiplier;

							if (options.responsiveEntries!=undefined) opt.responsiveEntries = options.responsiveEntries;

							if (options.column!=undefined)  {
								if (options.column<=0 || options.column>=20) {
									var gbfc = getBestFitColumn(opt,jQuery(window).width(),"id");
									opt.column = gbfc.column;
									opt.columnindex = gbfc.index;
									opt.mmHeight = gbfc.mmHeight;
								} else {
									opt.column=parseInt(options.column,0);
								}
								opt.origcolumn = opt.column;
							}

							if (options.animSpeed!=undefined)  opt.animSpeed=options.animSpeed/1000;
							if (options.delayBasic!=undefined)  opt.delayBasic=options.delayBasic/100;

							if (options.pageAnimation!=undefined)  opt.pageAnimation = options.pageAnimation;
							if (options.changedAnim!=undefined)  opt.changedAnim = options.changedAnim;
							if (options.silent == true) opt.silent=true;
						}


						opt.started=true;

						
						setOptions(container,opt);
						setItemsOnPages(opt);
						organiseGrid(opt,"esredraw");

				},
		// QUICK REDRAW ITEMS
		esquickdraw: function(options) {


						// CATCH THE CONTAINER
						var container=jQuery(this);
						var opt = getOptions(container);
						opt.silent=true;
						setOptions(container,opt);
						setItemsOnPages(opt);
						organiseGrid(opt,"esquickdraw");

		},

		// METHODE CURRENT
		esreinit: function(options) {
						// CATCH THE CONTAINER
						var container=jQuery(this);
						prepareItemsInGrid(opt,true);
						//setItemsOnPages(opt);
						organiseGrid(opt,"esreinit");
						prepareSortingAndOrders(container);

						return opt.lastslide;
				},


		// METHODE JUMP TO SLIDE
		somemethodb: function(slide) {
					return this.each(function() {
						// CATCH THE CONTAINER
						var container=jQuery(this);

					})

				}


})


		function checkBottomPos(opt,scroll) {			
			var bottompos = (opt.container.offset().top + opt.container.height() + (opt.contPadTop + opt.contPadBottom)) - jQuery(document).scrollTop(),
				wh = jQuery(window).height(),
				dh = jQuery(document).height();
			
			if ((opt.lastBottomCompare!=bottompos && wh>=bottompos) || (scroll && wh>=bottompos) || (dh===wh && wh>bottompos)) {		
			
					opt.lastBottomCompare = bottompos;
					if (opt.lmbut && opt.lmbut.data('loading')!=1) {
						opt.lmbut.data('loading',1);								
						loadMoreItems(opt);
					}
			}
		}


		/******************************
			-  COOKIE HaNDLING  -
		*******************************/
		function createCookie(name, value, days) {
		    var expires;

		    if (days) {
		        var date = new Date();
		        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		        expires = "; expires=" + date.toGMTString();
		    } else {
		        expires = "";
		    }
		    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
		}

		function readCookie(name) {
		    var nameEQ = encodeURIComponent(name) + "=";
		    var ca = document.cookie.split(';');
		    for (var i = 0; i < ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
		        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
		    }
		    return null;
		}

		function eraseCookie(name) {
		    createCookie(name, "", -1);
		}


		/******************************
			-	Action on TAB Blur 	-
		********************************/
		var vis = (function(){
		    var stateKey,
		        eventKey,
		        keys = {
		                hidden: "visibilitychange",
		                webkitHidden: "webkitvisibilitychange",
		                mozHidden: "mozvisibilitychange",
		                msHidden: "msvisibilitychange"
		    };
		    for (stateKey in keys) {
		        if (stateKey in document) {
		            eventKey = keys[stateKey];
		            break;
		        }
		    }
		    return function(c) {
		        if (c) document.addEventListener(eventKey, c);
		        return !document[stateKey];
		    }
		})();

		var tabBlurringCheck = function() {

			var notIE = (document.documentMode === undefined),
			    isChromium = window.chrome;

			 if (!jQuery("body").hasClass("esg-blurlistenerexists")) {
				jQuery("body").addClass("esg-blurlistenerexists");
				if (notIE && !isChromium) {

				    // checks for Firefox and other  NON IE Chrome versions
					jQuery(window).on("focusin", function () {

				        setTimeout(function(){
				            // TAB IS ACTIVE, WE CAN START ANY PART OF THE SLIDER
				            jQuery('body').find('.esg-grid.esg-container').each(function() {
				            	jQuery(this).esquickdraw();
				            });
				        },300);

				    }).on("focusout", function () {
						// TAB IS NOT ACTIVE, WE CAN STOP ANY PART OF THE SLIDER
				    });

				} else {

				    // checks for IE and Chromium versions
				    if (window.addEventListener) {

				        // bind focus event
				      window.addEventListener("focus", function (event) {

				            setTimeout(function(){
				                 // TAB IS ACTIVE, WE CAN START ANY PART OF THE SLIDER
					            jQuery('body').find('.esg-grid.esg-container').each(function() {
					            	jQuery(this).esquickdraw();
					            });

				            },300);

				        }, false);



				    } else {

				        // bind focus event
				        window.attachEvent("focus", function (event) {

				            setTimeout(function(){
								// TAB IS ACTIVE, WE CAN START ANY PART OF THE SLIDER
								jQuery('body').find('.esg-grid.esg-container').each(function() {
				            		jQuery(this).esquickdraw();
								});

					         },300);

				        });


				    }
				}
			}
		}

/*********************************
	-	CHECK AVAILABLE FILTERS	-
*********************************/
function checkAvailableFilters(container,opt) {
	/*container.find('.esg-filter-wrapper .esg-filterbutton').each(function() {
		var filt = jQuery(this);

		if (container.find('ul >li.'+filt.data('filter')).length==0) {
			punchgs.TweenLite.to(filt,0.3,{autoAlpha:0.3});
			filt.addClass("notavailablenow");
		} else {
			punchgs.TweenLite.to(filt,0.3,{autoAlpha:1});
		}
	});	*/
}


/*********************************************************
	-	CHECK IF MORE TO LOAD FOR SELECTED FILTERS	-
*********************************************************/

function checkMoreToLoad(opt) {

	var container = opt.container,
		selfilters  = new Array;
		fidlist = new Array,
		searchchanged = jQuery(opt.filterGroupClass+'.esg-filter-wrapper.eg-search-wrapper .eg-justfilteredtosearch').length,
		forcesearch =jQuery(opt.filterGroupClass+'.esg-filter-wrapper.eg-search-wrapper .eg-forcefilter').length;


	jQuery(opt.filterGroupClass+'.esg-filter-wrapper .esg-filterbutton.selected, '+opt.filterGroupClass+' .esg-filter-wrapper .esg-filterbutton.selected').each(function() {
		var fid = jQuery(this).data('fid');
		if (jQuery.inArray(fid,fidlist)==-1) {
			selfilters.push(fid);
			fidlist.push(fid);
		}
	});

	if (jQuery(opt.filterGroupClass+'.esg-filter-wrapper .esg-filterbutton.selected, '+opt.filterGroupClass+' .esg-filter-wrapper .esg-filterbutton.selected').length==0)
		selfilters.push(-1);

	var itemstoload = new Array();


	for (var i=0;i<opt.loadMoreItems.length;i++) {
		jQuery.each(opt.loadMoreItems[i][1],function(index,filtid) {
			jQuery.each(selfilters,function(selindex,selid) {
				if (selid == filtid && opt.loadMoreItems[i][0]!=-1 && (forcesearch==0 || forcesearch==1 && opt.loadMoreItems[i][2]==="cat-searchresult"))
					itemstoload.push(opt.loadMoreItems[i]);
			});
		})
	}
	
	addCountSuffix(container,opt);
	return itemstoload;
}

function addCountSuffix(container,opt) {

	var searchchanged = jQuery(opt.filterGroupClass+'.esg-filter-wrapper.eg-search-wrapper .eg-justfilteredtosearch').length,
		forcesearch =jQuery(opt.filterGroupClass+'.esg-filter-wrapper.eg-search-wrapper .eg-forcefilter').length;
	jQuery(opt.filterGroupClass+'.esg-filter-wrapper.eg-show-amount .esg-filterbutton').each(function() {
		var filter = jQuery(this);
		if (filter.find('.eg-el-amount').length==0 || searchchanged>0 ) {
			var	fid = filter.data('fid'),
				catname = filter.data('filter');
				if (forcesearch>0)
					catname = catname+".cat-searchresult";
			var amount = container.find('.'+catname).length;


			for (var i=0;i<opt.loadMoreItems.length;i++) {
				var found = false;
				if (forcesearch==0)
					jQuery.each(opt.loadMoreItems[i][1],function(index,filtid) {

							if (filtid === fid && opt.loadMoreItems[i][0]!=-1 ) amount++;
					});

				else

				if (jQuery.inArray(fid,opt.loadMoreItems[i][1])!=-1 && opt.loadMoreItems[i][2]==="cat-searchresult") {
					amount++;
				}
			}



			if (filter.find('.eg-el-amount').length==0) filter.append('<span class="eg-el-amount">0</span>');
			countToTop(filter,amount)
		}
	});


	jQuery(opt.filterGroupClass+'.esg-filter-wrapper.eg-search-wrapper .eg-justfilteredtosearch').removeClass("eg-justfilteredtosearch");

}

function countToTop(filter,amount) {

	var output = filter.find('.eg-el-amount'),
		obj = {value:parseInt(output.text(),0)};
	punchgs.TweenLite.to(obj,2,{value:amount,onUpdate:changeCount,onUpdateParams:["{self}",'value'],ease:punchgs.Power3.easeInOut});
	function changeCount(tween,prop) {
		output.html(Math.round(tween.target[prop]));
	}
}

/******************************
	-	BUILD LOADER 	-
********************************/
function buildLoader(container,opt,nominheight) {
		// CREATE THE SPINNER
		if (opt.esgloader != undefined && opt.esgloader.length>0) return false;		

		container.append('<div class="esg-loader '+opt.spinner+'">'+
								  		'<div class="dot1"></div>'+
								  	    '<div class="dot2"></div>'+
								  	    '<div class="bounce1"></div>'+
										'<div class="bounce2"></div>'+
										'<div class="bounce3"></div>'+
									 '</div>');
		esgloader = container.find('.esg-loader');

		if (opt.spinner=="spinner1" || opt.spinner=="spinner2") esgloader.css({backgroundColor:opt.spinnerColor});
		if (opt.spinner=="spinner3" || opt.spinner=="spinner4") container.find('.bounce1, .bounce2, .bounce3, .dot1, .dot2').css({backgroundColor:opt.spinnerColor});
		if (!nominheight) punchgs.TweenLite.to(container,0.3,{minHeight:"100px",zIndex:0});
		return esgloader;
		// END OF THE SPINNER FUN
}

/***********************************
	-	SET LOADED KEYS TO NULL	-
************************************/

function setKeyToNull(opt,key) {
	jQuery.each(opt.loadMoreItems,function(index,item) {
		if (item[0] == key) {
				opt.loadMoreItems[index][0] = -1;
				opt.loadMoreItems[index][2] ="already loaded";
		}
	});
}

/********************************************************
	-	CHECK AMOUNT OF STILL AVAILABLE ELEMENTS	-
********************************************************/
function loadMoreEmpty(opt) {
	var empty = true;

	for (var i=0;i<opt.loadMoreItems.length;i++) {
		if (opt.loadMoreItems[i][0]!=-1)
		  empty= false;
	}	
	return empty;
}


/******************************
	-	LOAD MORE ITEMS	-
********************************/
function loadMoreItems(opt) {
	
	// COLLECT ELEMENTS FROM ARRAY WE NEED TO LOAD
	var container = opt.container,
		availableItems = checkMoreToLoad(opt),
		itemstoload = new Array;


	// LOAD IT IF WE HAVE SOMETHIGN TO LOAD
	jQuery.each(availableItems,function(index,item) {
		if (itemstoload.length<opt.loadMoreAmount) {
			itemstoload.push(item[0]);
			setKeyToNull(opt,item[0]);
		}
	});


	var restitems = checkMoreToLoad(opt).length;

	
	
	if (opt.loadMoreType==="scroll") {			
		opt.esgloader.addClass("infinityscollavailable");		
		if (opt.esgloaderprocess != "add") {
			//console.log("Show Preloader 1. (no delay, speed 0.5)");
			opt.esgloaderprocess = "add";
			punchgs.TweenLite.to(opt.esgloader,0.5,{autoAlpha:1,overwrite:"all"})
		}
	}
	
	



	if (itemstoload.length>0) {
		
		if (opt.lmbut.length>0) {
			punchgs.TweenLite.to(opt.lmbut,0.4,{autoAlpha:0.2});
			opt.lmbut.data('loading',1);
		}


		var objData = {
		     action: opt.loadMoreAjaxAction,
		     client_action: 'load_more_items',
		     token: opt.loadMoreAjaxToken,
		     data: itemstoload,
		     gridid: opt.gridID
		    };


		jQuery.ajax({
		     type:'post',
		     url:opt.loadMoreAjaxUrl,
		     dataType:'json',
		     data:objData
		    }).success(function(data,status,arg3) {

				if (data.success) {
					
					var addit = jQuery(data.data);
					// IF WE ARE IN SEARCH MODE
					if (jQuery(opt.filterGroupClass+'.esg-filter-wrapper.eg-search-wrapper .eg-forcefilter').length>0) addit.addClass("cat-searchresult");
					opt.container.find('ul').first().append(addit);

					checkAvailableFilters(container,opt);

					// CATCH THE CONTAINER
					prepareItemsInGrid(opt,true);
					setItemsOnPages(opt);

					setTimeout(function() {
						opt.animDelay = "off";
						organiseGrid(opt,"Ajax Loaded");
						prepareSortingAndOrders(container);

						if (loadMoreEmpty(opt)) 
							opt.lmbut.remove();													
						else {
							
							opt.lmtxt = opt.loadMoreTxt+" ("+restitems+")";
							if (opt.loadMoreNr=="off")
								opt.lmtxt = opt.loadMoreTxt;


							if ( restitems== 0)
								opt.lmbut.html(opt.loadMoreEndTxt);
							else
								opt.lmbut.html(opt.lmtxt);
							if (opt.lmbut.length>0) {
								punchgs.TweenLite.to(opt.lmbut,0.4,{autoAlpha:1,overwrite:"all"});
								opt.lmbut.data('loading',0);
							}
						}

						setTimeout(function() {
							opt.animDelay = "on";


						},500)

					},10);
				}
		    }).error(function(arg1, arg2, arg3) {
		    	opt.lmbut.html("FAILURE: "+arg2);
		    });


	} else {
		if (loadMoreEmpty(opt)) {			
			opt.lmbut.remove();
			if (opt.loadMoreType==="scroll")  {
				//console.log("Remove Preloader Now");
				opt.esgloader.remove();
				
			}
		} else {
			opt.lmbut.data('loading',0).html(opt.loadMoreEndTxt);
			
		}
	}

	

	//container.find('ul').first().append(li);

}


/*************************************
	-	LOAD AJAX CONTENTS -
*************************************/
function killOldCustomAjaxContent(act) {
	// REMOVE THE CUSTOM CONTAINER LOADED FROM EXTERNAL
					var oldposttype = act.data('lastposttype'),
						postid = act.data('oldajaxsource'),
						posttype = act.data('oldajaxtype'),
						videoaspect = act.data('oldajaxvideoaspect'),
						selector = act.data('oldselector');

					if (oldposttype != undefined && oldposttype!="") {
						try{
							jQuery.each(jQuery.fn.tpessential.defaults.ajaxTypes,function(index,obj) {
									if (obj != undefined && obj.type!=undefined) {
										if (obj.type==oldposttype && obj.killfunc!=undefined)
												setTimeout(function() {
													if (obj.killfunc.call(this,{id:postid,type:posttype,aspectratio:videoaspect,selector:selector})) {
															act.empty();
													}
												},250);
									}
								})
							} catch(e) { console.log(e)}
					}
					act.data('lastposttype',"");
}


////////////////////////////////
// ADD AJAX NAVIGATION //
////////////////////////////////
function addAjaxNavigagtion(opt,act) {
	var acclass = ' eg-acp-'+opt.ajaxClosePosition;
		acclass = acclass+" eg-acp-"+opt.ajaxCloseStyle,
		acclass = acclass+" eg-acp-"+opt.ajaxCloseType,
		loc = "eg-icon-left-open-1",
		roc = "eg-icon-right-open-1",
		xoc = '<i class="eg-icon-cancel"></i>';

	if (opt.ajaxCloseType=="type1") {
			loc = "eg-icon-left-open-big";
			roc = "eg-icon-right-open-big";
			opt.ajaxCloseTxt = "";
			xoc = "X";
	}

	if (opt.ajaxCloseInner=="true" || opt.ajaxCloseInner==true) acclass=acclass+" eg-acp-inner";

	var conttext = '<div class="eg-ajax-closer-wrapper'+acclass+'">';

	if (opt.ajaxClosePosition=="tr" || opt.ajaxClosePosition=="br") {
		if (opt.ajaxNavButton=="on")
			conttext = conttext + '<div class="eg-ajax-left eg-ajax-navbt"><i class="'+loc+'"></i></div><div class="eg-ajax-right eg-ajax-navbt"><i class="'+roc+'"></i></div>';
		if (opt.ajaxCloseButton=="on")
			conttext = conttext + '<div class="eg-ajax-closer eg-ajax-navbt">'+xoc+opt.ajaxCloseTxt+'</div>';

	} else {
		if (opt.ajaxCloseButton=="on")
			conttext = conttext + '<div class="eg-ajax-closer eg-ajax-navbt">'+xoc+opt.ajaxCloseTxt+'</div>';
		if (opt.ajaxNavButton=="on")
			conttext = conttext + '<div class="eg-ajax-left eg-ajax-navbt"><i class="'+loc+'"></i></div><div class="eg-ajax-right eg-ajax-navbt"><i class="'+roc+'"></i></div>';
	}
	conttext = conttext + "</div>";


	switch (opt.ajaxClosePosition) {
		case "tl":
		case "tr":
		case "t":
			act.prepend(conttext);
		break;
		case "bl":
		case "br":
		case "b":
			act.append(conttext);
		break;
	}

	// CLICK ON CLOSE
	act.find('.eg-ajax-closer').click(function() {
		showHideAjaxContainer(act,false,null,null,0.25,true);
	});

	function arrayClickableItems(arr1) {
		var arr2 = new Array();
		jQuery.each(arr1,function(index,obj) {
			if (jQuery(obj).closest('.itemtoshow.isvisiblenow').length>0)
			  arr2.push(obj);
		})
		return arr2;
	}

	// CLICK ON NEXT AJAX CONTENT
	act.find('.eg-ajax-right').click(function() {
		var lastli = act.data('container').find('.lastclickedajax').closest('li'),
			nexts = lastli.nextAll().find('.eg-ajax-a-button'),
			prevs = lastli.prevAll().find('.eg-ajax-a-button');

		nexts = arrayClickableItems(nexts);
		prevs = arrayClickableItems(prevs);

		if (nexts.length>0) {
			nexts[0].click();
		} else {
			prevs[0].click();
		}
	});

	// CLICK ON PREV AJAX CONTENT
	act.find('.eg-ajax-left').click(function() {
		var lastli = act.data('container').find('.lastclickedajax').closest('li'),
			nexts = lastli.nextAll().find('.eg-ajax-a-button'),
			prevs = lastli.prevAll().find('.eg-ajax-a-button');

		nexts = arrayClickableItems(nexts);
		prevs = arrayClickableItems(prevs);

		if (prevs.length>0) {
			prevs[prevs.length-1].click();
		} else {
			nexts[nexts.length-1].click();
		}
	});
}

////////////////////////////////
// SHOW / HIDE AJAX CONTAINER //
////////////////////////////////
function showHideAjaxContainer(act,show,scroll,scrolloffset,speed,kill) {

	 		speed = speed==undefined ? 0.25 : speed;


	 		var opt = act.data('container').data('opt'),
	 			hh = act.data('lastheight') != undefined ? act.data('lastheight') : "100px";


			if (!show) {
				//punchgs.TweenLite.to(act,speed,{autoAlpha:0});
				if (kill) {
					killOldCustomAjaxContent(act);
					hh = "0px";
				}


				punchgs.TweenLite.to(act.parent(),speed,{height:hh, ease:punchgs.Power2.easeInOut,
					onStart:function() {
						punchgs.TweenLite.to(act,speed,{autoAlpha:0,ease:punchgs.Power3.easeOut});
					},
					onComplete:function() {
						setTimeout(function() {
							if (kill) act.html("");
						},300);
					}
				});

			} else {

				speed = speed+1.2;
				addAjaxNavigagtion(opt,act);
				punchgs.TweenLite.set(act,{height:"auto"});
				punchgs.TweenLite.set(act.parent(),{minHeight:0,maxHeight:"none",height:"auto",overwrite:"all"});
				punchgs.TweenLite.from(act,speed,{height:hh, ease:punchgs.Power3.easeInOut,
					onStart:function() {

						punchgs.TweenLite.to(act,speed,{autoAlpha:1,ease:punchgs.Power3.easeOut});

					},
					onComplete:function() {
						act.data('lastheight',act.height());
						jQuery(window).trigger("resize.essg");
						if (act.find('.eg-ajax-closer-wrapper').length==0) addAjaxNavigagtion(opt,act);
					}
				});

				if (opt.ajaxScrollToOnLoad!="off")
					jQuery("html, body").animate({scrollTop:(act.offset().top-scrolloffset)},{queue:false,speed:0.5});
			}
}

////////////////////
// REMOVE LOADER //
////////////////////
function removeLoader(act) {
	act.closest('.eg-ajaxanimwrapper').find('.esg-loader').remove();
}

////////////////////
// AJAX CALL BACK //
////////////////////
function ajaxCallBack(opt,a) {
	if (opt.ajaxCallback==undefined || opt.ajaxCallback=="" || opt.ajaxCallback.length<3)
		return false;

	var splitter = opt.ajaxCallback.split(')'),
		splitter = splitter[0].split('('),
		callback = splitter[0],
		arguments = splitter.length>1 && splitter[1]!="" ? splitter[1]+"," : "",
		obj = new Object();

	try{
		obj.containerid = "#"+opt.ajaxContentTarget,
		obj.postsource = a.data('ajaxsource'),
		obj.posttype = a.data('ajaxtype');

		if (opt.ajaxCallbackArgument == "on")
			eval(callback+"("+arguments+"obj)");
		else
			eval(callback+"("+arguments+")");
		} catch(e) { console.log("Callback Error"); console.log(e)}
}

///////////////////////
// LOAD MORE CONTENT //
///////////////////////
function loadMoreContent(container,opt,a) {

		//MARK THE LAST CLICKED AJAX ELEMENT
		container.find('.lastclickedajax').removeClass("lastclickedajax");
		a.addClass("lastclickedajax");


		var act = jQuery("#"+opt.ajaxContentTarget).find('.eg-ajax-target').eq(0),
			postid = a.data('ajaxsource'),
			posttype = a.data('ajaxtype'),
			videoaspect = a.data('ajaxvideoaspect');

			act.data('container',container);

		if (videoaspect=="16:9")
			videoaspect ="widevideo"
		else
			videoaspect ="normalvideo";


		showHideAjaxContainer(act,false);

		if (act.length>0) {



			// ADD LOAD MORE TO THE CONTAINER
			//try{
				// PRELOAD AJAX JS FILE IN CASE IT NEEDED
				if (opt.ajaxJsUrl!=undefined && opt.ajaxJsUrl!="" && opt.ajaxJsUrl.length>3)	{
					jQuery.getScript(opt.ajaxJsUrl).done( function(script,textStatus) {
						opt.ajaxJsUrl = "";
					})
					.fail(function(jqxhr,settings,exception) {
						console.log("Loading Error on Ajax jQuery File. Please doublecheck if JS File and Path exist:"+opt.ajaxJSUrl);
						opt.ajaxJsUrl = "";
					});
				}
				// PRELOAD AJAX CSSS FILE IN CASE IT NEEDED
				if (opt.ajaxCssUrl!=undefined && opt.ajaxCssUrl!="" && opt.ajaxCssUrl.length>3)	{
					jQuery("<link>")
						.appendTo('head')
						.attr({type:"text/css", rel:"stylesheet"})
						.attr('href', opt.ajaxCssUrl);

					opt.ajaxCssUrl == "";
				}

				buildLoader(act.closest('.eg-ajaxanimwrapper'),opt);

				if (act.data('ajaxload') != undefined)
					act.data('ajaxload').abort();

				killOldCustomAjaxContent(act);

				switch (posttype) {
					// IF THE CONTENT WE LOAD IS FROM A POST
					case "postid":
						var objData = {
										 action: opt.loadMoreAjaxAction,
									     client_action: 'load_more_content',
									     token: opt.loadMoreAjaxToken,
									     postid:postid
									    };

						setTimeout(function() {

							act.data('ajaxload',jQuery.ajax({
							     type:'post',
							     url:opt.loadMoreAjaxUrl,
							     dataType:'json',
							     data:objData
							    }));
							act.data('ajaxload').success(function(data,status,arg3) {

									if (data.success) {
										jQuery(act).html(data.data);
										showHideAjaxContainer(act,true,opt.ajaxScrollToOnLoad,opt.ajaxScrollToOffset);
										removeLoader(act);
										ajaxCallBack(opt,a);

									}
							 })
							 act.data('ajaxload').error(function(arg1, arg2, arg3) {
							 		if (arg2!="abort") {
								    	jQuery(act).append("<p>FAILURE: <strong>"+arg2+"</strong></p>");
										removeLoader(act);
									}
							 });
						},300);
					break;
					// IF THE CONTENER WE LOAD IS A YOUTUBE VIDEO
					case "youtubeid":
						setTimeout(function() {
							act.html('<div class="eg-ajax-video-container '+videoaspect+'"><iframe width="560" height="315" src="//www.youtube.com/embed/'+postid+'?autoplay=1&vq=hd1080" frameborder="0" allowfullscreen></iframe></div>');
						    removeLoader(act);
							showHideAjaxContainer(act,true,opt.ajaxScrollToOnLoad,opt.ajaxScrollToOffset);
							ajaxCallBack(opt,a);
						},300);
					break;
					// IF THE CONTENER WE LOAD IS A VIMEO VIDEO
					case "vimeoid":
						setTimeout(function() {

							act.html('<div class="eg-ajax-video-container '+videoaspect+'"><iframe src="https://player.vimeo.com/video/'+postid+'?portrait=0&autoplay=1" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>');
						    removeLoader(act);
							showHideAjaxContainer(act,true,opt.ajaxScrollToOnLoad,opt.ajaxScrollToOffset);
							ajaxCallBack(opt,a);
						},300);
					break;
					// IF THE CONTENER WE LOAD IS A Wistia VIDEO
					case "wistiaid":
						setTimeout(function() {
							act.html('<div class="eg-ajax-video-container '+videoaspect+'"><iframe src="//fast.wistia.net/embed/iframe/'+postid+'"allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="640" height="388"></iframe></div>');
						    removeLoader(act);
							showHideAjaxContainer(act,true,opt.ajaxScrollToOnLoad,opt.ajaxScrollToOffset);
							ajaxCallBack(opt,a);
						},300);
					break;
					// IF THE CONTENER WE LOAD IS A VIMEO VIDEO
					case "html5vid":
						postid=postid.split("|");
						setTimeout(function() {
							act.html('<video autoplay="true" loop="" class="rowbgimage" poster="" width="100%" height="auto"><source src="'+postid[0]+'" type="video/mp4"><source src="'+postid[1]+'" type="video/webm"><source src="'+postid[2]+'" type="video/ogg"></video>');
						    removeLoader(act);
							showHideAjaxContainer(act,true,opt.ajaxScrollToOnLoad,opt.ajaxScrollToOffset);
							ajaxCallBack(opt,a);
						},300);
					break;
					// IF THE CONTENER WE LOAD IS A VIMEO VIDEO
					case "soundcloud" :
					case "soundcloudid":
						setTimeout(function() {
							act.html('<iframe width="100%" height="250" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'+postid+'&amp;auto_play=true&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>');
						    removeLoader(act);
							showHideAjaxContainer(act,true,opt.ajaxScrollToOnLoad,opt.ajaxScrollToOffset);
							ajaxCallBack(opt,a);
						},300);
					break;
					// IF THE CONTENER WE LOAD IS AN IMAGE
					case "imageurl":
						setTimeout(function() {
							var img = new Image();
							img.onload = function () {
	 							 var img = jQuery(this);
	 							 act.html("");
	 							 img.css({width:"100%",height:"auto"});
								 act.append(jQuery(this));
								 removeLoader(act);
								 showHideAjaxContainer(act,true,opt.ajaxScrollToOnLoad,opt.ajaxScrollToOffset);
								 ajaxCallBack(opt,a);
							}
							img.onerror = function(e) {
								 act.html("Error");
								 removeLoader(act);
								 showHideAjaxContainer(act,true,opt.ajaxScrollToOnLoad,opt.ajaxScrollToOffset);
							};
						    img.src=postid;
						},300);
					break;
					// EXTENDED VARIABLES FOR CONTENT LOADING
					default:
						jQuery.each(jQuery.fn.tpessential.defaults.ajaxTypes,function(index,obj) {

						if (obj.openAnimationSpeed==undefined) obj.openAnimationSpeed=0;

							if (obj != undefined && obj.type!=undefined) {
								if (obj.type==posttype) {
									setTimeout(function() {
										act.data('lastposttype',posttype);
										act.data('oldajaxsource',postid);
										act.data('oldajaxtype',posttype);
										act.data('oldajaxvideoaspect',videoaspect);
										act.data('oldselector',"#"+opt.ajaxContentTarget+' .eg-ajax-target');
										showHideAjaxContainer(act,true,opt.ajaxScrollToOnLoad,opt.ajaxScrollToOffset,0);
										act.html(obj.func.call(this,{id:postid,type:posttype,aspectratio:videoaspect}));
										removeLoader(act);

									},300);
								}
							}
						})

					break;
				}


			  //} catch(e) {}
		}

}

	//////////////////
	// IS MOBILE ?? //
	//////////////////
	var is_mobile = function() {
	    var agents = ['android', 'webos', 'iphone', 'ipad', 'blackberry','Android', 'webos', ,'iPod', 'iPhone', 'iPad', 'Blackberry', 'BlackBerry'];
		var ismobile=false;
	    for(i in agents) {

		    if (navigator.userAgent.split(agents[i]).length>1) {
	            ismobile = true;

	          }
	    }
	    return ismobile;
	}

/********************************************************************************
	-	PREPARE PRESELECTED FILTERS, PAGINATION AND SEARCH BASED ON COOKIES	-
*********************************************************************************/
function resetFiltersFromCookies(opt,triggerclick,otherids) {
	if (opt.cookies.filter=="on") {
				var selectedFilters = otherids!==undefined ? otherids : readCookie("grid_"+opt.girdID+"_filters");

				if (selectedFilters!==undefined && selectedFilters!==null && selectedFilters.length>0) {
					var foundfilters = 0;
					jQuery.each(selectedFilters.split(","),function(index,filt) {
						if (filt!==undefined && filt!==-1 && filt!=="-1") {
							jQuery(opt.filterGroupClass+'.esg-filterbutton,'+opt.filterGroupClass+' .esg-filterbutton').each(function() {								
								if ((jQuery(this).data('fid') == filt || parseInt(jQuery(this).data('fid'),0)===parseInt(filt,0)) && !jQuery(this).hasClass("esg-pagination-button")) {																											
									if (triggerclick) 
											jQuery(this).click();
									else
											jQuery(this).addClass("selected");
									foundfilters++;
								}
							})								
						}
					});
					if (foundfilters>0) 
						jQuery(opt.filterGroupClass+'.esg-filterbutton.esg-allfilter,'+opt.filterGroupClass+' .esg-filterbutton.esg-allfilter').removeClass("selected");
				}
			}
}

function resetPaginationFromCookies(opt,otherids) {
	// HANDLE THE PAGINATION  - WHICH PAGE SHOULD BE SHOWN IF PAGINATION WAS SAVED AS COOKIE
	if (opt.cookies.pagination==="on") {
		var pagec = otherids!==undefined ? otherids : readCookie("grid_"+opt.girdID+"_pagination");		
		if (pagec!==undefined && pagec!==null && pagec.length>0)
		 	jQuery(opt.filterGroupClass+'.esg-filterbutton.esg-pagination-button,'+opt.filterGroupClass+' .esg-filterbutton.esg-pagination-button').each(function() {		 		
		 		if (parseInt(jQuery(this).data('page'),0) === parseInt(pagec,0) && !jQuery(this).hasClass("selected"))
		 			jQuery(this).click();
		 	})
	}
}

function resetSearchFromCookies(opt) {
	if (opt.cookies.search==="on") {
		var lastsearch = readCookie("grid_"+opt.gridID+"_search");
		if (lastsearch!==undefined && lastsearch!=null && lastsearch.length>0) {							
			 jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').val(lastsearch).trigger("change");
			 opt.cookies.searchjusttriggered = true;
		}
	}
}

/*************************************
	-	PREPARING ALL THE GOODIES	-
**************************************/
//! MAIN PREPARING
function mainPreparing(container,opt) {

			/*************************************************************
				-	PREPARE PRESELECTED FILTERS BASED ON COOKIED	-
			**************************************************************/
			resetFiltersFromCookies(opt)

			/*********************************************
				-	BUILD LEFT/RIGHT BIG CONTAINER 	-
			**********************************************/

		/*	container.find('.esg-filters, .navigationbuttons, .esg-pagination').wrapAll('<div class="eg-leftright-container dark"></div>');
			container.find('.eg-filter-clear').remove();
			container.find('.esg-overflowtrick').css({float:"left"});


			if (navcont.length>0) {
						var wcor = navcont.outerWidth(true);
						container.find('.esg-overflowtrick').css({width:container.width() - wcor});
					}
*/
			var navcont = container.find('.eg-leftright-container');
			/*******************************************
				-	PREPARE GRID	-
			*******************************************/

			var gbfc = getBestFitColumn(opt,jQuery(window).width(),"id");
			opt.column = gbfc.column;
			opt.columnindex = gbfc.index;
			opt.mmHeight = gbfc.mmHeight;
			prepareItemsInGrid(opt);
			organiseGrid(opt,"MainPreparing");

			/***********************************
				-	PREPARE SEARCH FUNCTION	-
			***********************************/
			if (jQuery(opt.filterGroupClass+'.eg-search-wrapper').length>0) {

				var fgc = opt.filterGroupClass.replace(".",""),
					srch = "Search Result",
					submit = jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-submit'),
					clear = jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-clean');

				jQuery(opt.filterGroupClass+".esg-filter-wrapper.eg-search-wrapper").append('<div style="display:none !important" class="esg-filterbutton hiddensearchfield '+fgc+'" data-filter="cat-searchresult"><span>'+srch+'</span></div>');

				opt.lastsearchtimer = 0;

				function inputsubmited() {
					if (opt.lastsearchtimer == 1) return false;
					opt.lastsearchtimer = 1;

					buildLoader(jQuery(opt.filterGroupClass+'.eg-search-wrapper'),{ spinner:"spinner3", spinnerColor:"#fff"},true);

					punchgs.TweenLite.fromTo(jQuery(opt.filterGroupClass+'.eg-search-wrapper').find('.esg-loader'),0.3,{autoAlpha:0},{autoAlpha:1,ease:punchgs.Power3.easeInOut});

					var ifield = jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input'),
						ival = ifield.val(),
						hidsbutton = jQuery(opt.filterGroupClass+'.eg-search-wrapper.esg-filter-wrapper .hiddensearchfield');

					ifield.attr('disabled','true');

					if (ival.length>0) {
						ifield.trigger("searchstarting");						
						var searchdata = {search:ival,id:opt.gridID},
							objData = {
						     action: opt.loadMoreAjaxAction,
						     client_action: 'get_grid_search_ids',
						     token: opt.loadMoreAjaxToken,
						     data: searchdata
						    };


						jQuery.ajax({
						     type:'post',
						     url:opt.loadMoreAjaxUrl,
						     dataType:'json',
						     data:objData
						 }).success(function(result,status,arg3) {
						 		
						 		// SAVE THE COOKIE FOR THE CURRENT GRID WITH LAST SEARCH RESULT						 		
						 		if (opt.cookies.search==="on")
						 			createCookie("grid_"+opt.gridID+"_search", ival, opt.cookies.timetosave*(1/60/60));

							 	if (opt.cookies.searchjusttriggered === true) {	
							 		var cpageids = readCookie("grid_"+opt.girdID+"_pagination"),
							 			cfilterids = readCookie("grid_"+opt.girdID+"_filters");
							 		setTimeout(function() {							 			
							 			resetFiltersFromCookies(opt,true,cfilterids);										
							 			resetPaginationFromCookies(opt,cpageids);
									},200);
									opt.cookies.searchjusttriggered = false;
								}
							 	setTimeout(function() {
								 	opt.lastsearchtimer = 0;
								 	jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').attr('disabled',false);
									punchgs.TweenLite.to(jQuery(opt.filterGroupClass+'.eg-search-wrapper').find('.esg-loader'),0.5,{autoAlpha:1,ease:punchgs.Power3.easeInOut,onComplete:function() {
										jQuery(opt.filterGroupClass+'.eg-search-wrapper').find('.esg-loader').remove();
									}});
									jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').trigger("searchended");
								},1000);
							   	var rarray = new Array();
							   	if (result)
							 		jQuery.each(result,function(index,id){
								 		if (id!=undefined && jQuery.isNumeric(id))
								 			rarray.push(id);
							 		});

						 		//CALL AJAX TO GET ID'S FOR RESULTS
								container.find('.cat-searchresult').removeClass("cat-searchresult");
								var found = 0;

								jQuery.each(opt.loadMoreItems,function(andex,litem) {
									litem[2]="notsearched";
									jQuery.each(rarray,function(bndex,id){
										if (parseInt(litem[0],0) === parseInt(id,0) && parseInt(litem[0],0)!=-1) {
											litem[2]="cat-searchresult";
											found++;
											return false;
										}
									});
								});


								jQuery.each(rarray,function(index,id){
									container.find('.eg-post-id-'+id).addClass("cat-searchresult");
								})
								hidsbutton.addClass("eg-forcefilter").addClass("eg-justfilteredtosearch");
								jQuery(opt.filterGroupClass+'.esg-filter-wrapper .esg-allfilter').trigger("click");

						}).error(function(arg1, arg2, arg3) {
							console.log("FAILURE: "+arg2);
							setTimeout(function() {
								 	opt.lastsearchtimer = 0;
								 	jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').attr('disabled',false);
									punchgs.TweenLite.to(jQuery(opt.filterGroupClass+'.eg-search-wrapper').find('.esg-loader'),0.5,{autoAlpha:1,ease:punchgs.Power3.easeInOut,onComplete:function() {
										jQuery(opt.filterGroupClass+'.eg-search-wrapper').find('.esg-loader').remove();
									}});
									jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').trigger("searchended");
							},1000);
						});


					} else {
						jQuery.each(opt.loadMoreItems,function(andex,litem) {litem[2]="notsearched";});
						container.find('.cat-searchresult').removeClass("cat-searchresult");
						var hidsbutton = jQuery(opt.filterGroupClass+'.eg-search-wrapper.esg-filter-wrapper .hiddensearchfield');
						hidsbutton.removeClass("eg-forcefilter").addClass("eg-justfilteredtosearch");
						
						// CLEAR COOKIE, FIELD IS EMPTY
						if (opt.cookies.search==="on")						 			
				    		createCookie("grid_"+opt.gridID+"_search", "", -1);
						
						jQuery(opt.filterGroupClass+'.esg-filter-wrapper .esg-allfilter').trigger("click");
						setTimeout(function() {
								 	opt.lastsearchtimer = 0;
								 	jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').attr('disabled',false);
									punchgs.TweenLite.to(jQuery(opt.filterGroupClass+'.eg-search-wrapper').find('.esg-loader'),0.5,{autoAlpha:1,ease:punchgs.Power3.easeInOut,onComplete:function() {
										jQuery(opt.filterGroupClass+'.eg-search-wrapper').find('.esg-loader').remove();
									}});
									jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').trigger("searchended");
						},1000);

					}
				};
				
				
				
				submit.click(inputsubmited);
				jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').on("change",inputsubmited);

				clear.click(function() {
					if (opt.cookies.search==="on")						 			
				    	createCookie("grid_"+opt.gridID+"_search", "", -1);
		
					jQuery.each(opt.loadMoreItems,function(andex,litem) {litem[2]="notsearched";});
					container.find('.cat-searchresult').removeClass("cat-searchresult");
					var hidsbutton = jQuery(opt.filterGroupClass+'.eg-search-wrapper.esg-filter-wrapper .hiddensearchfield');
					jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').val("");
					hidsbutton.removeClass("eg-forcefilter").addClass("eg-justfilteredtosearch");
					jQuery(opt.filterGroupClass+'.esg-filter-wrapper .esg-allfilter').trigger("click");
					setTimeout(function() {
					 	opt.lastsearchtimer = 0;
					 	jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').attr('disabled',false);
						punchgs.TweenLite.to(jQuery(opt.filterGroupClass+'.eg-search-wrapper').find('.esg-loader'),0.5,{autoAlpha:1,ease:punchgs.Power3.easeInOut,onComplete:function() {
							jQuery(opt.filterGroupClass+'.eg-search-wrapper').find('.esg-loader').remove();
						}});
						jQuery(opt.filterGroupClass+'.eg-search-wrapper .eg-search-input').trigger("searchended");
					},1000);

				})

			}

			
			addCountSuffix(container,opt);


			/***************************************
				-	PREPARE DROP DOWN FILTERS	-
			****************************************/
			jQuery(opt.filterGroupClass+'.esg-filter-wrapper,'+opt.filterGroupClass+' .esg-filter-wrapper').each(function(i) {

				var efw = jQuery(this);

				if (efw.hasClass("dropdownstyle")) {
									efw.find('.esg-filter-checked').each(function() {
						jQuery(this).prependTo(jQuery(this).parent());
					})

					if (!is_mobile()) {
						if (opt.showDropFilter=="click") {
							efw.click(function() {
								var efw = jQuery(this).closest('.esg-filter-wrapper');
								efw.find('.esg-selected-filterbutton').addClass("hoveredfilter");
								efw.find('.esg-dropdown-wrapper').stop().show();
							});
							efw.on("mouseleave",function() {
								var efw = jQuery(this).closest('.esg-filter-wrapper');
								efw.find('.esg-selected-filterbutton').removeClass("hoveredfilter");
								efw.find('.esg-dropdown-wrapper').stop().hide();
	
							});
						} else {
							efw.hover(function() {
								var efw = jQuery(this).closest('.esg-filter-wrapper');
								efw.find('.esg-selected-filterbutton').addClass("hoveredfilter");
								efw.find('.esg-dropdown-wrapper').stop().show();
							},function() {
								var efw = jQuery(this).closest('.esg-filter-wrapper');
								efw.find('.esg-selected-filterbutton').removeClass("hoveredfilter");
								efw.find('.esg-dropdown-wrapper').stop().hide();
	
							})
						}
					} else {
						efw.find('.esg-selected-filterbutton').click(function() {															
							var esfb = efw.find('.esg-selected-filterbutton');
							if (esfb.hasClass("hoveredfilter")) {																		
									esfb.removeClass("hoveredfilter");									
									efw.find('.esg-dropdown-wrapper').stop().hide();
								
							} else {		
									esfb.addClass("hoveredfilter");									
									efw.find('.esg-dropdown-wrapper').stop().show();														
							}							
						});
					}

					
				}
			});

			if (is_mobile()) {
				jQuery(document).on('click touchstart',function(event) {		
					var p = jQuery(event.target).closest('.esg-filter-wrapper');
					if (p.length==0) {										
						opt.container.find('.hoveredfilter').removeClass("hoveredfilter");					
						opt.container.find('.esg-dropdown-wrapper').stop().hide();							
					}					
				})
			}

			opt.container.find('.esg-filters').each(function(i) {
				punchgs.TweenLite.set(this,{zIndex:(70-i)});
			})

			opt.container.find('.esg-filter-wrapper.dropdownstyle').each(function(i) {
				punchgs.TweenLite.set(this,{zIndex:(1570-i)});
			})
			


			/***********************************************
				-	HANDLE OF LEFT NAVIGATION BUTTON	-
			*************************************************/
			jQuery("body").on("click",opt.filterGroupClass+'.esg-left,'+opt.filterGroupClass+' .esg-left',function() {
				opt = getOptions(container);
				opt.oldpage = opt.currentpage;
				opt.currentpage--;

				if (opt.currentpage<0) opt.currentpage = opt.realmaxpage-1;

				var gbfc = getBestFitColumn(opt,jQuery(window).width(),"id");
				opt.column = gbfc.column;
				opt.columnindex = gbfc.index;
				opt.mmHeight = gbfc.mmHeight;

				setItemsOnPages(opt);
				organiseGrid(opt,"LeftNavigation");
				setOptions(container,opt);
				stopAllVideos(true);
			});


			/***********************************************
				-	HANDLE OF RIGHT NAVIGATION BUTTON	-
			***********************************************/
			jQuery("body").on("click",opt.filterGroupClass+'.esg-right,'+opt.filterGroupClass+' .esg-right',function() {
				opt = getOptions(container);
				opt.oldpage = opt.currentpage;
				opt.currentpage++;

				if (opt.currentpage>=opt.realmaxpage) opt.currentpage = 0;

				var gbfc = getBestFitColumn(opt,jQuery(window).width(),"id");
				opt.column = gbfc.column;
				opt.columnindex = gbfc.index;
				opt.mmHeight = gbfc.mmHeight;

				setItemsOnPages(opt);
				organiseGrid(opt,"RightNavigation");
				setOptions(container,opt);
				stopAllVideos(true);
			})


			/**************************************
				-	HANDLE OF FILTER BUTTONS	-
			****************************************/

			jQuery(opt.filterGroupClass+'.esg-filterbutton, '+opt.filterGroupClass+' .esg-filterbutton').each(function() {

				if (!jQuery(this).hasClass("esg-pagination-button"))
					jQuery(this).click(function() {

						var opt = getOptions(container);


						stopAllVideos(true);
						var efb = jQuery(this);

						// TURN OFF ALL SELECTED BUTTON
						if (!efb.hasClass("esg-pagination-button")) {
							jQuery(opt.filterGroupClass+'.esg-allfilter, '+opt.filterGroupClass+' .esg-allfilter').removeClass("selected");
							if (efb.hasClass("esg-allfilter")) {
								jQuery(opt.filterGroupClass+'.esg-filterbutton, '+opt.filterGroupClass+' .esg-filterbutton').each(function() {
									 jQuery(this).removeClass("selected");
								})
							}
						}

						if (efb.closest('.esg-filters').hasClass("esg-singlefilters") || opt.filterType=="single") {
								jQuery(opt.filterGroupClass+'.esg-filterbutton, '+opt.filterGroupClass+' .esg-filterbutton').each(function() {
									 jQuery(this).removeClass("selected");
								})
								efb.addClass("selected")
						} else {
							if (efb.hasClass("selected"))
								efb.removeClass("selected")
							else
								efb.addClass("selected")
						}

						var hidsbutton = jQuery(opt.filterGroupClass+'.esg-filter-wrapper .hiddensearchfield');
						if (hidsbutton.hasClass("eg-forcefilter")) hidsbutton.addClass("selected");

						var countofselected=0,
							filtcookie = "";
						jQuery(opt.filterGroupClass+'.esg-filterbutton.selected,'+opt.filterGroupClass+' .esg-filterbutton.selected').each(function() {
							if (jQuery(this).hasClass("selected") && !jQuery(this).hasClass("esg-pagination-button")) {
							  countofselected++;							
							  filtcookie = countofselected===0 ? jQuery(this).data('fid') : filtcookie+","+jQuery(this).data('fid');
							 }

						})

						// CREATE A COOKIE FOR THE LAST SELECTION OF FILTERS
						if (opt.cookies.filter==="on" && opt.cookies.searchjusttriggered !== true) 
							createCookie("grid_"+opt.girdID+"_filters",filtcookie,opt.cookies.timetosave*(1/60/60));
						

						if (countofselected==0)
						  jQuery(opt.filterGroupClass+'.esg-allfilter,'+opt.filterGroupClass+' .esg-allfilter').addClass("selected");

				 		opt.filterchanged = true;
				 		opt.currentpage=0;

				 		if (opt.maxpage==1) {
						 	 jQuery(opt.filterGroupClass+'.navigationbuttons,'+opt.filterGroupClass+' .navigationbuttons').css({display:'none'});
						 	 jQuery(opt.filterGroupClass+'.esg-pagination,'+opt.filterGroupClass+' .esg-pagination').css({display:'none'});
					 	} else {
						 	 jQuery(opt.filterGroupClass+'.navigationbuttons,'+opt.filterGroupClass+' .navigationbuttons').css({display:'inline-block'});
						 	 jQuery(opt.filterGroupClass+'.esg-pagination,'+opt.filterGroupClass+' .esg-pagination').css({display:'inline-block'});
					 	}
					 	
						if (opt.lmbut!=undefined && opt.lmbut.length>0)	{
							var itemtoload = checkMoreToLoad(opt).length;
							if (itemtoload>0) {
								if (opt.loadMoreNr=="off")
									opt.lmbut.html(opt.loadMoreTxt);
								else								
									opt.lmbut.html(opt.loadMoreTxt+" ("+itemtoload+")");
							}
							else
								opt.lmbut.data('loading',0).html(opt.loadMoreEndTxt);

						} 



						setItemsOnPages(opt);
						organiseGrid(opt,"filtergroup");
						setOptions(container,opt);
					})


			})


			/*****************************************
				-	IN CASE WINDOW IS RESIZED 	-
			******************************************/
			var resizetimer;


			jQuery(window).on("resize.essg",function() {
					clearTimeout(resizetimer);

					if (opt.forceFullWidth=="on" || opt.forceFullScreen=="on") {
						var offl = container.parent().parent().find('.esg-relative-placeholder').offset().left;
						container.closest('.esg-container-fullscreen-forcer').css({left:(0-offl),width:jQuery(window).width()});
					}
					else
						container.closest('.esg-container-fullscreen-forcer').css({left:0,width:"auto"});

					if (navcont.length>0) {
						var wcor = navcont.outerWidth(true);

						punchgs.TweenLite.set(container.find('.esg-overflowtrick'),{width:container.width() - wcor,overwrite:"all"});
					}


				var gbfc = getBestFitColumn(opt,jQuery(window).width(),"id");
				opt.column = gbfc.column;
				opt.columnindex = gbfc.index;
				opt.mmHeight = gbfc.mmHeight;

				setOptions(container,opt);
				resizetimer = setTimeout(function() {
					opt = getOptions(container);					
					setItemsOnPages(opt);
					organiseGrid(opt,"resize");
					setOptions(container,opt);
				},200);
				//stopAllVideos(true);

			});


			/************************************************
				-	Container Height to right position	-
			************************************************/


			container.on('itemsinposition',function() {

				var container = jQuery(this),
					opt = getOptions(container);				

				clearTimeout(opt.iteminspositiontimer);
				opt.iteminspositiontimer = setTimeout(function() {

					
					var navcont = container.find('.eg-leftright-container');
					
					clearTimeout(container.data('callednow'));


					if (opt.maxheight>0 && opt.maxheight<9999999999) {
						opt.inanimation = false;
						var esgo = container.find('.esg-overflowtrick').first();
							ul = opt.mainul,
							navcont = container.find('.eg-leftright-container');


						var padtop = parseInt(esgo.css('paddingTop'),0);
						padtop = padtop == undefined ? 0 : padtop;
						padtop = padtop == null ? 0 : padtop;
						var padbot = parseInt(esgo.css('paddingBottom'),0);
						padbot = padbot == undefined ? 0 : padbot;
						padbot = padbot == null ? 0 : padbot;

						var newheight = opt.maxheight+opt.overflowoffset+padtop+padbot;

						if (opt.forceFullScreen=="on") {
							var coh = jQuery(window).height();
							if (opt.fullScreenOffsetContainer!=undefined) {
								try{
									var offcontainers = opt.fullScreenOffsetContainer.split(",");
									jQuery.each(offcontainers,function(index,searchedcont) {
										coh = coh - jQuery(searchedcont).outerHeight(true);

										if (coh<opt.minFullScreenHeight) coh=opt.minFullScreenHeight;
									});
								} catch(e) {}
							}

							newheight =coh;
						}

						var heightspeed = 0.3;


						if (ul.height()<200)
							heightspeed = 1;
						punchgs.TweenLite.to(ul,heightspeed,{force3D:"auto",height:newheight,ease:punchgs.Power3.easeInOut,clearProps:"transform"});
						punchgs.TweenLite.to(esgo,heightspeed,{force3D:true,height:newheight,ease:punchgs.Power3.easeInOut,clearProps:"transform",onComplete:function() {
							container.closest('.eg-grid-wrapper, .myportfolio-container').css({height:"auto"}).removeClass("eg-startheight");
						}});


						if (navcont.length>0)
							punchgs.TweenLite.set(navcont,{minHeight:newheight,ease:punchgs.Power3.easeInOut});

							var ensl = jQuery(opt.filterGroupClass+'.esg-navbutton-solo-left,'+opt.filterGroupClass+' .esg-navbutton-solo-left');
							var ensr = jQuery(opt.filterGroupClass+'.esg-navbutton-solo-right,'+opt.filterGroupClass+' .esg-navbutton-solo-right');

							if (ensl.length>0)
								ensl.css({marginTop:(0-ensl.height()/2)});


							if (ensr.length>0)
								ensr.css({marginTop:(0-ensr.height()/2)});

					} else {
						if (opt.maxheight==0) {
							var esgo = container.find('.esg-overflowtrick').first();
							var ul = container.find('ul').first();
							punchgs.TweenLite.to(ul,1,{force3D:"auto",height:0,ease:punchgs.Power3.easeInOut,clearProps:"transform"});
							punchgs.TweenLite.to(esgo,1,{force3D:true,height:0,ease:punchgs.Power3.easeInOut,clearProps:"transform"});
						}
					}
					container.data('callednow',setTimeout(function() {
						container.find('.itemtoshow.isvisiblenow').each(function() {
							hideUnderElems(jQuery(this));
						})
					},250));

					// IF WE ARE IN THE FIRST LOAD AND ACTIVATE PROCESS
					if (opt.firstLoadFinnished===undefined) {
						container.trigger("essential_grid_ready_to_use");
						
						// HANDLE THE COOKIES WHICH NEED TO BE HANDLED AFTER FIRST LOAD
						resetSearchFromCookies(opt);

						// HANDLE THE PAGINATION  - WHICH PAGE SHOULD BE SHOWN IF PAGINATION WAS SAVED AS COOKIE
						resetPaginationFromCookies(opt);

						opt.firstLoadFinnished = true;
					}
				
				},50);

			});
		

			prepareSortingAndOrders(container);
			prepareSortingClicks(container);

}

/**********************************************
	-	PREPARE SORTING AND ORDERS 	-
**********************************************/

function prepareSortingAndOrders(container) {

			var opt = getOptions(container);

			/************************************************
				-	HANDLING OF SORTING ISSUES   -
			*************************************************/

			// PREPARE THE DATE SRINGS AND MAKE A TIMESTAMP OF IT
			container.find('.tp-esg-item').each(function() {
				var dd = new Date(jQuery(this).data('date'));
				jQuery(this).data('date',dd.getTime()/1000);
			})

			jQuery(opt.filterGroupClass+'.esg-sortbutton-order,'+opt.filterGroupClass+' .esg-sortbutton-order').each(function() {
				var eso = jQuery(this);
				eso.removeClass("tp-desc").addClass("tp-asc");
				eso.data('dir',"asc");
			})
	}

function prepareSortingClicks(container) {

			opt = getOptions(container);
			var resizetimer;

			jQuery(opt.filterGroupClass+'.esg-sortbutton-wrapper .esg-sortbutton-order,'+opt.filterGroupClass+' .esg-sortbutton-wrapper .esg-sortbutton-order').click(function() {
				var eso = jQuery(this);
				if (eso.hasClass("tp-desc")) {
					eso.removeClass("tp-desc").addClass("tp-asc");
					eso.data('dir',"asc");
				} else {
					eso.removeClass("tp-asc").addClass("tp-desc");
					eso.data('dir',"desc");
				}

				var dir = eso.data('dir');

				stopAllVideos(true,true);
				jQuery(opt.filterGroupClass+'.esg-sorting-select,'+opt.filterGroupClass+' .esg-sorting-select').each(function() {

					var sorter = jQuery(this).val();
					clearTimeout(resizetimer);
					container.find('.tp-esg-item').tsort({data:sorter,forceStrings:"false",order:dir});
					resizetimer = setTimeout(function() {
						opt = getOptions(container);
						setItemsOnPages(opt);
						organiseGrid(opt,"preparSorting");
						setOptions(container,opt);
					},200);

				});

			})

			// SORTING FUNCTIONS
			jQuery(opt.filterGroupClass+'.esg-sorting-select,'+opt.filterGroupClass+' .esg-sorting-select').each(function() {
				var sel = jQuery(this);

				sel.change(function() {
					//container.find('iframe').css({visibility:'hidden'});
					//container.find('.video-eg').css({visibility:'hidden'});

					var eso = jQuery(this).closest('.esg-sortbutton-wrapper').find('.esg-sortbutton-order');

					var sorter = sel.val();
					var sortername = sel.find('option:selected').text();
					var dir = eso.data('dir');
					stopAllVideos(true,true);
					clearTimeout(resizetimer);
					sel.parent().parent().find('.sortby_data').text(sortername);
					var sorted = container.find('.tp-esg-item').tsort({data:sorter,forceStrings:"false",order:dir});
					if (sorted!==undefined) {
					
						opt = getOptions(container);
						setItemsOnPages(opt);
						organiseGrid(opt,"OnSorting");
						setOptions(container,opt);
					}
				});
			});


}


function fixCenteredCoverElement(item,ecc,media) {

		  if (ecc==undefined) ecc = item.find('.esg-entry-cover');
		  if (media==undefined)  media = item.find('.esg-entry-media');
		  if (ecc && media) {
			  var mh = media.outerHeight();			  
			  punchgs.TweenLite.set(ecc,{height:mh});
			  var cc = item.find('.esg-cc');
			  punchgs.TweenLite.set(cc,{top:((mh - cc.height()) / 2 )});
		 }

}




/********************************************
	-	GET BEST FITTING COLUMN AMOUNT 	-
********************************************/
function getBestFitColumn(opt,winw,resultoption) {
	var lasttop = winw,
		lastbottom = 0,
		smallest =9999,
		largest = 0,
		samount = opt.column,
		lamoung = opt.column,
		lastamount = opt.column,
		resultid = 0,
		resultidb = 0;

	if (opt.responsiveEntries!=undefined && opt.responsiveEntries.length>0)
		jQuery.each(opt.responsiveEntries, function(index,obj) {
			var curw = obj.width != undefined ? obj.width : 0,
				cura = obj.amount != undefined ? obj.amount : 0;

			if (smallest>curw) {
				smallest = curw;
				samount = cura;
				resultidb = index;

			}
			if (largest<curw) {
				largest = curw;
				lamount = cura;
			}

			if (curw>lastbottom && curw<=lasttop) {
					lastbottom = curw;
					lastamount = cura;
					resultid = index;
			}
		})

	if (smallest>winw) {
		lastamount = samount;
		resultid = resultidb;
	}

	var obj = new Object;
	obj.index = resultid;
	obj.column = lastamount;
	obj.mmHeight = opt.responsiveEntries[obj.index].mmheight;	
	if (resultoption=="id")
		return obj;
	else
		return lastamount;
}



/******************************
	-	Get Options	-
********************************/
 function getOptions(container){
 	return container.data('opt');
 };

/******************************
	-	Set Options	-
********************************/
 function setOptions(container,opt){
 	container.data('opt',opt);
 };


/******************************
	-	CHECK MEDIA LISTENERS	-
********************************/
function checkMediaListeners(item) {
	// MAKE SURE THAT YOUTUBE OR VIMEO PLAYER HAS LISTENER
	item.find('iframe').each(function(i) {
		var ifr = jQuery(this);
		if (ifr.attr('src').toLowerCase().indexOf('youtube')>0) prepareYT(ifr)
		else
		if (ifr.attr('src').toLowerCase().indexOf('vimeo')>0) prepareVimeo(ifr);
		else
		if (ifr.attr('src').toLowerCase().indexOf('wistia')>0) prepareWs(ifr)
		else
		if (ifr.attr('src').toLowerCase().indexOf('soundcloud')>0) prepareSoundCloud(ifr);
	 })

	 //  VIDEO PLAYER HAS LISTENER ?
     item.find('video').each(function(i) {
		prepareVideo(jQuery(this));
 	 })

}


/******************************
	-	CHECK MEDIA LISTENERS	-
********************************/
function waitMediaListeners(item) {
	 var ifr =  item.find('iframe').first(),
	 	 vid = item.find('video').first(),
	 	 vt = ifr.length>0 && ifr.attr('src').toLowerCase().indexOf('youtube')>0 ? "y" :
	 	 	  ifr.length>0 && ifr.attr('src').toLowerCase().indexOf('vimeo')>0 ? "v" :
	 	 	  ifr.length>0 &&  ifr.attr('src').toLowerCase().indexOf('wistia')>0 ? "w" :
	 	 	  ifr.length>0 && ifr.attr('src').toLowerCase().indexOf('soundcloud')>0 ? "s" :
	 	 	  vid.length>0 && vid.length>=1 ? "h" : "";

	 var intr = setInterval(function() {
		// MAKE SURE THAT YOUTUBE OR VIMEO PLAYER HAS LISTENER
		item.find('iframe').each(function(i) {			
			if (vt==="" || (vt==="y" && prepareYT(ifr)) || (vt==="v" && prepareVimeo(ifr)) || (vt==="w" && prepareWs(ifr)) || (vt==="s" && prepareSoundCloud(ifr)) || (vt==="h" && prepareVideo(ifr)))
				clearInterval(intr);			
		 })
	 },50)

}


/******************************
	-	DIRECTION CALCULATOR	-
********************************/
function directionPrepare(direction,effect,ww,hh,correction) {

		var xy = new Object;
		switch( direction ) {
			case 0:
				// from top
				xy.x = 0;
				xy.y = effect=="in" ? (0 - hh): (10+hh);
				xy.y = correction  && effect=="in" ? xy.y -5 : xy.y;
				break;
			case 1:
				// from right
				xy.y = 0;
				xy.x = effect=="in" ? ww : -10-ww;
				xy.x = correction  && effect=="in" ? xy.x + 5 : xy.x;
				break;
			case 2:
				// from bottom
				xy.y = effect=="in" ? hh : (-10-hh);
				xy.x = 0;
				xy.y = correction  && effect=="in" ? xy.y  + 5 : xy.y;
				break;
			case 3:
				// from left
				xy.y = 0;
				xy.x = effect=="in" ? (0-ww) : (10+ww) ;
				xy.x = correction  && effect=="in" ? xy.x - 5 : xy.x;
				break;
		};
		return xy;
}

/********************************************
	-	GET THE MOUSE MOVE DIRECTION	-
********************************************/

function getDir( item, coordinates ) {

			// the width and height of the current div
			var w = item.width(),
				h = item.height(),
				x = ( coordinates.x - item.offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
				y = ( coordinates.y - item.offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),
				direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 ) % 4;
				return direction;
			}


function hideUnderElems(item) {
	item.find('.eg-handlehideunder').each(function() {
		var elem = jQuery(this);
		var hideunder = elem.data('hideunder'),
			hideunderheight = elem.data('hideunderheight'),
			hidetype = elem.data('hidetype');
		if (elem.data('knowndisplay')==undefined)  elem.data('knowndisplay',elem.css("display"));


		if ((item.width()<hideunder && hideunder!=undefined) ||  (item.height()<hideunderheight && hideunderheight!=undefined)) {
		    if (hidetype == "visibility")
		    	elem.addClass("forcenotvisible");
		     else

			 if (hidetype == "display")
		   		elem.addClass("forcenotdisplay");

		} else {
		     if (hidetype == "visibility")
		    	elem.removeClass("forcenotvisible");
		      else

			  if (hidetype == "display")
		   		elem.removeClass("forcenotdisplay");
		}
	 });

}


/**********************************************
	-	Even Grid with MasonrySkin Pusher	-
***********************************************/

function offsetParrents(off,item) {
	var ul = item.closest('.mainul'),
		ot = ul.parent();

	if ((item.position().top + item.height()>ul.height()+40) || off==0 || (ul.data('bh')!=0 && ul.data('bh')!=undefined && item.position().top + item.height()>parseInt(ul.data('bh'),0)+40)) {

		if (ul.data('bh') == undefined || ul.data('bh') == 0)  ul.data('bh',ul.height());
		if (ot.data('bh') == undefined || ot.data('bh') == 0)  ot.data('bh',ot.height());

		var ulb = ul.data('bh'),
			otb = ot.data('bh');

		if (off!=0) {
			ul.data('alreadyinoff',false);
			punchgs.TweenLite.to(ul,0.2,{height:ulb + off});
			punchgs.TweenLite.to(ot,0.2,{height:otb + off});
		} else {
			if (!ul.data('alreadyinoff')) {
				ul.data('alreadyinoff',true);
				punchgs.TweenLite.to(ul,0.3,{height:ulb,ease:punchgs.Power3.easeIn,onComplete:function() {
					ul.data('bh',0);
					ot.data('bh',0);
					ul.data('alreadyinoff',false);
				}});
				punchgs.TweenLite.to(ot,0.3,{height:otb,ease:punchgs.Power3.easeIn,onComplete:function() {
					ul.data('bh',0);
					ot.data('bh',0);
					ul.data('alreadyinoff',false);
				}});
			}
		}
	}
}

 /**************************************
 	-	//! ITEM HOVER ANIMATION	-
 **************************************/

 function itemHoverAnim(item,art,opt,direction) {


	  	 if (item.data('simplevideo') != 1) checkMediaListeners(item);
	  	 	 
	  	 if (item.find('.isplaying, .isinpause').length>0) return false;
	  	 
  		 clearTimeout(item.data('hovertimer'));
  		 var curdelays = opt.mainhoverdelay;
  		 if (art=="set") curdelays=0;

  		 item.data('hovertimer',setTimeout(function() {
	  		 	 item.data('animstarted',1);


	  		 	 punchgs.TweenLite.set(item,{z:0.01,x:0,y:0,rotationX:0,rotationY:0,rotationZ:0});
			 	 // ADD A CLASS FOR ANY FURTHER DEVELOPEMENTS
				 item.addClass("esg-hovered");
				 var ecc = item.find('.esg-entry-cover');
				 punchgs.TweenLite.set(ecc,{transformStyle:"flat"});
				 if (art!="set") fixCenteredCoverElement(item,ecc);

				 //if (!ecc.hasClass("esg-visible-cover")) punchgs.TweenLite.fromTo(ecc,0.2,{autoAlpha:0},{force3D:"auto",autoAlpha:1,overwrite:"auto"});

				 if (item.find('.esg-entry-content').length>0 && art!="set" && opt.layout=="even") {
				 	var pt = item.data('pt'), pb = item.data('pb'), pl = item.data('pl'), pr = item.data('pr'),
				 		bt = item.data('bt'), bb = item.data('bb'), bl = item.data('bl'), br = item.data('br');

				 	item.data('hhh',item.outerHeight());
				 	item.data('www',item.outerWidth());

					punchgs.TweenLite.set(item.find('.esg-entry-content'),{display:"block"});

					//punchgs.TweenLite.set(item.find('.esg-entry-media'),{height:item.data('hhh')});
					punchgs.TweenLite.set(item,{z:0.1,zIndex:50,x:0-(pl+pr+br+bl)/2, y:0-(pt+pb+bt+bb)/2,height:"auto",width:item.data('www')+pl+pr+bl+br});


					if (opt.evenGridMasonrySkinPusher=="on") {
						var hdifference = item.height() - item.data('hhh');
						offsetParrents(hdifference,item);
					}

				 	 // SPECIAL FUN FOR OVERLAPPING CONTAINER, SHOWING MASONRY IN EVEN GRID !!!
				 	 item.css({	paddingTop:pt+"px",
				 	 			paddingLeft:pl+"px",
				 	 			paddingRight:pr+"px",
				 	 			paddingBottom:pr+"px"
				 	 		});

				 	 item.css({borderTopWidth:bt+"px",borderBottomWidth:bb+"px",borderLeftWidth:bl+"px",borderRightWidth:br+"px"});

					 if (opt.inanimation != true ) punchgs.TweenLite.set(item.closest('.esg-overflowtrick'),{overflow:"visible",overwrite:"all"});
				 }

				 jQuery.each(esgAnimmatrix,function(index,key) {
					 item.find(key[0]).each(function() {
						 	 var elem = jQuery(this),
							  	 dd = elem.data('delay')!=undefined ? elem.data('delay') : 0;
							  	 animfrom = key[2];
							  	 animto = key[3];

	  						  // SET ANIMATE POSITIONS
	  						  animto.delay=dd;
	  						  animto.overwrite="all";
	  						  animfrom.overwrite="all";
	  						  animto.transformStyle="flat";
	  						  animto.force3D=true;
	  						  var elemdelay = 0;

	  						  // IF IT IS NOT MEDIA, WE CAN REMOVE ALL TRANSFORMS
	  						  var isOut = key[0].indexOf('out') > -1;
	  						  if (!elem.hasClass("esg-entry-media") && !isOut)
	  						  	animto.clearProps="transform";

	  						  if (isOut) animfrom.clearProps = "transform";
	  						  
		  					  animto.z=0.001;

		  					  // SET PERSPECTIVE IF IT IS STILL UNDEFINED
		  					  if (animfrom.transformPerspective ==undefined)
			  						  animfrom.transformPerspective = 1000;

			  				  // IF IT IS AN OVERLAY, WE NEED TO SET Z POSITION EXTREM
			  				  if (elem.hasClass("esg-overlay")) {
				  				  if (animfrom.z == undefined) animfrom.z = -0.002;
				  				  animto.z = -.0001;
			  				  }

	  						  var animobject = elem;
	  						  var splitted = false;

	  						  // ID MEDIA EXIST AND VIDEO EXIST, NO HOVER NEEDED
	  						  if (elem.hasClass("esg-entry-media") && elem.find('.esg-media-video').length>0)
	  						    return true;

	  						  // ANIMATE BREAK DOWN
	  						 var tw = punchgs.TweenLite.killTweensOf(animobject,false);


	  						  

	  						  // IF IT IS ONLY START, WE NEED TO SET INSTEAD OF ANIMATE
	  						  if (art=="set" ) {	  						  		
		  							var tw = punchgs.TweenLite.set(animobject,animfrom);	
		  							punchgs.TweenLite.set(item.find('.esg-entry-cover'),{visibility:"visible"});	  							
		  							if (isOut) {			  						  	
		  						  		tw.eventCallback("onComplete",resetTransforms,[animobject]);			  						
			  						}
	  						  } else
  						  		switch (key[0]) {
	  						  		case ".esg-shifttotop":
	  						  				animto.y =  0 - item.find('.esg-bc.eec').last().height();
	  						  				var tw = punchgs.TweenLite.fromTo(elem,0.5,{y:0},{y:animto.y});
	  						  		break;
	  						  		case ".esg-slide":
	  						  				var xy =  directionPrepare(direction,"in",item.width(),item.height());
											var af = new Object();
											var at = new Object();
											jQuery.extend(af,animfrom);
											jQuery.extend(at,animto);
	  						  				af.css.x = xy.x;
	  						  				af.css.y = xy.y;
											var tw = punchgs.TweenLite.fromTo(animobject,key[1],af,at,elemdelay);
	  						  		break;
	  						  		case ".esg-slideout":
	  						  				var xy =  directionPrepare(direction,"out",item.width(),item.height());
											var af = new Object();
											var at = new Object();
											jQuery.extend(af,animfrom);
											jQuery.extend(at,animto);
	  						  				at.x = xy.x;
	  						  				at.y = xy.y;
	  						  				at.clearProps="";
											var tw = punchgs.TweenLite.fromTo(animobject,key[1],af,at,elemdelay);
	  						  		break;

	  						  		default:
	  						  				var tw = punchgs.TweenLite.fromTo(animobject,key[1],animfrom,animto,elemdelay);	  						  				
	  						  		break;
  						  		}
					 })
				 })
		},curdelays));

}


/*********************************
	-	VIDEO HAS BEEN CLICKED	-
********************************/

function videoClickEvent(item,container,opt,simpleframe) {


	 item.css({transform:"none",'-moz-transform':'none','-webkit-transform':'none'});
	 item.closest('.esg-overflowtrick').css({transform:"none",'-moz-transform':'none','-webkit-transform':'none'});
	 item.closest('ul').css({transform:"none",'-moz-transform':'none','-webkit-transform':'none'});


	 // PREPARE THE CONTAINERS FOR MEDIAS
	 if (!simpleframe)
		 item.find('.esg-media-video').each(function() {
		   var prep = jQuery(this),
		   	   media= item.find('.esg-entry-media');
		   if (prep.data('youtube')!=undefined && item.find('.esg-youtube-frame').length==0) {
			  
		  	  var ytframe = "https://www.youtube.com/embed/"+prep.data('youtube')+"?version=3&enablejsapi=1&html5=1&controls=1&autohide=1&rel=0&showinfo=0";
			  media.append('<iframe class="esg-youtube-frame" wmode="Opaque" style="position:absolute;top:0px;left:0px;display:none" width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" data-src="'+ytframe+'" src="about:blank"></iframe>');
		   }

		   if (prep.data('vimeo')!=undefined && item.find('.esg-vimeo-frame').length==0) {
			  
		  	  var vimframe = "https://player.vimeo.com/video/"+prep.data('vimeo')+"?title=0&byline=0&html5=1&portrait=0&api=1;";
			  media.append('<iframe class="esg-vimeo-frame"  allowfullscreen="false" style="position:absolute;top:0px;left:0px;display:none" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" data-src="'+vimframe+'" src="about:blank"></iframe>');
		   }
			if (prep.data('wistia')!=undefined && item.find('.esg-wistia-frame').length==0) {
			  
		  	  var wsframe = "https://fast.wistia.net/embed/iframe/"+prep.data('wistia')+"?version=3&enablejsapi=1&html5=1&controls=1&autohide=1&rel=0&showinfo=0";
			  media.append('<iframe class="esg-wistia-frame" wmode="Opaque" style="position:absolute;top:0px;left:0px;display:none" width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" data-src="'+wsframe+'" src="about:blank"></iframe>');
		   }
		   if (prep.data('soundcloud')!=undefined && item.find('.esg-soundcloud-frame').length==0) {
			  
			   var scframe = 'https://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/'+prep.data('soundcloud')+'&amp;auto_play=false&amp;hide_related=false&amp;visual=true&amp;show_artwork=true';
			   media.append('<iframe class="esg-soundcloud-frame" allowfullscreen="false" style="position:absolute;top:0px;left:0px;display:none" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" scrolling="no" frameborder="no" data-src="'+scframe+'" src="about:blank"></iframe>');
		   }

		   if ((prep.data('mp4')!=undefined || prep.data('webm')!=undefined || prep.data('ogv')!=undefined) && item.find('.esg-video-frame').length==0 ) {
		   	  
	           media.append('<video class="esg-video-frame" style="position:absolute;top:0px;left:0px;display:none" width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" data-origw="'+prep.attr("width")+'" data-origh="'+prep.attr("height")+'" ></video');
		       if (prep.data('mp4')!=undefined) media.find('video').append('<source src="'+prep.data("mp4")+'" type="video/mp4" />');
		       if (prep.data('webm')!=undefined) media.find('video').append('<source src="'+prep.data("webm")+'" type="video/webm" />');
		       if (prep.data('ogv')!=undefined) media.find('video').append('<source src="'+prep.data("ogv")+'" type="video/ogg" />');
		   }

		 })

	 adjustMediaSize(item,true,null,opt);

	 var ifr = item.find('.esg-youtube-frame'),
	 	cover = item.find('.esg-entry-cover'),
	 	poster = item.find('.esg-media-poster')
	 	vt = "y",
	 	go = false;

	 if (ifr.length==0) { ifr=item.find('.esg-vimeo-frame'); vt = "v";}
	 if (ifr.length==0) { ifr=item.find('.esg-wistia-frame'); vt="w";}
	 if (ifr.length==0) { ifr=item.find('.esg-soundcloud-frame'); vt="s";}
	 if (ifr.length==0) { ifr=item.find('.esg-video-frame'); vt="h"; }


	 // IN CASE NO FRAME IS PREDEFINED YET WE NEED TO LOAD API, AND VIDEO, AND CHANGE SRC

	 if (ifr.attr('src')=="about:blank") 
	 	ifr.attr('src',ifr.data('src'));
	 else
	 if (ifr.hasClass("esg-video-frame")) 
	 	punchgs.TweenLite.set(ifr,{opacity:0,display:"block"});
	 else 
	 	go = true;
	 loadVideoApis(container,opt);
	 
	 if (!simpleframe) punchgs.TweenLite.set(ifr,{opacity:0,display:"block"});
	 var intr = setInterval(function() {
	 	
	 	if (go || (vt=="y" && prepareYT(ifr)) || (vt=="v" && prepareVimeo(ifr)) || (vt=="w" && prepareWs(ifr)) || (vt=="s" && prepareSoundCloud(ifr)) || (vt=="h" && prepareVideo(ifr))) {
 			clearInterval(intr);
 			if (!simpleframe) {
 				if (is_mobile()) {
	 				punchgs.TweenLite.set(ifr,{autoAlpha:1});
			 		punchgs.TweenLite.set(poster,{autoAlpha:0});
			 		punchgs.TweenLite.set(cover,{autoAlpha:0});
 				} else {
			 		punchgs.TweenLite.to(ifr,0.5,{autoAlpha:1});
			 		punchgs.TweenLite.to(poster,0.5,{autoAlpha:0});
			 		punchgs.TweenLite.to(cover,0.5,{autoAlpha:0});
			 		if (vt==="y" || vt==="w") playYT(ifr,simpleframe);
			 	}
			 	if (vt==="v") playVimeo(ifr,simpleframe);
			 	if (vt==="s") playSC(ifr,simpleframe);
			 	if (vt==="h") playVideo(ifr,simpleframe);
		 	}
		 	if (ifr.attr('src') !=undefined) {
		 		if (ifr.attr('src').toLowerCase().indexOf('youtube')>0)
				 	playYT(ifr,simpleframe);
				if (ifr.attr('src').toLowerCase().indexOf('vimeo')>0)
				 	playVimeo(ifr,simpleframe);
				if (ifr.attr('src').toLowerCase().indexOf('wistia')>0)
				 	playWs(ifr,simpleframe);
				if (ifr.attr('src').toLowerCase().indexOf('soundcloud')>0)
				 	playSC(ifr,simpleframe);

			}
	 	}				 			
	},100);						
}

function setMediaEntryAspectRatio(obj)  {
	
	var attrw = obj.img!==undefined ? obj.img.attr('width') : 1,
		attrh = obj.img!==undefined ? obj.img.attr('height') : 1;

		
	if (obj.ar===undefined || obj.ar=="auto" || obj.ar===NaN) {
		obj.imgw = obj.imgw===undefined ? obj.img!=undefined ? obj.img.width() : 1 : obj.imgw,
		obj.imgh = obj.imgh===undefined ? obj.img!=undefined ? obj.img.height() : 1 : obj.imgh;

		obj.imgw = obj.imgw===null || obj.imgw===NaN || obj.imgw===undefined || obj.imgw===false ? 1 : obj.imgw;
		obj.imgh = obj.imgh===null || obj.imgh===NaN || obj.imgh===undefined || obj.imgh===false ? 1 : obj.imgh;
						
		obj.imgw = obj.img!=undefined ? attrw!==undefined && attrw!==false ? attrw : obj.imgw : 1;
		obj.imgh = obj.img!=undefined ? attrh!==undefined && attrh!==false ? attrh : obj.imgh : 1;
		
		obj.ar = obj.img!==undefined && obj.img.length>=1 ? (obj.imgh/obj.imgw)*100 : 0;
	}

	if (obj.ip.data('keepAspectRatio')!==1) {
		obj.ip.css({paddingBottom:obj.ar+"%"});
		obj.ip.data('bottompadding',obj.ar);			
	}

	if (obj.keepAspectRatio)	
		obj.ip.data('keepAspectRatio',1);


}


 /**********************************
 	-	PREPARE PORTFOLIO -
 **********************************/
 function prepareItemsInGrid(opt,appending) {
 	
 	var container = opt.container;
 	container.addClass("esg-container");

 	if (!appending) {
	 	container.find('.mainul>li').each(function() {
	 		jQuery(this).addClass("eg-newli");
	 	});
 	}

 	// BASIC VARIABLES
	var items = opt.mainul[0].getElementsByClassName('eg-newli'), // opt.mainul.find('>.eg-newli'), //
		itemw = 100/opt.column,
		ar = opt.aspectratio,
		cwidth = container.find('.esg-overflowtrick').parent().width(),
		ul = container.find('ul').first(),
		esgo = container.find('.esg-overflowtrick').first(),
		itemh=0,
		aratio = 1,
		hratio = 1;
	
	// CALCULATE THE ASPECT RATIO
	ar = ar.split(":");

	if (ar.length>1) {
		aratio=parseInt(ar[0],0) / parseInt(ar[1],0);
		hratio = parseInt(ar[1],0) / parseInt(ar[0],0);
		itemh = (cwidth / opt.column) / aratio;
		kar=true;
		hratio=hratio*100;
	} else {
		aratio ="auto";
		hratio ="auto";
		kar=false;
	}
 
	// PREPARE THE ITEMS
	for (var q=0;q<items.length;q++) {			
 		var $item = items[q],
 			item= jQuery($item),
 			media = item.find('.esg-entry-media'), 
 			img = media.find('img'),
 			mediasrc = img!=undefined && img.length>0 ? img.attr('src') : undefined,
			lzysrc = img!=undefined && img.length>0 ? img.data('lazysrc') : undefined;


		if (lzysrc===undefined) lzysrc = mediasrc;

		media.addClass(opt.mediaFilter);

 		punchgs.TweenLite.set(item,{force3D:"auto",autoAlpha:0,opacity:0});


	 	// PREPARE CLASS OF ITEM
	 	item.addClass("tp-esg-item");

	 	var imgopts  = { bgpos: img.length>=1 && img!=undefined ? img.data("bgposition") : undefined,
	 					 bgsize: img.length>=1 && img!=undefined ? img.data("bgsize") : undefined,
	 					 bgrepeat: img.length>=1 && img!=undefined ? img.data("bgrepeat") : undefined,
	 					}

	 	imgopts.bgpos =  imgopts.bgpos===undefined ? "" : "background-position:"+imgopts.bgpos+";";
	 	imgopts.bgsize =  imgopts.bgsize===undefined ? "" : "background-size:"+imgopts.bgsize+";";
	 	imgopts.bgrepeat =  imgopts.bgrepeat===undefined ? "" : "background-repeat:"+imgopts.bgrepeat+";";
	 	
	 	media.append('<div class="esg-media-poster" src="'+lzysrc+'" data-src="'+lzysrc+'" data-lazythumb="'+img.data("lazythumb")+'" style="'+imgopts.bgsize+imgopts.bgrepeat+imgopts.bgpos+'background-image:url('+lzysrc+')"></div>');		 	

	 	
	 	// WRAP MEDIA CONTENT
	 	if (opt.layout=="even") {	 			  						
			 media.wrap('<div class="esg-entry-media-wrapper" style="width:100%;height:100%;overflow:hidden;position:relative;"></div>');				 				 			 		 			 								 
		} else
			media.wrap('<div class="esg-entry-media-wrapper" style="overflow:hidden;position:relative;"></div>');
			
		
		setMediaEntryAspectRatio({ip:media,img:img,ar:hratio,keepAspectRatio:kar});
		
		if (img!=undefined && img.length>0) img.css({display:"none"});


		item.find('.esg-media-video').each(function() {
			var prep = jQuery(this),				
				videovisible = "display:none;",
				viddatasrc = "data-src=",
				vidsrc = "src=";

		   if (prep.data('poster')!=undefined && prep.data('poster').length>3)	
		   			media.find('.esg-media-poster').css({opacity:1,backgroundImage:"url("+prep.data('poster')+")"}).attr('src',prep.data('poster')).data('src',prep.data('poster'));	   						
		   else {
	 			 item.find('.esg-entry-cover').remove();
	 			 item.find('.esg-media-poster').remove();
				 videovisible = "display:block;"
				 viddatasrc = "src=";
				 vidsrc = "data-src=";
				 hratio = (parseInt(prep.attr('height'),0) / parseInt(prep.attr('width'),0))*100;				 
				 setMediaEntryAspectRatio({ip:media,ar:hratio,keepAspectRatio:true});
				 /**
				 -	CLICK ON ITEM TO PLAY VIDEO IN SIMPLEFRAME-
				 **/
				 item.data('simplevideo',1);
				 //videoClickEvent(item,container,opt,true);
			}

		if (item.find('.esg-click-to-play-video').length==0) {
			  item.find('.esg-entry-cover').find('*').each(function () {
				  if (jQuery(this).closest('a').length==0 && jQuery(this).find('a').length==0) {
					  jQuery(this).addClass("esg-click-to-play-video");
				  }
			  })

			  item.find('.esg-overlay').addClass("esg-click-to-play-video");
		   }

			//YOUTUBE PREPARING
			if (prep.data('youtube')!=undefined) {

				var ytframe = "https://www.youtube.com/embed/"+prep.data('youtube')+"?version=3&enablejsapi=1&html5=1&controls=1&autohide=1&rel=0&showinfo=0";
			  	media.append('<iframe class="esg-youtube-frame" wmode="Opaque" style="position:absolute;top:0px;left:0px;'+videovisible+'" width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" '+viddatasrc+'"'+ytframe+'" '+vidsrc+'"about:blank"></iframe>');
			}

			//VIMEO PREPARING
			if (prep.data('vimeo')!=undefined) {
			  	var vimframe = "https://player.vimeo.com/video/"+prep.data('vimeo')+"?title=0&byline=0&html5=1&portrait=0&api=1";
				media.append('<iframe class="esg-vimeo-frame" style="position:absolute;top:0px;left:0px;'+videovisible+'" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""  width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" '+viddatasrc+'"'+vimframe+'" '+vidsrc+'"about:blank"></iframe>');
			}
			   
			//wistia PREPARING
			if (prep.data('wistia')!=undefined) {
				var wsframe = "https://fast.wistia.net/embed/iframe/"+prep.data('wistia')+"?version=3&enablejsapi=1&html5=1&controls=1&autohide=1&rel=0&showinfo=0";
				media.append('<iframe class="esg-wistia-frame" wmode="Opaque" style="position:absolute;top:0px;left:0px;'+videovisible+'" width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" '+viddatasrc+'"'+wsframe+'" '+vidsrc+'"about:blank"></iframe>');
			}
			
			//SOUND CLOUD PREPARING
			if (prep.data('soundcloud')!=undefined) {
		   		var scframe = 'https://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/'+prep.data('soundcloud')+'&amp;auto_play=false&amp;hide_related=false&amp;visual=true&amp;show_artwork=true';
		   		media.append('<iframe class="esg-soundcloud-frame" style="position:absolute;top:0px;left:0px;'+videovisible+'" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" '+viddatasrc+'"'+scframe+'" '+vidsrc+'"about:blank"></iframe>');
		   	}

			//VIDEO PREPARING
			if (prep.data('mp4')!=undefined || prep.data('webm')!=undefined || prep.data('ogv')!=undefined) {
			   media.append('<video class="esg-video-frame" controls style="position:absolute;top:0px;left:0px;'+videovisible+'" width="'+prep.attr("width")+'" height="'+prep.attr("height")+'" data-origw="'+prep.attr("width")+'" data-origh="'+prep.attr("height")+'"></video');
			   var hvid = media.find('video');
			   if (prep.data('mp4')!=undefined) hvid.append('<source src="'+prep.data("mp4")+'" type="video/mp4" />');
			   if (prep.data('webm')!=undefined) hvid.append('<source src="'+prep.data("webm")+'" type="video/webm" />');
			   if (prep.data('ogv')!=undefined) hvid.append('<source src="'+prep.data("ogv")+'" type="video/ogg" />');

			}

			 /*************************************
			 	-	CLICK ON ITEM VIDEO ICONS	-
			 **************************************/

			 item.find('.esg-click-to-play-video').click(function() {
				 var item = jQuery(this).closest('.tp-esg-item');
				 videoClickEvent(item,container,opt);
			 })

			 if (item.data('simplevideo')==1) waitMediaListeners(item);

		})

		// PREPARE THE CONTAINERS FOR MEDIAS
		if (item.find('.esg-media-video').length==0) item.find('.esg-click-to-play-video').remove();
		
		adjustMediaSize(item,true,null,opt);

 		//CHECK IF ENTRY HAS MEDIA & CONTENT PART
 		if (item.find('.esg-entry-content').length>0 && item.find('.esg-media-cover-wrapper').length>0) {
	 		if (item.find('.esg-entry-content').index()<item.find('.esg-media-cover-wrapper').index())
	 		{

	 		} else {
	 		  item.find('.esg-entry-content').addClass('esg-notalone');
	 		}
	 		
 		}


 		// PREPARE THE COVER ELEMENT POSITIONS
		 item.find('.esg-entry-cover').each(function(i) {

			 var eec = jQuery(this),
			 	 clickable = eec.data('clickable');

			 eec.css({visibility:"hidden"});

			 eec.find('.esg-top').wrapAll('<div class="esg-tc eec"></div>');
			 eec.find('.esg-left').wrapAll('<div class="esg-lc eec"></div>');
			 eec.find('.esg-right').wrapAll('<div class="esg-rc eec"></div>');
			 eec.find('.esg-center').wrapAll('<div class="esg-cc eec"></div>');
			 eec.find('.esg-bottom').wrapAll('<div class="esg-bc eec"></div>');

			 eec.find('.eec').append('<div></div>');

			 if (clickable=="on" && eec.find('.esg-overlay').length>=1) {
				 eec.click(function(e) {
					if (jQuery(e.target).closest('a').length==0)
					  jQuery(this).find('.eg-invisiblebutton')[0].click();
				 }).css({cursor:"pointer"});
			 }
		 })

		 	item.data('pt',parseInt(item.css("paddingTop"),0));
		 	item.data('pb',parseInt(item.css("paddingBottom"),0));
		 	item.data('pl',parseInt(item.css("paddingLeft"),0));
		 	item.data('pr',parseInt(item.css("paddingRight"),0));
		 	item.data('bt',parseInt(item.css("borderTopWidth"),0));
		 	item.data('bb',parseInt(item.css("borderBottomWidth"),0));
		 	item.data('bl',parseInt(item.css("borderLeftWidth"),0));
		 	item.data('br',parseInt(item.css("borderRightWidth"),0));

		 if (item.find('.esg-entry-content').length>0 && opt.layout=="even") {

		 	item.css({paddingTop:"0px",paddingLeft:"0px",paddingRight:"0px",paddingBottom:"0px"});
		 	item.css({borderTopWidth:"0px",borderBottomWidth:"0px",borderLeftWidth:"0px",borderRightWidth:"0px"});

		 }


	
		 /****************************************
		 	-	AJAX EXTENSION PREPARING	-
		 *****************************************/

		 if (opt.ajaxContentTarget != undefined && jQuery("#"+opt.ajaxContentTarget).length>0)
			 item.find('.eg-ajaxclicklistener, a').each(function() {

				 var a = jQuery(this),
				 	 act = jQuery("#"+opt.ajaxContentTarget).find('.eg-ajax-target');
				 	 if (!act.parent().hasClass("eg-ajaxanimwrapper")) {
					 	act.wrap('<div class="eg-ajaxanimwrapper" style="position:relative;overflow:hidden;"></div>');
				 	 }
				 if (a.data('ajaxsource')!=undefined && a.data('ajaxtype')!=undefined) {
					 a.addClass("eg-ajax-a-button");
					 a.click(function() {
						 loadMoreContent(container,opt,a);
						 if (act.length>0)
					 		return false;
					 	 else
					 		return true;

					 });

				 }
			 })

		 /***********************************************
		 	-	TRIGGER FILTER ON CATEGORY CLICK	-
		 ************************************************/
		 item.find('.eg-triggerfilter').click(function() {
			var fil = jQuery(this).data('filter');
			jQuery(opt.filterGroupClass+'.esg-filterbutton,'+opt.filterGroupClass+' .esg-filterbutton').each(function() {
				if (jQuery(this).data('filter') == fil) jQuery(this).trigger("click");
			});
			return false;
		 }).css({cursor:"pointer"});


		 /******************************
		 	-	HOVER ON ITEMS	-
		 ********************************/
		item.on( 'mouseenter.hoverdir, mouseleave.hoverdir', function( event ) {
		  	var item=jQuery(this),
		    	direction = getDir( item, { x : event.pageX, y : event.pageY } );

		  	if (event.type === 'mouseenter')
			  	 itemHoverAnim(jQuery(this),"nope",opt,direction);
			else {


		  		 clearTimeout(item.data('hovertimer'));
		  		 if ( item.data('animstarted')==1) {
			  		  item.data('animstarted',0);

				 	 // REMOVE THE CLASS FOR ANY FURTHER DEVELOPEMENTS
					 item.removeClass("esg-hovered");
					 var ecc = item.find('.esg-entry-cover'),
					 	 maxdelay=0;

					 if (item.find('.esg-entry-content').length>0 && opt.layout=="even") {
						punchgs.TweenLite.set(item.find('.esg-entry-content'),{display:"none"});
						punchgs.TweenLite.set(item,{zIndex:5});
						punchgs.TweenLite.set(item.closest('.esg-overflowtrick'),{overflow:"hidden",overwrite:"all"});

						// SPECIAL FUN FOR OVERLAPPING CONTAINER, SHOWING MASONRY IN EVEN GRID !!!
						item.css({paddingTop:"0px",paddingLeft:"0px",paddingRight:"0px",paddingBottom:"0px"});
						item.css({borderTopWidth:"0px",borderBottomWidth:"0px",borderLeftWidth:"0px",borderRightWidth:"0px"});
					 	//item.find('.esg-entry-media').css({height:"100%"});
					 	punchgs.TweenLite.set(item,{z:0,'height':item.data('hhh'),width:item.data('www'),x:0,y:0});
					 	if (opt.evenGridMasonrySkinPusher=="on") offsetParrents(0,item)
					 }



					 jQuery.each(esgAnimmatrix,function(index,key) {
						 item.find(key[0]).each(function() {
							  var elem = jQuery(this),
							  	  dd = elem.data('delay')!=undefined ? elem.data('delay') : 0,
							  	  animto = key[5],
							  	  elemdelay =0;
							  	  animobject = elem,
							  	  splitted = false,
							  	  isOut = key[0].indexOf('out') > -1;		
							  	 				  	  
							  	 
								  if (maxdelay<dd) maxdelay = dd;
		  						  if (animto.z == undefined) animto.z = 1;
		  						  switch (key[0]) {
		  						  		case ".esg-slide":
		  						  				var xy =  directionPrepare(direction,"in",item.width(),item.height(),true);

		  						  				animto.x = xy.x;
		  						  				animto.y = xy.y;
												var tw = punchgs.TweenLite.to(animobject,0.5,{y:animto.y, x:animto.x,overwrite:"all",onCompleteParams:[animobject],onComplete:function(obj) {
													punchgs.TweenLite.set(obj,{autoAlpha:0});
												}});
		  						  		break;
		  						  		case ".esg-slideout":

		  						  				var xy =  directionPrepare(direction,"out",item.width(),item.height());
		  						  				animto.x = 0;
		  						  				animto.y = 0;
		  						  				animto.overwrite = "all";
												var tw = punchgs.TweenLite.fromTo(animobject,0.5,{autoAlpha:1,x:xy.x,y:xy.y},{x:0,y:0,autoAlpha:1,overwrite:"all"});
		  						  		break;

		  						  		default:

												animto.force3D="auto";																										
		  						  				var tw = punchgs.TweenLite.to(animobject,key[4],animto,elemdelay);
		  						  		break;
	  						  		}
	  						  		
	  						  	if (isOut) {			  						  	
			  						tw.eventCallback("onComplete",resetTransforms,[animobject]);			  						
			  					}
			  			})
					 })
				 
 				}

	 			if (item.hasClass("esg-demo"))
	 				setTimeout(function() {
		 				  itemHoverAnim(item);
	 				},800);
 			}
		})

		 // PREPARE VISIBLE AND UNVISIBLE ELEMENTS !!
		 itemHoverAnim(item,"set",opt);

		 if (item.hasClass("esg-demo")) itemHoverAnim(item);


	}
	loadVideoApis(container,opt);
 	setItemsOnPages(opt);
 	
	opt.mainul.find('.eg-newli').removeClass('eg-newli');
	
 }



function resetTransforms(element) {
	punchgs.TweenLite.set(element,{clearProps:"transform", css:{clearProps:"transform"}});
}
 /*****************************************
 	-	Get IframeOriginal Size	-
 *****************************************/
function adjustMediaSize(item,resize,p,opt) {	 
	 // PREPARE IFRAMES !!
 	var srcfor = item.find('iframe').length>0 ? "iframe" :
 				item.find('.esg-video-frame').length>0 ? ".esg-video-frame" : "";

	// Calculate Iframe Width and Height
		if (srcfor!=="") {
 		item.find(srcfor).each(function(i) {
 			var ifr = jQuery(this);
	 		ifr.data('origw',ifr.attr('width'));
	 		ifr.data('origh',ifr.attr('height'));
	 		var oldw = ifr.data('origw'),
	 			oldh = ifr.data('origh'),
	 			ifw,ifh;

	 		ifw = p!=undefined ? p.itemw : item.width();
	 		ifh = Math.round((ifw  / oldw) * oldh);
	 		ifw = Math.round(ifw);

	 		ifr.data('neww',ifw);
		 	ifr.data('newh',ifh);

			if (resize && opt.layout!="even") {
		 	   punchgs.TweenLite.set(ifr,{width:ifw,height:ifh});			 	   
		 	//   punchgs.TweenLite.set(item.find('.esg-entry-media'),{width:ifw,height:ifh});
	 		} else {
		 	   punchgs.TweenLite.set(ifr,{width:"100%",height:"100%"});			 	   
		 	  // punchgs.TweenLite.set(item.find('.esg-entry-media'),{width:"100%",height:"100%"});
	 		}
	 	})
		} 	
 }





 /******************************
 	-	SET PAGE FILTER	-
 ********************************/
 function setItemsOnPages(opt) {
 	
		var container = opt.container;

		 // BASIC VARIABLES
		 var items = container.find('.mainul>li'),
		 	 itemperpage = opt.column*opt.row;

		 // CALCULATE ITEM PER PAGE HERE (BASED ON LAYOUT AND MULTIPLIER
		 var mp = opt.rowItemMultiplier;
		 var mpl = mp.length;

		 if (mpl>0)
			 if (/*opt.column!=1 &&*/ opt.layout=="even") {
			 	 itemperpage = 0;
				 for (var i=0;i<opt.row;i++) {
					 var cle = i - (mpl*Math.floor(i/mpl));
					 	itemperpage = itemperpage + mp[cle][opt.columnindex];
				 }
			 }

		// COBBLES PATTER SHOULD SHOW ONLY AS MANY ROWS AS MAX ROWS REALLY SET
		if (opt.evenCobbles == "on" && opt.cobblesPattern!=undefined) {
			 var trow = 0,
			 	 tcol = 0,
			 	 tcount = 0,
			 	 itemperpage = 0;

			  jQuery.each(items, function(i,$item) {
				   var item = jQuery(item),
						cobblesw = item.data('cobblesw'),
						cobblesh = item.data('cobblesh');

					if (opt.cobblesPattern!=undefined && opt.cobblesPattern.length>2) {
						var newcobblevalues =  getCobblePat(opt.cobblesPattern,i);
						cobblesw = parseInt(newcobblevalues.w,0);
						cobblesh = parseInt(newcobblevalues.h,0);

					}

					cobblesw = cobblesw==undefined ? 1 : cobblesw;
					cobblesh = cobblesh==undefined ? 1 : cobblesh;

					if (opt.column < cobblesw) cobblesw = opt.column;
					tcount = tcount + cobblesw*cobblesh;

					if ((opt.column*opt.row)>=tcount) itemperpage++;

			})
		}

		 var minindex = itemperpage*opt.currentpage,
		 	 cwidth = container.find('.esg-overflowtrick').parent().width(),
		 	 maxindex = minindex + itemperpage,
		 	 filters = jQuery(opt.filterGroupClass+'.esg-filterbutton.selected:not(.esg-navigationbutton),'+opt.filterGroupClass+' .esg-filterbutton.selected:not(.esg-navigationbutton)'),
		 	 indexcounter = 0;





		 // PREPARE THE ITEMS IF WE HAVE FILTERS ON PAGE
		 if (jQuery(opt.filterGroupClass+'.esg-filter-wrapper, '+opt.filterGroupClass+' .esg-filter-wrapper').length>0) {		 	
					 jQuery.each(items,function(index,$item) {

					 	var item= jQuery($item);
					 	item.find('.esgbox').each(function() {
					 		if (opt.lightBoxMode=="all")
					 			jQuery(this).attr('rel',"group");
					 		else
						 	if (opt.lightBoxMode!="contentgroup")
						 		jQuery(this).attr('rel',"");
					 	})

					 	// CHECK IF THE FILTER SELECTED, AND IT FITS TO THE CURRENT ITEM
					 	var nofilter = true,
					 		foundfilter = 0;
					 	jQuery.each(filters,function(index,curfilter) {
						 	if (item.hasClass(jQuery(curfilter).data('filter'))) {
						 		nofilter=false;
						 		foundfilter++;
						 	}
					 	})

					 	// IF ELEMENT DO NOT PASS IN ALL SELECTED FILTER, THEN DO NOT SHOW IT
					 	if (opt.filterLogic=="and" && foundfilter < filters.length) nofilter = true;

					 	// IF SEARCH FILTER IS ACTIVATED, AND ELEMENT IS NOT FITTING IN SEARCH AND IN SELECTED FILTER, THEN HIDE IT
					 	hidsbutton = jQuery(opt.filterGroupClass+'.esg-filter-wrapper .hiddensearchfield');
					 	if (hidsbutton.hasClass("eg-forcefilter") && foundfilter < filters.length) nofilter = true;


					 	// FILTER BASED SHOW OR HIDE THE ITEM (Less then Items fit on Page
					 	if (indexcounter>=minindex && indexcounter<maxindex && !nofilter) {

						 	item.addClass("itemtoshow").removeClass("itemishidden").removeClass("itemonotherpage");

						 	if (opt.lightBoxMode=="filterpage" || opt.lightBoxMode=="filterall") 
						 		item.find('.esgbox').attr('rel',"group");
						 								 
						 	indexcounter++;
					 	} else {

						 	if (opt.lightBoxMode=="filterall")
						 		item.find('.esgbox').attr('rel',"group");
						 	if (!nofilter) {
						 		if (indexcounter<minindex || indexcounter>=maxindex) {
							 		 item.addClass("itemonotherpage");
						 		     item.removeClass("itemtoshow");
						 		     indexcounter++;
							 	} else {
							 		item.addClass("itemtoshow").removeClass("itemishidden").removeClass("itemonotherpage");
							 		indexcounter++;
								}
							 	item.addClass("fitsinfilter");
						 	}  else {
								item.addClass("itemishidden").removeClass("itemtoshow").removeClass("fitsinfilter");
							}
					 	}

				 	})
		} else {

				jQuery.each(items,function(index,$item) {

					 	var item= jQuery($item);


					 	item.find('.esgbox').each(function() {
					 		if (opt.lightBoxMode=="all")
					 			jQuery(this).attr('rel',"group");
					 		else
						 	if (opt.lightBoxMode!="contentgroup")
						 		jQuery(this).attr('rel',"");
					 	})

					 	if (opt.lightBoxMode=="filterall") 
						 	item.find('.esgbox').attr('rel',"group");


					 	// FILTER BASED SHOW OR HIDE THE ITEM (Less then Items fit on Page
					 	if (indexcounter>=minindex && indexcounter<maxindex) {

						 	item.addClass("itemtoshow").removeClass("itemishidden").removeClass("itemonotherpage");
						 	indexcounter++;
						 	if (opt.lightBoxMode=="filterpage" || opt.lightBoxMode=="filterall") 
						 		item.find('.esgbox').attr('rel',"group");
					 	} else {


						 		if (indexcounter<minindex || indexcounter>=maxindex) {
							 		 item.addClass("itemonotherpage");
						 		     item.removeClass("itemtoshow");
						 		     indexcounter++;
							 	} else {
							 		item.addClass("itemtoshow").removeClass("itemishidden").removeClass("itemonotherpage");
							 		indexcounter++;
								}
							 	item.addClass("fitsinfilter");
					 	}

				 	})
		}




	 	// HOW MANY NONEFILTERED ITEMS DO WE HAVE?
	 	opt.nonefiltereditems = container.find('.itemtoshow, .fitsinfilter').length;

	 	if (opt.loadMoreType!="none") {
	 		var amnt = 0;
	 		var onewaszero = false;
	 		filters.each(function() {

	 			var filt = jQuery(this).data('filter');
	 			if (filt !=undefined) {
		 			var newc = container.find('.'+filt).length;
			 		amnt = amnt + newc;
			 		if (newc==0) onewaszero = true;
			 	}
		 	})

		 	if (filters.length==0 || filters.length==1) amnt=1;

		   if (amnt==0 || onewaszero) 		   	
		   	loadMoreItems(opt);
		   
		   	


	 	}

	 	// BUILD THE PAGINATION BASED ON NONE FILTERED ITEMS
	 	var paginholder = jQuery(opt.filterGroupClass+'.esg-pagination,'+opt.filterGroupClass+' .esg-pagination');
	 	paginholder.find('.esg-pagination').remove();
	 	paginholder.html("");
	 	opt.maxpage=0;

 		var extraclass;
 		var pageamounts = Math.ceil(opt.nonefiltereditems / itemperpage);

 		opt.realmaxpage = pageamounts;

 		if (pageamounts>7 && opt.smartPagination=="on") {
		 	//BUILD PAGINATION IF ONLY SMART PAGES SHOULD BE ADDED
		 	if (opt.currentpage<3) {
			 	for (var i=0;i<4;i++) {
				  if (i==opt.currentpage)
		 		 	extraclass="selected";
		 		  else
		 			extraclass="";
		 		  opt.maxpage++;
			 	  paginholder.append('<div class="esg-navigationbutton esg-filterbutton esg-pagination-button '+extraclass+'" data-page="'+i+'">'+(i+1)+'</div>');
			 	}
			 	paginholder.append('<div class="esg-navigationbutton">...</div>');
			 	paginholder.append('<div class="esg-navigationbutton esg-filterbutton esg-pagination-button '+extraclass+'" data-page="'+(pageamounts-1)+'">'+(pageamounts)+'</div>');
		 	}

		 	else

		 	if (pageamounts - opt.currentpage<4) {
			 	paginholder.append('<div class="esg-navigationbutton esg-filterbutton esg-pagination-button '+extraclass+'" data-page="0">1</div>');
			 	paginholder.append('<div class="esg-navigationbutton">...</div>');
			 	for (var i=pageamounts-4;i<pageamounts;i++) {
				  if (i==opt.currentpage)
		 		 	extraclass="selected";
		 		  else
		 			extraclass="";
		 		  opt.maxpage++;
			 	  paginholder.append('<div class="esg-navigationbutton esg-filterbutton esg-pagination-button '+extraclass+'" data-page="'+i+'">'+(i+1)+'</div>');
			 	}
		 	} else {
			 	paginholder.append('<div class="esg-navigationbutton esg-filterbutton esg-pagination-button '+extraclass+'" data-page="0">1</div>');
			 	paginholder.append('<div class="esg-navigationbutton">...</div>');
			 	for (var i=opt.currentpage-1;i<opt.currentpage+2;i++) {
				  if (i==opt.currentpage)
		 		 	extraclass="selected";
		 		  else
		 			extraclass="";
		 		  opt.maxpage++;
			 	  paginholder.append('<div class="esg-navigationbutton esg-filterbutton esg-pagination-button '+extraclass+'" data-page="'+i+'">'+(i+1)+'</div>');
			 	}
			 	paginholder.append('<div class="esg-navigationbutton">...</div>');
			 	paginholder.append('<div class="esg-navigationbutton esg-filterbutton esg-pagination-button '+extraclass+'" data-page="'+(pageamounts-1)+'">'+(pageamounts)+'</div>');

		 	}

 		} else {

	 		// BUILD PAGINATION WHEN ALL PAGES SHOULD BE ADDED
		 	for (var i=0;i<pageamounts;i++) {

		 		if (i==opt.currentpage)
		 			extraclass="selected";
		 		else
		 			extraclass="";
		 		opt.maxpage++;
			 	paginholder.append('<div class="esg-navigationbutton esg-filterbutton esg-pagination-button '+extraclass+'" data-page="'+i+'">'+(i+1)+'</div>');
		 	}
		 }


	 	if (opt.maxpage==1) {
		 	 jQuery(opt.filterGroupClass+'.esg-navigationbutton,'+opt.filterGroupClass+' .esg-navigationbutton').not('.esg-loadmore').css({display:'none'});

		 	 paginholder.css({display:'none'});
	 	} else {
		 	 jQuery(opt.filterGroupClass+'.esg-navigationbutton,'+opt.filterGroupClass+' .esg-navigationbutton').css({display:'inline-block'});
		 	 paginholder.css({display:'inline-block'});
	 	}

	 	if (opt.currentpage>=Math.ceil(opt.nonefiltereditems / itemperpage)) {
	 		opt.oldpage = opt.currentpage;
	 		opt.currentpage = 0;
	 		// Rescan again, and turn visibilty on of the first items, to make them visible after filtering has less pages
	 		var counter =0;
	 		container.find('.itemtoshow, .fitsinfilter').each(function() {
		 		counter++;
		 		if (counter<maxindex)
		 		  jQuery(this).removeClass("itemonotherpage");
	 		})
	 		paginholder.find('.esg-pagination-button').first().addClass("selected");
	 	}
	 	if (opt.currentpage<0) opt.currentpage=0;




	 	/** HANDLE OF PAGINATION BUTTONS **/
		paginholder.find('.esg-pagination-button').on("click",function() {
		 	opt.oldpage=opt.currentpage;
		 	opt.currentpage = jQuery(this).data('page');
			opt = getOptions(container);	//new added
			var gbfc = getBestFitColumn(opt,jQuery(window).width(),"id");
			opt.column = gbfc.column;
			opt.columnindex = gbfc.index;
			opt.mmHeight = gbfc.mmHeight;

			// CREATE A COOKIE FOR THE LAST SELECTION OF FILTERS
			if (opt.cookies.pagination==="on" && opt.cookies.searchjusttriggered !== true) 
				createCookie("grid_"+opt.girdID+"_pagination",opt.currentpage,opt.cookies.timetosave*(1/60/60));

		 	setItemsOnPages(opt);
			organiseGrid(opt,"paginholder");
			setOptions(container,opt);
			stopAllVideos(true);
			if (opt.paginationScrollToTop=="on") {
				jQuery("html, body").animate({scrollTop:(container.offset().top-opt.paginationScrollToTopOffset)},{queue:false,speed:0.5});
			}

		});


		if (opt.firstshowever==undefined) jQuery(opt.filterGroupClass+'.esg-navigationbutton,'+opt.filterGroupClass+' .esg-navigationbutton').css({visibility:"hidden"});


	
 }

function waittorungGrid(img,opt,what) {
	
	var mainul = img.closest('.mainul');
	clearTimeout( mainul.data("intreorganisier"));
	if (!mainul.hasClass("gridorganising")) {

		runGrid(opt,what);
	} else {
		 mainul.data("intreorganisier",setTimeout(function() {
			waittorungGrid(img,opt,what)
		 },10));
	}
	
}

/*******************************************
	-	PREPARE LOADING OF IMAGES	-
********************************************/
function loadAllPrepared(img,opt) {
		if (img.data('preloading')==1) return false;

		var limg = new Image();

 	 	if (img.data('lazysrc')!=img.attr('src') && img.data('lazysrc')!=undefined && img.data('lazysrc')!='undefined') {

			if (img.data('lazysrc') !=undefined && img.data('lazysrc') !='undefined')
				img.attr('src',img.data('lazysrc'));
		}

		img.data('preloading',1);


		limg.onload = function(loadedimg) {			
			img.data('lazydone',1);
			img.data('ww',limg.width);
			img.data('hh',limg.height);			
			img.closest('.showmeonload').addClass("itemtoshow").removeClass("showmeonload").addClass("loadedmedia");
			removeLLCover(img,limg.width,limg.height);
			if (opt.lazyLoad=="on")
				waittorungGrid(img,opt,true);

		}

		limg.onerror = function() {
				img.data('lazydone',1);
				img.closest('.showmeonload').addClass("itemtoshow").removeClass("showmeonload").addClass("loadedmedia");
				if (opt.lazyLoad=="on")
					waittorungGrid(img,opt,true);

			}


		if (img.attr('src')!=undefined && img.attr('src')!='undefined')
			limg.src = img.attr('src');
		 else
			limg.src = img.data('src');
		
		if (limg.complete) {
			img.data('lazydone',1);
			img.data('ww',limg.width);
			img.data('hh',limg.height);
			img.closest('.showmeonload').addClass("itemtoshow").removeClass("showmeonload").addClass("loadedmedia");
			removeLLCover(img,limg.width,limg.height);
			if (opt.lazyLoad=="on")
				waittorungGrid(img,opt,true);
		}


}

/******************************
	-	WAIT FOR PRELOADS	-
********************************/

var waitForLoads = function(elements,opt) {
		
	
	jQuery.each(elements,function(index,element){
		element = jQuery(element);
		if (!element.hasClass("isvisiblenow") && opt.esgloaderprocess!=="add") 		{	
			//console.log("Show Preloader 1. (  speed 0.5)");
			opt.esgloaderprocess = "add";			
			punchgs.TweenLite.to(opt.esgloader,0.5,{autoAlpha:1,ease:punchgs.Power3.easeInOut});
		}
		
	});

	var inter = setInterval(function() {

			opt.bannertimeronpause = true;
			opt.cd=0;			
			 var found = 0;
			 elements.find('.esg-media-poster').each(function(i) {
				var img = jQuery(this),
					imgsrc = img.attr('src'),
					ip =img.parent();

			 	//img.css({display:"none"});
			 	if (img.data('lazydone')!=1 && opt.lazyLoad=="on" && ip.find('.lazyloadcover').length<1) {
			 		lthumb = img.data('lazythumb');			 		
			 		var	bgimg = "",
			 			blurclass ="";
			 		if (lthumb!=undefined) {
			 			imgsrc = img.data('lazysrc');
			 			bgimg = ";background-image:url("+lthumb+")"
			 			blurclass="esg-lazyblur";
			 		}			 		

				 	ip.append('<div class="lazyloadcover '+blurclass+'" style="background-color:'+opt.lazyLoadColor+bgimg+'"></div>');
				 	
			 	} 
			 	
			 	if (img.data('lazydone')!=1 && found<3) {			 		
			 		found++;
			 		loadAllPrepared(jQuery(this),opt);
			 	}

			 	if (opt.lazyLoad!=="on") {
			 		punchgs.TweenLite.set(img,{autoAlpha:1});
			 	}

			 });

			 if (found==0) {
				  if (opt.esgloader.length>0 && opt.esgloaderprocess!=="remove") {
				  	opt.esgloaderprocess = "remove";					 
					var infdelay = 0;
					if (opt.esgloader.hasClass("infinityscollavailable"))
					 	infdelay = 1;
					//console.log("Hide Preloader 1. (delay:"+infdelay+", speed 0.5)");
					punchgs.TweenLite.to(opt.esgloader,0.5,{autoAlpha:0, ease:punchgs.Power3.easeInOut, delay:infdelay});
				 }
			 }
			 if (found==0 && !elements.closest('.mainul').hasClass("gridorganising")) {
				 clearInterval(inter);				 
			   	 runGrid(opt);
			 }			 
		},50)
	
	runGrid(opt);

}



 /******************************
 	-	ORGANISE GRID	-
 ********************************/
 function organiseGrid(opt,fromwhere) { 		 	
	waitForLoads(opt.container.find('.itemtoshow'),opt)	
 }


function removeLLCover(img,imgw,imgh) {
	var ip = img.parent();
	
	setMediaEntryAspectRatio({ip:ip,img:img,imgw:imgw,imgh:imgh});
	if (!img.hasClass("coverremoved") && ip.find('.lazyloadcover').length>0) {
		img.addClass("coverremoved");			
		punchgs.TweenLite.set(ip.find('.lazyloadcover'),{zIndex:0});		
		punchgs.TweenLite.fromTo(img,0.5,{autoAlpha:0,zIndex:1},{force3D:true, autoAlpha:1,ease:punchgs.Power1.easeInOut,onComplete:function() {
			img.parent().find('.lazyloadcover').remove();			
		}});
	} else
	if (opt.lazyLoad=="off") {
		//punchgs.TweenLite.fromTo(img,0.5,{autoAlpha:0,zIndex:1},{force3D:true, autoAlpha:1,ease:punchgs.Power1.easeInOut});		
		punchgs.TweenLite.set(img,{force3D:true, autoAlpha:1});
	}
}


/***********************************************
	-	Run Grid To Prepare for Animation	-
************************************************/
function runGrid(opt,newelementadded) {		
		
		var  container = opt.container;			 
		if (opt.loadMoreType=="scroll") checkBottomPos(opt);

		if (opt.firstshowever==undefined) {
			if (container.is(":hidden"))
				punchgs.TweenLite.set(container,{autoAlpha:1,display:"block"});
			runGridMain(opt,newelementadded);
			jQuery(opt.filterGroupClass+'.esg-navigationbutton, '+opt.filterGroupClass+' .esg-navigationbutton').css({visibility:"visible"});
			
			//punchgs.TweenLite.to(opt.esgloader,0.2,{autoAlpha:0});
			opt.firstshowever = 1;

		} else {
			runGridMain(opt,newelementadded);
			jQuery(opt.filterGroupClass+'.esg-navigationbutton, '+opt.filterGroupClass+' .esg-navigationbutton').css({visibility:"visible"});
		}

}

/**********************************
	-	GET THE COBBLES PATTERN	-
***********************************/

function getCobblePat(ar,index) {
	var cobblevalue = new Object;
	cobblevalue.w = 1;
	cobblevalue.h = 1;
	ar = ar.split(",");
	if (ar!=undefined) {
			ar = ar[index - (Math.floor(index/(ar.length)) * (ar.length))].split("x");
			cobblevalue.w = ar[0];
			cobblevalue.h = ar[1];
	}
	return cobblevalue;
}



/************************************************
	-	//! RUN THE GRID POSITION CALCULATION	-
*************************************************/
function runGridMain(opt,newelementadded) {

	
	
	// BASIC VARIABLES
 	var  container = opt.container,
 		 items = container.find('.itemtoshow, .isvisiblenow').not('.ui-sortable-helper'),
 	 	 p = new Object,
	 	 ul = container.find('ul').first(),
	 	 esgo = container.find('.esg-overflowtrick').first(),
	 	 ar = opt.aspectratio,
	 	 aratio,
	 	 coh = 0;

	 	opt.aspectratioOrig = opt.aspectratio;


	container.find('.mainul').addClass("gridorganising");
	// CALCULATE THE ASPECT RATIO


	ar = ar.split(":");
 	aratio=parseInt(ar[0],0) / parseInt(ar[1],0);




	p.item = 0;
	p.pagetoanimate=0-opt.currentpage;			// Page Offsets
	p.col=0;									// Current Col
	p.row=0;									// Current Row
	p.pagecounter=0;							// Counter
	p.itemcounter=0;

	p.fakecol=0;
	p.fakerow=0;
	p.maxheight=0;

	p.allcol =0;
	p.allrow = 0;
	p.ulcurheight = 0;
	p.ulwidth = ul.width();

	p.verticalsteps = 1;




	p.currentcolumnheight = new Array;
	for (var i=0;i<opt.column;i++)
		p.currentcolumnheight[i] = 0;

	p.pageitemcounterfake=0;
	p.pageitemcounter=0;

	// GET DELAY BASIC
	if (opt.delayBasic!=undefined)
		p.delaybasic = opt.delayBasic;
	else
		p.delaybasic = 0.08;


	p.anim = opt.pageAnimation;

	p.itemtowait=0;
	p.itemouttowait=0;

	p.ease = "punchgs.Power1.easeInOut";
	p.easeout = p.ease;
	p.row=0;
	p.col=0;

	// MULTIPLIER SETTINGS
	var mp = opt.rowItemMultiplier,
		mpl = mp.length,
		origcol = opt.column;


	p.y = 0;
	p.fakey = 0;
	container.find('.esg-overflowtrick').css({width:"100%"});
	if (container.find('.esg-overflowtrick').width()==100)
		container.find('.esg-overflowtrick').css({width:container.find('.esg-overflowtrick').parent().width()});
	p.cwidth = container.find('.esg-overflowtrick').width()-(opt.overflowoffset*2)			// Current Width of Parrent Container

	opt.inanimation = true;

	p.cwidth_n_spaces = p.cwidth -  ((opt.column-1)*opt.space);

	p.itemw = Math.round(p.cwidth_n_spaces/opt.column);	// Current Item Width in PX
	p.originalitemw = p.itemw;

	var forceAR = false;


	// CHANGE ASPECT RATIO IF FULLSCREEN IS SET
	if (opt.forceFullScreen=="on") {
		coh = jQuery(window).height();
		if (opt.fullScreenOffsetContainer!=undefined) {
			try{
				var offcontainers = opt.fullScreenOffsetContainer.split(",");
				jQuery.each(offcontainers,function(index,searchedcont) {
					coh = coh - jQuery(searchedcont).outerHeight(true);
					if (coh<opt.minFullScreenHeight) coh=opt.minFullScreenHeight;
				});
			} catch(e) {}
		}
		forceAR = true;
	}



	if (opt.layout=="even") {

			p.itemh = Math.round(coh) == 0 ? Math.round((p.cwidth_n_spaces / opt.column) / aratio) : Math.round(coh/opt.row);
			opt.aspectratio = coh == 0 ? opt.aspectratio : p.itemw+":"+p.itemh;
			
			if (mpl>0)
				punchgs.TweenLite.set(items,{display:"block",visibility:"visible",overwrite:"auto"});
			else
			if (opt.evenCobbles=="on")
				punchgs.TweenLite.set(items,{display:"block",visibility:"visible",overwrite:"auto"});
			else
				punchgs.TweenLite.set(items,{display:"block",width:p.itemw,height:p.itemh,visibility:"visible",overwrite:"auto"});
	} else {		
		punchgs.TweenLite.set(items,{display:"block",width:p.itemw,height:"auto",visibility:"visible",overwrite:"auto"});
	}
	if (!newelementadded)  {

		punchgs.TweenLite.killTweensOf(items);
	}

	p.originalitemh = p.itemh;

	// PREPARE A GRID FOR CALCULATE THE POSITIONS OF COBBLES
	var thegrid = new Array(),
		maxcobblerow = opt.row*opt.column*2;

	for (var rrr = 0 ; rrr<maxcobblerow; rrr++) {
		var newrow = new Array();
		for (var ccc = 0; ccc<opt.column;ccc++) {
				newrow.push(0);
		}
		thegrid.push(newrow);
	}

	var cobblepatternindex = 0;


	if (items.length==0) container.trigger('itemsinposition');
	// REPARSE THE ITEMS TO MAKE
 	jQuery.each(items,function(index,$item) {
		var item = jQuery($item);
		p.itemw = 	p.originalitemw;

		//fixCenteredCoverElement(item);


		punchgs.TweenLite.set(item.find('.esg-entry-content'),{minHeight:opt.mmHeight+"px"});

		//! COBBLES
		if (opt.evenCobbles == "on" && !item.hasClass("itemonotherpage") && !item.hasClass("itemishidden")) {
				var cobblesw = item.data('cobblesw'),
					cobblesh = item.data('cobblesh');

				if (opt.cobblesPattern!=undefined && opt.cobblesPattern.length>2) {

					var newcobblevalues =  getCobblePat(opt.cobblesPattern,cobblepatternindex);
					cobblesw = parseInt(newcobblevalues.w,0);
					cobblesh = parseInt(newcobblevalues.h,0);
					cobblepatternindex++;
				}


				cobblesw = cobblesw==undefined ? 1 : cobblesw;
				cobblesh = cobblesh==undefined ? 1 : cobblesh;


				if (opt.column < cobblesw) cobblesw = opt.column;

				p.cobblesorigw = p.originalitemw;
				p.cobblesorigh = p.originalitemh;
				p.itemw = p.itemw * cobblesw + ((cobblesw-1) * opt.space);
				p.itemh =  p.originalitemh;

				p.itemh = p.itemh * cobblesh + ((cobblesh-1) * opt.space);

				var cobblepattern = cobblesw+":"+cobblesh	,
					spacefound = false,
					r = 0,
					c = 0;

				switch (cobblepattern) {
								case "1:1":
									do {
										if (thegrid[r][c]==0) {
											thegrid[r][c] = "1:1";
											spacefound = true;
											p.cobblesx = c;
											p.cobblesy = r;
										}
										c++;
										if (c==opt.column) {
											c=0;r++;
										}
										if (r>=maxcobblerow) spacefound= true;
									} while (!spacefound);
								break;



								case "1:2":
									do {
										if (thegrid[r][c]==0 && r<maxcobblerow-1 && thegrid[r+1][c]==0) {
											thegrid[r][c] = "1:2";
											thegrid[r+1][c] = "1:2";
											p.cobblesx = c;
											p.cobblesy = r;

											spacefound = true;
										}
										c++;
										if (c==opt.column) {
											c=0;r++;
										}
										if (r>=maxcobblerow) spacefound= true;
									} while (!spacefound);
								break;

								case "1:3":
									do {
										if (thegrid[r][c]==0 && r<maxcobblerow-2 && thegrid[r+1][c]==0 && thegrid[r+2][c]==0) {
											thegrid[r][c] = "1:3";
											thegrid[r+1][c] = "1:3";
											thegrid[r+2][c] = "1:3";
											p.cobblesx = c;
											p.cobblesy = r;

											spacefound = true;
										}
										c++;
										if (c==opt.column) {
											c=0;r++;
										}
										if (r>=maxcobblerow) spacefound= true;
									} while (!spacefound);
								break;


								case "2:1":
									do {
										if (thegrid[r][c]==0 && c<opt.column-1 && thegrid[r][c+1]==0) {
											thegrid[r][c] = "2:1";
											thegrid[r][c+1] = "2:1";
											p.cobblesx = c;
											p.cobblesy = r;
											spacefound = true;
										}
										c++;
										if (c==opt.column) {
											c=0;r++;
										}
										if (r>=maxcobblerow) spacefound= true;
									} while (!spacefound);
								break;

								case "3:1":
									do {
										if (thegrid[r][c]==0 && c<opt.column-2 && thegrid[r][c+1]==0 && thegrid[r][c+2]==0) {
											thegrid[r][c] = "3:1";
											thegrid[r][c+1] = "3:1";
											thegrid[r][c+2] = "3:1";
											p.cobblesx = c;
											p.cobblesy = r;
											spacefound = true;
										}
										c++;
										if (c==opt.column) {
											c=0;r++;
										}
										if (r>=maxcobblerow) spacefound= true;
									} while (!spacefound);
								break;

								case "2:2":
									do {
										if (c<opt.column-1 && r<maxcobblerow-1 && thegrid[r][c]==0 && thegrid[r][c+1]==0 && thegrid[r+1][c]==0 && thegrid[r+1][c+1]==0) {
											thegrid[r][c] = "2:2";
											thegrid[r+1][c] = "2:2";
											thegrid[r][c+1] = "2:2";
											thegrid[r+1][c+1] = "2:2";

											p.cobblesx = c;
											p.cobblesy = r;

											spacefound = true;
										}
										c++;
										if (c==opt.column) {
											c=0;r++;
										}
										if (r>=maxcobblerow) spacefound= true;
									} while (!spacefound);
								break;

								case "3:2":
									do {
										if (c<opt.column-2 && r<maxcobblerow-1 &&
											thegrid[r][c]==0 &&
											thegrid[r][c+1]==0 &&
											thegrid[r][c+2]==0 &&
											thegrid[r+1][c]==0  &&
											thegrid[r+1][c+1]==0 &&
											thegrid[r+1][c+2]==0
											)
										{

												thegrid[r][c] = "3:2";
												thegrid[r][c+1] = "3:2";
												thegrid[r][c+2] = "3:2";
												thegrid[r+1][c] = "3:2";
												thegrid[r+1][c+1] = "3:2";
												thegrid[r+1][c+2] = "3:2";

												p.cobblesx = c;
												p.cobblesy = r;

												spacefound = true;
										}
										c++;
										if (c==opt.column) {
											c=0;r++;
										}
										if (r>=maxcobblerow) spacefound= true;
									} while (!spacefound);
								break;

								case "2:3":
									do {
										if (c<opt.column-1 && r<maxcobblerow-2 &&
											thegrid[r][c]==0 &&
											thegrid[r][c+1]==0 &&
											thegrid[r+1][c]==0 &&
											thegrid[r+1][c+1]==0  &&
											thegrid[r+2][c+1]==0 &&
											thegrid[r+2][c+1]==0

											)
										{

												thegrid[r][c] = "2:3";
												thegrid[r][c+1] = "2:3";
												thegrid[r+1][c] = "2:3";
												thegrid[r+1][c+1] = "2:3";
												thegrid[r+2][c] = "2:3";
												thegrid[r+2][c+1] = "2:3";

												p.cobblesx = c;
												p.cobblesy = r;

												spacefound = true;

										}
										c++;
										if (c==opt.column) {
											c=0;r++;
										}
										if (r>=maxcobblerow) spacefound= true;
									} while (!spacefound);
								break;

								case "3:3":
									do {
										if (c<opt.column-2 && r<maxcobblerow-2 &&
											thegrid[r][c]==0 &&
											thegrid[r][c+1]==0 &&
											thegrid[r][c+2]==0 &&
											thegrid[r+1][c]==0  &&
											thegrid[r+1][c+1]==0 &&
											thegrid[r+1][c+2]==0 &&
											thegrid[r+2][c]==0  &&
											thegrid[r+2][c+1]==0 &&
											thegrid[r+2][c+2]==0

											)
										{

												thegrid[r][c] = "3:3";
												thegrid[r][c+1] = "3:3";
												thegrid[r][c+2] = "3:3";
												thegrid[r+1][c] = "3:3";
												thegrid[r+1][c+1] = "3:3";
												thegrid[r+1][c+2] = "3:3";
												thegrid[r+2][c] = "3:3";
												thegrid[r+2][c+1] = "3:3";
												thegrid[r+2][c+2] = "3:3";

												p.cobblesx = c;
												p.cobblesy = r;

												spacefound = true;
										}
										c++;
										if (c==opt.column) {
											c=0;r++;
										}
										if (r>=maxcobblerow) spacefound= true;
									} while (!spacefound);
								break;
				}

				opt.aspectratio = p.itemw+":"+p.itemh;

				punchgs.TweenLite.set(item,{width:p.itemw,height:p.itemh,overwrite:"auto"});
				var eem = item.find('.esg-entry-media'),
					multi = (p.itemh/p.itemw)*100; 				
				punchgs.TweenLite.set(eem,{paddingBottom:multi+"%"});

		} else {

				//IF ITEMW IS DIFFERENT BASED ON MULTIPLIER, WE NEED TO RESET SIZES
				var cle = p.row - (mpl*Math.floor(p.row/mpl));

				if (opt.layout=="even" && mpl>0) {
					/*if (origcol!=1)*/ opt.column = mp[cle][opt.columnindex];
					p.cwidth = container.find('.esg-overflowtrick').width()-(opt.overflowoffset*2)			// Current Width of Parrent Container
					p.cwidth_n_spaces = p.cwidth -  ((opt.column-1)*opt.space);
					p.itemw = Math.round(p.cwidth_n_spaces/opt.column);	// Current Item Width in PX

					p.itemh = coh == 0 ? (p.cwidth_n_spaces / opt.column) / aratio : coh/opt.row;
					opt.aspectratio = coh == 0 ? opt.aspectratio : p.itemw+":"+p.itemh;

					punchgs.TweenLite.set(item,{width:p.itemw,height:p.itemh,overwrite:"auto"});			// KRIKI KRIKI

				}// END OF MULTIPLIER CALCULATION#

				// RESET ASPECT RATIO IF FULLSCREEN ASPECT RATIO HAS BEEN CHANGED
				if (forceAR) {
					var eem = item.find('.esg-entry-media'),
						multi = (p.itemh/p.itemw)*100; 				
					punchgs.TweenLite.set(eem,{paddingBottom:multi+"%"});
				}
		}


		if (opt.layout=="even") {
			
		
		} else {



			if (item.hasClass("itemtoshow"))
				if (item.width() != p.itemw || item.css("opacity")==0 || item.css("visibility")=="hidden")
						p = prepareItemToMessure(item,p,container);
				else {

					adjustMediaSize(item,true,p,opt);
					p.itemh = item.height();

				}
		    else {

		    	adjustMediaSize(item,true,p,opt);
		    	p.itemh = item.height();
		    }


		}

		//adjustMediaSize(item,true,p);

		p = animateGrid($item,opt,p);
		p.itemcounter++;

		if (ul.height()<p.maxheight) container.trigger('itemsinposition');



	});

	opt.aspectratio = opt.aspectratioOrig;



	if (p.itemtowait==0) {
		opt.container.trigger('itemsinposition');
		container.find('.mainul').removeClass("gridorganising");
	}

	var gbfc = getBestFitColumn(opt,jQuery(window).width(),"id");
	opt.column = gbfc.column;
	opt.columnindex = gbfc.index;
	opt.mmHeight = gbfc.mmHeight;

	opt.maxheight = p.maxheight;
	opt.container.trigger('itemsinposition');
	opt.inanimation = true;

	// RESET FILTER AND STARTER VALUES
	opt.started = false;
	opt.filterchanged=false;
	opt.silent=false;
	opt.silentout=false;
	opt.changedAnim = "";
	setOptions(container,opt);
	
	if (opt.esgloader.length>0 && opt.esgloaderprocess != "remove") {
		opt.esgloaderprocess = "remove";
		var infdelay = 0;

		if (opt.esgloader.hasClass("infinityscollavailable")) 
		 	infdelay = 1;		
		punchgs.TweenLite.to(opt.esgloader,1,{autoAlpha:0,ease:punchgs.Power3.easeInOut,delay:infdelay});
	}


	
	
 }

/***************************************
	-	Prepare Item for Messure	-
***************************************/

function prepareItemToMessure(item,p,container) {

//		punchgs.TweenLite.set(item,{width:p.itemw,height:"auto",visibility:"visible"});
		adjustMediaSize(item,true,p,container.data('opt'));
	 	p.itemh = item.outerHeight(true);
		return p;
	}



/*****************************************
	-	GRID ANIMATOR -
*****************************************/
function animateGrid($item,opt,p) {

	

	// Basics
	var item= jQuery($item),
		samepageanims =   ["fade","scale","vertical-flip","horizontal-flip","vertical-flipbook","horizontal-flipbook","fall","rotatefall","rotatescale","stack"],
		horizontalanims = ["horizontal-slide","horizontal-harmonica"],
		verticalalanims = ["vertical-slide","vertical-harmonica"];





	p.skipanim = false;
	p.x= Math.round(p.col*p.itemw);


	// CALCULATE THE POSITIONS

	if (opt.layout=="even") {
//		p.y = (Math.round(p.itemh)*p.row);
	} else {
		p.idealcol = 0;
		p.backupcol = p.col;
		for (var i=0;i<opt.column;i++)
		  if (p.currentcolumnheight[p.idealcol]>p.currentcolumnheight[i])
		    p.idealcol = i;

		p.y = p.currentcolumnheight[p.idealcol];

		p.x= Math.round(p.idealcol*p.itemw) + p.idealcol * opt.space;

		p.col=p.idealcol;


		if (p.itemh==undefined) p.itemh=0;

	}

	if (p.cobblesx != undefined) {
		p.x = p.cobblesx * p.cobblesorigw;
		p.y = p.cobblesy * p.cobblesorigh;
	}



	p.waits=p.col*(p.delaybasic)+p.row*(p.delaybasic*opt.column);


	p.speed=opt.animSpeed;
	p.inxrot =0;
	p.inyrot =0;
	p.outxrot=0;
	p.outyrot=0;
	p.inorigin="center center";
	p.outorigin="center center";
	p.itemh = Math.round(p.itemh);
	p.scale=1;

	p.outfade=0;
	p.infade=0;


	/**************************************
		-	THE FADE OVER ANIMATIONS	-
	***************************************/
	if (item.hasClass("itemonotherpage"))
		p.skipanim = true;


	/**************************************
		-	THE SLIDE ANIMATIONS	-
	***************************************/
	if (p.anim == "horizontal-slide") {
		p.waits=0;

		p.hsoffset = 0-p.cwidth-parseInt(opt.space);
		p.hsoffsetout = 0-p.cwidth-parseInt(opt.space);


		if (opt.oldpage!=undefined && opt.oldpage>opt.currentpage) {
			p.hsoffset = p.cwidth+parseInt(opt.space);
			p.hsoffsetout = p.cwidth+parseInt(opt.space);

		}


	} else

	if (p.anim == "vertical-slide") {
		p.waits=0;
		p.maxcalcheight = (opt.row * opt.space) + (opt.row*p.itemh);

		p.vsoffset = p.maxcalcheight+parseInt(opt.space);
		p.vsoffsetout = p.maxcalcheight+parseInt(opt.space);

		if (opt.oldpage!=undefined && opt.oldpage>opt.currentpage) {
			p.vsoffset = 0-p.maxcalcheight-parseInt(opt.space);
			p.vsoffsetout = 0-p.maxcalcheight-parseInt(opt.space);
		}
	}



	// MAKE IN AND OUTWAITS EQUAL FOR THIS MOMENT
	p.outwaits = p.waits;


	// SPACE CORRECTIONS
	if (opt.layout=="even" && p.cobblesx == undefined)  {
			p.x= p.x + p.col * opt.space;
			//p.y = p.y + p.row*opt.space;
	}

	if (p.cobblesx != undefined) {

		p.x = p.x + p.cobblesx * opt.space;
		p.y = p.y + p.cobblesy * opt.space;
	}


	/********************************
		-	FLIPS && flipbookS	-
	*********************************/

    if (p.anim == "vertical-flip" || p.anim == "horizontal-flip" || p.anim == "vertical-flipbook" || p.anim == "horizontal-flipbook")
    	p=fakePositions(item,p,opt);



	/******************************
		-	FLIP VALUES 	-
	********************************/

	if (p.anim == "vertical-flip") {
		p.inxrot = -180;
		p.outxrot = 180;
	}
	else

	if (p.anim == "horizontal-flip") {
		p.inyrot = -180;
		p.outyrot = 180;

	}

	// EVEN SPEEDS
	p.outspeed=p.speed;



	if (opt.animDelay=="off") {
		p.waits=0;
		p.outwaits=0;
	}


	/******************************
		-	SCALES	-
	********************************/

	if (p.anim=="scale") {
		p.scale =0;
	}

	else

	/******************************
		-	flipbook VALUES	-
	********************************/

	if (p.anim == "vertical-flipbook") {
		p.inxrot = -90;
		p.outxrot = 90;
		p.inorigin = "center top"
		p.outorigin = "center bottom"
		p.waits = p.waits+p.speed/3;
		p.outfade=1;
		p.infade=1;
		p.outspeed=p.speed/1.2;
		p.ease = "Sine.easeOut";
		p.easeout = "Sine.easeIn";

		if (opt.animDelay=="off") {
			p.waits=p.speed/3;
			p.outwaits=0;
		}
	}

	else

	if (p.anim == "horizontal-flipbook") {
		p.inyrot = -90;
		p.outyrot = -90;
		p.inorigin = "left center"
		p.outorigin = "right center"
		p.waits = p.waits+p.speed/2.4;
		p.outfade=1;
		p.infade=1;
		p.outspeed=p.speed/1.2;
		p.ease = "Sine.easeOut";
		p.easeout = "Sine.easeIn";
		if (opt.animDelay=="off") {
			p.waits=p.speed/3;
			p.outwaits=0;
		}

	}

	else

	/******************************
		-	FALL ANIMATION	-
	********************************/

	if (p.anim == "fall" || p.anim== "rotatefall") {
		p.outoffsety = 100;
		p=fakePositions(item,p,opt);
		p.outfade=0;
	}



	if (p.anim=="rotatefall") {
		p.rotatez = 20;
		p.outorigin = "left top"
		p.outfade=1;
		p.outoffsety = 600;
	}

	else

	/******************************
		-	ROTATESCALE	-
	********************************/

	if (p.anim== "rotatescale") {
		p.scale=0;
		p.inorigin = "left bottom";
		p.outorigin = "center center";
		p.faeout =1;
		p.outoffsety = 100;
		p=fakePositions(item,p,opt);
	}

	else

	/******************************
		-	STACK	-
	********************************/

	if (p.anim== "stack") {
		p.scale=0;
		p.inorigin = "center center";
		p.faeout =1;
		p.ease = "punchgs.Power3.easeOut";

		p=fakePositions(item,p,opt);
		p.ease="Back.easeOut";
	}







	/**********************************************
		-	DEPENDENCIES ON CHANGES AND FILTERS	-
	**********************************************/




	// IF ANIMATION SHOULD BE DONE IN SILENT, WITHOUT ANIMATION AT ALL
	if (opt.silent) {
		p.waits=0;
		p.outwaits=0;
		p.speed=0;
		p.outspeed=0;

	}

	// IF ANIMATION OF OUTGOING ELEMENTS SHOULD BE SLIENT
	if (opt.silentout) {
		p.outwaits=0;
		p.outspeed=0.4;
		p.speed=0.4;
		p.ease="punchgs.Power3.easeOut";
		p.easeout=p.ease;

	}

	//p.waits=p.waits*1.15;
	//p.speed = p.speed + 0.5;

	//p.ease = punchgs.Power1.easeInOut;

	p.hooffset = opt.overflowoffset;
	p.vooffset = opt.overflowoffset;




	/******************************
		-	ANIMATION ITSELF	-
	********************************/



	if ((p.itemw+p.x-p.cwidth)<20 && (p.itemw+p.x-p.cwidth)>-20) {
		var dif = (p.itemw+p.x)-p.cwidth;
		p.itemw = p.itemw - dif;

	}


	if ((item.hasClass("itemtoshow") || item.hasClass("fitsinfilter")) && !p.skipanim) {
			item.addClass("isvisiblenow");

			if (opt.layout!="even") {
				p.currentcolumnheight[p.idealcol] = p.currentcolumnheight[p.idealcol] + p.itemh + parseInt(opt.space);
				if (p.ulcurheight<p.currentcolumnheight[p.idealcol]) {
					p.ulcurheight = p.currentcolumnheight[p.idealcol];

				}
			} else {
				p.ulcurheight = p.y + p.itemh;
			}



			if (p.maxheight<p.ulcurheight) {   //&& p.pagecounter<=opt.currentpage
				p.maxheight=p.ulcurheight;
			}



			p.itemtowait++;



			var localx = Math.round(p.hooffset+p.x)
			var localy = Math.round(p.vooffset+p.y)

			// RTL SUPPORT
			if (opt.rtl=="on")
				localx = (p.ulwidth-localx-p.itemw)

			// FADE OVER SPECIALS
			if (item.css("opacity")==0 && p.anim == "fade") {

				punchgs.TweenLite.set(item,{opacity:0,autoAlpha:0,width:p.itemw,height:p.itemh,scale:1,left:localx,y:0,top:localy,overwrite:"all"});

			} else

			// SCALE OVER SPECIALS
			if (item.css("opacity")==0 && p.anim == "scale") {
				punchgs.TweenLite.set(item,{width:p.itemw,height:p.itemh,scale:0,left:localx,y:0,top:localy,overwrite:"all"});
			} else

			// ROTATE SCALE ANIMATIONS
			if (item.css("opacity")==0 && p.anim == "rotatescale")
				punchgs.TweenLite.set(item,{width:p.itemw,height:p.itemh,scale:1,left:localx,top:localy,xPercent:+150,yPercent:+150,rotationZ:20,overwrite:"all"});

			else
			// THE FALL ANIMATION
			if (item.css("opacity")==0 && p.anim=="fall")
				punchgs.TweenLite.set(item,{width:p.itemw,height:p.itemh,scale:0.5,left:localx,top:localy,y:0,overwrite:"all"});

			else
			// THE ROTATEFALL ANIMATION
			if (item.css("opacity")==0 && p.anim=="rotatefall")
				punchgs.TweenLite.set(item,{autoAlpha:0,width:p.itemw,height:p.itemh,left:localx,rotationZ:0,top:localy,y:0,overwrite:"all"});





			// FADE OVER SPECIALS

			// PREPARING THE FLIPS
			if (item.css("opacity")==0 && (p.anim=="vertical-flip" || p.anim=="horizontal-flip" || p.anim=="vertical-flipbook" || p.anim=="horizontal-flipbook"))
				punchgs.TweenLite.set(item,{autoAlpha:p.infade,zIndex:10,scale:1,y:0,transformOrigin:p.inorigin, rotationX:p.inxrot,rotationY:p.inyrot,width:p.itemw,height:p.itemh,left:localx,top:localy,overwrite:"all"});

			// STACK ANIMATION
			if (p.anim=="stack")
				punchgs.TweenLite.set(item,{zIndex:p.pageitemcounter,scale:0.5,autoAlpha:1,left:localx,top:localy});

			// HORIZONTAL SLIDE ANIMATIONS
			if (p.anim=="horizontal-slide" && item.css("opacity")==0) {
				punchgs.TweenLite.set(item,{autoAlpha:1,left:Math.round(p.hooffset+(p.x-p.hsoffset)),top:localy, width:p.itemw, height:p.itemh});
			}

			// VERTICAL SLIDE ANIMATIONS
			if (p.anim=="vertical-slide" && item.css("opacity")==0)
				punchgs.TweenLite.set(item,{autoAlpha:1,left:localx,top:Math.round(p.vooffset+p.y-p.vsoffset), width:p.itemw, height:p.itemh});





			//////////////////////////////////////////////////////////////
			// ANIMATE THE ITEMS IN THE GRID TO OPSITION AND VISIBILITY //
			//////////////////////////////////////////////////////////////


		   var ecc = item.find('.esg-entry-cover');
		   var media = item.find('.esg-entry-media');
		   if (ecc && media) {
			  var mh = media.outerHeight();
			  var cc = item.find('.esg-cc');			  
			  punchgs.TweenLite.to(ecc,0.01,{height:mh,ease:p.ease,delay:p.waits});
		      punchgs.TweenLite.to(cc,0.01,{top:((mh - cc.height()) / 2 ),ease:p.ease,delay:p.waits});
		   }

			opt.container.trigger('itemsinposition');
		  	punchgs.TweenLite.to(item,p.speed,{force3D:"auto",autoAlpha:1,scale:1,transformOrigin:p.inorigin,rotationX:0,rotationY:0,y:0,x:0,xPercent:0,yPercent:0,z:0.1,rotationZ:0,left:localx,top:localy,ease:p.ease,delay:p.waits,
						onComplete:function() {
							if (item.hasClass("itemtoshow")) {
								punchgs.TweenLite.set(item,{autoAlpha:1,overwrite:"all"});

							}
							p.itemtowait--;

							if (p.itemtowait==0) {								
								opt.container.trigger('itemsinposition');
								item.closest('.mainul').removeClass("gridorganising");

							}
						}
					});




			//ANIMATE THE IFRAME SIZES, FOR VIDEOS AND REST FOR FUN
			/*if (item.find('iframe').length>0) {
		 		item.find('iframe').each(function() {
		 			var ifr = jQuery(this);
			 		var ifw = Math.round(ifr.data('neww'));
			 		var ifh = Math.round(ifr.data('newh'));
			 		if (opt.layout!="even") {
				 		punchgs.TweenLite.set(item.find('.esg-media-poster'),{width:ifw,height:ifh});
				 		punchgs.TweenLite.set(item.find('iframe'),{width:ifw,height:ifh});
				 	}	else {
					 	punchgs.TweenLite.set(item.find('.esg-media-poster'),{width:"100%",height:"100%"});
				 		punchgs.TweenLite.set(item.find('iframe'),{width:"100%",height:"100%"});
				 	}
				});
	 		}

	 		//ANIMATE THE HTML5 SIZES, FOR VIDEOS AND REST FOR FUN
			if (item.find('.video-eg').length>0) {
		 		item.find('.video-eg').each(function() {
		 			var ifr = jQuery(this);
			 		var ifw = ifr.data('neww');
			 		var ifh = ifr.data('newh');
			 		if (opt.layout!="even") {
				 		punchgs.TweenLite.set(item.find('.esg-media-poster'),{width:ifw,height:ifh});
				 		punchgs.TweenLite.set(item.find('.esg-entry-media'),{width:ifw,height:ifh});
				 		punchgs.TweenLite.set(item.find('.video-eg'),{width:ifw,height:ifh});
				 	} else {
					 	punchgs.TweenLite.set(item.find('.esg-media-poster'),{width:"100%",height:"100%"});
				 		punchgs.TweenLite.set(item.find('.esg-entry-media'),{width:"100%",height:"100%"});
				 		punchgs.TweenLite.set(item.find('.video-eg'),{width:"100%",height:"100%"});
				 	}
				});
	 		}*/



			// NEXT PAGE PLEASE
			if (opt.layout=="masonry") p.col = p.backupcol;
			p=shiftGrid(p,opt,item);



	} else {

		p.itemouttowait++;
		punchgs.TweenLite.set(item,{zIndex:5});
		item.removeClass("isvisiblenow");



		if (item.css("opacity")>0) {
			// TWEEN OPACITY AND ROTATIONS

			if (p.anim=="stack") {

				punchgs.TweenLite.set(item,{zIndex:p.pageitemcounterfake+100})
				punchgs.TweenLite.to(item,p.outspeed/2,{force3D:"auto",x:-20-p.itemw,rotationY:30,rotationX:10,ease:Sine.easeInOut,delay:p.outwaits});
				punchgs.TweenLite.to(item,0.01,{force3D:"auto",zIndex:p.pageitemcounterfake,delay:p.outwaits+p.outspeed/3});

				punchgs.TweenLite.to(item,p.outspeed*0.2,{force3D:"auto",delay:p.outwaits+p.outspeed*0.9,autoAlpha:0,ease:Sine.easeInOut});
				punchgs.TweenLite.to(item,p.outspeed/3,{zIndex:2,force3D:"auto",x:0,scale:0.9,rotationY:0,rotationX:0,ease:Sine.easeInOut,delay:p.outwaits+p.outspeed/1.4,onComplete:function() {
						if (!item.hasClass("itemtoshow")) punchgs.TweenLite.set(item,{autoAlpha:0,overwrite:"all",display:"none"});
						p.itemouttowait--;
						if (p.itemouttowait==0) {
							
							opt.container.trigger('itemsinposition');
						}
					}});;
			}

			else

			if (p.anim == "horizontal-flipbook" || p.anim == "vertical-flipbook") {

				punchgs.TweenLite.to(item,p.outspeed,{force3D:"auto",zIndex:2,scale:p.scale,autoAlpha:p.outfade,transformOrigin:p.outorigin,rotationX:p.outxrot,rotationY:p.outyrot,ease:p.easeout,delay:p.outwaits,onComplete:function() {

					if (!item.hasClass("itemtoshow")) punchgs.TweenLite.set(item,{autoAlpha:0,overwrite:"all",display:"none"});
					p.itemouttowait--;
					if (p.itemouttowait==0) {

						
						opt.container.trigger('itemsinposition');
					}
				}});
			}

			else

			if (p.anim =="fall")
				punchgs.TweenLite.to(item,p.outspeed,{zIndex:2,force3D:"auto",y:p.outoffsety,autoAlpha:0,ease:p.easeout,delay:p.outwaits,onComplete:function() {

					if (!item.hasClass("itemtoshow")) punchgs.TweenLite.set(item,{autoAlpha:0,overwrite:"all",display:"none"});
					p.itemouttowait--;
					if (p.itemouttowait==0) {
						
						opt.container.trigger('itemsinposition');
					}
				}});


			else

			if (p.anim=="horizontal-slide")
				punchgs.TweenLite.to(item,p.outspeed,{zIndex:2,force3D:"auto",autoAlpha:1,left:p.hooffset+item.position().left+p.hsoffsetout,top:p.vooffset+item.position().top,ease:p.easeout,delay:p.outwaits,onComplete:function() {

						punchgs.TweenLite.set(item,{autoAlpha:0,overwrite:"all",display:"none"});
						p.itemouttowait--;
						if (p.itemouttowait==0) {
							
							opt.container.trigger('itemsinposition');
						}
					}});
			else

			if (p.anim=="vertical-slide")
				punchgs.TweenLite.to(item,p.outspeed,{zIndex:2,force3D:"auto",autoAlpha:1,left:p.hooffset+item.position().left,top:p.vooffset+item.position().top+p.vsoffsetout,ease:p.easeout,delay:p.outwaits,onComplete:function() {

						punchgs.TweenLite.set(item,{autoAlpha:0,overwrite:"all",display:"none"});
						p.itemouttowait--;
						if (p.itemouttowait==0) {
							
							opt.container.trigger('itemsinposition');
						}
					}});
			else

			if (p.anim=="rotatefall" && item.css("opacity")>0) {

				punchgs.TweenLite.set(item,{zIndex:300-p.item});
				punchgs.TweenLite.to(item,p.outspeed/2,{force3D:"auto",transformOrigin:p.outorigin,ease:"punchgs.Bounce.easeOut",rotationZ:p.rotatez,delay:p.outwaits});
				punchgs.TweenLite.to(item,p.outspeed/2,{zIndex:2,force3D:"auto",autoAlpha:0,y:p.outoffsety,ease:punchgs.Power3.easeIn,delay:p.outwaits+p.outspeed/3});
			}

			else {

				punchgs.TweenLite.to(item,p.outspeed,{force3D:"auto",zIndex:2,scale:p.scale,autoAlpha:p.outfade,transformOrigin:p.outorigin,rotationX:p.outxrot,rotationY:p.outyrot,ease:p.easeout,delay:p.outwaits,onComplete:function() {

					if (!item.hasClass("itemtoshow")) punchgs.TweenLite.set(item,{autoAlpha:0,overwrite:"all",display:"none"});
					p.itemouttowait--;
					if (p.itemouttowait==0) {
						
						opt.container.trigger('itemsinposition');
					}
				}});
			}
		} else {
			punchgs.TweenLite.set(item,{zIndex:2,scale:p.scale,autoAlpha:0,transformOrigin:p.outorigin,rotationX:p.outxrot,rotationY:p.outyrot,onComplete:function() {

					if (!item.hasClass("itemtoshow")) punchgs.TweenLite.set(item,{autoAlpha:0,overwrite:"all",display:"none"});
					p.itemouttowait--;
					if (p.itemouttowait==0) {
						
						opt.container.trigger('itemsinposition');
					}
				}});


		}


		//CALCULATE FAKE POSITIONS IN GRID
		p=shiftGridFake(p,opt);



	}

	
	return p;
}

/******************************
	-	FAKE POSITIONS	-
********************************/
function fakePositions(item,p,opt) {
	if ((item.hasClass("itemtoshow") || item.hasClass("fitsinfilter")) && !p.skipanim) {
    		// ITEM MUST BE SHOWN
    	} else {
		// CHECK IF ITEM HAD ALREADY A POSITION IN GRID SOMEWHERE
    		var cc = item.data('col');
			var rr = item.data('row');

			// IF NOT, THE OUTGOING ITEMS NEED TO GET A POSITIONG IN GRID
			if (cc==undefined || rr==undefined ) {
				if (p.x!=0 && p.y!=0) {
					p.x= Math.round(p.fakecol*p.itemw);
					p.y = p.fakey;
					cc=p.fakecol;
					rr=p.fakerow;
					item.data('col',p.fakecol);
					item.data('row',p.fakerow);
				}
			}

			if (p.anim=="rotatefall") {
				p.outwaits = (opt.column-cc)*p.delaybasic+(rr)*(p.delaybasic*opt.column);

			} else {
				p.outwaits=cc*p.delaybasic+rr*(p.delaybasic*opt.column);
			}
		}
	return p;
}

/******************************
	-	SHIFT THE GRID	-
********************************/

function shiftGrid(p,opt,item) {
	item.data('col',p.col);
	item.data('row',p.row);
	p.pageitemcounter++;
	p.col=p.col+p.verticalsteps;

	p.allcol++;
	if (p.col==opt.column) {
		 p.col=0;
		 p.row++;
		 p.allrow++;
		 p.y = parseFloat(p.y) + parseFloat(p.itemh) + parseFloat(opt.space);
		 if (p.row==opt.row) {
		 	p.row=0;

	 		if (p.pageitemcounter>=opt.column*opt.row) p.pageitemcounter=0;
		 	p.pagetoanimate=p.pagetoanimate+1;
		 	p.pagecounter++;
		 	if (p.pageitemcounter==0)
			 	for (var i=0;i<opt.column;i++)
					p.currentcolumnheight[i] = 0;
		 }
	}

	return p;
}





/******************************
	-	SHIFT THE FAKE GRID	-
********************************/

function shiftGridFake(p,opt) {
	p.fakecol=p.fakecol+1;
	p.pageitemcounterfake++;

	if (p.fakecol==opt.column) {
		 p.fakecol=0;
		 p.fakerow++;
		 p.fakey = p.fakey + p.itemh + opt.space;

		 if (p.fakerow==opt.row) {
		 	p.fakerow=0;
		 	p.pageitemcounterfake=0;;
		 }
	}
	return p;
}






















/******************************
	-	VIDEO HANDLINGS	-
********************************/


/******************************
	-	LOAD VIDEO APIS	-
********************************/
function loadVideoApis(container,opt) {
	var addedyt=0;
	var addedvim=0;
	var addedws=0;
	var addedvid=0;
	var addedsc = 0;
	var httpprefix = "http";

	if (location.protocol === 'https:') {
			httpprefix = "https";
	}
	container.find('iframe').each(function(i) {
		try {
			if (jQuery(this).attr('src').indexOf('you')>0 && addedyt==0) {
				addedyt=1;
				var s = document.createElement("script");
				var httpprefix2 = "https";
				s.src = httpprefix2+"://www.youtube.com/iframe_api"; /* Load Player API*/

				var before = document.getElementsByTagName("script")[0];
				var loadit = true;
				jQuery('head').find('*').each(function(){
					if (jQuery(this).attr('src') == httpprefix2+"://www.youtube.com/iframe_api")
					   loadit = false;
				});
				if (loadit) {
					before.parentNode.insertBefore(s, before);


				}
			}
		} catch(e) {}
	});



	 // LOAD THE wistia API
	 container.find('iframe').each(function(i) {
		try{
			if (jQuery(this).attr('src').indexOf('ws')>0 && addedws==0) {
					addedws=1;
					var f = document.createElement("script");
					f.src = httpprefix+"://fast.wistia.com/assets/external/E-v1.js"; /* Load Player API*/
					var before = document.getElementsByTagName("script")[0];

					var loadit = true;
					jQuery('head').find('*').each(function(){
						if (jQuery(this).attr('src') == httpprefix+"://fast.wistia.com/assets/external/E-v1.js")
						   loadit = false;
					});
					if (loadit)
						before.parentNode.insertBefore(f, before);
				}
			} catch(e) {}
	});

// LOAD THE VIMEO API
	 container.find('iframe').each(function(i) {
		try{
				if (jQuery(this).attr('src').indexOf('vim')>0 && addedvim==0) {
					addedvim=1;
					var f = document.createElement("script");
					f.src ="https://secure-a.vimeocdn.com/js/froogaloop2.min.js"; /* Load Player API*/
					var before = document.getElementsByTagName("script")[0];

					var loadit = true;
					jQuery('head').find('*').each(function(){
						if (jQuery(this).attr('src') == "https://secure-a.vimeocdn.com/js/froogaloop2.min.js")
						   loadit = false;
					});
					if (loadit)
						before.parentNode.insertBefore(f, before);
				}
			} catch(e) {}
	});


	  // LOAD THE SOUNDCLOUD API
	 container.find('iframe').each(function(i) {
		try{
				if (jQuery(this).attr('src').indexOf('soundcloud')>0 && addedsc==0) {

					addedsc=1;
					var f = document.createElement("script");
					f.src = httpprefix+"://w.soundcloud.com/player/api.js"; /* Load Player API*/
					var before = document.getElementsByTagName("script")[0];

					var loadit = true;
					jQuery('head').find('*').each(function(){
						if (jQuery(this).attr('src') == httpprefix+"://w.soundcloud.com/player/api.js")
						   loadit = false;
					});
					if (loadit)
						before.parentNode.insertBefore(f, before);
				}
			} catch(e) {}
	});


	var videohandlers= {youtube:addedyt,
						vimeo:addedvim,
						wistia:addedws,
						soundcloud:addedsc,
						htmlvid:addedvid};


	return videohandlers;
}

function toHHMMSS() {


	var date_now = new Date();

	var seconds = Math.floor(date_now)/1000;

	var minutes = Math.floor(seconds/60);
	var hours = Math.floor(minutes/60);
	var days = Math.floor(hours/24);

	var hours = hours-(days*24);
	var minutes = minutes-(days*24*60)-(hours*60);
	var seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);

	return hours+":"+minutes+":"+seconds;
}


/************************************
	-	STOP ALL  VIDEOS	-
*************************************/

function stopAllVideos(forceall,killiframe,callerid) {
	
	var isplaying=" isplaying";
	if (forceall) isplaying = "";	

	var visibleitems = document.getElementsByClassName("tp-esg-item isvisiblenow");


	for (var a=0;a<visibleitems.length;a++) {
		var _y = visibleitems[a].getElementsByClassName('esg-youtubevideo haslistener'+isplaying),
		    _v = visibleitems[a].getElementsByClassName('esg-vimeovideo haslistener'+isplaying),
		    _w = visibleitems[a].getElementsByClassName('esg-wistiavideo haslistener'+isplaying),
		    _h = visibleitems[a].getElementsByClassName('esg-htmlvideo haslistener'+isplaying),
		    _s = visibleitems[a].getElementsByClassName('esg-soundcloud'+isplaying);
			
		for (var i=0;i<_y.length;i++) {
			var ifr = jQuery(_y[i]),
				player = ifr.data('player');

			if (callerid !=ifr.attr('id')) {
				player.pauseVideo();
				if (forceall)  forceVideoInPause(ifr,true,player,"youtube")
			}
		}
		for (i=0;i<_v.length;i++) {
			var ifr = jQuery(_v[i]),
				id = ifr.attr('id'),
				player = $f(id);
			if (callerid !=id) {
				player.api("pause");
				if (callerid===undefined)		
					if (forceall)  forceVideoInPause(ifr,true,player,"vimeo")
			}
		}
		for (i=0;i<_w.length;i++) {
			var ifr = jQuery(_w[i]),
				player = ifr.data('player');

			if (callerid!=ifr.attr('id')) {
				ifr.wistiaApi.pause();
				if (forceall)  forceVideoInPause(ifr,true,player,"wistia")
			}
		}
		for (i=0;i<_h.length;i++) {
			var ifr = jQuery(_h[i]),
				id = ifr.attr('id'),
				player=document.getElementById(id);

			if (callerid !=id) {
				player.pause();
				if (forceall)  forceVideoInPause(ifr,true,player,"html5vid")
			}
		}
		for (i=0;i<_s.length;i++) {
			var ifr = jQuery(_s[i]),
				player = ifr.data('player');
			if (callerid !=ifr.attr('id')) {
				player.pause();
				if (forceall)  forceVideoInPause(ifr,true,player,"soundcloud")
			}
		}

	}

}

/*************************************************************
	-	FORCE VIDEO BACK IN PAUSE MODE AND SHOW POSTER 	-
*************************************************************/
function forceVideoInPause(vid,killiframe,player,vidtype) {

				vid.removeClass("isplaying");


				var item=vid.closest('.tp-esg-item');


				if (item.find('.esg-media-video').length>0 && !jQuery("body").data('fullScreenMode')) {
					 var cover = item.find('.esg-entry-cover');
					 var poster = item.find('.esg-media-poster');
					 if (poster.length>0) {
					 	 if (!is_mobile()) {
							 punchgs.TweenLite.to(cover,0.5,{autoAlpha:1});
							 punchgs.TweenLite.to(poster,0.5,{autoAlpha:1});
							 punchgs.TweenLite.to(vid,0.5,{autoAlpha:0});
						} else {
							punchgs.TweenLite.set(cover,{autoAlpha:1});
							 punchgs.TweenLite.set(poster,{autoAlpha:1});
							 punchgs.TweenLite.set(vid,{autoAlpha:0});
						}

						 if (killiframe) {
						   if (vidtype=="youtube")
								try {  player.destroy(); } catch(e) {}
							else
						   if (vidtype=="vimeo")
							try {  player.api("unload"); } catch(e) {}
						   else
							if (vidtype=="wistia")
								try {  player.end(); } catch(e) {}
							else
						   if (vidtype!="html5vid") {
							   vid.removeClass("haslistener");
							   vid.removeClass("readytoplay");
							 }

					     } else {
							 setTimeout(function() {
							 	if (!is_mobile())
									vid.css({display:"none"});
							 },500);
						 }
					}
				}
			}


//////////////////////////////////////////
// CHANG THE YOUTUBE PLAYER STATE HERE //
////////////////////////////////////////
function onPlayerStateChange(event) {

		
		
				
		var ytcont = event.target.getIframe(),
			jc = jQuery(ytcont);

		if (event.data == YT.PlayerState.PLAYING) {
			event.target.setPlaybackQuality("hd1080");
			stopAllVideos(true,false,ytcont.id);
			jc.addClass("isplaying").removeClass("isinpause");			
		}

		if (event.data==2 ) {
			forceVideoInPause(jc);
		}

		if (event.data==0 ) {
			forceVideoInPause(jc);
		}
		
}






/////////////////////////////////////
// EVENT HANDLING FOR VIMEO VIDEOS //
/////////////////////////////////////

function vimeoready_auto(player_id) {

		var froogaloop = $f(player_id);
		var vimcont = jQuery('#'+player_id);

		froogaloop.addEvent('ready', function(data) {
				vimcont.addClass("readytoplay");


				froogaloop.addEvent('play', function(data) {
					
					stopAllVideos(true,false,player_id);
					vimcont.addClass("isplaying");
					vimcont.removeClass("isinpause");
				});

				froogaloop.addEvent('finish', function(data) {
					
					forceVideoInPause(vimcont);
					vimcont.removeClass("isplaying");
				});

				froogaloop.addEvent('pause', function(data) {
					
					forceVideoInPause(vimcont);
					vimcont.removeClass("isplaying");
				});
		});
}

function addEvent(element, eventName, callback) {

		if (element.addEventListener)  element.addEventListener(eventName, callback, false);
			else
		element.attachEvent(eventName, callback, false);
}


///////////////////////////////////////
// EVENT HANDLING FOR VIDEO JS VIDEOS //
////////////////////////////////////////
function html5vidready(myVideo,vidcont,player_id) {


		vidcont.addClass("readytoplay");

		vidcont.on('play',function() {
			stopAllVideos(true,false,player_id);
			vidcont.addClass("isplaying");
			vidcont.removeClass("isinpause");
		});




		vidcont.on('pause',function() {
			forceVideoInPause(vidcont);
			vidcont.removeClass("isplaying");
		});

		vidcont.on('ended',function() {
			forceVideoInPause(vidcont);
			vidcont.removeClass("isplaying");
		});



}



/********************************************************
	-	YOUTUBE IFRAME ID AND PLAYER OCNFIGURTION	-
*********************************************************/

function prepareYT(ifr) {


	 var frameID = "ytiframe"+Math.round(Math.random()*100000+1);

	 if (!ifr.hasClass("haslistener") && typeof YT != "undefined") {

		 try{
			ifr.attr('id',frameID);

				var player = new YT.Player(frameID, {
					events: {
						"onStateChange": onPlayerStateChange
					}
				});
				ifr.data('player',player);
				ifr.addClass("haslistener").addClass("esg-youtubevideo");

			} catch(e) { return false}
	} else {
		var player = ifr.data('player');
		if (player!=undefined)
			if (typeof player.playVideo=="function")
				return true;
			else
				return false;
		else
			return false;
	}

}

function playYT(ifr) {

	var player = ifr.data('player');
	if (player !=undefined)
		if (typeof player.playVideo == "function")
			player.playVideo();


}

/********************************************************
	-	VIMEO IFRAME ID AND PLAYER CONFIGURATION	-
********************************************************/

function prepareVimeo(ifr) {

	
	 if (!ifr.hasClass("haslistener") && typeof $f != "undefined") {
	     try {
	     			
					var frameID = "vimeoiframe"+Math.round(Math.random()*100000+1);
					ifr.attr('id',frameID);
					var isrc = ifr.attr('src');
					var queryParameters = {}, queryString = isrc,
					re = /([^&=]+)=([^&]*)/g, m;
					// Creates a map with the query string parameters

					
					while (m = re.exec(queryString)) {
						queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
					}

					if (queryParameters['player_id']!=undefined)
						isrc = isrc.replace(queryParameters['player_id'],frameID);
					else
						isrc=isrc+"&player_id="+frameID;

					
					try{ isrc = isrc.replace('api=0','api=1'); } catch(e) {}

					isrc=isrc+"&api=1";

					ifr.attr('src',isrc);
					var player = ifr[0];
					
					$f(player).addEvent('ready', function() {
						
						vimeoready_auto(frameID)
					});
					
					ifr.addClass("haslistener").addClass("esg-vimeovideo");
			 } catch(e) { return false}

	 } else {
			
	 		if (typeof $f != undefined && typeof $f != "undefined") {
	 			
	 			 var froogaloop = $f(ifr.attr('id'));
	 			 
		 		if (typeof froogaloop.api=="function" && ifr.hasClass("readytoplay")) {
		 			
			 		return true;
		 		}
		 		else {
		 			
			 		return false;
		 		}
			} else {
				
				return false;
			}
	 }

}

function playVimeo(ifr) {
	var froogaloop = $f(ifr.attr('id'));
	froogaloop.api("play");
}


/********************************************************
	-	wistia IFRAME ID AND PLAYER OCNFIGURTION	-
*********************************************************/

function prepareWs(ifr) {


	 var frameID = "wsiframe"+Math.round(Math.random()*100000+1);

	 if (!ifr.hasClass("haslistener") && typeof Ws != "undefined") {

		 try{
			ifr.attr('id',frameID);

				var player = new Ws.Player(frameID, {
					events: {
						"onStateChange": onPlayerStateChange
					}
				});
				ifr.data('player',player);
				ifr.addClass("haslistener").addClass("esg-wistiavideo");

			} catch(e) { return false}
	} else {
		var player = ifr.data('player');
		if (player!=undefined)
			if (typeof player.playVideo=="function")
				return true;
			else
				return false;
		else
			return false;
	}

}

function playWs(ifr) {

	var player = ifr.data('player');
	if (player !=undefined)
		if (typeof player.playVideo == "function")
			player.wistiaApi.Plau();
}

/********************************************************
	-	SOUNDCLUD IFRAME ID AND PLAYER CONFIGURATION	-
********************************************************/

function prepareSoundCloud(ifr) {

	 if (ifr.data('player')==undefined && typeof SC != "undefined") {
		  var frameID = "sciframe"+Math.round(Math.random()*100000+1);
		 try{

			ifr.attr('id',frameID);
			var player = SC.Widget(frameID);

			player.bind(SC.Widget.Events.PLAY,function() {

					stopAllVideos(true,false,ifr.attr('id'));
					ifr.addClass("isplaying");
					ifr.removeClass("isinpause");

				});
			player.bind(SC.Widget.Events.PAUSE,function() {
					forceVideoInPause(ifr);
					ifr.removeClass("isplaying");

			});
			player.bind(SC.Widget.Events.FINISH,function() {
					forceVideoInPause(ifr);
					ifr.removeClass("isplaying");

			});
			ifr.data('player',player);
			ifr.addClass("haslistener").addClass("esg-soundcloud");

		 } catch(e) { return false}
	} else {
		var player = ifr.data('player');
		if (player!=undefined) {

			if (typeof player.getVolume=="function") {
				return true;
			} else {
				return false;
			}
		} else
			return false;
	}

}

function playSC(ifr) {


	var player = ifr.data('player');
	if (player !=undefined) {

		if (typeof player.getVolume == "function") {

			setTimeout(function() {
				player.play();
			},500);
		}
	}

}

/********************************************************
	-	VIMEO IFRAME ID AND PLAYER CONFIGURATION	-
********************************************************/

function prepareVideo(html5vid) {

	 if (!html5vid.hasClass("haslistener")) {
	// 	try {
				 var videoID = "videoid_"+Math.round(Math.random()*100000+1);
				 html5vid.attr('id',videoID);
				 var myVideo=document.getElementById(videoID);
				 myVideo.oncanplay=html5vidready(myVideo,html5vid,videoID);

				 html5vid.addClass("haslistener").addClass("esg-htmlvideo");

		//	} catch(e) { return false }
	} else {
		try {
			 var id = html5vid.attr('id');
			 var myVideo=document.getElementById(id);

			 if (typeof myVideo.play=="function" && html5vid.hasClass("readytoplay"))
			   return true;
			else
			   return false;
			 } catch(e) { return false}
	}
}

function playVideo(ifr) {
	var id = ifr.attr('id');
	var myVideo=document.getElementById(id);
	myVideo.play();

}






})(jQuery);


/*! TinySort
* Copyright (c) 2008-2013 Ron Valstar http://tinysort.sjeiti.com/
*
* Dual licensed under the MIT and GPL licenses:
*   http://www.opensource.org/licenses/mit-license.php
*   http://www.gnu.org/licenses/gpl.html
*//*
* Description:
*   A jQuery plugin to sort child nodes by (sub) contents or attributes.
*
* Contributors:
*	brian.gibson@gmail.com
*	michael.thornberry@gmail.com
*
* Usage:
*   $("ul#people>li").tsort();
*   $("ul#people>li").tsort("span.surname");
*   $("ul#people>li").tsort("span.surname",{order:"desc"});
*   $("ul#people>li").tsort({place:"end"});
*   $("ul#people>li").tsort("span.surname",{order:"desc"},span.name");
*
* Change default like so:
*   $.tinysort.defaults.order = "desc";
*
*/
;(function($,undefined) {
	'use strict';
	// private vars
	var fls = !1							// minify placeholder
		,nll = null							// minify placeholder
		,prsflt = parseFloat				// minify placeholder
		,mathmn = Math.min					// minify placeholder
		,rxLastNr = /(-?\d+\.?\d*)$/g		// regex for testing strings ending on numbers
		,rxLastNrNoDash = /(\d+\.?\d*)$/g	// regex for testing strings ending on numbers ignoring dashes
		,aPluginPrepare = []
		,aPluginSort = []
		,isString = function(o){return typeof o=='string';}
		,loop = function(array,func){
            var l = array.length
                ,i = l
                ,j;
            while (i--) {
                j = l-i-1;
                func(array[j],j);
            }
		}
		// Array.prototype.indexOf for IE (issue #26) (local variable to prevent unwanted prototype pollution)
		,fnIndexOf = Array.prototype.indexOf||function(elm) {
			var len = this.length
				,from = Number(arguments[1])||0;
			from = from<0?Math.ceil(from):Math.floor(from);
			if (from<0) from += len;
			for (;from<len;from++){
				if (from in this && this[from]===elm) return from;
			}
			return -1;
		}
	;
	//
	// init plugin
	$.tinysort = {
		 id: 'TinySort'
		,version: '1.5.6'
		,copyright: 'Copyright (c) 2008-2013 Ron Valstar'
		,uri: 'http://tinysort.sjeiti.com/'
		,licensed: {
			MIT: 'http://www.opensource.org/licenses/mit-license.php'
			,GPL: 'http://www.gnu.org/licenses/gpl.html'
		}
		,plugin: (function(){
			var fn = function(prepare,sort){
				aPluginPrepare.push(prepare);	// function(settings){doStuff();}
				aPluginSort.push(sort);			// function(valuesAreNumeric,sA,sB,iReturn){doStuff();return iReturn;}
			};
			// expose stuff to plugins
			fn.indexOf = fnIndexOf;
			return fn;
		})()
		,defaults: { // default settings

			 order: 'asc'			// order: asc, desc or rand

			,attr: nll				// order by attribute value
			,data: nll				// use the data attribute for sorting
			,useVal: fls			// use element value instead of text

			,place: 'start'			// place ordered elements at position: start, end, org (original position), first
			,returns: fls			// return all elements or only the sorted ones (true/false)

			,cases: fls				// a case sensitive sort orders [aB,aa,ab,bb]
			,forceStrings:fls		// if false the string '2' will sort with the value 2, not the string '2'

			,ignoreDashes:fls		// ignores dashes when looking for numerals

			,sortFunction: nll		// override the default sort function
		}
	};
	$.fn.extend({
		tinysort: function() {
			var i,j,l
				,oThis = this
				,aNewOrder = []
				// sortable- and non-sortable list per parent
				,aElements = []
				,aElementsParent = [] // index reference for parent to aElements
				// multiple sort criteria (sort===0?iCriteria++:iCriteria=0)
				,aCriteria = []
				,iCriteria = 0
				,iCriteriaMax
				//
				,aFind = []
				,aSettings = []
				//
				,fnPluginPrepare = function(_settings){
					loop(aPluginPrepare,function(fn){
						fn.call(fn,_settings);
					});
				}
				//
				,fnPrepareSortElement = function(settings,element){
					if (typeof element=='string') {
						// if !settings.cases
						if (!settings.cases) element = toLowerCase(element);
						element = element.replace(/^\s*(.*?)\s*$/i, '$1');
					}
					return element;
				}
				//
				,fnSort = function(a,b) {
					var iReturn = 0;
					if (iCriteria!==0) iCriteria = 0;
					while (iReturn===0&&iCriteria<iCriteriaMax) {
						var oPoint = aCriteria[iCriteria]
							,oSett = oPoint.oSettings
							,rxLast = oSett.ignoreDashes?rxLastNrNoDash:rxLastNr
						;
						//
						fnPluginPrepare(oSett);
						//
						if (oSett.sortFunction) { // custom sort
							iReturn = oSett.sortFunction(a,b);
						} else if (oSett.order=='rand') { // random sort
							iReturn = Math.random()<0.5?1:-1;
						} else { // regular sort
							var bNumeric = fls
								// prepare sort elements
								,sA = fnPrepareSortElement(oSett,a.s[iCriteria])
								,sB = fnPrepareSortElement(oSett,b.s[iCriteria])
							;
							// maybe force Strings
							if (!oSett.forceStrings) {
								// maybe mixed
								var  aAnum = isString(sA)?sA&&sA.match(rxLast):fls
									,aBnum = isString(sB)?sB&&sB.match(rxLast):fls;
								if (aAnum&&aBnum) {
									var  sAprv = sA.substr(0,sA.length-aAnum[0].length)
										,sBprv = sB.substr(0,sB.length-aBnum[0].length);
									if (sAprv==sBprv) {
										bNumeric = !fls;
										sA = prsflt(aAnum[0]);
										sB = prsflt(aBnum[0]);
									}
								}
							}
							iReturn = oPoint.iAsc*(sA<sB?-1:(sA>sB?1:0));
						}

						loop(aPluginSort,function(fn){
							iReturn = fn.call(fn,bNumeric,sA,sB,iReturn);
						});

						if (iReturn===0) iCriteria++;
					}

					return iReturn;
				}
			;
			// fill aFind and aSettings but keep length pairing up
			for (i=0,l=arguments.length;i<l;i++){
				var o = arguments[i];
				if (isString(o))	{
					if (aFind.push(o)-1>aSettings.length) aSettings.length = aFind.length-1;
				} else {
					if (aSettings.push(o)>aFind.length) aFind.length = aSettings.length;
				}
			}
			if (aFind.length>aSettings.length) aSettings.length = aFind.length; // todo: and other way around?

			// fill aFind and aSettings for arguments.length===0
			iCriteriaMax = aFind.length;
			if (iCriteriaMax===0) {
				iCriteriaMax = aFind.length = 1;
				aSettings.push({});
			}

			for (i=0,l=iCriteriaMax;i<l;i++) {
				var sFind = aFind[i]
					,oSettings = $.extend({}, $.tinysort.defaults, aSettings[i])
					// has find, attr or data
					,bFind = !(!sFind||sFind==='')
					// since jQuery's filter within each works on array index and not actual index we have to create the filter in advance
					,bFilter = bFind&&sFind[0]===':'
				;
				aCriteria.push({ // todo: only used locally, find a way to minify properties
					 sFind: sFind
					,oSettings: oSettings
					// has find, attr or data
					,bFind: bFind
					,bAttr: !(oSettings.attr===nll||oSettings.attr==='')
					,bData: oSettings.data!==nll
					// filter
					,bFilter: bFilter
					,$Filter: bFilter?oThis.filter(sFind):oThis
					,fnSort: oSettings.sortFunction
					,iAsc: oSettings.order=='asc'?1:-1
				});
			}
			//
			// prepare oElements for sorting
			oThis.each(function(i,el) {
				var $Elm = $(el)
					,mParent = $Elm.parent().get(0)
					,mFirstElmOrSub // we still need to distinguish between sortable and non-sortable elements (might have unexpected results for multiple criteria)
					,aSort = []
				;
				for (j=0;j<iCriteriaMax;j++) {
					var oPoint = aCriteria[j]
						// element or sub selection
						,mElmOrSub = oPoint.bFind?(oPoint.bFilter?oPoint.$Filter.filter(el):$Elm.find(oPoint.sFind)):$Elm;
					// text or attribute value
					aSort.push(oPoint.bData?mElmOrSub.data(oPoint.oSettings.data):(oPoint.bAttr?mElmOrSub.attr(oPoint.oSettings.attr):(oPoint.oSettings.useVal?mElmOrSub.val():mElmOrSub.text())));
					if (mFirstElmOrSub===undefined) mFirstElmOrSub = mElmOrSub;
				}
				// to sort or not to sort
				var iElmIndex = fnIndexOf.call(aElementsParent,mParent);
				if (iElmIndex<0) {
					iElmIndex = aElementsParent.push(mParent) - 1;
					aElements[iElmIndex] = {s:[],n:[]};	// s: sort, n: not sort
				}
				if (mFirstElmOrSub.length>0)	aElements[iElmIndex].s.push({s:aSort,e:$Elm,n:i}); // s:string/pointer, e:element, n:number
				else							aElements[iElmIndex].n.push({e:$Elm,n:i});
			});
			//
			// sort
			loop(aElements, function(oParent) { oParent.s.sort(fnSort); });
			//
			// order elements and fill new order
			loop(aElements, function(oParent) {
				var aSorted = oParent.s
                    ,aUnsorted = oParent.n
                    ,iSorted = aSorted.length
                    ,iUnsorted = aUnsorted.length
                    ,iNumElm = iSorted+iUnsorted
					,aOriginal = [] // list for original position
					,iLow = iNumElm
					,aCount = [0,0] // count how much we've sorted for retrieval from either the sort list or the non-sort list (oParent.s/oParent.n)
				;
				switch (oSettings.place) {
					case 'first':	loop(aSorted,function(obj) { iLow = mathmn(iLow,obj.n); }); break;
					case 'org':		loop(aSorted,function(obj) { aOriginal.push(obj.n); }); break;
					case 'end':		iLow = iUnsorted; break;
					default:		iLow = 0;
				}
				for (i=0;i<iNumElm;i++) {
					var bFromSortList = contains(aOriginal,i)?!fls:i>=iLow&&i<iLow+iSorted
                        ,iCountIndex = bFromSortList?0:1
						,mEl = (bFromSortList?aSorted:aUnsorted)[aCount[iCountIndex]].e;
					mEl.parent().append(mEl);
					if (bFromSortList||!oSettings.returns) aNewOrder.push(mEl.get(0));
					aCount[iCountIndex]++;
				}
			});
			oThis.length = 0;
			Array.prototype.push.apply(oThis,aNewOrder);

			return oThis;
		}
	});
	// toLowerCase // todo: dismantle, used only once
	function toLowerCase(s) {
		return s&&s.toLowerCase?s.toLowerCase():s;
	}
	// array contains
	function contains(a,n) {
		for (var i=0,l=a.length;i<l;i++) if (a[i]==n) return !fls;
		return fls;
	}
	// set functions
	$.fn.TinySort = $.fn.Tinysort = $.fn.tsort = $.fn.tinysort;
})(jQuery);