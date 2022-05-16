<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Api\Callbacks;

class AreaCallbacks
{

	public function areaSectionManager()
	{
		echo 'Create as many areas as you need.';
	}

	public function areaSanitize( $input )
	{
		$output = get_option('careerist_plugin_area');

		if ( count($output) == 0 ) {
			$output[$input['post_type']] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {
			if ($input['post_type'] === $key) {
				$output[$key] = $input;
			} else {
				$output[$input['post_type']] = $input;
			}
		}
		
		return $output;
	}

	public function textField( $args )
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$input = get_option( $option_name );

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="" placeholder="' . $args['placeholder'] . '" required>';
	}

	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option( $option_name );

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class=""><label for="' . $name . '"><div></div></label></div>';
	}
}
