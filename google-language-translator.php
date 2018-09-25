<?php

/*
Plugin Name: Google Language Translator Premium
Version: 5.0.35
Plugin URI: http://www.wp-studio.net/
Description: The MOST SIMPLE Google Translator plugin.  This plugin adds Google Translator to your website by using a single shortcode, [google-translator]. Settings include: layout style, hide/show specific languages, hide/show Google toolbar, and hide/show Google branding. Add the shortcode to pages, posts, and widgets.
Author: Rob Myrick
Author URI: http://www.wp-studio.net/
*/

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include( plugin_dir_path( __FILE__ ) . 'widget.php');

class google_language_translator_premium {

  public $languages_array;
  
  public function __construct() {

    $this->languages_array = array (
      'af' => 'Afrikaans',
      'sq' => 'Albanian',
      'am' => 'Amharic',
      'ar' => 'Arabic',
      'hy' => 'Armenian',
      'az' => 'Azerbaijani',
      'eu' => 'Basque',
      'be' => 'Belarusian',
      'bn' => 'Bengali',
      'bs' => 'Bosnian',
      'bg' => 'Bulgarian',
      'ca' => 'Catalan',
      'ceb' => 'Cebuano',
      'ny' => 'Chichewa',
      'zh-CN' => 'Chinese (Simplified)',
      'zh-TW' => 'Chinese (Traditional)',
      'co' => 'Corsican',
      'hr' => 'Croatian',
      'cs' => 'Czech',
      'da' => 'Danish',
      'nl' => 'Dutch',
      'en' => 'English',
      'eo' => 'Esperanto',
      'et' => 'Estonian',
      'tl' => 'Filipino',
      'fi' => 'Finnish',
      'fr' => 'French',
      'fy' => 'Frisian',
      'gl' => 'Galician',
      'ka' => 'Georgian',
      'de' => 'German',
      'el' => 'Greek',
      'gu' => 'Gujarati',
      'ht' => 'Haitian',
      'ha' => 'Hausa',
      'haw' => 'Hawaiian',
      'iw' => 'Hebrew',
      'hi' => 'Hindi',
      'hmn' => 'Hmong',
      'hu' => 'Hungarian',
      'is' => 'Icelandic',
      'ig' => 'Igbo',
      'id' => 'Indonesian',
      'ga' => 'Irish',
      'it' => 'Italian',
      'ja' => 'Japanese',
      'jw' => 'Javanese',
      'kn' => 'Kannada',
      'kk' => 'Kazakh',
      'km' => 'Khmer',
      'ko' => 'Korean',
      'ku' => 'Kurdish',
      'ky' => 'Kyrgyz',
      'lo' => 'Lao',
      'la' => 'Latin',
      'lv' => 'Latvian',
      'lt' => 'Lithuanian',
      'lb' => 'Luxembourgish',
      'mk' => 'Macedonian',
      'mg' => 'Malagasy',
      'ml' => 'Malayalam',
      'ms' => 'Malay',
      'mt' => 'Maltese',
      'mi' => 'Maori',
      'mr' => 'Marathi',
      'mn' => 'Mongolian',
      'my' => 'Myanmar (Burmese)',
      'ne' => 'Nepali',
      'no' => 'Norwegian',
      'ps' => 'Pashto',
      'fa' => 'Persian',
      'pl' => 'Polish',
      'pt' => 'Portuguese',
      'pa' => 'Punjabi',
      'ro' => 'Romanian',
      'ru' => 'Russian',
      'sr' => 'Serbian',
      'sn' => 'Shona',
      'st' => 'Sesotho',
      'sd' => 'Sindhi',
      'si' => 'Sinhala',
      'sk' => 'Slovak',
      'sl' => 'Slovenian',
      'sm' => 'Samoan',
      'gd' => 'Scots Gaelic',
      'so' => 'Somali',
      'es' => 'Spanish',
      'su' => 'Sundanese',
      'sw' => 'Swahili',
      'sv' => 'Swedish',
      'tg' => 'Tajik',
      'ta' => 'Tamil',
      'te' => 'Telugu',
      'th' => 'Thai',
      'tr' => 'Turkish',
      'uk' => 'Ukrainian',
      'ur' => 'Urdu',
      'uz' => 'Uzbek',
      'vi' => 'Vietnamese',
      'cy' => 'Welsh',
      'xh' => 'Xhosa',
      'yi' => 'Yiddish',
      'yo' => 'Yoruba',
      'zu' => 'Zulu',
    );

    define ('PLUGIN_VER', '5.0.35');
    add_action( 'admin_menu', array( &$this, 'add_my_admin_menus')); 
    add_action('admin_menu', array( &$this, 'test_add_my_admin_menus'));
    add_action('admin_enqueue_scripts', array( &$this, 'load_edit_screen_scripts'));
    add_action('admin_init',array(&$this, 'initialize_settings')); 
    add_action('wp_head',array(&$this, 'load_css'));
    add_action('wp_footer',array(&$this, 'footer_script'));
    add_action('add_meta_boxes',array(&$this, 'add_page_post_meta_box'));
    add_shortcode( 'google-translator',array(&$this, 'google_translator_shortcode'));
    add_shortcode( 'glt', array(&$this, 'google_translator_menu_language'));
    add_filter('widget_text','do_shortcode');
    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'glt_settings_link') );
    add_action( 'save_post', array( &$this, 'save_meta_box' ) );
    add_action( 'init', array( &$this, 'add_menu_page_languages') );
    add_action( 'init', array( &$this, 'implement_update_manual_translation_meta' ) );
    add_filter( 'the_content', array(&$this,'googlelanguagetranslator_manual_language_switcher') );
    add_action( 'init', array( &$this, 'preferred_language') );
	
    if (!is_admin()) {
      add_action('init',array(&$this, 'flags'));
    }
	
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');
	
    if ($manual_is_active == 1) {
      add_filter( 'template_include', array( &$this, 'glt_locate_template' ) );
    }
	
    if ($manual_is_active != 1) {
      add_filter('walker_nav_menu_start_el', array(&$this,'menu_shortcodes') , 10 , 2);
    }
  }
  
  public function glt_activate() {
    delete_option('googlelanguagetranslator_manage_translations');
    add_option('googlelanguagetranslator_active', 1);   
    add_option('googlelanguagetranslator_language','en');
    add_option('googlelanguagetranslator_language_option','all');
    add_option('googlelanguagetranslator_flags','show_flags');
    add_option('language_display_settings',array ('en' => 1));
    add_option('flag_display_settings',array ('flag-en' => 1)); 
    add_option('googlelanguagetranslator_translatebox','yes'); 
    add_option('googlelanguagetranslator_display','Vertical'); 
    add_option('googlelanguagetranslator_toolbar','Yes'); 
    add_option('googlelanguagetranslator_showbranding','Yes'); 
    add_option('googlelanguagetranslator_flags_alignment','flags_left');   
    add_option('googlelanguagetranslator_analytics',0);  
    add_option('googlelanguagetranslator_analytics_id','');
    add_option('googlelanguagetranslator_css','');
    add_option('googlelanguagetranslator_multilanguage',0);
    add_option('googlelanguagetranslator_floating_widget','yes');
    add_option('googlelanguagetranslator_flag_size','18');
    add_option('googlelanguagetranslator_flags_order','');
    add_option('googlelanguagetranslator_languagebox_width','');
    add_option('googlelanguagetranslator_flagarea_width','');
    add_option('googlelanguagetranslator_theme_style','elegant');
    add_option('googlelanguagetranslator_languagebox_flags','show_flags');
    add_option('googlelanguagetranslator_english_flag_choice','');
    add_option('googlelanguagetranslator_spanish_flag_choice','');
    add_option('googlelanguagetranslator_portuguese_flag_choice','');
    add_option('googlelanguagetranslator_lang_urls','no');
    add_option('googlelanguagetranslator_activate_manual_language',0);
    add_option('googlelanguagetranslator_browser_language_detection',0);
  } 
  
  public function glt_deactivate() {
    delete_option('googlelanguagetranslator_active');   
    delete_option('googlelanguagetranslator_language');
    delete_option('googlelanguagetranslator_language_option');
    delete_option('googlelanguagetranslator_flags');
    delete_option('language_display_settings');
    delete_option('flag_display_settings'); 
    delete_option('googlelanguagetranslator_translatebox'); 
    delete_option('googlelanguagetranslator_display'); 
    delete_option('googlelanguagetranslator_toolbar'); 
    delete_option('googlelanguagetranslator_showbranding'); 
    delete_option('googlelanguagetranslator_flags_alignment');   
    delete_option('googlelanguagetranslator_manage_translations');
    delete_option('googlelanguagetranslator_multilanguage');
    delete_option('googlelanguagetranslator_floating_widget');
    delete_option('googlelanguagetranslator_flag_size');
    delete_option('googlelanguagetranslator_flags_order');
    delete_option('googlelanguagetranslator_languagebox_width');
    delete_option('googlelanguagetranslator_flagarea_width');
    delete_option('googlelanguagetranslator_theme_style');
    delete_option('googlelanguagetranslator_languagebox_flags');
    delete_option('googlelanguagetranslator_english_flag_choice');
    delete_option('googlelanguagetranslator_spanish_flag_choice');
    delete_option('googlelanguagetranslator_portuguese_flag_choice');
    delete_option('googlelanguagetranslator_lang_urls');
  }

  public function glt_locate_template( $template ) {
    $post_id = get_the_ID();
    $is_active = get_option('googlelanguagetranslator_active');
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');
    $option_name = 'googlelanguagetranslator_manual_language_display_settings';
    $get_manual_language_choices = get_option (''.$option_name.'');

    foreach ($this->languages_array as $key => $value) {
      $language_code = $key;
      $language_name = $value;
      $language_code_array[] = $key;
		
      if (!isset($get_manual_language_choices[''.$language_code.''])) {
	$get_manual_language_choices[''.$language_code.''] = 0;
      }

      $items[] = $get_manual_language_choices[''.$language_code.''];
      $language_codes = $language_code_array;

      if ($get_manual_language_choices[''.$language_code.''] == 1 && $manual_is_active == 1 && $language_code != $default_language_code) {
        $active_languages[] = $language_code;
      }
    } //endforeach

    if ( !in_array (get_post_type( $post_id ), $active_languages) ) {
      return $template;
    } 
 
    if ( is_single() ) { 
      return $this->glt_get_template_hierarchy( 'single' );
    }
  }

  public function glt_get_template_hierarchy( $template ) {
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';

    if ( $theme_file = locate_template( array( 'translation/' . $template ) ) ) {
        $file = $theme_file;
    } else {
        $file = get_stylesheet_directory() . '/' . $template;
    }
    return $file;
  }

  public function glt_settings_link ( $links ) {
    $settings_link = array(
      '<a href="' . admin_url( 'options-general.php?page=google_language_translator_premium' ) . '">Settings</a>',
    );
    return array_merge( $links, $settings_link );
  }

  public function test_add_my_admin_menus() {
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');
	
    if ($manual_is_active == 1):
      add_menu_page('Languages', 'Languages', 'manage_options', 'languages', array(&$this, 'page_layout_cb'),'dashicons-translation',99);
    endif;
	
    $license_key_option = get_option('googlelanguagetranslator_license_key');

    add_submenu_page(null, 'Manage Languages', 'Manage Languages', 'manage_options', 'manual_translation_module', array(&$this, 'manual_translation_module_page_layout_cb'));
    add_submenu_page(null, 'About Wordpress Translation', 'About Wordpress Translation', 'manage_options', 'about_wordpress_translation', array(&$this, 'about_wordpress_translation_page_layout_cb'));
    add_submenu_page(null, 'License', 'License', 'manage_options', 'license', array(&$this, 'license_layout_cb'));
    
  }
  
  public function add_my_admin_menus() {
    $p = add_options_page('Google Language Translator Premium', 'Google Language Translator Premium', 'manage_options', 'google_language_translator_premium', array(&$this, 'page_layout_cb'));
    
    add_action( 'load-' . $p, array(&$this, 'load_admin_js' ));
  }

  public function load_edit_screen_scripts() {
    wp_enqueue_script( 'cookie-js', plugins_url('js/cookie.js',__FILE__), array('jquery'), PLUGIN_VER);
    wp_enqueue_style( 'edit-screen-styles', plugins_url('css/style-edit-screen.css',__FILE__),'', PLUGIN_VER);
  }
  
  public function load_admin_js(){
    add_action( 'admin_enqueue_scripts', array(&$this, 'enqueue_admin_js' ));
    add_action('admin_footer',array(&$this, 'footer_script'));
    add_action('admin_head',array(&$this, 'load_css'));
    add_action('admin_head',array(&$this, 'add_menu_page_languages'));
  }
  
  public function enqueue_admin_js(){
    wp_enqueue_script( 'admin-script', plugins_url('js/admin.js',__FILE__), array('jquery'), PLUGIN_VER);
    wp_enqueue_script( 'flag-script', plugins_url('js/load-flags.js',__FILE__), array('jquery'), PLUGIN_VER);
    wp_enqueue_script( 'load-selectbox-script', plugins_url('js/load-selectbox.js',__FILE__), array('jquery'), PLUGIN_VER);
		
    if (get_option ('googlelanguagetranslator_floating_widget') == 'yes') {
      wp_enqueue_script( 'glt-toolbar', plugins_url('js/load-toolbar.js',__FILE__), array('jquery'), PLUGIN_VER);
      wp_enqueue_style( 'glt-toolbar-styles', plugins_url('css/toolbar.css', __FILE__),'', PLUGIN_VER );
    }
		
    wp_enqueue_script( 'jquery-ui' );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'load-flags', plugins_url('js/load-flags.js',__FILE__), array('jquery'), PLUGIN_VER);
    wp_enqueue_style( 'google-language-translator', plugins_url('css/style.css', __FILE__),'', PLUGIN_VER );
  }
  
  public function add_page_post_meta_box() {
    global $post;
    $is_active = get_option('googlelanguagetranslator_active');
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');
    if ($is_active == 0 && $manual_is_active == 1):
      $screens = array('page','post');
      foreach ($screens as $screen):
        add_meta_box(
          'Manual Translation Setting',
	  '<div class="notranslate" style="display:inline">Manual Translation Setting</div>',
	  array( &$this, 'render_translation_meta_box' ),
	  $screen,
	  'side',
	  'high'
        );
      endforeach;
    endif;
  }
  
  public function add_custom_post_type_meta_boxes() {
    $is_active = get_option('googlelanguagetranslator_active');
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');
    $option_name = 'googlelanguagetranslator_manual_language_display_settings';
    $get_manual_language_choices = get_option (''.$option_name.'');
	
    if ($manual_is_active == 1 && $is_active == 0):

    foreach ($this->languages_array as $key => $value) {
      $language_code = $key;
      $language_name = $value;
      $language_code_array[] = $key;
      $items[] = $get_manual_language_choices[''.$language_code.''];
      $language_codes = $language_code_array;

      if ($get_manual_language_choices[''.$language_code.''] == 1):
        add_meta_box(
	  'translation-workspace',
          '<div class="notranslate" style="display:inline">Translation Workspace</div>',
	  array( &$this, 'render_meta_box_content' ),
	  $language_code,
	  'advanced',
	  'high'
        );
	  
	add_meta_box(
          'Manual Translation Setting',
	  '<div class="notranslate" style="display:inline">Manual Translation Setting</div>',
	  array( &$this, 'render_translation_meta_box' ),
	  $language_code,
	  'side',
	  'high'
	);
	endif;
	}
	endif;
  }

  public function save_meta_box($post) { 
    global $post;
	
    if(isset($_POST["show_manual_language_switcher"])){
      $meta_element_class = $_POST['show_manual_language_switcher'];
       update_post_meta($post->ID, 'show_manual_language_switcher', $meta_element_class);
    }
	
  } 
 
  public function render_translation_meta_box($object) {
    $is_active = get_option('googlelanguagetranslator_active');
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');

    if ($is_active == 0 && $manual_is_active == 1):
	
      wp_nonce_field( basename( __FILE__ ), 'show_manual_language_switcher_nonce' ); 

      $show_manual_language_switcher = get_post_meta(get_the_ID(), 'show_manual_language_switcher', true); ?>

      <select id="show_manual_language_switcher" name="show_manual_language_switcher">
        <option value="on" <?php if ($show_manual_language_switcher == "on") { echo 'selected="selected"'; } ?>>Show language switcher</option>
        <option value="off" <?php if ($show_manual_language_switcher == "off") { echo 'selected="selected"'; } ?>>Hide the language switcher</option>
      </select>

      <?php  
    endif;
  }

  public function implement_update_manual_translation_meta() {
    $posts = get_posts('post_status=publish');
      foreach($posts as $post):
        $show_manual_language_switcher = get_post_meta($post->ID, 'show_manual_language_switcher', true);
        if ( empty ($show_manual_language_switcher) ): 
          add_post_meta($post->ID, 'show_manual_language_switcher','on',true);
          update_post_meta($post->ID, 'show_manual_language_switcher', 'on'); 
        endif;
      endforeach;
  }

  public function render_meta_box_content() { 
    $str = '';
    $str.= '<div id="translation-workspace" class="notranslate"><strong>Use the widget toll below to translate text from the text editor above:</strong><br/><ol><li>Copy/paste your UN-TRANSLATED content into the text editor above</li><li>Save changes (click "Update"). You should now see your content in the area below</li><li>Use the translation widget to auto-translate your text immediately</li><li>Copy/paste your translate content below, into the text editor above</li><li>Save again</li></ol></div>';
    echo $str; ?>
    <div id="google_translate_element"></div><script type="text/javascript" async="async">
      function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en', autoDisplay: false}, 'google_translate_element');
      }
</script><script type="text/javascript" async="async" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

  <br/>

  <?php
    $page_id = get_the_ID();
    $page_object = get_page( $page_id );
      echo $page_object->post_content;
      echo '<div class="translated-content">'.the_content().'</div>'; 
  }

  public function flags() {
    wp_enqueue_script( 'flags', plugins_url('js/load-flags.js',__FILE__), array('jquery'), PLUGIN_VER);
    wp_enqueue_script( 'load-selectbox-script', plugins_url('js/load-selectbox.js',__FILE__), array('jquery'), PLUGIN_VER);
    wp_enqueue_script( 'load-edits', plugins_url('js/load-edits.js',__FILE__), array('jquery'), PLUGIN_VER);
    wp_enqueue_script( 'cookie-js', plugins_url('js/cookie.js',__FILE__), array('jquery'), PLUGIN_VER);
	
    if (get_option ('googlelanguagetranslator_floating_widget') == 'yes') {
      wp_enqueue_script( 'glt-toolbar', plugins_url('js/load-toolbar.js',__FILE__), array('jquery'), PLUGIN_VER);
      wp_enqueue_style( 'glt-toolbar-styles', plugins_url('css/toolbar.css', __FILE__),'', PLUGIN_VER );
    }
	 
    wp_enqueue_style( 'google-language-translator', plugins_url('css/style.css', __FILE__),'', PLUGIN_VER );
  }

  public function load_css() {
	include( plugin_dir_path( __FILE__ ) . 'css/style.php');
  }  

  function preferred_language () {

  $browser_language_detection_active = get_option('googlelanguagetranslator_browser_language_detection');

  if ($browser_language_detection_active == 1):
	
	$browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
	
	if (!empty($get_http_accept_language)):
	  $get_http_accept_language = explode(",",$browser_lang);
	else:
	  $get_http_accept_language = explode(",",$browser_lang);
	endif;
	
  $bestlang = $get_http_accept_language[0];
  $bestlang_prefix = substr($get_http_accept_language[0],0,2); 

    if (empty($_COOKIE['googtrans']) ) {
	  if ( get_option('googlelanguagetranslator_language') != $bestlang_prefix ) {
      switch ($bestlang) {
		case 'af': //Afrikaans
          if ($bestlang == 'af') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|af'); } </script>
        <?php	
          }
        break;
		
		case 'sq': //Albanian
          if ($bestlang == 'sq') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|sq'); } </script>
        <?php	
          }
        break;
		
		case 'ar': //Arabic
          if ($bestlang == 'ar') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ar'); } </script>
        <?php	
          }
        break;
		
		case 'hy': //Armenian
          if ($bestlang == 'hy') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|hy'); } </script>
        <?php	
          }
        break;
		
		case 'az': //Azerbaijani
          if ($bestlang == 'az') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|az'); } </script>
        <?php	
          }
        break;  
		
		case 'eu': //Basque
          if ($bestlang == 'eu') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|eu'); } </script>
        <?php	
          }
        break;  
		
		case 'be': //Belarusian
          if ($bestlang == 'be') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|be'); } </script>
        <?php	
          }
        break; 
		
		case 'bg': //Bulgarian
          if ($bestlang == 'bg') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|bg'); } </script>
        <?php	
          }
        break;  
		
		case 'bn':  //Bengali
          if ($bestlang == 'bn') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|bn'); } </script>
        <?php	
          }
        break;
		
		case 'bs': //Bosnian
          if ($bestlang == 'bs') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|bs'); } </script>
        <?php	
          }
        break;
		
		case 'ca': //Catalan
          if ($bestlang == 'ca') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ca'); } </script>
        <?php	
          }
        break;
	
	        case 'zh': //Chinese
          if ($bestlang == 'zh') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|zh-CN'); } </script>
        <?php	
          }
        break;
		
		case 'zh-hans': //Chinese(Hans)
          if ($bestlang == 'zh') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|zh-CN'); } </script>
        <?php	
          }
        break;
		
		case 'zh-CN': //Chinese(Simplified Han)
          if ($bestlang == 'zh-CN') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|zh-CN'); } </script>
        <?php	
          }
        break;
		
		case 'zh-TW': //Chinese(Traditional Han)
          if ($bestlang == 'zh-TW') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|zh-TW'); } </script>
        <?php	
          }
        break;
		
		case 'hr': //Croatian
          if ($bestlang == 'hr') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|hr'); } </script>
        <?php	
          }
        break;
		
		case 'cs': //Czech
          if ($bestlang == 'cs') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|cs'); } </script>
        <?php	
          }
        break;
		
		case 'da': //Danish
          if ($bestlang == 'da') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|da'); } </script>
        <?php	
          }
        break;
		
		case 'gu': //Gujarati
          if ($bestlang == 'gu') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|gu'); } </script>
        <?php	
          }
        break;
		
	        case 'nl': //Dutch
          if ($bestlang == 'nl') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|nl'); } </script>
        <?php	
          }
        break;
		
	        case 'en': //English
          if ($bestlang == 'en') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|en'); } </script>
        <?php	
          }
        break;
		
		case 'en-GB': //English (Great Britain)
          if ($bestlang == 'en-GB' || $bestlang == 'en-US') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|en'); } </script>
        <?php	
          }
        break;
		
		case 'en-US': //English
          if ($bestlang == 'en-US') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|en'); } </script>
        <?php	
          }
        break;
		
		case 'et': //Estonian
          if ($bestlang == 'et') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|et'); } </script>
        <?php	
          }
        break;
		
		case 'fil': //Filipino
          if ($bestlang == 'fil') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|tl'); } </script>
        <?php	
          }
        break;
		
		case 'fi': //Finnish
          if ($bestlang == 'fi') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|fi'); } </script>
        <?php	
          }
        break;
		
		case 'fr': //French
          if ($bestlang == 'fr') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|fr'); } </script>
        <?php	
          }
        break;
		
		case 'gl': //Galician
          if ($bestlang == 'gl') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|gl'); } </script>
        <?php	
          }
        break;
		
		case 'ka': //Georgian
          if ($bestlang == 'ka') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ka'); } </script>
        <?php	
          }
        break;
		
		case 'de': //German
          if ($bestlang == 'de') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|de'); }</script><script>jQuery(document).ready(function($) { $.cookie('language_name','German'); }); </script>
        <?php	
          }
        break;
		
		case 'el': //Greek
          if ($bestlang == 'el') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|el'); } </script>
        <?php	
          }
        break;
		
	        case 'ha': //Hausa
          if ($bestlang == 'ha') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ha'); } </script>
        <?php	
          }
        break;
		
		case 'he': //Hebrew
          if ($bestlang == 'he') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|iw'); } </script>
        <?php	
          }
        break;
		
		case 'jw': //Javanese
          if ($bestlang == 'jw') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|jw'); } </script>
        <?php	
          }
        break;
		
		case 'kn': //Kannada
          if ($bestlang == 'kn') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|kn'); } </script>
        <?php	
          }
        break;
		
		case 'hi': //Hindi
          if ($bestlang == 'hi') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|hi'); } </script>
        <?php	
          }
        break;
		
		case 'hu': //Hungarian
          if ($bestlang == 'hu') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|hu'); } </script>
        <?php	
          }
        break;
		
		case 'is': //Icelandic
          if ($bestlang == 'is') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|is'); } </script>
        <?php	
          }
        break;
		
		case 'id': //Indonesian
          if ($bestlang == 'id') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|id'); } </script>
        <?php	
          }
        break;
		
		case 'ga': //Irish
          if ($bestlang == 'ga') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ga'); } </script>
        <?php	
          }
        break;
		
		case 'it': //Italian
          if ($bestlang == 'it') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|it'); } </script>
        <?php	
          }
        break;
		
		case 'ja': //Japanese
          if ($bestlang == 'ja') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ja'); } </script>
        <?php	
          }
        break;
		
		case 'ko': //Korean
          if ($bestlang == 'ko') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ko'); } </script>
        <?php	
          }
        break;
		
		case 'km': //Khmer
          if ($bestlang == 'km') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|km'); } </script>
        <?php	
          }
        break;
		
		case 'lo': //Lao
          if ($bestlang == 'lo') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|lo'); } </script>
        <?php	
          }
        break;
		
		case 'lv': //Latvian
          if ($bestlang == 'lv') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|lv'); } </script>
        <?php	
          }
        break;
		
		case 'la': //Latin
          if ($bestlang == 'la') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|la'); } </script>
        <?php	
          }
        break;
		
		case 'lt': //Lithuanian
          if ($bestlang == 'lt') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|lt'); } </script>
        <?php	
          }
        break;
		
		case 'mr': //Marathi
          if ($bestlang == 'mr') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|mr'); } </script>
        <?php	
          }
        break;
		
		case 'mk': //Macedonian
          if ($bestlang == 'mk') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|mk'); } </script>
        <?php	
          }
        break;
		
		case 'ms': //Malay
          if ($bestlang == 'ms') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ms'); } </script>
        <?php	
          }
        break;
		
		case 'mt': //Maltese
          if ($bestlang == 'mt') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|mt'); } </script>
        <?php	
          }
        break;
		
		case 'no': //Norwegian
          if ($bestlang == 'no') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|no'); } </script>
        <?php	
          }
        break;
		
		case 'nb': //Norwegian Bokmal
          if ($bestlang == 'nb') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|no'); } </script>
        <?php	
          }
        break;
		
		case 'fa': //Persian
          if ($bestlang == 'fa') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|fa'); } </script>
        <?php	
          }
        break;
		
		case 'pl':  //Polish
          if ($bestlang == 'pl') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|pl'); } </script>
        <?php	
          }
        break;
		
		case 'pt': //Portuguese
          if ($bestlang == 'pt') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|pt'); } </script>
        <?php	
          }
        break;
		
		case 'pt-BR': //Brazilian Portugues
          if ($bestlang == 'pt-BR') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|pt'); } </script>
        <?php	
          }
        break;
		
		case 'ro': //Romanian
          if ($bestlang == 'ro') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ro'); } </script>
        <?php	
          }
        break;
		
		case 'ru': //Russian
          if ($bestlang == 'ru') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ru'); } </script>
        <?php	
          }
        break;
		
		case 'sr': //Serbian
          if ($bestlang == 'sr') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|sr'); } </script>
        <?php	
          }
        break;
		
		case 'sk': //Slovak
          if ($bestlang == 'sk') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|sk'); } </script>
        <?php	
          }
        break;
		
		case 'sl': //Slovenian
          if ($bestlang == 'sl') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|sl'); } </script>
        <?php	
          }
        break;
		
		case 'eo': //Esperanto
          if ($bestlang == 'eo') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|eo'); } </script>
        <?php	
          }
        break;
	
		case 'es': //Spanish
          if ($bestlang == 'es') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|es'); } </script>
        <?php	
          }
        break;
		
		case 'sw': //Swahili
          if ($bestlang == 'sw') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|sw'); } </script>
        <?php	
          }
        break;


		case 'sv': //Swedish
          if ($bestlang == 'sv') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|sv'); } </script>
        <?php	
          }
        break;
		
		case 'ta': //Tamil
          if ($bestlang == 'ta') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ta'); } </script>
        <?php	
          }
        break;
		
		case 'te': //Telugu
          if ($bestlang == 'te') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|te'); } </script>
        <?php	
          }
        break;
		
		case 'th': //Thai
          if ($bestlang == 'th') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|th'); } </script>
        <?php	
          }
        break;
		
		case 'tr': //Turkish
          if ($bestlang == 'tr') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|tr'); } </script>
        <?php	
          }
        break;
		
		case 'uk': //Ukranian
          if ($bestlang == 'uk') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|uk'); } </script>
        <?php	
          }
        break;
		
		case 'ur': //Urdu
          if ($bestlang == 'ur') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|ur'); } </script>
        <?php	
          }
        break;
		
		case 'vi': //Vietnamesse
          if ($bestlang == 'vi') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|vi'); } </script>
        <?php	
          }
        break;
		
		case 'cy': //Welsh
          if ($bestlang == 'cy') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|cy'); } </script>
        <?php	
          }
        break;
		
		case 'yi': //Yiddish
          if ($bestlang == 'yi') { ?>
          <script type="text/javascript" async="async">window.onload = function() { doGoogleLanguageTranslator('<?php echo get_option('googlelanguagetranslator_language'); ?>|yi'); } </script>
        <?php	
          }
        break;
      };	
     }
   }
  endif;
  }

  public function google_translator_shortcode() {
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');
    $layout = get_option('googlelanguagetranslator_display');
	
    if (($layout == 'Vertical' || $layout == 'SIMPLE') && !$manual_is_active == 1){
      return $this->googlelanguagetranslator_vertical();
    }

    elseif($layout == 'Horizontal' && !$manual_is_active == 1){
      return $this->googlelanguagetranslator_horizontal();
    }
  }

  public function googlelanguagetranslator_included_languages() {
    if ( get_option('googlelanguagetranslator_language_option')=='specific') { 
	  $get_language_choices = get_option ('language_display_settings');
	  
	  foreach ($get_language_choices as $key=>$value) {
	    if($value == 1) {
		  $items[] = $key;
	    }
	  }
	  
	  $comma_separated = implode(",",array_values($items));
	  
	  if ( get_option('googlelanguagetranslator_display') == 'Vertical') {
	     $lang = ", includedLanguages:'".$comma_separated."'";
	       return $lang;
	  } elseif ( get_option('googlelanguagetranslator_display') == 'Horizontal') {
	     $lang = ", includedLanguages:'".$comma_separated."'";
	       return $lang;
      } 
    }
  }

  public function analytics() {
    if ( get_option('googlelanguagetranslator_analytics') == 1 ) {
	  $analytics_id = get_option('googlelanguagetranslator_analytics_id');
	  $analytics = "gaTrack: true, gaId: '".$analytics_id."'";

          if (!empty ($analytics_id) ):
	    return ', '.$analytics;
          endif;
    }
  }
  
  public function menu_shortcodes( $item_output,$item ) { 
    if ( !empty($item->description)) {
      $output = do_shortcode($item->description);
  
      if ( $output != $item->description )
        $item_output = $output;     
      }
    return $item_output;
  } 

  public function google_translator_menu_language($atts, $content = '') {
    extract(shortcode_atts(array(
      "language" => 'Afrikaans',
      "image" => 'no',
      "text" => 'yes',
      "image_size" => '24',
      "label" => 'Espa«Ðol'
    ), $atts));

        $flag_width = get_option('googlelanguagetranslator_flag_size');
	$default_language = get_option('googlelanguagetranslator_language'); 
	$english_flag_choice = get_option('googlelanguagetranslator_english_flag_choice');
	$spanish_flag_choice = get_option('googlelanguagetranslator_spanish_flag_choice');
	$portuguese_flag_choice = get_option('googlelanguagetranslator_portuguese_flag_choice');
	$language_code = array_search($language,$this->languages_array);
	$language_name = $language;
	$language_name_flag = $language_name;
	
	if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
	  $language_name_flag = 'canada';
	}
	if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
          $language_name_flag = 'united-states';
	}
	if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
	  $language_name_flag = 'mexico';
	}
	if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
	  $language_name_flag = 'brazil';
	}
        return "<a class='nturl notranslate ".$language_code." ".$language_name_flag." single-language flag' title='".$language."'>".($image=='yes' ? "<span class='flag size".$image_size."'></span>" : '') .($text=='yes' ? $label : '')."</a>";
  }

  public function footer_script() {
    global $shortcode_started;
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');
    $default_language = get_option('googlelanguagetranslator_language');
    $language_choices = $this->googlelanguagetranslator_included_languages();
    $new_languages_array_string = get_option('googlelanguagetranslator_flags_order');
    $new_languages_array = explode(",",$new_languages_array_string);
    $new_languages_array_codes = array_values($new_languages_array);
    $new_languages_array_count = count($new_languages_array);
    $get_language_option = get_option('googlelanguagetranslator_language_option');
    $get_flag_choices = get_option ('flag_display_settings');
    $get_flag_choices_count = count($get_flag_choices);
    $english_flag_choice = get_option('googlelanguagetranslator_english_flag_choice');
    $spanish_flag_choice = get_option('googlelanguagetranslator_spanish_flag_choice');
    $portuguese_flag_choice = get_option('googlelanguagetranslator_portuguese_flag_choice');
    $floating_widget = get_option ('googlelanguagetranslator_floating_widget');
    $floating_widget_text = get_option ('googlelanguagetranslator_floating_widget_text');
    $floating_widget_text_translation_allowed = get_option ('googlelanguagetranslator_floating_widget_text_allow_translation');
    $lang_attribute = get_option('googlelanguagetranslator_lang_urls');
    $flag_width = get_option('googlelanguagetranslator_flag_size');
    $is_active = get_option ( 'googlelanguagetranslator_active' );
    $layout = get_option ( 'googlelanguagetranslator_display' );
    $theme_style = get_option ( 'googlelanguagetranslator_theme_style ');
    $horizontal_layout = ', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL';
    $simple_layout = ', layout: google.translate.TranslateElement.InlineLayout.SIMPLE';
    $is_multilanguage = get_option('googlelanguagetranslator_multilanguage');
    $auto_display = ', autoDisplay: false';
    $str = '';

    if ($manual_is_active != 1): ?>

    <script type="text/javascript" async="async">jQuery(document).ready(function($) { layout = '<?php echo $layout; ?>', 'SIMPLE'==layout ? lang_text='' : lang_text=$(this).attr('data-lang'); glt_id = 'google_language_translator'; excluded_divs = "<?php echo get_option('googlelanguagetranslator_exclude_translation'); ?>"; $("body").find(excluded_divs).addClass("notranslate"); $('#flags a, a.nturl, a.single-language, .tool-items a').each(function() { $(this).attr('data-lang', $(this).attr('title')); }); $("a.flag,a.nturl").on("click",function(){function l(){doGoogleLanguageTranslator(default_lang+"|"+default_lang); if (lang_attribute == 'yes') { setTimeout(function() { window.location.href = window.location.href.split("?")[0]; }, 100); } } function n(){doGoogleLanguageTranslator(default_lang+"|"+lang_prefix); if (lang_attribute == 'yes') { if (is_admin == 1) { setTimeout(function(){ location.href = "<?php echo admin_url(); ?>options-general.php?page=google_language_translator_premium&lang=" + lang_prefix; }, 100); } else { setTimeout(function(){ location.href = window.location.href.split("?")[0] + "?lang=" + lang_prefix; }, 100); } } } lang_text=$(this).attr('data-lang'),lang_attribute = "<?php echo get_option('googlelanguagetranslator_lang_urls'); ?>", is_admin = "<?php echo is_admin(); ?>", default_lang="<?php echo get_option('googlelanguagetranslator_language'); ?>",lang_prefix=$(this).attr("class").split(" ")[2],$(".tool-container").hide(),lang_prefix==default_lang?l():n();}),0==$("body > #google_language_translator").length&&$("#glt-footer").html("<div id='google_language_translator'></div>")});</script>

    <?php
	
    if( $is_active == 1){
	  
      foreach ($get_flag_choices as $flag_choice_key) {}
	  
      if ($floating_widget=='yes' && $get_language_option != 'specific') {
	$str.='<div id="glt-translate-trigger"><span'.($floating_widget_text_translation_allowed != 1 ? ' class="notranslate"' : ' class="translate"').'>'.(empty($floating_widget_text) ? 'Translate &raquo;' : $floating_widget_text).'</span></div>';
        $str.='<div id="glt-toolbar"></div>';
      } //endif $floating_widget

      $str.='<div id="flags" class="size16" style="display:none">';
	$str.='<ul id="sortable" class="ui-sortable">';	  
	  
	  if ((empty($new_languages_array_string)) || ($new_languages_array_count != $get_flag_choices_count)) {
		    foreach ($this->languages_array as $key=>$value) {
		      $language_code = $key;
		      $language_name = $value;
		      $language_name_flag = $language_name;
	            if ($flag_choice_key == '1') {
                 if ( isset ( $get_flag_choices['flag-'.$language_code.''] ) ) {
				  if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
					$language_name_flag = 'canada';
				  }
				  if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                    $language_name_flag = 'united-states';
				  }
				  if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				    $language_name_flag = 'mexico';
				  }
				  if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
					$language_name_flag = 'brazil';
				  }
				  
				  if ($lang_attribute == 'yes') {
			        $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				  } else {
					$str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				  }
			     }
		        } //$key
	         }//foreach
	    } else {
		     foreach ($new_languages_array_codes as $value) {
		       $language_name = $value;
		       $language_code = array_search ($language_name,$this->languages_array);
		       $language_name_flag = $language_name;
			     if ($flag_choice_key == '1') {
			      if (in_array($language_name,$this->languages_array)) {
                   if ( isset ( $get_flag_choices['flag-'.$language_code.''] ) ) {
				    if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
					  $language_name_flag = 'canada';
				    }
				    if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                      $language_name_flag = 'united-states';
				    }
				    if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				      $language_name_flag = 'mexico';
				    }
				    if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
					  $language_name_flag = 'brazil';
				    }
					
				    if ($lang_attribute == 'yes') {
			          $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				    } else {
					  $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				    }
		           } //isset
			      } //in_array
		         }//flag_choice_key
	         }//foreach
	    }//endif
      $str.='</ul>';
      $str.='</div>';
      
	}

    if ($is_multilanguage == 1) {
      $multilanguagePage = ', multilanguagePage:true';
      $str.="<div id='glt-footer'></div><script type='text/javascript' async='async'>function GoogleLanguageTranslatorInit() { new google.translate.TranslateElement({pageLanguage: '".$default_language."'".$language_choices . ($layout=='Horizontal' ? $horizontal_layout : ($layout=='SIMPLE' && $theme_style != 'elegant' ? $simple_layout : '')) . $auto_display . $multilanguagePage . $this->analytics()."}, 'google_language_translator');}</script><script type='text/javascript'  async='async' src='//translate.google.com/translate_a/element.js?cb=GoogleLanguageTranslatorInit'></script>";
    } else {		  	
      $str.="<div id='glt-footer'></div><script type='text/javascript' async='async'>function GoogleLanguageTranslatorInit() { new google.translate.TranslateElement({pageLanguage: '".$default_language."'".$language_choices . ($layout=='Horizontal' ? $horizontal_layout : ($layout=='SIMPLE' && $theme_style != 'elegant' ? $simple_layout : '')) . $auto_display . $this->analytics()."}, 'google_language_translator');}</script><script type='text/javascript'  async='async' src='//translate.google.com/translate_a/element.js?cb=GoogleLanguageTranslatorInit'></script>";
    } //$is_multilanguage
      echo $str;
    endif; //$manual_is_active	
  } //function

  public function add_menu_page_languages() {
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');
    $option_name = 'googlelanguagetranslator_manual_language_display_settings';
    $get_manual_language_choices = get_option (''.$option_name.'');
    $default_language_code = get_option('googlelanguagetranslator_language');

    foreach ($this->languages_array as $key => $value) {
      $language_code = $key;
      $language_name = $value;
      $language_code_array[] = $key;
		
        if (!isset($get_manual_language_choices[''.$language_code.''])) {
	  $get_manual_language_choices[''.$language_code.''] = 0;
	}
		
	$items[] = $get_manual_language_choices[''.$language_code.''];
	$language_codes = $language_code_array;

        if ($get_manual_language_choices[''.$language_code.''] == 1 && $manual_is_active == 1 && $language_code != $default_language_code) {
          register_post_type( $language_code, array('public' => true,'show_in_menu' => 'languages','menu_name' => $language_name, 'label' => $language_name, 'slug' => $language_code, 'with_front' => false, 'register_meta_box_cb' => array(&$this,'add_custom_post_type_meta_boxes') ) );
        }
    }	 
  }

  public function googlelanguagetranslator_manual_language_switcher($content) {	
    global $post;
     
    $show_manual_language_switcher_meta = get_post_meta($post->ID, 'show_manual_language_switcher', true);
    $show_manual_language_switcher = get_option('googlelanguagetranslator_manual_language_switcher');
    $manual_is_active = get_option('googlelanguagetranslator_activate_manual_language');
    $language_choices = $this->googlelanguagetranslator_included_languages();
    $get_language_choices = get_option ('language_display_settings');
    $get_manual_language_choices = get_option ('googlelanguagetranslator_manual_language_display_settings');
    $get_language_option = get_option('googlelanguagetranslator_language_option');
    $default_language_code = get_option('googlelanguagetranslator_language');
    $english_flag_choice = get_option('googlelanguagetranslator_english_flag_choice');
    $spanish_flag_choice = get_option('googlelanguagetranslator_spanish_flag_choice');
    $portuguese_flag_choice = get_option('googlelanguagetranslator_portuguese_flag_choice');
    $lang_attribute = get_option('googlelanguagetranslator_lang_urls');
    $is_multilanguage = get_option('googlelanguagetranslator_multilanguage');
    $auto_display = ', autoDisplay: false';
    $default_permalink = get_the_permalink();
    $parsed_permalink = parse_url($default_permalink);
    $scheme = $parsed_permalink['scheme'];
    $base_host = $parsed_permalink['host'];
    $path = explode('/', $default_permalink);
    $path_string = $path[sizeof($path)-2];
    $post_type = get_post_type( $post->ID );
    $started = false;
    $language_code_search = array();
    $str = '';
	
    if ($manual_is_active == 1 && $show_manual_language_switcher == 'show' && $show_manual_language_switcher_meta == 'on') {
	  foreach ($get_manual_language_choices as $key=>$value) {
		$language_code = $key;
		$language_name = $this->languages_array[$language_code];
		$language_name_flag = $language_name;
		
		if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
		  $language_name_flag = 'canada';
		}
	    if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
          $language_name_flag = 'united-states';
		}
		if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
		  $language_name_flag = 'mexico';
		}
		if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
		  $language_name_flag = 'brazil';
		}
		
	      if ($started == false) {
					  
			$str.='<div id="language" class="manual-language-translation" style="height:30px; margin-bottom:5px">';
		    $str.='<div id="language_inner" style="height:30px; width:170px"><div class="switcher notranslate">';
	        $str.='<div class="selected">';
            $str.='<a class="notranslate" href="#" title="'.$language_name.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
            $str.='</div>';
            $str.='<div class="option">';
           
		  $started = true;
	      }
		
		
	    if ($language_code == $default_language_code) {
	      $str.='<a class="nturl notranslate '.$language_code.'" href="'.home_url().'/'.$path_string.'" title="'.$language_name.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		} else {
		  $str.='<a class="nturl notranslate '.$language_code.'" href="'.home_url().'/'.$language_code.'/'.$path_string.'" title="'.$language_name_flag.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		} 

	  } //foreach ?>

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

			 $.cookie("language_name",default_language_name);
			 
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
			   //alert(language_name);
			   $(".selected").html( "<a class='notranslate nturl' title='" + language_name + "' href='#'><span class='flag size16 "+language_name_flag+"'></span>" + language_name + "</a>");
			 
		   }		   
         });
	  
	  
		  
		  $("a.nturl").on('click',function() {
		     $.removeCookie("language_name");
		     $.removeCookie("flag_url");
			 
			 $.cookie("language_name", $(this).attr("title"),{ path: "/" });
			 $.cookie("flag_url", $(this).find("img").attr("src"),{ path: "/" });  
			
			 
			 default_lang = "<?php echo get_option('googlelanguagetranslator_language'); ?>";
			 lang_prefix = $(this).attr("class").split(" ")[2];
			 
			 var lang_attribute = "<?php echo get_option('googlelanguagetranslator_lang_urls'); ?>";
			 var language_name = $(this).attr("title");
			 var flag_url = $(this).find("img").attr("src");
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
		  });
		  
		  var language_name = $.cookie("language_name");
		  var language_name_flag = language_name;
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
			   $(".selected").html("<a class='notranslate' title='" + language_name + "' href='#'><span class='flag size16 " + language_name_flag + "'></span>" + language_name + "</a>"); 

        });
	  </script>

    <?php
					 
	$str.='</div></div></div></div>';

	  if(get_option('googlelanguagetranslator_display') == 'Vertical') {
		if (get_option('googlelanguagetranslator_theme_style') == 'elegant') {
		  $str.='<div dir="ltr" class="elegant-display skiptranslate goog-te-gadget"><div id=":0.targetLanguag"></div>Powered by <span style="white-space:nowrap"><a class="goog-logo-link" href="https://translate.google.com" target="_blank"><img src="https://www.google.com/images/logos/google_logo_41.png" style="padding-right: 3px" height="13px" width="37px">Translate</a></span></div><div style="clear:both"></div>';
		}
	  }
	  
	  $str.='<div id="google_language_translator"></div>';
	}
	$content = '<div>' . ($manual_is_active == 1 && !is_admin() ? (!is_home() ? $str : '') : '') . '</div>' . $content;
	
	return $content;
  }

  public function googlelanguagetranslator_vertical() {		
    global $shortcode_started;
    $shortcode_started = 'true';
    $new_languages_array_string = get_option('googlelanguagetranslator_flags_order');
    $new_languages_array = explode(",",$new_languages_array_string);
    $new_languages_array_codes = array_values($new_languages_array);
    $new_languages_array_count = count($new_languages_array);
    $is_active = get_option ( 'googlelanguagetranslator_active' );
    $get_flag_choices = get_option ('flag_display_settings');
    $get_flag_choices_count = count($get_flag_choices);
    $get_language_option = get_option('googlelanguagetranslator_language_option');
    $language_choices = $this->googlelanguagetranslator_included_languages();
    $get_language_choices = get_option ('language_display_settings');
    $floating_widget = get_option ('googlelanguagetranslator_floating_widget');
    $flag_width = get_option('googlelanguagetranslator_flag_size');
    $default_language_code = get_option('googlelanguagetranslator_language');
    $english_flag_choice = get_option('googlelanguagetranslator_english_flag_choice');
    $spanish_flag_choice = get_option('googlelanguagetranslator_spanish_flag_choice');
    $portuguese_flag_choice = get_option('googlelanguagetranslator_portuguese_flag_choice');
    $lang_attribute = get_option('googlelanguagetranslator_lang_urls');
    $is_multilanguage = get_option('googlelanguagetranslator_multilanguage');
    $auto_display = ', autoDisplay: false';
    $str = '';
	
    include( plugin_dir_path( __FILE__ ) . 'load-switcher.php');
    
    if( $is_active == 1){
	  
	  foreach ($get_flag_choices as $flag_choice_key) {}
	  
	  $str.='<div id="flags" class="size'.$flag_width.'">';
	  $str.='<ul id="sortable" class="ui-sortable">';	  
	  
	  if ((empty($new_languages_array_string)) || ($new_languages_array_count != $get_flag_choices_count)) {
		    foreach ($this->languages_array as $key=>$value) {
		      $language_code = $key;
		      $language_name = $value;
		      $language_name_flag = $language_name;
	            if ($flag_choice_key == '1') {
                 if ( isset ( $get_flag_choices['flag-'.$language_code.''] ) ) {
				  if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
					$language_name_flag = 'canada';
				  }
				  if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                    $language_name_flag = 'united-states';
				  }
				  if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				    $language_name_flag = 'mexico';
				  }
				  if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
					$language_name_flag = 'brazil';
				  }
				  
				  if ($lang_attribute == 'yes') {

			        $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				  } else {
					$str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				  }
			     }
		        } //$key
	         }//foreach
	    } else {
//print_r($new_languages_array_codes);
		     foreach ($new_languages_array_codes as $value) {
		       $language_name = $value;
		       $language_code = array_search ($language_name, $this->languages_array);
		       $language_name_flag = $language_name;
			     if ($flag_choice_key == '1') {
			      if (in_array($language_name,$this->languages_array)) {
                   if ( isset ( $get_flag_choices['flag-'.$language_code.''] ) ) {
				    if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
					  $language_name_flag = 'canada';
				    }
				    if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                      $language_name_flag = 'united-states';
				    }
				    if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				      $language_name_flag = 'mexico';
				    }
				    if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
					  $language_name_flag = 'brazil';
				    }
					
				    if ($lang_attribute == 'yes') {
			          $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				    } else {
					  $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				    }
		           } //isset
			      } //in_array
		         }//flag_choice_key
	         }//foreach
	    }//endif
      $str.='</ul>';
      $str.='</div>';
      
	  $started = false;
	  
	  if ($get_language_option != 'specific') {
      
      foreach ($this->languages_array as $key=>$value) {
		$language_code = $key;
		$language_name = $value;
        $language_name_flag = $language_name;
		
        if ($started == false) {
		
	$str.='<div id="language" class="auto-language-translation" style="height:30px">';
	$str.='<div id="language_inner" style="height:30px"><div class="switcher notranslate">';
	$str.='<div class="selected">';
        $str.='<a class="notranslate" title="'.$language_name.'" href="#"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
        $str.='</div>';
        $str.='<div class="option">';
		  
		$started = true;

	    }
		
		if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
		  $language_name_flag = 'canada';
		}
		if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
          $language_name_flag = 'united-states';
		}
		if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
		  $language_name_flag = 'mexico';
		}
		if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
		  $language_name_flag = 'brazil';
		}
		
		if ($lang_attribute == 'yes') {
	      $str.='<a title="'.$language_name.'" class="notranslate nturl '.$language_code.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		} else {
		  $str.='<a title="'.$language_name.'" class="notranslate nturl '.$language_code.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		}
	  }//foreach
		
	  } else {
		
		$language_code_search = array();
		
	  foreach ($get_language_choices as $key=>$value) {

		$language_code = $key;
		$language_name = $this->languages_array[$language_code];
		$language_name_flag = $language_name;
				
	    if ($started == false) {
		
		$str.='<div id="language" class="auto-language-translation" style="height:30px">';
	    $str.='<div id="language_inner" style="height:30px"><div class="switcher notranslate">';
	    $str.='<div class="selected">';
        $str.='<a class="notranslate" title="'.$language_name.'" href="#"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
        $str.='</div>';
        $str.='<div class="option">';
		  
		$started = true;

	    }
			    
		if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
		  $language_name_flag = 'canada';
		}
	    if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
          $language_name_flag = 'united-states';
		}
		if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
		  $language_name_flag = 'mexico';
		}
		if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
		  $language_name_flag = 'brazil';
		}
		
		if ($lang_attribute == 'yes') {
	      $str.='<a class="notranslate nturl '.$language_code.'" title="'.$language_name.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		} else {
		  $str.='<a class="notranslate nturl '.$language_code.'" title="'.$language_name.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		}
	   }//foreach
	  }//else
					 
	  $str.='</div></div></div></div>';

          if (get_option('googlelanguagetranslator_theme_style') == 'elegant') {
	    $str.='<div style="padding-top:8px" dir="ltr" class="elegant-display skiptranslate goog-te-gadget"><div id=":0.targetLanguag"></div>Powered by <span style="white-space:nowrap"><a class="goog-logo-link" href="https://translate.google.com" target="_blank"><img src="https://www.google.com/images/logos/google_logo_41.png" style="padding-right: 3px" height="13px" width="37px">Translate</a></span></div><div style="clear:both"></div>';
          }
	  
	  $str.='<div id="google_language_translator"></div>';

	  return $str;
	  
	} //End $is_active
  } // End glt_vertical

  
  
  public function googlelanguagetranslator_horizontal(){
    global $shortcode_started;
    $shortcode_started = 'true';
    $new_languages_array_string = get_option('googlelanguagetranslator_flags_order');
    $new_languages_array = explode(",",$new_languages_array_string);
    $new_languages_array_codes = array_values($new_languages_array);
    $new_languages_array_count = count($new_languages_array);
    $is_active = get_option ( 'googlelanguagetranslator_active' );
    $get_flag_choices = get_option ('flag_display_settings');
    $get_flag_choices_count = count($get_flag_choices);
    $get_language_option = get_option('googlelanguagetranslator_language_option');
    $language_choices = $this->googlelanguagetranslator_included_languages();
    $get_language_choices = get_option ('language_display_settings');
    $floating_widget = get_option ('googlelanguagetranslator_floating_widget');
    $flag_width = get_option('googlelanguagetranslator_flag_size');
    $default_language_code = get_option('googlelanguagetranslator_language');
    $english_flag_choice = get_option('googlelanguagetranslator_english_flag_choice');
    $spanish_flag_choice = get_option('googlelanguagetranslator_spanish_flag_choice');
    $portuguese_flag_choice = get_option('googlelanguagetranslator_portuguese_flag_choice');
    $lang_attribute = get_option('googlelanguagetranslator_lang_urls');
    $str = '';
	
    include( plugin_dir_path( __FILE__ ) . 'load-switcher.php');
	
    if( $is_active == 1){
	  
	  foreach ($get_flag_choices as $flag_choice_key) {}
	  
	  $str.='<div id="flags" class="size'.$flag_width.'">';
	  $str.='<ul id="sortable" class="ui-sortable">';	  
	  
	  if ((empty($new_languages_array_string)) || ($new_languages_array_count != $get_flag_choices_count)) {
		    foreach ($this->languages_array as $key=>$value) {
		      $language_code = $key;
		      $language_name = $value;
			  $language_name_flag = $language_name;
			  
			  if ($flag_choice_key == '1') {
                if ( isset ( $get_flag_choices['flag-'.$language_code.''] ) ) {
				  if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
					$language_name_flag = 'canada';
				  }
				  if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                    $language_name_flag = 'united-states';
				  }
				  if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				    $language_name_flag = 'mexico';
				  }
				  if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
					$language_name_flag = 'brazil';
				  }
				  if ($lang_attribute == 'yes') {
			        $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				  } else {
					$str.="<li id='".$language_name."'><a title='".$language_name."' class='notranslate flag ".$language_code." ".$language_name_flag."'></a>";
				  }
			    }
		      } //$key
			}//foreach
	    } elseif (!empty($new_languages_array_string)) {
		
			foreach ($new_languages_array_codes as $value) {
		      $language_name = $value;
			  $language_code = array_search ($language_name,$this->languages_array);
			  $language_name_flag = $language_name;
			  
			  if ($flag_choice_key == '1') {
                if ( isset ( $get_flag_choices['flag-'.$language_code.''] ) ) {
				  if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
					$language_name_flag = 'canada';
				  }
				  if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                    $language_name_flag = 'united-states';
				  }
				  if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				    $language_name_flag = 'mexico';
				  }
				  if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
					$language_name_flag = 'brazil';
				  }
				  if ($lang_attribute == 'yes') {
			        $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="notranslate flag '.$language_code.' '.$language_name_flag.'"></a>';
				  } else {
					$str.="<li id='".$language_name."'><a title='".$language_name."' class='notranslate flag ".$language_code." ".$language_name_flag."'></a>";
				  }
			    }
		      } //$key
		    }//foreach
	    }//empty
	  
      $str.='</ul>';
	  $str.='</div>';
	  
	  $started = false;
	  
	  if ($get_language_option != 'specific') {
      
      foreach ($this->languages_array as $key=>$value) {
		$language_code = $key;
		$language_name = $value;
        $language_name_flag = $language_name;
		
		if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
		  $language_name_flag = 'canada';
		}
		if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
          $language_name_flag = 'united-states';
		}
		if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
		  $language_name_flag = 'mexico';
		}
		if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
		  $language_name_flag = 'brazil';
		}
		
        if ($started == false) {
		  
		$str.='<div id="glt_container">';
	    $str.='<div id="language" class="auto-language-translation">';
	    $str.='<div id="language_inner" style="width:160px; height:30px"><div class="switcher notranslate">';
	    $str.='<div class="selected">';
        $str.='<a class="notranslate" onclick="return false;" href="#"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
        $str.='</div>';
		
        $str.='<div class="option">';
		  
		$started = true;

	    }
		
	    if ($lang_attribute == 'yes') {
	      $str.='<a title="'.$language_name.'" class="notranslate nturl '.$language_code.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		} else {
		  $str.='<a title="'.$language_name.'" class="notranslate nturl '.$language_code.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		} 
	  }//foreach
		
	  } else {
		
		$language_code_search = array();
		
	  foreach ($get_language_choices as $key=>$value) {

		$language_code = $key;
		$language_name = $this->languages_array[$language_code];
		$language_name_flag = $language_name;
		
		if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
		  $language_name_flag = 'canada';
		}
	    if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
          $language_name_flag = 'united-states';
		}
		if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
		  $language_name_flag = 'mexico';
		}
		if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
		  $language_name_flag = 'brazil';
		}
				
	    if ($started == false) {
		
		$str.='<div id="glt_container">';
	    $str.='<div id="language" class="auto-language-translation">';
	    $str.='<div id="language_inner" style="width:160px; height:30px"><div class="switcher notranslate">';
	    $str.='<div class="selected">';
        $str.='<a class="notranslate" onclick="return false;" href="#"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
        $str.='</div>';
		  
        $str.='<div class="option">';
		  
		$started = true;

	    }
		
	    if ($lang_attribute == 'yes') {
	      $str.='<a title="'.$language_name.'" class="notranslate nturl '.$language_code.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		} else {
		  $str.='<a title="'.$language_name.'" class="notranslate nturl '.$language_code.'"><span class="flag size16 '.$language_name_flag.'"></span>'.$language_name.'</a>';
		}
	  }
		
	  }//if
					 
	  $str.='</div></div></div></div>';

	  if(get_option('googlelanguagetranslator_display') == 'Horizontal') {
            if(get_option('googlelanguagetranslator_flags_alignment') == 'flags_right') {
	      $str.='<div style="text-align:left; padding-top:8px" dir="ltr" class="elegant-display skiptranslate goog-te-gadget">';
            } elseif ((get_option('googlelanguagetranslator_flags_alignment') == 'flags_left') || get_option('googlelanguagetranslator_flags_alignment') == 'flags_center') {
	    $str.='<div style="margin-top:4px; height:100%; line-height:30px; clear:none" dir="ltr" class="elegant-display skiptranslate goog-te-gadget">';
            } 
          if (get_option('googlelanguagetranslator_theme_style') == 'elegant') {
            $str.='<div id=":0.targetLanguag"></div>Powered by <span style="white-space:nowrap"><a class="goog-logo-link" href="https://translate.google.com" target="_blank"><img src="https://www.google.com/images/logos/google_logo_41.png" style="padding-right: 3px" height="13px" width="37px">Translate</a></span></div>';
          }
      $str.='</div>';
		}
	  $str.='<div id="google_language_translator"></div>';      
	  
	  return $str;
	  }	
  } // End glt_horizontal
 
  public function initialize_settings() {
    add_settings_section('auto_translation_settings','Settings', '','google_language_translator_premium');
    add_settings_section('manual_translation_settings','Settings','','google_language_translator_premium');

    $auto_translation_settings_array = array ('googlelanguagetranslator_license_key','googlelanguagetranslator_active','googlelanguagetranslator_product_type','googlelanguagetranslator_language','googlelanguagetranslator_language_option','language_display_settings','googlelanguagetranslator_flags','flag_display_settings','googlelanguagetranslator_translatebox','googlelanguagetranslator_display','googlelanguagetranslator_toolbar','googlelanguagetranslator_showbranding','googlelanguagetranslator_flags_alignment','googlelanguagetranslator_flag_size','googlelanguagetranslator_languagebox_width','googlelanguagetranslator_flagarea_width','googlelanguagetranslator_theme_style','googlelanguagetranslator_languagebox_flags','googlelanguagetranslator_analytics','googlelanguagetranslator_analytics_id','googlelanguagetranslator_css','googlelanguagetranslator_multilanguage','googlelanguagetranslator_floating_widget','googlelanguagetranslator_floating_widget_position','googlelanguagetranslator_flags_order','googlelanguagetranslator_auto_language_detection','googlelanguagetranslator_english_flag_choice','googlelanguagetranslator_spanish_flag_choice','googlelanguagetranslator_portuguese_flag_choice','googlelanguagetranslator_lang_urls','googlelanguagetranslator_exclude_translation','googlelanguagetranslator_browser_language_detection','googlelanguagetranslator_floating_widget_text','googlelanguagetranslator_floating_widget_text_allow_translation');

    $manual_translation_settings_array = array
('googlelanguagetranslator_manual_language_display_settings','googlelanguagetranslator_activate_manual_language','googlelanguagetranslator_manual_language_switcher');

    foreach ($auto_translation_settings_array as $setting) {
      add_settings_field( $setting,'',$setting.'_cb','google_language_translator','auto_translation_settings');
      register_setting( 'google_language_translator',$setting); 
    }

    foreach ($manual_translation_settings_array as $setting) {
      add_settings_field( $setting,'',$setting.'_cb','google_language_translator','manual_translation_settings');
      register_setting( 'google_language_translator2',$setting);
    }
  }

  public function googlelanguagetranslator_license_key_cb() {
  
  }
  
  public function googlelanguagetranslator_active_cb() {
	  
	$option_name = 'googlelanguagetranslator_active' ;
    $new_value = 1;

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>
	  		
	  <script type="text/javascript" async="async">
		jQuery(document).ready(function($) {
		  var manual_is_active = "<?php echo get_option('googlelanguagetranslator_activate_manual_language'); ?>";
		    if (manual_is_active == 1) {
		      $("input[name='googlelanguagetranslator_active']").attr("disabled", true);
			}
		});
      </script>

      <?php 

      $html = '<input type="checkbox" name="googlelanguagetranslator_active" id="googlelanguagetranslator_active" value="1" '.checked(1,$options,false).'/> &nbsp; Check to activate';
	    echo $html;
  }
  
  public function googlelanguagetranslator_product_type_cb() {
	  
	$option_name = 'googlelanguagetranslator_product_type' ;
    $new_value = 1;

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>
	  		
	  <select name="googlelanguagetranslator_product_type" id="googlelanguagetranslator_product_type">
        <option value="free_website_widget" <?php if($options=='free_website_widget'){echo "selected";}?>>FREE Website Widget</option>
	    <option value="paid_google_translate_api" <?php if($options=='paid_google_translate_api'){echo "selected";}?>>Google Translate API (PAID)</option>
      </select>
	 <?php 
  }
  
  public function googlelanguagetranslator_language_cb() {
	$option_name = 'googlelanguagetranslator_language';
    $new_value = 'en';

      if ( get_option( $option_name ) === false ) {
        update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.'');
	
	  $str='';
	  $str.='<select name="googlelanguagetranslator_language" id="googlelanguagetranslator_language">';
		
	  foreach ($this->languages_array as $key => $value) {
		$language_code = $key;
		$language_name = $value;
		
		$str.='<option value="'.$language_code.'"'.($options==$language_code ? 'selected' : '').'>'.$language_name.'</option>';
	  }
	  $str.='</select>';
	  echo $str;     
    } 
  
    public function googlelanguagetranslator_language_option_cb() {
	
	$option_name = 'googlelanguagetranslator_language_option' ;
    $new_value = 'all';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

    <input type="radio" name="googlelanguagetranslator_language_option" id="googlelanguagetranslator_language_option" value="all" <?php if($options=='all'){echo "checked";}?>/> All Languages<br/>
	<input type="radio" name="googlelanguagetranslator_language_option" id="googlelanguagetranslator_language_option" value="specific" <?php if($options=='specific'){echo "checked";}?>/> Specific Languages
    <?php 
	}
  
    public function language_display_settings_cb() {
	  $default_language_code = get_option('googlelanguagetranslator_language');
	  $option_name = 'language_display_settings';
      $new_value = array(''.$default_language_code.'' => 1);
	  
	  if ( get_option( $option_name ) == false ) {
        // The option does not exist, so we update it.
        update_option( $option_name, $new_value );
	  } 
	  
	  $get_language_choices = get_option (''.$option_name.''); ?>

          <script type="text/javascript" async="async">
            jQuery(document).ready(function($) {
              $('.select-all-languages').on('click',function(e) { e.preventDefault(); $('.languages').find('input:checkbox').prop('checked', true); });
              $('.clear-all-languages').on('click',function(e) { e.preventDefault(); 
$('.languages').find('input:checkbox').prop('checked', false); });
            });
          </script>

          <div class="glt-controls languages notranslate"><a class="select-all-languages" href="#">Select All</a> <a class="clear-all-languages" href="#">Clear All</a></div>

          <?php

	  foreach ($this->languages_array as $key => $value) {
		$language_code = $key;
		$language_name = $value;
		$language_code_array[] = $key;
		
		if (!isset($get_language_choices[''.$language_code.''])) {
		  $get_language_choices[''.$language_code.''] = 0;
		}
		
		$items[] = $get_language_choices[''.$language_code.''];
		$language_codes = $language_code_array;
		$item_count = count($items); 

		if ($item_count == 1 || $item_count == 26 || $item_count == 51 || $item_count == 76) { ?>
          <div class="languages" style="width:25%; float:left">
	    <?php } ?>
		  <div><input type="checkbox" name="language_display_settings[<?php echo $language_code; ?>]" value="1"<?php checked( 1,$get_language_choices[''.$language_code.'']); ?>/><?php echo $language_name; ?></div>
        <?php 
		if ($item_count == 25 || $item_count == 50 || $item_count == 75 || $item_count == 97) { ?>
          </div>
        <?php } 
	  } ?>
     <div class="clear"></div>
    <?php
	} 
  
    public function googlelanguagetranslator_flags_cb() { 
	
      $option_name = 'googlelanguagetranslator_flags' ;
      $new_value = 'show_flags';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

      <input type="radio" name="googlelanguagetranslator_flags" id="googlelanguagetranslator_flags" value="show_flags" <?php if($options=='show_flags'){echo "checked";}?>/> Yes, show flag images<br/>
	  <input type="radio" name="googlelanguagetranslator_flags" id="googlelanguagetranslator_flags" value="hide_flags" <?php if($options=='hide_flags'){echo "checked";}?>/> No, hide flag images
    <?php 
    }  

    public function googlelanguagetranslator_manual_language_display_settings_cb() {
      $default_language_code = get_option('googlelanguagetranslator_language');
      $option_name = 'googlelanguagetranslator_manual_language_display_settings';
      $new_value = array(''.$default_language_code.'' => 1);
	  
	  if ( get_option( $option_name ) == false ) {
        // The option does not exist, so we update it.
        update_option( $option_name, $new_value );
	  } 
	  
	  $get_manual_language_choices = get_option (''.$option_name.''); ?>

          <script type="text/javascript" async="async">
            jQuery(document).ready(function($) {
              $('.select-all').on('click',function(e) { e.preventDefault(); $('.languages').find('input:checkbox').prop('checked', true); });
              $('.clear-all').on('click',function(e) { e.preventDefault(); 
$('.languages').find('input:checkbox').prop('checked', false); });
            });
          </script>

          <div class="glt-controls choose_flags notranslate"><a class="select-all" href="#">Select All</a> <a class="clear-all" href="#">Clear All</a></div>

          <?php
	  
	  foreach ($this->languages_array as $key => $value) {
		$language_code = $key;
		$language_name = $value;
		$language_code_array[] = $key;
		
		if (!isset($get_manual_language_choices[''.$language_code.''])) {
		  $get_manual_language_choices[''.$language_code.''] = 0;
		}
		
		$items[] = $get_manual_language_choices[''.$language_code.''];
		$language_codes = $language_code_array;
		$item_count = count($items); 

		if ($item_count == 1 || $item_count == 26 || $item_count == 51 || $item_count == 76) { ?>
          <div class="languages" style="width:25%; float:left">
	    <?php } ?>
		  <div><input type="checkbox" name="googlelanguagetranslator_manual_language_display_settings[<?php echo $language_code; ?>]" value="1"<?php checked( 1,$get_manual_language_choices[''.$language_code.'']); ?>/><?php echo $language_name; ?></div>
        <?php 
		if ($item_count == 25 || $item_count == 50 || $item_count == 75 || $item_count == 97) { ?>
          </div>
        <?php } 
	  } ?>
     <div class="clear"></div>
    <?php
    }
  
    public function googlelanguagetranslator_manual_language_switcher_cb() {
      $option_name = 'googlelanguagetranslator_manual_language_switcher' ;
      $new_value = 'show';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_manual_language_switcher" id="googlelanguagetranslator_manual_language_switcher">
		      <option value="show" <?php if($options=='show'){echo "selected";}?>>Yes, show language switcher</option>
			  <option value="hide" <?php if($options=='hide'){echo "selected";}?>>No, hide language switcher</option>
		  </select>
	 <?php 
    }

    public function googlelanguagetranslator_browser_language_detection_cb() {
      $option_name = 'googlelanguagetranslator_browser_language_detection' ;
      $new_value = 0;

      if ( get_option( $option_name ) === false ) {
        update_option( $option_name, $new_value );
      } 
      $options = get_option (''.$option_name.'');

      $html = '<input type="checkbox" name="googlelanguagetranslator_browser_language_detection" id="googlelanguagetranslator_browser_language_detection" value="1" '.checked(1,$options,false).'/> &nbsp; Translate to native language upon first site visit';
      echo $html;
    }
  
    public function googlelanguagetranslator_activate_manual_language_cb() {
      $option_name = 'googlelanguagetranslator_activate_manual_language' ;
      $new_value = 0;

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

      <script type="text/javascript" async="async">
		jQuery(document).ready(function($) {
		  var auto_is_active = "<?php echo get_option('googlelanguagetranslator_active'); ?>";
		    if (auto_is_active == 1) {
		      $("input[name='googlelanguagetranslator_activate_manual_language']").attr("disabled", true);
			}
		});
      </script>
	  	
      <?php
	  
	  $html = '<input type="checkbox" name="googlelanguagetranslator_activate_manual_language" id="googlelanguagetranslator_activate_manual_language" value="1" '.checked(1,$options,false).'/> &nbsp; Check to activate';
	    echo $html;
  }
  
  public function flag_display_settings_cb() {
	  $default_language_code = get_option('googlelanguagetranslator_language');
	  $option_name = 'flag_display_settings';
      $new_value = array('flag-'.$default_language_code.'' => 1);
	  
	  if ( get_option( $option_name ) == false ) {
        // The option does not exist, so we update it.
        update_option( $option_name, $new_value );
	  } 
	  
	  $get_flag_choices = get_option (''.$option_name.''); ?>

          <script type="text/javascript" async="async">
            jQuery(document).ready(function($) {
              $('.select-all-flags').on('click',function(e) { e.preventDefault(); $('.choose_flags').find('input:checkbox').prop('checked', true); });
              $('.clear-all-flags').on('click',function(e) { e.preventDefault(); 
$('.choose_flags').find('input:checkbox').prop('checked', false); });
            });
          </script>

          <div class="glt-controls choose_flags notranslate"><a class="select-all-flags" href="#">Select All</a> <a class="clear-all-flags" href="#">Clear All</a></div>

          <?php
	  
	  foreach ($this->languages_array as $key => $value) {
		$language_code = $key;
		$language_name = $value;
		$language_code_array[] = $key;
		
		if (!isset($get_flag_choices['flag-'.$language_code.''])) {
		  $get_flag_choices['flag-'.$language_code.''] = 0;
		}
		
		$items[] = $get_flag_choices['flag-'.$language_code.''];
		$language_codes = $language_code_array;
		$item_count = count($items); 

		if ($item_count == 1 || $item_count == 26 || $item_count == 51 || $item_count == 76) { ?>
          <div class="flagdisplay" style="width:25%; float:left">
	    <?php } ?>
		  <div><input type="checkbox" name="flag_display_settings[flag-<?php echo $language_code; ?>]" value="1"<?php checked( 1,$get_flag_choices['flag-'.$language_code.'']); ?>/><?php echo $language_name; ?></div>
        <?php 
		if ($item_count == 25 || $item_count == 50 || $item_count == 75 || $item_count == 97) { ?>
          </div>
        <?php } 
	  } ?>
     <div class="clear"></div>
    <?php
  }
  
  public function googlelanguagetranslator_floating_widget_cb() {
	
	$option_name = 'googlelanguagetranslator_floating_widget' ;
    $new_value = 'yes';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_floating_widget" id="googlelanguagetranslator_floating_widget" style="width:170px">
		      <option value="yes" <?php if($options=='yes'){echo "selected";}?>>Yes, show widget</option>
			  <option value="no" <?php if($options=='no'){echo "selected";}?>>No, hide widget</option>
		  </select>
  <?php 
  }

  public function googlelanguagetranslator_floating_widget_text_cb() {

    $option_name = 'googlelanguagetranslator_floating_widget_text' ;
    $new_value = 'Translate &raquo;';

    if ( get_option( $option_name ) === false ) {
      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
    }

    $options = get_option (''.$option_name.''); ?>

    <input type="text" name="googlelanguagetranslator_floating_widget_text" id="googlelanguagetranslator_floating_widget_text" value="<?php echo esc_attr($options); ?>" style="width:170px"/>
		      
  <?php }

  public function googlelanguagetranslator_floating_widget_text_allow_translation_cb() {
    $option_name = 'googlelanguagetranslator_floating_widget_text_allow_translation' ;
    $new_value = 0;

    if ( get_option( $option_name ) === false ) {
      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
    }

    $options = get_option (''.$option_name.'');

    $html = '<input type="checkbox" name="googlelanguagetranslator_floating_widget_text_allow_translation" id="googlelanguagetranslator_floating_widget_text_allow_translation" value="1" '.checked(1,$options,false).'/> &nbsp; Check to allow';
    echo $html;
  }

  public function googlelanguagetranslator_floating_widget_position_cb() {
      $option_name = 'googlelanguagetranslator_floating_widget_position';
      $new_value = 'bottom-left';

      if (get_option($option_name) === false):
        update_option($option_name, $new_value);
      endif;

      $options = get_option(''.$option_name.''); ?>

      <select name="googlelanguagetranslator_floating_widget_position" id="googlelanguagetranslator_floating_widget_position" style="width:170px">
        <option value="bottom_left" <?php if($options=='bottom_left'){echo "selected";}?>>Bottom left</option>
        <option value="bottom_center" <?php if($options=='bottom_center'){echo "selected";}?>>Bottom center</option>
	<option value="bottom_right" <?php if($options=='bottom_right'){echo "selected";}?>>Bottom right</option>
        <option value="top_left" <?php if($options=='top_left'){echo "selected";}?>>Top left</option>
        <option value="top_center" <?php if($options=='top_center'){echo "selected";}?>>Top center</option>
	<option value="top_right" <?php if($options=='top_right'){echo "selected";}?>>Top right</option>
      </select>
  <?php
  }
  
  public function googlelanguagetranslator_translatebox_cb() {
	
	$option_name = 'googlelanguagetranslator_translatebox' ;
    $new_value = 'yes';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_translatebox" id="googlelanguagetranslator_translatebox" style="width:190px">
		      <option value="yes" <?php if($options=='yes'){echo "selected";}?>>Show language switcher</option>
			  <option value="no" <?php if($options=='no'){echo "selected";}?>>Hide language switcher</option>
		  </select>
  <?php }
  
  public function googlelanguagetranslator_display_cb() {
    $option_name = 'googlelanguagetranslator_display' ;
    $new_value = 'Vertical';

    if ( get_option( $option_name ) === false ) {
      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
    } 
	  
    $options = get_option (''.$option_name.''); ?>

    <select name="googlelanguagetranslator_display" id="googlelanguagetranslator_display" style="width:170px;">
      <option value="Vertical" <?php if(get_option('googlelanguagetranslator_display')=='Vertical'){echo "selected";}?>>Vertical</option>
      <option value="Horizontal" <?php if(get_option('googlelanguagetranslator_display')=='Horizontal'){echo "selected";}?>>Horizontal</option>
      <?php
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
	if (!empty($get_http_accept_language)):
	  $get_http_accept_language = explode(",",$browser_lang);
	else:
	  $get_http_accept_language = explode(",",$browser_lang);
	endif;
        $bestlang = $get_http_accept_language[0];
        $bestlang_prefix = substr($get_http_accept_language[0],0,2); 
               
        if ($bestlang_prefix == 'en'): ?>
	  <option value="SIMPLE" <?php if (get_option('googlelanguagetranslator_display')=='SIMPLE'){echo "selected";}?>>SIMPLE</option>
        <?php endif; ?>
      </select> 
  <?php }
  
  public function googlelanguagetranslator_toolbar_cb() {
	
	$option_name = 'googlelanguagetranslator_toolbar' ;
    $new_value = 'Yes';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_toolbar" id="googlelanguagetranslator_toolbar" style="width:170px;">
             <option value="Yes" <?php if(get_option('googlelanguagetranslator_toolbar')=='Yes'){echo "selected";}?>>Yes</option>
             <option value="No" <?php if(get_option('googlelanguagetranslator_toolbar')=='No'){echo "selected";}?>>No</option>
          </select>
  <?php }
  
  public function googlelanguagetranslator_showbranding_cb() {
	
	$option_name = 'googlelanguagetranslator_showbranding' ;
    $new_value = 'Yes';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_showbranding" id="googlelanguagetranslator_showbranding" style="width:170px;">
             <option value="Yes" <?php if(get_option('googlelanguagetranslator_showbranding')=='Yes'){echo "selected";}?>>Yes</option>
             <option value="No" <?php if(get_option('googlelanguagetranslator_showbranding')=='No'){echo "selected";}?>>No</option>
          </select> 
  <?php }
  
  public function googlelanguagetranslator_flags_alignment_cb() {
	
	$option_name = 'googlelanguagetranslator_flags_alignment' ;
    $new_value = 'flags_left';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

      <input type="radio" name="googlelanguagetranslator_flags_alignment" id="googlelanguagetranslator_flags_alignment" value="flags_left" <?php if($options=='flags_left'){echo "checked";}?>/> Align Left<br/>
      <input type="radio" name="googlelanguagetranslator_flags_alignment" id="googlelanguagetranslator_flags_alignment" value="flags_center" <?php if($options=='flags_center'){echo "checked";}?>/> Align Center<br/>
      <input type="radio" name="googlelanguagetranslator_flags_alignment" id="googlelanguagetranslator_flags_alignment" value="flags_right" <?php if($options=='flags_right'){echo "checked";}?>/> Align Right
  <?php }
  
  public function googlelanguagetranslator_flag_size_cb() {
	
	$option_name = 'googlelanguagetranslator_flag_size' ;
    $new_value = '24px';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_flag_size" id="googlelanguagetranslator_flag_size" style="width:110px;">
             <option value="16" <?php if($options=='16'){echo "selected";}?>>16px</option>
			 <option value="18" <?php if($options=='18'){echo "selected";}?>>18px</option>
             <option value="20" <?php if($options=='20'){echo "selected";}?>>20px</option>
			 <option value="22" <?php if($options=='22'){echo "selected";}?>>22px</option>
             <option value="24" <?php if($options=='24'){echo "selected";}?>>24px</option>
          </select> 
  <?php }
          
  public function googlelanguagetranslator_languagebox_width_cb() {
	
	$option_name = 'googlelanguagetranslator_languagebox_width' ;
    $new_value = '160px';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_languagebox_width" id="googlelanguagetranslator_languagebox_width" style="width:110px;">
             <option value="100%" <?php if($options=='100%'){echo "selected";}?>>100%</option>
             <option value="">-------</option>
             <option value="150px" <?php if($options=='150px'){echo "selected";}?>>150px</option>
             <option value="160px" <?php if($options=='160px'){echo "selected";}?>>160px</option>
			 <option value="170px" <?php if($options=='170px'){echo "selected";}?>>170px</option>
             <option value="180px" <?php if($options=='180px'){echo "selected";}?>>180px</option>
			 <option value="190px" <?php if($options=='190px'){echo "selected";}?>>190px</option>
             <option value="200px" <?php if($options=='200px'){echo "selected";}?>>200px</option>
			 <option value="210px" <?php if($options=='210px'){echo "selected";}?>>210px</option>
             <option value="220px" <?php if($options=='220px'){echo "selected";}?>>220px</option>
			 <option value="230px" <?php if($options=='230px'){echo "selected";}?>>230px</option>
             <option value="240px" <?php if($options=='240px'){echo "selected";}?>>240px</option>
			 <option value="250px" <?php if($options=='250px'){echo "selected";}?>>250px</option>
             <option value="260px" <?php if($options=='260px'){echo "selected";}?>>260px</option>
			 <option value="270px" <?php if($options=='270px'){echo "selected";}?>>270px</option>
             <option value="280px" <?php if($options=='280px'){echo "selected";}?>>280px</option>
			 <option value="290px" <?php if($options=='290px'){echo "selected";}?>>290px</option>
             <option value="300px" <?php if($options=='300px'){echo "selected";}?>>300px</option>
          </select> 
  <?php }
  
  public function googlelanguagetranslator_flagarea_width_cb() {
	
	$option_name = 'googlelanguagetranslator_flagarea_width' ;
    $new_value = '160px';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_flagarea_width" id="googlelanguagetranslator_flagarea_width" style="width:110px;">
			 <option value="100%" <?php if($options=='100%'){echo "selected";}?>>100%</option>
             <option value="">-------</option>
             <option value="150px" <?php if($options=='150px'){echo "selected";}?>>150px</option>
             <option value="160px" <?php if($options=='160px'){echo "selected";}?>>160px</option>
			 <option value="170px" <?php if($options=='170px'){echo "selected";}?>>170px</option>
             <option value="180px" <?php if($options=='180px'){echo "selected";}?>>180px</option>
			 <option value="190px" <?php if($options=='190px'){echo "selected";}?>>190px</option>
             <option value="200px" <?php if($options=='200px'){echo "selected";}?>>200px</option>
			 <option value="210px" <?php if($options=='210px'){echo "selected";}?>>210px</option>
             <option value="220px" <?php if($options=='220px'){echo "selected";}?>>220px</option>
			 <option value="230px" <?php if($options=='230px'){echo "selected";}?>>230px</option>
             <option value="240px" <?php if($options=='240px'){echo "selected";}?>>240px</option>
			 <option value="250px" <?php if($options=='250px'){echo "selected";}?>>250px</option>
             <option value="260px" <?php if($options=='260px'){echo "selected";}?>>260px</option>
			 <option value="270px" <?php if($options=='270px'){echo "selected";}?>>270px</option>
             <option value="280px" <?php if($options=='280px'){echo "selected";}?>>280px</option>
			 <option value="290px" <?php if($options=='290px'){echo "selected";}?>>290px</option>
             <option value="300px" <?php if($options=='300px'){echo "selected";}?>>300px</option>
          </select> 
  <?php }
  
  public function googlelanguagetranslator_theme_style_cb() {
	
    $option_name = 'googlelanguagetranslator_theme_style' ;
    $new_value = 'elegant';

    if ( get_option( $option_name ) === false ):
      // The option does not exist, so we update it.
      update_option( $option_name, $new_value);
    endif;
	  
    $options = get_option (''.$option_name.''); ?>

    <select style="width:170px" name="googlelanguagetranslator_theme_style" id="googlelanguagetranslator_theme_style">
      <option value="classic" <?php if($options=='classic'){echo "selected";}?>>Classic</option>
      <option value="elegant" <?php if ($options=='elegant'){echo "selected";}?>>Elegant</option>
    </select> 
  <?php }
  
  public function googlelanguagetranslator_analytics_cb() {
	
    $option_name = 'googlelanguagetranslator_analytics' ;
    $new_value = 0;

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
      } 
	  
      $options = get_option (''.$option_name.'');

      $html = '<input type="checkbox" name="googlelanguagetranslator_analytics" id="googlelanguagetranslator_analytics" value="1" '.checked(1,$options,false).'/> &nbsp; Activate Google Analytics tracking?';
    echo $html;
  }
  
  public function googlelanguagetranslator_analytics_id_cb() {
	
    $option_name = 'googlelanguagetranslator_analytics_id' ;
    $new_value = '';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.'');

    $html = '<input type="text" name="googlelanguagetranslator_analytics_id" id="googlelanguagetranslator_analytics_id" value="'.$options.'" />';
    echo $html;
  }
  
  public function googlelanguagetranslator_css_cb() {
	 
    $option_name = 'googlelanguagetranslator_css' ;
    $new_value = '';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.'');
    
	  $html = '<textarea style="width:100%; height:200px" name="googlelanguagetranslator_css" id="googlelanguagetranslator_css">'.$options.'</textarea>';
    echo $html;
  }
  
  public function googlelanguagetranslator_multilanguage_cb() {
	
	$option_name = 'googlelanguagetranslator_multilanguage' ;
    $new_value = 0;

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); 

      $html = '<input type="checkbox" name="googlelanguagetranslator_multilanguage" id="googlelanguagetranslator_multilanguage" value="1" '.checked(1,$options,false).'/> &nbsp; Turn on multilanguage mode?';
      echo $html; 
  }
  
  public function googlelanguagetranslator_languagebox_flags_cb() {
	 
    $option_name = 'googlelanguagetranslator_languagebox_flags' ;
    $new_value = 'show_flags';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.''); ?>
    
    <select name="googlelanguagetranslator_languagebox_flags" id="googlelanguagetranslator_languagebox_flags">
	  <option value="show_flags"<?php if($options=='show_flags'){echo "selected";}?>>Show flags</option>
	  <option value="hide_flags"<?php if($options=='hide_flags'){echo "selected";}?>>Hide flags</option>
    </select>
  <?php
  }

  
  public function googlelanguagetranslator_flags_order_cb() {
      
      $option_name = 'googlelanguagetranslator_flags_order' ;
    
      $new_value = $this->languages_array;
   

      if ( ( get_option( $option_name ) !== null || get_option($option_name) === false ) ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.'');
	  		
  }
  
  public function googlelanguagetranslator_english_flag_choice_cb() {
	$option_name = 'googlelanguagetranslator_english_flag_choice';
	$new_value = 'us_flag';
	
	if ( get_option ( $option_name ) === false ) {
	  
	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}
	
	$options = get_option ( ''.$option_name.'' ); ?>

    <select name="googlelanguagetranslator_english_flag_choice" id="googlelanguagetranslator_english_flag_choice">
      <option value="us_flag" <?php if($options=='us_flag'){echo "selected";}?>>U.S. Flag</option>
	  <option value="uk_flag" <?php if ($options=='uk_flag'){echo "selected";}?>>U.K Flag</option>
	  <option value="canadian_flag" <?php if ($options=='canadian_flag'){echo "selected";}?>>Canadian Flag</option>
    </select>
   <?php
  }
  
  public function googlelanguagetranslator_spanish_flag_choice_cb() {
	$option_name = 'googlelanguagetranslator_spanish_flag_choice';
	$new_value = 'spanish_flag';
	
	if ( get_option ( $option_name ) === false ) {
	  
	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}
	
	$options = get_option ( ''.$option_name.'' ); ?>

    <select name="googlelanguagetranslator_spanish_flag_choice" id="googlelanguagetranslator_spanish_flag_choice">
      <option value="spanish_flag" <?php if($options=='spanish_flag'){echo "selected";}?>>Spanish Flag</option>
	  <option value="mexican_flag" <?php if ($options=='mexican_flag'){echo "selected";}?>>Mexican Flag</option>
    </select>
   <?php
  }
  
  public function googlelanguagetranslator_portuguese_flag_choice_cb() {
	$option_name = 'googlelanguagetranslator_portuguese_flag_choice';
	$new_value = 'portuguese_flag';
	
	if ( get_option ( $option_name ) === false ) {
	  
	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}
	
	$options = get_option ( ''.$option_name.'' ); ?>

    <select name="googlelanguagetranslator_portuguese_flag_choice" id="googlelanguagetranslator_spanish_flag_choice">
      <option value="portuguese_flag" <?php if($options=='portuguese_flag'){echo "selected";}?>>Portuguese Flag</option>
	  <option value="brazilian_flag" <?php if ($options=='brazilian_flag'){echo "selected";}?>>Brazilian Flag</option>
    </select>
   <?php
  }
  
  public function googlelanguagetranslator_lang_urls_cb() {
	$option_name = 'googlelanguagetranslator_lang_urls';
	$new_value = 'no';
	
	if ( get_option ( $option_name ) === false ) {
	  
	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}
	
	$options = get_option ( ''.$option_name.'' ); ?>

<select name="googlelanguagetranslator_lang_urls" id="googlelanguagetranslator_lang_urls" style="width:170px">
      <option value="yes" <?php if($options=='yes'){echo "selected";}?>>Yes</option>
	  <option value="no" <?php if ($options=='no'){echo "selected";}?>>No</option>
    </select>
   <?php
  }

  public function googlelanguagetranslator_exclude_translation_cb() {
	
	$option_name = 'googlelanguagetranslator_exclude_translation';
	$new_value = '';
	
	if (get_option($option_name) === false ) {
	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}
	
	$options = get_option (''.$option_name.'');
	
	$html = '<input type="text" name="'.$option_name.'" id="'.$option_name.'" value="'.$options.'" />';
	
	echo $html;
  }

  public function page_layout_cb() { ?>
    <div class="wrap" style="width:89%">
    <?php  
                      if( isset( $_GET[ 'tab' ] ) ) {  
                          $active_tab = $_GET[ 'tab' ];  
                      } else {
                        if (get_option('googlelanguagetranslator_license_key') == ''):
                          $active_tab = 'license';
                        else:
                          $active_tab = 'plugin_settings';
                        endif;
                      }
                  ?>  

            <h2 class="nav-tab-wrapper notranslate">
            <?php if (get_option('googlelanguagetranslator_license_key') == ''): ?>
            <a href="?page=google_language_translator_premium" class="nav-tab <?php echo $active_tab == 'plugin_settings' ? 'nav-tab-active' : ''; ?>">Auto-translation Settings</a>
            <a href="?page=google_language_translator_premium" class="nav-tab <?php echo $active_tab == 'manual_translation_module' ? 'nav-tab-active' : ''; ?>">Manual Translation Module</a>   
            <a href="?page=google_language_translator_premium" class="nav-tab <?php echo $active_tab == 'license' ? 'nav-tab-active' : ''; ?>">License</a>
            <?php else: ?>
            <a href="?page=google_language_translator_premium&tab=plugin_settings" class="nav-tab <?php echo $active_tab == 'plugin_settings' ? 'nav-tab-active' : ''; ?>">Auto-translation Settings</a>
            <a href="?page=manual_translation_module&tab=manual_translation_module" class="nav-tab <?php echo $active_tab == 'manual_translation_module' ? 'nav-tab-active' : ''; ?>">Manual Translation Module</a>   
            <a href="?page=license&tab=license" class="nav-tab <?php echo $active_tab == 'license' ? 'nav-tab-active' : ''; ?>">License</a>
            <?php endif; ?>
            </h2>
    <?php

	define('GLT_SECRET_KEY', '58587a94e33cc3.81094040');
	define('GLT_LICENSE_SERVER_URL', 'http://wp-studio.net/');

    $license_key_option = get_option('googlelanguagetranslator_license_key');

    if ($license_key_option != ''): ?>
      <script type="text/javascript" async="async"> 
        jQuery(document).ready(function($) {     
          $('#glt-settings').show();
          $('#glt-activation').hide();
          $('#glt-settings input').prop('disabled', false);
          setTimeout(function(){ $('#message').fadeOut('slow'); }, 2000);
         });
      </script>
    <?php else: ?>
      <script type="text/javascript" async="async">
        jQuery(document).ready(function($) {
             
          $('#glt-activation').show();
        });
      </script>

    <?php 
    endif;

    
  
    if (isset($_REQUEST['activate_license'])) {
      $license_key = $_REQUEST['googlelanguagetranslator_license_key'];
      $api_params = array(
        'secret_key' => GLT_SECRET_KEY,
        'slm_action' => 'slm_activate',
        'license_key' => $license_key,
        'registered_domain' => $_SERVER['SERVER_NAME'],
		'item_reference' => urlencode('Google Language Translator'),
      );

      $query = esc_url_raw(add_query_arg($api_params, GLT_LICENSE_SERVER_URL));
      $response = wp_remote_get($query, array('timeout' => 20));

      if (is_wp_error($response)) { ?>
        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo 'Unexpected error. Please try again.'; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
      <?php
      }

      $license_data = json_decode(wp_remote_retrieve_body($response), true);
        
      if($license_data['result'] == 'success') { ?>

        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo $license_data['message']; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div> 
 
       <?php if($license_data['result'] == 'success') { ?>
	  
	    <script type="text/javascript" async="async">
		  jQuery(document).ready(function($) {
			window.location.href = '?page=google_language_translator_premium';
		  });
	    </script>
        <?php } ?>

        <script type="text/javascript" async="async"> 
          jQuery(document).ready(function($) {    
            $('#glt-settings').show();
            $('#glt-activation').hide();
            $('#glt-settings input').prop('disabled', false);        
           });
        </script>

        <?php
        update_option('googlelanguagetranslator_license_key', $license_key); 
        update_option('googlelanguagetranslator_active',1);
      } else { ?>
        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo $license_data['message']; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>

        <script type="text/javascript" async="async">
        jQuery(document).ready(function($) {
          setTimeout(function(){ $('#message').fadeOut('slow'); }, 2000);
        });
        </script>
      <?php
      }
    }
   
    if (isset($_REQUEST['deactivate_license'])) {
      $license_key = $_REQUEST['googlelanguagetranslator_license_key'];

      $api_params = array(
        'slm_action' => 'slm_deactivate',
        'secret_key' => GLT_SECRET_KEY,
        'license_key' => $license_key,
        'registered_domain' => $_SERVER['SERVER_NAME'],
		'item_reference' => urlencode('Google Language Translator'),
      );
 
      $query = esc_url_raw(add_query_arg($api_params, GLT_LICENSE_SERVER_URL));
      $response = wp_remote_get($query, array('timeout' => 20));
      
      if (is_wp_error($response)) { ?>
        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo 'Unexpected error. Please try again.'; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
      <?php
      }
 
      $license_data = json_decode(wp_remote_retrieve_body($response), true);
      //var_dump($response);
      if($license_data['result'] == 'success') { ?>
        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo $license_data['message']; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
        
        <?php
          update_option('googlelanguagetranslator_license_key', '');
          update_option('googlelanguagetranslator_active',0);
        } else { ?>
        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo $license_data['message']; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
      <?php
        }   
      } ?>

    <div id="glt-activation">
    <?php echo 'hello'; ?>
    <p>Please enter the license key to activate GLT Premium. Your license key can be found in the email you received following your purchase.</p>
    <form class="glt-activation" action="" method="post">
        <table class="form-table">
            <tr>
                <th style="width:100px;"><label for="googlelanguagetranslator_license_key">License Key</label></th>
                <td ><input class="regular-text" type="text" id="googlelanguagetranslator_license_key" name="googlelanguagetranslator_license_key" value="<?php echo get_option('googlelanguagetranslator_license_key'); ?>"></td>
            </tr>
        </table>

        <p class="submit">
          <input type="submit" name="activate_license" value="Activate" class="button-primary" />
          <input type="submit" name="deactivate_license" value="Deactivate" class="button" />
        </p>

    </form>

    </div> <!-- #glt-activation -->

    <div id="glt-settings">
      <?php if (get_option('googlelanguagetranslator_license_key') != ''): ?>
        <form action="<?php echo admin_url('options.php'); ?>" method="post">
	  <div class="metabox-holder has-right-sidebar" style="float:left; width:65%">
            <div class="postbox glt-main-settings" style="width: 100%">
              <h3 class="notranslate">Main Settings</h3>
                <?php settings_fields('google_language_translator'); ?>
                  <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                    <tr>
		      <td class="notranslate">Activate auto-translation?<br/>(Manual translation <u>must</u> be turned-off to activate)</td>
                      <td class="notranslate"><?php $this->googlelanguagetranslator_active_cb(); ?></td>
                    </tr>				  
					  
		    <tr class="notranslate">
		      <td>Choose the original language of your website</td>
		      <td><?php $this->googlelanguagetranslator_language_cb(); ?></td>
		    </tr>
					  
		    <tr class="notranslate">
		      <td>Select a theme style:</td>
		      <td><?php $this->googlelanguagetranslator_theme_style_cb(); ?></td>
		    </tr>
                  </table>
                </div> <!-- .glt-main-settings -->

                <div class="postbox glt-layout-settings" style="width:100%">
                  <h3 class="notranslate">Layout Settings</h3>
                  <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                    <tr class="notranslate">
		      <td>What languages will display in the language switcher?<br/>("All Languages" <u>must</u> be chosen to display flags)</td>
		      <td><?php $this->googlelanguagetranslator_language_option_cb(); ?></td>
		    </tr>
					  
		    <tr class="notranslate languages">
		      <td colspan="2"><?php $this->language_display_settings_cb(); ?></td>
		    </tr>
					  
		    <tr class="notranslate">
		      <td class="choose_flags_intro">Show flag images?<br/>(Display up to 104 flags above the language switcher)</td>
		      <td class="choose_flags_intro"><?php $this->googlelanguagetranslator_flags_cb(); ?></td>
		    </tr>
					  
		    <tr class="notranslate choose_flags">
		      <td colspan="2" class="choose_flags">Choose the flags you want to display:</td>
                    </tr>
					  
		    <tr class="notranslate choose_flags">
		      <td colspan="2" class="choose_flags"><?php $this->flag_display_settings_cb(); ?></td>
		    </tr>			      
					  
		    <tr class="notranslate">
		      <td>Show or hide the language switcher?</td>
		      <td><?php $this->googlelanguagetranslator_translatebox_cb(); ?></td>
		    </tr>
					  
		    <tr class="notranslate">
                      <td>Layout options:</td>
		      <td><?php $this->googlelanguagetranslator_display_cb(); ?></td>
		    </tr>
					  
		    <tr class="notranslate">
                      <td>Show Google Toolbar?</td>
		      <td><?php $this->googlelanguagetranslator_toolbar_cb(); ?></td>
		    </tr>
					  
		    <tr class="notranslate">
	              <td>Show Google Branding?<br/>
	                <span>(<a href="https://developers.google.com/translate/v2/attribution" target="_blank">Learn more</a> about Google's Attribution Requirements.)</span>
                      </td>
		      <td>
                        <?php $this->googlelanguagetranslator_showbranding_cb(); ?>
                      </td>
		    </tr>
					  
		    <tr class="alignment notranslate">
		      <td class="flagdisplay">Align the translator left or right?</td>
		      <td class="flagdisplay"><?php $this->googlelanguagetranslator_flags_alignment_cb(); ?></td>
		    </tr>
                  </table>
                </div> <!-- .glt-layout-settings -->

                <div class="postbox glt-floating-widget-settings" style="width:100%">
                  <h3 class="notranslate">Floating Widget Settings</h3>
                  <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">					  
		    <tr class="notranslate">
		      <td>Show floating translation widget?<br/>
		        <span>("All Languages" option <strong><u>must</u></strong> be chosen to show widget.)</span>
		      </td>
		      <td>
                        <?php $this->googlelanguagetranslator_floating_widget_cb(); ?>
                      </td>
		    </tr>

                    <tr class="floating_widget_text notranslate">
                      <td>Custom text for the floating widget:</td>
                      <td><?php $this->googlelanguagetranslator_floating_widget_text_cb(); ?></td>
                    </tr>

                    <tr class="floating_widget_text notranslate">
                      <td>Allow floating widget text to translate?:</td>
                      <td><?php $this->googlelanguagetranslator_floating_widget_text_allow_translation_cb(); ?></td>
                    </tr>

                    <tr class="floating_widget_text notranslate">
	              <td>Floating Widget Position <strong style="color:red">(New!)</strong></td>
		      <td><?php $this->googlelanguagetranslator_floating_widget_position_cb(); ?></td>
		    </tr>
                  </table>
                </div> <!-- .glt-floating-widget-settings -->

                <div class="postbox glt-performance-settings">
                  <h3 class="notranslate">Behavior Settings</h3>
                    <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                      <tr class="multilanguage notranslate">
		        <td>Multilanguage Page Option:</td>
			<td><?php $this->googlelanguagetranslator_multilanguage_cb(); ?></td>
		      </tr>

                      <tr class="notranslate">
		        <td>Reload pages with <code>lang</code> attribute?</td>
		        <td><?php $this->googlelanguagetranslator_lang_urls_cb(); ?></td>
		      </tr>
					  
	              <tr class="notranslate">
		        <td>Google Analytics:</td>
			<td><?php $this->googlelanguagetranslator_analytics_cb(); ?></td>
		      </tr>
					  
		      <tr class="analytics notranslate">
		        <td>Google Analytics ID (Ex. 'UA-11117410-2')</td>
		        <td><?php $this->googlelanguagetranslator_analytics_id_cb(); ?></td>
		      </tr>

                      <tr class="notranslate">
		        <td>Add CSS selectors to exclude translation<br/>(Ex: #access, #site-title, #site-description)</td>
		        <td><?php $this->googlelanguagetranslator_exclude_translation_cb(); ?></td>
		      </tr>
		    </table>
                  </div> <!-- .glt-performance-settings -->

                  <div class="postbox glt-usage-settings">
                    <h3 class="notranslate">Usage</h3>
		    <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                                          <tr class="notranslate">
						<td>Full widget usage in pages/posts/sidebar:</td>
						<td><code>[google-translator]</code></td>
                                          </tr>

					  <tr class="notranslate">
						<td style="width:40%">Usage in header/footer/template:</td>
						<td style="width:60%"><code>&lt;?php echo do_shortcode('[google-translator]'); ?&gt;</code></td>
					  </tr>
					
					  <tr class="notranslate">
						<td colspan="2">Add a single language to menus/pages/posts:</td>
					  </tr>
					
					  <tr class="notranslate">
						<td colspan="2"><code>[glt language="Spanish" label="Espa&ntilde;ol" image="yes" text="yes" image_size="24"]</code></td>
					  </tr>

                      <tr class="notranslate">
						<td colspan="2"><em>For menu usage, use a custom link as your menu item. Enable "descriptions" located in the upper-right corner of "Appearance > Menus".  Place shortcode into the "description" field, use <code style="border:none">#</code> for the URL, and create menu title of your choice. </em></td>                     
                      </tr>
					  
					  <tr class="notranslate">
						<td><?php submit_button(); ?></td>
						<td></td>
					  </tr>
	            </table>	  
		  </div> <!-- .glt-usage-settings -->
		  </div> <!-- .metbox-holder -->
		  
		  <div class="metabox-holder" style="float:right; clear:right; width:33%; min-width:350px; ">
		    <div class="postbox glt-preview-settings">

		      <h3 class="notranslate">Preview</h3>
	            <table style="width:100%">
		          <tr>
					<td style="box-sizing:border-box; -webkit-box-sizing:border-box; -moz-box-sizing:border-box; padding:15px 15px; margin:0px"><span style="color:red; font-weight:bold" class="notranslate">(New!)</span><span class="notranslate"> Drag &amp; drop flags to change their position.</span><br/><br/><?php echo do_shortcode('[google-translator]'); ?><p class="hello"><span class="notranslate">Translated text:</span> &nbsp; <span class="translate">Hello</span></p></td>
		          </tr>
		        </table>

		    </div> <!-- .postbox -->
	      </div> <!-- .metabox-holder -->
		  
		  <div id="glt_advanced_settings" class="metabox-holder notranslate" style="float: right; width: 33%;">
          <div class="postbox glt-advanced-settings">
            <h3>Advanced Settings</h3>
			<div class="inside">
			 
			    <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
				  
				      <tr class="notranslate">
				        <td class="advanced">Flag container width:</td>
						<td class="advanced"><?php $this->googlelanguagetranslator_flagarea_width_cb(); ?></td>
                      </tr>  
				  
				      <tr class="notranslate">
				        <td class="advanced">Select flag size:</td>
						<td class="advanced"><?php $this->googlelanguagetranslator_flag_size_cb(); ?></td>
                      </tr>
				  
				      <tr class="notranslate">
						<td class="advanced">Language switcher width</td>
						<td class="advanced"><?php $this->googlelanguagetranslator_languagebox_width_cb(); ?></td>
                      </tr> 
		
				      <tr class="notranslate">
						<td class="advanced">Language box flags?</td>
						<td class="advanced"><?php $this->googlelanguagetranslator_languagebox_flags_cb(); ?></td>
                      </tr>  
				  
				      <tr class="notranslate">
						<td class="advanced">Flag for English:</td>
						<td class="advanced"><?php $this->googlelanguagetranslator_english_flag_choice_cb(); ?></td>
				      </tr>
				  
				      <tr class="notranslate">
						<td class="advanced">Flag for Spanish:</td>
						<td class="advanced"><?php $this->googlelanguagetranslator_spanish_flag_choice_cb(); ?></td>
				      </tr>
				  
				      <tr class="notranslate">
						<td class="advanced">Flag for Portuguese:</td>
						<td class="advanced"><?php $this->googlelanguagetranslator_portuguese_flag_choice_cb(); ?></td>
				      </tr>

                                      <tr class="notranslate">
						<td class="advanced">Activate language detection?:</td>
						<td class="advanced"><?php $this->googlelanguagetranslator_browser_language_detection_cb(); ?></td>
				      </tr>


			    </table>
			   
			 </div>
          </div>
	   </div>
				
	   <div class="metabox-holder notranslate" style="float: right; width: 33%;">
          <div class="postbox glt-css-override-settings">
            <h3>CSS Overrides</h3>
			<div class="inside">
			 
			   
			  <p>"Elegant" theme requires that HTML elements surrounding the translator be set to <code>overflow:visible</code>.  If you have any elements set to <code>overflow:hidden</code>, you might experience display issues.</p> 
				  <p>You can apply any necessary CSS styles below:</p>
			      <?php $this->googlelanguagetranslator_css_cb(); ?>
				
			   
			 </div>
          </div>
	   </div>
        

        <div class="metabox-holder notranslate" style="float: right; width: 33%;">
          <div class="postbox">
            <h3>Need more powerful translation?</h3>
			<div class="inside"><a href="http://gtranslate.net/?xyz=1565" target="_blank"><img src="<?php echo plugins_url( 'images/logo_slogan.png' , __FILE__ ); ?>" alt="GTranslate" width="200" /></a>
			  <p>GTranslate not only helps you define and implement a successful Multilingual SEO strategy, but also makes sure you are found by your potential clients all around the world regardless of their language.<br /><br /></p>
				
                
                <br />
               <br />
             </div>
          </div>
	   </div>
				<input id="order" name="googlelanguagetranslator_flags_order" value="<?php print_r(get_option('googlelanguagetranslator_flags_order'));?>" type="hidden" /><input name="googlelanguagetranslator_license_key" value="<?php echo get_option('googlelanguagetranslator_license_key'); ?>" type="hidden" />

	</form>
		  
	    <div class="metabox-holder notranslate" style="float: right; width: 33%;">
          <div class="postbox">
            <h3>Please Consider A Donation</h3>
              <div class="inside">If you like this plugin and find it useful, help keep this plugin actively developed by clicking the donate button <br /><br />
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                  <input type="hidden" name="cmd" value="_donations">
                  <input type="hidden" name="business" value="robertmyrick@hotmail.com">
                  <input type="hidden" name="lc" value="US">
                  <input type="hidden" name="item_name" value="Support Studio 88 Design and help us bring you more Wordpress goodies!  Any donation is kindly appreciated.  Thank you!">
                  <input type="hidden" name="no_note" value="0">
                  <input type="hidden" name="currency_code" value="USD">
                  <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
                  <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                  <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>

                <br />
               <br />
             </div>
          </div>
	   </div>	
<div class="clear"></div>
 <?php endif; ?>
 </div> <!-- #glt-settings -->
</div> <!-- .wrap -->

<?php 
  }

  public function manual_translation_module_page_layout_cb() { ?>
    
    <div id="glt-settings" class="wrap" style="width:89%">
                   <?php  
                      if( isset( $_GET[ 'tab' ] ) ) {  
                          $active_tab = $_GET[ 'tab' ];  
                      } else {
                          $active_tab = 'plugin_settings';
                      }
                  ?>  

            <h2 class="nav-tab-wrapper notranslate">
                <?php if (get_option('googlelanguagetranslator_license_key') == ''): ?>
            <a href="?page=google_language_translator_premium" class="nav-tab <?php echo $active_tab == 'plugin_settings' ? 'nav-tab-active' : ''; ?>">Auto-translation Settings</a>
            <a href="?page=manual_translation_module" class="nav-tab <?php echo $active_tab == 'manual_translation_module' ? 'nav-tab-active' : ''; ?>">Manual Translation Module</a>   
            <a href="?page=license&tab=license" class="nav-tab <?php echo $active_tab == 'license' ? 'nav-tab-active' : ''; ?>">License</a>
            <?php else: ?>
            <a href="?page=google_language_translator_premium&tab=plugin_settings" class="nav-tab <?php echo $active_tab == 'plugin_settings' ? 'nav-tab-active' : ''; ?>">Auto-translation Settings</a>
            <a href="?page=manual_translation_module&tab=manual_translation_module" class="nav-tab <?php echo $active_tab == 'manual_translation_module' ? 'nav-tab-active' : ''; ?>">Manual Translation Module</a>   
            <a href="?page=license&tab=license" class="nav-tab <?php echo $active_tab == 'license' ? 'nav-tab-active' : ''; ?>">License</a>
            <?php endif; ?>
            </h2>

            <form action="<?php echo admin_url('options.php'); ?>" method="post">
	       <div class="metabox-holder has-right-sidebar">
                <div class="postbox glt-main-settings" style="width:100%">
                  <h3 class="notranslate">Main Settings</h3>
                    <?php settings_fields('google_language_translator2'); ?>
                    <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                        <tr>
                          <td>Check this box to activate manual translation<br/>(Auto translation <u>must</u> be turned-off to activate)</td>
                          <td><?php echo $this->googlelanguagetranslator_activate_manual_language_cb(); ?></td>
                        </tr>

                        <tr>
                          <td colspan="2">
                            <?php add_thickbox(); ?>
			    <a href="#TB_inline?width=600&height=550&inlineId=manual-translation-help" class="thickbox" title="Manual Translation Module">How to Setup Manual Translation</a>
			      <div id="manual-translation-help" style="display:none">
                                <p>Manual translation is for users who want full control over translated pages. All pages are stored inside of Wordpress, and you have full capability to  edit translations.</p> 
                                <p><strong>By activating Manual Translation, auto-translation becomes disabled.</strong></p>
                                <h3>How it works:</h3>
                                <p>Our plugin requires you to copy content from your ORIGINAL pages/posts in your default language, then paste that content into NEW, translated pages.</p>
                                <ul>
                                  <li><p><strong> Upon activating manual translation, a new menu labeled "Languages" appears the left Wordpress menu.</strong></p></li>
				  <li><p><strong>Translated pages must use the same PAGE SLUG as your original post or page.</strong></p></li>
                                  <li><p><strong>Permalinks might need to be flushed after creating your first translated page. Navigate to "Settings > Permalinks" and save your settings twice to ensure the settings are flushed and updated.</strong></p></li>
                                </ul>

                                <h3>Page Slug</h3>

                                <p>You can find the slug of your original post/page by visiting "Edit Screen" for that specific page or post. The page slug is located under the title, at the end of the Permalink. For example, if your website has a page named "Sample Page", the page slug would be "sample-page" and is found at the end of the permalink (http://www.example.com/sample-page).</p>
				
				<hr/>
				<h3>Getting started:</h3>
                                <ol>
                                <li><p><strong>DE-ACTIVATE auto-translation by removing check mark from AUTO-TRANSLATION settings page. ACTIVATE manual translation by placing check mark on the MANUAL TRANSLATION settings page.</strong></p></li>
                                <li><p><strong>Activate a new language by placing a check mark in the language list</strong></p></li>
                                <li><p><strong>Choose whether to show/hide the language switcher for translated pages</strong></p></li>
                                <li><p><strong>Save settings</strong></p></li>
                                </ol>

                                <p>Notice the new menu "Languages" in the left menu.  Under this menu you will see your chosen languages, and you will store all of your pages/posts under each language.</p>

                                <h3>Create Your First Translated Page</h3>
                                <ol>
				<li><p><strong>Navigate to an ORIGINAL post or page of your choice</strong></p></li>
                                <li><p><strong>Make sure that you are displaying the "Visual" text editor. Copy the content inside of the text editor by highlighting it. You can copy your images and non-text content, but you will likely need to re-position them later. Just copy everything in the text editor for now.</strong></p></li>  
                                <li><p><strong>Take note of the PAGE SLUG for later use</strong></p></li>
                                <li><p><strong>Navigate to the "Languages" menu and select your desired language in the sub-menu</strong></p></li>
                                <li><p><strong>Add a new page and give it a title of your choice. Paste your copied content into the text editor (Visual).</strong></p></li>
                                <li><p><strong>Click "Publish" to save the content.</strong></p></li>
                                <li><p><strong>Click "Preview" to ensure that the new page is created on your website.<br/>(Note: Your new web page may not yet look the way you want.)</strong></p></li>
                                </ol>

				<p>At this point, if you have done everything correctly you should now have a NEW page created under the "Languages" menu, and it should contain the original content that you copied previously.</p>

                                <h3>Translate Your Content</h3>
				<p>Under the text editor there is a box is a box labeled "Translation Workspace". Notice that the content of your NEW page will display here.</p>

                                <ol>
                                <li><p><strong>Notice the Google Translate widget. Use Google's auto-translation tool to translate content into your new language</strong></p></li>
                                <li><p><strong>Copy/paste the translated content into the text editor above.</strong></p></li>
				<li><p><strong>Click "Update" to save the new translated content.</strong></p></li>
                                <li><p><strong>Click "Preview" to view the new translated content.<br/>(Remember: you will need to manually adjust any non-text content (i.e. images, iframes, etc) so that it displays correctly on your new page.)</strong></p></li>  
                                <li><p><strong>You're finished! Feel free to edit translations as needed!</strong></p></li>
                                </ol>

                                <h3>Create a Custom Template for Translated Pages</h3>
                                <p>GLT uses "single.php" from your current theme to display translated pages. You can override this template and modify it to suit your needs. You will need to create a new template file to do this.</p>

                                <p>To create a new template:</p>
                                <ol>
                                <li><p><strong>Login to your hosting account or gain access to your website files via FTP.</strong></p></li>
                                <li><p><strong>Navigate to your current theme folder and create a new folder named "translation". For example, you will create a folder that appears like this: "http://yoursite.com/wp-content/themes/your-current-theme/translation".</strong></p></li>
                                <li><p><strong>Create a new file named "single.php". For example, your file location should look like this: "http://yoursite.com/wp-content/themes/your-current-theme/translation/single.php".</strong></p></li>
                                <li><p><strong>Add code for your new page template. Start by copying the code from your theme's "single.php" file, then paste it into the NEW "single.php" you just created. Feel free to modify the layout to suit your specific needs.</strong></p></li>
                                <li><p><strong>GLT will now use this new file to display translated pages! If your page does not look correct, there might be some type of conflict with your website.  WP Studio will be happy to help you resolve the issue and get you up and running! We are confident that manual translation will work on your site, although sometimes issues arise that require attention.</strong></p></li>
                                </ol>

				<p>If you need assistance of any kind, please <a href="http://wp-studio.net/contact/" target="_blank">feel free to contact us here</a>.</p>
                              </div>
						  </td>
                          
                        </tr>
                      
                        <tr>
						  <td class="notranslate">Activate languages below:<br/>(Default language <u>MUST</u> be checked to work properly)</td>
                          <td class="notranslate"></td>
                        </tr>
                                   
                        <tr class="notranslate">
			              <td colspan="2" class="choose_flags">  
                            <?php echo $this->googlelanguagetranslator_manual_language_display_settings_cb(); ?>
                          </td> 
                        </tr>
					  
					    <tr class="notranslate">
						  <td>Show the langauge switcher in your posts and pages?</td>
						  <td><?php echo $this->googlelanguagetranslator_manual_language_switcher_cb(); ?></td>
					    </tr>

                        <tr class="notranslate">
			              <td><?php submit_button(); ?></td>
			              <td></td>
			            </tr>
                      </table>
                  </div>
               </div>
            </form>
    </div>
<?php
  }

   public function license_layout_cb() { ?>
    <div id="glt-license-settings" class="wrap" style="width:89%">
    
    <?php  
                      if( isset( $_GET[ 'tab' ] ) ) {  
                          $active_tab = $_GET[ 'tab' ];  
                      } else {
                          $active_tab = 'plugin_settings';
                      }
                  ?>  

            <h2 class="nav-tab-wrapper notranslate">
                <?php if (get_option('googlelanguagetranslator_license_key') == ''): ?>
            <a href="?page=google_language_translator_premium" class="nav-tab <?php echo $active_tab == 'plugin_settings' ? 'nav-tab-active' : ''; ?>">Auto-translation Settings</a>
            <a href="?page=google_language_translator_premium" class="nav-tab <?php echo $active_tab == 'manual_translation_module' ? 'nav-tab-active' : ''; ?>">Manual Translation Module</a>   
            <a href="?page=license&tab=license" class="nav-tab <?php echo $active_tab == 'license' ? 'nav-tab-active' : ''; ?>">License</a>
            <?php else: ?>
            <a href="?page=google_language_translator_premium&tab=plugin_settings" class="nav-tab <?php echo $active_tab == 'plugin_settings' ? 'nav-tab-active' : ''; ?>">Auto-translation Settings</a>
            <a href="?page=manual_translation_module&tab=manual_translation_module" class="nav-tab <?php echo $active_tab == 'manual_translation_module' ? 'nav-tab-active' : ''; ?>">Manual Translation Module</a>   
            <a href="?page=license&tab=license" class="nav-tab <?php echo $active_tab == 'license' ? 'nav-tab-active' : ''; ?>">License</a>
            <?php endif; ?>
            </h2>
    <div id="icon-options-general" class="icon32"></div>

    <?php
    
    define('GLT_SECRET_KEY', '58587a94e33cc3.81094040');
    define('GLT_LICENSE_SERVER_URL', 'http://wp-studio.net/');
  
    if (isset($_REQUEST['activate_license'])) {
      $license_key = $_REQUEST['googlelanguagetranslator_license_key'];

      $api_params = array(
        'slm_action' => 'slm_activate',
        'secret_key' => GLT_SECRET_KEY,
        'license_key' => $license_key,
        'registered_domain' => $_SERVER['SERVER_NAME'],
		'item_reference' => urlencode('Google Language Translator'),
      );

      $query = esc_url_raw(add_query_arg($api_params, GLT_LICENSE_SERVER_URL));
      $response = wp_remote_get($query, array('timeout' => 20));
	  $license_data = json_decode(wp_remote_retrieve_body($response), true);
	  //var_dump($response);
      if ($license_data->result == 'error') { ?>
        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo 'Unexpected error. Please try again.'; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
      <?php
      }

      
	  //var_dump($response);
      if($license_data->result == 'success') { ?>

        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo $license_data->message; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
        
        <script type="text/javascript" async="async"> 
        jQuery(document).ready(function($) {        
          window.location.href = '?page=google_language_translator_premium';
         });
        </script>

        <?php
        update_option('googlelanguagetranslator_license_key', $license_key); 
        update_option('googlelanguagetranslator_active',1);
      } else { ?>
        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo $license_data->message; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
      <?php
      }
    }
   
    if (isset($_REQUEST['deactivate_license'])) {
      $license_key = $_REQUEST['googlelanguagetranslator_license_key'];

      $api_params = array(
        'slm_action' => 'slm_deactivate',
        'secret_key' => GLT_SECRET_KEY,
        'license_key' => $license_key,
        'registered_domain' => $_SERVER['SERVER_NAME'],
		'item_reference' => urlencode('Google Language Translator'),
      );
 
      $query = esc_url_raw(add_query_arg($api_params, GLT_LICENSE_SERVER_URL));
      $response = wp_remote_get($query, array('timeout' => 20));
	  //var_dump($response);
      if (is_wp_error($response)) { ?>
        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo 'Unexpected error. Please try again.'; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
      <?php
      }
 
      $license_data = json_decode(wp_remote_retrieve_body($response), true);

      if($license_data->result == 'success') { ?>
	  
	    <script type="text/javascript" async="async">
		  jQuery(document).ready(function($) {
			window.location.href = '?page=google_language_translator_premium';
		  });
	    </script>
        <?php
          update_option('googlelanguagetranslator_license_key', '');
          update_option('googlelanguagetranslator_active',0);
        } else { ?>

        <div id="message" class="updated notice is-dismissible notranslate"><p><?php echo $license_data->message; ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
      <?php
        }   
      } ?>

    <div id="glt-activation">
    <p>Click "Deactivate" below if you wish to disconnect your license. You may re-activate your license at any time.</p>
    <form class="glt-activation" action="" method="post">
        <table class="form-table">
            <tr>
                <th style="width:100px;"><label for="googlelanguagetranslator_license_key">License Key</label></th>
                <td ><input class="regular-text" type="text" id="googlelanguagetranslator_license_key" name="googlelanguagetranslator_license_key" value="<?php echo get_option('googlelanguagetranslator_license_key'); ?>"></td>
            </tr>
        </table>

        <p class="submit">
          <input type="submit" name="activate_license" value="Activate" class="button-primary" />
          <input type="submit" name="deactivate_license" value="Deactivate" class="button" />
        </p>

    </form>
</div> <!-- #glt-activation -->

<?php 
}

  public function about_wordpress_translation_page_layout_cb() { ?>
    <div class="wrap" style="width:89%">
	      <div id="icon-options-general" class="icon32"></div>
                  <?php  
                      if( isset( $_GET[ 'tab' ] ) ) {  
                          $active_tab = $_GET[ 'tab' ];  
                      } else {
                          $active_tab = 'plugin_settings';
                      } ?>  
            <h2 class="nav-tab-wrapper notranslate">
                <!--<span class="notranslate">Google Language Translator</span>-->
            <a href="?page=google_language_translator_premium&tab=plugin_settings" class="nav-tab <?php echo $active_tab == 'plugin_settings' ? 'nav-tab-active' : ''; ?>">Auto-translation Settings</a>
            <a href="?page=manage_languages&tab=manual_translation_module" class="nav-tab <?php echo $active_tab == 'manual_translation_module' ? 'nav-tab-active' : ''; ?>">Manual Translation Module</a>
            <!--<a href="?page=about_wordpress_translation&tab=about_wordpress_translation" class="nav-tab <?php echo $active_tab == 'about_wordpress_translation' ? 'nav-tab-active' : ''; ?>">About Wordpress Translation</a>-->
            </h2>
            <form action="<?php echo admin_url('options.php'); ?>" method="post">
	       <div class="metabox-holder has-right-sidebar" style="float:left; width:65%">
                <div class="postbox" style="width: 100%">
                  <h3 class="notranslate">About Wordpress Translation</h3>
                  <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                    <tr>
		      <td colspan="2" class="notranslate">
                        <a href="#">How does Wordpress translation work?</a><br/><br/>
                        <a href="#">I heard that Wordpress offers translation files to translate my website. Why not just install language files?</a><br/><br/>
                        <a href="#">What is necessary to translate my website in full?</a><br/><br/>
                        <a href="#">What are .PO and .MO files?</a><br/><br/>
                        <a href="#">Can I use .PO/.MO files to translate my web pages and blog posts?</a><br/><br/>
                        <a href="#">What is the difference between auto-translation and manual translation?</a><br/><br/>
                        <a href="#">What is the best method to use for translating my website?</a><br/><br/>
                        <a href="#">What exactly does a .PO/.MO file do?</a>
                      </td>
		      <td class="notranslate"></td>
                    </tr>
                  </table>
                </div>
               </div>
            </form>
    </div>
<?php }}
$google_language_translator = new google_language_translator_premium();

require 'plugin-update-checker/plugin-update-checker.php';

$myUpdateChecker = PucFactory::buildUpdateChecker('http://wp-studio.net/updates/glt-info.json', __FILE__ ); ?>