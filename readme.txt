=== Google Language Translator Premium ===

Contributors: Rob Myrick
Donate link: https://www.paypal.com/us/cgi-bin/webscr?cmd=_flow&SESSION=c6aycTLE8Qho4lN9-QgzmJQKxNrRLomhJQ8gEAM2t5EZc5enxqC4Dpii-1C&dispatch=5885d80a13c0db1f8e263663d3faee8d0b7e678a25d883d0fa72c947f193f8fd
Plugin link: http://wp-studio.net/
Tags: language translator, google translator, language translate, google, google language translator, translation, translate, multi language
Requires at least: 2.9
Tested up to: 4.7.3
stable tag: 5.0.35

Welcome to Google Language Translator! This plugin allows you to insert the Google Language Translator tool anywhere on your website using shortcode.

== Description ==

Settings include: inline or vertical layout, show/hide specific languages, hide/show Google toolbar, and hide/show Google branding. Add the shortcode to pages, posts, and widgets.

== Installation ==

1. Download the zip folder named google-language-translator.zip
2. Unzip the folder and put it in the plugins directory of your wordpress installation. (wp-content/plugins).
3. Activate the plugin through the plugin window in the admin panel.
4. Go to Settings > Google Language Translator, enable the plugin, and then choose your settings.
5. Copy the shortcode and paste it into a page, post or widget.
6. Do not use the shortcode twice on a single page - it will not work.

== Frequently Asked Questions ==

Q: What is the manual translation module?

A: This module helps you create and store permanent translations.  Translations are not cached (due to Google restrictions); but instead, they are stored directly in the database after you copy/paste them yourself. We simply provide the automated Google Translate tool, then we let you copy/paste translations directly into your posts/pages. 

Q: How does manual translation work? 

A: When you activate manual translation, a new menu will appear in your Wordpress Dashboard, called "Languages". Under this menu, you can duplicate your posts/pages and store them here separately, as translated posts/pages. All translations, up to 81+ languages, can be stored and managed here.  

Q: Can I edit manual translations?

A: Yes! Since all content that you translate is stored in the database, you can edit anything you want using the content editor.  Simply copy/paste the exact text that you want and place it inside of the text editor, then save!

Q: Content in manual translation does not use the same page template as my original page. Can I use my own page template?

A: Yes! In our update to version 5.0.16, custom template overrides are now possible. Simply create a new folder in the directory of your active theme, and name it "translation". Then place a new file inside of that folder, named "single.php". You can then add code from your theme's "single.php" file, to the new "single.php" file inside of the "translation" folder, and then modify according to your needs. 

Q: What should I do if the translate widget does not show on my website?

1. Make sure that the plugin is installed and activated.
2. Verify that a check mark is placed in the activation setting located at "Settings > Google Language Translator".
3. Verify that "Show Language Box?" setting is enabled at "Settings > Google Language Translator".
4. Use your browser's web tools to ensure that CSS styles are not hiding the translation widget.
5. Contact support at http://www.wp-studio.net/submit-ticket. 

Q: What should I do if there are no languages being displayed in the language box?

1. Make sure that the plugin is installed and activated.
2. Verify that a check mark is placed in the activation setting located at "Settings > Google Language Translator".
3. Verify that Adobe Flash is installed in your web browser. Google uses Flash in order to display their language box.
4. Contact support at http://www.wp-studio.net/submit-ticket.

Q: Can I exclude certain areas of my website from being translated?
A: Yes! Add the "notranslate" class to the HTML element containing your text. For example, the following text will be excluded from translation: <span class="notranslate">Hello World!</span>

== Changelog ==

5.0.35

- Modified the timing of footer javascript.
- Fixed an issue with the lang parameter not working properly.
- Changed Chinese (Traditional) language flag to the Flag of Taiwan.
- Fixed a minor display issue with the Google Analytics setting in Wordpress Dashboard.
- Change all scripts in googlelanguagetranslator.php to load asynchronously.

5.0.34

- Fixed a major issue with language detection settings. Code for language detection is now hooked into the 'wp_footer' action.
- Updated to jQuery versio 1.4.1.

5.0.33

- Fixed an error with the language switcher not functioning properly when the "lang" attribute setting is activated.

5.0.32

- Automated the process of sending license keys when a purchase is made at http://wp-studio.net. Users will receive their license key immediately via email.
- Fixed a small display error on the settings page.
- Added the $ver parameter to all enqueued scripts and styles. This will ensure that all files are refreshed when an update is made.

5.0.31

- Fixed a CSS display issue with the settings screen. We apologize for any inconvenience.

5.0.30

- Fixed a CSS display issue with the Floating Widget toolbar.
- Improved the GLT Settings page dislay.
- Changed the name of PHP classes to reflect a more unique name (to avoid error messages if user have both free and premium versions activated).

5.0.29

- Removed toolbar.js and flags.js and combined to existing files (to improve efficiency of page load and http requests).
- Added new setting to allow or prevent floating widget text to translate.
- Added new setting for custom text in the Floating Widget.
- Removed "notranslate" class from the Floating Widget text to allow for translation.

5.0.28

- Fixed a CSS display issue with horizontal layout for the elegant theme. It was improperly displaying Google branding twice.
- Added SIMPLE layout (make sure to choose "Classic" theme setting, then SIMPLE will appear as a layout option).
- Improved functionality for flags. Users are now returned to original language when the flag is displayed. The Google Toolbar will be hidden once returning back to the original language. The Google Toolbar will appear again when another translation is made.

5.0.27

- Added 8 new languages with their associated flags: Hawaiian, Kurdish, Kyrgyz, Luxembourgish, Pashto, Shona, Corsican, Amharic.

5.0.26

- Fixed CSS for single language shortcodes. English, Spanish and Portuguese were not able to display the correct customized flags chosen by the user in Advanced Settings.

5.0.25

- Added Sindhi and Frisian as a new languages with their associated flags.

5.0.24

- Added Xhosa and Samoan as a new languages with their associated flags.
- Renamed some of the wp_enqueue_script calls to include more unique file names, thus avoiding conflict with other plugins overriding these files.

5.0.23

- Fixed "256 characters of unexpected output" error upon plugin activation.
- Fixed a glitch with clicking the language drop-down. Translation was firing when the drop-down was clicked initially, but also fired again when a user chose a language. This should no longer happen.
- Eliminated a glitch with flags.js. The firing function was being loaded twice, which caused the Google Toolbar to display the language improperly when going back to the original language.
- Made a simple improvement to CSS for the mobile settings page.

5.0.22

- Fixed an issue with license key activation.

5.0.21

- Having upgrade issues with using 5.0.2 version - bumping to 5.0.21.

5.0.2

- Fixed a problem with the Google Toolbar not displaying in the settings page.
- Fixed a problem with the "Preview" area not translating text properly.
- Fixed a problem with jQuery that produced a 404 page error when translation was placed as a navigation menu item.
- Fixed a problem with the browser language detection setting - the checkbox will now save properly. Sorry for the inconvenience!

5.0.19

- Fixed a settings registration error preventing the manual translation options page not to display. Sorry!

5.0.18

- Re-factored code for settings registration.
- Fixed PHP error related to the /install/uninstall hook.
- Added new option "Browser Language Detection".  If activated, website visitors will see your website in their native browser language upon their first visit. GLT currently supports 76 different browser language codes.

5.0.17

- Fixed an issue with "glt_locate_template" function.  The function now runs only when manual translation is activated.

5.0.16

- Added capability for users to use a custom template for displaying manual translation. GLT uses a Custom Post Type to manage manual translations, so GLT previously was limited to using "single.php" for displaying a translated page. To create a custom page template, add a new folder named "translation" to your current theme directory. Then create a file inside this folder and name it single.php.  Use any code you want to display your translated page content.
- Fixed the manual translation switcher to show the current language and flag that is being displayed to the user.
- Fixed problematic CSS styles associated with the page/post edit screens when creating manual translation pages.
- Fixed major issue with language switcher displaying "undefined" upon user's first visit to translatable pages.

5.0.15

- Updated another error in flag display - the custom flag choice was not showing the correctly in the floating widget.  This happened only when used on it's own, and not when used on the same page as the [google-translator] shortcode.
- Added Select All / Clear All links to the language and flag checkboxes. 

5.0.14

- Added new option "Floating Widget Position", see settings panel located at "Settings > Google Language Translator Premium.
- Updated the flag display setting for the menu language shortcode. Previously, it was not showing/hiding the flag due to the migration of flag images over to a single image sprite.

5.0.13

- Added licensing management.  If you don't have a license key and you purchased the plugin, you can request a key at http://wp-studio.net/contact/
- Added functionality to auto-update the plugin directly from the Wordpress Dashboard.

5.0.12

- Adjusted CSS to reflect the correct flag sizes in the Floating Widget toolbar.

5.0.1

- Migrated all flag images into an image sprites. 
- Added 10 new languages and associated flags: Chichewa, Kazakh, Malagasy, Malayalam, Myanmar(Burmese), Sesotho, Sinhala, Sundanese, Tajik, and Uzbek.

5.0.0

- Updated jQueryUI scripts to load internally from Wordpress, instead of separate files. 
- Removed all jQueryUI related files from the plugin.

4.0.9

- Fixed 3 additional PHP sytax errors in googlelanguagetranslator.php.

4.0.8

- Fixed 3 undefined index PHP errors ($default_language_name) found in googlelanguagetranslator.php.
- Updated a link in the support documentation, which was being directed to a porn site outside of WPStudio. We owned this domain at one time, but no longer have any control of that domain, or the content located there.
- Changed minor CSS styles in style.php.

4.0.7

- Fixed an important display issue associated with the manual translation module. Previously, when activating manual translation, the language switcher did not display.  Website visitors could not see that translation was available. This is now fixed.

4.0.6

- Fixed issues with language switcher displaying jQuery code in the image "alt" tags. Now those "alt" tags will properly display the language name.

4.0.5

- Fixed an issue with "alt" tags displaying the incorrect information in vertical layout. In some cases, "alt" tags were displaying image width instead of the language name.

4.0.4

- Added "alt" tag to single language images. (For example, when languages are place using single language shortcode, i.e. [glt lanuage="Spanish" image="yes"])

4.0.3

- Fixed multiple "undefined variable" errors found in googlelanguagetranslator.php.

4.0.2

- Fixed a syntax error that was preventing the "Specific Languages" drop-down from displaying.

4.0.1

- Added Manual Translation Module, which makes translation available for storage in single pages/posts. A language drop-down is provided for your users to switch back and forth between the translated pages/posts you choose to build. Please see the documentation here to understand fully how to use it: http://wp-studio.net/manual-translation/
- Re-factored some specific lines of code that seemed to throw errors in the latest update of Wordpress 4.0.  
- Re-factored code in 'googlelanguagetranslator.php' to be more efficient, which resulted in about 1000 less, lines of code.
- Fixed the issue with ALT tags display the image size for its value.
- Fixed the issue with width/height attributes of flag images, incorrectly using "px" in their values.

4.0.0

- Fixed a major footer script error, which caused single menu language translations not to function.

3.0.9

- Fixed the incorrect image links for the menu translation shortcode - images were not displaying at all.  I apologize for this inconvenience.
- Made some minor CSS changes to ensure plugin styles are not overridden by Wordpress themes.

3.0.8

- Added NEW shortcode!  Allows placement of single languages into the navigation menu. See settings panel for usage.
- Eliminated 1 PHP error (only known error currently)
- Re-factored code in googlelanguagetranslator.php to improve efficiency
- Removed "de-activation" hook. Added "uninstall" hook instead. Settings will be preserved until user deletes the plugin completely. 
- Updated CSS styles for the flags area to prevent themes from overriding layouts. 

3.0.7

- Updated 5 PHP errors.

3.0.6

- Added drag/drop functionality to the flags, in order to allow customized display.
- Added flag choices for 3 languages. English can now display either United States, United Kingdom, or Canadian flags. Spanish can now display either Spanish or Mexican flag. Portuguese can now display either Brazilian flag or Portuguese flag.
- Added functionality to add 'lang' attribute to URLs (includes page reload). This feature has zero SEO benefit, as Google does not provide incentive for auto-generated translations in Google Search. This feature is mostly for convenience, in that website visitors can change the language attribute in the address bar to trigger the language being displayed.
- Re-factored much of the old, inefficient code. The plugin now loads more quickly and increases page speed to some extent.

3.0.5

- Added new Floating Widget (see settings page). The Floating Widget is simply another way for allowing website visitors to translate languages.  The functionality is built-in with the existing flag preferences, and can be turned on or off at the administrator's preference. The floating widget can also function in full with both the language box and/or flags showing OR hiding, so the administrator has full control of how it displays. The floating widget is placed at bottom right of the website in the free version, but can be placed in other locations by changing CSS styles associated with the box. The premium version will allow more options as to changing the Floating Widget location.
- Fixed the issue with Dashboard styles loading on the wrong pages. This was causing some annoying display issues on the Wordpress Dashboard. 

3.0.4

- Re-factored/re-arranged more code in google languagetransltor.php by placing them into separate files.
- Fixed the issue of Custom CSS box not displaying it's styles to the website. This was only missed in this last update, due to re-arrangement of the files. Sorry for any inconvenience.
- Removed style2.php file, which is unnecessary and was being used in testing.

3.0.3

- Re-factored/re-arranged some of the code in googlelanguagetranslator.php by placing them into separate files.
- Fixed a minor coding issue in glt_widget.php - this was generating an error in Wordpress when debugging.
- Moved all CSS code into a single file.  The result is nice, clean inline CSS code that is now called only once.
- Fixed some additional CSS display issues.

3.0.2

- Adjusted additional minor invalid HTML issues on the settings page, and also in the front-end plugin display.

3.0.1

- Changed the url request to Google to allow both unsecured and secured page translations. Previously, some users experienced errors when trying to use the translator on "https://" (secured) pages.
- Adjusted some minor spacing issues in the settings page HTML (caused some annoying red HTML errors when using "View Source" in right-click menu).
- Removed old CSS styles that were added in the previous 3.0 update - the styles were added when Google servers were being updated, and were producing major translation dislay issues until their update was complete.  Now the styles I added are no longer needed.  

3.0

- Correct a small CSS error that affected the showing/hiding of the Google toolbar. 

2.9

***IMPORTANT: Google's most recent server update is producing display issues for website translation tool. There are major display issues with the translation toolbar and also the translations editing interface. Version 2.9 temporarily hides the edit translation functionality until Google decides to fix this issue, although you can still edit translations directly through your Google account at translate.google.com. Please direct any support requests through Wordpress.org and we will be happy to assist you.

- Fixed Google Translation toolbar display issue
- Fixed the Edit Translation interface by hiding it temporarily until Google fixes this
- Removed some unneeded styles from the style sheet.
- Fixed some CSS issues for the Google Branding display, which was affected by Google's most recent update

2.8

- Added an option to allow users to manage their own translations directly through their Google Translate account (free). When activated, users can hover over the text of their website, and edit the translations from the webpage directly.  Google will remember these translations, and then serve them to users once the edits are made. Users must install the Google Translate Customization meta tag provided through Google Translate here: translate.google.com/manager/website/settings. To obtain this meta tag, users need to configure the Google Translate tool directly from this website (although they will not use this because the plugin provides it), then the user can obtain the meta tag on the "Get Code" screen, which is displayed after configuring the Google Translate tool on this webpage. 
- Added an option to allow users to turn on/off Google's multilanguagePage option, that when activated, the original website content will be a forced translation, instead of original content (but only after a translation is made.)
- Added more flexible styles to the settings page, so that left and right panels display nicely to the user.

2.7

- Added Google Analytics tracking capability to the plugin.  
- Added a "CSS Styles" box in the settings panel.
- Changed the Catalonian flag to its correct flag image.
- Fixed coding issues that previously updated options incorrectly, which is why many users experienced display issues.  All options are now initialized upon plugin activation, which should fix this issue permanently.
- Fixed a glitch in our usage of the translate API.  Previously, when the user clicked the default language, it would toggle back and forth between the default language and "Afrikaans" language. Now, users will see the correct language displayed at all times, no matter how many times it is clicked.  

2.6

- Added defaults to all options to ensure there are no more issues with the translator displaying upon installation. Again, sorry for any inconvenience.

2.5

- Eliminated an internal Wordpress error being generated from a coding mistake.
- Added a default option for the Translator alingment. Previously, this was causing the plugin to disapppear.

2.4

- Found a couple of small display errors in the settings page after uploading version 2.3. Sorry for any inconvenience!

2.3

- Added a "Preview" area on the settings page that allows you to see your settings in action.
- Added custom flag support for all languages (custom flags available ONLY when selecting the "ALL Languages" setting.
- Added an option that allows left/right alignment of the translation tool.
- Added the "Google Language Translator" widget.
- Updated googlelanguagetranslator.php to properly register setting in the admin settings panel.

2.2

- Added language "Portuguese" and "German" to the Original Language drop-down option on the settings page.
- Changed flag image for the English language (changed United States flag to the United Kingdom flag).
- Added link in the settings panel that points to Google's Attribution Policy.

2.1 
- Added language "Dutch" to the Original Language drop-down option on the settings page.
- Added a new CSS class that more accurately hides the "Powered by" text when hiding Google's branding. In previous version, the "Powered by" text was actually disguised by setting it's color to "transparent", but now we have set it's font-size to 0px instead.

2.0 

Corrected some immediate errors in the 1.9 update.

1.9 

- Added 7 flag image choices that, when clicked by website visitors, will change the language displayed, both on the website, AND in the drop-down box (flag language choices are limited to those provided in this plugin). 
- Added 6 additional languages to the translator, as provided in Google's most recent updates ( new languages include Bosnian, Cebuano, Khmer, Marathi, Hmong, Javanese ).
- Corrected a minor technical issue where the Czech option (on the backend) was incorrectly displaying the Croatian language on the front end.
- Added jQuery functionality to the settings panel to improve the user experience.
- Added an option for users to display/hide the flag images.
- Added an option for users to display/hide the translate box when flags are displayed.
- Removed the settings.css file - I found a better way of displaying the options without CSS.

1.8 

Modified google-language-translator.php to display the correct output to the browser when horizontal layout is selected.  Previously, it was not displaying at all.

1.7 

Modified google-language-translator.php so that jQuery and CSS styles were enqueued properly onto the settings page only. Previously, jQuery functionality and CSS styles were being added to all pages of the Wordpresss Dashboard, which was causing functionality and display issues for some users.

1.6 

Added "Specific Language" support to the plugin settings, which allows the user to choose specific languages that are displayed to website visitors.

1.5 

Added "Original Language" support to the plugin settings, which allows the user to choose the original language of their website, which ultimately removes the original language as a choice in the language drop-down presented to website visitors.

1.4 

Corrected display problems associated with CSS styles not being placed correctly in wp_head.  

1.3 

HTML display problem in the sidebar area now fixed. Previously, inserting the [google-translator] plugin into a text widget caused it to display above the widget, instead of inside of it.

1.2 

Shortcode support is now available for adding [google-translator] to text widgets.  I apologize for any inconvenience this may have caused.

1.1 

The shortcode supplied on the settings page was updated to display '[google-translator]'.

== Screenshots ==

1. Settings include: inline or vertical layout, hide/show Google toolbar, display specific languages, and show/hide Google branding. Add the shortcode to pages, posts, and widgets.