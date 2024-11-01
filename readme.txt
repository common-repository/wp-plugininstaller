=== wp-PluginInstaller ===
Contributors: afiouni
Tags: plugin install, install, automatic installation
Requires at least: 2.8
Tested up to: 2.9.2
Stable Tag: 1.1

== Description ==

wp-PluginInstaller is a plugin designed to allow plugin writers help their site visitors automatically install plugins in their WordPress installations without the need to download and upload the plugin zip file.

By using the built in WordPress plugin installation scripts, this wp-PluginInstaller will come handy for every user regardless of his/her technical background.

wp-PluginInstaller was designed to support multiple widgets on the same page just in case multiple plugins are to be showcased on the same page.

= How wp-PluginInstaller works =
wp-PluginInstaller is designed to use the built in installation mechanism of WordPress. Therefore, after proper configuration, wp-PluginInstaller will display a form requesting the user to input his or her Blog Root URL.

wp-PluginInstaller will redirect the user to his/her wordPress admin area where the user will have to properly login for the default installation screen to be displayed allowing the user to install the plugin automatically.

= Features =
The wp-PluginInstaller can be used in multiple ways:

* Using a Widget: If you are using widgets, you can drag wp-PluginInstaller to your sidebar to display the form to install a plugin
* Using a Short Code
* As a template function

wp-PluginInstaller supports the follwing options:

* Title: A title for the widget
* Plugin Slug on WordPress.org: The plugin slug as it appears on the WordPress plugin URL. It is usually the name of the plugin, in lowercase, and replacing the spaces with a hyphen (-)
* Include Default Styles: Will include a default style for the form. Please feel free to disable this feature and to style it the way you see fit. More on styling and its related CSS classes below
* Show Powered By Link: If you like to support this plugin, please add a link to its plugin page

= Styling =
The wp-PluginInstaller form supports the following CSS classes:

* .wppi_form_container : the container of the overall form (div)
* .wppi_input_container : the container of the label and text input (p)
* .wppi_input_label : the label of the URL text input (label)
* .wppi_input_text : the text input (input type="text")
* .wppi_error_message : the error message displayed when the URL entered is not correct (p)
* .wppi_example : the examples domains names (p)
* .wppi_credit_container : the container of the powered by credit link (p)
* .wppi_submit_container : the container of the submit button (p)
* .wppi_submit_button : the submit button (input type="submit")

== Installation ==
Try the automated installation this plugin allows by trying it at [plugin page](http://skinju.com/wordpress/wp-plugininstaller "http://skinju.com/wordpress/wp-plugininstaller") 

You can of course follow the stanard installation process:

1. Upload the entire wp-PluginInstaller directory to the /wp-content/plugins/ directory
2. Activate the plugin from the Plugins admin menu in WordPress

= Usage =
1. Activating this plugin will add a new admin menu section called skinju with a link to wp-PluginInstaller configuration page that includes detailed information on usage
2. wp-PluginInstaller can be used as a Widget, a Short Code, or a function in your template file

== Like this plugin? ==

= Keep up to date =
If you like this work, you can keep up to date with the latest news and releases of skinju packages and plugins. You can:

* Follow [skinju on Twitter](http://twitter.com/skinju "http://twitter.com/skinju") to keep up to date on bug fixes and releases

= Let Others Know =
You can also help spread the word and let others know about it. You can:

* Link to skinju website http://skinju.com/
* Give the plugins good ratings on the plugin pages on WordPress.org

== Screenshots ==

1. skinju Admin Menu Section: This is Where the wp-PluginInstaller menu item is added after activating the plugin
2. wp-PluginInstaller Widget: Define what plugin you would like to support along with the default options including a simple styling option and an option to support this plugin and give it some credit


== Changelog ==

= 1.1 =
* Initial Release
