<?php 
/**
 * Plugin Name: Singbui Crawler Klook
 * Plugin URI: http://singbui.com
 * Description: This is a plugin that crawler data from klook
 * Version: 1.0
 * Author: Sing Bui
 * Author URI: http://singbui.com
 * License: 
 */
/* add page to submenu options-general.php */
add_action('admin_menu', 'crawler_page');
function crawler_page(){
  //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
  add_submenu_page('options-general.php', 'Crawler Klook', 'Crawler Klook', 'manage_options', 'crawler-klook', 'cb_crawler_klook');
}

function cb_crawler_klook(){
?>
  <div class="wrap">
      <h1>Crawler Klook</h1>
      <form method="post" action="options.php">
        <?php settings_fields('exchange_rate_vnd'); ?>
        <table class="form-table">
          <tr>
            <th scope="row"><label>Exchange Rate USD to VND</label></th>
            <td><input name="exchange_rate_vnd" type="number" id="exchange_rate_vnd" value="<?php form_option('exchange_rate_vnd'); ?>" class="regular-text" /></td>
          </tr>
        </table>
        <?php submit_button(); ?>
        <?php do_settings_sections('klook_show_data_page'); ?>
      </form>
  </div>
<?php
}

add_action('admin_init', 'crawler_klook_setting');
function crawler_klook_setting() {
  register_setting('exchange_rate_vnd','exchange_rate_vnd');

  //add_settings_section($id, $title, $callback, $page)
  add_settings_section('klook_show_data_section', 'Show Prices','handle_klook_show_data', 'klook_show_data_page');

  // add_settings_field( $id, $title, $callback, $page, $section, $arg)
  add_settings_field('klook_show_data_script','', 'klook_show_data_load_js','klook_show_data_page', 'klook_show_data_section', array('name'=>'script') );
}

function handle_klook_show_data() {
  wp_enqueue_script( 'klook_script', plugins_url( '/plugin.js', __FILE__ ), array('jquery'), '', true );
}

function klook_show_data_load_js($args) {
  extract($args);
  if($name === 'script') {
    echo "<div id='klook-load-data'></div>";
  }
}