<?php
$sectionTitle = block_value('title');
$sectionContent = block_value('content');
$background_color = block_value("background-color");
$upload_button_icon_id = block_value('upload-button-icon');
$upload_button_icon = wp_get_attachment_image_src($upload_button_icon_id, 'full');
$selected_page = block_value('button-link');
$button_link_type = block_value('button-toggle');

$setEventType = '';
if ($button_link_type == 'internal') {
    $link = get_permalink($selected_page->ID);
} else if ($button_link_type == 'external') {
    $link = block_value('external-button-link');
    $setEventType = 'target="_blank"';
} else if ($button_link_type == 'download') {
    $link = block_value('external-button-link');
    $setEventType = 'download target="_blank"';
}
?>
<div class="module_tabbed body-l alignfull <?php echo $background_color; ?>">
    <div class="grid-wrap">
        <div class="block_head-center text-center">
            <?php if (isset($sectionTitle) && $sectionTitle !== ''): ?>
                <h3><?php echo $sectionTitle; ?></h3><?php endif; ?>
            <?php if (isset($sectionContent) && $sectionContent !== ''): ?>
                <p><?php echo $sectionContent; ?></p><?php endif; ?>
            <?php if (block_value('button-text')) : ?>
                <a href="<?php echo $link; ?>" <?php echo $setEventType; ?>
                   class="btn btn-primary"><?php echo block_value('button-text'); ?>
                    <?php if ($upload_button_icon != 0): ?><img src="<?php echo $upload_button_icon[0]; ?>"
                                                                alt="<?php echo block_value('button-text') . '-icon'; ?>"/><?php endif; ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="wrap_tabs">

            <ul id="tabs-nav">
                <?php if (block_rows('add-tab')) : ?>
                    <?php $k = 0;
                    while (block_rows('add-tab')):
                        block_row('add-tab');
                        $k++;
                        $leaders_tab_title = block_sub_value('leaders-tab-title');
                        ?>

                        <li><a href="#tab<?php echo $k; ?>"><?php echo $leaders_tab_title; ?></a></li>
                    <?php endwhile; endif;
                reset_block_rows('add-tab'); ?>

            </ul>

            <?php if (block_rows('add-tab')) : ?>
                <?php $j = 0;
                while (block_rows('add-tab')):
                    block_row('add-tab');
                    $j++;
                    $leaders_tab_image = block_sub_value('leaders-tab-image');
                    $leaders_add_name = block_sub_value('leaders-add-name');
                    $leaders_add_designation = block_sub_value('leaders-add-designation');
                    $leaders_add_content = block_sub_value('leaders-add-content');
                    ?>
                    <div id="tab<?php echo $j; ?>" class="tab-in tab-content">
                        <div class="img_tab object-fit rounded_30">
                            <?php if (isset($leaders_tab_image) && $leaders_tab_image != 0): ?><img
                                src="<?php block_sub_field('leaders-tab-image') ?>" alt="<?php _e('Tab Image','enhabitTabbedTestimonial');?>"
                                class="tab-img" /><?php endif; ?>
                        </div>
                        <div class="info_tab">
                            <?php if (isset($leaders_add_name) && $leaders_add_name !== ''): ?>
                                <h4><?php echo $leaders_add_name; ?></h4><?php endif; ?>
                            <?php if (isset($leaders_add_designation) && $leaders_add_designation !== ''): ?>
                                <div class="title-sm-bold"><?php echo $leaders_add_designation; ?></div><?php endif; ?>
                            <?php if (isset($leaders_add_content) && $leaders_add_content !== ''): ?>
                                <p><?php echo $leaders_add_content; ?></p><?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; endif;
            reset_block_rows('add-tab'); ?>
        </div>
        <div class="slider_tabs block-tabs">
            <?php if (block_rows('add-tab')) : ?>
                <?php $i = 0;
                while (block_rows('add-tab')): block_row('add-tab');
                    $i++;
                    $leaders_tab_title = block_sub_value('leaders-tab-title');
                    $leaders_tab_image = block_sub_value('leaders-tab-image');
                    $leaders_add_name = block_sub_value('leaders-add-name');
                    $leaders_add_designation = block_sub_value('leaders-add-designation');
                    $leaders_add_content = block_sub_value('leaders-add-content');
                    ?>
                    <div class="tab-in">
                        <input type="radio" <?php if ($i == 1): ?>checked<?php endif; ?> name="tabs"
                               id="tab<?php echo $i; ?>">
                        <?php if (isset($leaders_tab_title) && $leaders_tab_title !== ''): ?><label
                            for="tab<?php echo $i; ?>"><?php echo $leaders_tab_title; ?></label><?php endif; ?>
                        <div id="tab-content<?php echo $i; ?>"
                             class="tab-content <?php if ($i == 1): ?>body-m<?php endif; ?> animated fadeIn">
                            <div class="img_tab object-fit rounded_30">
                                <?php if (isset($leaders_tab_image) && $leaders_tab_image != 0): ?><img
                                    src="<?php block_sub_field('leaders-tab-image') ?>" alt="<?php _e('Tab Image','enhabitTabbedTestimonial');?>"
                                    class="tab-img" /><?php endif; ?>
                            </div>
                            <div class="info_tab">
                                <?php if (isset($leaders_add_name) && $leaders_add_name !== ''): ?>
                                    <h4><?php echo $leaders_add_name; ?></h4><?php endif; ?>
                                <?php if (isset($leaders_add_designation) && $leaders_add_designation !== ''): ?>
                                    <div class="title-sm-bold"><?php echo $leaders_add_designation; ?></div><?php endif; ?>
                                <?php if (isset($leaders_add_content) && $leaders_add_content !== ''): ?>
                                    <p><?php echo $leaders_add_content; ?></p><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; endif;
            reset_block_rows('add-tab'); ?>
        </div>
    </div>
</div>