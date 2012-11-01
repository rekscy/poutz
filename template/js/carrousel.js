

var carrousel = {
	
	nbSlide:0,
	nbCurrent: 1,
	elemCurrent: null,
	elem: null,
	timer:null,
	
	init : function(elem){
		this.nbSlide = elem.find('.slide').length;
		
		//création de pagiantion
		elem.append('<div class="navigation"></div>');
		for(var i=1;i<=this.nbSlide;i++){
			elem.find(".navigation").append('<span>'+i+'</span');
		}
	
	elem.find('.navigation span').click(function(){carrousel.gotoSlide($(this).text());})

	//initialization du carrousel
	
	this.elem=elem;
	elem.find(".slide").hide();
	elem.find(".slide:first").show();
	this.elemCurrent = elem.find("slide:first");
	this.elem.find('.navigation span:first').addClass('active');
	
	//reglage de la position de la span
        
        var posSpan=  630-(this.nbSlide*13);

        this.elem.find('.navigation').css({'padding-left': posSpan});
	//Timer
	carrousel.play();
	
	//Arret du carrousel en hover
	elem.mouseover(carrousel.stop);
	elem.mouseout(carrousel.play);
	
	},
	
	gotoSlide : function(num){
		if(num==this.nbCurrent){
			return false;
		}
		
		/*ANIMATION FADE IN FADE OUT
		this.elemCurrent.fadeOut();
		this.elem.find('#slide'+num).fadeIn();
		*/		/*ANIMATION FADE IN FADE OUT
		this.elemCurrent.fadeOut();
		this.elem.find('#slide'+num).fadeIn();
		*/

		var sens=1;
		if(num<this.nbCurrent){sens=-1}
		
                if(num==2){
                     this.elem.find('#slide'+1).fadeOut(100);
                }
                
		var cssDeb = {"opacity" :1, 'display':'block'};
		var cssFin = {"opacity" :1, 'display':'none'};
		
                
                this.elemCurrent.fadeOut(100);
//		this.elem.find('#slide'+num).show().css(cssDeb);
//		this.elem.find("#slide"+num).animate({'top': 5, 'left':5},500);
//		this.elemCurrent.animate(cssFin,500);

                this.elem.find('#slide'+num).fadeIn(500);

		this.elem.find('.navigation span').removeClass('active');
		this.elem.find('.navigation span:eq('+(num-1)+')').addClass('active');
		this.nbCurrent =num;
		this.elemCurrent=this.elem.find('#slide'+num)
	},
	
	next :function(){
		var num = Number(this.nbCurrent)+1;
		if(num>this.nbSlide){
			num=1;
		}
		this.gotoSlide(num);
	},
	
	
	prev :function(){
		num=this.nbCurrent-1;
		if(num<1){
			nbCurrent=this.nbSlide;
		}
		this.gotoSlide(num);
	},
	
	stop :function(){
		window.clearInterval(carrousel.timer);
	},
	
	play :function(){
		window.clearInterval(carrousel.timer);
		carrousel.timer = window.setInterval("carrousel.next()",15000);
		
	}
		
}

$(function(){
	carrousel.init($('#caroussel'));
});