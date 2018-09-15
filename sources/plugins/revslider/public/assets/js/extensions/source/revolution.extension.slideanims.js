/************************************************
 * REVOLUTION 5.2 EXTENSION - SLIDE ANIMATIONS
 * @version: 1.5 (25.10.2016)
 * @requires jquery.themepunch.revolution.js
 * @author ThemePunch
************************************************/

(function($) {
"use strict";
var _R = jQuery.fn.revolution,
	extension = {	alias:"SlideAnimations Min JS",
					name:"revolution.extensions.slideanims.min.js",
					min_core: "4.5",
					version:"1.5.0"
			  };

	///////////////////////////////////////////
	// 	EXTENDED FUNCTIONS AVAILABLE GLOBAL  //
	///////////////////////////////////////////
	jQuery.extend(true,_R, {
		
		animateSlide : function(nexttrans, comingtransition, container,   nextli, actli, nextsh, actsh,  mtl) {
			if (_R.compare_version(extension).check==="stop") return mtl;
			return animateSlideIntern(nexttrans, comingtransition, container,   nextli, actli, nextsh, actsh,  mtl)
		}
			
	});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////       SLIDE TRANSITION MODULES 		////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	


//////////////////////////////////////////////////////
//
// * Revolution Slider - TRANSITION PREDEFINITION MODULES
// * @version: 5.0.0 (13.02.2015)
// * @author ThemePunch
//
//////////////////////////////////////////////////////


	///////////////////////
	// PREPARE THE SLIDE //
	//////////////////////
	var prepareOneSlide = function(slotholder,opt,visible,vorh) {

				var sh=slotholder,
					img = sh.find('.defaultimg'),
					scalestart = sh.data('zoomstart'),
					rotatestart = sh.data('rotationstart');

				if (img.data('currotate')!=undefined)
					rotatestart = img.data('currotate');
				if (img.data('curscale')!=undefined && vorh=="box")
					scalestart = img.data('curscale')*100;
				else
				if (img.data('curscale')!=undefined)
					scalestart = img.data('curscale');
				
				_R.slotSize(img,opt);
				
				
				var src = img.attr('src'),
					bgcolor=img.css('backgroundColor'),
					w = opt.width,
					h = opt.height,
					fulloff = img.data("fxof"),
					fullyoff=0;

				if (opt.autoHeight=="on") h = opt.c.height();
				if (fulloff==undefined) fulloff=0;
			
				var off=0,
					bgfit = img.data('bgfit'),
					bgrepeat = img.data('bgrepeat'),
					bgposition = img.data('bgposition');

				if (bgfit==undefined) bgfit="cover";
				if (bgrepeat==undefined) bgrepeat="no-repeat";
				if (bgposition==undefined) bgposition="center center";
								
				
				switch (vorh) {
					// BOX ANIMATION PREPARING
					case "box":
						// SET THE MINIMAL SIZE OF A BOX
						//var  basicsize = 0,
						var x = 0,
							y = 0;

						/*if (opt.sloth>opt.slotw)
							basicsize=opt.sloth
						else
							basicsize=opt.slotw;
						
						opt.slotw = basicsize;
						opt.sloth = basicsize;*/
						
											
						for (var j=0;j<opt.slots;j++) {
							y=0;
							for (var i=0;i<opt.slots;i++) 	{

								sh.append('<div class="slot" '+
										  'style="position:absolute;'+
													'top:'+(fullyoff+y)+'px;'+
													'left:'+(fulloff+x)+'px;'+
													'width:'+opt.slotw+'px;'+
													'height:'+opt.sloth+'px;'+
													'overflow:hidden;">'+

										  '<div class="slotslide" data-x="'+x+'" data-y="'+y+'" '+
										  			'style="position:absolute;'+
													'top:'+(0)+'px;'+
													'left:'+(0)+'px;'+
													'width:'+opt.slotw+'px;'+
													'height:'+opt.sloth+'px;'+
													'overflow:hidden;">'+

										  '<div style="position:absolute;'+
													'top:'+(0-y)+'px;'+
													'left:'+(0-x)+'px;'+
													'width:'+w+'px;'+
													'height:'+h+'px;'+
													'background-color:'+bgcolor+';'+
													'background-image:url('+src+');'+
													'background-repeat:'+bgrepeat+';'+
													'background-size:'+bgfit+';background-position:'+bgposition+';">'+
										  '</div></div></div>');
								y=y+opt.sloth;
								if (scalestart!=undefined && rotatestart!=undefined)
										punchgs.TweenLite.set(sh.find('.slot').last(),{rotationZ:rotatestart});
							}
							x=x+opt.slotw;
						}
					break;

					// SLOT ANIMATION PREPARING
					case "vertical":
					case "horizontal":
						
						 if (vorh == "horizontal") {

							if (!visible) var off=0-opt.slotw;
							for (var i=0;i<opt.slots;i++) {
									sh.append('<div class="slot" style="position:absolute;'+
																	'top:'+(0+fullyoff)+'px;'+
																	'left:'+(fulloff+(i*opt.slotw))+'px;'+
																	'overflow:hidden;width:'+(opt.slotw+0.3)+'px;'+
																	'height:'+h+'px">'+
									'<div class="slotslide" style="position:absolute;'+
																	'top:0px;left:'+off+'px;'+
																	'width:'+(opt.slotw+0.6)+'px;'+
																	'height:'+h+'px;overflow:hidden;">'+
									'<div style="background-color:'+bgcolor+';'+
																	'position:absolute;top:0px;'+
																	'left:'+(0-(i*opt.slotw))+'px;'+
																	'width:'+w+'px;height:'+h+'px;'+
																	'background-image:url('+src+');'+
																	'background-repeat:'+bgrepeat+';'+
																	'background-size:'+bgfit+';background-position:'+bgposition+';">'+
									'</div></div></div>');
									if (scalestart!=undefined && rotatestart!=undefined)
										punchgs.TweenLite.set(sh.find('.slot').last(),{rotationZ:rotatestart});
									
							}
						} else {
							if (!visible) var off=0-opt.sloth;
							for (var i=0;i<opt.slots+2;i++) {
								sh.append('<div class="slot" style="position:absolute;'+
														 'top:'+(fullyoff+(i*opt.sloth))+'px;'+
														 'left:'+(fulloff)+'px;'+
														 'overflow:hidden;'+
														 'width:'+w+'px;'+
														 'height:'+(opt.sloth)+'px">'+

											 '<div class="slotslide" style="position:absolute;'+
																 'top:'+(off)+'px;'+
																 'left:0px;width:'+w+'px;'+
																 'height:'+opt.sloth+'px;'+
																 'overflow:hidden;">'+
											'<div style="background-color:'+bgcolor+';'+
																	'position:absolute;'+
																	'top:'+(0-(i*opt.sloth))+'px;'+
																	'left:0px;'+
																	'width:'+w+'px;height:'+h+'px;'+
																	'background-image:url('+src+');'+
																	'background-repeat:'+bgrepeat+';'+
																	'background-size:'+bgfit+';background-position:'+bgposition+';">'+

											'</div></div></div>');
									if (scalestart!=undefined && rotatestart!=undefined)
										punchgs.TweenLite.set(sh.find('.slot').last(),{rotationZ:rotatestart});
									
							}
						}
					break;
				}
		}



var getSliderTransitionParameters = function(container,comingtransition,nextsh,slidedirection) {
	
	
	/* Transition Name ,
	   Transition Code,
	   Transition Sub Code,
	   Max Slots,
	   MasterSpeed Delays,
	   Preparing Slots (box,slideh, slidev),
	   Call on nextsh (null = no, true/false for visibility first preparing),
	   Call on actsh (null = no, true/false for visibility first preparing),
	   Index of Animation
	   easeIn,
	   easeOut,
	   speed,
	   slots,
	*/


	var opt=container[0].opt,
		p1i = punchgs.Power1.easeIn, 
		p1o = punchgs.Power1.easeOut,
		p1io = punchgs.Power1.easeInOut,
		p2i = punchgs.Power2.easeIn,
		p2o = punchgs.Power2.easeOut,
		p2io = punchgs.Power2.easeInOut,
		p3i = punchgs.Power3.easeIn, 
		p3o = punchgs.Power3.easeOut, 
		p3io = punchgs.Power3.easeInOut,
		flatTransitions = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45],
		premiumTransitions = [16,17,18,19,20,21,22,23,24,25,27],
		nexttrans =0,
		specials = 1,
		STAindex = 0,
		indexcounter =0,
		STA = new Array,
		transitionsArray = [ ['boxslide' , 0, 1, 10, 0,'box',false,null,0,p1o,p1o,500,6],
							 ['boxfade', 1, 0, 10, 0,'box',false,null,1,p1io,p1io,700,5],
							 ['slotslide-horizontal', 2, 0, 0, 200,'horizontal',true,false,2,p2io,p2io,700,3],
							 ['slotslide-vertical', 3, 0,0,200,'vertical',true,false,3,p2io,p2io,700,3],
							 ['curtain-1', 4, 3,0,0,'horizontal',true,true,4,p1o,p1o,300,5],
							 ['curtain-2', 5, 3,0,0,'horizontal',true,true,5,p1o,p1o,300,5],
							 ['curtain-3', 6, 3,25,0,'horizontal',true,true,6,p1o,p1o,300,5],
							 ['slotzoom-horizontal', 7, 0,0,400,'horizontal',true,true,7,p1o,p1o,300,7],
							 ['slotzoom-vertical', 8, 0,0,0,'vertical',true,true,8,p2o,p2o,500,8],
							 ['slotfade-horizontal', 9, 0,0,1000,'horizontal',true,null,9,p2o,p2o,2000,10],
							 ['slotfade-vertical', 10, 0,0 ,1000,'vertical',true,null,10,p2o,p2o,2000,10],
							 ['fade', 11, 0, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['crossfade', 11, 1, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['fadethroughdark', 11, 2, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['fadethroughlight', 11, 3, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['fadethroughtransparent', 11, 4, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['slideleft', 12, 0,1,0,'horizontal',true,true,12,p3io,p3io,1000,1],
							 ['slideup', 13, 0,1,0,'horizontal',true,true,13,p3io,p3io,1000,1],
							 ['slidedown', 14, 0,1,0,'horizontal',true,true,14,p3io,p3io,1000,1],
							 ['slideright', 15, 0,1,0,'horizontal',true,true,15,p3io,p3io,1000,1],
							 ['slideoverleft', 12, 7,1,0,'horizontal',true,true,12,p3io,p3io,1000,1],
							 ['slideoverup', 13, 7,1,0,'horizontal',true,true,13,p3io,p3io,1000,1],
							 ['slideoverdown', 14, 7,1,0,'horizontal',true,true,14,p3io,p3io,1000,1],
							 ['slideoverright', 15, 7,1,0,'horizontal',true,true,15,p3io,p3io,1000,1],
							 ['slideremoveleft', 12, 8,1,0,'horizontal',true,true,12,p3io,p3io,1000,1],
							 ['slideremoveup', 13, 8,1,0,'horizontal',true,true,13,p3io,p3io,1000,1],
							 ['slideremovedown', 14, 8,1,0,'horizontal',true,true,14,p3io,p3io,1000,1],
							 ['slideremoveright', 15, 8,1,0,'horizontal',true,true,15,p3io,p3io,1000,1],
							 ['papercut', 16, 0,0,600,'',null,null,16,p3io,p3io,1000,2],
							 ['3dcurtain-horizontal', 17, 0,20,100,'vertical',false,true,17,p1io,p1io,500,7],
							 ['3dcurtain-vertical', 18, 0,10,100,'horizontal',false,true,18,p1io,p1io,500,5],
							 ['cubic', 19, 0,20,600,'horizontal',false,true,19,p3io,p3io,500,1],
							 ['cube',19,0,20,600,'horizontal',false,true,20,p3io,p3io,500,1],
							 ['flyin', 20, 0,4,600,'vertical',false,true,21,p3o,p3io,500,1],
							 ['turnoff', 21, 0,1,500,'horizontal',false,true,22,p3io,p3io,500,1],
							 ['incube', 22, 0,20,200,'horizontal',false,true,23,p2io,p2io,500,1],
							 ['cubic-horizontal', 23, 0,20,500,'vertical',false,true,24,p2o,p2o,500,1],
							 ['cube-horizontal', 23, 0,20,500,'vertical',false,true,25,p2o,p2o,500,1],
							 ['incube-horizontal', 24, 0,20,500,'vertical',false,true,26,p2io,p2io,500,1],
							 ['turnoff-vertical', 25, 0,1,200,'horizontal',false,true,27,p2io,p2io,500,1],
							 ['fadefromright', 14, 1,1,0,'horizontal',true,true,28,p2io,p2io,1000,1],
							 ['fadefromleft', 15, 1,1,0,'horizontal',true,true,29,p2io,p2io,1000,1],
							 ['fadefromtop', 14, 1,1,0,'horizontal',true,true,30,p2io,p2io,1000,1],
							 ['fadefrombottom', 13, 1,1,0,'horizontal',true,true,31,p2io,p2io,1000,1],
							 ['fadetoleftfadefromright', 12, 2,1,0,'horizontal',true,true,32,p2io,p2io,1000,1],
							 ['fadetorightfadefromleft', 15, 2,1,0,'horizontal',true,true,33,p2io,p2io,1000,1],
							 ['fadetobottomfadefromtop', 14, 2,1,0,'horizontal',true,true,34,p2io,p2io,1000,1],
							 ['fadetotopfadefrombottom', 13, 2,1,0,'horizontal',true,true,35,p2io,p2io,1000,1],							 
							 ['parallaxtoright', 15, 3,1,0,'horizontal',true,true,36,p2io,p2i,1500,1],
							 ['parallaxtoleft', 12, 3,1,0,'horizontal',true,true,37,p2io,p2i,1500,1],
							 ['parallaxtotop', 14, 3,1,0,'horizontal',true,true,38,p2io,p1i,1500,1],
							 ['parallaxtobottom', 13, 3,1,0,'horizontal',true,true,39,p2io,p1i,1500,1],
							 ['scaledownfromright', 12, 4,1,0,'horizontal',true,true,40,p2io,p2i,1000,1],
							 ['scaledownfromleft', 15, 4,1,0,'horizontal',true,true,41,p2io,p2i,1000,1],
							 ['scaledownfromtop', 14, 4,1,0,'horizontal',true,true,42,p2io,p2i,1000,1],
							 ['scaledownfrombottom', 13, 4,1,0,'horizontal',true,true,43,p2io,p2i,1000,1],
							 ['zoomout', 13, 5,1,0,'horizontal',true,true,44,p2io,p2i,1000,1],
							 ['zoomin', 13, 6,1,0,'horizontal',true,true,45,p2io,p2i,1000,1],
							 ['slidingoverlayup', 27, 0,1,0,'horizontal',true,true,47,p1io,p1o,2000,1],
							 ['slidingoverlaydown', 28, 0,1,0,'horizontal',true,true,48,p1io,p1o,2000,1],
							 ['slidingoverlayright', 30, 0,1,0,'horizontal',true,true,49,p1io,p1o,2000,1],
							 ['slidingoverlayleft', 29, 0,1,0,'horizontal',true,true,50,p1io,p1o,2000,1],
							 ['parallaxcirclesup', 31, 0,1,0,'horizontal',true,true,51,p2io,p1i,1500,1],
							 ['parallaxcirclesdown', 32, 0,1,0,'horizontal',true,true,52,p2io,p1i,1500,1],
							 ['parallaxcirclesright', 33, 0,1,0,'horizontal',true,true,53,p2io,p1i,1500,1],
							 ['parallaxcirclesleft', 34, 0,1,0,'horizontal',true,true,54,p2io,p1i,1500,1],
							 ['notransition',26,0,1,0,'horizontal',true,null,46,p2io,p2i,1000,1],
							 ['parallaxright', 15, 3,1,0,'horizontal',true,true,55,p2io,p2i,1500,1],
							 ['parallaxleft', 12, 3,1,0,'horizontal',true,true,56,p2io,p2i,1500,1],
							 ['parallaxup', 14, 3,1,0,'horizontal',true,true,57,p2io,p1i,1500,1],
							 ['parallaxdown', 13, 3,1,0,'horizontal',true,true,58,p2io,p1i,1500,1],							 
						   ];

	opt.duringslidechange = true;

	// INTERNAL TEST FOR TRANSITIONS
	opt.testanims = false;
	if (opt.testanims==true) {
		opt.nexttesttransform = opt.nexttesttransform === undefined ? 34 : opt.nexttesttransform + 1;
		opt.nexttesttransform = opt.nexttesttransform>70 ? 0 : opt.nexttesttransform;
		comingtransition = transitionsArray[opt.nexttesttransform][0];
		console.log(comingtransition+"  "+opt.nexttesttransform+"  "+transitionsArray[opt.nexttesttransform][1]+"  "+transitionsArray[opt.nexttesttransform][2]);
	}
		

	// CHECK AUTO DIRECTION FOR TRANSITION ARTS		
	jQuery.each(["parallaxcircles","slidingoverlay","slide","slideover","slideremove","parallax","parralaxto"],function(i,b) {	
	
		if (comingtransition==b+"horizontal")  comingtransition = slidedirection!=1 ? b+"left" : b+"right";			
		if (comingtransition==b+"vertical") comingtransition = slidedirection!=1 ? b+"up" : b+"down";			
	});					

		
		
	// RANDOM TRANSITIONS
	if (comingtransition == "random") {
		comingtransition = Math.round(Math.random()*transitionsArray.length-1);
		if (comingtransition>transitionsArray.length-1) comingtransition=transitionsArray.length-1;
	}

	// RANDOM FLAT TRANSITIONS
	if (comingtransition == "random-static") {
		comingtransition = Math.round(Math.random()*flatTransitions.length-1);
		if (comingtransition>flatTransitions.length-1) comingtransition=flatTransitions.length-1;
		comingtransition = flatTransitions[comingtransition];
	}

	// RANDOM PREMIUM TRANSITIONS
	if (comingtransition == "random-premium") {
		comingtransition = Math.round(Math.random()*premiumTransitions.length-1);
		if (comingtransition>premiumTransitions.length-1) comingtransition=premiumTransitions.length-1;
		comingtransition = premiumTransitions[comingtransition];
	}
	
	//joomla only change: avoid problematic transitions that don't compatible with mootools
	var problematicTransitions = [12,13,14,15,16,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45];
	if(opt.isJoomla == true && window.MooTools != undefined && problematicTransitions.indexOf(comingtransition) != -1){

		var newTransIndex = Math.round(Math.random() * (premiumTransitions.length-2) ) + 1;

		//some limits fix
		if (newTransIndex > premiumTransitions.length-1)
			newTransIndex = premiumTransitions.length-1;

		if(newTransIndex == 0)
			newTransIndex = 1;

		comingtransition = premiumTransitions[newTransIndex];
	}



	function findTransition() {
		// FIND THE RIGHT TRANSITION PARAMETERS HERE
		jQuery.each(transitionsArray,function(inde,trans) {
			if (trans[0] == comingtransition || trans[8] == comingtransition) {
				nexttrans = trans[1];
				specials = trans[2];
				STAindex = indexcounter;
			}
			indexcounter = indexcounter+1;
		})
	}

	findTransition();

	

	if (nexttrans>30) nexttrans = 30;
	if (nexttrans<0) nexttrans = 0;



	var obj = new Object();
	obj.nexttrans = nexttrans;
	obj.STA = transitionsArray[STAindex]; // PREPARED DEFAULT SETTINGS PER TRANSITION
	obj.specials = specials;	
	return obj;


}


/*************************************
	-	ANIMATE THE SLIDE  	-
*************************************/

var gSlideTransA = function(a,i) {
	if (i==undefined || jQuery.isNumeric(a)) return a;
	if (a==undefined) return a;
	return a.split(",")[i];
}

var animateSlideIntern = function(nexttrans, comingtransition, container, nextli, actli, nextsh, actsh,  mtl) {

	// GET THE TRANSITION
	
	var opt = container[0].opt,
		ai = actli.index(),
		ni = nextli.index(),
		slidedirection = ni<ai ? 1 : 0;

	if (opt.sc_indicator=="arrow") slidedirection = opt.sc_indicator_dir;			
			
	var stp = getSliderTransitionParameters(container,comingtransition,nextsh,slidedirection),
		STA = stp.STA,
		specials = stp.specials,					
		nexttrans = stp.nexttrans;

	//KEN BURNS ONLY WITH FADE TRANSITION
	if (nextsh.data('kenburns')=="on") //|| actsh.data('kenburns')=="on") 
		nexttrans = 11;


	// DEFINE THE MASTERSPEED FOR THE SLIDE //
	var ctid = nextli.data('nexttransid') || 0,
		masterspeed=gSlideTransA(nextli.data('masterspeed'),ctid);

	masterspeed = masterspeed==="default" ? STA[11] : masterspeed==="random" ? Math.round(Math.random()*1000+300) : masterspeed!=undefined ? parseInt(masterspeed,0) : STA[11];
	masterspeed = masterspeed > opt.delay ? opt.delay : masterspeed;

	// ADJUST MASTERSPEED
	masterspeed = masterspeed + STA[4];
	
	
	///////////////////////
	//	ADJUST SLOTS     //	
	///////////////////////
	opt.slots = gSlideTransA(nextli.data('slotamount'),ctid);	
	opt.slots = opt.slots==undefined || opt.slots=="default" ? STA[12] : opt.slots=="random" ? Math.round(Math.random()*12+4) : opt.slots;
	opt.slots = opt.slots < 1 ? comingtransition=="boxslide" ? Math.round(Math.random()*6+3) : comingtransition=="flyin" ? Math.round(Math.random()*4+1) : opt.slots : opt.slots;
	opt.slots = (nexttrans==4 || nexttrans==5 || nexttrans==6) && opt.slots<3 ? 3 : opt.slots;
	opt.slots = STA[3] != 0 ? Math.min(opt.slots,STA[3]) : opt.slots;
	opt.slots = nexttrans==9 ? opt.width/opt.slots : nexttrans==10 ? opt.height/opt.slots : opt.slots;
	

	/////////////////////////////////////////////
	//	SET THE ACTUAL AMOUNT OF SLIDES !!     //
	//  SET A RANDOM AMOUNT OF SLOTS          //
	///////////////////////////////////////////
	opt.rotate = gSlideTransA(nextli.data('rotate'),ctid);
	opt.rotate = opt.rotate==undefined || opt.rotate=="default" ? 0 : opt.rotate==999 || opt.rotate=="random" ? Math.round(Math.random()*360) : opt.rotate;
	opt.rotate = (!jQuery.support.transition  || opt.ie || opt.ie9) ? 0 : opt.rotate;
	
	

	
	
	// prepareOneSlide
	if (nexttrans!=11) {
		if (STA[7] !=null) prepareOneSlide(actsh,opt,STA[7],STA[5]);
		if (STA[6] !=null) prepareOneSlide(nextsh,opt,STA[6],STA[5]);
	}

	// DEFAULT SETTINGS FOR NEXT AND ACT SH
	mtl.add(punchgs.TweenLite.set(nextsh.find('.defaultvid'),{y:0,x:0,top:0,left:0,scale:1}),0);				
	mtl.add(punchgs.TweenLite.set(actsh.find('.defaultvid'),{y:0,x:0,top:0,left:0,scale:1}),0);				
	mtl.add(punchgs.TweenLite.set(nextsh.find('.defaultvid'),{y:"+0%",x:"+0%"}),0);				
	mtl.add(punchgs.TweenLite.set(actsh.find('.defaultvid'),{y:"+0%",x:"+0%"}),0);				
	mtl.add(punchgs.TweenLite.set(nextsh,{autoAlpha:1,y:"+0%",x:"+0%"}),0);				
	mtl.add(punchgs.TweenLite.set(actsh,{autoAlpha:1,y:"+0%",x:"+0%"}),0);	
	mtl.add(punchgs.TweenLite.set(nextsh.parent(),{backgroundColor:"transparent"}),0);				
	mtl.add(punchgs.TweenLite.set(actsh.parent(),{backgroundColor:"transparent"}),0);	
				
	

	var ei= gSlideTransA(nextli.data('easein'),ctid), 
		eo =gSlideTransA(nextli.data('easeout'),ctid); 

	ei = ei==="default" ? STA[9] || punchgs.Power2.easeInOut : ei || STA[9] || punchgs.Power2.easeInOut;
	eo = eo==="default" ? STA[10] || punchgs.Power2.easeInOut : eo || STA[10] || punchgs.Power2.easeInOut;


	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==0) {								// BOXSLIDE


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				var maxz = Math.ceil(opt.height/opt.sloth);
				var curz = 0;
				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);
					curz=curz+1;
					if (curz==maxz) curz=0;

					mtl.add(punchgs.TweenLite.from(ss,(masterspeed)/600,
										{opacity:0,top:(0-opt.sloth),left:(0-opt.slotw),rotation:opt.rotate,force3D:"auto",ease:ei}),((j*15) + ((curz)*30))/1500);
				});
	}
	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==1) {

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				var maxtime,
					maxj = 0;

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						rand=Math.random()*masterspeed+300,
						rand2=Math.random()*500+200;
					if (rand+rand2>maxtime) {
						maxtime = rand2+rand2;
						maxj = j;
					}
					mtl.add(punchgs.TweenLite.from(ss,rand/1000,
								{autoAlpha:0, force3D:"auto",rotation:opt.rotate,ease:ei}),rand2/1000);
				});
	}


	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==2) {

				var subtl = new punchgs.TimelineLite();
				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,{left:opt.slotw,ease:ei, force3D:"auto",rotation:(0-opt.rotate)}),0);
					mtl.add(subtl,0);
				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.from(ss,masterspeed/1000,{left:0-opt.slotw,ease:ei, force3D:"auto",rotation:opt.rotate}),0);
					mtl.add(subtl,0);
				});
	}



	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==3) {
				var subtl = new punchgs.TimelineLite();

				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,{top:opt.sloth,ease:ei,rotation:opt.rotate,force3D:"auto",transformPerspective:600}),0);
					mtl.add(subtl,0);

				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.from(ss,masterspeed/1000,{top:0-opt.sloth,rotation:opt.rotate,ease:eo,force3D:"auto",transformPerspective:600}),0);
					mtl.add(subtl,0);
				});
	}



	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==4 || nexttrans==5) {

				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				var cspeed = (masterspeed)/1000,
					ticker = cspeed,
					subtl = new punchgs.TimelineLite();

				actsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					var del = (i*cspeed)/opt.slots;
					if (nexttrans==5) del = ((opt.slots-i-1)*cspeed)/(opt.slots)/1.5;
					subtl.add(punchgs.TweenLite.to(ss,cspeed*3,{transformPerspective:600,force3D:"auto",top:0+opt.height,opacity:0.5,rotation:opt.rotate,ease:ei,delay:del}),0);
					mtl.add(subtl,0);
				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					var del = (i*cspeed)/opt.slots;
					if (nexttrans==5) del = ((opt.slots-i-1)*cspeed)/(opt.slots)/1.5;
					subtl.add(punchgs.TweenLite.from(ss,cspeed*3,
									{top:(0-opt.height),opacity:0.5,rotation:opt.rotate,force3D:"auto",ease:punchgs.eo,delay:del}),0);
					mtl.add(subtl,0);

				});


	}

	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==6) {


				if (opt.slots<2) opt.slots=2;
				if (opt.slots % 2) opt.slots = opt.slots+1;

				var subtl = new punchgs.TimelineLite();

				//SET DEFAULT IMG UNVISIBLE
				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);

				actsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					if (i+1<opt.slots/2)
						var tempo = (i+2)*90;
					else
						var tempo = (2+opt.slots-i)*90;

					subtl.add(punchgs.TweenLite.to(ss,(masterspeed+tempo)/1000,{top:0+opt.height,opacity:1,force3D:"auto",rotation:opt.rotate,ease:ei}),0);
					mtl.add(subtl,0);
				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);

					if (i+1<opt.slots/2)
						var tempo = (i+2)*90;
					else
						var tempo = (2+opt.slots-i)*90;

					subtl.add(punchgs.TweenLite.from(ss,(masterspeed+tempo)/1000,
											{top:(0-opt.height),opacity:1,force3D:"auto",rotation:opt.rotate,ease:eo}),0);
					mtl.add(subtl,0);
				});
	}


	////////////////////////////////////
	// THE SLOTSZOOM - TRANSITION II. //
	////////////////////////////////////
	if (nexttrans==7) {

				masterspeed = masterspeed *2;
				if (masterspeed>opt.delay) masterspeed=opt.delay;
				var subtl = new punchgs.TimelineLite();

				//SET DEFAULT IMG UNVISIBLE
				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);

				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this).find('div');
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,{
							left:(0-opt.slotw/2)+'px',
							top:(0-opt.height/2)+'px',
							width:(opt.slotw*2)+"px",
							height:(opt.height*2)+"px",
							opacity:0,
							rotation:opt.rotate,
							force3D:"auto",
							ease:ei}),0);
					mtl.add(subtl,0);

				});

				//////////////////////////////////////////////////////////////
				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT //
				///////////////////////////////////////////////////////////////
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this).find('div');

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
								{left:0,top:0,opacity:0,transformPerspective:600},
								{left:(0-i*opt.slotw)+'px',
								 ease:eo,
								 force3D:"auto",
							     top:(0)+'px',
							     width:opt.width,
							     height:opt.height,
								 opacity:1,rotation:0,
								 delay:0.1}),0);
					mtl.add(subtl,0);
				});
	}




	////////////////////////////////////
	// THE SLOTSZOOM - TRANSITION II. //
	////////////////////////////////////
	if (nexttrans==8) {

				masterspeed = masterspeed * 3;
				if (masterspeed>opt.delay) masterspeed=opt.delay;
				var subtl = new punchgs.TimelineLite();



				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this).find('div');
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,
								  {left:(0-opt.width/2)+'px',
								   top:(0-opt.sloth/2)+'px',
								   width:(opt.width*2)+"px",
								   height:(opt.sloth*2)+"px",
								   force3D:"auto",
								   ease:ei,
								   opacity:0,rotation:opt.rotate}),0);
					mtl.add(subtl,0);

				});


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT //
				///////////////////////////////////////////////////////////////
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this).find('div');

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
								  {left:0, top:0,opacity:0,force3D:"auto"},
								  {'left':(0)+'px',
								   'top':(0-i*opt.sloth)+'px',
								   'width':(nextsh.find('.defaultimg').data('neww'))+"px",
								   'height':(nextsh.find('.defaultimg').data('newh'))+"px",
								   opacity:1,
								   ease:eo,rotation:0,
								   }),0);
					mtl.add(subtl,0);
				});
	}


	////////////////////////////////////////
	// THE SLOTSFADE - TRANSITION III.   //
	//////////////////////////////////////
	if (nexttrans==9 || nexttrans==10) {
				var ssamount=0;
				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					ssamount++;
					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/2000,{autoAlpha:0,force3D:"auto",transformPerspective:600},
																		 {autoAlpha:1,ease:ei,delay:(i*opt.slots/100)/2000}),0);

				});
	}


	//////////////////////
	// SLIDING OVERLAYS //
	//////////////////////
				
	if (nexttrans==27||nexttrans==28||nexttrans==29||nexttrans==30) {
		
		var slot = nextsh.find('.slot'),		
			nd = nexttrans==27 || nexttrans==28 ? 1 : 2,
			mhp = nexttrans==27 || nexttrans==29 ? "-100%" : "+100%",
			php = nexttrans==27 || nexttrans==29 ? "+100%" : "-100%",
			mep = nexttrans==27 || nexttrans==29 ? "-80%" : "80%",
			pep = nexttrans==27 || nexttrans==29 ? "+80%" : "-80%",
			ptp = nexttrans==27 || nexttrans==29 ? "+10%" : "-10%",
			
			fa = {overwrite:"all"},
			ta = {autoAlpha:0,zIndex:1,force3D:"auto",ease:ei},
			
			fb = {position:"inherit",autoAlpha:0,overwrite:"all",zIndex:1},
			tb = {autoAlpha:1,force3D:"auto",ease:eo},
			
			fc = {overwrite:"all",zIndex:2,opacity:1,autoAlpha:1},
			tc = {autoAlpha:1,force3D:"auto",overwrite:"all",ease:ei},
			
			fd = {overwrite:"all",zIndex:2,autoAlpha:1},
			td = {autoAlpha:1,force3D:"auto",ease:ei},
			at = nd==1 ? "y" : "x";

		fa[at] = "0px";
		ta[at] = mhp;
		fb[at] = ptp;
		tb[at] = "0%";
		fc[at] = php;
		tc[at] = mhp;
		fd[at] = mep;  
		td[at] = pep;

	
		slot.append('<span style="background-color:rgba(0,0,0,0.6);width:100%;height:100%;position:absolute;top:0px;left:0px;display:block;z-index:2"></span>');
				
		mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/1000,fa,ta),0);						
		mtl.add(punchgs.TweenLite.fromTo(nextsh.find('.defaultimg'),masterspeed/2000,fb,tb),masterspeed/2000);				
		mtl.add(punchgs.TweenLite.fromTo(slot,masterspeed/1000,fc,tc),0);	
		mtl.add(punchgs.TweenLite.fromTo(slot.find('.slotslide div'),masterspeed/1000,fd,td),0);			
	}

	
	////////////////////////////////
	// PARALLAX CIRCLE TRANSITION //
	////////////////////////////////

	//nexttrans = 34;
	if (nexttrans==31||nexttrans==32||nexttrans==33||nexttrans==34) { // up , down, right ,left
		
		masterspeed = 6000;
		ei = punchgs.Power3.easeInOut;

		var ms = masterspeed / 1000;
			mas = ms - ms/5,
			_nt = nexttrans,
			fy = _nt == 31 ? "+100%" : _nt == 32 ? "-100%" : "0%",
			fx = _nt == 33 ? "+100%" : _nt == 34 ? "-100%" : "0%",
			ty = _nt == 31 ? "-100%" : _nt == 32 ? "+100%" : "0%",
			tx = _nt == 33 ? "-100%" : _nt == 34 ? "+100%" : "0%",
		
				
		mtl.add(punchgs.TweenLite.fromTo(actsh,ms-(ms*0.2),{y:0,x:0},{y:ty,x:tx,ease:eo}),ms*0.2);
		mtl.add(punchgs.TweenLite.fromTo(nextsh,ms,{y:fy, x:fx},{y:"0%",x:"0%",ease:ei}),0);
		//mtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:0}),0);border:1px solid #fff

		function moveCircles(cont,ms,_nt,dir,ei) {
			var slot = cont.find('.slot'),			
				pieces = 6,
				sizearray = [2,1.2,0.9,0.7,0.55,0.42],				
				sw = cont.width(),
				sh = cont.height(),
				di = sh>sw ? (sw*2) / pieces : (sh*2) / pieces;
			slot.wrap('<div class="slot-circle-wrapper" style="overflow:hidden;position:absolute;border:1px solid #fff"></div>');
			
			for (var i=0; i<pieces;i++) slot.parent().clone(false).appendTo(nextsh);	

			cont.find('.slot-circle-wrapper').each(function(i) {
				if (i<pieces) {
					var t = jQuery(this),
						s = t.find('.slot'),						

						nh = sw>sh ? sizearray[i]*sw : sizearray[i]*sh,
						nw =  nh,
						
						nl = 0 + (nw/2 - sw/2),
						nt = 0 + (nh/2 - sh/2),
						br = i!=0 ? "50%" : "0",						
						
						ftop = _nt == 31 ? sh/2 - nh/2 : _nt == 32 ? sh/2 - nh/2 : sh/2 - nh/2,
						fleft = _nt == 33 ? sw/2 - nw/2 : _nt == 34 ? sw - nw : sw/2 - nw/2,											
						fa = {scale:1,transformOrigo:"50% 50%",width:nw+"px",height:nh+"px",top:ftop+"px",left:fleft+"px",borderRadius:br},
						ta = {scale:1,top:sh/2 - nh/2,left:sw/2 - nw/2,ease:ei},
						
						fftop = _nt == 31 ? nt : _nt == 32 ? nt : nt,
						ffleft = _nt == 33 ? nl : _nt == 34 ? nl+(sw/2) : nl,
						fb = {width:sw,height:sh,autoAlpha:1,top:fftop+"px",position:"absolute",left:ffleft+"px"},
						tb = {top:nt+"px",left:nl+"px",ease:ei},
						
						speed = ms,
						delay = 0;
						
					
									
					
					mtl.add(punchgs.TweenLite.fromTo(t,speed,fa,ta),delay);
					mtl.add(punchgs.TweenLite.fromTo(s,speed,fb,tb),delay);				
					mtl.add(punchgs.TweenLite.fromTo(t,0.001,{autoAlpha:0},{autoAlpha:1}),0);
				}
			})				
		}

		nextsh.find('.slot').remove();
		nextsh.find('.defaultimg').clone().appendTo(nextsh).addClass("slot");
		moveCircles(nextsh, ms,_nt,"in",ei);
	//	moveCircles(actsh, mas,_nt,"out",eo);


		
		
		
				
		
	}

	/////////////////////////////
	// SIMPLE FADE ANIMATIONS //
	////////////////////////////
	if (nexttrans==11) {

			if (specials>4) specials = 0;
						
				var ssamount=0,
					bgcol = specials == 2 ? "#000000" : specials == 3 ? "#ffffff" : "transparent";
												
				switch (specials) {
					case 0: //FADE 						
						mtl.add(punchgs.TweenLite.fromTo(nextsh,masterspeed/1000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),0);																
					break;

					case 1: // CROSSFADE						
						mtl.add(punchgs.TweenLite.fromTo(nextsh,masterspeed/1000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),0);				
						mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/1000,{autoAlpha:1},{autoAlpha:0,force3D:"auto",ease:ei}),0);														
					break;
					
					case 2:
					case 3:
					case 4:
						mtl.add(punchgs.TweenLite.set(actsh.parent(),{backgroundColor:bgcol,force3D:"auto"}),0);
						mtl.add(punchgs.TweenLite.set(nextsh.parent(),{backgroundColor:"transparent",force3D:"auto"}),0);
						mtl.add(punchgs.TweenLite.to(actsh,masterspeed/2000,{autoAlpha:0,force3D:"auto",ease:ei}),0);
						mtl.add(punchgs.TweenLite.fromTo(nextsh,masterspeed/2000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),masterspeed/2000);																
					break;
					
				}

				mtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:1}),0);
				mtl.add(punchgs.TweenLite.set(actsh.find('defaultimg'),{autoAlpha:1}),0);	

				
    }

	if (nexttrans==26) {
				var ssamount=0;			
				masterspeed=0;	
				mtl.add(punchgs.TweenLite.fromTo(nextsh,masterspeed/1000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),0);				
				mtl.add(punchgs.TweenLite.to(actsh,masterspeed/1000,{autoAlpha:0,force3D:"auto",ease:ei}),0);				
				mtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:1}),0);
				mtl.add(punchgs.TweenLite.set(actsh.find('defaultimg'),{autoAlpha:1}),0);
	}



	if (nexttrans==12 || nexttrans==13 || nexttrans==14 || nexttrans==15) {
				masterspeed = masterspeed;
				if (masterspeed>opt.delay) masterspeed=opt.delay;
				//masterspeed = 1000;

				setTimeout(function() {
					punchgs.TweenLite.set(actsh.find('.defaultimg'),{autoAlpha:0});

				},100);

				var oow = opt.width,
					ooh = opt.height,
					ssn=nextsh.find('.slotslide, .defaultvid'),
					twx = 0,
					twy = 0,
					op = 1,
					scal = 1,
					fromscale = 1,					
					speedy = masterspeed/1000,
					speedy2 = speedy;


				if (opt.sliderLayout=="fullwidth" || opt.sliderLayout=="fullscreen") {
					oow=ssn.width();
					ooh=ssn.height();
				}



				if (nexttrans==12)
					twx = oow;
				else
				if (nexttrans==15)
					twx = 0-oow;
				else
				if (nexttrans==13)
					twy = ooh;
				else
				if (nexttrans==14)
					twy = 0-ooh;


				// DEPENDING ON EXTENDED SPECIALS, DIFFERENT SCALE AND OPACITY FUNCTIONS NEED TO BE ADDED
				if (specials == 1) op = 0;
				if (specials == 2) op = 0;
				if (specials == 3) speedy = masterspeed / 1300;				

				if (specials==4 || specials==5)
					scal=0.6;
				if (specials==6 )
					scal=1.4;


				if (specials==5 || specials==6) {
				    fromscale=1.4;
				    op=0;
				    oow=0;
				    ooh=0;twx=0;twy=0;
				 }
				if (specials==6) fromscale=0.6;
				var dd = 0;

				if (specials==7) {
					oow = 0;
					ooh = 0;
				}

				var inc = nextsh.find('.slotslide'),
					outc = actsh.find('.slotslide, .defaultvid');

				mtl.add(punchgs.TweenLite.set(actli,{zIndex:15}),0);
				mtl.add(punchgs.TweenLite.set(nextli,{zIndex:20}),0);

				if (specials==8) {
										
					mtl.add(punchgs.TweenLite.set(actli,{zIndex:20}),0);
					mtl.add(punchgs.TweenLite.set(nextli,{zIndex:15}),0);					
					mtl.add(punchgs.TweenLite.set(inc,{left:0, top:0, scale:1, opacity:1,rotation:0,ease:ei,force3D:"auto"}),0);
				} else {
					
					mtl.add(punchgs.TweenLite.from(inc,speedy,{left:twx, top:twy, scale:fromscale, opacity:op,rotation:opt.rotate,ease:ei,force3D:"auto"}),0);
				}
				
				if (specials==4 || specials==5) {
					oow = 0; ooh=0;
				}
				
				if (specials!=1)
					switch (nexttrans) {
						case 12:		
							
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'left':(0-oow)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
						case 15:
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'left':(oow)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
						case 13:						
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'top':(0-ooh)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
						case 14:
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'top':(ooh)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
					}
	}

	//////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XVI.  //
	//////////////////////////////////////
	if (nexttrans==16) {						// PAPERCUT


			var subtl = new punchgs.TimelineLite();
			mtl.add(punchgs.TweenLite.set(actli,{'position':'absolute','z-index':20}),0);
			mtl.add(punchgs.TweenLite.set(nextli,{'position':'absolute','z-index':15}),0);


			// PREPARE THE CUTS
			actli.wrapInner('<div class="tp-half-one" style="position:relative; width:100%;height:100%"></div>');

			actli.find('.tp-half-one').clone(true).appendTo(actli).addClass("tp-half-two");
			actli.find('.tp-half-two').removeClass('tp-half-one');

			var oow = opt.width,
				ooh = opt.height;
			if (opt.autoHeight=="on")
				ooh = container.height();


			actli.find('.tp-half-one .defaultimg').wrap('<div class="tp-papercut" style="width:'+oow+'px;height:'+ooh+'px;"></div>')
			actli.find('.tp-half-two .defaultimg').wrap('<div class="tp-papercut" style="width:'+oow+'px;height:'+ooh+'px;"></div>')
			actli.find('.tp-half-two .defaultimg').css({position:'absolute',top:'-50%'});
			actli.find('.tp-half-two .tp-caption').wrapAll('<div style="position:absolute;top:-50%;left:0px;"></div>');

			mtl.add(punchgs.TweenLite.set(actli.find('.tp-half-two'),
			                 {width:oow,height:ooh,overflow:'hidden',zIndex:15,position:'absolute',top:ooh/2,left:'0px',transformPerspective:600,transformOrigin:"center bottom"}),0);

			mtl.add(punchgs.TweenLite.set(actli.find('.tp-half-one'),
			                 {width:oow,height:ooh/2,overflow:'visible',zIndex:10,position:'absolute',top:'0px',left:'0px',transformPerspective:600,transformOrigin:"center top"}),0);

			// ANIMATE THE CUTS
			var img=actli.find('.defaultimg'),
				ro1=Math.round(Math.random()*20-10),
				ro2=Math.round(Math.random()*20-10),
				ro3=Math.round(Math.random()*20-10),
				xof = Math.random()*0.4-0.2,
				yof = Math.random()*0.4-0.2,
				sc1=Math.random()*1+1,
				sc2=Math.random()*1+1,
				sc3=Math.random()*0.3+0.3;

			mtl.add(punchgs.TweenLite.set(actli.find('.tp-half-one'),{overflow:'hidden'}),0);
			mtl.add(punchgs.TweenLite.fromTo(actli.find('.tp-half-one'),masterspeed/800,
			                 {width:oow,height:ooh/2,position:'absolute',top:'0px',left:'0px',force3D:"auto",transformOrigin:"center top"},
			                 {scale:sc1,rotation:ro1,y:(0-ooh-ooh/4),autoAlpha:0,ease:ei}),0);
			mtl.add(punchgs.TweenLite.fromTo(actli.find('.tp-half-two'),masterspeed/800,
			                 {width:oow,height:ooh,overflow:'hidden',position:'absolute',top:ooh/2,left:'0px',force3D:"auto",transformOrigin:"center bottom"},
			                 {scale:sc2,rotation:ro2,y:ooh+ooh/4,ease:ei,autoAlpha:0,onComplete:function() {
				                // CLEAN UP
								punchgs.TweenLite.set(actli,{'position':'absolute','z-index':15});
								punchgs.TweenLite.set(nextli,{'position':'absolute','z-index':20});
								if (actli.find('.tp-half-one').length>0)  {
									actli.find('.tp-half-one .defaultimg').unwrap();
									actli.find('.tp-half-one .slotholder').unwrap();
								}
								actli.find('.tp-half-two').remove();
			                 }}),0);

			subtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:1}),0);

			if (actli.html()!=null)
				mtl.add(punchgs.TweenLite.fromTo(nextli,(masterspeed-200)/1000,
												{scale:sc3,x:(opt.width/4)*xof, y:(ooh/4)*yof,rotation:ro3,force3D:"auto",transformOrigin:"center center",ease:eo},
												{autoAlpha:1,scale:1,x:0,y:0,rotation:0}),0);

			mtl.add(subtl,0);


	}

	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XVII.  //
	///////////////////////////////////////
	if (nexttrans==17) {								// 3D CURTAIN HORIZONTAL


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);

					mtl.add(punchgs.TweenLite.fromTo(ss,(masterspeed)/800,
									{opacity:0,rotationY:0,scale:0.9,rotationX:-110,force3D:"auto",transformPerspective:600,transformOrigin:"center center"},
									{opacity:1,top:0,left:0,scale:1,rotation:0,rotationX:0,force3D:"auto",rotationY:0,ease:ei,delay:j*0.06}),0);

				});
	}



	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XVIII.  //
	///////////////////////////////////////
	if (nexttrans==18) {								// 3D CURTAIN VERTICAL

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);

					mtl.add(punchgs.TweenLite.fromTo(ss,(masterspeed)/500,
									{autoAlpha:0,rotationY:110,scale:0.9,rotationX:10,force3D:"auto",transformPerspective:600,transformOrigin:"center center"},
									{autoAlpha:1,top:0,left:0,scale:1,rotation:0,rotationX:0,force3D:"auto",rotationY:0,ease:ei,delay:j*0.06}),0);
				});



	}


	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XIX.  //
	///////////////////////////////////////
	if (nexttrans==19 || nexttrans==22) {								// IN CUBE

				var subtl = new punchgs.TimelineLite();
				//SET DEFAULT IMG UNVISIBLE

				mtl.add(punchgs.TweenLite.set(actli,{zIndex:20}),0);
				mtl.add(punchgs.TweenLite.set(nextli,{zIndex:20}),0);
				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);
				var rot = 90,
					op = 1,
					torig ="center center ";

				if (slidedirection==1) rot = -90;

				if (nexttrans==19) {
					torig = torig+"-"+opt.height/2;
					op=0;

				} else {
					torig = torig+opt.height/2;
				}

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				punchgs.TweenLite.set(container,{transformStyle:"flat",backfaceVisibility:"hidden",transformPerspective:600});

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{transformStyle:"flat",backfaceVisibility:"hidden",left:0,rotationY:opt.rotate,z:10,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:torig,rotationX:rot},
									{left:0,rotationY:0,top:0,z:0, scale:1,force3D:"auto",rotationX:0, delay:(j*50)/1000,ease:ei}),0);
					subtl.add(punchgs.TweenLite.to(ss,0.1,{autoAlpha:1,delay:(j*50)/1000}),0);
					mtl.add(subtl);
				});

				actsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);
					var rot = -90;
					if (slidedirection==1) rot = 90;

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{transformStyle:"flat",backfaceVisibility:"hidden",autoAlpha:1,rotationY:0,top:0,z:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:torig, rotationX:0},
									{autoAlpha:1,rotationY:opt.rotate,top:0,z:10, scale:1,rotationX:rot, delay:(j*50)/1000,force3D:"auto",ease:eo}),0);

					mtl.add(subtl);					
				});
				mtl.add(punchgs.TweenLite.set(actli,{zIndex:18}),0);
	}




	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XX.  //
	///////////////////////////////////////
	if (nexttrans==20 ) {								// FLYIN


				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);
				
				if (slidedirection==1) {
				   var ofx = -opt.width
				   var rot  =80;
				   var torig = "20% 70% -"+opt.height/2;
				} else {
					var ofx = opt.width;
					var rot = -80;
					var torig = "80% 70% -"+opt.height/2;
				}


				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						d = (j*50)/1000;

					

					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{left:ofx,rotationX:40,z:-600, opacity:op,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:torig,transformStyle:"flat",rotationY:rot},
									{left:0,rotationX:0,opacity:1,top:0,z:0, scale:1,rotationY:0, delay:d,ease:ei}),0);
				

				});
				actsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						d = (j*50)/1000;
						d = j>0 ?  d + masterspeed/9000 : 0;

					if (slidedirection!=1) {
					   var ofx = -opt.width/2
					   var rot  =30;
					   var torig = "20% 70% -"+opt.height/2;
					} else {
						var ofx = opt.width/2;
						var rot = -30;
						var torig = "80% 70% -"+opt.height/2;
					}
					eo=punchgs.Power2.easeInOut;

					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{opacity:1,rotationX:0,top:0,z:0,scale:1,left:0, force3D:"auto",transformPerspective:600,transformOrigin:torig, transformStyle:"flat",rotationY:0},
									{opacity:1,rotationX:20,top:0, z:-600, left:ofx, force3D:"auto",rotationY:rot, delay:d,ease:eo}),0);
					
					
				});
	}

	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XX.  //
	///////////////////////////////////////
	if (nexttrans==21 || nexttrans==25) {								// TURNOFF


				//SET DEFAULT IMG UNVISIBLE

				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);
				var rot = 90,
					ofx = -opt.width,
					rot2 = -rot;

				if (slidedirection==1) {
				   if (nexttrans==25) {
				   	 var torig = "center top 0";
				   	 rot = opt.rotate;
				   } else {
				     var torig = "left center 0";
				     rot2 = opt.rotate;
				   }

				} else {
					ofx = opt.width;
					rot = -90;
					if (nexttrans==25) {
				   	 var torig = "center bottom 0"
				   	 rot2 = -rot;
				   	 rot = opt.rotate;
				   } else {
				     var torig = "right center 0";
				     rot2 = opt.rotate;
				   }
				}

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						ms2 = ((masterspeed/1.5)/3);


					mtl.add(punchgs.TweenLite.fromTo(ss,(ms2*2)/1000,
									{left:0,transformStyle:"flat",rotationX:rot2,z:0, autoAlpha:0,top:0,scale:1,force3D:"auto",transformPerspective:1200,transformOrigin:torig,rotationY:rot},
									{left:0,rotationX:0,top:0,z:0, autoAlpha:1,scale:1,rotationY:0,force3D:"auto",delay:ms2/1000, ease:ei}),0);
				});


				if (slidedirection!=1) {
				   	ofx = -opt.width
				   	rot  = 90;

				   if (nexttrans==25) {
				   	 torig = "center top 0"
				   	 rot2 = -rot;
				   	 rot = opt.rotate;
				   } else {
				     torig = "left center 0";
				     rot2 = opt.rotate;
				   }

				} else {
					ofx = opt.width;
					rot = -90;
					if (nexttrans==25) {
				   	 torig = "center bottom 0"
				   	 rot2 = -rot;
				   	 rot = opt.rotate;
				   } else {
				     torig = "right center 0";
				     rot2 = opt.rotate;
				   }
				}

				actsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);
					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{left:0,transformStyle:"flat",rotationX:0,z:0, autoAlpha:1,top:0,scale:1,force3D:"auto",transformPerspective:1200,transformOrigin:torig,rotationY:0},
									{left:0,rotationX:rot2,top:0,z:0,autoAlpha:1,force3D:"auto", scale:1,rotationY:rot,ease:eo}),0);
				});
	}



	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XX.  //
	///////////////////////////////////////
	if (nexttrans==23 || nexttrans == 24) {								// cube-horizontal - inboxhorizontal

		//SET DEFAULT IMG UNVISIBLE
		setTimeout(function() {
			actsh.find('.defaultimg').css({opacity:0});
		},100);
		var rot = -90,
			op = 1,
			opx=0;

		if (slidedirection==1) rot = 90;
		if (nexttrans==23) {
			var torig = "center center -"+opt.width/2;
			op=0;
		} else
			var torig = "center center "+opt.width/2;

		punchgs.TweenLite.set(container,{transformStyle:"preserve-3d",backfaceVisibility:"hidden",perspective:2500});
						nextsh.find('.slotslide').each(function(j) {
			var ss=jQuery(this);
			mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
							{left:opx,rotationX:opt.rotate,force3D:"auto",opacity:op,top:0,scale:1,transformPerspective:1200,transformOrigin:torig,rotationY:rot},
							{left:0,rotationX:0,autoAlpha:1,top:0,z:0, scale:1,rotationY:0, delay:(j*50)/500,ease:ei}),0);
		});

		rot = 90;
		if (slidedirection==1) rot = -90;

		actsh.find('.slotslide').each(function(j) {
			var ss=jQuery(this);
			mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
							{left:0,rotationX:0,top:0,z:0,scale:1,force3D:"auto",transformStyle:"flat",transformPerspective:1200,transformOrigin:torig, rotationY:0},
							{left:opx,rotationX:opt.rotate,top:0, scale:1,rotationY:rot, delay:(j*50)/500,ease:eo}),0);
			if (nexttrans==23) mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/2000,{autoAlpha:1},{autoAlpha:0,delay:(j*50)/500 + masterspeed/3000,ease:eo}),0);

		});
	}	
	

	return mtl;
}	

})(jQuery);