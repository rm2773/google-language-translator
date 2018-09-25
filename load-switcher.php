<?php

$default_language_code = get_option('googlelanguagetranslator_language'); 

if (isset($_GET['lang'])) {
  $url_language_prefix = $_GET['lang'];
} else {
  $url_language_prefix = '';
}

if (isset($_COOKIE['googtrans'])) {
  $cookie_value = $_COOKIE['googtrans'];
}

if (isset ($_COOKIE['language_name']) ):
  $language_name = $_COOKIE['language_name'];
endif;

$get_http_accept_language = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
$bestlang = $get_http_accept_language[0];
$bestlang_prefix = substr($get_http_accept_language[0],0,2);
$lang_attribute = get_option('googlelanguagetranslator_lang_urls'); ?>

<script type="text/javascript" async="async">
  jQuery(document).ready(function($) {
    $(function() { 
      var default_language_code = "<?php echo get_option('googlelanguagetranslator_language'); ?>";
      var default_language_name = "";
      var language_name = $.cookie('language_name');

      if(typeof (language_name) == "undefined" || typeof (language_name) == "object") {
        if (default_language_code == "en") { var default_language_name = "English"; }
        else if (default_language_code == "af") { var default_language_name = "Afrikaans"; }
	else if (default_language_code == "sq") { var default_language_name = "Albanian"; }
	else if (default_language_code == "ar") { var default_language_name = "Arabic"; }
	else if (default_language_code == "hy") { var default_language_name = "Armenian"; }
	else if (default_language_code == "az") { var default_language_name = "Azerbaijani"; }
	else if (default_language_code == "eu") { var default_language_name = "Basque"; }
	else if (default_language_code == "be") { var default_language_name = "Belarusian"; }
	else if (default_language_code == "bn") { var default_language_name = "Bengali"; }
	else if (default_language_code == "bs") { var default_language_name = "Bosnian"; }
	else if (default_language_code == "bg") { var default_language_name = "Bulgarian"; }
	else if (default_language_code == "ca") { var default_language_name = "Catalan"; }
        else if (default_language_code == "ceb") { var default_language_name = "Cebuano"; }
	else if (default_language_code == "zh-CN") { var default_language_name = "Chinese1"; }
	else if (default_language_code == "zh-TW") { var default_language_name = "Chinese2"; }
	else if (default_language_code == "cs") { var default_language_name = "Czech"; }
	else if (default_language_code == "hr") { var default_language_name = "Croatian"; }
	else if (default_language_code == "eo") { var default_language_name = "Esperanto"; }
	else if (default_language_code == "et") { var default_language_name = "Estonian"; }
	else if (default_language_code == "tl") { var default_language_name = "Filipino"; }
	else if (default_language_code == "fi") { var default_language_name = "Finnish"; }
	else if (default_language_code == "gl") { var default_language_name = "Galician"; }
	else if (default_language_code == "ka") { var default_language_name = "Georgian"; }
	else if (default_language_code == "gu") { var default_language_name = "Gujarati"; }
	else if (default_language_code == "ht") { var default_language_name = "Haitian"; }
	else if (default_language_code == "iw") { var default_language_name = "Hebrew"; }
	else if (default_language_code == "hi") { var default_language_name = "Hindi"; }
	else if (default_language_code == "hmn") { var default_language_name = "Hmong"; }
	else if (default_language_code == "hu") { var default_language_name = "Hungarian"; }
	else if (default_language_code == "is") { var default_language_name = "Icelandic"; }
	else if (default_language_code == "id") { var default_language_name = "Indonesian"; }
	else if (default_language_code == "ga") { var default_language_name = "Irish"; }
	else if (default_language_code == "ja") { var default_language_name = "Japanese"; }
	else if (default_language_code == "jw") { var default_language_name = "Javanese"; }
	else if (default_language_code == "kn") { var default_language_name = "Kannada"; }
	else if (default_language_code == "km") { var default_language_name = "Khmer"; }
	else if (default_language_code == "ko") { var default_language_name = "Korean"; }
	else if (default_language_code == "lo") { var default_language_name = "Lao"; }
	else if (default_language_code == "la") { var default_language_name = "Latin"; }
	else if (default_language_code == "lv") { var default_language_name = "Latvian"; }
	else if (default_language_code == "lt") { var default_language_name = "Lithuanian"; }
	else if (default_language_code == "mk") { var default_language_name = "Macedonian"; }
	else if (default_language_code == "ms") { var default_language_name = "Malay"; }
	else if (default_language_code == "mt") { var default_language_name = "Maltese"; }
	else if (default_language_code == "mr") { var default_language_name = "Marathi"; }
	else if (default_language_code == "no") { var default_language_name = "Norwegian"; }
	else if (default_language_code == "fa") { var default_language_name = "Persian"; }
	else if (default_language_code == "pl") { var default_language_name = "Polish"; }
	else if (default_language_code == "ro") { var default_language_name = "Russian"; }
	else if (default_language_code == "sr") { var default_language_name = "Serbian"; }
	else if (default_language_code == "sk") { var default_language_name = "Slovak"; }
	else if (default_language_code == "sl") { var default_language_name = "Slovenian"; }
	else if (default_language_code == "sw") { var default_language_name = "Swahili"; }
	else if (default_language_code == "sv") { var default_language_name = "Swedish"; }
	else if (default_language_code == "ta") { var default_language_name = "Tamil"; }
	else if (default_language_code == "te") { var default_language_name = "Telugu"; }
	else if (default_language_code == "th") { var default_language_name = "Thai"; }
	else if (default_language_code == "tr") { var default_language_name = "Turkish"; }
	else if (default_language_code == "uk") { var default_language_name = "Ukranian"; }
	else if (default_language_code == "ur") { var default_language_name = "Urdu"; }
	else if (default_language_code == "vi") { var default_language_name = "Vietnamese"; }
	else if (default_language_code == "cy") { var default_language_name = "Welsh"; }
	else if (default_language_code == "yi") { var default_language_name = "Yiddish"; }
	else if (default_language_code == "de") { var default_language_name = "German"; }
	else if (default_language_code == "es") { var default_language_name = "Spanish"; }
	else if (default_language_code == "it") { var default_language_name = "Italian"; }
	else if (default_language_code == "da") { var default_language_name = "Danish"; }
	else if (default_language_code == "fr") { var default_language_name = "French"; }
	else if (default_language_code == "el") { var default_language_name = "Greek"; }
	else if (default_language_code == "nl") { var default_language_name = "Dutch"; }
	else if (default_language_code == "pt") { var default_language_name = "Portuguese"; }
	else if (default_language_code == "ru") { var default_language_name = "Russian"; }
	else if (default_language_code == "yo") { var default_language_name = "Yoruba"; }
	else if (default_language_code == "zu") { var default_language_name = "Zulu"; }

	$.cookie("language_name",default_language_name); //checked	 

	var language_name = $.cookie("language_name");
	var english_flag_choice = "<?php echo get_option('googlelanguagetranslator_english_flag_choice'); ?>";
        var spanish_flag_choice = "<?php echo get_option('googlelanguagetranslator_spanish_flag_choice'); ?>";
        var portuguese_flag_choice = "<?php echo get_option('googlelanguagetranslator_portuguese_flag_choice'); ?>";
        var language_name_flag = language_name;

	if ( language_name == "English" && english_flag_choice == 'canadian_flag') {
	  var language_name_flag = 'canada';
	}
	if ( language_name == "English" && english_flag_choice == 'us_flag') {
          var language_name_flag = 'united-states';
	}
	if ( language_name == "Spanish" && spanish_flag_choice == 'mexican_flag') {
	  var language_name_flag = 'mexico';
	}
	if ( language_name == "Portuguese" && portuguese_flag_choice == 'brazilian_flag') {
	  var language_name_flag = 'brazil';
	}
        $(".selected").html( "<a class='notranslate' title='" + language_name + "' href='#'><span class='flag size16 "+language_name_flag+"'></span>" + language_name + "</a>");
      } //typeof		   
    }); //function
	      
    $("a.flag, a.nturl").on('click',function() {	
      $.removeCookie("language_name");
      $.cookie("language_name", $(this).attr("title"));
      default_lang = "<?php echo get_option('googlelanguagetranslator_language'); ?>";
      lang_prefix = $(this).attr("class").split(" ")[2];
      var lang_attribute = "<?php echo get_option('googlelanguagetranslator_lang_urls'); ?>";
      var language_name = $(this).attr("title");
      var is_admin = "<?php echo is_admin(); ?>";
      var english_flag_choice = "<?php echo get_option('googlelanguagetranslator_english_flag_choice'); ?>";
      var spanish_flag_choice = "<?php echo get_option('googlelanguagetranslator_spanish_flag_choice'); ?>";
      var portuguese_flag_choice = "<?php echo get_option('googlelanguagetranslator_portuguese_flag_choice'); ?>";
      var language_name_flag = language_name;

      if ( language_name == "English" && english_flag_choice == 'canadian_flag') {
        var language_name_flag = 'canada';
      }
      if ( language_name == "English" && english_flag_choice == 'us_flag') {
        var language_name_flag = 'united-states';
      }
      if ( language_name == "Spanish" && spanish_flag_choice == 'mexican_flag') {
        var language_name_flag = 'mexico';
      }
      if ( language_name == "Portuguese" && portuguese_flag_choice == 'brazilian_flag') {
	var language_name_flag = 'brazil';
      }

      if (lang_attribute == 'no') {
        var language_name = $.cookie("language_name");
	$("#language.auto-language-translation .selected").html( "<a class='notranslate' title='" + language_name + "' href='#'><span class='flag size16 "+language_name_flag+"'></span>" + language_name + "</a>");
      }
    }); //a.flag 

    <?php if ($url_language_prefix == '' || $cookie_value == '/'.$default_language_code.'/'.$default_language_code.'') { ?>
    var default_language_code = "<?php echo get_option('googlelanguagetranslator_language'); ?>";
    var lang = GetURLParameter('lang');
    var googtrans = $.cookie("googtrans");

    function GetURLParameter(sParam) {
      var sPageURL = window.location.search.substring(1);
      var sURLVariables = sPageURL.split('&');

      for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
          return sParameterName[1];
        } else {
          return 'undefined';
        } //endif
      } //for
    } //function

    $(function() {
      var language_name = $.cookie("language_name");
      var flag_url = $.cookie("flag_url");
      var english_flag_choice = "<?php echo get_option('googlelanguagetranslator_english_flag_choice'); ?>";
      var spanish_flag_choice = "<?php echo get_option('googlelanguagetranslator_spanish_flag_choice'); ?>";
      var portuguese_flag_choice = "<?php echo get_option('googlelanguagetranslator_portuguese_flag_choice'); ?>";
      var language_name_flag = language_name;

      if ( language_name == "English" && english_flag_choice == 'canadian_flag') {
        var language_name_flag = 'canada';
      }
      if ( language_name == "English" && english_flag_choice == 'us_flag') {
        var language_name_flag = 'united-states';
      }
      if ( language_name == "Spanish" && spanish_flag_choice == 'mexican_flag') {
        var language_name_flag = 'mexico';
      }
      if ( language_name == "Portuguese" && portuguese_flag_choice == 'brazilian_flag') {
	var language_name_flag = 'brazil';
      }
      $("div.selected").html("<a class='notranslate' title='" + language_name + "' href='#'><span class='flag size16 "+language_name_flag+"'></span>" + language_name + "</a>");
    }); //function
    <?php } //endif; ?>
  }); //jQuery
</script>

<?php

foreach($this->languages_array as $key => $value):
  $language_code = $key;
  $language_name = $value;

  if ($url_language_prefix == $default_language_code): ?>
  <script type="text/javascript" async="async">
  jQuery(document).ready(function($) {
      var language_name = "<?php echo $language_name; ?>";
      var language_code = "<?php echo $language_code; ?>";
      var lang = GetURLParameter("lang");
      var googtrans = $.cookie("googtrans");
      var default_language = "<?php echo get_option('googlelanguagetranslator_language'); ?>";
      var lang_prefix = $("a." + language_code ").attr("class").split(" ")[2];

      $.cookie("language_name", language_name);

        function GetURLParameter(sParam) {
          var sPageURL = window.location.search.substring(1);
          var sURLVariables = sPageURL.split("&");

          for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split("=");
            if (sParameterName[0] == sParam) {
              return sParameterName[1];
            }
          } //for
        } //function

        if (lang && lang == language_code) {
          $("a").not("a.flag,a.nturl").each(function() {
            $(this).attr("href", function() {
              var language_name = "<?php echo $language_name; ?>";
              var language_code = "<?php echo $language_code; ?>";
              return this.href.split("?")[0] + "?lang=" + language_code ";
            }); //attr
          }); //a.flag
        } //if

        $(function() {
          var language_name = $.cookie("language_name");
          var flag_url = $.cookie("flag_url");
          var english_flag_choice = "'.get_option('googlelanguagetranslator_english_flag_choice').'";
          var spanish_flag_choice = "'.get_option('googlelanguagetranslator_spanish_flag_choice').'";
          var portuguese_flag_choice = "'.get_option('googlelanguagetranslator_portuguese_flag_choice').'";
          var language_name_flag = language_name;
          var homeurl = "<?php echo home_url(); ?>";

          if (language_name == "English" && english_flag_choice == "canadian_flag") {
            var language_name_flag = "canada";
          }
          if (language_name == "English" && english_flag_choice == "us_flag") {
            var language_name_flag = "united-states";
          }
          if (language_name == "Spanish" && spanish_flag_choice == "mexican_flag") {
            var language_name_flag = "mexico";
          }
          if (language_name == "Portuguese" && portuguese_flag_choice == "brazilian_flag") {
            var language_name_flag = "brazil";
          }
          $("div.selected").html("<a class='notranslate' title='" + language_name + "'><span class='flag size16 " + language_name_flag + "'></span>" + language_name + "</a>");
        }); //function
      }); //jQuery 
    </script>

    <?php else : if ($url_language_prefix == $language_code): ?>
      <script type="text/javascript" async="async">
      jQuery(document).ready(function($) {
        var language_name = "<?php echo $language_name; ?>";
        var language_code = "<?php echo $language_code; ?>";
        var lang = GetURLParameter("lang");
        var googtrans = $.cookie("googtrans");
        var default_language = "<?php echo get_option('googlelanguagetranslator_language'); ?>";
        var lang_prefix = $("a.flag." + language_code).attr("class").split(" ")[2];
        
        if (googtrans != "/"+default_language+"/"+language_code) {
          setTimeout(function() { $('.flag.' + lang).trigger('click'); }, 500); 
        }

        $.cookie("language_name", language_name);

        function GetURLParameter(sParam) {
          var sPageURL = window.location.search.substring(1);
          var sURLVariables = sPageURL.split("&");
          for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split("=");
            if (sParameterName[0] == sParam) {
              return sParameterName[1];
            }
          }
        }

        if (lang && lang == language_code) {
          $("a").not("a.flag,a.nturl").each(function() {
            $(this).attr("href", function() {
              var language_name = "<?php echo $language_name; ?>";
              var language_code = "<?php echo $language_code; ?>";
              return this.href.split("?")[0] + "?lang=" + language_code;
            });
          });
        }

        $(function() {
          var language_name = $.cookie("language_name");
          var english_flag_choice = "<?php echo get_option('googlelanguagetranslator_english_flag_choice'); ?>";
          var spanish_flag_choice = "<?php echo get_option('googlelanguagetranslator_spanish_flag_choice'); ?>";
          var portuguese_flag_choice = "<?php echo get_option('googlelanguagetranslator_portuguese_flag_choice'); ?>";
          var language_name_flag = language_name;

          if (language_name == "English" && english_flag_choice == "canadian_flag") {
            var language_name_flag = "canada";
          }
          if (language_name == "English" && english_flag_choice == "us_flag") {
            var language_name_flag = "united-states";
          }
          if (language_name == "Spanish" && spanish_flag_choice == "mexican_flag") {
            var language_name_flag = "mexico";
          }
          if (language_name == "Portuguese" && portuguese_flag_choice == "brazilian_flag") {
            var language_name_flag = "brazil";
          }
          $("div.selected").html("<a class='notranslate' title='" + language_name + "'><span class='flag size16 " + language_name_flag + "'></span>" + language_name + "</a>");
        });
      }); 
</script> 

<?php endif; endif; endforeach; ?>