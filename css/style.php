<?php   

$glt_css = get_option("googlelanguagetranslator_css");
$get_language_choices = get_option ('language_display_settings');
$flagarea_width = get_option ('googlelanguagetranslator_flagarea_width'); 
$languagebox_width = get_option ('googlelanguagetranslator_languagebox_width'); 
$options = get_option ('googlelanguagetranslator_flag_size'); 
$alignment = get_option ('googlelanguagetranslator_flags_alignment');
$language_codes = array_keys($this->languages_array);
$license_key = get_option ('googlelanguagetranslator_license_key');
$floating_widget = get_option ('googlelanguagetranslator_floating_widget');
$floating_widget_position = get_option ('googlelanguagetranslator_floating_widget_position');

    echo '<style type="text/css">';
    echo $glt_css;

if ($floating_widget == 'yes'):
  if ($floating_widget_position == 'bottom_left'):
    echo '#glt-translate-trigger { left:20px; right:auto; }';
  elseif ($floating_widget_position == 'top_right'):
    echo '#glt-translate-trigger { bottom:auto; top:0; border-top-left-radius:0; border-top-right-radius:0; -webkit-border-top-left-radius:0; -webkit-border-top-right-radius:0; -moz-border-top-left-radius:0; -moz-border-top-right-radius:0; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; -webkit-border-bottom-left-radius: 5px; -webkit-border-bottom-right-radius: 5px; -moz-border-bottom-left-radius: 5px; -moz-border-bottom-right-radius: 5px;}';
    echo '.tool-container.tool-top { top:50px !important; bottom:auto !important; }';
    echo '.tool-container.tool-top .arrow { border-color: transparent transparent #d0cbcb; top:-14px; }';
  elseif ($floating_widget_position == 'top_left'):
    echo '#glt-translate-trigger { bottom:auto; top:0; left:20px; right:auto; border-top-left-radius:0; border-top-right-radius:0; -webkit-border-top-left-radius:0; -webkit-border-top-right-radius:0; -moz-border-top-left-radius:0; -moz-border-top-right-radius:0; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; -webkit-border-bottom-left-radius: 5px; -webkit-border-bottom-right-radius: 5px; -moz-border-bottom-left-radius: 5px; -moz-border-bottom-right-radius: 5px;}';
    echo '.tool-container.tool-top { top:50px !important; bottom:auto !important; }';
    echo '.tool-container.tool-top .arrow { border-color: transparent transparent #d0cbcb; top:-14px; }';
  elseif ($floating_widget_position == 'top_center'):
    echo '#glt-translate-trigger { bottom:auto; top:0; left:50%; margin-left:-63px; right:auto; border-top-left-radius:0; border-top-right-radius:0; -webkit-border-top-left-radius:0; -webkit-border-top-right-radius:0; -moz-border-top-left-radius:0; -moz-border-top-right-radius:0; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; -webkit-border-bottom-left-radius: 5px; -webkit-border-bottom-right-radius: 5px; -moz-border-bottom-left-radius: 5px; -moz-border-bottom-right-radius: 5px;}';
    echo '.tool-container.tool-top { top:50px !important; bottom:auto !important; }';
    echo '.tool-container.tool-top .arrow { border-color: transparent transparent #d0cbcb; top:-14px; }';
  elseif ($floating_widget_position == 'bottom_center'):
    echo '#glt-translate-trigger { left:50%; margin-left:-63px; right:auto; }';
  endif;
endif;

if (get_option('googlelanguagetranslator_flags') == 'hide_flags') {
  if ( $alignment == 'flags_right') {
	echo '#google_language_translator, #language { clear:both; width:auto !important; text-align:right; }';
	echo '#language { float:right; }';
	echo '#flags { text-align:right; width:165px; float:right; clear:right; }';
	echo 'p.hello { text-align:right; float:right; clear:both; }';
    echo '.glt-clear { height:0px; clear:both; margin:0px; padding:0px; }';
	echo '.elegant-display { text-align:right; }'; 
  }
  
  if ( $alignment == 'flags_center') {
	echo '#language { clear:both; }';
	echo '#google_language_translator { clear:both; }';
	echo '#flags { width:'.$flagarea_width.'; margin:0px auto; text-align:center; }';
    echo '#flags a { display:inline-block; margin-right:2px; }';
    echo '.switcher { margin:10px auto 0px auto; }';
    echo '.goog-te-gadget, p.hello { text-align:center; }';
  }
}

if (get_option('googlelanguagetranslator_flags') == 'show_flags') {
	if (get_option('googlelanguagetranslator_language_option')=='specific') {
		echo '#flags {display:none !important; }';
	}
  
	if(get_option('googlelanguagetranslator_display')=='Vertical') { 
	    echo 'p.hello { font-size:12px; color:darkgray; }';
        echo '#google_language_translator, #flags { text-align:left; }';
	  if ($alignment == 'flags_right') {
	    echo '#sortable { float:right !important; }';
	  } 
	} elseif (get_option('googlelanguagetranslator_display')=='Horizontal') {
        

	  if ($alignment=='flags_right') {
	    echo '#google_language_translator { text-align:left !important; }';
	    echo 'select.goog-te-combo { float:right; }';
	    echo '.goog-te-gadget { padding-top:13px; }';
	    echo '.goog-te-gadget .goog-te-combo { margin-top:-7px !important; }';
	    echo '#language { margin-bottom:3px !important; }';
	  }
  
	    echo '.goog-te-gadget { margin-top:2px !important; }';
	    echo 'p.hello { font-size:12px; color:#666; }';
	} 

	if ( $alignment == 'flags_right') {
	  echo '#google_language_translator, #language { clear:both; width:'.$languagebox_width.' !important; text-align:right; }';
	  echo '.switcher { width:'.$languagebox_width.' !important; }';
	  echo '#language { float:right; }';
	  echo '#flags { text-align:right; width:165px; float:right; clear:right; }';
	  echo 'p.hello { text-align:right; float:right; clear:both; }';
      echo '.glt-clear { height:0px; clear:both; margin:0px; padding:0px; }';
	  echo '#sortable { width:auto; }';
	  echo '#flags ul { float:right !important; }';
	}

	if ( $alignment == 'flags_left') {
	  echo '#google_language_translator { clear:both; }';
	  echo '#language { clear:both; }';
	  echo '#flags { width:'.$flagarea_width.' !important; }';
	  echo '#flags a { display:inline-block; margin-right:2px; }';
	} elseif ( $alignment == 'flags_right') {
	  echo '#flags { width:'.$flagarea_width.' !important; text-align:right; float:right; clear:right; }';
	  echo '#flags a { display:inline-block; margin-left:2px; }';
	  echo '.elegant-display { text-align:right; }';
	} elseif ( $alignment == 'flags_center') {
	  echo '#language { clear:both; }';
	  echo '#google_language_translator { clear:both; }';
	  echo '#flags { width:'.$flagarea_width.'; margin:0px auto; text-align:center; }';
      echo '#flags a { display:inline-block; margin-right:2px; }';
      echo '.switcher { margin:10px auto 0px auto; }';
      echo '.goog-te-gadget, p.hello { text-align:center; }';
	  echo '#flags li { display:inline !important; float:none !important; }';
	  echo '#flags ul { width:auto !important; }';
    }

}
      echo '.goog-tooltip {display: none !important;}';
      echo '.goog-tooltip:hover {display: none !important;}';
      echo '.goog-text-highlight {background-color: transparent !important; border: none !important; box-shadow: none !important;}';

if (get_option('googlelanguagetranslator_showbranding')=='Yes') {
    if(get_option('googlelanguagetranslator_active')==1) {
      echo '#google_language_translator { width:auto !important; }';
    }
  
} elseif(get_option('googlelanguagetranslator_showbranding')=='No') {
    if(get_option('googlelanguagetranslator_active')==1) { 
	  echo '.elegant-display { display:none; }';
      echo '#google_language_translator a {display: none !important; }';
      echo '.goog-te-gadget {color:transparent !important;}';  
      echo '.goog-te-gadget { font-size:0px !important; }';
      echo '.goog-branding { display:none; }';
    }
}

if (get_option('googlelanguagetranslator_translatebox') == 'no') {
    if(get_option('googlelanguagetranslator_active')==1) {
	  echo '#google_language_translator, #language { display:none; }';
    }
}

if (get_option('googlelanguagetranslator_flags') == 'hide_flags') {
    if(get_option('googlelanguagetranslator_active') ==1) {
      echo '#flags { display:none; }';
    }
}

if(get_option('googlelanguagetranslator_toolbar')=='Yes') {
    if(get_option('googlelanguagetranslator_active')==1) {
      echo '#google_language_translator {color: transparent;}';
	  echo 'body { top:0px !important; }';
    }
} elseif(get_option('googlelanguagetranslator_toolbar')=='No') {
    if(get_option('googlelanguagetranslator_active')==1) {
      echo '.goog-te-banner-frame{visibility:hidden !important;}';
      echo 'body { top:0px !important;}';
    }
}

if(get_option ('googlelanguagetranslator_theme_style')=='elegant') {
    if ( get_option ('googlelanguagetranslator_languagebox_flags') != 'show_flags') { 
      echo '.switcher .selected span.size16, .switcher .option span.size16 { display:none; }';
	}
  
    if (get_option('googlelanguagetranslator_display')=='Horizontal') {
      echo '.goog-te-gadget { margin-top:2px !important; }';
      echo 'p.hello { font-size:12px; color:#666; }';
      echo '#language_inner { float:left; }';
      echo '.blockdisplay { display:block !important; }';
	  echo '#google_language_translator { display:none; }';
	  
	
	  if ( $alignment =='flags_left') {
		 echo '.switcher { float:left; width:150px !important; }';
	     
	  }
      if ( $alignment == 'flags_center') {
	     echo '.switcher { float:left; width:150px !important; }';
	     echo '#language,#glt_container { min-width:320px; }';
	     echo '.elegant-display { padding-top:6px !important; }';
	     echo '#flags ul { float:none !important; }';
      }
	
	  if ($alignment != 'flags_center') {
	     echo '#language { width:320px; }';
	     
	  }
	  
      if ($alignment == 'flags_right') {
         echo '.goog-te-combo { float:right; }';
		 echo '.goog-te-gadget { padding-top:9px; clear:none !important;}';
	     echo '#language_inner { float:right !important; }';
	     echo '#language,#glt_container { min-width:320px; }';
	  }
    }
  
    if (get_option('googlelanguagetranslator_display')!='Horizontal') {
	  echo '.switcher, select.goog-te-combo { width:'.$languagebox_width.' !important; clear:both; }';
    }
    echo 'p.hello { font-size:12px; color:darkgray; }';
    echo '.goog-te-gadget { clear:both; }';
    echo '#google_language_translator { display:none; }';
	
} elseif ( get_option ('googlelanguagetranslator_theme_style')=='classic' || get_option('googlelanguagetranslator_display')=='SIMPLE') {
    echo '#language { display:none; }';	
}

if ( get_option ('googlelanguagetranslator_language_option') == "specific" ) {
   foreach($language_codes as $language_code) {  
	 if (!isset ( $get_language_choices ['$language_code'] ) ) {
       $get_language_choices['$language_code'] = 0;
     }
	
	 if ( $get_language_choices[$language_code] != 1 ) { 
	  echo 'a.'.$language_code.' { display:none; } '; 
	}
  }
}
echo '</style>';
?>