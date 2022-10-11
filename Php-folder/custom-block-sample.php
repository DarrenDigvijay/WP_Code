<?php
// Needed for adding the PHP Template Method blocks from within the plugin
use function Genesis\CustomBlocks\add_block;

add_block(
    'sbx-genesis-compact-testimonial-slider',
    array(
        'title' => 'Compact Testimonial Slider',
        'category' => 'common',
        'icon' => 'account_circle',
        'keywords' => array('text', 'post', 'image'),
        'displayModal' => false,
        'fields' => array(
            'background-color' =>
                array(
                    'location' => 'editor',
                    'width' => '25',
                    'help' => '',
                    'options' =>
                        array(
                            0 =>
                                array(
                                    'value' => '',
                                    'label' => __('Select Background Color', 'enhabitCompactTestimonialSlider'),
                                ),
                            1 =>
                                array(
                                    'value' => 'bkg-purple-25',
                                    'label' => __('Medium Purple', 'enhabitCompactTestimonialSlider'),
                                ),
                            2 =>
                                array(
                                    'value' => 'bkg-purple-10',
                                    'label' => __('Light Purple', 'enhabitCompactTestimonialSlider'),
                                ),
                            3 =>
                                array(
                                    'value' => 'bkg-orange-25',
                                    'label' => __('Medium Orange', 'enhabitCompactTestimonialSlider'),
                                ),
                            4 =>
                                array(
                                    'value' => 'bkg-orange-10',
                                    'label' => __('Light Orange', 'enhabitCompactTestimonialSlider'),
                                ),
                            5 =>
                                array(
                                    'value' => 'bkg-teal-50',
                                    'label' => __('Dark Teal', 'enhabitCompactTestimonialSlider'),
                                ),
                            6 =>
                                array(
                                    'value' => 'bkg-teal-35',
                                    'label' => __('Medium Teal', 'enhabitCompactTestimonialSlider'),
                                ),
                            7 =>
                                array(
                                    'value' => 'bkg-teal-15',
                                    'label' => __('Light Teal', 'enhabitCompactTestimonialSlider'),
                                ),
                            8 =>
                                array(
                                    'value' => 'bkg-pink-25',
                                    'label' => __('Medium Pink', 'enhabitCompactTestimonialSlider'),
                                ),
                            9 =>
                                array(
                                    'value' => 'bkg-pink-10',
                                    'label' => __('Light Pink', 'enhabitCompactTestimonialSlider'),
                                ),
                            10 =>
                                array(
                                    'value' => 'bkg-blue-25',
                                    'label' => __('Medium Blue', 'enhabitCompactTestimonialSlider'),
                                ),
                            11 =>
                                array(
                                    'value' => 'bkg-blue-10',
                                    'label' => __('Light Blue', 'enhabitCompactTestimonialSlider'),
                                ),
                            12 =>
                                array(
                                    'value' => 'bkg-gradient-purple',
                                    'label' => __('Gradient Full Purple', 'enhabitCompactTestimonialSlider'),
                                ),
                            13 =>
                                array(
                                    'value' => 'bkg-gradient-orange',
                                    'label' => __('Gradient Full Orange', 'enhabitCompactTestimonialSlider'),
                                ),
                            14 =>
                                array(
                                    'value' => 'bkg-purple-bottom',
                                    'label' => __('Gradient Bottom Purple', 'enhabitCompactTestimonialSlider'),
                                ),
                            15 =>
                                array(
                                    'value' => 'bkg-orange-bottom',
                                    'label' => __('Gradient Bottom Orange', 'enhabitCompactTestimonialSlider'),
                                ),
                            16 =>
                                array(
                                    'value' => 'bkg-purple-top',
                                    'label' => __('Gradient Top Purple', 'enhabitCompactTestimonialSlider'),
                                ),
                            17 =>
                                array(
                                    'value' => 'bkg-orange-top',
                                    'label' => __('Gradient Top Orange ', 'enhabitCompactTestimonialSlider'),
                                ),
                            18 =>
                                array(
                                    'value' => 'bkg-purple-mid',
                                    'label' => __('Gradient Middle Purple', 'enhabitCompactTestimonialSlider'),
                                ),
                            19 =>
                                array(
                                    'value' => 'bkg-orange-mid',
                                    'label' => __('Gradient Middle Orange', 'enhabitCompactTestimonialSlider'),
                                ),
                        ),
                    'default' => 'white',
                    'name' => 'background-color',
                    'label' => __('Background Color', 'enhabitCompactTestimonialSlider'),
                    'order' => 0,
                    'control' => 'select',
                    'type' => 'string',
                ),
            'title' =>
                array(
                    'location' => 'editor',
                    'width' => '100',
                    'help' => '',
                    'default' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'name' => 'title',
                    'label' => __('Title (Required)', 'enhabitCompactTestimonialSlider'),
                    'control' => 'text',
                    'type' => 'string',
                    'order' => 1,
                ),
            'sub-title' =>
                array(
                    'help' => '',
                    'default' => '',
                    'placeholder' => '',
                    'name' => 'sub-title',
                    'label' => __('Subtitle (Required)', 'enhabitCompactTestimonialSlider'),
                    'location' => 'editor',
                    'order' => 2,
                    'control' => 'rich_text',
                    'type' => 'string',
                ),
            'button-text' =>
                array(
                    'location' => 'editor',
                    'width' => '100',
                    'help' => '',
                    'default' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'name' => 'button-text',
                    'label' => __('Button Label Text', 'enhabitCompactTestimonialSlider'),
                    'control' => 'text',
                    'type' => 'string',
                    'order' => 3,
                ),
            'button-toggle' =>
                array(
                    'location' => 'editor',
                    'width' => '25',
                    'help' => '',
                    'default' => '',
                    'options' =>
                        array(
                            0 =>
                                array(
                                    'value' => 'internal',
                                    'label' => __('Internal Link', 'enhabitCompactTestimonialSlider'),
                                ),
                            1 =>
                                array(
                                    'value' => 'external',
                                    'label' => __('External Link', 'enhabitCompactTestimonialSlider'),
                                ),
                            2 =>
                                array(
                                    'value' => 'download',
                                    'label' => __('Download Link', 'enhabitCompactTestimonialSlider'),
                                ),
                        ),
                    'name' => 'button-toggle',
                    'label' => __('Button Link Type', 'enhabitCompactTestimonialSlider'),
                    'order' => 4,
                    'control' => 'select',
                    'type' => 'string',
                ),
            'button-link' =>
                array(
                    'location' => 'editor',
                    'width' => '25',
                    'help' => '',
                    'default' => '',
                    'placeholder' => '',
                    'name' => 'button-link',
                    'post_type_rest_slug' => 'pages',
                    'label' => __('Button Link (Internal)', 'enhabitCompactTestimonialSlider'),
                    'order' => 5,
                    'control' => 'post',
                    'type' => 'object',
                ),
            'external-button-link' =>
                array(
                    'location' => 'editor',
                    'width' => '50',
                    'help' => '',
                    'default' => '',
                    'placeholder' => '',
                    'name' => 'external-button-link',
                    'label' => __('External/Download Button Link', 'enhabitCompactTestimonialSlider'),
                    'order' => 6,
                    'control' => 'url',
                    'type' => 'string',
                ),
            'upload-button-icon' =>
                array(
                    'location' => 'editor',
                    'width' => '100',
                    'help' => '',
                    'name' => 'upload-button-icon',
                    'label' => __('Upload Button Icon', 'enhabitCompactTestimonialSlider'),
                    'order' => 7,
                    'control' => 'image',
                    'type' => 'integer',
                ),
            'add-testimonials' =>
                array(
                    'help' => '',
                    'min' => '3',
                    'max' => '5',
                    'sub_fields' =>
                        array(
                            'author' =>
                                array(
                                    'location' => 'editor',
                                    'width' => '50',
                                    'help' => '',
                                    'default' => '',
                                    'placeholder' => '',
                                    'maxlength' => '',
                                    'name' => 'author',
                                    'label' => __('Author', 'enhabitCompactTestimonialSlider'),
                                    'control' => 'text',
                                    'type' => 'string',
                                    'order' => 0,
                                    'parent' => 'add-testimonials',

                                ),
                            'designation' =>
                                array(
                                    'location' => 'editor',
                                    'width' => '50',
                                    'help' => '',
                                    'name' => 'designation',
                                    'label' => __('Designation', 'enhabitCompactTestimonialSlider'),
                                    'order' => 1,
                                    'control' => 'text',
                                    'type' => 'string',
                                    'parent' => 'add-testimonials',
                                ),
                            'content' =>
                                array(
                                    'location' => 'editor',
                                    'width' => '100',
                                    'help' => '',
                                    'default' => '',
                                    'placeholder' => '',
                                    'maxlength' => '',
                                    'name' => 'excerpt',
                                    'label' => __('Add Content', 'enhabitCompactTestimonialSlider'),
                                    'control' => 'classic_text',
                                    'type' => 'text',
                                    'order' => 2,
                                    'parent' => 'add-testimonials',
                                ),
                        ),
                    'name' => 'add-testimonials',
                    'label' => __('Add Testimonial Cards (Required)', 'enhabitCompactTestimonialSlider'),
                    'location' => 'editor',
                    'order' => 8,
                    'control' => 'repeater',
                    'type' => 'object',
                ),
        ),
    )
);