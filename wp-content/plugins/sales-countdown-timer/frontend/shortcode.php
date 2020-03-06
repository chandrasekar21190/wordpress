<?php

/**
 * Class SALES_COUNTDOWN_TIMER_Frontend_Shortcode
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SALES_COUNTDOWN_TIMER_Frontend_Shortcode {
	protected $settings;
	protected $data;

	public function __construct() {
		$this->settings = new SALES_COUNTDOWN_TIMER_Data();
//		/*Register scripts*/
		add_action( 'init', array( $this, 'shortcode_init' ) );
	}

	public function shortcode_init() {
		add_shortcode( 'sales_countdown_timer', array( $this, 'register_shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'shortcode_enqueue_script' ) );
	}

	public function shortcode_enqueue_script() {
		if ( ! wp_script_is( 'woo-sctr-shortcode-style', 'registered' ) ) {
			wp_register_style( 'woo-sctr-shortcode-style', SALES_COUNTDOWN_TIMER_CSS . 'shortcode-style.css', array(), SALES_COUNTDOWN_TIMER_VERSION );
		}
		if ( ! wp_script_is( 'woo-sctr-shortcode-script', 'registered' ) ) {
			wp_register_script( 'woo-sctr-shortcode-script', SALES_COUNTDOWN_TIMER_JS . 'shortcode-script.js', array('jquery'), SALES_COUNTDOWN_TIMER_VERSION );
		}
	}

	public function register_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'id'                            => '',
			'names'                         => '',
			'message'                       => '{countdown_timer}',
			'active'                        => 1,
			'enable_single_product'         => 0,
			'is_variation'                  => 0,
			'sale_price_type'               => 0,
			'time_type'                     => 'fixed',
			'count_style'                   => 1,
			'sale_from_date'                => '',
			'sale_to_date'                  => 0,
			'sale_from_time'                => 0,
			'sale_to_time'                  => 0,
			'override_price'                => '',
			'override_sale_time'            => '',
			'upcoming'                      => 0,
			'upcoming_message'              => 'Starts in {countdown_timer}',
			'style'                         => 1,
			'time_separator'                => '',
			'display_type'                  => 1,
			'datetime_unit_bg_color'        => '',
			'datetime_unit_color'           => '',
			'datetime_unit_font_size'       => '',
			'datetime_value_color'          => '',
			'datetime_value_bg_color'       => '',
			'datetime_value_font_size'      => '',
			'countdown_timer_color'         => '',
			'countdown_timer_bg_color'      => '',
			'countdown_timer_padding'       => '',
			'countdown_timer_border_radius' => '',
			'size_on_archive_page'          => '75',
			'datetime_unit_position'        => 'bottom',
			'animation_style'               => 'default',
			'circle_smooth_animation'       => 1,
		), $atts ) );
		global $sale_countdown_timer_id;
		$sale_countdown_timer_id ++;
		$now              = current_time( 'timestamp' );
		$sale_from_date   = strtotime( $sale_from_date );
		$sale_to_date     = strtotime( $sale_to_date );
		$sale_from_time   = woo_ctr_time( $sale_from_time );
		$sale_to_time     = woo_ctr_time( $sale_to_time );
		$sale_text_before = $sale_text_after = '';
		$day              = $hour = $minute = $second = '';
		if ( $id ) {
			$index = array_search( $id, $this->settings->get_id() );
			if ( $index >= 0 ) {
				if ( ! $sale_from_date && ! $enable_single_product ) {
					$sale_from_date = strtotime( $this->settings->get_sale_from_date()[ $index ] );
				}
				if ( ! $sale_to_date && ! $enable_single_product ) {
					$sale_to_date = strtotime( $this->settings->get_sale_to_date()[ $index ] );
				}
				if ( ! $sale_from_time && ! $enable_single_product ) {
					$sale_from_time = woo_ctr_time( $this->settings->get_sale_from_time()[ $index ] );
				}
				if ( ! $sale_to_time && ! $enable_single_product ) {
					$sale_to_time = woo_ctr_time( $this->settings->get_sale_to_time()[ $index ] );
				}
				$active           = $this->settings->get_active()[ $index ];
				$message          = $this->settings->get_message()[ $index ];
				$upcoming_message = $this->settings->get_upcoming_message()[ $index ];
//				$time_type                  = 'fixed';
				$count_style                        = $this->settings->get_count_style()[ $index ];
				$upcoming                           = $this->settings->get_upcoming()[ $index ];
				$time_separator                     = $this->settings->get_time_separator()[ $index ];
				$display_type                       = $this->settings->get_display_type()[ $index ];
				$countdown_timer_color              = $this->settings->get_countdown_timer_color()[ $index ];
				$countdown_timer_bg_color           = $this->settings->get_countdown_timer_bg_color()[ $index ];
				$countdown_timer_padding            = $this->settings->get_countdown_timer_padding()[ $index ];
				$countdown_timer_border_radius      = $this->settings->get_countdown_timer_border_radius()[ $index ];
				$countdown_timer_border_color       = $this->settings->get_countdown_timer_border_color()[ $index ];
				$countdown_timer_item_border_color  = $this->settings->get_countdown_timer_item_border_color()[ $index ];
				$countdown_timer_item_border_radius = $this->settings->get_countdown_timer_item_border_radius()[ $index ];
				$countdown_timer_item_height        = $this->settings->get_countdown_timer_item_height()[ $index ];
				$countdown_timer_item_width         = $this->settings->get_countdown_timer_item_width()[ $index ];
				$datetime_unit_bg_color             = $this->settings->get_datetime_unit_bg_color()[ $index ];
				$datetime_unit_color                = $this->settings->get_datetime_unit_color()[ $index ];
				$datetime_unit_font_size            = $this->settings->get_datetime_unit_font_size()[ $index ];
				$datetime_value_bg_color            = $this->settings->get_datetime_value_bg_color()[ $index ];
				$datetime_value_color               = $this->settings->get_datetime_value_color()[ $index ];
				$datetime_value_font_size           = $this->settings->get_datetime_value_font_size()[ $index ];
				$size_on_archive_page               = ( isset( $this->settings->get_size_on_archive_page()[ $index ] ) && $this->settings->get_size_on_archive_page()[ $index ] ) ? $this->settings->get_size_on_archive_page()[ $index ] : 75;
				$datetime_unit_position             = isset( $this->settings->get_datetime_unit_position()[ $index ] ) ? $this->settings->get_datetime_unit_position()[ $index ] : 'bottom';
				$animation_style                    = isset( $this->settings->get_animation_style()[ $index ] ) ? $this->settings->get_animation_style()[ $index ] : 'default';
				$circle_smooth_animation            = isset( $this->settings->get_circle_smooth_animation()[ $index ] ) ? $this->settings->get_circle_smooth_animation()[ $index ] : 1;
			}
		}
//		/*pass settings arguments*/
		if ( ! $active ) {
			return false;
		}

		/*handle time type*/
		if ( $time_type == 'fixed' ) {
			$sale_from = $sale_from_date + $sale_from_time;
			$sale_to   = $sale_to_date + $sale_to_time;
		} else {
			$sale_from = strtotime( 'today' ) + woo_ctr_time( $sale_from_time );
			$sale_to   = strtotime( 'today' ) + woo_ctr_time( $sale_to_time );
			if ( $sale_from >= $sale_to ) {
				if ( $now > $sale_to ) {
					$sale_to += 86400;
				} else {
					$sale_from -= 86400;
				}
			}

		}

		if ( $sale_to < $sale_from ) {
			return false;
		}
		if ( $sale_from > $now ) {
			if ( $upcoming && $enable_single_product ) {
				$end_time = $sale_from - $now;
				$text     = $upcoming_message;
			} else {
				return false;
			}
		} else {
			if ( $sale_to < $now ) {
				return false;
			} else {
				$end_time = $sale_to - $now;
				$text     = $message;
			}
		}

		/*datetime format*/
		switch ( $count_style ) {
			case 1:
				$day    = esc_html__( 'days', 'sales-countdown-timer' );
				$hour   = esc_html__( 'hrs', 'sales-countdown-timer' );
				$minute = esc_html__( 'mins', 'sales-countdown-timer' );
				$second = esc_html__( 'secs', 'sales-countdown-timer' );
				break;
			case 2:
				$day    = esc_html__( 'days', 'sales-countdown-timer' );
				$hour   = esc_html__( 'hours', 'sales-countdown-timer' );
				$minute = esc_html__( 'minutes', 'sales-countdown-timer' );
				$second = esc_html__( 'seconds', 'sales-countdown-timer' );
				break;
			case 3:
				$day    = '';
				$hour   = '';
				$minute = '';
				$second = '';
				break;
			case 4:
				$day    = esc_html__( 'd', 'sales-countdown-timer' );
				$hour   = esc_html__( 'h', 'sales-countdown-timer' );
				$minute = esc_html__( 'm', 'sales-countdown-timer' );
				$second = esc_html__( 's', 'sales-countdown-timer' );
				break;
			default:
		}

		if ( ! wp_script_is( 'woo-sctr-shortcode-script', 'enqueued' ) ) {
			wp_enqueue_script( 'woo-sctr-shortcode-script' );
		}
		if ( ! wp_script_is( 'woo-sctr-shortcode-style', 'enqueued' ) ) {
			wp_enqueue_style( 'woo-sctr-shortcode-style' );

		}
		$shop_css = '';
		if ( is_tax( 'product_cat' ) || is_post_type_archive( 'product' ) ) {
			if ( $countdown_timer_padding ) {
				$countdown_timer_padding = $countdown_timer_padding * $size_on_archive_page / 100;
			}
			if ( $datetime_value_font_size ) {
				$datetime_value_font_size = $datetime_value_font_size * $size_on_archive_page / 100;
			}
			if ( $datetime_unit_font_size ) {
				$datetime_unit_font_size = $datetime_unit_font_size * $size_on_archive_page / 100;
			}
			if ( $countdown_timer_item_height ) {
				$countdown_timer_item_height = $countdown_timer_item_height * $size_on_archive_page / 100;
			}
			if ( $countdown_timer_item_width ) {
				$countdown_timer_item_width = $countdown_timer_item_width * $size_on_archive_page / 100;
			}
			$shop_css = '.woo-sctr-shortcode-wrap-wrap{width: 100%;justify-content: center;}';
		}
		$countdown_timer_padding_mobile     = $countdown_timer_padding ? $countdown_timer_padding * $size_on_archive_page / 100 : '';
		$datetime_value_font_size_mobile    = $datetime_value_font_size ? $datetime_value_font_size * $size_on_archive_page / 100 : '';
		$datetime_unit_font_size_mobile     = $datetime_unit_font_size ? $datetime_unit_font_size * $size_on_archive_page / 100 : '';
		$countdown_timer_item_height_mobile = $countdown_timer_item_height ? $countdown_timer_item_height * $size_on_archive_page / 100 : '';
		$countdown_timer_item_width_mobile  = $countdown_timer_item_width ? $countdown_timer_item_width * $size_on_archive_page / 100 : '';

		$end_time  = (int) $end_time - 1;
		$day_left  = floor( $end_time / 86400 );
		$hour_left = floor( ( $end_time - 86400 * (int) $day_left ) / 3600 );
		$min_left  = floor( ( $end_time - 86400 * (int) $day_left - 3600 * (int) $hour_left ) / 60 );
		$sec_left  = $end_time - 86400 * (int) $day_left - 3600 * (int) $hour_left - 60 * (int) $min_left;
		$day_deg   = $day_left;
		$hour_deg  = $hour_left * 15;
		$min_deg   = $min_left * 6;
		$sec_deg   = ( $sec_left + 1 ) * 6;

		if ( $is_variation ) {
			$day_left_t = $hour_left_t = $min_left_t = $sec_left_t = '00';
		} else {
			$day_left_t  = zeroise( $day_left, 2 );
			$hour_left_t = zeroise( $hour_left, 2 );
			$min_left_t  = zeroise( $min_left, 2 );
			$sec_left_t  = zeroise( $sec_left, 2 );
			if ( $animation_style == 'default' ) {
				$sec_left_t = zeroise( $sec_left == 59 ? 0 : $sec_left + 1, 2 );

			}
		}
		$css = '';
		if ( $display_type == 4 ) {
			/*set circle fill*/
			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-date.woo-sctr-shortcode-countdown-unit .woo-sctr-progress-circle .woo-sctr-value-bar{' . esc_attr__( 'transform: rotate(' ) . $day_deg . 'deg);}';
			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-hour.woo-sctr-shortcode-countdown-unit .woo-sctr-progress-circle .woo-sctr-value-bar{' . esc_attr__( 'transform: rotate(' ) . $hour_deg . 'deg);}';
			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-minute.woo-sctr-shortcode-countdown-unit .woo-sctr-progress-circle .woo-sctr-value-bar{' . esc_attr__( 'transform: rotate(' ) . $min_deg . 'deg);}';
			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-second.woo-sctr-shortcode-countdown-unit .woo-sctr-progress-circle .woo-sctr-value-bar{' . esc_attr__( 'transform: rotate(' ) . $sec_deg . 'deg);}';
			if ( $circle_smooth_animation == 1 ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-progress-circle .woo-sctr-value-bar{transition: transform 1s linear;}';
			}
			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1{';
			if ( $countdown_timer_color ) {
				$css .= esc_attr__( 'color:' ) . $countdown_timer_color . ';';
			}
			if ( $countdown_timer_bg_color ) {
				$css .= esc_attr__( 'background:' ) . $countdown_timer_bg_color . ';';
			}
			if ( $countdown_timer_padding ) {
				$css .= esc_attr__( 'padding:' ) . $countdown_timer_padding . 'px;';
			}
			if ( $countdown_timer_border_radius ) {
				$css .= esc_attr__( 'border-radius:' ) . $countdown_timer_border_radius . 'px;';
			}
			if ( $countdown_timer_bg_color ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . '.woo-sctr-sticky-top{' . esc_attr__( 'background:' ) . $countdown_timer_bg_color . ';}';
			}

			$css .= '}';
			if ( $countdown_timer_item_border_color ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-progress-circle .woo-sctr-value-bar{' . esc_attr__( 'border-color: ' ) . $countdown_timer_item_border_color . ';}';
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-progress-circle .woo-sctr-first50-bar{' . esc_attr__( 'background-color: ' ) . $countdown_timer_item_border_color . ';}';
			}
			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-value-container,.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-value{';
			if ( $datetime_value_color ) {
				$css .= esc_attr__( 'color:' ) . $datetime_value_color . ';';
			}
			$css .= '}';
			if ( $datetime_value_bg_color ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-progress-circle:after{' . esc_attr__( 'background:' ) . $datetime_value_bg_color . ';}';
			}
			if ( $datetime_value_font_size ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-progress-circle{';
				$css .= esc_attr__( 'font-size: ' ) . $datetime_value_font_size . 'px;';
				$css .= '}';
			}

			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-text{';
			if ( $datetime_unit_color ) {
				$css .= esc_attr__( 'color:' ) . $datetime_unit_color . ';';
			}
			if ( $datetime_unit_bg_color ) {
				$css .= esc_attr__( 'background:' ) . $datetime_unit_bg_color . ';';
			}
			if ( $datetime_unit_font_size ) {
				$css .= esc_attr__( 'font-size:' ) . $datetime_unit_font_size . 'px;';
			}

			$css .= '}';
			/*mobile*/
			$css .= '@media screen and (max-width:600px){';
			if ( $countdown_timer_padding_mobile !== '' ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1{padding:' . $countdown_timer_padding_mobile . 'px;}';
			}
			if ( $datetime_value_font_size_mobile !== '' ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-progress-circle{';
				$css .= esc_attr__( 'font-size: ' ) . $datetime_value_font_size_mobile . 'px;';
				$css .= '}';
			}
			if ( $datetime_unit_font_size_mobile !== '' ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-text{' . esc_attr__( 'font-size:' ) . $datetime_unit_font_size_mobile . 'px;}';
			}
			$css .= '}';
		} else {
			if ( $display_type == 1 || $display_type == 2 ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . '{display:block;text-align:center;}';
			}
			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1{';
			if ( $countdown_timer_color ) {
				$css .= esc_attr__( 'color:' ) . $countdown_timer_color . ';';
			}
			if ( $countdown_timer_bg_color ) {
				$css .= esc_attr__( 'background:' ) . $countdown_timer_bg_color . ';';
			}
			if ( $countdown_timer_padding ) {
				$css .= esc_attr__( 'padding:' ) . $countdown_timer_padding . 'px;';
			}
			if ( $countdown_timer_border_radius ) {
				$css .= esc_attr__( 'border-radius:' ) . $countdown_timer_border_radius . 'px;';
			}
			if ( $countdown_timer_border_color ) {
				$css .= esc_attr__( 'border: 1px solid ' ) . $countdown_timer_border_color . ';';
			}
			$css .= '}';
			if ( $countdown_timer_bg_color ) {
				$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . '.woo-sctr-sticky-top{' . esc_attr__( 'background:' ) . $countdown_timer_bg_color . ';}';
			}
			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-value,.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-value-container{';
			if ( $datetime_value_color ) {
				$css .= esc_attr__( 'color:' ) . $datetime_value_color . ';';
			}
			if ( $datetime_value_bg_color ) {
				$css .= esc_attr__( 'background:' ) . $datetime_value_bg_color . ';';
			}
			if ( $datetime_value_font_size ) {
				$css .= esc_attr__( 'font-size:' ) . $datetime_value_font_size . 'px;';
			}
			$css .= '}';

			$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-text{';
			if ( $datetime_unit_color ) {
				$css .= esc_attr__( 'color:' ) . $datetime_unit_color . ';';
			}
			if ( $datetime_unit_bg_color ) {
				$css .= esc_attr__( 'background:' ) . $datetime_unit_bg_color . ';';
			}
			if ( $datetime_unit_font_size ) {
				$css .= esc_attr__( 'font-size:' ) . $datetime_unit_font_size . 'px;';
			}
			$css  .= '}';
			$css1 = '';
			if ( $countdown_timer_item_height ) {
				$css1 .= esc_attr__( 'height:' ) . $countdown_timer_item_height . 'px;';
			}
			if ( $countdown_timer_item_width ) {
				$css1 .= esc_attr__( 'width:' ) . $countdown_timer_item_width . 'px;';
			}
			if ( $countdown_timer_item_border_radius ) {
				$css1 .= esc_attr__( 'border-radius:' ) . $countdown_timer_item_border_radius . 'px;';
			}
			if ( $countdown_timer_item_border_color ) {
				$css1 .= esc_attr__( 'border:1px solid ' ) . $countdown_timer_item_border_color . ';';
			}
			/*mobile*/
			$mobile_css = '@media screen and (max-width:600px){';
			if ( $countdown_timer_padding_mobile !== '' ) {
				$mobile_css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1{padding:' . $countdown_timer_padding_mobile . 'px;}';
			}
			if ( $datetime_value_font_size_mobile !== '' ) {
				$mobile_css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-value,.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-value-container{';
				$mobile_css .= esc_attr__( 'font-size: ' ) . $datetime_value_font_size_mobile . 'px;';
				$mobile_css .= '}';
			}
			if ( $datetime_unit_font_size_mobile !== '' ) {
				$mobile_css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-1 .woo-sctr-shortcode-countdown-text{' . esc_attr__( 'font-size:' ) . $datetime_unit_font_size_mobile . 'px;}';
			}

			if ( $css1 ) {
				if ( $display_type == 1 ) {
					$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-wrap.woo-sctr-shortcode-countdown-style-1 .woo-sctr-shortcode-countdown-unit{' . $css1 . '}';
					if ( $countdown_timer_item_height_mobile !== '' ) {
						$mobile_css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-wrap.woo-sctr-shortcode-countdown-style-1 .woo-sctr-shortcode-countdown-unit{' . esc_attr__( 'height:' ) . $countdown_timer_item_height_mobile . 'px;}';
					}
					if ( $countdown_timer_item_width_mobile !== '' ) {
						$mobile_css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-wrap.woo-sctr-shortcode-countdown-style-1 .woo-sctr-shortcode-countdown-unit{' . esc_attr__( 'width:' ) . $countdown_timer_item_width_mobile . 'px;}';
					}
				} elseif ( $display_type == 2 ) {
					if ( $animation_style == 'default' ) {
						$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-wrap.woo-sctr-shortcode-countdown-style-2 .woo-sctr-shortcode-countdown-value{' . $css1 . '}';
						if ( $countdown_timer_item_height_mobile !== '' ) {
							$mobile_css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-wrap.woo-sctr-shortcode-countdown-style-2 .woo-sctr-shortcode-countdown-value{' . esc_attr__( 'height:' ) . $countdown_timer_item_height_mobile . 'px;}';
						}
						if ( $countdown_timer_item_width_mobile !== '' ) {
							$mobile_css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-wrap.woo-sctr-shortcode-countdown-style-2 .woo-sctr-shortcode-countdown-value{' . esc_attr__( 'width:' ) . $countdown_timer_item_width_mobile . 'px;}';
						}
					} else {
						$css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-wrap.woo-sctr-shortcode-countdown-style-2 .woo-sctr-shortcode-countdown-value-container{' . $css1 . '}';
						if ( $countdown_timer_item_height_mobile !== '' ) {
							$mobile_css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-wrap.woo-sctr-shortcode-countdown-style-2 .woo-sctr-shortcode-countdown-value-container{' . esc_attr__( 'height:' ) . $countdown_timer_item_height_mobile . 'px;}';
						}
						if ( $countdown_timer_item_width_mobile !== '' ) {
							$mobile_css .= '.woo-sctr-shortcode-wrap-wrap.woo-sctr-shortcode-wrap-wrap-' . $sale_countdown_timer_id . ' .woo-sctr-shortcode-countdown-wrap.woo-sctr-shortcode-countdown-style-2 .woo-sctr-shortcode-countdown-value-container{' . esc_attr__( 'width:' ) . $countdown_timer_item_width_mobile . 'px;}';
						}
					}
				}
			}
			$mobile_css .= '}';

			$css .= $mobile_css;
		}
		$css .= $shop_css;
		wp_add_inline_style( 'woo-sctr-shortcode-style', $css );
		/*message*/
		$text = explode( '{countdown_timer}', $text );
		if ( count( $text ) >= 2 ) {
			$sale_text_before = $text[0];
			$sale_text_after  = $text[1];
		} else {
			return '';
		}
		$design_class = ' woo-sctr-shortcode-countdown-style-' . $display_type;
		switch ( $time_separator ) {
			case 'colon':
				$time_separator = ':';
				break;
			case 'comma':
				$time_separator = ',';
				break;
			case 'dot':
				$time_separator = '.';
				break;
			default:
				$time_separator = '';
		}

		ob_start();
		if ( $datetime_unit_position == 'bottom' ) {
			if ( $animation_style == 'default' ) {
				switch ( $display_type ) {
					case '1':
					case '2':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">

                            <div class="woo-sctr-shortcode-wrap">
                                <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                       value="<?php echo $end_time; ?>">
                                <div class="woo-sctr-shortcode-countdown-wrap <?php echo $design_class; ?>">
                                    <div class="woo-sctr-shortcode-countdown">
                                        <div class="woo-sctr-shortcode-countdown-1">
                                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                                            <div class="woo-sctr-shortcode-countdown-2">
                                        <span class="woo-sctr-shortcode-countdown-unit-wrap"
                                              style="<?php if ( ! $day_left ) {
	                                              echo 'display:none';
                                              } ?>">
                                            <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                                <span class="woo-sctr-shortcode-countdown-date-value woo-sctr-shortcode-countdown-value"><?php echo $day_left_t; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                            </span>
                                        </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                                      style="<?php if ( ! $day_left ) {
													      echo 'display:none';
												      } ?>"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                            <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                                <span class="woo-sctr-shortcode-countdown-hour-value woo-sctr-shortcode-countdown-value"><?php echo $hour_left_t; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                            </span>
                                        </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                            <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                                <span class="woo-sctr-shortcode-countdown-minute-value woo-sctr-shortcode-countdown-value"><?php echo $min_left_t; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                            </span>
                                        </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                            <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                                <span class="woo-sctr-shortcode-countdown-second-value woo-sctr-shortcode-countdown-value"><?php echo $sec_left_t; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                            </span>
                                        </span>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-text-bottom"><?php echo $sale_text_after; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						break;
					case '3':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-inline woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">
                            <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                   value="<?php echo $end_time; ?>">
                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                            <span class="woo-sctr-shortcode-countdown-1">
                <span class="woo-sctr-shortcode-countdown-unit-wrap" style="<?php if ( ! $day_left ) {
	                echo 'display:none';
                } ?>">
                                <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                    <span class="woo-sctr-shortcode-countdown-date-value woo-sctr-shortcode-countdown-value"><?php echo $day_left_t; ?></span>
                                    <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                </span>
                </span>
                <span class="woo-sctr-shortcode-countdown-time-separator" style="<?php if ( ! $day_left ) {
	                echo 'display:none';
                } ?>"><?php echo $time_separator; ?></span>
                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                    <span class="woo-sctr-shortcode-countdown-hour-value woo-sctr-shortcode-countdown-value"><?php echo $hour_left_t; ?></span>
                                    <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                </span>
                </span>
                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                    <span class="woo-sctr-shortcode-countdown-minute-value woo-sctr-shortcode-countdown-value"><?php echo $min_left_t; ?></span>
                                    <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                </span>
                                </span>
                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                    <span class="woo-sctr-shortcode-countdown-second-value woo-sctr-shortcode-countdown-value"><?php echo $sec_left_t; ?></span>
                                    <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                </span>

                                    </span>
                                    </span>
                            <span class="woo-sctr-shortcode-countdown-text-after"><?php echo $sale_text_after; ?></span>
                        </div>

						<?php
						break;
					case '4':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-circle woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">

                            <div class="woo-sctr-shortcode-wrap">
                                <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                       value="<?php echo $end_time; ?>">
                                <div class="woo-sctr-shortcode-countdown-wrap <?php echo $design_class; ?>">
                                    <div class="woo-sctr-shortcode-countdown">
                                        <div class="woo-sctr-shortcode-countdown-1">
                                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                                            <div class="woo-sctr-shortcode-countdown-2">
                                    <span class="woo-sctr-shortcode-countdown-unit-wrap"
                                          style="<?php if ( ! $day_left ) {
	                                          echo 'display:none';
                                          } ?>">
                                        <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                            <div class="woo-sctr-progress-circle<?php echo $day_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                <span class="woo-sctr-shortcode-countdown-date-value woo-sctr-shortcode-countdown-value"><?php echo $day_left_t; ?></span>
                                                <div class="woo-sctr-left-half-clipper">
                                                    <div class="woo-sctr-first50-bar"<?php echo $day_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                    <div class="woo-sctr-value-bar"></div>
                                                </div>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                        </span>
                                    </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                                      style="<?php if ( ! $day_left ) {
													      echo 'display:none';
												      } ?>"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                            <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                                <div class="woo-sctr-progress-circle<?php echo $hour_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                    <span class="woo-sctr-shortcode-countdown-hour-value woo-sctr-shortcode-countdown-value"><?php echo $hour_left_t; ?></span>

                                                    <div class="woo-sctr-left-half-clipper">
                                                        <div class="woo-sctr-first50-bar"<?php echo $hour_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                        <div class="woo-sctr-value-bar"></div>
                                                    </div>
                                                </div>
                                                <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                            </span>
                                    </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                        <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                            <div class="woo-sctr-progress-circle<?php echo $min_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                <span class="woo-sctr-shortcode-countdown-minute-value woo-sctr-shortcode-countdown-value"><?php echo $min_left_t; ?></span>

                                                <div class="woo-sctr-left-half-clipper">
                                                    <div class="woo-sctr-first50-bar"<?php echo $min_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                    <div class="woo-sctr-value-bar"></div>
                                                </div>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                        </span>
                                    </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                        <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                            <div class="woo-sctr-progress-circle<?php echo $sec_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                <span class="woo-sctr-shortcode-countdown-second-value woo-sctr-shortcode-countdown-value"><?php echo $sec_left_t; ?></span>
                                                <div class="woo-sctr-left-half-clipper">
                                                    <div class="woo-sctr-first50-bar"<?php echo $sec_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                    <div class="woo-sctr-value-bar"></div>
                                                </div>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                        </span>
                                    </span>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-text-bottom"><?php echo $sale_text_after; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						break;
					default:
				}
			} else {
				switch ( $display_type ) {
					case '1':
					case '2':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">

                            <div class="woo-sctr-shortcode-wrap">
                                <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                       value="<?php echo $end_time; ?>">
                                <div class="woo-sctr-shortcode-countdown-wrap <?php echo $design_class; ?>">
                                    <div class="woo-sctr-shortcode-countdown">
                                        <div class="woo-sctr-shortcode-countdown-1">
                                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                                            <div class="woo-sctr-shortcode-countdown-2">
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap"
                                                      style="<?php if ( ! $day_left ) {
	                                                      echo 'display:none';
                                                      } ?>">
                                                    <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-date-value-container woo-sctr-shortcode-countdown-value-container">
                                                            <span class="woo-sctr-shortcode-countdown-date-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                <span class="woo-sctr-shortcode-countdown-date-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                    <span class="woo-sctr-shortcode-countdown-date-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $day_left > 0 ? zeroise( $day_left - 1, 2 ) : '00'; ?></span>
                                                                    <span class="woo-sctr-shortcode-countdown-date-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $day_left_t; ?></span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                        <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                                    </span>
                                                </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                                      style="<?php if ( ! $day_left ) {
													      echo 'display:none';
												      } ?>"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-hour-value-container woo-sctr-shortcode-countdown-value-container">
                                                            <span class="woo-sctr-shortcode-countdown-hour-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                <span class="woo-sctr-shortcode-countdown-hour-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                    <span class="woo-sctr-shortcode-countdown-hour-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $hour_left > 0 ? zeroise( $hour_left - 1, 2 ) : '23'; ?></span>
                                                                    <span class="woo-sctr-shortcode-countdown-hour-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $hour_left_t; ?></span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                        <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                                    </span>
                                                </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-minute-value-container woo-sctr-shortcode-countdown-value-container">
                                                            <span class="woo-sctr-shortcode-countdown-minute-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                <span class="woo-sctr-shortcode-countdown-minute-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                    <span class="woo-sctr-shortcode-countdown-minute-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $min_left > 0 ? zeroise( $min_left - 1, 2 ) : '59'; ?></span>
                                                                    <span class="woo-sctr-shortcode-countdown-minute-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $min_left_t; ?></span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                        <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                                    </span>
                                                </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-second-value-container woo-sctr-shortcode-countdown-value-container">
                                                            <span class="woo-sctr-shortcode-countdown-second-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                <span class="woo-sctr-shortcode-countdown-second-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                    <span class="woo-sctr-shortcode-countdown-second-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $sec_left_t; ?></span>
                                                                    <span class="woo-sctr-shortcode-countdown-second-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $sec_left < 60 ? zeroise( $sec_left + 1, 2 ) : '00'; ?></span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                        <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                                    </span>
                                                </span>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-text-bottom"><?php echo $sale_text_after; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						break;
					case '3':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-inline woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">
                            <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                   value="<?php echo $end_time; ?>">
                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                            <span class="woo-sctr-shortcode-countdown-1">
                                <span class="woo-sctr-shortcode-countdown-unit-wrap" style="<?php if ( ! $day_left ) {
	                                echo 'display:none';
                                } ?>">
                                    <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                        <span class="woo-sctr-shortcode-countdown-date-value-container woo-sctr-shortcode-countdown-value-container">
                                            <span class="woo-sctr-shortcode-countdown-date-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                <span class="woo-sctr-shortcode-countdown-date-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                    <span class="woo-sctr-shortcode-countdown-date-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $day_left > 0 ? zeroise( $day_left - 1, 2 ) : '00'; ?></span>
                                                    <span class="woo-sctr-shortcode-countdown-date-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $day_left_t; ?></span>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                    </span>
                                </span>
                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                      style="<?php if ( ! $day_left ) {
	                                      echo 'display:none';
                                      } ?>"><?php echo $time_separator; ?></span>
                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                    <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                        <span class="woo-sctr-shortcode-countdown-hour-value-container woo-sctr-shortcode-countdown-value-container">
                                            <span class="woo-sctr-shortcode-countdown-hour-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                <span class="woo-sctr-shortcode-countdown-hour-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                    <span class="woo-sctr-shortcode-countdown-hour-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $hour_left > 0 ? zeroise( $hour_left - 1, 2 ) : '23'; ?></span>
                                                    <span class="woo-sctr-shortcode-countdown-hour-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $hour_left_t; ?></span>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                    </span>
                                </span>
                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                    <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                        <span class="woo-sctr-shortcode-countdown-minute-value-container woo-sctr-shortcode-countdown-value-container">
                                            <span class="woo-sctr-shortcode-countdown-minute-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                <span class="woo-sctr-shortcode-countdown-minute-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                    <span class="woo-sctr-shortcode-countdown-minute-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $min_left > 0 ? zeroise( $min_left - 1, 2 ) : '59'; ?></span>
                                                    <span class="woo-sctr-shortcode-countdown-minute-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $min_left_t; ?></span>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                    </span>
                                </span>
                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                    <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                        <span class="woo-sctr-shortcode-countdown-second-value-container woo-sctr-shortcode-countdown-value-container">
                                            <span class="woo-sctr-shortcode-countdown-second-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                <span class="woo-sctr-shortcode-countdown-second-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                    <span class="woo-sctr-shortcode-countdown-second-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $sec_left_t; ?></span>
                                                    <span class="woo-sctr-shortcode-countdown-second-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $sec_left < 60 ? zeroise( $sec_left + 1, 2 ) : '00'; ?></span>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                    </span>
                                </span>
                            </span>
                            <span class="woo-sctr-shortcode-countdown-text-after"><?php echo $sale_text_after; ?></span>
                        </div>

						<?php
						break;
					case '4':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-circle woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">

                            <div class="woo-sctr-shortcode-wrap">
                                <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                       value="<?php echo $end_time; ?>">
                                <div class="woo-sctr-shortcode-countdown-wrap <?php echo $design_class; ?>">
                                    <div class="woo-sctr-shortcode-countdown">
                                        <div class="woo-sctr-shortcode-countdown-1">
                                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                                            <div class="woo-sctr-shortcode-countdown-2">
                                                <div class="woo-sctr-shortcode-countdown-unit-wrap"
                                                     style="<?php if ( ! $day_left ) {
													     echo 'display:none';
												     } ?>">
                                                    <div class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                                        <div class="woo-sctr-progress-circle<?php echo $day_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                            <div class="woo-sctr-shortcode-countdown-date-value-container woo-sctr-shortcode-countdown-value-container">
                                                                <div class="woo-sctr-shortcode-countdown-date-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                    <div class="woo-sctr-shortcode-countdown-date-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                        <span class="woo-sctr-shortcode-countdown-date-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $day_left > 0 ? zeroise( $day_left - 1, 2 ) : '00'; ?></span>
                                                                        <span class="woo-sctr-shortcode-countdown-date-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $day_left_t; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="woo-sctr-left-half-clipper">
                                                                <div class="woo-sctr-first50-bar"<?php echo $day_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                                <div class="woo-sctr-value-bar"></div>
                                                            </div>
                                                        </div>
                                                        <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                                    </div>
                                                </div>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                                      style="<?php if ( ! $day_left ) {
													      echo 'display:none';
												      } ?>"><?php echo $time_separator; ?></span>
                                                <div class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <div class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                                        <div class="woo-sctr-progress-circle<?php echo $hour_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                            <div class="woo-sctr-shortcode-countdown-hour-value-container woo-sctr-shortcode-countdown-value-container">
                                                                <div class="woo-sctr-shortcode-countdown-hour-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                    <div class="woo-sctr-shortcode-countdown-hour-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                        <span class="woo-sctr-shortcode-countdown-hour-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $hour_left > 0 ? zeroise( $hour_left - 1, 2 ) : '23'; ?></span>
                                                                        <span class="woo-sctr-shortcode-countdown-hour-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $hour_left_t; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="woo-sctr-left-half-clipper">
                                                                <div class="woo-sctr-first50-bar"<?php echo $hour_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                                <div class="woo-sctr-value-bar"></div>
                                                            </div>
                                                        </div>
                                                        <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                                    </div>
                                                </div>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <div class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <div class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                                        <div class="woo-sctr-progress-circle<?php echo $min_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                            <div class="woo-sctr-shortcode-countdown-minute-value-container woo-sctr-shortcode-countdown-value-container">
                                                                <div class="woo-sctr-shortcode-countdown-minute-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                    <div class="woo-sctr-shortcode-countdown-minute-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                        <span class="woo-sctr-shortcode-countdown-minute-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $min_left > 0 ? zeroise( $min_left - 1, 2 ) : '59'; ?></span>
                                                                        <span class="woo-sctr-shortcode-countdown-minute-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $min_left_t; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="woo-sctr-left-half-clipper">
                                                                <div class="woo-sctr-first50-bar"<?php echo $min_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                                <div class="woo-sctr-value-bar"></div>
                                                            </div>
                                                        </div>
                                                        <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                                    </div>
                                                </div>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <div class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <div class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                                        <div class="woo-sctr-progress-circle<?php echo $sec_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                            <div class="woo-sctr-shortcode-countdown-second-value-container woo-sctr-shortcode-countdown-value-container">
                                                                <div class="woo-sctr-shortcode-countdown-second-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                    <div class="woo-sctr-shortcode-countdown-second-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                        <span class="woo-sctr-shortcode-countdown-second-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $sec_left_t; ?></span>
                                                                        <span class="woo-sctr-shortcode-countdown-second-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $sec_left < 60 ? zeroise( $sec_left + 1, 2 ) : '00'; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="woo-sctr-left-half-clipper">
                                                                <div class="woo-sctr-first50-bar"<?php echo $sec_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                                <div class="woo-sctr-value-bar"></div>
                                                            </div>
                                                        </div>
                                                        <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-text-bottom"><?php echo $sale_text_after; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						break;
					default:
				}
			}
		} else {
			if ( $animation_style == 'default' ) {
				switch ( $display_type ) {
					case '1':
					case '2':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">
                            <div class="woo-sctr-shortcode-wrap">
                                <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                       value="<?php echo $end_time; ?>">
                                <div class="woo-sctr-shortcode-countdown-wrap <?php echo $design_class; ?>">
                                    <div class="woo-sctr-shortcode-countdown">
                                        <div class="woo-sctr-shortcode-countdown-1">
                                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                                            <div class="woo-sctr-shortcode-countdown-2">
                                        <span class="woo-sctr-shortcode-countdown-unit-wrap"
                                              style="<?php if ( ! $day_left ) {
	                                              echo 'display:none';
                                              } ?>">
                                            <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                                <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-date-value woo-sctr-shortcode-countdown-value"><?php echo $day_left_t; ?></span>
                                            </span>
                                        </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                                      style="<?php if ( ! $day_left ) {
													      echo 'display:none';
												      } ?>"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                            <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                                <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-hour-value woo-sctr-shortcode-countdown-value"><?php echo $hour_left_t; ?></span>
                                            </span>
                                        </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                            <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                                <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-minute-value woo-sctr-shortcode-countdown-value"><?php echo $min_left_t; ?></span>
                                            </span>
                                        </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                            <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                                <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-second-value woo-sctr-shortcode-countdown-value"><?php echo $sec_left_t; ?></span>
                                            </span>
                                        </span>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-text-bottom"><?php echo $sale_text_after; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						break;
					case '3':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-inline woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">
                            <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                   value="<?php echo $end_time; ?>">
                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                            <span class="woo-sctr-shortcode-countdown-1">
                <span class="woo-sctr-shortcode-countdown-unit-wrap" style="<?php if ( ! $day_left ) {
	                echo 'display:none';
                } ?>">
                                <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                    <span class="woo-sctr-shortcode-countdown-date-value woo-sctr-shortcode-countdown-value"><?php echo $day_left_t; ?></span>
                                    <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                </span>
                </span>
                <span class="woo-sctr-shortcode-countdown-time-separator" style="<?php if ( ! $day_left ) {
	                echo 'display:none';
                } ?>"><?php echo $time_separator; ?></span>
                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                    <span class="woo-sctr-shortcode-countdown-hour-value woo-sctr-shortcode-countdown-value"><?php echo $hour_left_t; ?></span>
                                    <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                </span>
                </span>
                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                    <span class="woo-sctr-shortcode-countdown-minute-value woo-sctr-shortcode-countdown-value"><?php echo $min_left_t; ?></span>
                                    <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                </span>
                                </span>
                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                    <span class="woo-sctr-shortcode-countdown-second-value woo-sctr-shortcode-countdown-value"><?php echo $sec_left_t; ?></span>
                                    <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                </span>

                                    </span>
                                    </span>
                            <span class="woo-sctr-shortcode-countdown-text-after"><?php echo $sale_text_after; ?></span>
                        </div>

						<?php
						break;
					case '4':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-circle woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">

                            <div class="woo-sctr-shortcode-wrap">
                                <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                       value="<?php echo $end_time; ?>">
                                <div class="woo-sctr-shortcode-countdown-wrap <?php echo $design_class; ?>">
                                    <div class="woo-sctr-shortcode-countdown">
                                        <div class="woo-sctr-shortcode-countdown-1">
                                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                                            <div class="woo-sctr-shortcode-countdown-2">
                                    <span class="woo-sctr-shortcode-countdown-unit-wrap"
                                          style="<?php if ( ! $day_left ) {
	                                          echo 'display:none';
                                          } ?>">
                                        <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                            <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                            <div class="woo-sctr-progress-circle<?php echo $day_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                <span class="woo-sctr-shortcode-countdown-date-value woo-sctr-shortcode-countdown-value"><?php echo $day_left_t; ?></span>
                                                <div class="woo-sctr-left-half-clipper">
                                                    <div class="woo-sctr-first50-bar"<?php echo $day_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                    <div class="woo-sctr-value-bar"></div>
                                                </div>
                                            </div>
                                        </span>
                                    </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                                      style="<?php if ( ! $day_left ) {
													      echo 'display:none';
												      } ?>"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                            <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                                <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                                <div class="woo-sctr-progress-circle<?php echo $hour_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                    <span class="woo-sctr-shortcode-countdown-hour-value woo-sctr-shortcode-countdown-value"><?php echo $hour_left_t; ?></span>

                                                    <div class="woo-sctr-left-half-clipper">
                                                        <div class="woo-sctr-first50-bar"<?php echo $hour_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                        <div class="woo-sctr-value-bar"></div>
                                                    </div>
                                                </div>
                                            </span>
                                    </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                        <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                            <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                            <div class="woo-sctr-progress-circle<?php echo $min_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                <span class="woo-sctr-shortcode-countdown-minute-value woo-sctr-shortcode-countdown-value"><?php echo $min_left_t; ?></span>

                                                <div class="woo-sctr-left-half-clipper">
                                                    <div class="woo-sctr-first50-bar"<?php echo $min_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                    <div class="woo-sctr-value-bar"></div>
                                                </div>
                                            </div>
                                        </span>
                                    </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                        <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                            <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                            <div class="woo-sctr-progress-circle<?php echo $sec_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                <span class="woo-sctr-shortcode-countdown-second-value woo-sctr-shortcode-countdown-value"><?php echo $sec_left_t; ?></span>
                                                <div class="woo-sctr-left-half-clipper">
                                                    <div class="woo-sctr-first50-bar"<?php echo $sec_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                    <div class="woo-sctr-value-bar"></div>
                                                </div>
                                            </div>
                                        </span>
                                    </span>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-text-bottom"><?php echo $sale_text_after; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						break;
					default:
				}
			} else {
				switch ( $display_type ) {
					case '1':
					case '2':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">

                            <div class="woo-sctr-shortcode-wrap">
                                <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                       value="<?php echo $end_time; ?>">
                                <div class="woo-sctr-shortcode-countdown-wrap <?php echo $design_class; ?>">
                                    <div class="woo-sctr-shortcode-countdown">
                                        <div class="woo-sctr-shortcode-countdown-1">
                                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                                            <div class="woo-sctr-shortcode-countdown-2">
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap"
                                                      style="<?php if ( ! $day_left ) {
	                                                      echo 'display:none';
                                                      } ?>">
                                                    <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                                        <span class="woo-sctr-shortcode-countdown-date-value-container woo-sctr-shortcode-countdown-value-container">
                                                            <span class="woo-sctr-shortcode-countdown-date-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                <span class="woo-sctr-shortcode-countdown-date-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                    <span class="woo-sctr-shortcode-countdown-date-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $day_left > 0 ? zeroise( $day_left - 1, 2 ) : '00'; ?></span>
                                                                    <span class="woo-sctr-shortcode-countdown-date-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $day_left_t; ?></span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                                      style="<?php if ( ! $day_left ) {
													      echo 'display:none';
												      } ?>"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                                        <span class="woo-sctr-shortcode-countdown-hour-value-container woo-sctr-shortcode-countdown-value-container">
                                                            <span class="woo-sctr-shortcode-countdown-hour-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                <span class="woo-sctr-shortcode-countdown-hour-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                    <span class="woo-sctr-shortcode-countdown-hour-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $hour_left > 0 ? zeroise( $hour_left - 1, 2 ) : '23'; ?></span>
                                                                    <span class="woo-sctr-shortcode-countdown-hour-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $hour_left_t; ?></span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                                        <span class="woo-sctr-shortcode-countdown-minute-value-container woo-sctr-shortcode-countdown-value-container">
                                                            <span class="woo-sctr-shortcode-countdown-minute-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                <span class="woo-sctr-shortcode-countdown-minute-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                    <span class="woo-sctr-shortcode-countdown-minute-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $min_left > 0 ? zeroise( $min_left - 1, 2 ) : '59'; ?></span>
                                                                    <span class="woo-sctr-shortcode-countdown-minute-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $min_left_t; ?></span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                                        <span class="woo-sctr-shortcode-countdown-second-value-container woo-sctr-shortcode-countdown-value-container">
                                                            <span class="woo-sctr-shortcode-countdown-second-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                <span class="woo-sctr-shortcode-countdown-second-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                    <span class="woo-sctr-shortcode-countdown-second-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $sec_left_t; ?></span>
                                                                    <span class="woo-sctr-shortcode-countdown-second-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $sec_left < 60 ? zeroise( $sec_left + 1, 2 ) : '00'; ?></span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-text-bottom"><?php echo $sale_text_after; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						break;
					case '3':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-inline woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">
                            <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                   value="<?php echo $end_time; ?>">
                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                            <span class="woo-sctr-shortcode-countdown-1">
                                <span class="woo-sctr-shortcode-countdown-unit-wrap" style="<?php if ( ! $day_left ) {
	                                echo 'display:none';
                                } ?>">
                                    <span class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                        <span class="woo-sctr-shortcode-countdown-date-value-container woo-sctr-shortcode-countdown-value-container">
                                            <span class="woo-sctr-shortcode-countdown-date-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                <span class="woo-sctr-shortcode-countdown-date-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                    <span class="woo-sctr-shortcode-countdown-date-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $day_left > 0 ? zeroise( $day_left - 1, 2 ) : '00'; ?></span>
                                                    <span class="woo-sctr-shortcode-countdown-date-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $day_left_t; ?></span>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                    </span>
                                </span>
                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                      style="<?php if ( ! $day_left ) {
	                                      echo 'display:none';
                                      } ?>"><?php echo $time_separator; ?></span>
                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                    <span class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                        <span class="woo-sctr-shortcode-countdown-hour-value-container woo-sctr-shortcode-countdown-value-container">
                                            <span class="woo-sctr-shortcode-countdown-hour-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                <span class="woo-sctr-shortcode-countdown-hour-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                    <span class="woo-sctr-shortcode-countdown-hour-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $hour_left > 0 ? zeroise( $hour_left - 1, 2 ) : '23'; ?></span>
                                                    <span class="woo-sctr-shortcode-countdown-hour-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $hour_left_t; ?></span>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                    </span>
                                </span>
                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                    <span class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                        <span class="woo-sctr-shortcode-countdown-minute-value-container woo-sctr-shortcode-countdown-value-container">
                                            <span class="woo-sctr-shortcode-countdown-minute-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                <span class="woo-sctr-shortcode-countdown-minute-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                    <span class="woo-sctr-shortcode-countdown-minute-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $min_left > 0 ? zeroise( $min_left - 1, 2 ) : '59'; ?></span>
                                                    <span class="woo-sctr-shortcode-countdown-minute-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $min_left_t; ?></span>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                    </span>
                                </span>
                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                <span class="woo-sctr-shortcode-countdown-unit-wrap">
                                    <span class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                        <span class="woo-sctr-shortcode-countdown-second-value-container woo-sctr-shortcode-countdown-value-container">
                                            <span class="woo-sctr-shortcode-countdown-second-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                <span class="woo-sctr-shortcode-countdown-second-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                    <span class="woo-sctr-shortcode-countdown-second-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $sec_left_t; ?></span>
                                                    <span class="woo-sctr-shortcode-countdown-second-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $sec_left < 60 ? zeroise( $sec_left + 1, 2 ) : '00'; ?></span>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                    </span>
                                </span>
                            </span>
                            <span class="woo-sctr-shortcode-countdown-text-after"><?php echo $sale_text_after; ?></span>
                        </div>

						<?php
						break;
					case '4':
						?>
                        <div class="woo-sctr-shortcode-wrap-wrap woo-sctr-shortcode-wrap-wrap-circle woo-sctr-shortcode-wrap-wrap-<?php echo $sale_countdown_timer_id ?>">

                            <div class="woo-sctr-shortcode-wrap">
                                <input type="hidden" class="woo-sctr-shortcode-data-end_time"
                                       value="<?php echo $end_time; ?>">
                                <div class="woo-sctr-shortcode-countdown-wrap <?php echo $design_class; ?>">
                                    <div class="woo-sctr-shortcode-countdown">
                                        <div class="woo-sctr-shortcode-countdown-1">
                                            <span class="woo-sctr-shortcode-countdown-text-before"><?php echo $sale_text_before; ?></span>
                                            <div class="woo-sctr-shortcode-countdown-2">
                                                <div class="woo-sctr-shortcode-countdown-unit-wrap"
                                                     style="<?php if ( ! $day_left ) {
													     echo 'display:none';
												     } ?>">
                                                    <div class="woo-sctr-shortcode-countdown-date woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-date-text woo-sctr-shortcode-countdown-text"><?php echo $day; ?></span>
                                                        <div class="woo-sctr-progress-circle<?php echo $day_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                            <div class="woo-sctr-shortcode-countdown-date-value-container woo-sctr-shortcode-countdown-value-container">
                                                                <div class="woo-sctr-shortcode-countdown-date-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                    <div class="woo-sctr-shortcode-countdown-date-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                        <span class="woo-sctr-shortcode-countdown-date-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $day_left > 0 ? zeroise( $day_left - 1, 2 ) : '00'; ?></span>
                                                                        <span class="woo-sctr-shortcode-countdown-date-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $day_left_t; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="woo-sctr-left-half-clipper">
                                                                <div class="woo-sctr-first50-bar"<?php echo $day_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                                <div class="woo-sctr-value-bar"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"
                                                      style="<?php if ( ! $day_left ) {
													      echo 'display:none';
												      } ?>"><?php echo $time_separator; ?></span>
                                                <div class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <div class="woo-sctr-shortcode-countdown-hour woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-hour-text woo-sctr-shortcode-countdown-text"><?php echo $hour; ?></span>
                                                        <div class="woo-sctr-progress-circle<?php echo $hour_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                            <div class="woo-sctr-shortcode-countdown-hour-value-container woo-sctr-shortcode-countdown-value-container">
                                                                <div class="woo-sctr-shortcode-countdown-hour-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                    <div class="woo-sctr-shortcode-countdown-hour-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                        <span class="woo-sctr-shortcode-countdown-hour-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $hour_left > 0 ? zeroise( $hour_left - 1, 2 ) : '23'; ?></span>
                                                                        <span class="woo-sctr-shortcode-countdown-hour-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $hour_left_t; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="woo-sctr-left-half-clipper">
                                                                <div class="woo-sctr-first50-bar"<?php echo $hour_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                                <div class="woo-sctr-value-bar"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <div class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <div class="woo-sctr-shortcode-countdown-minute woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-minute-text woo-sctr-shortcode-countdown-text"><?php echo $minute; ?></span>
                                                        <div class="woo-sctr-progress-circle<?php echo $min_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                            <div class="woo-sctr-shortcode-countdown-minute-value-container woo-sctr-shortcode-countdown-value-container">
                                                                <div class="woo-sctr-shortcode-countdown-minute-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                    <div class="woo-sctr-shortcode-countdown-minute-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                        <span class="woo-sctr-shortcode-countdown-minute-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $min_left > 0 ? zeroise( $min_left - 1, 2 ) : '59'; ?></span>
                                                                        <span class="woo-sctr-shortcode-countdown-minute-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $min_left_t; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="woo-sctr-left-half-clipper">
                                                                <div class="woo-sctr-first50-bar"<?php echo $min_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                                <div class="woo-sctr-value-bar"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="woo-sctr-shortcode-countdown-time-separator"><?php echo $time_separator; ?></span>
                                                <div class="woo-sctr-shortcode-countdown-unit-wrap">
                                                    <div class="woo-sctr-shortcode-countdown-second woo-sctr-shortcode-countdown-unit">
                                                        <span class="woo-sctr-shortcode-countdown-second-text woo-sctr-shortcode-countdown-text"><?php echo $second; ?></span>
                                                        <div class="woo-sctr-progress-circle<?php echo $sec_deg <= 180 ? '' : ' woo-sctr-over50' ?>">
                                                            <div class="woo-sctr-shortcode-countdown-second-value-container woo-sctr-shortcode-countdown-value-container">
                                                                <div class="woo-sctr-shortcode-countdown-second-value-container-1 woo-sctr-shortcode-countdown-value-container-1">
                                                                    <div class="woo-sctr-shortcode-countdown-second-value-container-2 woo-sctr-shortcode-countdown-value-container-2">
                                                                        <span class="woo-sctr-shortcode-countdown-second-value-1 woo-sctr-shortcode-countdown-value1"><?php echo $sec_left_t; ?></span>
                                                                        <span class="woo-sctr-shortcode-countdown-second-value-2 woo-sctr-shortcode-countdown-value2"><?php echo $sec_left < 60 ? zeroise( $sec_left + 1, 2 ) : '00'; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="woo-sctr-left-half-clipper">
                                                                <div class="woo-sctr-first50-bar"<?php echo $sec_deg <= 180 ? 'style="display:none"' : '' ?>></div>
                                                                <div class="woo-sctr-value-bar"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="woo-sctr-shortcode-countdown-text-bottom"><?php echo $sale_text_after; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						break;
					default:
				}
			}
		}


		$return = ob_get_clean();
		$return = str_replace( "\n", '', $return );
		$return = str_replace( "\r", '', $return );
		$return = str_replace( "\t", '', $return );
		$return = str_replace( "\l", '', $return );
		$return = str_replace( "\0", '', $return );

		return $return;
	}
}