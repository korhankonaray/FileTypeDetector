<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
Thememakers_Application_Shortcodes::register();

//*******

add_action('admin_head', 'thememakers_app_shortcodes_admin', 1);

function thememakers_app_shortcodes_admin() {
    wp_enqueue_script('thememakers_app_shortcodes_js', THEMEMAKERS_APPLICATION_URI . '/shortcodes/js/general.js', array('jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-dialog'));
    wp_enqueue_style('thememakers_app_shortcodes_css', THEMEMAKERS_APPLICATION_URI . '/shortcodes/css/styles.css');
    ?>
    <script type="text/javascript">
        var thememakers_app_shortcodes_app_link = "<?php echo Thememakers_Application_Shortcodes::get_application_uri() ?>";
        var thememakers_app_shortcodes_items = [];

    <?php foreach (Thememakers_Application_Shortcodes::$autoshortcodes as $shortcode_key => $shortcode_name) : ?>
            thememakers_app_shortcodes_items.push({'key': '<?php echo $shortcode_key ?>', 'name': '<?php echo $shortcode_name ?>'});
    <?php endforeach; ?>


    </script>
    <?php
}

add_filter('mce_buttons', array('Thememakers_Application_Shortcodes', 'mce_buttons'));
add_filter('mce_external_plugins', array('Thememakers_Application_Shortcodes', 'mce_add_rich_plugins'));

//AJAX callback
add_action('wp_ajax_app_shortcodes_get_shortcode_template', array('Thememakers_Application_Shortcodes', 'get_shortcode_template'));
add_action('wp_ajax_app_shortcodes_base64_encode', array('Thememakers_Application_Shortcodes', 'base64_encode'));

class Thememakers_Application_Shortcodes {

    public static $shortcodes = array();
    public static $autoshortcodes = array();

    //*****************************

    public static function get_application_path() {
        return THEMEMAKERS_APPLICATION_PATH . '/shortcodes';
    }

    public static function get_application_uri() {
        return THEMEMAKERS_APPLICATION_URI . '/shortcodes';
    }

    //realmag777 dev
    public static function register() {
        /*
          self::$shortcodes = array(
          'alert' => "Alerts",
          'quotes' => "Quotes",
          );
         */

        $shortcodes = self::get_shortcodes_array();
        if (!empty($shortcodes)) {
            foreach ($shortcodes as $value) {
                $name = ucfirst(trim($value));
                $name = str_replace("_", " ", $name);
                self::$autoshortcodes[$value] = $name;
            }
        }

        foreach (self::$autoshortcodes as $shortcode_key => $shortcode_name) {

            $code = 'function ' . $shortcode_key . '_action($attributes = array(), $content = "") {
        $attributes["content"] = $content;
        return Thememakers_Application_Shortcodes::draw_html("' . $shortcode_key . '", $attributes);}';

            eval($code);

            add_shortcode($shortcode_key, $shortcode_key . '_action');
        }
    }

    public static function draw_html($shortcode_key, $attributes = array()) {
        return ThemeMakersThemeView::draw_free_page(self::get_application_path() . "/views/autoshortcodes/" . $shortcode_key . ".php", $attributes);
    }

    public static function get_shortcodes_array() {
        $results = array();
        $handler = opendir(self::get_application_path() . "/views/autoshortcodes/popups/");
        while ($file = readdir($handler)) {
            if ($file != "." AND $file != "..") {
                $results[] = $file;
            }
        }
        //****
        foreach ($results as $key => $value) {
            $value = explode(".", $value);
            if (!empty($value[0])) {
                $results[$key] = $value[0];
            }
        }


        sort($results);

        return $results;
    }

    //*****************************


    function mce_buttons($buttons) {
        $buttons[] = 'thememakers_shortcodes';
        return $buttons;
    }

    function mce_add_rich_plugins($plugin_array) {
        $plugin_array['thememakers_tiny_shortcodes'] = self::get_application_uri() . '/js/shortcodes.js';
        return $plugin_array;
    }

    //ajax
    public function get_shortcode_template() {
        echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/autoshortcodes/popups/' . $_REQUEST['shortcode_name'] . ".php", array());
        exit;
    }

    //ajax
    public static function base64_encode() {
        echo base64_encode($_REQUEST['string']);
        exit;
    }
	
	
	public static function draw_shortcode_option($data) {
		switch ($data['type']) {
			case 'textarea':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<textarea id="<?php echo $data['id'] ?>" class="js_shortcode_template_changer data-area" data-shortcode-field="<?php echo $data['shortcode_field'] ?>"><?php echo $data['default_value'] ?></textarea>
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
			case 'select':
				if (!isset($data['display'])) {
					$data['display'] = 1;
				}
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<?php if (!empty($data['options'])): ?>
					<select <?php if ($data['display'] == 0): ?>style="display: none;"<?php endif; ?> class="js_shortcode_template_changer data-select <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" id="<?php echo $data['id'] ?>">

						<?php foreach ($data['options'] as $key => $text) : ?>
							<option <?php if ($data['default_value'] == $key) echo 'selected' ?> value="<?php echo $key ?>"><?php echo $text ?></option>
						<?php endforeach; ?>

					</select>
				<?php endif; ?>
				<?php
				break;
			case 'text':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<input type="text" value="<?php echo $data['default_value'] ?>" class="js_shortcode_template_changer data-input" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" id="<?php echo $data['id'] ?>" />
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
			case 'color':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<input type="text" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" value="<?php echo $data['default_value'] ?>" class="bg_hex_color text small js_shortcode_template_changer" id="<?php echo $data['id'] ?>">
				<div style="background-color: <?php echo $data['default_value'] ?>" class="bgpicker"></div>
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
			case 'upload':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<input type="text" id="<?php echo $data['id'] ?>" value="<?php echo $data['default_value'] ?>" class="js_shortcode_template_changer data-input data-upload <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" />
				<a title="" class="button_upload button-primary" href="#">
					<?php _e('Upload', TMM_THEME_FOLDER_NAME); ?>
				</a>
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
			case 'checkbox':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<div class="radio-holder">
					<input <?php if ($data['is_checked']): ?>checked=""<?php endif; ?> type="checkbox" value="<?php if ($data['is_checked']): ?>1<?php else: ?>0<?php endif; ?>" id="<?php echo $data['id'] ?>" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="<?php echo $data['shortcode_field'] ?>">
					<label for="<?php echo $data['id'] ?>"><span></span><i class="description"><?php echo $data['description'] ?></i></label>
					<span class="preset_description"><?php echo $data['description'] ?></span>
				</div><!--/ .radio-holder-->
				<?php
				break;
			case 'radio':
				?>
				<?php if (!empty($data['title'])): ?>
					<h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
				<?php endif; ?>

				<div class="radio-holder">
					<input <?php if ($data['values'][0]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo $data['name'] ?>" id="<?php echo $data['values'][0]['id'] ?>" value="<?php echo $data['values'][0]['value'] ?>" class="js_shortcode_radio_self_update" />
					<label for="<?php echo $data['values'][0]['id'] ?>" class="label-form"><span></span><?php echo $data['values'][0]['title'] ?></label>

					<input <?php if ($data['values'][1]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo $data['name'] ?>" id="<?php echo $data['values'][1]['id'] ?>" value="<?php echo $data['values'][1]['value'] ?>" class="js_shortcode_radio_self_update" />
					<label for="<?php echo $data['values'][1]['id'] ?>" class="label-form"><span></span><?php echo $data['values'][1]['title'] ?></label>

					<input type="hidden" id="<?php echo @$data['hidden_id'] ?>" value="<?php echo $data['value'] ?>" class="js_shortcode_template_changer" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" />
				</div><!--/ .radio-holder-->
				<span class="preset_description"><?php echo $data['description'] ?></span>
				<?php
				break;
		}
	}

}

