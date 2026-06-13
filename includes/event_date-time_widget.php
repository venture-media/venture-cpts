<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'elementor/widgets/widgets_registered', 'venture_register_event_date_widget' );

function venture_register_event_date_widget() {
    // Make sure Elementor is active
    if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
        return;
    }

    class Venture_Event_Date_Widget extends \Elementor\Widget_Base {

        public function get_name() {
            return 'venture-event-date';
        }

        public function get_title() {
            return 'Event Date & Time';
        }

        public function get_icon() {
            return 'eicon-date';
        }

        public function get_categories() {
            return [ 'general' ]; // or create your own category
        }

        protected function register_controls() {
            $this->start_controls_section(
                'content_section',
                [
                    'label' => 'Event Date & Time',
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'event_datetime',
                [
                    'label'       => 'Event Date & Time',
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
            $datetime = $settings['event_datetime'];

            if ( ! empty( $datetime ) ) {
                // Save to post meta when rendered in editor or frontend
                if ( is_singular( 'events' ) ) {
                    update_post_meta( get_the_ID(), '_event_datetime', sanitize_text_field( $datetime ) );
                }

                // Format and display
                $timestamp = strtotime( $datetime );
                echo '<div class="venture-event-datetime">';
                echo '<strong>Event Date:</strong> ' . esc_html( date( 'F j, Y \a\t g:i A', $timestamp ) );
                echo '</div>';
            }
        }
    }

    \Elementor\Plugin::instance()->widgets_manager->register( new Venture_Event_Date_Widget() );
}
endif;
