<?php

return apply_filters('typeit:settings_data', array(

    //-- All of these keys are lowercased versions of the keys in the original JS package.

    'strings' => array(
        "name" => "String",
        "description" => "Enter a string you'd like to type.",
        "helper_description" => "",
        "default_value" => "",
        "input_type" => "text",
        "required" => true,
        "can_have_many" => true
    ),

    'speed' => array(
        "name" => 'Speed',
        "description" => "Enter a speed, in milliseconds, at which you'd like to type.",
        "helper_description" => "",
        "default_value" => 100,
        "input_type" => "number",
        "required" => false,
    ),

    'deletespeed' => array(
        "js_key" => 'deleteSpeed',
        "name" => "Delete Speed",
        "description" => "Enter the speed, in milliseconds, at which you'd like to delete a string.",
        "helper_description" => "",
        "default_value" => null,
        "input_type" => "number",
        "required" => false,
    ),

    'lifelike' => array(
        "js_key" => 'lifeLike',
        "name" => "Life-Like",
        "description" => "Check if you want the rate of typing to be slightly variable, like a human.",
        "helper_description" => "Yes, I make the typing animation more life-like.",
        "default_value" => true,
        "input_type" => "checkbox",
        "required" => false,
    ),

    'cursor' => array(
        "name" => "Cursor",
        "description" => "Check if you want a blinking cursor to appear at the end of the string(s).",
        "helper_description" => "Yes, show a blinking cursor.",
        "default_value" => true,
        "input_type" => "checkbox",
        "required" => false,
    ),

    'cursorspeed' => array(
        "js_key" => 'cursorSpeed',
        "name" => "Cursor Speed",
        "description" => "The speed at which you want the cursor to blink, if it's enabled.",
        "helper_description" => "",
        "default_value" => 1000,
        "input_type" => "number",
        "required" => false,
    ),

    'breaklines' => array(
        "js_key" => 'breakLines',
        "name" => "Break Lines",
        "description" => "Check if you want each string to be typed on its own line.",
        "helper_description" => "Yes, break lines.",
        "default_value" => false,
        "input_type" => "checkbox",
        "required" => false,
    ),

    'nextstringdelay' => array(
        "js_key" => 'nextStringDelay',
        "name" => "Next String Delay",
        "description" => "Enter the amount of time to pause between typeing multiple strings.",
        "helper_description" => "",
        "default_value" => 250,
        "input_type" => "number",
        "required" => false,
    ),

    'startdelete' => array(
        "js_key" => 'startDelete',
        "name" => "Start Delete",
        "description" => "Check if you want the string (or first string, if multiple) to appear by default, and then be deleted before continuing.",
        "helper_description" => "Yes, start by deleting a string.",
        "default_value" => false,
        "input_type" => "checkbox",
        "required" => false,
    ),

    'startdelay' => array(
        "js_key" => 'startDelay',
        "name" => "Start Delay",
        "description" => "Enter the amount of time to wait before starting this TypeIt effect on page load.",
        "helper_description" => "",
        "default_value" => 250,
        "input_type" => "number",
        "required" => false,
    ),

    'loop' => array(
        "name" => "Loop",
        "description" => "Check if you want this effect to loop continuously.",
        "helper_description" => "Yes, loop this effect repeatedly.",
        "default_value" => false,
        "input_type" => "checkbox",
        "required" => false,
    ),

    'loopdelay' => array(
        "js_key" => 'loopDelay',
        "name" => "Loop Delay",
        "description" => "The amount of time to delay between looped instances.",
        "helper_description" => "",
        "default_value" => 750,
        "input_type" => "number",
        "required" => false,
    ),

    'html' => array(
        "name" => "HTML",
        "description" => "Check if you want to parse the string as HTML.",
        "helper_description" => "Yes, parse this as HTML.",
        "default_value" => true,
        "input_type" => "checkbox",
        "required" => false,
    ),

    'waituntilvisible' => array(
        "js_key" => 'waitUntilVisible',
        "name" => "waitUntilVisible",
        "description" => "Only begin the typing animation after the target element is visible.",
        "helper_description" => "Yes, wait until the element is visible.",
        "default_value" => false,
        "input_type" => "checkbox",
        "required" => false,
    ),
));
