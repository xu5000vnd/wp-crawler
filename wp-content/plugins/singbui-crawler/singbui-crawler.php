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
      </form>
      <?php //do_settings_sections('klook_show_data_page'); ?>
      </div>
  </div>
<?php
}

add_action('admin_init', 'crawler_klook_setting');
function crawler_klook_setting() {
  register_setting('exchange_rate_vnd','exchange_rate_vnd');

  //add_settings_section($id, $title, $callback, $page)
  add_settings_section('klook_show_data_section', 'Show Prices','handle_klook_show_data', 'klook_show_data_page');

  // add_settings_field( $id, $title, $callback, $page, $section, $arg)
  add_settings_field('klook_show_name','Name', 'klook_show_data_load_js','klook_show_data_page', 'klook_show_data_section', array('name'=>'name') );
  add_settings_field('klook_show_link','Link', 'klook_show_data_load_js','klook_show_data_page', 'klook_show_data_section', array('name'=>'link') );
  add_settings_field('klook_show_packages','Packages', 'klook_show_data_load_js','klook_show_data_page', 'klook_show_data_section', array('name'=>'packages') );
  add_settings_field('klook_show_datetime','Date Time Crawl', 'klook_show_data_load_js','klook_show_data_page', 'klook_show_data_section', array('name'=>'datetime') );
}

function handle_klook_show_data() {
  wp_enqueue_script( 'klook_script', plugins_url( '/loadprices.js', __FILE__ ), array('jquery'), '', true );
  echo "<div id='exchange_rate' data-rate='".get_option('exchange_rate_vnd')."'>Exchange rate USD to VND : <strong style='font-size:16px'>" . get_option('exchange_rate_vnd') . "<strong/> VND</div>";
}

function klook_show_data_load_js($args) {
  extract($args);
  switch ($name) {
    case 'name':
      echo '<div id="klook_name"></div>';
      break;
    case 'link':
      echo '<div id="klook_link"></div>';
      break;
    case 'packages':
      echo '<div id="klook_packages"></div>';
      break;
    case 'datetime':
      echo '<div id="klook_datetime"></div>';
      break;
    default:
      break;
  }
}