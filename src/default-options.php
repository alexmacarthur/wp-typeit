<?php

return apply_filters('typeit:settings_data', array(

	'strings' => array(
		"name" => "String",
		"description" => "Enter a string you'd like to type.",
		"helper_description" => "",
		"default_value" => "",
		"input_type" => "text",
		"required" => true
	),

    'speed' => array(
		"name" => 'Speed',
		"description" => "Enter a speed, in milliseconds, at which you'd like to type.",
		"helper_description" => "",
		"default_value" => 100,
		"input_type" => "number",
		"required" => false
	),

    'deleteSpeed' => array(
		"name" => "Delete Speed",
		"description" => "Enter the speed, in milliseconds, at which you'd like to delete a string.",
		"helper_description" => "",
		"default_value" => null,
		"input_type" => "number",
		"required" => false
	),

    'lifeLike' => array(
		"name" => "Life-Like",
		"description" => "Check if you want the rate of typing to be slightly variable, like a human.",
		"helper_description" => "Yes, I make the typing animation more life-like.",
		"default_value" => true,
		"input_type" => "checkbox",
		"required" => false
	),

    'cursor' => array(
		"name" => "Cursor",
		"description" => "Check if you want a blinking cursor to appear at the end of the string(s).",
		"helper_description" => "Yes, show a blinking cursor.",
		"default_value" => true,
		"input_type" => "checkbox",
		"required" => false
	),

    'cursorSpeed' => array(
		"name" => "Cursor Speed",
		"description" => "The speed at which you want the cursor to blink, if it's enabled.",
		"helper_description" => "",
		"default_value" => 1000,
		"input_type" => "number",
		"required" => false
	),

    'breakLines' => array(
		"name" => "Break Lines",
		"description" => "Check if you want each string to be typed on its own line.",
		"helper_description" => "Yes, break lines.",
		"default_value" => false,
		"input_type" => "checkbox",
		"required" => false
	),

    'nextStringDelay' => array(
		"name" => "Next String Delay",
		"description" => "Enter the amount of time to pause between typeing multiple strings.",
		"helper_description" => "",
		"default_value" => 250,
		"input_type" => "number",
		"required" => false
	),

    'startDelete' => array(
		"name" => "Start Delete",
		"description" => "Check if you want the string (or first string, if multiple) to appear by default, and then be deleted before continuing.",
		"helper_description" => "Yes, start by deleting a string.",
		"default_value" => false,
		"input_type" => "checkbox",
		"required" => false
	),

    'startDelay' => array(
		"name" => "Start Delay",
		"description" => "Enter the amount of time to wait before starting this TypeIt effect on page load.",
		"helper_description" => "",
		"default_value" => 250,
		"input_type" => "number",
		"required" => false
	),

    'loop' => array(
		"name" => "Loop",
		"description" => "Check if you want this effect to loop continuously.",
		"helper_description" => "Yes, loop this effect repeatedly.",
		"default_value" => false,
		"input_type" => "checkbox",
		"required" => false
	),

    'loopDelay' => array(
		"name" => "Loop Delay",
		"description" => "The amount of time to delay between looped instances.",
		"helper_description" => "",
		"default_value" => 750,
		"input_type" => "number",
		"required" => false
	),

    'html' => array(
		"name" => "HTML",
		"description" => "Check if you want to parse the string as HTML.",
		"helper_description" => "Yes, parse this as HTML.",
		"default_value" => true,
		"input_type" => "checkbox",
		"required" => false
	)
	
));
