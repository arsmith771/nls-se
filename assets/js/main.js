function removeNoJs(){

	jQuery('body').removeClass('no-js');

}

function pinFooter(){

 	var winH = window.innerHeight,
 		contentH = jQuery('.site-container').height();

 	if ( contentH  < winH ){

 		jQuery('.site-footer').addClass('site-footer--pinned');

 	} else {

 		jQuery('.site-footer').removeClass('site-footer--pinned');
 	}
}

function subMenuContainer(){

	jQuery('.menu-primary .menu-item-33').find('.sub-menu').prepend('<span id="sub-menu-right" class="sub-menu-arrow sub-menu-arrow--r">&gt;</span>'); //.prepend('<span id="sub-menu-left" class="sub-menu-arrow sub-menu-arrow--r">&lt;</span>');
}

function slideSubMenu_r(){

	jQuery('#sub-menu-right').on('click', function(){

		var slideX = window.innerWidth;

		jQuery(this).closest('.sub-menu').css('left','auto').animate({right: slideX}, 300);
		console.log('clicked');
		
	});
}

function subMenuReset(){

	jQuery('.menu-primary .menu-item-33').find('.sub-menu').css('left','0').css('right','0');
}

function sourceList(){

	var sourceListH = jQuery('.single-source #source-list-container').height(),
		sourceCopy = jQuery('.single-source #source-copy');

	if ( window.innerWidth > 1024 ) {

		sourceCopy.css('min-height', sourceListH + 30);

	} else {

		sourceCopy.removeAttr('style');
	}
}

function showHide(){

	jQuery('#toggle-transcript').on('click', function(event){

		event.preventDefault();
		//jQuery('.accordion__header').removeClass('active');
		jQuery('#source-transcript-container').slideToggle();
		//jQuery(this).closest('.accordion').find('.accordion__header').toggleClass('active');
		jQuery('html, body').animate({
           scrollTop: jQuery('#source-transcript-container').offset().top
       	}, 'slow');

	});
}

function seeDiscussion(){

	jQuery('#see-discussion__cta').on('click', function(){

		jQuery('html, body').animate({
           scrollTop: jQuery('#source-discussion-points').offset().top
       	}, 'slow');

	});
}

function compareHeight(){

	var sourceCopyH = jQuery('#source-copy').height(),
		sourceListContainerH = jQuery('#source-list-container').height();

	if ( sourceCopyH > sourceListContainerH ){

		jQuery('#source-copy').addClass('mb40');

	} else{

		jQuery('#source-copy').removeClass('mb40');
	}
}

function sourceListCurrent(){

	var sourceNum = jQuery('#current-source-list-item').val();

	jQuery('.source-list__item').each(function(index) {

		if ( ( jQuery(this).index() == sourceNum ) && jQuery('.entry').hasClass('category-town-planning') ) {

			jQuery(this).addClass('source-list__item--current');

		} else if ( ( jQuery(this).index() == ( sourceNum - 1) ) && !jQuery('.entry').hasClass('category-town-planning') ) {

			jQuery(this).addClass('source-list__item--current');
		}
	});
}

function toggleInteractiveModal(){

	jQuery('.source-list__lnk--interactive').not('.source-list__lnk--gallery').on('click', function(event){

		event.preventDefault();
		jQuery('#interactive-modal').animate({left: '0', right: '0'}, 600);
		//jQuery('#interactive-modal').fadeToggle();
		jQuery('#interactive-modal__close').focus();
	});
}

function closeModal(){

	jQuery('#interactive-modal__close').on('click', function(event){

		event.preventDefault();
		jQuery('#interactive-modal').animate({left: '-5000px', right: '5000px'}, 600);
		//jQuery('#interactive-modal').fadeToggle();
	});

	jQuery(document).on('keyup',function(event) {

    	if (event.keyCode == 27) {

       		//jQuery('#interactive-modal').fadeToggle();
       		jQuery('#interactive-modal').animate({left: '-5000px', right: '5000px'}, 600);
    	}
	});
}

function slideCaptionTouch(){

	jQuery('.landing-banner__toggle-decript').on('click', function(){

		whatInput.ask();

		if (whatInput.ask() === 'touch') {

			var jThis = jQuery(this);

			if ( jThis.hasClass('closed') ) {
				jQuery('.landing-banner__caption').animate({left: '0'}, 500);
				jThis.text('Hide image description')
				jThis.removeClass('closed').addClass('open');

			} else {

				jQuery('.landing-banner__caption').animate({left: '-395px'}, 500);
				jThis.text('View image description')
				jThis.removeClass('open').addClass('closed');
			}
		}
	});
}


function slideCaption(){

	jQuery('.landing-banner').on('mouseover focus', function(){

		whatInput.ask();

		if ( ( whatInput.ask() === 'mouse' ) || ( whatInput.ask() === 'keyboard' ) ) {
	
			jQuery(this).find('.landing-banner__caption').animate({left: '0'}, 500);

		}

	});
	
	jQuery('.landing-banner').on('mouseleave blur', function(){
	
		whatInput.ask();

		if ( ( whatInput.ask() === 'mouse' ) || ( whatInput.ask() === 'keyboard' ) ) {
	
			jQuery(this).find('.landing-banner__caption').animate({left: '-395px'}, 300);

		} 
	});
  	
}


function slidePersonCaption(){

	jQuery('.key-people-thumbs__item > img').on('click', function(){

		jQuery('.key-people-thumbs__item').find('.key-people-thumbs__item__caption').css('left', '-260px');

		if ( jQuery(this).closest('.key-people-thumbs__item').hasClass('closed') ) {

			jQuery(this).siblings('.key-people-thumbs__item__caption').animate({left: '0'}, 200);
			jQuery(this).closest('.key-people-thumbs__item').removeClass('closed').addClass('open');

		} else {

			jQuery(this).siblings('.key-people-thumbs__item__caption').animate({left: '-260px'}, 200);
			jQuery(this).closest('.key-people-thumbs__item').removeClass('open').addClass('closed');
		}

	});

}

function relocateSourceList(){

	var copyBlock = jQuery('.page-template-encyclopaedia .landing-copy'),
		sourceList = jQuery('.page-template-encyclopaedia #source-list-container');

	if ( ( jQuery('.page-template-encyclopaedia .landing-copy #source-list-container').length < 1 ) && ( window.innerWidth > 1024 ) ) {

		copyBlock.prepend(sourceList);

	} else if ( ( jQuery('.page-template-encyclopaedia .landing-copy #source-list-container').length > 0 ) && ( window.innerWidth <= 1024 ) ){

		sourceList.insertAfter(copyBlock);

	}
}

function makeVisible() {

    jQuery('.landing-banner__img__item').each(function (index, elem) {
		
		if (!elem.complete) {
       		jQuery(this).on('load', function () {

            	jQuery(this).closest('.landing-banner__img').addClass('fade-out');

        	});
			
		} else {
			
            jQuery(this).closest('.landing-banner__img').addClass('fade-out');

    	}
    });
}


/*
function toggleGalleryCaption(){

	jQuery('.fancybox-caption__body').on('click', function(event){
		//event.preventDefault();
		event.stopPropagation();
		jQuery(this).find('.gallery-image-caption__long').toggle();
		console.log('clicked');
	});
}
*/

jQuery(document).ready(function(){
	removeNoJs();
	sourceList();
	//subMenuContainer();
	//slideSubMenu_r();
	pinFooter();
	showHide();
	compareHeight();
	sourceListCurrent();
	slideCaption();
	slideCaptionTouch();
	slidePersonCaption();
	relocateSourceList();
	makeVisible();
	seeDiscussion();
	toggleInteractiveModal();
	closeModal();
//	toggleGalleryCaption();
});

jQuery(window).on('load', function(){

	//toggleGalleryCaption();

});

jQuery(window).on('resize', function(){

	sourceList();
	subMenuReset();
	pinFooter();
	compareHeight();
	relocateSourceList();

});