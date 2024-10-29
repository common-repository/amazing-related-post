<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists("RPKH_settings")) {

    class RPKH_settings
    {
        public function __construct()
        {
            add_action("admin_menu", array($this, "RPKH_add_menu_item"));
            add_action('admin_init', array($this, 'RPKH_setting_option'));
        }
        public function RPKH_add_menu_item()
        {
            add_menu_page(__("Related Post"), __("Related Post"), "manage_options", __("related-post"), array($this, "RPKH_setting_page_content"), 'dashicons-list-view');
        }

        public function RPKH_setting_page_content()
        {
?>
            <form action="options.php" method="post">
                <div class="input-text-wrap loginas" id="title-wrap">
                    <?php
                    settings_fields('option');
                    do_settings_sections('option');
                    ?>
                </div>
                <?php
                settings_errors();
                submit_button(__('save setting'));
                ?>
            </form>
        <?php
        }



        public function RPKH_setting_option()
        {
            register_setting('option', __('option'));
            add_settings_section('RPKH_my_id', '<h1 class="setting-page-heading" style="color: rgb(0, 136, 178);margin-top: 30px">' . __('Related Post Setting') . '<h1/>', '', 'option');
            add_settings_field(
                'posts_according_to',
                __('Posts According To:'),
                array($this, 'RPKH_create_according_to_select'),
                'option',
                'RPKH_my_id',
                array(
                    'id' => 'posts_according_to',
                    'name' =>  'Posts According To',
                    'options' => array(
                        'Prost Type' => 'Post Type',
                        'Category' => 'Category'
                    )
                )
            );

            add_settings_field(
                'posts_display',
                __('Posts display way:'),
                array($this, 'RPKH_create_order_select'),
                'option',
                'RPKH_my_id',
                array(
                    'id' => 'posts_display',
                    'name' =>  'posts display',
                    'options' => array(
                        'DESC' => 'DESC',
                        'ASC' => 'ASC',
                    )
                )
            );

            add_settings_field(
                'max_posts_count',
                __('Max Posts Count:'),
                array($this, 'RPKH_create_input'),
                'option',
                'RPKH_my_id',
                array(
                    'id' => 'max_posts_count',
                    'name' => 'max posts count',
                    'type' => 'number'
                )
            );

            add_settings_field(
                'posts_design',
                __('Posts Design:'),
                array($this, 'RPKH_create_desgin_select'),
                'option',
                'RPKH_my_id',
                array(
                    'id' => 'posts_design',
                    'name' =>  'posts_design',
                    'options' => array(
                        'Grid' => 'Grid',
                        'List' => 'List',
                    )
                )
            );
        }

        public function RPKH_create_according_to_select($args)
        {
            $val = get_option('option');
        ?>
            <select name="option[<?php esc_attr_e($args['id']) ?>]" id="option[<?php esc_attr_e($args['id']) ?>]">
                <?php
                foreach ($args['options'] as &$item) {
                ?>
                    <option value="<?php esc_attr_e($item) ?>" <?php echo ($val[$args['id']] === $item ? "selected='selected'" : '') ?>> <?php esc_html_e($item) ?> </option>
                <?php
                }
                ?>
            </select>
        <?php
        }


        public function RPKH_create_order_select($args)
        {
            $val = get_option('option');
        ?>
            <select name="option[<?php esc_attr_e($args['id']) ?>]" id="option[<?php esc_attr_e($args['id']) ?>]">
                <?php
                foreach ($args['options'] as &$item) {
                ?>
                    <option value="<?php esc_attr_e($item) ?>" <?php echo ($val[$args['id']] === $item ? "selected='selected'" : '') ?>> <?php esc_html_e($item) ?> </option>
                <?php
                }
                ?>
            </select>
        <?php
        }


        public function RPKH_create_input($args)
        {
            $val = get_option('option');
            // print_r($val);
            // exit;
            // $val[$args['id']] ? '' : update_option("option" . [$args['id']] . "", 1);
        ?>
            <input type="<?php esc_attr_e($args['type']) ?>" min="1" minlength="1" id="<?php esc_attr_e($args['id']) ?>" name="option[<?php esc_attr_e($args['id']) ?>]" value="<?php esc_attr_e($val[$args['id']]) ?>">
        <?php
        }

        public function RPKH_create_desgin_select($args)
        {
            $val = get_option('option');
        ?>
            <select name="option[<?php esc_attr_e($args['id']) ?>]" id="option[<?php esc_attr_e($args['id']) ?>]">
                <?php
                foreach ($args['options'] as &$item) {
                ?>
                    <option value="<?php esc_attr_e($item) ?>" <?php echo ($val[$args['id']] === $item ? "selected='selected'" : '') ?>> <?php esc_html_e($item) ?> </option>
                <?php
                }
                ?>
            </select>

            <div style="margin-top: 15px; ">
                <?php

                if ($val[$args['id']] === 'List') {
                ?>
                    <img style="padding:5px;border:3px solid #e1e1e1;border-radius: 5px;width:400px" src="<?php echo plugins_url("../assets/screenshot-1.png", __FILE__); ?>" alt="">
                <?php
                } else {
                ?>
                    <img style="padding:5px;border:3px solid #e1e1e1;border-radius: 5px;width:400px" src="<?php echo plugins_url("../assets/screenshot-2.png", __FILE__); ?>" alt="">

                <?php
                }
                ?>
            </div>
<?php

        }
    }
}

new RPKH_settings();
