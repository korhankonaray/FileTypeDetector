<?php

class ThemeMakersThemeModel {

//for ajax
    public static function change_options() {

        $action_type = $_REQUEST['type'];
        $data = array();
        parse_str($_REQUEST['values'], $data);
        $data = ThemeMakersHelper::db_quotes_shield($data);

        switch ($action_type) {
            case 'save':
                if (!empty($data)) {

                    foreach ($data as $option => $newvalue) {

                        if ($option == "sliders") {
                            unset($newvalue["__GROUP_INDEX__"]);
                            unset($newvalue["__SLIDE_INDEX__"]);
                            update_option(TMM_THEME_PREFIX . $option, $newvalue);
                            continue;
                        }

                        //*****

                        if ($option == "sidebars") {
                            include_once TMM_THEME_PATH . "/admin/entities/entity_custom_sidebars.php";
                            $sidebar = new Thememakers_Entity_Custom_Sidebars();
                            unset($newvalue[0]);
                            $sidebar->save_sidebars($newvalue);
                            continue;
                        }
                        if ($option == "seo_group") {
                            include_once TMM_THEME_PATH . "/admin/entities/entity_seo_group.php";
                            $seo_group = new Thememakers_Entity_SEO_Group();
                            $seo_group->save_groups($newvalue);
                            continue;
                        }
                        if ($option == "contact_form") {
                            include_once TMM_THEME_PATH . "/admin/entities/entity_contact_form.php";
                            if (!empty($newvalue)) {
                                foreach ($newvalue as $key => $form) {
                                    if (!isset($newvalue[$key]['title'])) {
                                        unset($newvalue[$key]);
                                    }

                                    if (empty($newvalue[$key]['title'])) {
                                        unset($newvalue[$key]);
                                    }
                                }
                            }
                            Thememakers_Entity_Contact_Form::save($newvalue);
                            continue;
                        }

                        if ($option == "slides") {
                            unset($newvalue["__INDEX__"]);
                            unset($newvalue["__GROUP_INDEX__"]);
                            unset($newvalue["__SLIDE_INDEX__"]);
                            update_option(TMM_THEME_PREFIX . $option, $newvalue);
                            continue;
                        }

                        if (is_array($newvalue)) {
                            update_option(TMM_THEME_PREFIX . $option, $newvalue);
                        } else {
                            $newvalue = stripcslashes($newvalue);
                            $newvalue = str_replace('\"', '"', $newvalue);
                            $newvalue = str_replace("\'", "'", $newvalue);
                            update_option(TMM_THEME_PREFIX . $option, $newvalue);
                        }
                    }
                }
                _e('Options have been updated.', TMM_THEME_FOLDER_NAME);
                break;


            case 'reset':
                if (!empty($data)) {
                    foreach ($data as $option => $newvalue) {
                        if ($option == "sidebars") {
                            continue;
                        }
                        if ($option == "contact_form") {
                            continue;
                        }

                        if ($option == "slides") {
                            continue;
                        }


                        update_option(TMM_THEME_PREFIX . $option, ($newvalue));
                    }
                }
                _e('Options have been reset.', TMM_THEME_FOLDER_NAME);
                break;


            default:
                break;
        }

        //**** CSS REGENERATION
        $custom_css1 = ThemeMakersThemeView::draw_free_page(TMM_THEME_PATH . '/admin/views/custom_css1.php');
        $custom_css2 = ThemeMakersThemeView::draw_free_page(TMM_THEME_PATH . '/admin/views/custom_css2.php');
        $handle = fopen(TMM_THEME_PATH . '/css/custom1.css', 'w');
        fwrite($handle, $custom_css1);
        fclose($handle);
        $handle = fopen(TMM_THEME_PATH . '/css/custom2.css', 'w');
        fwrite($handle, $custom_css2);
        fclose($handle);
        exit;
    }

}

