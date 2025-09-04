<?php
/**
 * Banner de modalidad
 */

if (empty($args['options']) || !is_array($args['options'])) {
    return;
}

extract($args['options']);
?>
    <div class="banner-crop-container">
    <?php
    // Verificar si debemos envolver en un enlace
    $should_wrap_link = $mode_banner_enable_link && !empty($mode_banner_link);
    
    // --- ALTERNATIVA AVANZADA PARA FALLBACK ---
    $fallback_image = !empty($mode_banner_lg) ? $mode_banner_lg : 
                     (!empty($mode_banner_md) ? $mode_banner_md : 
                     (!empty($mode_banner_sm) ? $mode_banner_sm : ''));
    // -----------------------------------------
    
    if ($should_wrap_link) : ?>
        <a href="<?php echo esc_url($mode_banner_link); ?>" id="product-banner-link">
    <?php endif; ?>
    
    <picture id="widget-product-bottom-banner">
        <?php if (!empty($mode_banner_lg)) : ?>
            <source srcset="<?php echo esc_url($mode_banner_lg); ?>" media="(min-width: 1200px)">
        <?php endif; ?>
        <?php if (!empty($mode_banner_md)) : ?>
            <source srcset="<?php echo esc_url($mode_banner_md); ?>" media="(min-width: 768px)">
        <?php endif; ?>
        <?php if (!empty($mode_banner_sm)) : ?>
            <source srcset="<?php echo esc_url($mode_banner_sm); ?>" media="(max-width: 767px)">
        <?php endif; ?>
        <!-- Fallback mejorado (usa lg > md > sm en ese orden) -->
        <img src="<?php echo esc_url($fallback_image); ?>" 
             alt="Banner inferior producto" 
             class="banner-main-image">
    </picture>
    
    <?php if ($should_wrap_link) : ?>
        </a>
    <?php endif; ?>
    </div>