<?php
 
/*
 
Plugin Name: No PO Box WooCommerce
Description: This plugin will block PO Box address at Checkout on WooCommerce
Version: 1.0 
Author: Rayna McGinnis 
Author URI: https://fireflywebstudio.com
License: GPLv2 or later
Text Domain: no-po-box-woocommerce
 
*/

// Do not allow PO Boxes in the shipping address on Woocommerce

add_action('woocommerce_after_checkout_validation', 'no_po_boxes_woocommerce');

function no_po_boxes_woocommerce( $posted ) {
  global $woocommerce;

  $address  = ( isset( $posted['shipping_address_1'] ) ) ? $posted['shipping_address_1'] : $posted['billing_address_1'];
  $postcode = ( isset( $posted['shipping_postcode'] ) ) ? $posted['shipping_postcode'] : $posted['billing_postcode'];

  $replace  = array(" ", ".", ",");
  $address  = strtolower( str_replace( $replace, '', $address ) );
  $postcode = strtolower( str_replace( $replace, '', $postcode ) );

  if ( strstr( $address, 'pobox' ) || strstr( $postcode, 'pobox' ) ) {
    wc_add_notice( sprintf( __( "Sorry, we cannot ship to PO BOX addresses.") ) ,'error' );
  }
}