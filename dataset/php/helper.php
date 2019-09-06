<?php

class ThemeMakersHelper {

	public static function get_post_featured_image($post_id, $w = 0, $crop = false, $h = 0) {
		$image_mode = get_option(TMM_THEME_PREFIX . 'image_mode');

		if ($image_mode == 1) {
			return self::get_post_featured_image_c($post_id, "$w*$h");
		} else {
			return self::get_post_featured_image_t($post_id, $w, $crop, $h);
		}
	}

	public static function resize_image($src, $w = 0, $crop = false, $h = 0) {
		$image_mode = get_option(TMM_THEME_PREFIX . 'image_mode');

		if ($image_mode == 1) {
			return self::resize_image_c($src, "$w*$h");
		} else {
			return self::resize_image_t($src, $w, $crop, $h);
		}
	}

	//**************************

	public static function get_post_featured_image_t($post_id, $w = 0, $crop = false, $h = 0) {
		$src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'single-post-thumbnail');

		$url = TMM_THEME_URI . '/admin/extensions/timthumb.php?src=' . urlencode($src[0]);

		$w = intval($w);
		if ($w) {
			if ($crop AND $h = intval($h)) {
				$url.='&w=' . $w . '&h=' . $h . '';
			} else {
				$url.='&w=' . $w;
			}
		}

		return $url;
	}

	public static function resize_image_t($src, $w = 0, $crop = false, $h = 0) {

		$url = TMM_THEME_URI . '/admin/extensions/timthumb.php?src=' . urlencode($src);

		$w = intval($w);
		if ($w) {
			if ($crop AND $h = intval($h)) {
				$url.='&w=' . $w . '&h=' . $h . '&a=t';
			} else {
				$url.='&w=' . $w;
			}
		}

		return $url;
	}

	//**************************
	public static function get_post_featured_image_c($post_id, $alias) {
		$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'single-post-thumbnail');
		$img_src = $img_src[0];
		$url = self::get_image($img_src, $alias);
		return $url;
	}

	public static function resize_image_c($img_src, $alias) {
		return self::get_image($img_src, $alias);
	}

	//**************************
	//for clean mode	
	public static function get_image($img_src, $alias) {
		if (empty($alias)) {
			return $img_src;
		}
		$sizes = get_theme_image_sizes();

		if (!key_exists($alias, $sizes)) {
			//return $img_src;
			$alias = '800*600';
		}

		//***

		$new_img_src = explode(".", $img_src);
		$ext = $new_img_src[count($new_img_src) - 1];
		unset($new_img_src[count($new_img_src) - 1]);
		$new_img_src = implode(".", $new_img_src);
		$new_img_src = $new_img_src . "-" . $sizes[$alias]['width'] . 'x' . $sizes[$alias]['height'] . "." . $ext;

		if (!self::is_file_url_exists($new_img_src)) {
			return $img_src;
		}

		return $new_img_src;
	}

	public static function is_file_url_exists($url) {
		if (!is_admin()) {
			/* if (function_exists('curl_init')) {
			  $curl = curl_init($url);
			  curl_setopt($curl, CURLOPT_NOBODY, true);
			  //Check connection only
			  $result = curl_exec($curl);
			  //Actual request
			  $ret = false;
			  if ($result !== false) {
			  $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			  //Check HTTP status code
			  if ($statusCode == 200) {
			  $ret = true;
			  }
			  }
			  curl_close($curl);
			  return $ret;
			  } else { */
			return(bool) preg_match('~HTTP/1\.\d\s+200\s+OK~', @current(get_headers($url)));
			//}
		}

		return true;
	}

//**************************


	public static function get_contact_information() {
		$contact_info = get_option(TMM_THEME_PREFIX . 'contact_info');
		return $contact_info;
	}

//Custom page navigation
	public static function pagenavi($query = null) {
		global $wp_query, $wp_rewrite;
		if (!$query)
			$query = $wp_query;
		$pages = '';
		$max = $query->max_num_pages;
		if (!$current = get_query_var('paged'))
			$current = 1;
		$a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
		$a['total'] = $max;
		$a['current'] = $current;

		$total = 1; //1 - display the text "Page N of N", 0 - not display
		$a['mid_size'] = 5; //how many links to show on the left and right of the current
		$a['end_size'] = 1; //how many links to show in the beginning and end
		$a['prev_text'] = ''; //text of the "Previous page" link
		$a['next_text'] = ''; //text of the "Next page" link
		//if ($total == 1 && $max > 1)
		//$pages = '<span class="pages">Page (' . $current . ' ' . __('of', TMM_THEME_FOLDER_NAME) . ' ' . $max . ')</span>';

		echo $pages . paginate_links($a);
	}

	public function add_comment() {
		if (!empty($_REQUEST['comment_content'])) {
			$time = current_time('mysql');
			$user = get_userdata(get_current_user_id());
			$data = array(
				'comment_post_ID' => $_REQUEST['comment_post_ID'],
				'comment_author' => $user->data->user_nicename,
				'comment_author_email' => $user->data->user_email,
				'comment_author_url' => $user->data->user_url,
				'comment_content' => $_REQUEST['comment_content'],
				'comment_parent' => $_REQUEST['comment_parent'],
				'user_id' => $user->data->ID,
				'comment_date' => $time,
			);

			echo wp_insert_comment($data);
		}

		exit;
	}

	public static function getDirectoryList($directory) {

		// create an array to hold directory list
		$results = array();

		// create a handler for the directory
		$handler = opendir($directory);

		// open directory and walk through the filenames
		while ($file = readdir($handler)) {

			// if file isn't this directory or its parent, add it to the results
			if ($file != "." && $file != "..") {
				$results[] = $file;
			}
		}

		// tidy up: close the handler
		closedir($handler);

		// done!
		return $results;
	}

	public static function cut_text($text, $charlength) {
		$charlength++;

		if (function_exists('mb_strlen') AND function_exists('mb_substr')) {
			if (mb_strlen($text) > $charlength) {
				$subex = mb_substr($text, 0, $charlength);
				$exwords = explode(' ', $subex);
				$excut = - ( mb_strlen($exwords[count($exwords) - 1]) );
				if ($excut < 0) {
					return mb_substr($subex, 0, $excut);
				} else {
					return $subex;
				}
			} else {
				return $text;
			}
		} else {
			if (strlen($text) > $charlength) {
				$subex = substr($text, 0, $charlength);
				$exwords = explode(' ', $subex);
				$excut = - ( strlen($exwords[count($exwords) - 1]) );
				if ($excut < 0) {
					return substr($subex, 0, $excut);
				} else {
					return $subex;
				}
			} else {
				return $text;
			}
		}
	}

	//for THEMEMAKERS_MEDIAGALLERY
	public function get_mediagallery() {
		$query_images_args = array(
			'post_type' => 'attachment', 'post_mime_type' => 'image', 'post_status' => 'inherit', 'posts_per_page' => -1,
		);

		$query_images = new WP_Query($query_images_args);
		$images = array();
		foreach ($query_images->posts as $key => $image) {
			$images[$key]['image_url'] = $image->guid;
			$images[$key]['thumb'] = ThemeMakersHelper::resize_image($image->guid, 150, true, 150);
		}

		echo json_encode($images);
		exit;
	}

	public function get_audio_mediagallery() {
		$query_audio_args = array(
			'post_type' => 'attachment', 'post_mime_type' => 'audio', 'post_status' => 'inherit', 'posts_per_page' => -1,
		);

		$query_audio = new WP_Query($query_audio_args);
		$files = array();
		foreach ($query_audio->posts as $key => $file) {
			$files[$key]['file_url'] = $file->guid;
			$files[$key]['file_name'] = $file->post_title;
		}

		echo json_encode($files);
		exit;
	}

	public function get_video_mediagallery() {
		$query_video_args = array(
			'post_type' => 'attachment', 'post_mime_type' => 'video', 'post_status' => 'inherit', 'posts_per_page' => -1,
		);

		$query_video = new WP_Query($query_video_args);
		$files = array();
		foreach ($query_video->posts as $key => $file) {
			$files[$key]['file_url'] = $file->guid;
			$files[$key]['file_name'] = $file->post_title;
		}

		echo json_encode($files);
		exit;
	}

	public static function sanitize_quotes($str) {
		$str = str_replace("'", '\'', $str);
		$str = str_replace('"', "\"", $str);
		return $str;
	}

	//for skeleton css framework
	public static function convert_css_class_name($num, $framework = 'skeleton') {
		$class_names = array(
			1 => 'one',
			2 => 'two',
			3 => 'three',
			4 => 'four',
			5 => 'five',
			6 => 'six',
			7 => 'seven',
			8 => 'eight',
			9 => 'nine',
			10 => 'ten',
			11 => 'eleven',
			12 => 'twelve',
			13 => 'thirteen',
			14 => 'fourteen',
			15 => 'fifteen',
			16 => 'sixteen'
		);

		return $class_names[$num];
	}

	public static function get_theme_buttons() {
		return array(
			'default' => __('Default', TMM_THEME_FOLDER_NAME),
			'sky' => __('Sky', TMM_THEME_FOLDER_NAME),
			'cyan' => __('Cyan', TMM_THEME_FOLDER_NAME),
			'green' => __('Green', TMM_THEME_FOLDER_NAME),
			'lightgreen' => __('Lightgreen', TMM_THEME_FOLDER_NAME),
			'yellow' => __('Yellow', TMM_THEME_FOLDER_NAME),
			'blue' => __('Blue', TMM_THEME_FOLDER_NAME),
			'red' => __('Red', TMM_THEME_FOLDER_NAME),
			'orange' => __('Orange', TMM_THEME_FOLDER_NAME),
			'vinous' => __('Vinous', TMM_THEME_FOLDER_NAME),
			'grey' => __('Grey', TMM_THEME_FOLDER_NAME),
			'dark' => __('Dark', TMM_THEME_FOLDER_NAME),
		);
	}

	public static function get_monts_names($num) {
		$monthes = array(
			0 => __('January', TMM_THEME_FOLDER_NAME),
			1 => __('February', TMM_THEME_FOLDER_NAME),
			2 => __('March', TMM_THEME_FOLDER_NAME),
			3 => __('April', TMM_THEME_FOLDER_NAME),
			4 => __('May', TMM_THEME_FOLDER_NAME),
			5 => __('June', TMM_THEME_FOLDER_NAME),
			6 => __('July', TMM_THEME_FOLDER_NAME),
			7 => __('August', TMM_THEME_FOLDER_NAME),
			8 => __('September', TMM_THEME_FOLDER_NAME),
			9 => __('October', TMM_THEME_FOLDER_NAME),
			10 => __('November', TMM_THEME_FOLDER_NAME),
			11 => __('December', TMM_THEME_FOLDER_NAME),
		);

		return $monthes[$num];
	}

	public static function get_short_monts_names($num) {
		$monthes = array(
			0 => __('jan', TMM_THEME_FOLDER_NAME),
			1 => __('feb', TMM_THEME_FOLDER_NAME),
			2 => __('mar', TMM_THEME_FOLDER_NAME),
			3 => __('apr', TMM_THEME_FOLDER_NAME),
			4 => __('may', TMM_THEME_FOLDER_NAME),
			5 => __('jun', TMM_THEME_FOLDER_NAME),
			6 => __('jul', TMM_THEME_FOLDER_NAME),
			7 => __('aug', TMM_THEME_FOLDER_NAME),
			8 => __('sep', TMM_THEME_FOLDER_NAME),
			9 => __('oct', TMM_THEME_FOLDER_NAME),
			10 => __('nov', TMM_THEME_FOLDER_NAME),
			11 => __('dec', TMM_THEME_FOLDER_NAME),
		);

		return $monthes[$num];
	}

	public static function get_days_of_week($num) {
		$monthes = array(
			0 => __('Sunday', TMM_THEME_FOLDER_NAME),
			1 => __('Monday', TMM_THEME_FOLDER_NAME),
			2 => __('Tuesday', TMM_THEME_FOLDER_NAME),
			3 => __('Wednesday', TMM_THEME_FOLDER_NAME),
			4 => __('Thursday', TMM_THEME_FOLDER_NAME),
			5 => __('Friday', TMM_THEME_FOLDER_NAME),
			6 => __('Saturday', TMM_THEME_FOLDER_NAME),
		);

		return $monthes[$num];
	}

	public static function get_theme_buttons_sizes() {
		return array(
			'small' => __('Small', TMM_THEME_FOLDER_NAME),
			'medium' => __('Medium', TMM_THEME_FOLDER_NAME),
			'large' => __('Large', TMM_THEME_FOLDER_NAME)
		);
	}

	public static function quotes_shield($text) {
		$text = str_replace("\'", "&#039;", $text);
		$text = str_replace("'", "&#039;", $text);
		$text = str_replace('"', "&quot;", $text);

		return $text;
	}

	public static function db_quotes_shield($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				if (is_array($value)) {
					$data[$key] = self::db_quotes_shield($value);
				} else {
					$value = stripslashes($value);
					$value = str_replace('\"', '"', $value);
					$value = str_replace("\'", "'", $value);
					$data[$key] = $value;
				}
			}
		}

		return $data;
	}

	public static function get_unique_ids() {
		$result = array();
		for ($i = 0; $i < 5; $i++) {
			$result[] = uniqid();
		}

		echo json_encode($result);
		exit;
	}

	public static function get_post_sort_array() {
		return array('ID', 'date', 'post_date', 'title', 'post_title', 'name', 'post_name', 'modified',
			'post_modified', 'modified_gmt', 'post_modified_gmt', 'menu_order', 'parent', 'post_parent',
			'rand', 'comment_count', 'author', 'post_author');
	}

	public static function get_post_categories() {
		$post_categories_objects = get_categories(array(
			'orderby' => 'name',
			'order' => 'ASC',
			'style' => 'list',
			'show_count' => 0,
			'hide_empty' => 0,
			'use_desc_for_title' => 1,
			'child_of' => 0,
			'hierarchical' => true,
			'title_li' => '',
			'show_option_none' => '',
			'number' => NULL,
			'echo' => 0,
			'depth' => 0,
			'current_category' => 0,
			'pad_counts' => 0,
			'taxonomy' => 'category',
			'walker' => 'Walker_Category'));

		$post_categories = array();
		$post_categories[0] = __('All Categories', TMM_THEME_FOLDER_NAME);
		foreach ($post_categories_objects as $value) {
			$post_categories[$value->term_id] = $value->name;
		}

		return $post_categories;
	}

	public static function draw_breadcrumbs() {
		if (!is_home()) {
			global $post;
			echo '<a href="';
			echo home_url();
			echo '">';
			bloginfo('name');
			echo "</a> ";
			if (is_category() || is_single()) {
				echo ThemeMakersHelper::get_the_category_list(' ');

				if (is_single()) {
					echo " ";
					the_title();
				}
			} elseif (is_archive()) {
				if (is_post_type_archive('post')) {
					_e('Blog Archives', TMM_THEME_FOLDER_NAME);
				} elseif (is_post_type_archive('folio')) {
					_e('Folio Archives', TMM_THEME_FOLDER_NAME);
				} elseif (is_post_type_archive('event')) {
					_e('Events Archives', TMM_THEME_FOLDER_NAME);
				}
			} elseif (is_page()) {
				if ($post->post_parent) {
					echo ' <a href="' . get_permalink($post->post_parent) . '">' . get_the_title($post->post_parent) . '</a>';
				}
				echo the_title();
			}
		}
	}

	public static function get_the_category_list($separator = '', $parents = '', $post_id = false) {
		global $wp_rewrite, $cat;
		if (!is_object_in_taxonomy(get_post_type($post_id), 'category'))
			return apply_filters('the_category', '', $separator, $parents);

		$categories = get_the_category($post_id);
		if (empty($categories))
			return apply_filters('the_category', __('Uncategorized', TMM_THEME_FOLDER_NAME), $separator, $parents);

		$rel = ( is_object($wp_rewrite) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

		$thelist = '';
		foreach ($categories as $category) {

			if ($cat == $category->term_id) {
				$thelist .= '&nbsp;' . $category->name;
				break;
			} else {
				$thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" title="' . esc_attr(sprintf(__("View all posts in %s", TMM_THEME_FOLDER_NAME), $category->name)) . '" ' . $rel . '>' . $category->name . '</a></li>';
			}
		}

		return apply_filters('the_category', $thelist, $separator, $parents);
	}

	public static function get_page_backround($page_id) {
		if ($page_id) {
			$page_bg = Thememakers_Entity_Page_Constructor::get_page_settings($page_id);

			if ($page_bg['pagebg_type'] == "image") {
				if (!empty($page_bg['pagebg_image'])) {

					if (!$page_bg['pagebg_type_image_option']) {
						$page_bg['pagebg_type_image_option'] = "repeat";
					}

					switch ($page_bg['pagebg_type_image_option']) {
						case "repeat-x":
							if (!empty($page_bg['pagebg_image'])) {
								return "background: url(" . $page_bg['pagebg_image'] . ") repeat-x 0 0";
							} else {
								return "";
							}
							break;

						case "fixed":
							if (!empty($page_bg['pagebg_image'])) {
								return "background: url(" . $page_bg['pagebg_image'] . ") no-repeat center top fixed;";
							} else {
								return "";
							}
							break;

						default:
							if (!empty($page_bg['pagebg_image'])) {
								return "background: url(" . $page_bg['pagebg_image'] . ") repeat 0 0";
							} else {
								return "";
							}
							break;
					}
				}
			}

			if ($page_bg['pagebg_type'] == "color") {
				if (!empty($page_bg['pagebg_color'])) {
					return "background: " . $page_bg['pagebg_color'];
				}
			}

			return self::draw_body_bg();
		} else {
			return self::draw_body_bg();
		}
	}

	private static function draw_body_bg() {
		$disable_body_bg = get_option(TMM_THEME_PREFIX . "disable_body_bg");
		if (!$disable_body_bg) {
			$body_pattern = get_option(TMM_THEME_PREFIX . "body_pattern");
			$body_pattern_custom_color = get_option(TMM_THEME_PREFIX . "body_pattern_custom_color");
			$body_pattern_selected = (int) get_option(TMM_THEME_PREFIX . "body_pattern_selected");
			$body_bg_color_selected = get_option(TMM_THEME_PREFIX . "body_bg_color");

			if ($body_pattern_selected == 0 OR $body_pattern_selected == 1) {
				if (!empty($body_pattern)) {
					return "background: url(" . $body_pattern . ") repeat 0 0 " . $body_bg_color_selected . ";";
				} else {
					return "";
				}
			} else {
				return "background: " . $body_pattern_custom_color;
			}
		}
	}

	public static function draw_page_header_bg() {
		$page_header_custom_image = get_option(TMM_THEME_PREFIX . "page_header_custom_image");
		$page_header_custom_color = get_option(TMM_THEME_PREFIX . "page_header_custom_color");

		if (empty($page_header_custom_color)) {
			$page_header_custom_color = '#63C3D7';
		}

		if (!empty($page_header_custom_image)) {
			return "background: url(" . $page_header_custom_image . ") no-repeat center 0 " . $page_header_custom_color . ";";
		}

		if (!empty($page_header_custom_color)) {
			return "background-color: " . $page_header_custom_color;
		}

		return;
	}

	public static function get_upload_folder() {
		$path = wp_upload_dir();
		$path = $path['basedir'];

		if (!file_exists($path)) {
			mkdir($path, 0777);
		}

		$path = $path . '/thememakers/';
		if (!file_exists($path)) {
			mkdir($path, 0777);
		}

		return $path;
	}

}

