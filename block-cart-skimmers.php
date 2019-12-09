<?php
/**
 * Plugin Name: Woo Block Skimmers
 * Plugin URI:        https://github.com/freddiemixell/woo-block-skimmers/
 * Description:       Prevent scammers from stealing your customers credit card information.
 * Version:           1.0.0
 * Author:            Freddie Mixell
 * Author URI:        https://github.com/freddiemixell/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       woo-block-skimmers
 */

add_action( 'template_redirect','disable_external_scripts' );

function disable_external_scripts() {
    global $woocommerce;

    /**
     * Allowed Image Sources
     *
     * @var array $img_src Allowed downloaded images.
     */
    $img_src = array(
        'https://*.stripe.com',
        'http://*.gravatar.com',
        'https://www.paypalobjects.com'
    );
    $img_src = apply_filters( 'woo_block_skimmers_img_src', $img_src );
    $img_src = "img-src 'self' " . implode( ' ', $img_src ) . ', ';

    /**
     * Allowed Script Sources
     *
     * @var array $script_src Allowed downloaded javascript.
     */
    $script_src = array(
        'https://checkout.stripe.com',
        'https://*.stripe.com',
        "'sha256-2N2eS+4Cy0nFISF8T0QGez36fUJfaY+o6QBWxTUYiHc='",
        "'sha256-DpOqX3SJKHlqyJojfUy3n0K6kwXVT2lclH2vWLBXawc='",
        "'sha256-l99z6+XVNiCBLUQ6qmiy8YG7vW20UXWRg+zYFMaYmvo='",
        "'sha256-m16ZMcWtXyc/TG61mIUG72BHGVeSMSSyiqsvhWPot/0='",
        "'sha256-Ett6fuSFU4H1hSyEezT/0PRpfl41M3394W68gZ7Hveg='",
        "'sha256-oyW3Q+ELF4gs5hzNRzqJm/IjmG3j488O4e/OUzLu4io='",
        "'sha256-XwNXvOz61OyhS81tx1wzTpEkCYAN6Agbu8pzJWEOPJ0='",
        "'sha256-+K3NCJyF5nQGty903hN4dEigE8ymStVppv225iWe27s='",
        "'sha256-p+qSCEdqU0XdAxhwXRnLMaBCcth9fvQ2zC3FpYUsImc='",
        "'sha256-dYpn3fCjB0krqw/9FNy+w/kY8GozNNAB2PhY8hyx9SA='",
        "'sha256-LUPZlMo37zvIj2QXzs+v+CjI2GfIB4QoXMfRq6r/rcM='",
        "'sha256-XtvSfuLifoLqf6CtwaAEA0P61Dl9yX71awU159fAuj0='",
        "'sha256-n3qH1zzzTNXXbWAKXOMmrBzjKgIQZ7G7UFh/pIixNEQ='",
        "'sha256-KoZvlNi6WIlva5SMPsgkZKuz3pwSCUhpugmi7saPqak='",
        ""
    );
    $script_src = apply_filters( 'woo_block_skimmers_script_src', $script_src );
    $script_src = "script-src 'self' " . implode( ' ', $script_src ) . ', ';

    /**
     * Allowed iFrame Sources
     *
     * @var array $frame_src Allowed iframes.
     */
    $frame_src = array(
        'https://checkout.stripe.com',
        'https://js.stripe.com/'
    );
    $frame_src = apply_filters( 'woo_block_skimmers_frame_src', $frame_src );
    $frame_src = "frame-src " . implode( ' ', $frame_src ) . ', ';

    /**
     * Allowed Places To SEND Data
     * @desc This is the most important one. Blocks sending your cc's to malicous places.
     * @var array $connect_src Allowed connection sources.
     */
    $connect_src = array(
        'https://checkout.stripe.com',
        'https://fonts.googleapis.com'
    );
    $connect_src = apply_filters( 'woo_block_skimmers_connect_src', $connect_src );
    $connect_src = "connect-src 'self' " . implode( ' ', $connect_src );

    $security_policy = "Content-Security-Policy: " . $img_src . $script_src . $frame_src . $connect_src;

    if ( is_checkout() ) {
        header( $security_policy );
    }
}
