<?php
/**
 * Plugin Name:       Venture CPTs
 * Plugin URI:        https://github.com/venture-media/venture-cpts
 * Description:       Registers Custom Post Types for Business Sectors, Client Contacts, Events and traders. Includes hierarchical category taxonomies and pretty permalinks.
 * Version:           0.9.1
 * Author:            Leon de Klerk
 * Author URI:        https://github.com/Leon2332
 * License:           MIT
 * Text Domain:       venture-media
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Only define once (prevents conflicts if loaded multiple times)
if ( ! function_exists( 'venture_cpt_business_sectors' ) ) :


// 1. BUSINESS SECTORS

function venture_cpt_business_sectors() {
    register_post_type( 'business_sectors', [
        'labels' => [
            'name' => 'Business Sectors',
            'singular_name' => 'Business Sector',
            'add_new' => 'Add Sector',
            'add_new_item' => 'Add New Business Sector',
            'edit_item' => 'Edit Business Sector',
            'new_item' => 'New Business Sector',
            'view_item' => 'View Business Sector',
            'search_items' => 'Search Business Sectors',
            'not_found' => 'No business sectors found',
            'not_found_in_trash' => 'No business sectors found in Trash',
            'all_items' => 'All Business Sectors',
            'menu_name' => 'Business Sectors',
            'name_admin_bar' => 'Business Sector'
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
        'rewrite' => [
            'slug' => 'business-sectors/%business_sector_category%',
            'with_front' => false
        ]
    ]);
}
add_action( 'init', 'venture_cpt_business_sectors', 0 );


function venture_cpt_business_sectors_taxonomy() {
    $labels = [
        'name' => 'Sector Categories',
        'singular_name' => 'Sector Category',
        'search_items' => 'Search Sector Categories',
        'all_items' => 'All Sector Categories',
        'parent_item' => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item' => 'Edit Sector Category',
        'update_item' => 'Update Sector Category',
        'add_new_item' => 'Add New Sector Category',
        'new_item_name' => 'New Sector Category Name',
        'menu_name' => 'Sector Categories',
    ];

    register_taxonomy( 'business_sector_category', [ 'business_sectors' ], [
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => [
            'slug' => 'business-sectors',
            'with_front' => false,
            'hierarchical' => true
        ],
    ]);
}
add_action( 'init', 'venture_cpt_business_sectors_taxonomy', 10 );


function venture_business_sectors_permalink( $post_link, $post ) {
    if ( $post->post_type === 'business_sectors' ) {
        if ( $terms = get_the_terms( $post->ID, 'business_sector_category' ) ) {
            $post_link = str_replace( '%business_sector_category%', array_pop( $terms )->slug, $post_link );
        } else {
            $post_link = str_replace( '%business_sector_category%', 'uncategorized', $post_link );
        }
    }
    return $post_link;
}
add_filter( 'post_type_link', 'venture_business_sectors_permalink', 10, 2 );


    
// 2. CLIENT CONTACTS

function venture_cpt_client_contacts() {
    register_post_type( 'client_contacts', [
        'labels' => [
            'name' => 'Client Contacts',
            'singular_name' => 'Client Contact',
            'add_new' => 'Add Contact',
            'add_new_item' => 'Add New Client Contact',
            'edit_item' => 'Edit Client Contact',
            'new_item' => 'New Client Contact',
            'view_item' => 'View Client Contact',
            'search_items' => 'Search Client Contacts',
            'not_found' => 'No client contacts found',
            'not_found_in_trash' => 'No client contacts found in Trash',
            'all_items' => 'All Client Contacts',
            'menu_name' => 'Client Contacts',
            'name_admin_bar' => 'Client Contact'
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-businessman',
        'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
        'rewrite' => [
            'slug' => 'client-contacts/%client_contact_category%',
            'with_front' => false
        ]
    ]);
}
add_action( 'init', 'venture_cpt_client_contacts', 0 );


function venture_cpt_client_contacts_taxonomy() {
    $labels = [
        'name' => 'Contact Categories',
        'singular_name' => 'Contact Category',
        'search_items' => 'Search Contact Categories',
        'all_items' => 'All Contact Categories',
        'parent_item' => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item' => 'Edit Contact Category',
        'update_item' => 'Update Contact Category',
        'add_new_item' => 'Add New Contact Category',
        'new_item_name' => 'New Contact Category Name',
        'menu_name' => 'Contact Categories',
    ];

    register_taxonomy( 'client_contact_category', [ 'client_contacts' ], [
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => [
            'slug' => 'client-contacts',
            'with_front' => false,
            'hierarchical' => true
        ],
    ]);
}
add_action( 'init', 'venture_cpt_client_contacts_taxonomy', 10 );


function venture_client_contacts_permalink( $post_link, $post ) {
    if ( $post->post_type === 'client_contacts' ) {
        if ( $terms = get_the_terms( $post->ID, 'client_contact_category' ) ) {
            $post_link = str_replace( '%client_contact_category%', array_pop( $terms )->slug, $post_link );
        } else {
            $post_link = str_replace( '%client_contact_category%', 'uncategorized', $post_link );
        }
    }
    return $post_link;
}
add_filter( 'post_type_link', 'venture_client_contacts_permalink', 10, 2 );


    
// 3. EVENTS

function venture_cpt_events() {
    register_post_type( 'events', [
        'labels' => [
            'name' => 'Events',
            'singular_name' => 'Event',
            'add_new' => 'Add Event',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'new_item' => 'New Event',
            'view_item' => 'View Event',
            'search_items' => 'Search Events',
            'not_found' => 'No events found',
            'not_found_in_trash' => 'No events found in Trash',
            'all_items' => 'All Events',
            'menu_name' => 'Events',
            'name_admin_bar' => 'Event'
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
        'rewrite' => [
            'slug' => 'events/%event_category%',
            'with_front' => false
        ]
    ]);
}
add_action( 'init', 'venture_cpt_events', 0 );


function venture_cpt_events_taxonomy() {
    $labels = [
        'name' => 'Event Categories',
        'singular_name' => 'Event Category',
        'search_items' => 'Search Event Categories',
        'all_items' => 'All Event Categories',
        'parent_item' => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item' => 'Edit Event Category',
        'update_item' => 'Update Event Category',
        'add_new_item' => 'Add New Event Category',
        'new_item_name' => 'New Event Category Name',
        'menu_name' => 'Event Categories',
    ];

    register_taxonomy( 'event_category', [ 'events' ], [
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => [
            'slug' => 'events',
            'with_front' => false,
            'hierarchical' => true
        ],
    ]);
}
add_action( 'init', 'venture_cpt_events_taxonomy', 10 );


function venture_events_permalink( $post_link, $post ) {
    if ( $post->post_type === 'events' ) {
        if ( $terms = get_the_terms( $post->ID, 'event_category' ) ) {
            $post_link = str_replace( '%event_category%', array_pop( $terms )->slug, $post_link );
        } else {
            $post_link = str_replace( '%event_category%', 'uncategorized', $post_link );
        }
    }
    return $post_link;
}
add_filter( 'post_type_link', 'venture_events_permalink', 10, 2 );



// 4. TRADERS

function venture_cpt_traders() {
    register_post_type( 'traders', [
        'labels' => [
            'name' => 'Traders',
            'singular_name' => 'Trader',
            'add_new' => 'Add Trader',
            'add_new_item' => 'Add New Trader',
            'edit_item' => 'Edit Trader',
            'new_item' => 'New Trader',
            'view_item' => 'View Trader',
            'search_items' => 'Search Traders',
            'not_found' => 'No traders found',
            'not_found_in_trash' => 'No traders found in Trash',
            'all_items' => 'All Traders',
            'menu_name' => 'Traders',
            'name_admin_bar' => 'Trader'
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'menu_position' => 8,
        'menu_icon' => 'dashicons-chart-line',
        'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
        'rewrite' => [
            'slug' => 'traders/%trader_category%',
            'with_front' => false
        ]
    ]);
}
add_action( 'init', 'venture_cpt_traders', 0 );


function venture_cpt_traders_taxonomy() {
    $labels = [
        'name' => 'Trader Categories',
        'singular_name' => 'Trader Category',
        'search_items' => 'Search Trader Categories',
        'all_items' => 'All Trader Categories',
        'parent_item' => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item' => 'Edit Trader Category',
        'update_item' => 'Update Trader Category',
        'add_new_item' => 'Add New Trader Category',
        'new_item_name' => 'New Trader Category Name',
        'menu_name' => 'Trader Categories',
    ];

    register_taxonomy( 'trader_category', [ 'traders' ], [
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => [
            'slug' => 'traders',
            'with_front' => false,
            'hierarchical' => true
        ],
    ]);
}
add_action( 'init', 'venture_cpt_traders_taxonomy', 10 );


function venture_traders_permalink( $post_link, $post ) {
    if ( $post->post_type === 'traders' ) {
        if ( $terms = get_the_terms( $post->ID, 'trader_category' ) ) {
            $post_link = str_replace( '%trader_category%', array_pop( $terms )->slug, $post_link );
        } else {
            $post_link = str_replace( '%trader_category%', 'uncategorized', $post_link );
        }
    }
    return $post_link;
}
add_filter( 'post_type_link', 'venture_traders_permalink', 10, 2 );

endif; // End if ! function_exists( 'venture_cpt_business_sectors' )
