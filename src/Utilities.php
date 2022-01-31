<?php

namespace TypeIt;

class Utilities
{

    public static function get_typed_options($options = array())
    {

        //-- Weird way of ensuring each value matches the type of the defaults.
        $formattedOptions = array();

        foreach ($options as $key => $value) {

            //-- Lowercase this because shortcode attributes MUST be lowercase.
            $key = strtolower($key);

            $defaults = Store::get('option_defaults');

			//-- @todo: add test!
            if (!isset($defaults[$key])) {
                continue;
            }
			
			$default = $defaults[$key];
			
            //-- Make sure the given key is set in case it needs capital letters for JS use.
			$givenKey = isset($default['js_key']) ? $default['js_key'] : $key;
			
            //-- If we've designated this can have many values (like 'strings'), enforce array type.
            $type = isset($default['can_have_many']) && $default['can_have_many']
            ? 'array'
            : gettype($default['default_value']);

            switch ($type) {
                case 'string':
                    $formattedOptions[$givenKey] = (string) $value;
                    break;
                case 'integer':
                    $formattedOptions[$givenKey] = (int) $value;
                    break;
                case 'array':
                    $formattedOptions[$givenKey] = (array) $value;
                    break;
                case 'boolean':

                    if (gettype($value) === 'boolean') {
                        $formattedOptions[$givenKey] = $value;
                        break;
                    }

                    if (gettype($value) === 'string') {
                        $formattedOptions[$givenKey] = in_array($value, array('true', 'on')) ? true : false;
                    }

                    break;

                default:
                    if (is_numeric($value)) {
                        $formattedOptions[$givenKey] = (int) $value;
                    } else {
                        $formattedOptions[$givenKey] = $value;
                    }
            }
        }

        return $formattedOptions;
    }

    /**
     * Determine if nested layers of inner blocks have a block by a particular name.
     *
     * @param array $block
     * @param string $blockName
     * @return boolean
     */
    public static function exists_in_inner_block($block, $blockName) {
        if(!$block['innerBlocks']) {
            return false;
        }

        foreach($block['innerBlocks'] as $block) {
            // This inner block has our block!
            if(!empty($block['attrs']['ref']) && has_block($blockName, $block['attrs']['ref'])) {
                return true;
            }

            // We still have more inner blocks, so keep searching through them.
            if(!empty($block['innerBlocks'])) {
                return self::exists_in_inner_block($block, $blockName);
            }
        }

        return false;
    }

    public static function has_reusable_block($blockName, $post) {
        // This page doesn't have any blocks. Don't bother.
        if (!has_blocks($post)) {
            return false;
        }
        
        // This is for reusable blocks
        if (has_block('block', $post)) {
            $content = get_post_field( 'post_content', $post);
            $blocks = parse_blocks($content);

            if (!is_array( $blocks ) || empty($blocks)) {
                return false;
            }

            foreach ($blocks as $block) {
                if($hasInnerBlock = self::exists_in_inner_block($block, $blockName)) {
                    return $hasInnerBlock;
                }

                if (!empty($block['attrs']['ref']) && has_block($blockName, $block['attrs']['ref'])) {
                    return true;
                }
            }
        }

        return false;
    }
}
