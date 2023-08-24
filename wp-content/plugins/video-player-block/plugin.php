<?php
/**
 * Plugin Name: Video Player Block
 * Description: A Simple, accessible, Easy to Use & fully Customizable video player. 
 * Version: 1.0.0
 * Author: bPlugins LLC
 * Author URI: http://bplugins.com
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: video-player
 */

// ABS PATH
if ( !defined( 'ABSPATH' ) ) { exit; }

// Constant
define( 'VPB_PLUGIN_VERSION', 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.0.0' );
define( 'VPB_ASSETS_DIR', plugin_dir_url( __FILE__ ) . 'assets/' );

// Generate Styles
class VPBStyleGenerator {
    public static $styles = [];
    public static function addStyle( $selector, $styles ){
        if( array_key_exists( $selector, self::$styles ) ){
           self::$styles[$selector] = wp_parse_args( self::$styles[$selector], $styles );
        }else { self::$styles[$selector] = $styles; }
    }
    public static function renderStyle(){
        $output = '';
        foreach( self::$styles as $selector => $style ){
            $new = '';
            foreach( $style as $property => $value ){
                if( $value == '' ){ $new .= $property; }else { $new .= " $property: $value;"; }
            }
            $output .= "$selector { $new }";
        }
        return $output;
    }
}

// Video Player
class vpbVideoPlayer{
    protected static $_instance = null;

    function __construct(){
        add_action( 'enqueue_block_assets', [$this, 'enqueueBlockAssets'] );
        add_action( 'init', [$this, 'onInit'] );
    }

    public static function instance(){
        if( self::$_instance === null ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function enqueueBlockAssets(){
        wp_enqueue_style( 'plyr', VPB_ASSETS_DIR . 'css/plyr.css', [], '3.6.12' );
        wp_enqueue_script( 'plyr', VPB_ASSETS_DIR . 'js/plyr.js', [], '3.6.12', true );
    }

    function onInit() {
        wp_register_style( 'vpb-video-editor-style', plugins_url( 'dist/editor.css', __FILE__ ), [ 'wp-edit-blocks' ], VPB_PLUGIN_VERSION ); // Backend Style
        wp_register_style( 'vpb-video-style', plugins_url( 'dist/style.css', __FILE__ ), [ 'wp-editor' ], VPB_PLUGIN_VERSION ); // Both Style

        register_block_type( __DIR__, [
            'editor_style'      => 'vpb-video-editor-style',
            'style'             => 'vpb-video-style',
            'render_callback'   => [$this, 'render']
        ] ); // Register Block

        wp_set_script_translations( 'vpb-video-editor-script', 'video-player', plugin_dir_path( __FILE__ ) . 'languages' ); // Translate
    }

    function render( $attributes ){
        extract( $attributes );

        $vpbVideoPlayerStyle = new VPBStyleGenerator(); // Generate Styles
        $vpbVideoPlayerStyle::addStyle( "#vpbVideoPlayer-$clientId .vpbVideoPlayer", [
            'width' => '0px' === $width || '0%' === $width || '0em' === $width ? '100%' : $width,
            'border-radius' => $radius
        ] );

        $jsonData = wp_json_encode( ['controls' => $controls, 'repeat' => $repeat, 'muted' => $muted, 'autoplay' => $autoplay, 'resetOnEnd' => $resetOnEnd, 'autoHideControl' => $autoHideControl] );

        ob_start(); ?>
        <div class='wp-block-vpb-video <?php echo 'align' . esc_attr( $align ); ?>' id='vpbVideoPlayer-<?php echo esc_attr( $clientId ) ?>' data-video='<?php echo $jsonData; ?>'>
            <style><?php echo wp_kses( $vpbVideoPlayerStyle::renderStyle(), [] ) ?></style>

            <div class='vpbVideoPlayer'>
                <div class='videoWrapper'>
                    <video controls playsinline data-poster='<?php echo esc_url( $poster ); ?>' preload='metadata'>
                        Your browser does not support the video tag.
                        <source src=<?php echo esc_url( $source ); ?> type='video/mp4' />
                    </video>
                </div>
            </div> <!-- Video Player -->
        </div>

        <?php $vpbVideoPlayerStyle::$styles = []; // Empty styles
        return ob_get_clean();
    } // Render
}
vpbVideoPlayer::instance();