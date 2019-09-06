<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" value="1" name="thememakers_meta_saving" />
<p>
    <label for="<?php echo $widget->get_field_id('title'); ?>"><?php _e('Title', TMM_THEME_FOLDER_NAME) ?>:</label>
    <input class="widefat" type="text" id="<?php echo $widget->get_field_id('title'); ?>" name="<?php echo $widget->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
</p>

<p>
    <label for="<?php echo $widget->get_field_id('width'); ?>"><?php _e('Width', TMM_THEME_FOLDER_NAME) ?>:</label>
    <input class="widefat" type="text" id="<?php echo $widget->get_field_id('width'); ?>" name="<?php echo $widget->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" />
</p>

<p>
    <label for="<?php echo $widget->get_field_id('height'); ?>"><?php _e('Height', TMM_THEME_FOLDER_NAME) ?>:</label>
    <input class="widefat" type="text" id="<?php echo $widget->get_field_id('height'); ?>" name="<?php echo $widget->get_field_name('height'); ?>" value="<?php echo $instance['height']; ?>" />
</p>

<p>
    <label for="<?php echo $widget->get_field_id('latitude'); ?>"><?php _e('Latitude', TMM_THEME_FOLDER_NAME) ?>:</label>
    <input class="widefat" type="text" id="<?php echo $widget->get_field_id('latitude'); ?>" name="<?php echo $widget->get_field_name('latitude'); ?>" value="<?php echo $instance['latitude']; ?>" />
</p>

<p>
    <label for="<?php echo $widget->get_field_id('longitude'); ?>"><?php _e('Longitude', TMM_THEME_FOLDER_NAME) ?>:</label>
    <input class="widefat" type="text" id="<?php echo $widget->get_field_id('longitude'); ?>" name="<?php echo $widget->get_field_name('longitude'); ?>" value="<?php echo $instance['longitude']; ?>" />
</p>


<p>
    <label for="<?php echo $widget->get_field_id('zoom'); ?>"><?php _e('Zoom', TMM_THEME_FOLDER_NAME) ?>:</label>
    <select id="<?php echo $widget->get_field_id('zoom'); ?>" name="<?php echo $widget->get_field_name('zoom'); ?>" class="widefat">
        <?php
        $zoom = array();
        for ($i = 1; $i < 24; $i++) {
            $zoom[] = $i;
        }
        ?>
        <?php foreach ($zoom as $i) : ?>
            <option <?php echo($i == $instance['zoom'] ? "selected" : "") ?> value="<?php echo $i ?>"><?php echo $i ?></option>
        <?php endforeach; ?>
    </select>
</p>


<p>
    <label for="<?php echo $widget->get_field_id('maptype'); ?>"><?php _e('Map type', TMM_THEME_FOLDER_NAME) ?>:</label>
    <select id="<?php echo $widget->get_field_id('maptype'); ?>" name="<?php echo $widget->get_field_name('maptype'); ?>" class="widefat">
        <?php
        $maptypes = array(
            'ROADMAP' => __('ROADMAP', TMM_THEME_FOLDER_NAME),
            'SATELLITE' => __('SATELLITE', TMM_THEME_FOLDER_NAME),
            'HYBRID' => __('HYBRID', TMM_THEME_FOLDER_NAME),
            'TERRAIN' => __('TERRAIN', TMM_THEME_FOLDER_NAME),
        );
        ?>
        <?php foreach ($maptypes as $type) : ?>
            <option <?php echo($type == $instance['maptype'] ? "selected" : "") ?> value="<?php echo $type ?>"><?php echo $type ?></option>
        <?php endforeach; ?>
    </select>
</p>

<p>
    <?php
    $checked = "";
    if ($instance['scrollwheel'] == 'true') {
        $checked = 'checked="checked"';
    }
    ?>
    <input type="checkbox" id="<?php echo $widget->get_field_id('scrollwheel'); ?>" name="<?php echo $widget->get_field_name('scrollwheel'); ?>" value="true" <?php echo $checked; ?> />
    <label for="<?php echo $widget->get_field_id('scrollwheel'); ?>"><?php _e('Show scrollwheel', TMM_THEME_FOLDER_NAME) ?>:</label>
</p>

<p>
    <?php
    $checked = "";
    if ($instance['marker'] == 'true') {
        $checked = 'checked="checked"';
    }
    ?>
    <input type="checkbox" id="<?php echo $widget->get_field_id('marker'); ?>" name="<?php echo $widget->get_field_name('marker'); ?>" value="true" <?php echo $checked; ?> />
    <label for="<?php echo $widget->get_field_id('marker'); ?>"><?php _e('Show marker', TMM_THEME_FOLDER_NAME) ?>:</label>
</p>



<p>
    <?php
    $checked = "";
    if ($instance['popup'] == 'true') {
        $checked = 'checked="checked"';
    }
    ?>
    <input type="checkbox" id="<?php echo $widget->get_field_id('popup'); ?>" name="<?php echo $widget->get_field_name('popup'); ?>" value="true" <?php echo $checked; ?> />
    <label for="<?php echo $widget->get_field_id('popup'); ?>"><?php _e('Show popup', TMM_THEME_FOLDER_NAME) ?>:</label>
</p>

<p>
    <label for="<?php echo $widget->get_field_id('html'); ?>"><?php _e('Html', TMM_THEME_FOLDER_NAME) ?>:</label>
    <textarea name="<?php echo $widget->get_field_name('html'); ?>" id="<?php echo $widget->get_field_id('html'); ?>" class="widefat"><?php echo $instance['html']; ?></textarea>
</p>


