jQuery(document).ready(function($){

  

$('form').bind('submit', function() {

  $(this).find("select#googlelanguagetranslator_languagebox_width").removeAttr('disabled');

});

  

var language_display = $('input[name=googlelanguagetranslator_language_option]:checked').val();

      $('#glt-settings input').prop('disabled', true);

      if ( language_display == 'all') {

       $ ('.languages').css('display','none');

	   $ ('.choose_flags').css('display','none');

		

	} else if (language_display == 'specific') {

	 

	   $ ('.choose_flags_intro').css('display','none');

	   $ ('.choose_flags').css('display','none');

	}

	

  var display = $('select[name=googlelanguagetranslator_display] option:selected').val();

 

  if ( display == 'Horizontal') {

	//$("input[value='flags_center']").attr('disabled',true);

	$("select#googlelanguagetranslator_languagebox_width").attr('disabled',true);

  }

  

  $('select[name=googlelanguagetranslator_display]').change(function() {

	if( $(this).val() == 'Horizontal') {

	  //$ ('.alignment').fadeOut("slow");

	} else if ( $(this).val() == 'Vertical') {

      //$ ('.alignment').fadeIn("slow");

	}

  });

  

  $('input[name=googlelanguagetranslator_language_option]').change(function(){

      if( $(this).val() == 'all'){

       $ ('.languages').fadeOut("slow");

	   $ ('.choose_flags_intro').css('display','');

		 var flag_display = $('input[name=googlelanguagetranslator_flags]:checked').val();

		 if ( flag_display == 'show_flags') {

		  $ ('.choose_flags').css('display','');

		}

	} else if ($(this).val() == 'specific') {

	   $ ('.languages').fadeIn("slow");

	   $ ('.choose_flags_intro').css('display','none');

	   $ ('.choose_flags').css('display','none');

	}

  });

      

  var language_display = $('input[name=googlelanguagetranslator_language_option]:checked').val();    

  var flag_display = $('input[name=googlelanguagetranslator_flags]:checked').val();

  var floating_widget_display = $('select[name=googlelanguagetranslator_floating_widget] option:selected').val();



  if ( flag_display == 'hide_flags') {

    $ ('.choose_flags').css('display','none');

  } else if (flag_display == 'show_flags') {

    if ( language_display == 'all') {

      $ ('.choose_flags').css('display','');

    }

  }



  if(floating_widget_display == 'yes') {

    $('.floating_widget_text').css('display','');

  } else {

    $('.floating_widget_text').css('display','none');

  }



  //FadeIn and FadeOut Floating Widget Text option

  $('select[name=googlelanguagetranslator_floating_widget]').change(function() {

    if($(this).val()=='yes') {

      $('.floating_widget_text').fadeIn("slow");

    } else {

      $('.floating_widget_text').fadeOut("slow");

    }

  });

	

  $('input[name=googlelanguagetranslator_flags]').change(function(){

      if( $(this).val() == 'hide_flags'){

       $ ('.choose_flags').fadeOut("slow");

	} else if ($(this).val() == 'show_flags') {

	   $ ('.choose_flags').fadeIn("slow");

	}

  });

  

    //FadeIn and FadeOut Google Analytics tracking settings

  $('input[name=googlelanguagetranslator_analytics]').change(function() {

	if( $(this).is(':checked')) {

	  $('.analytics').fadeIn("slow");

	} else if ( $(this).not(':checked')) {

	  $('.analytics').fadeOut("slow");

	}

	  });

  

  //Hide or show Google Analytics ID field upon browser refresh  

  var analytics = $('input[name=googlelanguagetranslator_analytics]');

  if ( analytics.is(':checked') )  {

       $ ('.analytics').css('display','');

  } else {

	   $ ('.analytics').css('display','none');

	}

  

  

  

  //Prevent the translator preview from translating Dashboard text

  $('#adminmenu').addClass('notranslate');

  $('#wp-toolbar').addClass('notranslate');

  $('#setting-error-settings_updated').addClass('notranslate');

  $('.update-nag').addClass('notranslate');

  $('title').addClass('notranslate');

  $('#footer-thankyou').addClass('notranslate');

  $('.settings-error').addClass('notranslate');

});

jQuery(document).ready(function($) { 
  $("#sortable,#sortable-toolbar").sortable({ 
    distance: 10, 
    helper: "clone", 
    forcePlaceholderSize:true,
    update: function(event,ui) {
      var newOrder = $(this).sortable('toArray').toString();
        $.post("options.php",{order: newOrder});
	$('#order').val(newOrder);
    }
  });
  $("#sortable,#sortable-toolbar").disableSelection();

});

jQuery(document).ready(function($) {

  $('#wpwrap').addClass('notranslate');

  $('#translation-workspace').addClass('translate');

});







 



