<?php
/**
 * Team Member
 *
 * Display a team members image with additional information
 */
if( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if( ! class_exists( 'avia_sc_team' ) )
{
	class avia_sc_team extends aviaShortcodeTemplate
	{
		/**
		 *
		 * @since 4.8.4
		 * @param \AviaBuilder $builder
		 */
		public function __construct( \AviaBuilder $builder )
		{
			parent::__construct( $builder );
		}

		/**
		 * @since 4.8.4
		 */
		public function __destruct()
		{
			parent::__destruct();
		}

		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['version']		= '1.0';
			$this->config['self_closing']	= 'no';
			$this->config['base_element']	= 'yes';

			$this->config['name']			= __( 'Team Member', 'avia_framework' );
			$this->config['tab']			= __( 'Content Elements', 'avia_framework' );
			$this->config['icon']			= AviaBuilder::$path['imagesURL'] . 'sc-team.png';
			$this->config['order']			= 35;
			$this->config['target']			= 'avia-target-insert';
			$this->config['shortcode']		= 'av_team_member';
			$this->config['shortcode_nested'] = array( 'av_team_icon' );
			$this->config['tooltip']		= __( 'Display a team members image with additional information', 'avia_framework' );
			$this->config['preview']		= true;
			$this->config['disabling_allowed'] = true;
			$this->config['id_name']		= 'id';
			$this->config['id_show']		= 'yes';
			$this->config['name_item']		= __( 'Team Member Item', 'avia_framework' );
			$this->config['tooltip_item']	= __( 'A Team Member Element Item', 'avia_framework' );
		}

		function admin_assets()
		{
			$ver = AviaBuilder::VERSION;

			wp_register_script( 'avia_tab_toggle_js', AviaBuilder::$path['assetsURL'] . 'js/avia-tab-toggle.js', array( 'avia_modal_js' ), $ver, true );
			Avia_Builder()->add_registered_admin_script( 'avia_tab_toggle_js' );
		}

		function extra_assets()
		{
			//load css
			wp_enqueue_style( 'avia-module-team', AviaBuilder::$path['pluginUrlRoot'] . 'avia-shortcodes/team/team.css', array( 'avia-layout' ), false );
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
							'type'			=> 'template',
							'template_id'	=> $this->popup_key( 'content_team' )
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
							'template_id'	=> $this->popup_key( 'styling_colors' )
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
								'template_id'	=> 'lazy_loading_toggle',
								'lockable'		=> true
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
					)

				);

		}

		/**
		 * Create and register templates for easier maintainance
		 *
		 * @since 4.6.4
		 */
		protected function register_dynamic_templates()
		{

			$this->register_modal_group_templates();

			/**
			 * Content Tab
			 * ===========
			 */

			$c = array(
						array(
							'name' 	=> __( 'Team Member Name', 'avia_framework' ),
							'desc' 	=> __( 'Name of the person', 'avia_framework' ),
							'id' 	=> 'name',
							'type' 	=> 'input',
							'std' 	=> 'John Doe',
							'lockable'	=> true,
							'tmpl_set_default'	=> false
						),

						array(
							'name' 	=> __( 'Team Member Job title', 'avia_framework' ),
							'desc' 	=> __( 'Job title of the person.', 'avia_framework' ),
							'id' 	=> 'job',
							'type' 	=> 'input',
							'std' 	=> '',
							'lockable'	=> true,
							'tmpl_set_default'	=> false
						),

						array(
							'name'		=> __( 'Team Member Image', 'avia_framework' ),
							'desc'		=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
							'id'		=> 'src',
							'type'		=> 'image',
							'title'		=> __( 'Insert Image', 'avia_framework' ),
							'button'	=> __( 'Insert', 'avia_framework' ),
							'std'		=> '',
							'lockable'	=> true,
							'tmpl_set_default'	=> false,
							'locked'	=> array( 'src', 'attachment', 'attachment_size' )
						),

						array(
							'name' 	=> __( 'Image size', 'avia_framework' ),
							'desc' 	=> __( 'Select the size of the team member image', 'avia_framework' ),
							'id' 	=> 'image_width',
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'tmpl_set_default'	=> false,
							'required'	=> array( 'src', 'not', '' ),
							'subtype'	=> array(
												__( 'Fit into container', 'avia_framework' ) => '',
												__( 'Use original size (or fit into container if too large)', 'avia_framework' ) => 'av-team-img-original',
											)
								),

						array(
							'name' 	=> __( 'Team Member Description', 'avia_framework' ),
							'desc' 	=> __( 'Enter a few words that describe the person', 'avia_framework' ),
							'id' 	=> 'description',
							'type' 	=> 'textarea',
							'std' 	=> '',
							'lockable'	=> true,
							'tmpl_set_default'	=> false
						),

						array(
							'name'			=> __( 'Add/Edit Social Service or Icon Links', 'avia_framework' ),
							'desc'			=> __( 'Below each Team Member you can add Icons that link to destinations like Facebook page, Twitter account etc.', 'avia_framework' ),
							'type'			=> 'modal_group',
							'id'			=> 'content',
							'modal_title'	=> __( 'Edit Social Service or Icon', 'avia_framework' ),
							'std'			=> array(),
							'editable_item'	=> true,
							'lockable'		=> true,
							'tmpl_set_default'	=> false,
							'subelements' 	=> $this->create_modal()
						)

				);

			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'content_team' ), $c );

			$c = array(
						array(
							'name' 	=> __( 'Font Colors', 'avia_framework' ),
							'desc' 	=> __( 'Either use the themes default colors or apply some custom ones', 'avia_framework' ),
							'id' 	=> 'font_color',
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'subtype'	=> array(
												__( 'Default', 'avia_framework' )				=> '',
												__( 'Define Custom Colors', 'avia_framework' )	=> 'custom'
											),
						),

						array(
							'name' 	=> __( 'Custom Title Font Color', 'avia_framework' ),
							'desc' 	=> __( 'Select a custom font color. Leave empty to use the default', 'avia_framework' ),
							'id' 	=> 'custom_title',
							'type' 	=> 'colorpicker',
							'std' 	=> '',
							'container_class' => 'av_half av_half_first',
							'lockable'	=> true,
							'required'	=> array( 'font_color', 'equals', 'custom' )
						),

						array(
							'name' 	=> __( 'Custom Content Font Color', 'avia_framework' ),
							'desc' 	=> __( 'Select a custom font color. Leave empty to use the default', 'avia_framework' ),
							'id' 	=> 'custom_content',
							'type' 	=> 'colorpicker',
							'std' 	=> '',
							'container_class' => 'av_half',
							'lockable'	=> true,
							'required'	=> array( 'font_color', 'equals', 'custom' )
						)
				);


			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_colors' ), $c );

		}

		/**
		 * Creates the modal popup for a single entry
		 *
		 * @since 4.6.4
		 * @return array
		 */
		protected function create_modal()
		{
			$elements = array(

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
							'type'			=> 'template',
							'template_id'	=> $this->popup_key( 'modal_content_team' )
						),

				array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

				array(
						'type'			=> 'template',
						'template_id'	=> 'element_template_selection_tab',
						'args'			=> array(
												'sc'			=> $this,
												'modal_group'	=> true
											)
					),

				array(
						'type' 	=> 'tab_container_close',
						'nodescription' => true
					)

				);

			return $elements;
		}

		/**
		 * Register all templates for the modal group popup
		 *
		 * @since 4.6.4
		 */
		protected function register_modal_group_templates()
		{
			/**
			 * Content Tab
			 * ===========
			 */
			$c = array(
						array(
							'name' 	=> __( 'Hover Text', 'avia_framework' ),
							'desc' 	=> __( 'Text that appears if you place your mouse above the Icon', 'avia_framework' ),
							'id' 	=> 'title',
							'type' 	=> 'input',
							'std' 	=> __( 'Social Icon Hover Text', 'avia_framework' ),
							'lockable'	=> true
						),

						array(
							'name' 	=> __( 'Icon Link', 'avia_framework' ),
							'desc' 	=> __( 'Enter the URL of the page you want to link to', 'avia_framework' ),
							'id' 	=> 'link',
							'type' 	=> 'input',
							'std' 	=> 'https://',
							'lockable'	=> true
						),

						array(
							'name' 	=> __( 'Open Link in new Window?', 'avia_framework' ),
							'desc' 	=> __( 'Select here if you want to open the linked page in a new window', 'avia_framework' ),
							'id' 	=> 'link_target',
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'subtype'	=> array(
												__( 'Open in same window', 'avia_framework' )	=> '',
												__( 'Open in new window', 'avia_framework' )	=> '_blank'
											)
						),

						array(
							'name' 	=> __( 'Select Icon', 'avia_framework' ),
							'desc' 	=> __( 'Select an icon for your social service, job, etc. below', 'avia_framework' ),
							'id' 	=> 'icon',
							'type' 	=> 'iconfont',
							'std' 	=> '',
							'lockable'	=> true,
							'locked'	=> array( 'icon', 'font' )
						),

				);

			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'modal_content_team' ), $c );

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
			Avia_Element_Templates()->set_locked_attributes( $attr, $this, $this->config['shortcode'], $default, $locked );

			$templateIMG = $this->update_template_lockable( 'src', "<img src='{{src}}' alt=''/>", $locked );
			$templateNAME = $this->update_option_lockable( 'name', $locked  );
			$templateJob = $this->update_option_lockable( 'job', $locked  );

			$params['innerHtml'] = '<div data-update_element_template="yes">';

			if( empty( $attr['src'] ) )
			{
				$params['innerHtml'] .= "<div class='avia_image_container' {$templateIMG}>";
				$params['innerHtml'] .=		"<img src='{$this->config['icon']}' title='{$this->config['name']}' alt='' />";
				$params['innerHtml'] .=		"<div class='avia-element-label'>{$this->config['name']}</div>";
				$params['innerHtml'] .= '</div>';
			}
			else
			{
				$params['innerHtml'] .= "<div class='avia_image_container' {$templateIMG}><img src='{$attr['src']}' alt='' /></div>";
			}

			$params['innerHtml'] .= "<div class='avia-element-name' {$templateNAME} >" . html_entity_decode( $attr['name'] ) . '</div>';
			$params['innerHtml'] .= "<span class='avia_job_container_inner' {$templateJob} >" . html_entity_decode( $attr['job'] ) . '</span>';

			$params['innerHtml'] .= '</div>';

			return $params;
		}


		/**
		 * Editor Sub Element - this function defines the visual appearance of an element that is displayed within a modal window and on click opens its own modal window
		 * Works in the same way as Editor Element
		 * @param array $params this array holds the default values for $content and $args.
		 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
		 */
		function editor_sub_element( $params )
		{
			$default = array();
			$locked = array();
			$attr = $params['args'];
			Avia_Element_Templates()->set_locked_attributes( $attr, $this, $this->config['shortcode_nested'][0], $default, $locked );

			extract( av_backend_icon( array( 'args' => $attr ) ) ); // creates $font and $display_char if the icon was passed as param 'icon' and the font as 'font'

			$params['innerHtml']  = '';
			$params['innerHtml'] .= "<div class='avia_title_container' data-update_element_template='yes'>";
			$params['innerHtml'] .=		'<span ' . $this->class_by_arguments_lockable( 'font', $font, $locked ) . '>';
			$params['innerHtml'] .=			'<span ' . $this->update_option_lockable( array( 'icon', 'icon_fakeArg' ), $locked ) . " class='avia_tab_icon' >{$display_char}</span>";
			$params['innerHtml'] .=		'</span>';
			$params['innerHtml'] .=		'<span ' . $this->update_option_lockable( 'title', $locked ) . " class='avia_title_container_inner'>{$attr['title']}</span>";
			$params['innerHtml'] .= '</div>';

			return $params;
		}

		/**
		 * Returns false by default.
		 * Override in a child class if you need to change this behaviour.
		 *
		 * @since 4.2.1
		 * @param string $shortcode
		 * @return boolean
		 */
		public function is_nested_self_closing( $shortcode )
		{
			if( in_array( $shortcode, $this->config['shortcode_nested'] ) )
			{
				return true;
			}

			return false;
		}

		/**
		 * Override base class - we have global attributes here
		 *
		 * @since 4.8.4
		 * @return boolean
		 */
		public function has_global_attributes()
		{
			return true;
		}

		/**
		 * Create custom stylings
		 *
		 * @since 4.8.4
		 * @param array $args
		 * @return array
		 */
		protected function get_element_styles( array $args )
		{
			$result = parent::get_element_styles( $args );

			extract( $result );

			$default = array(
						'name'			=> '',
						'src'			=> '',
						'attachment'	=> 0,
						'image_width'	=> '',
						'description'	=> '',
						'job'			=> '',
						'custom_markup'	=> '',
						'font_color'	=> '',
						'custom_title'	=> '',
						'custom_content' => '',
						'lazy_loading'	=> 'disabled'
					);

			$default = $this->sync_sc_defaults_array( $default, 'no_modal_item', 'no_content' );

			$locked = array();
			Avia_Element_Templates()->set_locked_attributes( $atts, $this, $shortcodename, $default, $locked, $content );
			Avia_Element_Templates()->add_template_class( $meta, $atts, $default );

			$socials = ShortcodeHelper::shortcode2array( $content );

			$modal_def = array(
						'link'			=> '',
						'link_target'	=> '',
						'icon'			=> '',
						'font'			=> '',
						'title'			=> ''
					);

			$modal = $this->sync_sc_defaults_array( $modal_def, 'modal_item' );

			foreach( $socials as &$social )
			{
				Avia_Element_Templates()->set_locked_attributes( $social['attr'], $this, $this->config['shortcode_nested'][0], $modal, $locked, $social['content'] );
				$social['attr'] = array_merge( $modal, $social['attr'] );
			}

			unset( $social );


			$atts = shortcode_atts( $default, $atts, $this->config['shortcode'] );

			$atts['socials'] = $socials;



			$classes = array(
						'avia-team-member',
						$element_id
					);

			$element_styling->add_classes( 'container', $classes );
			$element_styling->add_classes_from_array( 'container', $meta, 'el_class' );

			if( ! empty( $atts['src'] ) )
			{
				$classes = array(
							'avia_image',
							'avia_image_team',
							$atts['image_width']
						);

				$element_styling->add_classes( 'team-image', $classes );
			}

			if( 'custom' == $atts['font_color'] )
			{
				$element_styling->add_styles( 'team-name', array( 'color' => $atts['custom_title'] ) );
				$element_styling->add_styles( 'team-job', array( 'color' => $atts['custom_title'] ) );
				$element_styling->add_styles( 'team-description', array( 'color' => $atts['custom_content'] ) );

				if( ! empty( $atts['custom_title'] ) )
				{
					$element_styling->add_classes( 'team-job', 'av_opacity_variation' );
				}

				if( ! empty( $atts['custom_content'] ) )
				{
					$element_styling->add_classes( 'team-description', 'av_inherit_color' );
				}
			}

			$selectors = array(
							'container'			=> ".avia-team-member.{$element_id}",
							'team-name'			=> "#top #wrap_all .avia-team-member.{$element_id} .team-member-name",
							'team-job'			=> ".avia-team-member.{$element_id} .team-member-job-title",
							'team-description'	=> ".avia-team-member.{$element_id} .team-member-description",
				);

			$element_styling->add_selectors( $selectors );

			$result['default'] = $default;
			$result['atts'] = $atts;
			$result['content'] = $content;
			$result['element_styling'] = $element_styling;

			return $result;
		}

		/**
		 * Create custom stylings for items
		 * (also called when creating header implicit)
		 *
		 * @since 4.8.4
		 * @param array $args
		 * @return array
		 */
		protected function get_element_styles_item( array $args )
		{
			//	get settings from container element and remove to get correct element id (override self::has_global_attributes() to activate)
			$parent_atts = isset( $args['atts']['parent_atts'] ) ? $args['atts']['parent_atts'] : null;
			unset( $args['atts']['parent_atts'] );

			$result = parent::get_element_styles_item( $args );

			extract( $result );

			if( is_null( $parent_atts ) )
			{
				$parent_atts = $this->parent_atts;
			}

			$classes = array(
						'avia-team-icon',
						$element_id
					);

			$element_styling->add_classes( 'team-icon', $classes );



			$selectors = array(
						'container'		=> ".avia-team-member .avia-team-icon.{$element_id}",
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

			if( 'disabled' == $atts['img_scrset'] )
			{
				Av_Responsive_Images()->force_disable( 'disabled' );
			}

			$this->parent_atts = $atts;


			$social_html = '';

			if( ! empty( $src ) && ! empty( $socials ) )
			{
				foreach ($socials as $social )
				{
					$social_html .= $this->build_social_html( $social );
				}
			}


			$markup_person = avia_markup_helper( array( 'context' => 'person', 'echo' => false, 'custom_markup' => $custom_markup ) );
			$markup_image = avia_markup_helper( array( 'context' => 'single_image', 'echo' => false, 'custom_markup' => $custom_markup ) );
			$markup_name = avia_markup_helper( array( 'context' => 'name', 'echo' => false, 'custom_markup' => $custom_markup ) );
			$markup_job = avia_markup_helper( array( 'context' => 'job', 'echo' => false, 'custom_markup' => $custom_markup ) );
			$markup_description = avia_markup_helper( array( 'context' => 'description', 'echo' => false, 'custom_markup' => $custom_markup ) );
			$markup_affiliate = avia_markup_helper( array( 'context' => 'affiliation', 'echo' => false, 'custom_markup' => $custom_markup ) );

			$style_tag = $element_styling->get_style_tag( $element_id );
			$item_tag = $element_styling->style_tag_html( $this->subitem_inline_styles, 'sub-' . $element_id );
			$container_class = $element_styling->get_class_string( 'container' );
			$img_class = $element_styling->get_class_string( 'team-image' );
			$job_class = $element_styling->get_class_string( 'team-job' );
			$description_class = $element_styling->get_class_string( 'team-description' );


			$output  = '';
			$output .= $style_tag;
			$output .= $item_tag;
			$output .= "<section {$meta['custom_el_id']} class='{$container_class} {$av_display_classes}' {$markup_person}>";

			if( ! empty( $src ) )
			{
				$img_tag = "<img class='{$img_class}' src='{$src}' alt='" . esc_attr( $name ) . "' {$markup_image} />";
				$img_tag = Av_Responsive_Images()->prepare_single_image( $img_tag, $attachment, $lazy_loading );

				$output .= '<div class="team-img-container">';
				$output .=		$img_tag;

				if( ! empty( $socials ) )
				{
					$output .= '<div class="team-social">';
					$output .=		'<div class="team-social-inner">';
					$output .=			$social_html;
					$output .=		'</div>';
					$output .= '</div>';
				}

				$output .= '</div>';
			}

			if( $name )
			{
				$default_heading = 'h3';
				$args = array(
							'heading'		=> $default_heading,
							'extra_class'	=> ''
						);

				$extra_args = array( $this, $atts, $content );

				/**
				 * @since 4.5.5
				 * @return array
				 */
				$args = apply_filters( 'avf_customize_heading_settings', $args, __CLASS__, $extra_args );

				$heading = ! empty( $args['heading'] ) ? $args['heading'] : $default_heading;
				$css = ! empty( $args['extra_class'] ) ? $args['extra_class'] : '';

				$output .= "<{$heading} class='team-member-name {$css}' {$markup_name}>{$name}</{$heading}>";
			}

			if( $job )
			{
				$output .= "<div class='team-member-job-title {$job_class}' {$markup_job}>{$job}</div>";
			}

			if( $description )
			{
				$output .= "<div class='team-member-description {$description_class}' {$markup_description}>" . ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $description ) ) . '</div>';
			}

			$output .=		"<span class='hidden team-member-affiliation' {$markup_affiliate}>" . get_bloginfo('name') . '</span>';
			$output .= '</section>';

			$html = Av_Responsive_Images()->make_content_images_responsive( $output );

			Av_Responsive_Images()->force_disable( 'reset' );

			return $html;
		}

		/**
		 * Create a single social HTML and set stylings
		 *
		 * @since 4.8.4
		 * @param array $social
		 * @return string
		 */
		protected function build_social_html( array $social )
		{
			//	init parameters for normal shortcode handler
			$atts = $social['attr'];
			$content = $social['content'];
			$shortcodename = $this->config['shortcode_nested'][0];

			$result = $this->get_element_styles_item( compact( array( 'atts', 'content', 'shortcodename' ) ) );

			extract( $result );

			extract( $atts );


			//build link for each social item
			$tooltip = $atts['title'] ? 'data-avia-tooltip="' . esc_attr( $atts['title'] ) . '"' : '';
			$link = esc_url( $atts['link'] );
			$target = $atts['link_target'] ? "target='_blank'" : '';

			//apply special class in case its a link to a known social media service
			$social_class = $this->get_social_class( $link );
			$element_styling->add_classes( 'team-icon', $social_class );


			if( strstr( $atts['link'], '@' ) )
			{
				$markup = avia_markup_helper( array( 'context' => 'email', 'echo' => false, 'custom_markup' => $this->parent_atts['custom_markup'] ) );
			}
			else
			{
				$markup = avia_markup_helper( array( 'context' => 'url', 'echo' => false, 'custom_markup' => $this->parent_atts['custom_markup'] ) );
			}

			$display_char = av_icon( $atts['icon'], $atts['font'] );

			$this->subitem_inline_styles .= $element_styling->get_style_tag( $element_id, 'rules_only' );
			$team_icon_class = $element_styling->get_class_string( 'team-icon' );

			$social_html  = '';
			$social_html .= "<span class='hidden av_member_url_markup {$social_class}' $markup>{$link}</span>";
			$social_html .= "<a href='{$link}' class='{$team_icon_class}' rel='v:url' {$tooltip} {$target} {$display_char}></a>";

			return $social_html;
		}

		/**
		 * Return a special class for known social links
		 *
		 * @param string $link
		 * @return string
		 */
		protected function get_social_class( $link )
		{
			$class = array();

			$services = array(
							'facebook',
							'youtube',
							'twitter',
							'pinterest',
							'tumblr',
							'flickr',
							'linkedin',
							'dribbble',
							'behance',
							'github',
							'soundcloud',
							'xing',
							'vimeo',
							'plus.google',
							'myspace',
							'forrst',
							'skype',
							'reddit'
						);

			foreach( $services as $service )
			{
				if( strpos( $link, $service ) !== false )
				{
					$class[] = str_replace( '.', '-', $service );
				}
			}

			return implode( ' ', $class );
		}
	}
}
