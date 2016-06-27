<?php
/**
 * Plugin Name: CPT Stark Radio
 * Description: Creates the "Stark Radio" CPT.
 * Author: Eric Defore
 * Author URI: http://realbigmarketing.com
 * Version: 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SportsTM_Stark_Radio' ) ) {

    /**
     * Main SportsTM_Stark_Radio class
     *
     * @since       1.0.0
     */
    class SportsTM_Stark_Radio {

        /**
         * @var         SportsTM_Stark_Radio $instance The one true SportsTM_Stark_Radio
         * @since       1.0.0
         */
        private static $instance;

        /**
         * @var         Database Name for our CPT
         * @since       1.0.0
         */
        private $name = 'stark_radio';

        /**
         * @var         Singular Name for our CPT
         * @since       1.0.0
         */
        private $singular ='Stark Radio';

        /**
         * @var         Plural Name for our CPT
         * @since       1.0.0
         */
        private $plural = 'Stark Radio';

        /**
         * @var         Menu Icon for our CPT
         * @since       1.0.0
         */
        private $icon = '/images/microphone.png';

        /**
         * @var         Does our CPT use a Single Template?
         * @since       1.0.0
         */
        private $is_public = true;

        /**
         * @var         Does our CPT use a traditional Archive?
         * @since       1.0.0
         */
        private $has_archive = false;

        /**
         * @var         Menu Position for our CPT
         * @since       1.0.0
         */
        private $position = 35;

        /**
         * @var         Supported Fields of our CPT
         * @since       1.0.0
         */
        private $supports = array( 'title', 'editor', 'thumbnail', 'author' );

        /**
         * @var         Supported Taxonomies of our CPT
         * @since       1.0.0
         */
        private $taxonomies = array( 'category', 'post_tag' );

        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true SportsTM_Stark_Radio
         */
        public static function get_instance() {

            if ( ! self::$instance ) {

                self::$instance = new SportsTM_Stark_Radio();
                self::$instance->setup_constants();
                self::$instance->hooks();

            }

            return self::$instance;

        }

        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {

            // Plugin version
            define( 'SportsTM_Stark_Radio_VER', '1.0.0' );
            // Plugin path
            define( 'SportsTM_Stark_Radio_DIR', plugin_dir_path( __FILE__ ) );
            // Plugin URL
            define( 'SportsTM_Stark_Radio_URL', plugin_dir_url( __FILE__ ) );

        }

        /**
         * Run action and filter hooks
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function hooks() {

            add_action( 'init', array( $this, 'register_post_type' ) );
            
            add_filter( "manage_edit-{$this->name}_columns", array( $this, 'columns' ) );

        }

        /**
         * Register our Post Type
         * 
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        public function register_post_type() {

            if ( strpos( $this->icon, 'dashicons' ) === false ) {
                $this->icon = get_stylesheet_directory_uri() . $this->icon;
            }

            $labels = array(
                'name' => $this->plural,
                'all_items' => sprintf( __( 'All %s' ), $this->plural ),
                'singular_name' => $this->singular,
                'add_new' => sprintf( __( 'Add New %s' ), $this->singular ),
                'add_new_item' => sprintf( __( 'Add New %s' ), $this->singular ),
                'edit_item' => sprintf( __( 'Edit %s' ), $this->singular ),
                'new_item' => sprintf( __( 'New %s' ), $this->singular ),
                'view_item' => sprintf( __( 'View %s' ), $this->plural ),
                'search_items' => sprintf( __( 'Search %s' ), $this->plural ),
                'not_found' => sprintf( __( 'No %s Found' ), $this->plural ),
                'not_found_in_trash' => sprintf( __( 'No %s Found in the Trash' ), $this->plural ),
                'parent_item_colon' => sprintf( __( 'Parent %s:' ), $this->singular ),
                'menu_name' => $this->plural,
            );

            $args = array(
                'labels' => $labels,
                'menu_icon' => $this->icon,
                'hierarchical' => false,
                'description' => $this->plural,
                'supports' => $this->supports,
                'public' => $this->is_public,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => $this->position,
                'show_in_nav_menus' => true,
                'publicly_queryable' => $this->is_public,
                'exclude_from_search' => ! $this->is_public,
                'has_archive' => $this->archive,
                'query_var' => true,
                'rewrite' => true,
                'capability_type' => 'post',
                'taxonomies' => $this->taxonomies,
            );

            register_post_type( $this->name, $args );

        }

        /**
         * Modify columns on Post Edit Screen
         * 
         * @access      public
         * @since       1.0.0
         * @param       array $columns Columns
         * @return      array Modified Columns
         */
        public function columns( $columns ) {

            $columns = array(
                'cb' => '<input type="checkbox" />',
                'title' => __( 'Episode Name' ),
                'author' => __( 'Author' ),
                'tags' => __( 'Tags' ),
                'date' => __( 'Date' )
            );

            return $columns;

        }

    }

}

/**
 * The main function responsible for returning the one true SportsTM_Stark_Radio
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \SportsTM_Stark_Radio The one true SportsTM_Stark_Radio
 */
add_action( 'plugins_loaded', 'SportsTM_Stark_Radio_load' );
function SportsTM_Stark_Radio_load() {

    return SportsTM_Stark_Radio::get_instance();

}