jQuery.noConflict();

jQuery(document).ready(function($) {
				
  $("#language.auto-language-translation .selected").click (function(event) {
	event.preventDefault();
    $("#language.auto-language-translation .option").slideToggle(); 
  });
  
  $("#language.manual-language-translation .selected").click (function(event) {
	event.preventDefault();
	$("#language.manual-language-translation .option").slideToggle();
  });

  $("#language.auto-language-translation .option").click (function(event) {
	//event.preventDefault();
	$(this).slideToggle();
  });
				
  $("#language.auto-language-translation .option").mouseleave (function() {
	$(this).slideUp();
  });

  $("#language.auto-language-translation .switcher").mouseleave (function() { 
    $("#language.auto-language-translation .option").slideUp();
  });
				
  $("#language.auto-language-translation .switcher").mouseleave (function() {
    $("#language.auto-language-translation .option").slideUp();
  });
});