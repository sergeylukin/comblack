<?php
/**
 * Textblock
 *
 * Shortcode which creates a text element wrapped in a div
 */
if( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if( ! class_exists( 'avia_sc_text' ) )
{
	class avia_sc_text extends aviaShortcodeTemplate
	{
		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['version']		= '1.0';
			$this->config['self_closing']	= 'no';
			$this->config['base_element']	= 'yes';

			$this->config['name']			= __( 'Text Block', 'avia_framework' );
			$this->config['tab']			= __( 'Content Elements', 'avia_framework' );
			$this->config['icon']			= AviaBuilder::$path['imagesURL'] . 'sc-text_block.png';
			$this->config['order']			= 100;
			$this->config['target']			= 'avia-target-insert';
			$this->config['shortcode'] 		= 'av_textblock';
			$this->config['tinyMCE'] 	    = array('disable' => true);
			$this->config['tooltip'] 	    = __( 'Creates a simple text block', 'avia_framework' );
			$this->config['preview'] 		= 'large';
			$this->config['id_name']		= 'id';
			$this->config['id_show']		= 'yes';
		}

		/**
		 * Popup Elements
		 *
		 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
		 * opens a modal window that allows to edit the element properties
		 *
		 * @return void
		 */
		function popup_elements()
		{

			$this->elements = array(

				array(
						'type' 	=> 'tab_container',
						'nodescription' => true
					),

				array(
						'type' 	=> 'tab',
						'name'  => __( 'Content', 'avia_framework' ),
						'nodescription' => true
					),

					array(
							'name'		=> __( 'Content','avia_framework' ),
							'desc'		=> __( 'Enter some content for this textblock', 'avia_framework' ),
							'id'		=> 'content',
							'type'		=> 'tiny_mce',
							'std'		=> __( 'Click here to add your own text', 'avia_framework' ),
							'lockable'	=> true,
							'tmpl_set_default'	=> false
						),

				array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

				array(
						'type' 	=> 'tab',
						'name'  => __( 'Styling', 'avia_framework' ),
						'nodescription' => true
					),

					array(
							'type'			=> 'template',
							'template_id'	=> 'toggle_container',
							'templates_include'	=> array(
													$this->popup_key( 'styling_font_sizes' ),
													$this->popup_key( 'styling_font_colors' ),
												),
							'nodescription' => true
						),


				array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

				array(
						'type' 	=> 'tab',
						'name'  => __( 'Advanced', 'avia_framework' ),
						'nodescription' => true
					),

					array(
							'type' 	=> 'toggle_container',
							'nodescription' => true
						),

						array(
								'type'			=> 'template',
								'template_id'	=> 'screen_options_toggle',
								'lockable'		=> true
							),

						array(
								'type'			=> 'template',
								'template_id'	=> 'developer_options_toggle',
								'args'			=> array( 'sc' => $this )
							),

					array(
							'type' 	=> 'toggle_container_close',
							'nodescription' => true
						),

				array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

				array(
						'type'			=> 'template',
						'template_id'	=> 'element_template_selection_tab',
						'args'			=> array( 'sc' => $this )
					),

				array(
						'type' 	=> 'tab_container_close',
						'nodescription' => true
					),


				);

		}

		/**
		 * Create and register templates for easier maintainance
		 *
		 * @since 4.6.4
		 */
		protected function register_dynamic_templates()
		{
			/**
			 * Styling Tab
			 * ===========
			 */

			$c = array(
						array(
							'type'			=> 'template',
							'template_id'	=> 'font_sizes_icon_switcher',
							'lockable'		=> true,
							'subtype'		=> array(
												'default'	=> AviaHtmlHelper::number_array( 8, 40, 1, array( __( 'Use Default', 'avia_framework' ) => '' ), 'px' ),
												'medium'	=> AviaHtmlHelper::number_array( 8, 40, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' ),
												'small'		=> AviaHtmlHelper::number_array( 8, 40, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' ),
												'mini'		=> AviaHtmlHelper::number_array( 8, 40, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' )
											)
						)

					);

			$template = array(
							array(
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Font Size', 'avia_framework' ),
								'content'		=> $c
							),
					);

			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_font_sizes' ), $template );


			$c = array(
						array(
							'name'	=> __( 'Font Colors', 'avia_framework' ),
							'desc'	=> __( 'Either use the themes default colors or apply some custom ones', 'avia_framework' ),
							'id'	=> 'font_color',
							'type'	=> 'select',
							'std'	=> '',
							'lockable'	=> true,
							'subtype'	=> array(
											__( 'Default', 'avia_framework' )	=> '',
											__( 'Define Custom Colors', 'avia_framework' )	=> 'custom'
										),
						),

						array(
							'name'	=> __( 'Custom Font Color', 'avia_framework' ),
							'desc'	=> __( 'Select a custom font color. Leave empty to use the default', 'avia_framework' ),
							'id'	=> 'color',
							'type'	=> 'colorpicker',
							'std'	=> '',
							'lockable'	=> true,
							'required'	=> array( 'font_color', 'equals', 'custom' )
						),
					);

			$template = array(
							array(
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Font Colors', 'avia_framework' ),
								'content'		=> $c
							),
					);

			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_font_colors' ), $template );

		}

		/**
		 * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
		 * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
		 * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
		 *
		 *
		 * @param array $params this array holds the default values for $content and $args.
		 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
		 */
		function editor_element( $params )
		{
			$default = array();
			$locked = array();
			$attr = $params['args'];
			$content = $params['content'];
			Avia_Element_Templates()->set_locked_attributes( $attr, $this, $this->config['shortcode'], $default, $locked, $content );

			$template = $this->update_option_lockable( 'content', $locked );

			$params['class'] = '';
			$params['innerHtml'] = "<div class='avia_textblock avia_textblock_style' {$template} data-update_element_template='yes'>" . stripslashes( wpautop( trim( html_entity_decode( $content ) ) ) ) . '</div>';

			return $params;
		}

		/**
		 * Create custom stylings
		 *
		 * @since 4.8.7
		 * @param array $args
		 * @return array
		 */
		protected function get_element_styles( array $args )
		{
			$result = parent::get_element_styles( $args );

			extract( $result );

			$default = array(
						'font_color'	=> '',
						'color'			=> '',
						'size'			=> '',
					);

			$default = $this->sync_sc_defaults_array( $default, 'no_modal_item', 'no_content' );

			$locked = array();
			Avia_Element_Templates()->set_locked_attributes( $atts, $this, $shortcodename, $default, $locked, $content );
			Avia_Element_Templates()->add_template_class( $meta, $atts, $default );

			$atts = shortcode_atts( $default, $atts, $this->config['shortcode'] ) ;

			$classes = array(
						'av_textblock_section',
						$element_id
					);

			$element_styling->add_classes( 'section', $classes );


			$classes = array(
						'avia_textblock'
					);

			$element_styling->add_classes( 'container', $classes );

			$element_styling->add_classes_from_array( 'container', $meta, 'custom_class' );
			$element_styling->add_classes_from_array( 'container', $atts, 'template_class' );

			if( 'custom' == $atts['font_color'] )
			{
				$element_styling->add_classes( 'container', 'av_inherit_color' );
				$element_styling->add_styles( 'container', array( 'color' => $atts['color'] ) );
			}

			if( ! empty( $atts['size'] ) )
			{
				$element_styling->add_styles( 'container', array( 'font-size' => $atts['size'] . 'px' ) );
			}

			$selectors = array(
						'container'	=> ".av_textblock_section.{$element_id} .avia_textblock",
					);

			$element_styling->add_selectors( $selectors );


			$result['default'] = $default;
			$result['atts'] = $atts;
			$result['content'] = $content;
			$result['element_styling'] = $element_styling;

			return $result;
		}

		/**
		 * Frontend Shortcode Handler
		 *
		 * @param array $atts array of attributes
		 * @param string $content text within enclosing form of shortcode element
		 * @param string $shortcodename the shortcode found, when == callback name
		 * @return string $output returns the modified html string
		 */
		function shortcode_handler( $atts, $content = '', $shortcodename = '', $meta = '' )
		{
			$result = $this->get_element_styles( compact( array( 'atts', 'content', 'shortcodename', 'meta' ) ) );

			extract( $result );

			extract( AviaHelper::av_mobile_sizes( $atts ) ); //return $av_font_classes, $av_title_font_classes and $av_display_classes

			extract( $atts );

			$markup_entry = avia_markup_helper( array( 'context' => 'entry', 'echo' => false, 'custom_markup' => $meta['custom_markup'] ) );
			$markup_text = avia_markup_helper( array( 'context' => 'entry_content', 'echo' => false, 'custom_markup' => $meta['custom_markup'] ) );


			$style_tag = $element_styling->get_style_tag( $element_id );
			$section_class = $element_styling->get_class_string( 'section' );
			$container_class = $element_styling->get_class_string( 'container' );

			$output  = '';
			$output .= $style_tag;
			$output .= "<section {$meta['custom_el_id']} class='{$section_class} {$av_display_classes}' {$markup_entry}>";
			$output .=		"<div class='{$container_class} {$av_font_classes}' {$markup_text}>";
			$output .=			ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $content ) );
			$output .=		'</div>';
			$output .= '</section>';

			return $output;
		}
	}
}

