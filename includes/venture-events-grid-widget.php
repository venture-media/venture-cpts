<?php
/**
 * Custom Elementor Widget: Venture Events Grid
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Only load if Elementor is active
if ( ! did_action( 'elementor/loaded' ) ) {
    return;
}

add_action( 'elementor/widgets/widgets_registered', 'venture_register_events_grid_widget' );

function venture_register_events_grid_widget() {

    if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
        return;
    }

    class Venture_Events_Grid_Widget extends \Elementor\Widget_Base {

        public function get_name() {
            return 'venture-events-grid';
        }

        public function get_title() {
            return __( 'Venture Events Grid', 'venture-media' );
        }

        public function get_icon() {
            return 'eicon-posts-grid';
        }

        public function get_categories() {
            return [ 'general' ];
        }

        protected function register_controls() {

            // === LAYOUT ===
            $this->start_controls_section(
                'layout_section',
                [
                    'label' => __( 'Layout', 'venture-media' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'columns',
                [
                    'label'   => __( 'Columns', 'venture-media' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => '3',
                    'options' => [
                        '1' => __( '1 Column', 'venture-media' ),
                        '2' => __( '2 Columns', 'venture-media' ),
                        '3' => __( '3 Columns', 'venture-media' ),
                        '4' => __( '4 Columns', 'venture-media' ),
                    ],
                ]
            );

            $this->add_control(
                'posts_per_page',
                [
                    'label'   => __( 'Posts Per Page', 'venture-media' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'default' => 6,
                    'min'     => 1,
                    'max'     => 50,
                ]
            );

            $this->end_controls_section();

            // === QUERY ===
            $this->start_controls_section(
                'query_section',
                [
                    'label' => __( 'Query', 'venture-media' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'order',
                [
                    'label'   => __( 'Sort by Event Date', 'venture-media' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'DESC' => __( 'Newest First', 'venture-media' ),
                        'ASC'  => __( 'Oldest First', 'venture-media' ),
                    ],
                ]
            );

            $this->add_control(
                'hide_past_events',
                [
                    'label'        => __( 'Hide Past Events', 'venture-media' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     => __( 'Yes', 'venture-media' ),
                    'label_off'    => __( 'No', 'venture-media' ),
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $args = [
                'post_type'      => 'events',
                'posts_per_page' => $settings['posts_per_page'],
                'meta_key'       => '_event_datetime',
                'orderby'        => 'meta_value',
                'order'          => $settings['order'],
            ];

            // Hide past events
            if ( $settings['hide_past_events'] === 'yes' ) {
                $args['meta_query'] = [
                    [
                        'key'     => '_event_datetime',
                        'value'   => current_time( 'Y-m-d H:i' ),
                        'compare' => '>=',
                        'type'    => 'DATETIME',
                    ],
                ];
            }

            $query = new WP_Query( $args );

            if ( ! $query->have_posts() ) {
                echo '<p>' . esc_html__( 'No upcoming events found.', 'venture-media' ) . '</p>';
                return;
            }

            $columns = intval( $settings['columns'] );
            ?>
            <div class="venture-events-grid columns-<?php echo esc_attr( $columns ); ?>">
                <?php while ( $query->have_posts() ) : $query->the_post(); 
                    $event_datetime = get_post_meta( get_the_ID(), '_event_datetime', true );
                    $formatted_date = $event_datetime ? date( 'F j, Y \a\t g:i A', strtotime( $event_datetime ) ) : '';
                ?>
                    <div class="venture-event-item">
                        
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="venture-event-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="venture-event-content">
                            <h3 class="venture-event-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <?php if ( $formatted_date ) : ?>
                                <div class="venture-event-date">
                                    <?php echo esc_html( $formatted_date ); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php
        }
    }

    \Elementor\Plugin::instance()->widgets_manager->register( new Venture_Events_Grid_Widget() );
}
