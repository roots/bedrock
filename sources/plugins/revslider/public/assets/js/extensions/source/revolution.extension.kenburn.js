/********************************************
 * REVOLUTION 5.0 EXTENSION - KEN BURN
 * @version: 1.1 (25.10.2016)
 * @requires jquery.themepunch.revolution.js
 * @author ThemePunch
*********************************************/

(function($) {
"use strict";
var _R = jQuery.fn.revolution,
	extension = {	alias:"KenBurns Min JS",
					name:"revolution.extensions.kenburn.min.js",
					min_core: "5.0",
					version:"1.1.0"
			  };

///////////////////////////////////////////
// 	EXTENDED FUNCTIONS AVAILABLE GLOBAL  //
///////////////////////////////////////////
jQuery.extend(true,_R, {

	stopKenBurn : function(l) {		
		if (_R.compare_version(extension).check==="stop") return false;

		if (l.data('kbtl')!=undefined)			
		l.data('kbtl').pause();				
	},

	startKenBurn :  function(l,opt,prgs) {		

		if (_R.compare_version(extension).check==="stop") return false;

		var d = l.data(),
			i = l.find('.defaultimg'),
			s = i.data('lazyload') || i.data('src'),
			i_a = d.owidth / d.oheight,
			cw = opt.sliderType==="carousel" ?  opt.carousel.slide_width : opt.ul.width(),
			ch = opt.ul.height(),
			c_a = cw / ch;

		
		if (l.data('kbtl'))
			l.data('kbtl').kill();
		

		prgs = prgs || 0;



		
		// NO KEN BURN IMAGE EXIST YET
		if (l.find('.tp-kbimg').length==0) {
			l.append('<div class="tp-kbimg-wrap" style="z-index:2;width:100%;height:100%;top:0px;left:0px;position:absolute;"><img class="tp-kbimg" src="'+s+'" style="position:absolute;" width="'+d.owidth+'" height="'+d.oheight+'"></div>');
			l.data('kenburn',l.find('.tp-kbimg'));
		}

		var getKBSides = function(w,h,f,cw,ch,ho,vo) {			
					var tw = w * f,
						th = h * f,
						hd = Math.abs(cw-tw),
						vd = Math.abs(ch-th),
						s = new Object();
					s.l = (0-ho)*hd;
					s.r = s.l + tw;			
					s.t = (0-vo)*vd;
					s.b = s.t + th;	
					s.h = ho;
					s.v = vo;
					return s;
				},

			getKBCorners = function(d,cw,ch,ofs,o) {

				var p = d.bgposition.split(" ") || "center center",
					ho = p[0] == "center"  ? "50%" : p[0] == "left" || p [1] == "left" ? "0%" : p[0]=="right" || p[1] =="right" ? "100%" : p[0],
					vo = p[1] == "center" ? "50%" : p[0] == "top" || p [1] == "top" ? "0%" : p[0]=="bottom" || p[1] =="bottom" ? "100%" : p[1];
				
				ho = parseInt(ho,0)/100 || 0;
				vo = parseInt(vo,0)/100 || 0;


				var sides = new Object();


				sides.start = getKBSides(o.start.width,o.start.height,o.start.scale,cw,ch,ho,vo);
				sides.end = getKBSides(o.start.width,o.start.height,o.end.scale,cw,ch,ho,vo);
							
				return sides;	
			},

			kcalcL = function(cw,ch,d) {				
				var f=d.scalestart/100,
					fe=d.scaleend/100,
					ofs = d.offsetstart != undefined ? d.offsetstart.split(" ") || [0,0] : [0,0],
					ofe = d.offsetend != undefined ? d.offsetend.split(" ") || [0,0] : [0,0];
				d.bgposition = d.bgposition == "center center" ? "50% 50%" : d.bgposition;
				
				
				var o = new Object(),
					sw = cw*f,
					sh = sw/d.owidth * d.oheight,
					ew = cw*fe,
					eh = ew/d.owidth * d.oheight;		


				
				o.start = new Object();		
				o.starto = new Object();
				o.end = new Object();
				o.endo = new Object();
				
				o.start.width = cw;
				o.start.height = o.start.width / d.owidth * d.oheight;		

				if (o.start.height<ch) {
					var newf = ch / o.start.height;
					o.start.height = ch;
					o.start.width = o.start.width*newf;
				}
				o.start.transformOrigin = d.bgposition;					
				o.start.scale = f;	
				o.end.scale = fe;

				o.start.rotation = d.rotatestart+"deg";
				o.end.rotation = d.rotateend+"deg";		
				
				// MAKE SURE THAT OFFSETS ARE NOT TOO HIGH
				var c = getKBCorners(d,cw,ch,ofs,o);


				ofs[0] = parseFloat(ofs[0]) + c.start.l;
				ofe[0] = parseFloat(ofe[0]) + c.end.l;
				
				ofs[1] = parseFloat(ofs[1]) + c.start.t;			
				ofe[1] = parseFloat(ofe[1]) + c.end.t;
					
				var iws = c.start.r - c.start.l,
					ihs	= c.start.b - c.start.t,
					iwe = c.end.r - c.end.l,
					ihe	= c.end.b - c.end.t;
						
				ofs[0] = ofs[0]>0 ? 0 : iws + ofs[0] < cw ? cw-iws : ofs[0];
				ofe[0] = ofe[0]>0 ? 0 : iwe + ofe[0] < cw ? cw-iwe : ofe[0];
				
				ofs[1] = ofs[1]>0 ? 0 : ihs + ofs[1] < ch ? ch-ihs : ofs[1];
				ofe[1] = ofe[1]>0 ? 0 : ihe + ofe[1] < ch ? ch-ihe : ofe[1];

				

				o.starto.x = ofs[0]+"px";
				o.starto.y = ofs[1]+"px";
				o.endo.x = ofe[0]+"px";
				o.endo.y = ofe[1]+"px";				
				o.end.ease = o.endo.ease = d.ease;
				o.end.force3D = o.endo.force3D = true;
				return o;
			};
		
		if (l.data('kbtl')!=undefined) {
			l.data('kbtl').kill();
			l.removeData('kbtl');
		}

		var k = l.data('kenburn'),
			kw = k.parent(),
			anim = kcalcL(cw,ch,d),
			kbtl =  new punchgs.TimelineLite();
		
		
		kbtl.pause();
		
		anim.start.transformOrigin = "0% 0%";
		anim.starto.transformOrigin = "0% 0%";	

		kbtl.add(punchgs.TweenLite.fromTo(k,d.duration/1000,anim.start,anim.end),0);
		kbtl.add(punchgs.TweenLite.fromTo(kw,d.duration/1000,anim.starto,anim.endo),0);
			
		kbtl.progress(prgs);
		kbtl.play();	
		
		l.data('kbtl',kbtl);														
	}		
});

})(jQuery);