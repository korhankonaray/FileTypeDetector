<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
add_action("admin_init", array('TMM_Ext_LayoutConstructor', 'admin_init'));
add_action('admin_head', array('TMM_Ext_LayoutConstructor', 'admin_head'));
add_action('save_post', array('TMM_Ext_LayoutConstructor', 'save_post'));

class TMM_Ext_LayoutConstructor {

	public static function admin_init() {
		add_meta_box("layout_constructor", __("Layout constructor", TMM_THEME_FOLDER_NAME), array(__CLASS__, 'draw_page_meta_box'), "page", "normal", "high");
		add_meta_box("layout_constructor", __("Layout constructor", TMM_THEME_FOLDER_NAME), array(__CLASS__, 'draw_page_meta_box'), "post", "normal", "high");
		add_meta_box("layout_constructor", __("Layout constructor", TMM_THEME_FOLDER_NAME), array(__CLASS__, 'draw_page_meta_box'), "event", "normal", "high");
	}

	public static function get_application_path() {
		return THEMEMAKERS_APPLICATION_PATH . '/layout_constructor';
	}

	public static function get_application_uri() {
		return THEMEMAKERS_APPLICATION_URI . '/layout_constructor';
	}

	public static function admin_head() {
		wp_enqueue_style('tmm_ext_layout_constructor_css', self::get_application_uri() . '/css/styles.css');
		wp_enqueue_script('tmm_ext_layout_constructor_js', self::get_application_uri() . '/js/general.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog'));
		?>
		<script type="text/javascript">
			var lang_sure_item_delete = "<?php _e("Sure about column deleting?", TMM_THEME_FOLDER_NAME) ?>";
			var lang_sure_row_delete = "<?php _e("Sure about row deleting?", TMM_THEME_FOLDER_NAME) ?>";
			var lang_add_media = "<?php _e("Add Media", TMM_THEME_FOLDER_NAME) ?>";
			var lang_empty = "<?php _e("Empty", TMM_THEME_FOLDER_NAME) ?>";
		</script>
		<?php
	}

	public static function draw_page_meta_box() {
		$data = array();
		global $post;
		$data['post_id'] = $post->ID;
		$data['tmm_layout_constructor'] = get_post_meta($post->ID, 'thememakers_layout_constructor', true);
		$data['tmm_layout_constructor_row'] = get_post_meta($post->ID, 'thememakers_layout_constructor_row', true);
		echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/meta_panel.php', $data);
	}

	public static function draw_column_item($row, $uniqid, $css_class, $front_css_class, $value, $content, $title) {
		global $post;
		$data = array();
		$data['post_id'] = $post->ID;
		$data['uniqid'] = $uniqid;
		$data['row'] = $row;
		$data['css_class'] = $css_class;
		$data['front_css_class'] = $front_css_class;
		$data['value'] = $value;
		$data['content'] = $content;
		$data['title'] = $title;
		echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/column_item.php', $data);
	}

	public static function save_post() {
		if (!empty($_POST)) {
			if (isset($_POST['tmm_layout_constructor'])) {
				global $post;
				unset($_POST['tmm_layout_constructor']['__ROW_ID__']); //unset column html template
				unset($_POST['tmm_layout_constructor_row']['__ROW_ID__']); //unset column html template
				update_post_meta($post->ID, 'thememakers_layout_constructor', $_POST['tmm_layout_constructor']);
				update_post_meta($post->ID, 'thememakers_layout_constructor_row', $_POST['tmm_layout_constructor_row']);
			}
		}
	}

	public static function draw_front($post_id) {
		$tmm_layout_constructor = get_post_meta($post_id, 'thememakers_layout_constructor', true);
		if (!empty($tmm_layout_constructor)) {
			$data = array();
			$data['tmm_layout_constructor'] = $tmm_layout_constructor;
			$data['tmm_layout_constructor_row'] = get_post_meta($post_id, 'thememakers_layout_constructor_row', true);

			if (!is_array($data['tmm_layout_constructor_row'])) {
				$data['tmm_layout_constructor_row'] = array();
			}

			echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/front_output.php', $data);
		}

		echo "";
	}

	public static function draw_row_bg($tmm_layout_constructor_row, $row) {
		$style = '';
		if (isset($tmm_layout_constructor_row[$row])) {
			$data = $tmm_layout_constructor_row[$row];
			//***
			$border_css_data = "";
			if (isset($data['border_color'])) {
				if ($data['border_width'] != 0) {
					$border_css_data = 'border-top:' . $data['border_width'] . 'px ' . $data['border_type'] . ' ' . $data['border_color'] . ';';
					$border_css_data.= 'border-bottom:' . $data['border_width'] . 'px ' . $data['border_type'] . ' ' . $data['border_color'] . ';';
				}
			}

			//***
			if (isset($data['bg_type'])) {
				switch ($data['bg_type']) {
					case 'color':
						$style = 'style="background-color:' . $data['bg_data'] . ' !important;' . $border_css_data . '"';
						break;

					case 'image':
						$style = 'style="background: url(' . $data['bg_data'] . ') repeat 0 0;' . $border_css_data . '"';
						break;

					default:
						break;
				}
			}
		}

		echo $style;
	}

}
