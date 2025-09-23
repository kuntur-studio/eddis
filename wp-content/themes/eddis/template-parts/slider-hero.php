<?php
if (empty($args['options']) || !is_array($args['options'])) {
    return;
}

extract($args['options']);
?>
<section class="owl-carousel owl-theme" id="sliderHero">
    <?php foreach ($slides as $slide): ?>
        <div class="item">
            <?php if (!empty($slide['slide_enable_link']) && !empty($slide['slide_link'])): ?>
                <a href="<?php echo esc_url($slide['slide_link']); ?>">
            <?php endif; ?>

            <picture>
                <source media="(min-width: 1200px)" srcset="<?php echo esc_url($slide['slide_lg']); ?>">
                <source media="(min-width: 768px)" srcset="<?php echo esc_url($slide['slide_md']); ?>">
                <img src="<?php echo esc_url($slide['slide_sm']); ?>" alt="" class="img-fluid">
            </picture>

            <?php if (!empty($slide['slide_enable_link']) && !empty($slide['slide_link'])): ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</section>
