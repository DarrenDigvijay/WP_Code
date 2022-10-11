<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('theme_options', __('Global Sections',DEMO_DOMAIN))
    ->add_tab(__('Benefits',DEMO_DOMAIN), array(
        Field::make('checkbox', 'make_it_easy_sec_is_hidden', __('Hide',DEMO_DOMAIN)),
        Field::make('text', 'make_it_easy_sec_title', __('Title',DEMO_DOMAIN)),
        Field::make('complex', 'make_it_easy_cards', __('Benefit',DEMO_DOMAIN))
            ->set_layout('tabbed-horizontal')
            ->add_fields(array(
                Field::make('text', 'title', __('Title',DEMO_DOMAIN)),
                Field::make('image', 'image', __('Icon',DEMO_DOMAIN)),
                Field::make('rich_text', 'description', __('Description',DEMO_DOMAIN)),
            )),
    ))
    ->add_tab(__('How It Works',DEMO_DOMAIN), array(
        Field::make('checkbox', 'how_it_work_sec_is_hidden', __('Hide',DEMO_DOMAIN)),
        Field::make('complex', 'how_it_work', __('How It Works',DEMO_DOMAIN))
            ->set_layout('tabbed-horizontal')
            ->add_fields(array(
                Field::make('text', 'how_it_work_tab_title', __('Tab Title',DEMO_DOMAIN)),
                Field::make('rich_text', 'how_it_work_text', __('Description',DEMO_DOMAIN)),
                Field::make('image', 'how_it_work_background_image', __('Background Image',DEMO_DOMAIN)),
            )),
    ))
    ->add_tab(__('Testimonials',DEMO_DOMAIN), array(
        Field::make('checkbox', 'testimonial_sec_is_hidden', __('Hide',DEMO_DOMAIN)),
        Field::make('text', 'testimonial_sec_title', __('Title',DEMO_DOMAIN)),
        Field::make('complex', 'testimonials', __('Testimonial',DEMO_DOMAIN))
            ->set_layout('tabbed-horizontal')
            ->add_fields(array(
                Field::make('select', 'testimonial_video_option', __('Video Type',DEMO_DOMAIN))
                    ->set_options(array('self_hosted_video' => __('Self-hosted Video',DEMO_DOMAIN), 'youtube_video' => __('YouTube Video',DEMO_DOMAIN)
                    )),
                Field::make('file', 'feedback_video', __('Browse Video',DEMO_DOMAIN))
                    ->set_conditional_logic(array(
                        array('field' => 'testimonial_video_option', 'value' => 'self_hosted_video',
                        )
                    )),
                Field::make('text', 'feedback_video_link', __('Video Link',DEMO_DOMAIN))
                    ->set_conditional_logic(array(
                        array('field' => 'testimonial_video_option', 'value' => 'youtube_video',
                        )
                    )),
                Field::make('image', 'feedback_video_thumbnail', __('Video Thumbnail',DEMO_DOMAIN)),

            )),
    ))
    ->add_tab(__('Resources',DEMO_DOMAIN), array(
        Field::make('checkbox', 'resource_sec_is_hidden', __('Hide',DEMO_DOMAIN)),
        Field::make('urlpicker', 'resource_sec_btn', __('Button',DEMO_DOMAIN)),
    ))
    ->add_tab(__('Franchise',DEMO_DOMAIN), array(
        Field::make('checkbox', 'franchise_sec_is_hidden', __('Hide',DEMO_DOMAIN)),
        Field::make('text', 'franchise_sec_title', __('Title',DEMO_DOMAIN)),
        Field::make('rich_text', 'franchise_sec_desc', __('Description',DEMO_DOMAIN)),
        Field::make('urlpicker', 'franchise_sec_btn', __('Button',DEMO_DOMAIN)),
        Field::make('image','franchise_sec_background_img_left',__('Background Image Left',DEMO_DOMAIN))->set_width(50),
        Field::make('image', 'franchise_sec_background_img_right', __('Background Image Right',DEMO_DOMAIN))->set_width(50),
    ))
    ->add_tab(__('Map',DEMO_DOMAIN), array(
        Field::make('checkbox', 'map_sec_is_hidden', __('Hide',DEMO_DOMAIN)),
        Field::make('text', 'map_sec_title', __('Title',DEMO_DOMAIN)),
        Field::make('rich_text', 'map_sec_desc', __('Description',DEMO_DOMAIN)),
    ))
    ->add_tab(__('Social',DEMO_DOMAIN), array(
        Field::make('checkbox', 'social_sec_is_hidden', __('Hide',DEMO_DOMAIN)),
        Field::make('text', 'social_sec_title', __('Title',DEMO_DOMAIN))->set_width(25),
        Field::make('urlpicker', 'social_sec_btn', __('Button',DEMO_DOMAIN))->set_width(25),
        Field::make('media_gallery', 'social_image', __('Social Images',DEMO_DOMAIN)),
    ))
    ->add_tab(__('Contact',DEMO_DOMAIN), array(
        Field::make('checkbox', 'contact_sec_is_hidden', __('Hide',DEMO_DOMAIN)),
        Field::make('text', 'contact_sec_title', __('Title',DEMO_DOMAIN))->set_width(50),
        Field::make('text', 'contact_sec_form', __('Form ID',DEMO_DOMAIN))->set_width(50),
    ))
    ->add_tab(__('FAQ',DEMO_DOMAIN), array(
        Field::make('checkbox', 'faq_sec_is_hidden', __('Hide',DEMO_DOMAIN)),
        Field::make('text', 'faq_sec_title', __('Title',DEMO_DOMAIN))->set_width(25),
        Field::make('complex', 'faq_sec_question_answer',__('FAQ',DEMO_DOMAIN))
            ->set_layout('tabbed-horizontal')
            ->add_fields(array(
                Field::make('text', 'question', __('Question',DEMO_DOMAIN)),
                Field::make('rich_text', 'answer', __('Answer',DEMO_DOMAIN)),
            )),
    ));