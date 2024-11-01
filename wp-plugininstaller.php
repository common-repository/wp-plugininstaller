<?php
/*
Plugin Name: wp-PluginInstaller
Plugin URI: http://skinju.com/wordpress/wp-plugininstaller
Description: wp-PluginInstaller is a plugin designed to allow plugin writers help their site visitors automatically install plugins in their WordPress installations without the need to download and upload the plugin zip file.
Version: 1.1
Author: Khaled Afiouni
Author URI: http://www.afiouni.com/
Lincense: Released under the GPL license (http://www.opensource.org/licenses/gpl-license.php)
*/

/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

//-- Global skinju functions
if (!function_exists('skinju_valid_privileges_or_die')):
function skinju_valid_privileges_or_die ($r) {if (!current_user_can($r)) wp_die ('You do not have sufficient permissions to perform the requested action.');}
endif; //skinju_valid_privileges_or_die

if (!function_exists('skinju_get_tag_link')):
function skinju_get_tag_link( $tag )
{
  global $wp_rewrite;
  $taglink = $wp_rewrite->get_tag_permastruct();
	
  if (empty($taglink ))
  {
    $file = get_option( 'home' ) . '/';
    $taglink = $file . '?tag=' . $tag;
  }
  else
  {
    $taglink = str_replace( '%tag%', $tag, $taglink );
    $taglink = get_option( 'home' ) . user_trailingslashit( $taglink, 'category' );
  }
  return apply_filters( 'tag_link', $taglink, $tag_id );
}
endif; //skinju_get_tag_link

//-- Add Admin Menus
if (!has_action ('admin_menu', 'skinju_add_admin_menus')) {add_action('admin_menu', 'skinju_add_admin_menus');}
if (!function_exists('skinju_add_admin_menus')):
function skinju_add_admin_menus()
{
  if (function_exists('add_menu_page'))
  {
    add_menu_page('skinju', 'skinju', 0, 'skinju', 'skinju_options_page');
    do_action ('skinju_add_admin_menus');
  }
}
endif; //skinju_add_admin_menus

if (!function_exists('skinju_options_page')):
function skinju_options_page()
{
  echo '<div class="wrap">';
  echo '<div id="icon-plugins" class="icon32"><br /></div>';
  echo '<h2>About the skinju Wordpress Plugin Package</h2>';
  echo '<h2>Background</h2>';
  echo '<p><a href="http://skinju.com/" target="_blank">skinju</a> is a suite of add-ons, extensions, and plugins for well known open source packages such as WordPress.</p>';
  echo '<p>This package is primarily developed by <a href="http://www.afiouni.com/" target="_blank">Khaled Afiouni</a>. The WordPress plugins released under this package are released under the GNU GPL version 3 which is basically the requirement of the folks at <a href="http://wordpress.org/" target="_blank">WordPress.org</a>. For other wordpress plugins please check the <a href="http://skinju.com/wordpress" target="_blank">skinju wordpress plugins page</a></p>';

  echo '<h2>Like those plugins?</h2>';
  echo '<p>If you like this work, you can keep up to date with the latest news and releases of <a href="http://skinju.com/" target="_blank">skinju</a> packages and plugins. You can:</p>';
  echo '<p>- Follow <a href="http://twitter.com/skinju" target="_blank">skinju on Twitter</a> to keep up to date on bug fixes and releases</p>';
  echo '<br />';
  echo '<p>You can also help spread the word and let others know about it. You can:</p>';
  echo '<p>- Link to skinju website http://skinju.com/</p>';
  echo '<p>- Give the plugins good ratings on the plugin pages on <a href="http://wordpress.org/extend/plugins/" target="_blank">WordPress.org</a></p>';

  echo '<h2>Disclaimer</h2>';
  echo '<p>This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.</p>';



  echo '</div> <!-- end wrap -->';
}
endif; //skinju_options_page


//-- wpplugininstaller Functions
//-- Add Menu Item
if (!has_action ('skinju_add_admin_menus', 'wpplugininstaller_add_menu')) {add_action('skinju_add_admin_menus', 'wpplugininstaller_add_menu');}
if (!function_exists('wpplugininstaller_add_menu')):
function wpplugininstaller_add_menu()
{
    add_submenu_page('skinju', 'wp-PluginInstaller', 'wp-PluginInstaller', 'manage_wpplugininstaller', 'wpplugininstaller', 'wpplugininstaller_options');
}
endif; //wpplugininstaller_add_menu

//Activation Hook
register_activation_hook (__FILE__, 'wpplugininstaller_activate');
if (!function_exists('wpplugininstaller_activate')):
function wpplugininstaller_activate()
{
  $role = get_role('administrator');
  if (!$role->has_cap('manage_wpplugininstaller'))
  {
    $role->add_cap('manage_wpplugininstaller');
  }
}
endif; //wpplugininstaller_activate

//-- wpplugininstaller Options
if (!function_exists('wpplugininstaller_options')):
function wpplugininstaller_options()
{
  echo '<div class="wrap">';

  echo '<div id="icon-options-general" class="icon32"><br /></div>';
  echo '<h2>wp-PluginInstaller settings</h2>';

  echo '<p>wp-PluginInstaller is a plugin designed to allow plugin writers help their site visitors automatically install plugins in their WordPress installations without the need to download and upload the plugin zip file.</p>';
  echo '<p>By using the built in WordPress plugin installation scripts, this wp-PluginInstaller will come handy for every user regardless of his/her technical background.</p>';
  echo '<p>wp-PluginInstaller was designed to support multiple widgets on the same page just in case multiple plugins are to be showcased on the same page.</p>';

  echo '<h2>How wp-PluginInstaller works</h2>';
  echo '<p>wp-PluginInstaller is designed to use the built in installation mechanism of WordPress. Therefore, after proper configuration, wp-PluginInstaller will display a form requesting the user to input his or her Blog Root URL.</p>'; 
  echo '<p>wp-PluginInstaller will redirect the user to his/her wordPress admin area where the user will have to properly login for the default installation screen to be displayed allowing the user to install the plugin automatically.</p>';


  echo '<h2>Usage</h2>';
  echo '<p>You can add a plugin install form on your pages in many ways:</p>';
  echo '<h3>Using a Widget</h3>';
  echo '<p>If you are using widgets, you can drag wp-PluginInstaller to your sidebar to display the form to install a plugin. The Widget accepts the following inputs:</p>';
  echo '<p>- Title: A title for the widget</p>';
  echo '<p>- Plugin Slug on WordPress.org: The plugin slug as it appears on the WordPress plugin URL. It is usually the name of the plugin, in lowercase, and replacing the spaces with a hyphen (-)</p>';
  echo '<p>- Include Default Styles: Will include a default style for the form. Please feel free to disable this feature and to style it the way you see fit. More on styling and its related CSS classes below.</p>';
  echo '<p>- Show Powered By Link: If you like to support this plugin, please add a link to its <a target="_blank" href="http://skinju.com/wordpress/wp-plugininstaller">plugin page</a>.</p>';

  echo '<h3>Using a Short Code</h3>';
  echo '<p>[wpplugininstaller-form pluginslug="plugin-slug" usedefaultstyle="true" showcreditlink="true"/]</p>';
  echo '<p>The Short Code supports the same options as described in above</p>';

  echo '<h3>Using a function in your template files</h3>';
  echo '<p>wpplugininstaller_install_form ($pluginslug, $usedefaultstyle=true, $showcreditlink=true, $echo=false)</p>';
  echo '<h4>&nbsp;&nbsp;&nbsp;Parameters</h4>';
  echo '<p>&nbsp;&nbsp;&nbsp;$pluginslug : String (Required): The Plugin Slug on WordPress.org</p>';
  echo '<p>&nbsp;&nbsp;&nbsp;$usedefaultstyle : Boolean (Optional) (Default = true) : Include Default Styles</p>'; 
  echo '<p>&nbsp;&nbsp;&nbsp;$showcreditlink : Boolean (Optional) (Default = true) : Show Powered By wp-PluginInstaller Link</p>';
  echo '<p>&nbsp;&nbsp;&nbsp;$echo : Boolean (Optional) (Default = false) : Whether to echo the generated HTML or just return it as a string</p>';

  echo '<h2>Styling</h2>';
  echo '<p>The wp-PluginInstaller form supports the following CSS classes:</p>';
  echo '<p>&nbsp;&nbsp;&nbsp;.wppi_form_container : the container of the overall form (div)';
  echo '<p>&nbsp;&nbsp;&nbsp;.wppi_input_container : the container of the label and text input (p)';
  echo '<p>&nbsp;&nbsp;&nbsp;.wppi_input_label : the label of the URL text input (label)</p>';
  echo '<p>&nbsp;&nbsp;&nbsp;.wppi_input_text : the text input (input type="text")</p>';
  echo '<p>&nbsp;&nbsp;&nbsp;.wppi_error_message : the error message displayed when the URL entered is not correct (p)</p>';
  echo '<p>&nbsp;&nbsp;&nbsp;.wppi_example : the examples domains names (p)</p>';
  echo '<p>&nbsp;&nbsp;&nbsp;.wppi_credit_container : the container of the powered by credit link (p)</p>';
  echo '<p>&nbsp;&nbsp;&nbsp;.wppi_submit_container : the container of the submit button (p)</p>';
  echo '<p>&nbsp;&nbsp;&nbsp;.wppi_submit_button : the submit button (input type="submit")</p>';


  echo '<h2>Like this plugin?</h2>';
  echo '<p>If you like this plugin and would like to tell others about it, you can help spread the word:</p>';
  echo '<p>- Link to the plugin page <a target="_blank" href="http://skinju.com/wordpress/wp-plugininstaller">http://skinju.com/wordpress/wp-plugininstaller</a></p>';
  echo '<p>- Give it a good rating on the plugin <a target="_blank" href="http://wordpress.org/extend/plugins/wp-plugininstaller/">WordPress.org page</a></li>';
  echo '</ul>';

  echo '<h2>About</h2>';
  echo '<p><a href="http://skinju.com/wordpress/wp-plugininstaller" target="_blank">wp-PluginInstaller</a> is developed by <a href="http://www.afiouni.com/" target="_blank">Khaled Afiouni</a>. It\'s released under the GNU GPL version 3. For other wordpress plugins please check the <a href="http://skinju.com/wordpress" target="_blank">skinju wordpress plugins page</a></p>';
  echo '</div> <!-- wrap -->';
}
endif; //wpplugininstaller_options

//-- wpplugininstaller HTML Form
if (!function_exists('wpplugininstaller_install_form')):
function wpplugininstaller_install_form ($pluginslug, $usedefaultstyle=true, $showcreditlink=true, $echo=false)
{

  if (!isset($pluginslug) || $pluginslug == ''):
    if ($echo):
      echo "Please make sure to define the plugin-slug to properly display the wp-PluginInstaller form";
      return;
    else:
      return "Please make sure to define the plugin-slug to properly display the wp-PluginInstaller form";
      return;
    endif;
  endif;


  $install_form_script = '<script type="text/javascript">';
  $install_form_script .= '//<![CDATA[' . "\n";
  $install_form_script .= 'function go_install(formReference)';
  $install_form_script .= '{';
  $install_form_script .= 'blogRoot = formReference.blog_root.value;';
  $install_form_script .= 'pluginSlug = formReference.plugin_slug.value;';
  $install_form_script .= 'showCreditLink = formReference.show_credit_link.value;';
  $install_form_script .= 'var regexp = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;';
  $install_form_script .= 'if (!regexp.test(blogRoot)) {isError=1;}';
  $install_form_script .= 'else {isError=0;}';
  $install_form_script .= 'formReference.innerHTML = \'';
  $install_form_script .= '<p class="wppi_input_container"><label class="wppi_input_label">Your Blog Root URL</label>';
  $install_form_script .= '<input class="wppi_input_text" type="text" size="20" name="blog_root" /></p>\'';


  $install_form_script .= '+ ((isError==1)?\'<p class="wppi_error_message">Invalid URL. Please check your input and try again.</p>\':\'<p class="wppi_example">http://www.example.com/ or http://www.example.com/blog/</p>\') +';



  $install_form_script .= '\'<input type="hidden" name="plugin_slug" value="\' + pluginSlug + \'" />';
  $install_form_script .= '<input type="hidden" name="show_credit_link" value="\' + showCreditLink + \'" />';
  $install_form_script .= '<p class="wppi_submit_container"><input class="wppi_submit_button" type="submit" value="Install Plugin" /></p>\'';
  $install_form_script .= '+ ((showCreditLink==1)?\'<p class="wppi_credit_container"><a href="http://skinju.com/wordpress/wp-plugininstaller">Powered by wp-PluginInstaller</a></p>\':\'\');';

  $install_form_script .= 'if (isError==1) {return false;}';

  $install_form_script .= 'if (blogRoot.charAt(blogRoot.length-1) != "/") {blogRoot = blogRoot + "/";}';

  $install_form_script .= "window.open(blogRoot + 'wp-admin/plugin-install.php?tab=plugin-information&plugin=' +  pluginSlug + '&TB_iframe=true&width=640&height=594', 'installwindow', 'menubar=1,resizable=1,width=640,height=594');";
  $install_form_script .= '}';
  $install_form_script .= "\n" . '//]]>';
  $install_form_script .= '</script>';


  $install_form_style = '<style type="text/css">';
  $install_form_style .= '.wppi_form_container * {text-align: left!important; padding: 0!important; margin: 0!important; font-family: \'Lucida Grande\', Verdana, \'Bitstream Vera Sans\', Arial, sans-serif!important;}';
  $install_form_style .= '.wppi_form_container, .wppi_form_container form, .wppi_form_container p {display: block!important;}';
  $install_form_style .= '.wppi_form_container form {border: 2px solid #d54e21!important; -moz-border-radius: 5px!important; -webkit-border-radius: 5px!important; border-radius: 5px!important;}';
  $install_form_style .= '.wppi_form_container .wppi_input_container {padding-left: 15px!important; margin: 5px 0px!important;}';
  $install_form_style .= '.wppi_form_container .wppi_input_label{font-weight:bold!important; font-size:12px!important; color: #d54e21!important; padding-right: 15px!important;}';
  $install_form_style .= '.wppi_form_container .wppi_input_text {border: 1px solid #d54e21!important; padding: 3px!important; color: #333!important; font-size: 12px!important; width: 80%!important;}';
  $install_form_style .= '.wppi_form_container .wppi_example {padding-left: 15px!important; color: #555!important; font-size:9px!important; margin-bottom: 11px!important;}';
  $install_form_style .= '.wppi_form_container .wppi_submit_container {text-align: center!important; padding: 5px!important; margin-top: 3px!important;}';
  $install_form_style .= '.wppi_form_container .wppi_submit_button {background-color: #d54e21!important; color: #fff!important; border: 1px solid #d54e21!important; font-size: 13px!important; padding: 8px 10px!important; cursor: hand!important; color: #ffeedd!important; -moz-border-radius: 3px!important; -webkit-border-radius: 3px!important; border-radius: 3px!important;}';
  $install_form_style .= '.wppi_form_container .wppi_credit_container {text-align: center!important; padding: 3px!important;}';
  $install_form_style .= '.wppi_form_container .wppi_credit_container, .wppi_form_container .wppi_credit_container a, .wppi_form_container .wppi_credit_container a:visited, .wppi_form_container .wppi_credit_container a:hover {font-size:10px!important; background-color: #ffac90!important; color: #d54e21!important; text-decoration: none!important; }';
  $install_form_style .= '.wppi_form_container .wppi_error_message{font-size: 10px!important; font-weight:bold!important; text-align: center!important; background-color: #FFEBE8!important; color: #c00!important; padding: 4px!important;}';
  $install_form_style .= '</style>';

  $install_form_html = '<div class="wppi_form_container"><form method="get" onsubmit="go_install(this); return false">';
  $install_form_html .= '<p class="wppi_input_container"><label class="wppi_input_label">Your Blog Root URL</label><input class="wppi_input_text" type="text" size="20" name="blog_root" /></p>';
  $install_form_html .= '<p class="wppi_example">http://www.example.com/ or http://www.example.com/blog/</p>';
  $install_form_html .= '<input type="hidden" name="plugin_slug" value="' . $pluginslug . '" />';
  $install_form_html .= '<input type="hidden" name="show_credit_link" value="' . ($showcreditlink==true?'1':'0') . '" />';
  $install_form_html .= '<p class="wppi_submit_container"><input class="wppi_submit_button" type="submit" value="Install Plugin" /></p>';
  $install_form_html .= ($showcreditlink==true?'<p class="wppi_credit_container"><a href="http://skinju.com/wordpress/wp-plugininstaller">Powered by wp-PluginInstaller</a></p>':'');
  $install_form_html .= '</form></div>';

  $install_form_script = apply_filters('wpplugininstaller_install_form_script', $install_form_script);
  $install_form_style =  apply_filters('wpplugininstaller_install_form_style', $install_form_style);
  $install_form_html = apply_filters('wpplugininstaller_install_form_html', $install_form_html);

  if ($echo)
    echo $install_form_script . ($usedefaultstyle===true?$install_form_style:'') . $install_form_html;
  else
    return $install_form_script . ($usedefaultstyle===true?$install_form_style:'') . $install_form_html;
}
endif; //wpplugininstaller_install_form

//-- wpplugininstaller Class & Register Widget
add_action('widgets_init', create_function('', 'return register_widget("wpPluginInstaller_Widget");'));
class wpPluginInstaller_Widget extends WP_Widget
{
  function wpPluginInstaller_Widget()
  {
    $widget_ops = array('classname' => 'widget_wpPluginInstaller', 'description' => __('wp-PluginInstaller Widget, inserts a form that allows visitors to automatically install your plugin on their site'));
    $this->WP_Widget('wpplugininstaller', __('wp-PluginInstaller'), $widget_ops);
  }


  function widget( $args, $instance ) 
  {
    extract($args);
    $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
    echo $before_widget;
    if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 

    wpplugininstaller_install_form($instance['pluginslug'], $instance['usedefaultstyle'], $instance['showcreditlink'], true);
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) 
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['pluginslug'] = strip_tags($new_instance['pluginslug']);
    $instance['usedefaultstyle'] = isset($new_instance['usedefaultstyle']);
    $instance['showcreditlink'] = isset($new_instance['showcreditlink']);
    return $instance;
  }

  function form( $instance ) 
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'pluginslug' => '', 'usedefaultstyle' => true, 'showcreditlink' => true));
    $title = strip_tags($instance['title']);
    $pluginSlug = strip_tags($instance['pluginslug']);

    ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
    <p><label for="<?php echo $this->get_field_id('pluginslug'); ?>"><?php _e('Plugin Slug on WordPress.org:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('pluginslug'); ?>" name="<?php echo $this->get_field_name('pluginslug'); ?>" type="text" value="<?php echo esc_attr($pluginSlug); ?>" /></p>
    <p><input id="<?php echo $this->get_field_id('usedefaultstyle'); ?>" name="<?php echo $this->get_field_name('usedefaultstyle'); ?>" type="checkbox" <?php checked(isset($instance['usedefaultstyle']) ? $instance['usedefaultstyle'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('usedefaultstyle'); ?>"><?php _e('Include Default Styles.'); ?></label></p>
    <p><input id="<?php echo $this->get_field_id('showcreditlink'); ?>" name="<?php echo $this->get_field_name('showcreditlink'); ?>" type="checkbox" <?php checked(isset($instance['showcreditlink']) ? $instance['showcreditlink'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('showcreditlink'); ?>"><?php _e('Show Powered By Link.'); ?></label></p>
    <?php
  }
}

add_shortcode('wpplugininstaller-form', 'wpplugininstaller_shortcode');
function wpplugininstaller_shortcode ($atts)
{
  if (!isset ($atts['pluginslug']) || $atts['pluginslug'] == '') return '<b>Short Code Format: [wpplugininstaller-form pluginslug="plugin-slug" usedefaultstyle="true" showcreditlink="true"/] where plugin-slug is the slug of your plugin on WordPress.org</b>';

  shortcode_atts(array('usedefaultstyle' => false, 'showcreditlink' => false), $atts);
  return wpplugininstaller_install_form($atts['pluginslug'], $atts['usedefaultstyle']=="true", $atts['showcreditlink']=="true" ,false);
}