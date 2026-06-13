<?php
/**
 * Custom Elementor Widget: Event Date & Time
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Only load if Elementor is active
if ( ! did_action( 'elementor/loaded' ) ) {
    return;
}

add_action( 'elementor/widgets/widgets_registered', 'venture_register_event_date_widget' );

function venture_register_event_date_widget() {

    if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
        return;
    }

    class Venture_Event_Date_Widget extends \Elementor\Widget_Base {

        public function get_name() {
            return 'venture-event-date';
        }

        public function get_title() {
            return __( 'Event Date & Time', 'venture-media' );
        }

        public function get_icon() {
            return 'eicon-date';
        }

        public function get_categories() {
            return [ 'general' ];
        }

        protected function register_controls() {
            $this->start_controls_section(
                'content_section',
                [
                    'label' => __( 'Event Date & Time', 'venture-media' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'event_datetime',
                [
                    'label'       => __( 'Event Date & Time', 'venture-media' ),
                    'type'        => \Elementor\Controls_Manager::DATE_TIME,
                    'picker_options' => [
                        'enableTime' => true,
                        'dateFormat' => 'Y-m-d H:i',
                    ],
                    'default'     => '',
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();
            $datetime = ! empty( $settings['event_datetime'] ) ? $settings['event_datetime'] : '';

            if ( ! $datetime ) {
                return;
            }

            // Save to post meta (only when editing an Event)
            if ( is_singular( 'events' ) && get_post_type() === 'events' ) {
                update_post_meta( get_the_ID(), '_event_datetime', sanitize_text_field( $datetime ) );
            }

            // Display formatted date/time
            $timestamp = strtotime( $datetime );
            if ( $timestamp ) {
                echo '<div class="venture-event-datetime">';
                echo esc_html( date( 'F j, Y \a\t g:i A', $timestamp ) );
                echo '</div>';
            }
        }
    }

    \Elementor\Plugin::instance()->widgets_manager->register( new Venture_Event_Date_Widget() );
}
