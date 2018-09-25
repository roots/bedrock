/*
 * FullScreen Background  v1.5
 *
 * Copyright 2013-2014, LambertGroup
 * 
 */

(function($) {

	function animate_singular_text(elem,current_obj,options) {
		if (options.responsive) {
			newCss='';
			if (elem.css('font-size').lastIndexOf('px')!=-1) {
				fontSize=elem.css('font-size').substr(0,elem.css('font-size').lastIndexOf('px'));
				newCss+='font-size:'+fontSize/(options.origWidth/options.width)+'px;';
			} else if (elem.css('font-size').lastIndexOf('em')!=-1) {
				fontSize=elem.css('font-size').substr(0,elem.css('font-size').lastIndexOf('em'));
				newCss+='font-size:'+fontSize/(options.origWidth/options.width)+'em;';
			}
			
			if (elem.css('line-height').lastIndexOf('px')!=-1) {
				lineHeight=elem.css('line-height').substr(0,elem.css('line-height').lastIndexOf('px'));
				newCss+='line-height:'+lineHeight/(options.origWidth/options.width)+'px;';
			} else if (elem.css('line-height').lastIndexOf('em')!=-1) {
				lineHeight=elem.css('line-height').substr(0,elem.css('line-height').lastIndexOf('em'));
				newCss+='line-height:'+lineHeight/(options.origWidth/options.width)+'em;';
			}
			
			elem.wrapInner('<div class="newFS" style="'+newCss+'" />');
			
		}

		var leftPos=elem.attr('data-final-left');
		var topPos=elem.attr('data-final-top');
		if (options.responsive) {
			leftPos=parseInt(leftPos/(options.origWidth/options.width),10);
			topPos=parseInt(topPos/(options.origWidth/options.width),10);
		}
  
        var opacity_aux=1;
		if (current_obj.isVideoPlaying==true)
		   opacity_aux=0;
        elem.animate({
                opacity: opacity_aux,
                left:leftPos+'px',
                top: topPos+'px'
              }, elem.attr('data-duration')*1000, function() {
                if (current_obj.isVideoPlaying==true) {
                   var alltexts = $(current_obj.currentImg.attr('data-text-id')).children();
				   alltexts.css("opacity",0);
		        }
              });			
	};
    
    
    
    
	function animate_texts(current_obj,options,fullscreen_background_the,bannerControls) {
		$(current_obj.currentImg.attr('data-text-id')).css("display","block");
		var thetexts = $(current_obj.currentImg.attr('data-text-id')).children();

		var i=0;
		currentText_arr=Array();
		thetexts.each(function() {
			currentText_arr[i] = $(this);
            
            
		  var theLeft=currentText_arr[i].attr('data-initial-left');
		  var theTop=currentText_arr[i].attr('data-initial-top');
		  if (options.responsive) {
				theLeft=parseInt(theLeft/(options.origWidth/options.width),10);
				theTop=parseInt(theTop/(options.origWidth/options.width),10);
		  }		  

			currentText_arr[i].css({
				"left":theLeft+"px",
				"top":theTop+"px",
				"opacity":parseInt(currentText_arr[i].attr('data-fade-start'),10)/100
			});
			
            
            var currentText=currentText_arr[i];
            setTimeout(function() { animate_singular_text(currentText,current_obj,options);}, (currentText_arr[i].attr('data-delay')*1000));    
            	
            i++;
        });		
	};
		
	
	function initialPositioning(cur_i,options, fullscreen_background_container,origImgsDimensions,imgs,current_obj) {
		var ver_ie=getInternetExplorerVersion();
		if (cur_i==-1)
			cur_i=0;
	
		var mycurImage=$(imgs[cur_i]);
		var cur_horizontalPosition=options.horizontalPosition;
	    if (mycurImage.attr('data-horizontalPosition')!=undefined && mycurImage.attr('data-horizontalPosition')!='') {
           cur_horizontalPosition=mycurImage.attr('data-horizontalPosition');
        }
		
		var cur_verticalPosition=options.verticalPosition;
	    if (mycurImage.attr('data-verticalPosition')!=undefined && mycurImage.attr('data-verticalPosition')!='') {
           cur_verticalPosition=mycurImage.attr('data-verticalPosition');
        }	
		
		

		var origDim=origImgsDimensions[cur_i].split(";");
		if (options.width100Proc && !options.height100Proc) {	
			origDim[0]=origDim[0]/(options.origWidth/options.width);
			origDim[1]=origDim[1]/(options.origWidth/options.width);
		}
		
		var newW=origDim[0];
		var newH=origDim[1];
		//alert ("a: "+origDim[0]+'  ---  '+origDim[1]);
		if (options.width100Proc && options.height100Proc && newW>1) {
			  newW=current_obj.winWidth;
			  newH=newW*origDim[1]/origDim[0];
			  if (newH<current_obj.winHeight) {
				  newH=current_obj.winHeight;
				  newW=newH*origDim[0]/origDim[1];
			  }	
			  origDim[0]=parseInt(newW,10);
			  origDim[1]=parseInt(newH,10);
			  //alert ('new: '+origDim[0]+'  ---  '+origDim[1]);
		}
		
		
		
		var imgCurInside = $('#contentHolderUnit_'+cur_i, fullscreen_background_container).find('img:first');
		/*var finalWidth=origDim[0];
		var finalHeight=origDim[1];*/
		
		/*imgCurInside.css({
			"width":origDim[0]+"px",
			"height":origDim[1]+"px"
		});*/


		var cur_left=0;
		switch(cur_horizontalPosition)
		{
		case 'left':
			cur_left=0;
			break;
		case 'center':
			cur_left=(options.width-origDim[0])/2;
			break;	
		case 'right':
			cur_left=options.width-origDim[0];
			break;				  
		default:
			cur_left=0;
		}	
		
		var cur_top=0;
		switch(cur_verticalPosition)
		{
		case 'top':
			cur_top=-2;
			break;
		case 'center':
			cur_top=(options.height-origDim[1])/2;
			break;			
		case 'bottom':
			cur_top=options.height-origDim[1]+2;
			break;
		default:
			cur_top=0;
		}
		
		
		//alert ("b: "+origDim[0]+' --- '+origDim[1]);
		imgCurInside.css({
			"width":origDim[0]+"px",
			"height":origDim[1]+"px",
			"margin-left":parseInt(cur_left,10)+"px",
			"margin-top":parseInt(cur_top,10)+"px",
			"opacity":options.initialOpacity
		});
		
		/*if (ver_ie==-1 || (ver_ie!=-1 && ver_ie>=10)) {
			imgCurInside.css({
				"-webkit-transform-origin":cur_horizontalPosition+" "+cur_verticalPosition,
				"-moz-transform-origin":cur_horizontalPosition+" "+cur_verticalPosition,
				"-o-transform-origin":cur_horizontalPosition+" "+cur_verticalPosition,
				"transform-origin":cur_horizontalPosition+" "+cur_verticalPosition
			});
			
		}*/


	}
	
	


	
	
	//circ
	function the_arc(current_obj,options) {
			nowx = (new Date).getTime();
			if (!current_obj.mouseOverBanner && options.showCircleTimer) {	 
				current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
  	            
                current_obj.ctx.beginPath();
                current_obj.ctx.globalAlpha=options.behindCircleAlpha/100;
                current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 2 * Math.PI, false);
                current_obj.ctx.lineWidth = options.circleLineWidth+2;
                current_obj.ctx.strokeStyle = options.behindCircleColor;
                current_obj.ctx.stroke();
                

                current_obj.ctx.beginPath();
                current_obj.ctx.globalAlpha=options.circleAlpha/100;
                current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, ((current_obj.timeElapsed+nowx)-current_obj.arcInitialTime)/1000*2/options.autoPlay*Math.PI,  false);
                current_obj.ctx.lineWidth = options.circleLineWidth;
                current_obj.ctx.strokeStyle = options.circleColor;
                current_obj.ctx.stroke();
             }
    }
	
	
	
    // navigation
	function fullscreen_background_navigation(direction,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb){
		var navigateAllowed=true;
		if ((!options.loop && current_obj.current_img_no+direction>=total_images) || (!options.loop && current_obj.current_img_no+direction<0) || total_images<2)
			navigateAllowed=false;				
		
		if (navigateAllowed && !current_obj.slideIsRunning) {
			current_obj.slideIsRunning=true;
	
			$('.newFS', fullscreen_background_container ).contents().unwrap();
			current_obj.arcInitialTime=(new Date).getTime();
			current_obj.timeElapsed=0;			
			if (options.showCircleTimer) {
					clearInterval(current_obj.intervalID);

					current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
					current_obj.ctx.beginPath();
					current_obj.ctx.globalAlpha=options.behindCircleAlpha/100;
					current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 2 * Math.PI, false);
					current_obj.ctx.lineWidth = options.circleLineWidth+2;
					current_obj.ctx.strokeStyle = options.behindCircleColor;
					current_obj.ctx.stroke();            
					
					
					current_obj.ctx.beginPath();
					current_obj.ctx.globalAlpha=options.circleAlpha/100;
					current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 0,  false);
					current_obj.ctx.lineWidth = options.circleLineWidth;
					current_obj.ctx.strokeStyle = options.circleColor;
					current_obj.ctx.stroke();	
							
					current_obj.intervalID=setInterval(function(){the_arc(current_obj,options)}, 125);
			}

		    if (!current_obj.bottomNavClicked) {
				current_obj.previous_current_img_no=current_obj.current_img_no;
			}
			current_obj.bottomNavClicked=false;

			$(current_obj.currentImg.attr('data-text-id')).css("display","none");
			
			
			//deactivate previous
			if (options.skin=="bullets") {
               $(bottomNavButs[current_obj.current_img_no]).removeClass('bottomNavButtonON');
            }
            //thumbs deactivate previous
            if (options.skin!="bullets") {
               //$(thumbsHolder_Thumbs[current_obj.current_img_no]).removeClass('thumbsHolder_ThumbON');
			   $(thumbsHolder_Thumbs[current_obj.current_img_no]).css({
				   'border-color':options.thumbsBorderColorOFF
			   });			   
			}

			fullscreen_background_playOver.css('display','none');
			
			
			//set current img
			if (current_obj.current_img_no+direction>=total_images) {
				current_obj.current_img_no=0;
			} else if (current_obj.current_img_no+direction<0) {
				current_obj.current_img_no=total_images-1;
			} else {
				current_obj.current_img_no+=direction;
			}
	
			if (options.skin=="bullets") {
			   $(bottomNavButs[current_obj.current_img_no]).addClass('bottomNavButtonON');
			}
			
			
			//thumbs activate current
			if (options.skin!="bullets") {
			   ///$(thumbsHolder_Thumbs[current_obj.current_img_no]).addClass('thumbsHolder_ThumbON');
			   $(thumbsHolder_Thumbs[current_obj.current_img_no]).css({
				   'border-color':options.thumbsBorderColorON
			   });
			   //auto scroll carousel if needed
			   currentCarouselLeft=fullscreen_background_thumbsHolder.css('left').substr(0,fullscreen_background_thumbsHolder.css('left').lastIndexOf('px'));
			   if (current_obj.current_img_no===0 || current_obj.current_img_no===total_images-1) {
				  carouselScroll(0,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,options,total_images,thumbsHolder_Thumb,current_obj);
			   } else {
				 carouselScroll(1001,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,options,total_images,thumbsHolder_Thumb,current_obj);
			  }
            }			

			
			if (options.fadeSlides) {
				$('#contentHolderUnit_'+current_obj.current_img_no, fullscreen_background_container).css({
					'opacity':1,
					'z-index':0,
					'display':'block'
				});
				$('#contentHolderUnit_'+current_obj.previous_current_img_no, fullscreen_background_container).css({
					'z-index':1,
					'display':'block'
				});				
				
				//alert ( $('#contentHolderUnit_'+current_obj.current_img_no, fullscreen_background_container).html() );
				$('#contentHolderUnit_'+current_obj.previous_current_img_no, fullscreen_background_container).animate({
					'opacity':0
				  }, 800, 'easeOutQuad', function() {
					// Animation complete.
					  current_obj.slideIsRunning=false;
					  if (options.fadeSlides) {
						$('#contentHolderUnit_'+current_obj.current_img_no, fullscreen_background_container).css({
							'z-index':1
						});		
						$('#contentHolderUnit_'+current_obj.previous_current_img_no, fullscreen_background_container).css({
							'z-index':0,
							'display':'none'
						});
					  }
					  current_obj.currentImg = $(imgs[current_obj.current_img_no]);
					  
					  if (current_obj.currentImg.attr('data-video')=='true')
						fullscreen_background_playOver.css('display','block');
	
					  //reinit content to stop videos
					  if ($(imgs[current_obj.previous_current_img_no]).attr('data-video')=='true') {
							$('#contentHolderUnit_'+current_obj.previous_current_img_no, fullscreen_background_container).html($(imgs[current_obj.previous_current_img_no]).html());
							initialPositioning(current_obj.previous_current_img_no,options, fullscreen_background_container,origImgsDimensions,imgs,current_obj);
					  }
					  
					  //reposition previous image
					  //initialPositioning(current_obj.previous_current_img_no,options, fullscreen_background_container,origImgsDimensions,imgs,current_obj);
	
					  animate_texts(current_obj,options,fullscreen_background_the,bannerControls);
						
					  if (options.autoPlay>0 && total_images>1 && !current_obj.mouseOverBanner) {
						  clearTimeout(current_obj.timeoutID);
						  current_obj.timeoutID=setTimeout(function(){ fullscreen_background_navigation(1,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb)},options.autoPlay*1000);
					  }
				});			
			} else {
				fullscreen_background_contentHolder.animate({
					'left':+(-1)*current_obj.current_img_no*options.width+'px'
				  }, 800, 'easeOutQuad', function() {
					// Animation complete.
					  current_obj.slideIsRunning=false;
					  current_obj.currentImg = $(imgs[current_obj.current_img_no]);
					  
					  if (current_obj.currentImg.attr('data-video')=='true')
						fullscreen_background_playOver.css('display','block');
	
					  //reinit content to stop videos
					  if ($(imgs[current_obj.previous_current_img_no]).attr('data-video')=='true') {
							$('#contentHolderUnit_'+current_obj.previous_current_img_no, fullscreen_background_container).html($(imgs[current_obj.previous_current_img_no]).html());
							initialPositioning(current_obj.previous_current_img_no,options, fullscreen_background_container,origImgsDimensions,imgs,current_obj);
					  }
					  
					  //reposition previous image
					  //initialPositioning(current_obj.previous_current_img_no,options, fullscreen_background_container,origImgsDimensions,imgs,current_obj);
	
					  animate_texts(current_obj,options,fullscreen_background_the,bannerControls);
						
					  if (options.autoPlay>0 && total_images>1 && !current_obj.mouseOverBanner) {
						  clearTimeout(current_obj.timeoutID);
						  current_obj.timeoutID=setTimeout(function(){ fullscreen_background_navigation(1,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb)},options.autoPlay*1000);
					  }						  
				});
			}
			
			var newver_ie=getInternetExplorerVersion();
			if (newver_ie!=-1 && options.texturePath) { //is IE and I have a texture
				$('.texture_over_image', fullscreen_background_container).css('display','block');
			}

			
		} // if navigateAllowed
		
	};
	






    function carouselScroll(direction,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,options,total_images,thumbsHolder_Thumb,current_obj) {
		currentCarouselLeft=fullscreen_background_thumbsHolder.css('left').substr(0,fullscreen_background_thumbsHolder.css('left').lastIndexOf('px'));
		if (direction===1 || direction===-1) {
			current_obj.isCarouselScrolling=true;
			fullscreen_background_thumbsHolder.css('opacity','0.5');
			fullscreen_background_thumbsHolder.animate({
			    opacity: 1,
			    left: '+='+direction*current_obj.carouselStep
			  }, 500, 'easeOutCubic', function() {
			      // Animation complete.
				  disableCarouselNav(current_obj,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,options,total_images,thumbsHolder_Thumb);						  
				  current_obj.isCarouselScrolling=false;
			});				
		} else {
				if ( currentCarouselLeft != (-1) * Math.floor( current_obj.current_img_no/options.numberOfThumbsPerScreen )*current_obj.carouselStep) {
					current_obj.isCarouselScrolling=true;
					fullscreen_background_thumbsHolder.css('opacity','0.5');
					fullscreen_background_thumbsHolder.animate({
					    opacity: 1,
					    left: (-1) * Math.floor( current_obj.current_img_no/options.numberOfThumbsPerScreen )*current_obj.carouselStep
					  }, 500, 'easeOutCubic', function() {
					      // Animation complete.
						  disableCarouselNav(current_obj,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,options,total_images,thumbsHolder_Thumb);						  
						  current_obj.isCarouselScrolling=false;
					});
				}
		}
	
		
	};
	
	function disableCarouselNav(current_obj,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,options,total_images,thumbsHolder_Thumb) {
		currentCarouselLeft=fullscreen_background_thumbsHolder.css('left').substr(0,fullscreen_background_thumbsHolder.css('left').lastIndexOf('px'));
		if (currentCarouselLeft <0 ) {
			if (fullscreen_background_carouselLeftNav.hasClass('carouselLeftNavDisabled'))
				fullscreen_background_carouselLeftNav.removeClass('carouselLeftNavDisabled');
		} else {
			fullscreen_background_carouselLeftNav.addClass('carouselLeftNavDisabled');
		}		
		
		if (Math.abs(currentCarouselLeft-current_obj.carouselStep)<((2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width())+current_obj.thumbMarginLeft)*total_images) {
			if (fullscreen_background_carouselRightNav.hasClass('carouselRightNavDisabled'))
				fullscreen_background_carouselRightNav.removeClass('carouselRightNavDisabled');
		} else {
			fullscreen_background_carouselRightNav.addClass('carouselRightNavDisabled');
		}				
	};




			function rearangethumbs(current_obj,options,total_images,fullscreen_background_container,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb,fullscreen_background_thumbsHolderVisibleWrapper,fullscreen_background_thumbsHolderWrapper) {
						//thumbs
						
						if (options.skin!="bullets") {
							fullscreen_background_thumbsHolderWrapper.css({
								"top":options.height+"px",
								"margin-top":parseInt(options.thumbsWrapperMarginTop/(options.origWidth/options.width),10)+"px",
								"height":parseInt(options.origthumbsHolderWrapperH/(options.origWidth/options.width),10)+"px"
							});

							bgTopCorrection=0;

							fullscreen_background_carouselLeftNav.css('background-position','0px '+((fullscreen_background_thumbsHolderWrapper.height()-options.origthumbsHolderWrapperH)/2+bgTopCorrection)+'px');
							fullscreen_background_carouselRightNav.css('background-position','0px '+((fullscreen_background_thumbsHolderWrapper.height()-options.origthumbsHolderWrapperH)/2+bgTopCorrection)+'px');
							
							fullscreen_background_thumbsHolderVisibleWrapper.css('width',options.width-fullscreen_background_carouselLeftNav.width()-fullscreen_background_carouselRightNav.width());
							options.origWidthThumbsHolderVisibleWrapper=options.origWidth-fullscreen_background_carouselLeftNav.width()-fullscreen_background_carouselRightNav.width()	;				
							

							thumbsHolder_Thumbs.css({
								'width':parseInt(options.origThumbW/(options.origWidthThumbsHolderVisibleWrapper/fullscreen_background_thumbsHolderVisibleWrapper.width()),10)+'px',
								'height':parseInt(options.origThumbH/(options.origWidthThumbsHolderVisibleWrapper/fullscreen_background_thumbsHolderVisibleWrapper.width()),10)+'px'
	
							});
							
							

							
							var imageInside = $('.thumbsHolder_ThumbOFF', fullscreen_background_container).find('img:first');

							imageInside.css({
								"width":thumbsHolder_Thumbs.width()+"px",
								"height":thumbsHolder_Thumbs.height()+"px"/*,
								"margin-top":parseInt((fullscreen_background_thumbsHolderWrapper.height()-thumbsHolder_Thumbs.height())/2,10)+"px"*/
							});
							
							
							
							current_obj.thumbMarginLeft=Math.floor( (fullscreen_background_thumbsHolderWrapper.width()-fullscreen_background_carouselLeftNav.width()-fullscreen_background_carouselRightNav.width()-(2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width())*options.numberOfThumbsPerScreen)/(options.numberOfThumbsPerScreen-1) );
							thumb_i=-1;
							fullscreen_background_thumbsHolder.children().each(function() {
								thumb_i++;
								theThumb = $(this);
								//theThumb.css('background-position','center '+(options.origWidth/options.width)+'px');
								if ( thumb_i<=0 ) {
									theThumb.css('margin-left',Math.floor( ( fullscreen_background_thumbsHolderWrapper.width()-fullscreen_background_carouselLeftNav.width()-fullscreen_background_carouselRightNav.width()-(current_obj.thumbMarginLeft+(2*current_obj.thumbBorderWidth+theThumb.width()))*(options.numberOfThumbsPerScreen-1) - (2*current_obj.thumbBorderWidth+theThumb.width()) )/2 )+'px');
								} else {
									theThumb.css('margin-left',current_obj.thumbMarginLeft+'px');		
								}
							});

							//alert (thumbsHolder_Thumb.width());
							current_obj.carouselStep=((2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width())+current_obj.thumbMarginLeft)*options.numberOfThumbsPerScreen;

						}	
						
						if (options.numberOfThumbsPerScreen >= total_images) {
							switch(options.bottomNavPos) {
								case 'left':
								  fullscreen_background_thumbsHolderVisibleWrapper.css('left',options.bottomNavLateralMargin+current_obj.thumbMarginLeft+'px');
								  break;
								case 'right':
								  fullscreen_background_thumbsHolderVisibleWrapper.css('left',(options.width-((2*current_obj.thumbBorderWidth+thumbsHolder_Thumbs.width()+current_obj.thumbMarginLeft)*total_images))-options.bottomNavLateralMargin+'px');
								  break;
								default:
								  fullscreen_background_thumbsHolderVisibleWrapper.css('left',parseInt((fullscreen_background_thumbsHolderWrapper.width() - ((2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width())+current_obj.thumbMarginLeft)*total_images)/2,10)+'px');
							}
						}
									
			}



			function resizeVideoBg(current_obj,options,imgs,fullscreen_background_container) {
				  var cur_videoProportionWidth=options.videoProportionWidth;  //ex:16 from 16/9
				  var cur_videoProportionHeight = options.videoProportionHeight;
				  var cur_videoProportionHeight=9;
				  if ($(imgs[current_obj.current_img_no]).attr('data-videoProportionWidth')!=undefined && $(imgs[current_obj.current_img_no]).attr('data-videoProportionWidth')!='')
					  cur_videoProportionWidth=$(imgs[current_obj.current_img_no]).attr('data-videoProportionWidth');
					  
				  //alert (cur_videoProportionWidth);
				  
				  var idealVideoWidth = 1280; // youtube videos have 1280x720 = 16/9
				  var ratioUnit = idealVideoWidth / cur_videoProportionWidth;
				  var idealVideoHeight = parseInt(ratioUnit*cur_videoProportionHeight,10);
				  
				  /*var new_VideoWidth=idealVideoWidth;
				  var new_VideoHeight=idealVideoHeight;*/

				  windowW = $(window).width()+1;
				  windowH = $(window).height();
				  var scaleFact = 1/(idealVideoWidth/windowW);
				  if ((idealVideoHeight/windowH) < (idealVideoWidth/windowW)) {
					  scaleFact = 1/(idealVideoHeight/windowH);
				  }
				  if (cur_videoProportionWidth!=16)
					  scaleFact+=0.11;/**/
				  
				  /*//alert(scaleFact);
				  if (current_obj.haveYouTube) {
					  $('.lbg_player',fullscreen_background_container).css({
						  'width': (idealVideoWidth*scaleFact)+'px',
						  'height': (idealVideoHeight*scaleFact)+'px',
						  'left': parseInt(((windowW-idealVideoWidth*scaleFact) / 2),10)+'px',
						  'top': parseInt(((windowH-idealVideoHeight*scaleFact) / 2),10)+'px'
					  });
				  }
				  if (current_obj.haveVimeo) {
					  $('.lbg_vimeo_player',fullscreen_background_container).css({
						  'width': (idealVideoWidth*scaleFact)+'px',
						  'height': (idealVideoHeight*scaleFact)+'px',
						  'left': parseInt(((windowW-idealVideoWidth*scaleFact) / 2),10)+'px',
						  'top': parseInt(((windowH-idealVideoHeight*scaleFact) / 2),10)+'px'
					  });
				  }	
				  
				  if (current_obj.haveSelfHosted) {
					 $('#'+current_obj.html5_video_id).css({		
						  'width': (idealVideoWidth*scaleFact)+'px',
						  'height': (idealVideoHeight*scaleFact)+'px',
						  'left': parseInt(((windowW-idealVideoWidth*scaleFact) / 2),10)+'px',
						  'top': parseInt(((windowH-idealVideoHeight*scaleFact) / 2),10)+'px'
					  });
				  }			*/
				  	
					//alert ( idealVideoWidth+' -- '+scaleFact+' -- '+(idealVideoWidth*scaleFact) );
					//alert ( idealVideoHeight+' -- '+scaleFact+' -- '+(idealVideoHeight*scaleFact) );
				  		  		
					 $('iframe',fullscreen_background_container).css({		
						  'width': (idealVideoWidth*scaleFact)+'px',
						  'height': (idealVideoHeight*scaleFact)+'px',
						  'left': parseInt(((windowW-idealVideoWidth*scaleFact) / 2),10)+'px',
						  'top': parseInt(((windowH-idealVideoHeight*scaleFact) / 2),10)+'px'
					  });	  
			}





			function doResize(current_obj,options,total_images,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolderVisibleWrapper,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,bottomNavButs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb,fullscreen_background_leftNav,bottomNavBut,fullscreen_background_bottomNav,fullscreen_background_thumbsHolderVisibleWrapper,fullscreen_background_thumbsHolderWrapper,bottomNavWidth) {
					//alert (options.setAsBg);
					if (options.width100Proc && options.height100Proc && !options.setAsBg) {
						var bodyOverflow_initial=$('body').css('overflow');
						$('body').css('overflow','hidden');
					}
					current_obj.winWidth=$(window).width();
					current_obj.winHeight=$(window).height();	
					var newTextLeft=0;
					
					/*responsiveWidth=fullscreen_background_the.parent().parent().width();
					responsiveHeight=fullscreen_background_the.parent().parent().height();*/
					if (options.enableTouchScreen && options.fadeSlides) {
						responsiveWidth=fullscreen_background_the.parent().parent().parent().width();
						responsiveHeight=fullscreen_background_the.parent().parent().parent().height();
					} else {
						responsiveWidth=fullscreen_background_the.parent().parent().width();
						responsiveHeight=fullscreen_background_the.parent().parent().height();						
					}					
					
					
					
					if (options.responsiveRelativeToBrowser) {
						responsiveWidth=$(window).width();
						responsiveHeight=$(window).height();
					}
					

					if (options.width100Proc) {
						options.width=responsiveWidth;
					}
					
					if (options.height100Proc) {
						options.height=responsiveHeight;
					}

					if (options.origWidth!=responsiveWidth || options.width100Proc) {
						if (options.origWidth>responsiveWidth || options.width100Proc) {
							options.width=responsiveWidth;
						} else if (!options.width100Proc) {
							options.width=options.origWidth;
						}
						if (!options.height100Proc)
							options.height=options.width/current_obj.bannerRatio;
							
						/*if (options.enableTouchScreen && options.responsive && options.fadeSlides)
							options.width-=1;*/				

						
						//set banner size
						fullscreen_background_container.width(options.width);
						fullscreen_background_container.height(options.height);
						
						fullscreen_background_contentHolderVisibleWrapper.width(options.width);
						fullscreen_background_contentHolderVisibleWrapper.height(options.height);
						
						fullscreen_background_contentHolder.width(options.width);
						fullscreen_background_contentHolder.height(options.height);
						
						bannerControls.css('margin-top',parseInt((options.height-fullscreen_background_leftNav.height())/2,10)+'px');

						
						contentHolderUnit = $('.contentHolderUnit', fullscreen_background_container);
						contentHolderUnit.width(options.width);
						contentHolderUnit.height(options.height);
						
						if (options.enableTouchScreen && options.fadeSlides) {
							fullscreen_background_container.parent().width(options.width+1);
							fullscreen_background_container.parent().height(options.height);
						}						

						holderWidth=options.width*total_images;
						for (i=0; i<total_images; i++) {
							initialPositioning(i,options, fullscreen_background_container,origImgsDimensions,imgs,current_obj);
							if (options.fadeSlides) {
								newTextLeft=0;
							} else {
								newTextLeft=parseInt(i*options.width,10);
							}
							//reposition text
							$($(imgs[i]).attr('data-text-id')).css({
								'width':fullscreen_background_the.width()+'px',
								'left':newTextLeft,
								'top':bannerControls.css('top')
							});
													
						}

						
	
						fullscreen_background_contentHolder.width(holderWidth);

						if (options.skin=="bullets") {
							switch(options.bottomNavPos) {
								case 'left':
									fullscreen_background_bottomNav.css({
										"left":options.bottomNavLateralMargin+'px',
										"top":options.height+"px"
									});
								  break;
								case 'right':
									fullscreen_background_bottomNav.css({
										"left":parseInt(fullscreen_background_container.width()-bottomNavWidth,10)-options.bottomNavLateralMargin+'px',
										"top":options.height+"px"
									});	
								  break;
								default:
									fullscreen_background_bottomNav.css({
										"left":parseInt((fullscreen_background_container.width()-bottomNavWidth)/2,10)+'px',
										"top":options.height+"px"
									})
							}
							if (options.width100Proc && options.height100Proc) {
								// nothing
							} else {
								fullscreen_background_bottomNav.css('margin-top',parseInt(options.thumbsWrapperMarginTop/(options.origWidth/options.width),10)+'px');
							}
						} else {
							rearangethumbs(current_obj,options,total_images,fullscreen_background_container,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb,fullscreen_background_thumbsHolderVisibleWrapper,fullscreen_background_thumbsHolderWrapper);
						}

		 
						//playover
						fullscreen_background_playOver.css({
							'left':parseInt((options.width-fullscreen_background_playOver.width())/2,10)+'px',
							'top':parseInt((options.height-fullscreen_background_playOver.height())/2,10)+'px'
						});
	

						
						if(total_images>=2) {
							clearTimeout(current_obj.timeoutID);
							fullscreen_background_navigation(1,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb);	 
	
						} else {
							$('.newFS', fullscreen_background_container ).contents().unwrap();
							$(current_obj.currentImg.attr('data-text-id')).css("display","none");
							//fullscreen_background_playOver.css('display','none');
							animate_texts(current_obj,options,fullscreen_background_the,bannerControls);						
						}
						
						if (options.width100Proc && options.height100Proc && options.setAsBg) {
								resizeVideoBg(current_obj,options,imgs,fullscreen_background_container);
						}						
						
					}
					
					if (options.width100Proc && options.height100Proc && !options.setAsBg) {
						$('body').css('overflow',bodyOverflow_initial);
					}
			}	
			
			
			
			function getInternetExplorerVersion()
			// -1 - not IE
			// 7,8,9 etc
			{
			   var rv = -1; // Return value assumes failure.
			   if (navigator.appName == 'Microsoft Internet Explorer')
			   {
				  var ua = navigator.userAgent;
				  var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
				  if (re.exec(ua) != null)
					 rv = parseFloat( RegExp.$1 );
			   }
			   return parseInt(rv,10);
			}
			
			function isImg(the_str) {
				var res=false;
				var last4=the_str.substr(the_str.length - 4).toLowerCase();
				if (last4=='.jpg' || last4=='.png' || last4=='.gif') {
					res=true;
				}
				return res;
			}							


	
	$.fn.fullscreen_background = function(options) {

		var options = $.extend({},$.fn.fullscreen_background.defaults, options);

		return this.each(function() {
			var fullscreen_background_the = $(this);
					responsiveWidth=fullscreen_background_the.parent().width();
					responsiveHeight=fullscreen_background_the.parent().height();
					if (options.responsiveRelativeToBrowser) {
						responsiveWidth=$(window).width();
						responsiveHeight=$(window).height();
					}			
					options.origWidth=options.width;
					if (!options.fadeSlides)
						options.origWidth-=1;
					if (options.width100Proc)
						options.width=responsiveWidth;
					
					options.origHeight=options.height;
					if (options.height100Proc) {
						options.height=responsiveHeight;
					}
						
					if (options.responsive && (options.origWidth!=responsiveWidth || options.width100Proc)) {
						if (options.origWidth>responsiveWidth || options.width100Proc) {
							options.width=responsiveWidth;
						} else {
							options.width=options.origWidth;
						}
						if (!options.height100Proc)
							options.height=options.width/(options.origWidth/options.origHeight);	
					}
					
					if (options.enableTouchScreen && options.responsive && options.fadeSlides) {
						options.width-=1;
					}

				
			
			//the controllers
			var fullscreen_background_wrap = $('<div></div>').addClass('fullscreen_background').addClass(options.skin);
			var bannerControlsDef = $('<div class="bannerControls">   <div class="leftNav"></div>   <div class="rightNav"></div>      </div>  <div class="contentHolderVisibleWrapper"><div class="contentHolder"></div></div>   <div class="playOver"></div>  <div class="thumbsHolderWrapper"><div class="thumbsHolderVisibleWrapper"><div class="thumbsHolder"></div></div></div> <canvas class="mycanvas"></canvas>');
			fullscreen_background_the.wrap(fullscreen_background_wrap);
			if (options.texturePath) {
				fullscreen_background_the.append('<div class="texture_over_image" />');
				$('.texture_over_image', fullscreen_background_container).css({
					'background':"url("+options.texturePath+")"
				});	

			}	

			fullscreen_background_the.after(bannerControlsDef);
			

			
			//the elements
			var fullscreen_background_container = fullscreen_background_the.parent('.fullscreen_background');
			if (options.setAsBg) {
				fullscreen_background_container.wrap('<div class="setAsBg" />');
			}
			var bannerControls = $('.bannerControls', fullscreen_background_container);
			
			
			var fullscreen_background_contentHolderVisibleWrapper = $('.contentHolderVisibleWrapper', fullscreen_background_container);
			var fullscreen_background_contentHolder = $('.contentHolder', fullscreen_background_container);			
			
			
			var bottomNav_aux=$('<div class="bottomNav"></div>');
			
			fullscreen_background_the.after(bottomNav_aux);
			 
			if (!options.showAllControllers)
				bannerControls.css("display","none");			
			

			
			
			var fullscreen_background_leftNav = $('.leftNav', fullscreen_background_container);
			var fullscreen_background_rightNav = $('.rightNav', fullscreen_background_container);
			fullscreen_background_leftNav.css("display","none");
			fullscreen_background_rightNav.css("display","none");			
			if (options.showNavArrows) {
				if (options.showOnInitNavArrows) {
					fullscreen_background_leftNav.css("display","block");
					fullscreen_background_rightNav.css("display","block");
				}
			}
			
			var fullscreen_background_bottomNav = $('.bottomNav', fullscreen_background_container);
			var fullscreen_background_bottomOverThumb;
			if (options.skin=="bullets") {
				fullscreen_background_bottomNav.css({
					"display":"block",
					"top":options.height+"px"
				});
				if (options.width100Proc && options.height100Proc) {
					fullscreen_background_bottomNav.css("margin-top",options.thumbsWrapperMarginTop+'px');
				} else {
					fullscreen_background_bottomNav.css("margin-top",options.thumbsWrapperMarginTop/(options.origWidth/options.width)+'px');
				}
			}
			
			if (!options.showBottomNav) {
				fullscreen_background_bottomNav.css("display","none");
			}
			if (!options.showOnInitBottomNav) {
				fullscreen_background_bottomNav.css("left","-5000px");
			}
			



            //thumbs
			var fullscreen_background_thumbsHolderWrapper = $('.thumbsHolderWrapper', fullscreen_background_container);
            var fullscreen_background_thumbsHolderVisibleWrapper = $('.thumbsHolderVisibleWrapper', fullscreen_background_container);
			var fullscreen_background_thumbsHolder = $('.thumbsHolder', fullscreen_background_container);
			
			var fullscreen_background_carouselLeftNav;
			var fullscreen_background_carouselRightNav;
			fullscreen_background_carouselLeftNav=$('<div class="carouselLeftNav"></div>');
			fullscreen_background_carouselRightNav=$('<div class="carouselRightNav"></div>');
			fullscreen_background_thumbsHolderWrapper.append(fullscreen_background_carouselLeftNav);
			fullscreen_background_thumbsHolderWrapper.append(fullscreen_background_carouselRightNav);
			fullscreen_background_carouselRightNav.css('right','0');
			
			fullscreen_background_thumbsHolder.css('width',fullscreen_background_carouselLeftNav.width()+'px');
			
			if (!options.showBottomNav || !options.showOnInitBottomNav) {
				fullscreen_background_thumbsHolderWrapper.css({
					"opacity":0,
					"display":"none"
				});
			}
				
				
			if (options.skin!="bullets") {
					fullscreen_background_thumbsHolderWrapper.css('margin-top',parseInt(options.thumbsWrapperMarginTop/(options.origWidth/options.width),10)+'px');
			}
			
			var ver_ie=getInternetExplorerVersion();
			
			if (ver_ie!=-1 && options.texturePath) { //is IE and I have a texture
				$('.texture_over_image', fullscreen_background_container).click(function() {
					var mynewcurImg=$(imgs[current_obj.current_img_no]);
					if (mynewcurImg.attr('data-link')!=undefined && mynewcurImg.attr('data-link')!='') {
						var newcur_target=options.target;
						
						if (mynewcurImg.attr('data-target')!=undefined && mynewcurImg.attr('data-target')!=''){
							newcur_target=mynewcurImg.attr('data-target');
						}
						
						if (newcur_target=="_blank")
							window.open(mynewcurImg.attr('data-link'));
						else
							window.location = mynewcurImg.attr('data-link');
					} else {
						if (mynewcurImg.attr('data-video')=='true') {
								fullscreen_background_playOver.click();
						}
					}
				});
			}

			
			
			if (options.enableTouchScreen) {
				if (options.fadeSlides) {
					var randomNo=Math.floor(Math.random()*100000);
					
					fullscreen_background_container.wrap('<div id="fullbgParent_'+randomNo+'" style="position:relative;" />');
					$('#fullbgParent_'+randomNo).width(options.width+1);
					$('#fullbgParent_'+randomNo).height(options.height);	
				}
				
				
				if (ver_ie!=-1 && ver_ie==9 && options.fadeSlides && options.skin=="bullets") {
					//nothing
				} else {	
					//fullscreen_background_contentHolder.css('cursor','url('+options.absUrl+'skins/hand.cur),url('+options.absUrl+'skins/hand.cur),move');
					//fullscreen_background_container.css('cursor','url('+options.absUrl+'skins/hand.cur),url('+options.absUrl+'skins/hand.cur),move');
				}
				fullscreen_background_contentHolder.css('left','0');
				if (options.fadeSlides) {
					if (ver_ie!=-1 && ver_ie==9 && options.fadeSlides && options.skin=="bullets") {
						//nothing
					} else {
							fullscreen_background_container.draggable({ 
								axis: 'x',
								containment: "parent",
								/*revert: true,
								distance:10,*/
								start: function(event, ui) {
									origLeft=$(this).css('left');
									fullscreen_background_playOver.css('display','none');
								},
								stop: function(event, ui) {
									if (!current_obj.slideIsRunning) {
										finalLeft=$(this).css('left');
										direction=1;
										if (origLeft<finalLeft) {
											direction=-1;
										}
										//alert (direction+' -- '+origLeft+ ' < '+finalLeft);
										$(this).css('left','0px');
										fullscreen_background_navigation(direction,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb);
									}
								}
							});
					}
				} else  {
						fullscreen_background_contentHolder.draggable({ 
							axis: 'x',
							distance:10,
							start: function(event, ui) {
								origLeft=parseInt($(this).css('left'),10);
								fullscreen_background_playOver.css('display','none');
							},
							stop: function(event, ui) {
								if (!current_obj.slideIsRunning) {
									finalLeft=parseInt($(this).css('left'),10);
									direction=1;
									if (origLeft<finalLeft) {
										direction=-1;
									}	
									fullscreen_background_navigation(direction,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb);
								}
							}
						});					
				}
		
			}
			
			
			
			
			//the vars
			var fullscreen_background_playOver=$('.playOver', fullscreen_background_container);
			fullscreen_background_playOver.css({
				'left':parseInt((options.width-fullscreen_background_playOver.width())/2,10)+'px',
				'top':parseInt((options.height-fullscreen_background_playOver.height())/2,10)+'px'
			});

			var current_obj = {
					current_img_no:0,
					currentImg:0,
					previous_current_img_no:0,
					slideIsRunning:false,
					mouseOverBanner:false,
					isVideoPlaying:false,
					bottomNavClicked:false,
					current_imgInside:'',
					windowWidth:0,
					carouselStep:0,
					thumbBorderWidth:0,
					thumbMarginLeft:0,
					timeoutID:'',
					intervalID:'',
					arcInitialTime:(new Date).getTime(),
					timeElapsed:0,
					canvas:'',
					ctx:'',
					bannerRatio:options.origWidth/options.origHeight,
					msiInterval:'',
					msiInitialTime:(new Date).getTime(),
					winWidth:0,
					winHeight:0
				};
			current_obj.winWidth=$(window).width();
			current_obj.winHeight=$(window).height();	
							
			current_obj.canvas = $('.mycanvas', fullscreen_background_container)[0];
			current_obj.canvas.width=2*options.circleRadius+4*options.circleLineWidth;
			current_obj.canvas.height=2*options.circleRadius+4*options.circleLineWidth;				
			
			
			if (ver_ie!=-1 && ver_ie<9) {
			   options.showCircleTimer=false;
			}
			if (options.showCircleTimer) {				
				current_obj.ctx = current_obj.canvas.getContext('2d');
			}
 				
			var origImgsDimensions=new Array();

			
			var previousBottomHovered=0;
			var i = 0;

			
			//set banner size
			fullscreen_background_container.width(options.width);
			fullscreen_background_container.height(options.height);
			
			fullscreen_background_contentHolderVisibleWrapper.width(options.width);
			fullscreen_background_contentHolderVisibleWrapper.height(options.height);
			
			fullscreen_background_contentHolder.width(options.width);
			fullscreen_background_contentHolder.height(options.height);

			bannerControls.css('margin-top',parseInt((options.height-fullscreen_background_leftNav.height())/2,10)+'px');
			


			
			//get images
			var theul=fullscreen_background_the.find('ul:first');
			
			var total_images=0;
			var imgs = theul.children();
			var content_HolderUnit;
			var holderWidth=0;
			var bottomNavBut;
			var bottomNavWidth=0;
			var bottomNavMarginTop=0;
			var imgInside;
			var thumbsHolder_Thumb;
			var thumbsHolder_MarginTop=0;
			var myopacity=0;
			var newTextLeft=0;
			imgs.each(function() {
	            current_obj.currentImg = $(this);
	            if(!current_obj.currentImg.is('li')){
	            	current_obj.currentImg = current_obj.currentImg.find('li:first');
	            }

	            	
	            if(current_obj.currentImg.is('li')){
	            	total_images++;
					myzindex=0;
					mydisplay='none';
					if (total_images==1) {
						myzindex=1;
						mydisplay='block';
					}
	            	content_HolderUnit = $('<div class="contentHolderUnit" rel="'+ (total_images-1) +'" id="contentHolderUnit_'+ (total_images-1) +'">'+current_obj.currentImg.html()+'</div>');
					if (imgs.length<=1) {
						current_obj.currentImg.html('');
					}
					if (options.fadeSlides) {
						content_HolderUnit.css({
							'position':'absolute',
							'top':0,
							'left':0,
							'z-index':myzindex,
							'display':mydisplay
						});
					} else {
						content_HolderUnit.css({
							'position':'relative',
							'float':'left'
						});
					}
	            	content_HolderUnit.width(options.width);
	            	content_HolderUnit.height(options.height);
	            	fullscreen_background_contentHolder.append(content_HolderUnit);
	            	holderWidth=holderWidth+options.width;
	            	
	            	current_obj.current_img_no=total_images-1;
	            	imgInside = $('#contentHolderUnit_'+current_obj.current_img_no, fullscreen_background_container).find('img:first');
	            	origImgsDimensions[total_images-1]=imgInside.width()+';'+imgInside.height();
	            	initialPositioning((total_images-1),options, fullscreen_background_container,origImgsDimensions,imgs,current_obj);
	            	
		            //generate bottomNav
		            if (options.skin=="bullets") {
		                       bottomNavBut = $('<div class="bottomNavButtonOFF" rel="'+ (total_images-1) +'"></div>');
		                       fullscreen_background_bottomNav.append(bottomNavBut);
		            
		            
		                       bottomNavWidth+=parseInt(bottomNavBut.css('padding-left').substring(0, bottomNavBut.css('padding-left').length-2),10)+bottomNavBut.width();
                               bottomNavMarginTop=parseInt((fullscreen_background_bottomNav.height()-parseInt(bottomNavBut.css('height').substring(0, bottomNavBut.css('height').length-2)))/2,10);
                               bottomNavBut.css('margin-top',bottomNavMarginTop+'px');
							   
                   }
                   

		            //thumbs generate thumbsHolder
              if (options.skin!="bullets") {
					image_name=$(imgs[total_images-1]).attr('data-bottom-thumb');
					thumbsHolder_Thumb = $('<div class="thumbsHolder_ThumbOFF" rel="'+ (total_images-1) +'"><img src="'+ image_name + '"></div>');
		            fullscreen_background_thumbsHolder.append(thumbsHolder_Thumb);
		            if (options.origThumbW==0) {

					   	if (options.numberOfThumbsPerScreen==0) {
							options.numberOfThumbsPerScreen=Math.floor((options.origWidth-fullscreen_background_carouselLeftNav.width()-fullscreen_background_carouselRightNav.width())/(2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width()))-1;
						}
						options.origThumbW=thumbsHolder_Thumb.width();
						options.origThumbH=thumbsHolder_Thumb.height();
						options.origthumbsHolderWrapperH=fullscreen_background_thumbsHolderWrapper.height();
						current_obj.thumbBorderWidth=thumbsHolder_Thumb.css('borderLeftWidth').substr(0,thumbsHolder_Thumb.css('borderLeftWidth').lastIndexOf('px'))
						//alert (current_obj.thumbBorderWidth);
						current_obj.thumbMarginLeft=Math.floor( (options.origWidth-fullscreen_background_carouselLeftNav.width()-fullscreen_background_carouselRightNav.width()-(2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width())*options.numberOfThumbsPerScreen)/(options.numberOfThumbsPerScreen-1) );
                    }


		            fullscreen_background_thumbsHolder.css('width',fullscreen_background_thumbsHolder.width()+current_obj.thumbMarginLeft+(2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width())+'px');
	            
		            thumbsHolder_MarginTop=parseInt((fullscreen_background_thumbsHolderWrapper.height()-parseInt(thumbsHolder_Thumb.css('height').substring(0, thumbsHolder_Thumb.css('height').length-2)))/2,10);

                }
           
                   
                   
		            
		            if (options.fadeSlides) {
						newTextLeft=0;
					} else {
						newTextLeft=parseInt((total_images-1)*options.width,10);
					}
					fullscreen_background_contentHolder.append($(current_obj.currentImg.attr('data-text-id')));
					$(current_obj.currentImg.attr('data-text-id')).css({
						'width':fullscreen_background_the.width()+'px',
						'left':newTextLeft,
						'top':bannerControls.css('top')
					});
					
	            }	            

	        });		
			
			if (total_images<=1) {
				options.autoPlay=0;
				options.showNavArrows=false;
				options.showOnInitNavArrows=false;
				options.showBottomNav=false;
				options.showOnInitBottomNav=false;
				
				fullscreen_background_leftNav.css("display","none");
				fullscreen_background_rightNav.css("display","none");			
				fullscreen_background_bottomNav.css("display","none");
			}
			
			//thumbsWrapper background
			var bg_aux=options.thumbsWrapperBg;
			if (isImg(options.thumbsWrapperBg)) {
				bg_aux="url("+options.thumbsWrapperBg+")";
			}	
			fullscreen_background_thumbsHolderWrapper.css({
				'background':bg_aux
			});		
						
			fullscreen_background_contentHolder.width(holderWidth);
			
			fullscreen_background_bottomNav.width(bottomNavWidth);
			if (options.showOnInitBottomNav) {
				
				//fullscreen_background_bottomNav.css("left",parseInt((fullscreen_background_container.width()-bottomNavWidth)/2,10)+'px');
				switch(options.bottomNavPos) {
					case 'left':
						fullscreen_background_bottomNav.css("left",options.bottomNavLateralMargin+'px');
					  break;
					case 'right':
					  fullscreen_background_bottomNav.css("left",parseInt(fullscreen_background_container.width()-bottomNavWidth,10)-options.bottomNavLateralMargin+'px');;
					  break;
					default:
						fullscreen_background_bottomNav.css("left",parseInt((fullscreen_background_container.width()-bottomNavWidth)/2,10)+'px');
				}
			}	
			

			//thumbs
        if (options.skin!="bullets") {
			fullscreen_background_thumbsHolderVisibleWrapper.css({
				'width':(options.origWidth-fullscreen_background_carouselLeftNav.width()-fullscreen_background_carouselRightNav.width()),
				'left':fullscreen_background_carouselLeftNav.width()+'px'
			});
			
			
			current_obj.carouselStep=((2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width())+current_obj.thumbMarginLeft)*options.numberOfThumbsPerScreen;
			//disable left nav
			fullscreen_background_carouselLeftNav.addClass('carouselLeftNavDisabled');
			
			//disable right nav and center thumbs
			if (options.numberOfThumbsPerScreen >= total_images) {
				fullscreen_background_carouselRightNav.addClass('carouselRightNavDisabled');
				fullscreen_background_carouselLeftNav.css('display','none');
				fullscreen_background_carouselRightNav.css('display','none');
				fullscreen_background_thumbsHolderVisibleWrapper.css('left',parseInt((fullscreen_background_thumbsHolderWrapper.width() - ((2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width())+current_obj.thumbMarginLeft)*total_images)/2,10)+'px');
			}
			
			fullscreen_background_thumbsHolderWrapper.css("top",options.height+'px');
		    

			var img_inside = $('.thumbsHolder_ThumbOFF', fullscreen_background_container).find('img:first');
			//img_inside.css("margin-top",thumbsHolder_MarginTop+"px");
			options.origthumbsHolder_MarginTop=thumbsHolder_MarginTop;

         }

		var thumbsHolder_Thumbs=$('.thumbsHolder_ThumbOFF', fullscreen_background_container);
		thumbsHolder_Thumbs.css({
		   'border-color':options.thumbsBorderColorOFF
		});
		rearangethumbs(current_obj,options,total_images,fullscreen_background_container,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb,fullscreen_background_thumbsHolderVisibleWrapper,fullscreen_background_thumbsHolderWrapper);		 
			
			//for youtube iframes
			$("iframe", fullscreen_background_container).each(function(){
			      var ifr_source = $(this).attr('src');
				  var wmode = "?wmode=transparent";
				  if ( ifr_source.indexOf('?')!=-1 )
				  	wmode = "&wmode=transparent";
			      $(this).attr('src',ifr_source+wmode);
			});
			
			
			
			
	        //initialize first number image
			current_obj.current_img_no=0;
 			if (options.fadeSlides) {
				  $('#contentHolderUnit_'+current_obj.current_img_no, fullscreen_background_container).css({
					  'z-index':1
				  });
			}			
			
	        
	        
			current_obj.currentImg = $(imgs[0]);
			var firstImg=fullscreen_background_container.find('img:first');

			if (firstImg[0].complete) {
				$('.myloader', fullscreen_background_container).css('display','none');
				animate_texts(current_obj,options,fullscreen_background_the,bannerControls);						 
			} else {
			firstImg.load(function() {
				$('.myloader', fullscreen_background_container).css('display','none');
				animate_texts(current_obj,options,fullscreen_background_the,bannerControls);			  
			});
			}

			

			
			//pause on hover
			fullscreen_background_container.mouseenter(function() {
               	if (options.pauseOnMouseOver) {	
					current_obj.mouseOverBanner=true;
					clearTimeout(current_obj.timeoutID);
					nowx = (new Date).getTime();
					current_obj.timeElapsed=current_obj.timeElapsed+(nowx-current_obj.arcInitialTime);
				}
				
				
				if (options.autoHideNavArrows && options.showNavArrows) {
					fullscreen_background_leftNav.css("display","block");
					fullscreen_background_rightNav.css("display","block");
				}
                if (options.autoHideBottomNav && options.showBottomNav) {
				    if (options.skin=="bullets") {
					   fullscreen_background_bottomNav.css({
						   "display":"block"/*,
						   "left":parseInt((fullscreen_background_container.width()-bottomNavWidth)/2,10)+"px"*/
					   });
                     } else {
						 	if (options.thumbsWrapperMarginTop<0 && current_obj.isVideoPlaying) {
                       			//nothing
							} else {
								if (options.showBottomNav) {
									fullscreen_background_thumbsHolderWrapper.css({
										"display":"block"
									});									
									fullscreen_background_thumbsHolderWrapper
									.stop()
									.animate({
										opacity:1
									}, 500, 'swing', function() {
									 //complete
									});
								}								
							}
                     }
	
				}				
			});
			
			fullscreen_background_container.mouseleave(function() {
				if (options.pauseOnMouseOver) {		
					current_obj.mouseOverBanner=false;
					nowx = (new Date).getTime();
				}	
				
				
				if (options.autoHideNavArrows && options.showNavArrows && !current_obj.isVideoPlaying) {
					fullscreen_background_leftNav.css("display","none");
					fullscreen_background_rightNav.css("display","none");
				}
				if (options.autoHideBottomNav && options.showBottomNav) {
				   if (options.skin=="bullets") {
       					fullscreen_background_bottomNav.css("display","none");
				   } else	 {
           				fullscreen_background_thumbsHolderWrapper
									.stop()
									.animate({
										opacity:0
									}, 300, 'swing', function() {
									 //complete
									});
				   }
				}	
                			
				if (options.autoPlay>0 && total_images>1 && !current_obj.isVideoPlaying && options.pauseOnMouseOver) {
					clearTimeout(current_obj.timeoutID);

					
				    current_obj.arcInitialTime = (new Date).getTime();
					var new_delay = parseInt(options.autoPlay*1000-((current_obj.timeElapsed+nowx)-current_obj.arcInitialTime),10);
					current_obj.timeoutID=setTimeout(function(){ fullscreen_background_navigation(1,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb)},new_delay);
				}
			});
			
			
			var contentHolderUnit=$('.contentHolderUnit', fullscreen_background_contentHolder);
			if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1 && navigator.userAgent.indexOf('Android') == -1) {
				contentHolderUnit.css("z-index","1");
			} else if (navigator.userAgent.indexOf('Chrome') != -1 && navigator.userAgent.indexOf('Android') == -1) {
				contentHolderUnit.css("z-index","1");
			}
			contentHolderUnit.click(function() {
				var i=$(this).attr('rel');
				//alert (i+' -- '+current_obj.current_img_no);
				if ($(imgs[current_obj.current_img_no]).attr('data-video')=='true') {
					if (i!=current_obj.current_img_no) {
						current_obj.isVideoPlaying=false;
					} else {
						fullscreen_background_playOver.click();
						/*clearTimeout(current_obj.timeoutID);
		
						imgInside = $(this).find('img:first');
						imgInside.css('display','none');
						fullscreen_background_playOver.css('display','none');
						var texts = $(current_obj.currentImg.attr('data-text-id')).children();
				        texts.css("opacity",0);
                        current_obj.isVideoPlaying=true;
						
						if (options.thumbsWrapperMarginTop<0) {
                       			fullscreen_background_thumbsHolderWrapper.css("display","none");
 								if (options.skin=="bullets") {
					   				fullscreen_background_bottomNav.css("display","none");								
								}					
						}
						if (options.showCircleTimer) {
								clearInterval(current_obj.intervalID);

								current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
								current_obj.ctx.beginPath();
								current_obj.ctx.globalAlpha=0;
								current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 0, false);
								current_obj.ctx.lineWidth = options.circleLineWidth+2;
								current_obj.ctx.strokeStyle = options.behindCircleColor;
								current_obj.ctx.stroke();            
								
								
								current_obj.ctx.beginPath();
								current_obj.ctx.globalAlpha=0;
								current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 0,  false);
								current_obj.ctx.lineWidth = options.circleLineWidth;
								current_obj.ctx.strokeStyle = options.circleColor;
								current_obj.ctx.stroke();	

						}	*/					
					}
				}

				var mycurImg=$(imgs[current_obj.current_img_no]);
				if (mycurImg.attr('data-link')!=undefined && i==current_obj.current_img_no && mycurImg.attr('data-link')!='') {
					var cur_target=options.target;
					
					if (mycurImg.attr('data-target')!=undefined && mycurImg.attr('data-target')!=''){
						cur_target=mycurImg.attr('data-target');
					}
					
					if (cur_target=="_blank")
						window.open(mycurImg.attr('data-link'));
					else
						window.location = mycurImg.attr('data-link');
				}
			});
			
			
			fullscreen_background_playOver.click(function() {
				fullscreen_background_playOver.css('display','none');						
				clearTimeout(current_obj.timeoutID);
				
				imgInside = $('#contentHolderUnit_'+current_obj.current_img_no, fullscreen_background_container).find('img:first');
				imgInside.css('display','none');
				var all_texts = $(current_obj.currentImg.attr('data-text-id')).children();
				all_texts.css("opacity",0);
				current_obj.isVideoPlaying=true;	
				
				if (options.thumbsWrapperMarginTop<0) {
						fullscreen_background_thumbsHolderWrapper.css("display","none");
						if (options.skin=="bullets") {
							fullscreen_background_bottomNav.css("display","none");								
						}								
				}					
  
				if (options.showCircleTimer) {
						clearInterval(current_obj.intervalID);
  
						current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=0;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 0, false);
						current_obj.ctx.lineWidth = options.circleLineWidth+2;
						current_obj.ctx.strokeStyle = options.behindCircleColor;
						current_obj.ctx.stroke();            
						
						
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=0;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 0,  false);
						current_obj.ctx.lineWidth = options.circleLineWidth;
						current_obj.ctx.strokeStyle = options.circleColor;
						current_obj.ctx.stroke();	
  
				}
						
				if (ver_ie!=-1 && options.texturePath) { //is IE and I have a texture
					$('.texture_over_image', fullscreen_background_container).css('display','none');
				}
											
			});			
			
			
			
			//controllers
			fullscreen_background_leftNav.click(function() {
				if (!current_obj.slideIsRunning) {
					current_obj.isVideoPlaying=false;
					
					if (options.showBottomNav) {
						fullscreen_background_thumbsHolderWrapper.css({
							"opacity":1,
							"display":"block"
						});
						
						if (options.skin=="bullets") {
					   		fullscreen_background_bottomNav.css("display","block");								
						}						
					}

					
					clearTimeout(current_obj.timeoutID);
					fullscreen_background_navigation(-1,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb);
				}
			});
			fullscreen_background_rightNav.click(function() {
				if (!current_obj.slideIsRunning) {
					current_obj.isVideoPlaying=false;
					
					if (options.showBottomNav) {
						fullscreen_background_thumbsHolderWrapper.css({
							"opacity":1,
							"display":"block"
						});
						if (options.skin=="bullets") {
					   		fullscreen_background_bottomNav.css("display","block");								
						}						
					}					
					
					clearTimeout(current_obj.timeoutID);
					fullscreen_background_navigation(1,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb);
				}
			});
			
			
			
			
			
			
			
			
			
			
			
			var TO = false;
			$(window).resize(function() {
				var ver_ie=getInternetExplorerVersion();
				doResizeNow=true;
				var val = navigator.userAgent.toLowerCase();
				if (val.indexOf('android') != -1) {
					if (options.windowOrientationScreenSize0==0 && window.orientation==0)
						options.windowOrientationScreenSize0=$(window).width();
						
					if (options.windowOrientationScreenSize90==0 && window.orientation==90)
						options.windowOrientationScreenSize90=$(window).height();	
						
					if (options.windowOrientationScreenSize_90==0 && window.orientation==-90)
						options.windowOrientationScreenSize_90=$(window).height();						
					
					if (options.windowOrientationScreenSize0 && window.orientation==0 && $(window).width()>options.windowOrientationScreenSize0)	
						doResizeNow=false;

					if (options.windowOrientationScreenSize90 && window.orientation==90 && $(window).height()>options.windowOrientationScreenSize90)	
						doResizeNow=false;
						
					if (options.windowOrientationScreenSize_90 && window.orientation==-90 && $(window).height()>options.windowOrientationScreenSize_90)	
						doResizeNow=false;	
						
						
					if (current_obj.windowWidth==0) {
						doResizeNow=false;
						current_obj.windowWidth=$(window).width();
					}

				}
				if (ver_ie!=-1 && ver_ie==9 && current_obj.windowWidth==0)
					doResizeNow=false;
				
				
				if (current_obj.windowWidth==$(window).width()) {
					doResizeNow=false;
					if (options.windowCurOrientation!=window.orientation && navigator.userAgent.indexOf('Android') != -1) {
						options.windowCurOrientation=window.orientation;
						doResizeNow=true;
					}
				} else
					current_obj.windowWidth=$(window).width();
				
				
				if (val.indexOf("ipad") != -1 || val.indexOf("iphone") != -1 || val.indexOf("ipod") != -1 || val.indexOf("webos") != -1) {
					doResizeNow=true;
				}
				if (options.responsive && doResizeNow) {
					 if(TO !== false)
						clearTimeout(TO);
					 
					
					 TO = setTimeout(function(){ doResize(current_obj,options,total_images,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolderVisibleWrapper,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,bottomNavButs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb,fullscreen_background_leftNav,bottomNavBut,fullscreen_background_bottomNav,fullscreen_background_thumbsHolderVisibleWrapper,fullscreen_background_thumbsHolderWrapper,bottomNavWidth) }, 300); //200 is time in miliseconds
				}
			});



			//bottom nav
			var bottomNavButs=$('.bottomNavButtonOFF', fullscreen_background_container);
            if (options.skin=="bullets") {
			
			
			bottomNavButs.click(function() {
				if (!current_obj.slideIsRunning) {
					current_obj.isVideoPlaying=false;
					
					var currentBut=$(this);
					var i=currentBut.attr('rel');
					if (current_obj.current_img_no!=i) {
							//deactivate previous 
							$(bottomNavButs[current_obj.current_img_no]).removeClass('bottomNavButtonON');
							current_obj.previous_current_img_no=current_obj.current_img_no;
							current_obj.bottomNavClicked=true;
							
		
							current_obj.current_img_no=i-1;
							clearTimeout(current_obj.timeoutID);
							
							fullscreen_background_navigation(1,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb);
					}
				}
			});
			
			bottomNavButs.mouseenter(function() {
				var currentBut=$(this);
				var i=currentBut.attr('rel');
				
				
				
				if (options.showPreviewThumbs) {
					fullscreen_background_bottomOverThumb = $('<div class="bottomOverThumb"></div>');
					currentBut.append(fullscreen_background_bottomOverThumb);
					var image_name=$(imgs[i]).attr('data-bottom-thumb');
					var previous_image=$(imgs[previousBottomHovered]).attr('data-bottom-thumb');
					var thumb_marginLeft=80; //80 thumb width, 4 border
					var thumb_marginLeftFinal=-80;
					if (previousBottomHovered>i) {
					   thumb_marginLeft=-80;
					   thumb_marginLeftFinal=80;
		             }
					var thumb_marginTop=-80;
					fullscreen_background_bottomOverThumb.html('');
                    fullscreen_background_bottomOverThumb.html('<div class="innerBottomOverThumb"><img src="'+ previous_image + '"style="margin:0px;" id="oldThumb"><img src="'+ image_name + '" style="margin-top:'+thumb_marginTop+'px; margin-left:'+thumb_marginLeft+'px;" id="newThumb"></div>');
                    $('#newThumb')
                         .stop()
                         .animate({
                            marginLeft:'0px'
                          },150,function(){
                                fullscreen_background_bottomOverThumb.html('<div class="innerBottomOverThumb"><img src="'+ image_name + '"></div>'); //opera fix
                          });                    
                    $('#oldThumb')
                         .stop()
                         .animate({
                            marginLeft:thumb_marginLeftFinal+'px'
                          },150,function(){
                                //
                          });
					previousBottomHovered=i;
				}
				
				currentBut.addClass('bottomNavButtonON');
			});
			
			bottomNavButs.mouseleave(function() {
				var currentBut=$(this);
				var i=currentBut.attr('rel');

				if (options.showPreviewThumbs) {
					fullscreen_background_bottomOverThumb.remove();
				}				
				
				if (current_obj.current_img_no!=i)
					currentBut.removeClass('bottomNavButtonON');
			});			
			
            } //if (options.skin=="bullets") {





			//thumbs bottom nav
			thumbsHolder_Thumbs.mousedown(function() {
				if (!current_obj.slideIsRunning) {
					arrowClicked=true;
				    current_obj.isVideoPlaying=false;
					var currentBut=$(this);
					var i=currentBut.attr('rel');
					if (current_obj.current_img_no!=i) {
						//deactivate previous 
						///$(thumbsHolder_Thumbs[current_obj.current_img_no]).removeClass('thumbsHolder_ThumbON');
						   $(thumbsHolder_Thumbs[current_obj.current_img_no]).css({
							   'border-color':options.thumbsBorderColorOFF
						   });						
						current_obj.previous_current_img_no=current_obj.current_img_no;
						current_obj.bottomNavClicked=true;
						
						current_obj.current_img_no=i-1;
						clearTimeout(current_obj.timeoutID);
						
						fullscreen_background_navigation(1,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb);
					}
				}
			});
			thumbsHolder_Thumbs.mouseup(function() {
				arrowClicked=false;
			});				
			
			thumbsHolder_Thumbs.mouseenter(function() {
				var currentBut=$(this);
				var i=currentBut.attr('rel');
				
				///currentBut.addClass('thumbsHolder_ThumbON');
			   	currentBut.css({
				   'border-color':options.thumbsBorderColorON
			   	});				
			});
			
			thumbsHolder_Thumbs.mouseleave(function() {
				var currentBut=$(this);
				var i=currentBut.attr('rel');

				if (current_obj.current_img_no!=i) {
					///currentBut.removeClass('thumbsHolder_ThumbON');
				   currentBut.css({
					   'border-color':options.thumbsBorderColorOFF
				   });					
				}
			});	
			
			
			//carousel controllers
			fullscreen_background_carouselLeftNav.click(function() {
				if (!current_obj.isCarouselScrolling) {
					currentCarouselLeft=fullscreen_background_thumbsHolder.css('left').substr(0,fullscreen_background_thumbsHolder.css('left').lastIndexOf('px'));

					if (currentCarouselLeft <0 ) 
						carouselScroll(1,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,options,total_images,thumbsHolder_Thumb,current_obj);
				}
			});
			
			
			fullscreen_background_carouselRightNav.click(function() {
				if (!current_obj.isCarouselScrolling) {
					currentCarouselLeft=fullscreen_background_thumbsHolder.css('left').substr(0,fullscreen_background_thumbsHolder.css('left').lastIndexOf('px'));
					if (Math.abs(currentCarouselLeft-current_obj.carouselStep)<((2*current_obj.thumbBorderWidth+thumbsHolder_Thumb.width())+current_obj.thumbMarginLeft)*total_images) 
						carouselScroll(-1,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,options,total_images,thumbsHolder_Thumb,current_obj);
				}
			});

			if (options.width100Proc && options.height100Proc && options.setAsBg) {
					resizeVideoBg(current_obj,options,imgs,fullscreen_background_container);
			}	


			//first start autoplay
			if (options.skin=="bullets") {
			   $(bottomNavButs[current_obj.current_img_no]).addClass('bottomNavButtonON');
			}
			//thumbs
			///$(thumbsHolder_Thumbs[current_obj.current_img_no]).addClass('thumbsHolder_ThumbON');
				 $(thumbsHolder_Thumbs[current_obj.current_img_no]).css({
					 'border-color':options.thumbsBorderColorON
				 });
			
			
		 	
			
			if (options.autoPlay>0 && total_images>1) {
				if (options.showCircleTimer) {
					current_obj.intervalID=setInterval(function(){the_arc(current_obj,options)}, 125);
				}
                current_obj.timeoutID=setTimeout(function(){ fullscreen_background_navigation(1,current_obj,options,total_images,bottomNavButs,imgs,fullscreen_background_the,bannerControls,fullscreen_background_contentHolder,fullscreen_background_container,fullscreen_background_playOver,origImgsDimensions,thumbsHolder_Thumbs,fullscreen_background_thumbsHolder,fullscreen_background_carouselLeftNav,fullscreen_background_carouselRightNav,thumbsHolder_Thumb)},options.autoPlay*1000);
				
			}

			if ($(imgs[current_obj.current_img_no]).attr('data-video')=='true')
				fullscreen_background_playOver.css('display','block');
			
			
		});
	};

	
	//
	// plugin skins
	//
	$.fn.fullscreen_background.defaults = {
			skin: 'bullets',
			width:1920,
			height:600,
			width100Proc:true, //hidden
			height100Proc:true,			
			autoPlay:6,
			fadeSlides:true,
			loop:true,
			setAsBg:true,
			texturePath:'',
			
			
			horizontalPosition:'center', //hidden
			verticalPosition:'center', //hidden

			initialOpacity:1,
			
			target:"_blank",
			
			pauseOnMouseOver:false,
			showCircleTimer:true,
			showCircleTimerIE8IE7:false,
			circleRadius:8,
			circleLineWidth:4,
			circleColor: "#ffffff",
			circleAlpha: 100,
			behindCircleColor: "#000000",
			behindCircleAlpha: 20,
			responsive:true, //hidden
			responsiveRelativeToBrowser:true,
			
			numberOfThumbsPerScreen:0,
				
			bottomNavPos:'right', //left/center/right
			bottomNavLateralMargin:0, //only for left & right
			thumbsWrapperMarginTop:-110,
			thumbsWrapperBg:'', //hexa or image
			thumbsBorderColorON:'#000000',
			thumbsBorderColorOFF:'#7a7a7a',
			showAllControllers:true,
			showNavArrows:true,
			showOnInitNavArrows:true, // o1
			autoHideNavArrows:true, // o1
			showBottomNav:true,
			showOnInitBottomNav:true, // o2
			autoHideBottomNav:false, // o2
			showPreviewThumbs:true,
			enableTouchScreen:true,
			absUrl:'',
			
			videoProportionWidth:16,
			videoProportionHeight:9, // not available as option. Is a constant			
			
			origWidth:0,
			origHeight:0,
			origThumbW:0,
			origThumbH:0,
			origthumbsHolderWrapperH:0,
			origthumbsHolder_MarginTop:0,
			windowOrientationScreenSize0:0,
			windowOrientationScreenSize90:0,
			windowOrientationScreenSize_90:0,
			windowCurOrientation:0
			
	};

})(jQuery);


jQuery(window).bind('load',function(){
	jQuery(".vimeo-bg-player").each(function() {
		jQuery(this).fullscreen_background({
			skin: 'bullets',
			showNavArrows:false,
			showBottomNav:false,
			autoHideBottomNav:true,
			bottomNavLateralMargin:25, //only for left & right
			showPreviewThumbs:false,
			thumbsWrapperMarginTop: -55
		});
	});
});