jQuery.fn.newTip = function(textoTip) {
   this.each(function(){
      elem = $(this);
	var miTip = $('<div class="tip">' + textoTip + '</div>');
	 $(document.body).append(miTip);
      elem.data("capatip", miTip);
      
      elem.mouseenter(function(e){
         var miTip = $(this).data("capatip");
         miTip.css("left", e.pageX + 10);
       miTip.css("top", e.pageY + 5);
         miTip.show(200);
      });
      elem.mouseleave(function(e){
         var miTip = $(this).data("capatip");
         miTip.hide(100);
      });
   }); 
   return this;
};