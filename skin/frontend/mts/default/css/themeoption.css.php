<?php
define('MAGENTO_ROOT', (dirname(__FILE__).'/../../../../..'));
$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
require_once $mageFilename;

umask(0);
if ( empty($_GET['store']) ) {
    $_GET['store'] = '';
}
Mage::app( $_GET['store'] );

header("Content-type: text/css; charset: UTF-8");
?>



/* Start primary Color */

    /* color */
        .header-block p span,
        .currency_icon.selected,
        .currency_detail a:hover,
        .language_detail a:hover,
        .header .top-links a:hover,
        .product-name a:hover,
        .featured-block .custom .custom-contain h2,
        .footer-block-contain .custom p span.contact,
        .footer_link .link_box li:hover, .footer_link .link_box li:hover a,
        .default-container #nav li ul li a:hover,
        .default-container #nav li ul li a.over,
        .breadcrumbs li strong,
        .block li a:hover,
        .grid-mode-active,
        .list:hover,
        .sort_detail a:hover,
        .sort_icon.selected,
        .show_detail a:hover,
        .show_icon.selected,
        .list-mode-active,
        .grid:hover,
        .products-list .desc .link-learn,
        .tabs li.active a,
        .tabs li a:hover,
        .product-view .box-reviews dt a,
        .block-progress dt.complete,
        #opc-review .buttons-set p a,
        .sub-title,
        .checkout-progress li.active,
        .multiple-checkout .col2-set h2.legend,
        .multiple-checkout h3, .multiple-checkout h4,
        .multiple-checkout .box h2,
        .block-account .block-content li.current,
        .dashboard .welcome-msg p strong,
        .dashboard .box-content a,
        .addresses-list a,
        .link-print,
        .order-info .current,
        .customized .best_theme h4,
        #opc-login li.control label,
        #sidenav li.active a.level-top,
        div.wp-custom-menu-popup a.itemMenuName:hover, div.wp-custom-menu-popup a.actParent, div.wp-custom-menu-popup a.act,
        div.wp-custom-menu-popup .itemSubMenu a.itemMenuName:hover,
        .currency_pan span.icon-right, .language_pan span.icon-right,
        .show_pan span.icon-right, .sort_pan span.icon-right,
        .block-poll .block-subtitle,
        .my-tag-edit strong,
        .compare-table .btn-remove:hover span,
        .menu_customlinks li a:hover,
        .gift-messages-form h4,
        .col3-set .col-2 p strong,
        .col3-set .col-3 p strong,
        .advanced-search-summary strong,
        .products-grid button span:hover,
        .products-list .list-action button span:hover,
        .product-view .product-shop button.button span:hover
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('primary_color') ?>; }
    /* End color */
    
    /* Background */
        .header .form-search button.button,
        .menu-contain,
        button.button,
        .banner .container a,
        .featured-block .custom .custom-contain a.shop,
        .follow_button a.btn_follow:hover,
        .footer_link .link_box .input-box button.button:hover,
        .scrollup,
        .pager .pages .current,
        .pager .pages li a:hover,
        .product-view .product-shop .add-to-links li a:hover,
        .opc .active .step-title,
        .buttons-set .back-link a,
        .customized .best_theme a span,
        .close_la:hover,
        .dashboard .box-reviews .number,
        .dashboard .box-tags .number,
        .cart .totals .checkout-types button.btn-checkout:hover,
        .compare-table .btn-remove:hover,
        div.alert a:hover,
        div.alert button:hover,
        .fancy.product-view .product-content a.view-detail:hover,
        #sidenav li a.show-cat:hover,
        #sidenav li a.show-cat.active,
        .text-box .go,
        .ui-slider-horizontal .ui-slider-handle,
        .bx-wrapper .bx-controls-direction a:hover,
        .banner .container a,
        .products-grid .actions .add-to-links a:hover,
        .quick-view:hover,
        .products-list .list-action .add-to-links a:hover,
        .detail-carousel .flex-direction-nav a:hover
        {  background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('primary_color') ?>; }
    /* End Background */
    
   
    
    /* Border */
        {  border-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('primary_color') ?>; }
    /* End Border */
    
    /* Top Border */
        
        .checkout-progress li.active
        { border-top-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('primary_color') ?>; }
    /* End Top Border */
    
    /* Left Border */
        
        { border-left-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('primary_color') ?>; }
    /* End Left Border */
    
    /* Right Border */
        
        { border-right-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('primary_color') ?>; }
    /* End Right Border */
    
    /* Bottom Border */
        { border-bottom-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('primary_color') ?>; }
    /* End Bottom Border */
    
/* End primary Color */


/* Start Secondary Color */
    /* Color */
        
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('secondary_color') ?>; }
    /* End Color */
    
    /* Background */
        .header .form-search button.button:hover,
        .shopping_bg,
        div.menu.act a, div.menu.active a, div.menu .parentMenu a:hover,
        .default-container #nav li a.over, .default-container #nav a:hover, .default-container #nav li.level0.active a.level-top,
        .btn-remove:hover, .btn-edit:hover,
        button.button:hover,
        .featured-block .custom .custom-contain a.shop:hover,
        .footer_link .link_box .input-box button.button,
        .scrollup:hover,
        #sidenav li a.show-cat,
        .btn-remove2:hover,
        .cart-table td.a-center.last a.cartedit:hover, .cart-table td.a-center.last a.link-wishlist:hover,
        .buttons-set .back-link a:hover,
        .customized .best_theme a span:hover,
        .close_la,
        .cart .totals .checkout-types button.btn-checkout,
        div.alert,
        .detail-carousel .flex-direction-nav a,
        .menu-contain a span.label,
        .text-box .go:hover,
        .follow_button a.btn_follow,
        .bx-wrapper .bx-controls-direction a,
        .banner .container a:hover,
        #menu-button:hover
        {  background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('secondary_color') ?>; }
    /* End Background */
    
    /* Border */
        {  border-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('secondary_color') ?>; }
    /* End Border */
    
    /* Top Border */
        .menu-contain a span.icon
        { border-top-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('secondary_color') ?>; }
    /* End Top Border */
    
    /* Left Border */
        
        { border-left-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('secondary_color') ?>; }
    /* End Left Border */
    
    /* Right Border */
        .menu-contain ul li ul li a span.icon, .menu-contain .column a span.icon
        { border-right-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('secondary_color') ?>; }
    /* End Right Border */

    /* Bottom Border */
        
        { border-bottom-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('secondary_color') ?>; }
    /* End Bottom Border */
    
     /* Function For Convert RGB To Hex */
                        
                <?php
                function html2rgb($rgb)
                {
                    if ($rgb[0] == '#')
                        $rgb = substr($rgb, 1);
                
                    if (strlen($rgb) == 6)
                        list($r, $g, $b) = array($rgb[0].$rgb[1],
                                                 $rgb[2].$rgb[3],
                                                 $rgb[4].$rgb[5]);
                    elseif (strlen($rgb) == 3)
                        list($r, $g, $b) = array($rgb[0].$rgb[0], $rgb[1].$rgb[1], $rgb[2].$rgb[2]);
                    else
                        return false;
                
                    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
                 
                    return array($r, $g, $b);
                }
                
                
                $hex =  "#".Mage::helper("ExtraConfig")->themeOptions('secondary_color'); 
                $val = html2rgb($hex);
                
                ?>
                        
    /* End Function For Convert RGB To Hex */
    
    /* Transparent */
        .products-grid button span,
        .products-grid button span:hover,
        .products-list .list-action button span,
        .products-list .list-action button span:hover,
        .product-view .product-shop button.button span,
        .product-view .product-shop button.button span:hover
        {background-color: rgba(<?php echo $val[0]; ?>,<?php echo $val[1]; ?>,<?php echo $val[2]; ?>, 0.92);}
    /* Transparent */
    
/* End Secondary Color */

/* Third Color */

    /* Background Color */
        
        .featured-block .custom .custom-contain,
        .breadcrumbs,
        .toolbar,
        .tabs li a,
        .data-table thead th,
        .block-cart .subtotal,
        .cart .discount, .cart .shipping,
        .opc .step-title,
        .sp-methods .form-list,
        .my-account .pager,
        .tags-list,
        .compare-table tbody th,
        .customized,
        .products-grid .product-image,
        .popular-product .products-grid .product-image img,
        .mini-products-list .product-image img,
        .products-list .product-image,
        .data-table td a img,
        .detail-carousel .slides li img,
        .detail-carousel .product-image img,
        .default-noimage li.item img,
        .horizontal-noimage li.item img,
        .vertical-noimage li.item img,
        .noimage li.item img,
        .fancy.product-view a.product-image img,
        .menu-block .menu-block-contain,
        .detail-block .detail-content,
        .cart .totals,
        .gift-messages-form,
        .gift-messages-form .item .product-image img,
        .order-products-table th,
        .product-review .product-img-box .product-image img,
        .page-sitemap .sitemap,
        div.ajaxcartpro_progress,
        div.ajaxcartpro_progress1
        {  background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('third_color') ?>; }
    /* End  Background Color */
    
    /* border */
        { border-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('third_color') ?>; }
    /* End border */
    
    /* Top Border */
        .checkout-progress li
        { border-top-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('third_color') ?>; }
    /* End Top Border */
    
/* End Third Color */

/* Start button color */

    button.button,
    .buttons-set .back-link a,
    .customized .best_theme a span,
    div.alert a,
    .banner .container a,
    .cart .totals .checkout-types button.btn-checkout:hover,
    .header .form-search button.button:hover
    {  background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('buttonaerrow_color') ?>; }

/* End button color */


/*  button hover color */

    button.button:hover,
    .buttons-set .back-link a:hover,
    .customized .best_theme a span:hover,
    div.alert a:hover,
    .banner .container a:hover,
    .cart .totals .checkout-types button.btn-checkout,
    .header .form-search button.button
    {  background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('buttonhover_color') ?>; }

/* End button hover color */


/* border */

    /* border color */
        
        .header_currency:hover .currency_pan,
        .currency_detail,
        .header_language:hover .language_pan,
        .language_detail,
        .header .form-search input.input-text,
        .banner,
        .products-grid .product-content,
        .featured-block.top .custom,
        .popular-product .products-grid .product-image,
        .footer-block,
        .footer_link .link_box .input-box input,
        div.wp-custom-menu-popup,
        .category-block,
        .sort_box:hover .sort_pan,
        .sort_detail,
        .show_box:hover .show_pan,
        .show_detail,
        .pager .pages .current,
        .pager .pages li a,
        input, select, textarea,
        .detail-carousel .slides li,
        #content,
        .data-table,
        .products-list li.item,
        .products-list li.item .list-icon,
        .data-table td a img,
        .cart .discount, .cart .shipping,
        .cart .totals,
        .opc .step-title,
        .multiple-checkout .col2-set, .multiple-checkout .col3-set,
        .checkout-multishipping-shipping .box-sp-methods,
        .sp-methods .form-list,
        .product-review .product-img-box .product-image,
        .mini-products-list .product-image,
        .toptital,
        .menu-block,
        .detail-block,
        .detail-carousel .slides li, .detail-carousel .product-image, .default-noimage li.item, .horizontal-noimage li.item, .vertical-noimage li.item, .noimage li.item,
        .data-table td a.product-image,
        .gift-messages-form .item .product-image,
        .order-products-table,
        div.ajaxcartpro_progress,
        div.ajaxcartpro_progress1,
        .advanced-search-summary,
        .header a.logo,
        top-border
        {  border-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('border_color') ?>; }
    /* End border color */
    
    /* left border color */
        
        .footer-block-contain .custom.block2,
        .tabs li.active a,
        .tabs li a:hover,
        .menu-contain.fixed .logo
        {  border-left-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('border_color') ?>; }
    /* End left border color */
    
     /* right border color */
        
        .footer-block-contain .custom.block2,
        .tabs li.active a,
        .tabs li a:hover
        {  border-right-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('border_color') ?>; }
     /* End right border color */
     
     /* bottom border color */
        .popular-product .products-grid li,
        .footer_link,
        .tabs,
        .data-table thead th,
        .data-table tbody th,
        .data-table td,
        .block-progress dt,
        .sp-methods dt,
        .block-progress dd,
        .mini-products-list li,
        .cart .totals tfoot td,
        .gift-messages h3,
        .gift-messages-form h4,
        .gift-messages-form .item .details .product-name,
        .product-options,
        .order-products-table th,
        .order-products-table tbody th, .order-products-table tbody td,
        .order-products-table tfoot td,
        .onepagecheckout_datafields,
        .block-wishlist .block-content li.item
        {  border-bottom-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('border_color') ?>; }
     /* End bottom border color */
     
     /* End top border color */
        .product-view .product-shop .short-description,
        .product-view .product-shop .add-to-box,
        .buttons-set,
        .cart .shipping .sp-methods,
        .block .actions,
        .cart .totals tfoot td,
        .product-options,
        .menu_customlinks,
        .col1-layout .product-view .custom,
        .tabs li.active a,
        .tabs li a:hover
        {  border-top-color:  #<?php echo Mage::helper("ExtraConfig")->themeOptions('border_color') ?>; }
     /* End top border color */
/* End border */


/* Start Menu */
    /* top Menu background */
        .menu-contain
        {  background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('topmenu_background') ?>; }
    /* End top Menu background */

    /* Menu background */
        #nav ul,
        div.wp-custom-menu-popup
        {  background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('menu_background') ?>; }
    /* End Menu background */
    
    /* Menu top Fonts Color */
        div.menu a,
        .default-container #nav li a
        { color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('topmenu_fonts_color') ?>; }
    /* End top Menu Fonts Color */
    
    /* Menu top Fonts hover Color */
        div.menu a:hover,
        div.menu.act a, div.menu.active a,
        .default-container #nav li a:hover,
        .default-container #nav li.level0.active a.level-top,
        .default-container #nav li a.over
        { color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('topmenu_fontshover_color') ?>; }
    /* End top Menu Fonts hover Color */
    
    /* Menu top Fonts hover bg Color */
        div.menu.act a, div.menu.active a,
        div.menu .parentMenu a:hover,
        .default-container #nav li a.over,
        .default-container #nav a:hover,
        .default-container #nav li.level0.active a.level-top
        { background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('topmenu_fontshover_bg_color') ?>; }
    /* End top Menu Fonts hover bg Color */
    
    /* Menu Fonts Color */
        .default-container #nav li ul li a,
        div.wp-custom-menu-popup a,
        .menu_customlinks li a,
        .menu_customlinks li
        { color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('menu_fonts_color') ?>; }
    /* End Menu Fonts Color */
        
    
    /* Menu Fonts Hover Color */
        .default-container #nav li ul li a:hover,
        .default-container #nav li ul li a.over,
        div.wp-custom-menu-popup a.itemMenuName:hover, div.wp-custom-menu-popup a.actParent, div.wp-custom-menu-popup a.act,
        div.wp-custom-menu-popup .itemSubMenu a.itemMenuName:hover,
        .menu_customlinks li a:hover
        { color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('menu_fontshover_color') ?>; }
    /* End Menu Fonts Hover Color */
    
    /* Menu TopFonts */
        <?php $topmenufont = Mage::helper("ExtraConfig")->themeOptions('topmenu_fonts'); ?>
        <?php if(isset($topmenufont) && $topmenufont != null && $topmenufont != '--select--')   {  ?>
                
                    .default-container #nav li.level0 a.level-top,
                    div.menu a
                    {font-family: '<?php echo $topmenufont; ?>'!important;}
                    
        <?php } ?>
    /* End TopMenu Fonts */
    
    /* Menu Fonts */
        <?php $menufont = Mage::helper("ExtraConfig")->themeOptions('menu_fonts'); ?>
        <?php if(isset($menufont) && $menufont != null && $menufont != '--select--')   {  ?>
                
                    .default-container #nav li ul li a,
                    div.wp-custom-menu-popup a.itemMenuName span,
                    div.wp-custom-menu-popup .itemSubMenu a.itemMenuName span,
                    .menu_customlinks li a,
                    .menu_customlinks li,
                    .menu-block h2,
                    .menu-block p
                    {font-family: '<?php echo $menufont; ?>'!important;}
                    
        <?php } ?>
    /* End Menu Fonts */
    
    /* label color */
        .menu-contain a span.label
        { background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('category_label_color') ?>; }
    /* End label Color */
    
    /* label border top color */
        .menu-contain a span.icon
        { border-top-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('category_label_color') ?>; }
    /* End label border top Color */
    
    /* label border right color */
        .menu-contain ul li ul li a span.icon, .menu-contain .column a span.icon
        { border-right-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('category_label_color') ?>; }
    /* End label border right Color */
    
    /* border color */
        .menu-contain,
        div.menu a,
        .default-container #nav a,
        .shopping_bg,
        .cartlogo,
        div.wp-custom-menu-popup,
        #nav ul,
        .menu-contain.fixed .logo
        { border-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('menu_border_color') ?>; }
    /* End border Color */
    
    /* shoppingbg */
        .shopping_bg
        { background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('shoppingcart_bg_color') ?>; }
    /* End shoppingbg */
    
    /* Menuwidth */
    <?php $menuwidth = Mage::helper("ExtraConfig")->themeOptions('menuwidth'); ?>
    <?php if($menuwidth == 'template') { ?>
        .menu-contain
        {width:1200px; margin:0 auto;  }
    <?php } ?>
    /* End Menuwidth */
    
/* End Menu */


/* Start Sidebar */
    
    /* Sidebar BG Color */
        <?php $sidebar_bg = Mage::helper("ExtraConfig")->themeOptions('sidebar_background_color'); ?>
        <?php if(isset($sidebar_bg) && $sidebar_bg != null){ ?>
            .block{padding:10px;}
        <?php } ?>    
        .block
        {  background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('sidebar_background_color') ?>; }
    /* End Sidebar BG Color */
    
    /* Sidebar Title Font */
        <?php $sidebartitlefont = Mage::helper("ExtraConfig")->themeOptions('sidebar_title_fonts'); ?>
        <?php   if(isset($sidebartitlefont) && $sidebartitlefont != null && $sidebartitlefont != '--select--')   {  ?>
                
                    .block .block-title strong, .block-layered-nav dt {font-family: '<?php echo $sidebartitlefont; ?>';}
                    
        <?php } ?>
    /* End Sidebar Title Font */
    
    /* Sidebar Title Color */
        .block .block-title strong,
        .block-layered-nav dt
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('sidebar_title_fonts_color') ?>; }
    /* End Sidebar Title Color */

    /* Sidebar Fonts Color */
        .block-layered-nav #narrow-by-list dd ol li a,
        .block-category-nav .block-content dd ol li a,
        .block .block-content .product-name a,
        .block-poll .block-subtitle,
        .block-poll label,
        .block-wishlist .block-subtitle,
        .mini-products-list .product-details .price-box .old-price .price,
        .mini-products-list .product-details .price-box .special-price .price,
        .mini-products-list .product-details .price-box .regular-price .price,
        .block-wishlist .link-cart,
        .block-wishlist .actions a,
        .block-subscribe label,
        .block-account .block-content li a,
        .block-reorder .block-subtitle,
        .block .actions a,
        .block-layered-nav .currently .label,
        .block-layered-nav .currently .value,
        .block .empty,
        .block-blog .menu-recent UL LI a,
        .block-blog .menu-categories UL LI a,
        .block-blog .menu-tags UL LI a,
        #sidenav li a,
        .sf-menu a,
        .block .block-content .tags-list li a,
        .block-progress dt,
        .block-progress dd.complete address,
        .block-progress dt.complete,
        .block-progress dt.complete a
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('sidebar_fonts_color') ?>; }
    /* End Sidebar Fonts Color */
    
    /* Sidebar Fonts Hover Color */
        .block-layered-nav #narrow-by-list dd ol li a:hover,
        .block-blog .menu-recent ul li a:hover, .block-blog .menu-categories ul li a:hover, .block-blog .menu-tags ul li a:hover,
        #sidenav li a:hover,
        .block-viewed li a:hover,
        .block-account .block-content li a:hover,
        .sf-menu a:hover,
        .block-compare li .product-name a:hover,
        .block-reorder .block-content li.item:hover,
        .block .block-content .product-name a:hover,
        .block-wishlist .link-cart:hover,
        .block .actions a:hover,
        .block-progress dt.complete a:hover,
        .block-tags .block-content a:hover
        { color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('sidebar_linkhover_color') ?>; }
    /* End Sidebar Fonts Hover Color */
    
    /* Sidebar Seperator Color */
        .block .actions,
        .block-wishlist .block-content li.item,
        .block-progress dt
        {  border-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('sidebar_seperator_color') ?>; }
    /* End Sidebar Seperator Color */
    
/* End Sidebar */

/* Start Header */
    /* Header BG */
    <?php
    $headerbg_color = Mage::helper("ExtraConfig")->themeOptions('headerbg_color');
    $headerbg_pattern = Mage::helper("ExtraConfig")->themeOptions('headerbg_pattern');
    $headerbg_image = Mage::helper("ExtraConfig")->themeOptions('headerbg_image');
    ?>
    
    <?php if(isset($headerbg_color) && $headerbg_color != null){  ?>
                
                            .header-container
                            {
                                  background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('headerbg_color') ?>; 
                            }
                            
                <?php } elseif(isset($headerbg_pattern) && $headerbg_pattern != null) { ?>
                    
                            .header-container
                            {
                                background-image: url(<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'pattern/'.Mage::helper("ExtraConfig")->themeOptions('headerbg_pattern') ?>);
                            }    
                    
                <?php }	elseif(isset($headerbg_image) && $headerbg_image != null) { ?>
                    
                            .header-container           
                            {
                                    background-image: url(<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'custom/image/'.Mage::helper("ExtraConfig")->themeOptions('headerbg_image') ?>);
                                    background-attachment: <?php echo Mage::helper("ExtraConfig")->themeOptions('headerbg_attachment') ?>;
                                     background-position: <?php echo Mage::helper("ExtraConfig")->themeOptions('headerbg_position_y') ?> <?php echo Mage::helper("ExtraConfig")->themeOptions('headerbg_position_x') ?>;
                                    background-repeat: <?php echo Mage::helper("ExtraConfig")->themeOptions('headerbg_repeat') ?>;
                                    
                                    <?php if (Mage::helper("ExtraConfig")->themeOptions('headerbg_attachment') == 'fixed')
                                        {
                                    ?>
                                        background-size: 100%;
                                    <?php	} ?>
                            }    
                    
    <?php } else{} ?>
    /* End Header BG */
    
    /* Header Font Color */
        .header_currency label,
        .header .top-links a,
        .header-block p,
        .currency_pan span,
        .language_pan span,
        .currency_detail a,
        .language_detail a,
        .header .form-search input.input-text
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('header_font_color') ?>; }
    /* End Header Font Color */
    
    /* Header Font Hover Color */
        .header-block p span,
        .currency_detail a:hover,
        .currency_icon.selected,
        .language_detail a:hover,
        .header .top-links a:hover,
        .currency_pan span.icon-right, .language_pan span.icon-right
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('header_fonthover_color') ?>; }
    /* End Header Font Hover Color */
    
/* End Header */

/* Banner */
    /* border */
        <?php $banner_border = Mage::helper("ExtraConfig")->themeOptions('banner_border');
        if($banner_border == '0'){ ?>
            .banner{border:1px solid transparent;}
        <?php } ?>
    /* End border */
    
    /* Banner Title Color */
        .banner .container h2
        {color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('banner_title_color') ?>;}
    /* End Banner Title Color */
    
    /* Banner Title Color */
        .banner .container p
        {color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('banner_content_color') ?>;}
    /* End Banner Title Color */
    
    /* Banner Title size */
        .banner .container h2
        {font-size: <?php echo Mage::helper("ExtraConfig")->themeOptions('banner_title_fontsize') ?>px;}
    /* End Banner Title size */
/* End Banner */

/* Start Footer */
    <?php
    $footer_background_color = Mage::helper("ExtraConfig")->themeOptions('footer_background_color');
    $footer_background_pattern = Mage::helper("ExtraConfig")->themeOptions('footer_background_pattern');
    $footer_background_image = Mage::helper("ExtraConfig")->themeOptions('footer_background_image');
    ?>
    
    <?php if(isset($footer_background_color) && $footer_background_color != null) {  ?>
            
            
                   .footer-container
                    {
                          background-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('footer_background_color') ?>; 
                    }
                    
            <?php } elseif(isset($footer_background_pattern) && $footer_background_pattern != null) { ?>
            
                    .footer-container
                    {
                        background-image: url(<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'pattern/'.Mage::helper("ExtraConfig")->themeOptions('footer_background_pattern') ?>);
                    }
                    
            <?php } elseif(isset($footer_background_image) && $footer_background_image != null) { ?>
            
                    .footer-container          
                    {
                            background-image: url(<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'custom/image/'.Mage::helper("ExtraConfig")->themeOptions('footer_background_image') ?>);
                            background-attachment: <?php echo Mage::helper("ExtraConfig")->themeOptions('footer_background_attachment') ?>;
                             background-position: <?php echo Mage::helper("ExtraConfig")->themeOptions('footer_background_position_y') ?> <?php echo Mage::helper("ExtraConfig")->themeOptions('footer_background_position_x') ?>;
                            background-repeat: <?php echo Mage::helper("ExtraConfig")->themeOptions('footer_background_repeat') ?>;
                            
                            <?php if (Mage::helper("ExtraConfig")->themeOptions('footer_background_attachment') == 'fixed')
				{
                            ?>
				background-size: 100%;
                            <?php	} ?>
                    }    
            
    <?php } else{} ?>
    
    /* Footer Font Color */
        .footer address,
        .footer_link .link_box h2,
        .footer-payment .follow_us h2
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('footer_font_color') ?>; }
    /* End Footer Font Color */
    
    /* Footer Link Color */
        
        .footer_link .link_box li a,
        .footer_link .link_box li,
        .footer .footer_location p
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('footer_link_font_color') ?>; }
    /* End Footer Link Color */

    /* Footer Linkhover Color */
        .footer_link .link_box li a:hover,
        .footer_link .link_box li:hover, .footer_link .link_box li:hover a
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('footer_linkhover_font_color') ?>; }
    /* End Footer Linkhover Color */
    
    /* Footer border Color */
        .footer_link,
        .footer_link .link_box h2
        {  border-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('footer_border_color') ?>; }
    /* End border Color */
    
    /* Footer topblock bg Color */
        .footer-block
        {  background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('footer_topblock_bg') ?>; }
    /* End Footer topblock bg Color */
    
    /* Footer topblock boder Color */
        .footer-block,
        .footer-block-contain .custom.block2
        {  border-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('footer_topblock_border') ?>; }
    /* End Footer topblock border Color */
/* End Footer */


/* product list */
    /* Product BG */
        .products-grid .product-content,
        .detail-carousel .slides li,
        .detail-carousel .product-image,
        .default-noimage li.item,
        .horizontal-noimage li.item,
        .vertical-noimage li.item,
        .noimage li.item,
        .popular-product .products-grid .product-image,
        .mini-products-list .product-image,
        .products-list li.item .list-icon,
        .data-table td a.product-image,
        .fancy.product-view a.product-image,
        .gift-messages-form .item .product-image,
        .product-review .product-img-box .product-image
        {  background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('product_bg') ?>; }
    /* End Product BG */
    
    /* Latest Product BG */
        .new-arrival .products-grid .actions1
        {  background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('latestproduct_bg') ?>; }
    /* End Latest Product BG */
    
    /* Product Border */
        .products-grid .product-content,
        .detail-carousel .slides li,
        .detail-carousel .product-image,
        .default-noimage li.item,
        .horizontal-noimage li.item,
        .vertical-noimage li.item,
        .noimage li.item,
        .popular-product .products-grid .product-image,
        .mini-products-list .product-image,
        .products-list li.item .list-icon,
        .data-table td a.product-image,
        .fancy.product-view a.product-image,
        .gift-messages-form .item .product-image,
        .product-review .product-img-box .product-image
        {  border-color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('product_border') ?>; }
    /* End Product Border */
    
    /* Show border */
        <?php $show_border = Mage::helper("ExtraConfig")->themeOptions('show_border');
        if($show_border == '0'){ ?>
            .products-grid .product-content,
        .detail-carousel .slides li,
        .detail-carousel .product-image,
        .default-noimage li.item,
        .horizontal-noimage li.item,
        .vertical-noimage li.item,
        .noimage li.item,
        .popular-product .products-grid .product-image,
        .mini-products-list .product-image,
        .products-list li.item .list-icon,
        .data-table td a.product-image,
        .fancy.product-view a.product-image,
        .gift-messages-form .item .product-image,
        .product-review .product-img-box .product-image
        {border:1px solid transparent;}
        <?php } ?>
    /* End Show border */
    
    /* Product Image BG */
        .products-grid .product-image,
        .popular-product .products-grid .product-image img,
        .mini-products-list .product-image img,
        .products-list .product-image,
        .data-table td a img,
        .detail-carousel .slides li img,
        .detail-carousel .product-image img,
        .default-noimage li.item img,
        .horizontal-noimage li.item img,
        .vertical-noimage li.item img,
        .noimage li.item img,
        .fancy.product-view a.product-image img,
        .gift-messages-form .item .product-image img,
        .product-review .product-img-box .product-image img
        {  background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('product_image_bg') ?>; }
    /* End Product Image BG */
    
    /* Product Image */
        <?php
        $productimage = Mage::helper("ExtraConfig")->themeOptions('productimage');
        if($productimage == '0') { ?>
            .products-grid li.item:hover img.small-image{top:0px;}
            .products-grid .product-image img.thumbnail{display:none;}
        <?php } ?>
    /* End Product Image */
    
    /* Product Content */
        <?php
        $productcontent = Mage::helper("ExtraConfig")->themeOptions('productcontent');
        if($productcontent == '1') { ?>
            .products-grid .productgrid-area{bottom:0px;}
        <?php } ?>
    /* End Product Content */
    
    /* AddtoCart button background */
        .products-grid button span,
        .products-list .list-action button span,
        .product-view .product-shop button.button span,
        button.btn-cart
        {  background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('addtocart_bg') ?>; }
    /* End AddtoCart button background */
    
    /* AddtoCart button color */
        .products-grid button span,
        .products-list .list-action button span,
        .product-view .product-shop button.button span,
        button.btn-cart
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('addtocart_color') ?>; }
    /* End AddtoCart button color */
    
    /* AddtoCart button hover bg */
        .products-grid button span:hover,
        .products-list .list-action button span:hover,
        .product-view .product-shop button.button span:hover,
        button.btn-cart:hover
        {   background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('addtocart_hover_bg') ?>; }
    /* End AddtoCart button hover bg */
    
    /* AddtoCart button hover color */
        .products-grid button:hover span,
        .products-list .list-action button:hover span,
        .product-view .product-shop button.button:hover span,
        button.btn-cart:hover
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('addtocart_hover_color') ?>; }
    /* End AddtoCart button hover color */
    
    /* Product name/price color */
        .product-name a,
        .product-name ,
        .price-box .price
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('productname_color') ?>; }
    /* End Product name/price color */
    
    /* Product name hover color */
        
        .product-name a:hover
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('productname_hover_color') ?>; }
    /* End Product name hover color */
    
    /* Quickview button bg */
        .quick-view
        {   background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('quickview_bg_color') ?>; }
    /* End Quickview button bg */
    
    /* Quickview button hover bg */
        .quick-view:hover
        {   background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('quickview_hover_bg_color') ?>; }
    /* End Quickview button hover bg */
    
    <?php
    $buttonfont = Mage::helper("ExtraConfig")->themeOptions('button_fonts');
    $productnamefont = Mage::helper("ExtraConfig")->themeOptions('productname_fonts');
    ?>
    
    /* button font */
        <?php if(isset($buttonfont) && $buttonfont != null && $buttonfont != '--select--')  {  ?>
                   
                    button.btn-cart,
                    .price-box .price,
                    .products-list .list-action button.availability,
                    .products-grid button.availability
                    {font-family: '<?php echo $buttonfont; ?>';}
                
        <?php } ?>
    /* end button font */
    
    /* productname font */
        <?php if(isset($productnamefont) && $productnamefont != null && $productnamefont != '--select--')  {  ?>
                   
                    .product-name a,
                    .product-name
                    {font-family: '<?php echo $productnamefont; ?>';}
                
        <?php } ?>
    /* end productname font */
    
    /* AjaxPopup */
        <?php $ajaxpopup = Mage::helper("ExtraConfig")->themeOptions('ajaxpopup');
        if($ajaxpopup == '0'){ ?>
        .alert{display: none !important;}
        <?php } ?>
    /* End AjaxPopup */
    
/* end product list */


/* start Background Option */

<?php
$background_color = Mage::helper("ExtraConfig")->themeOptions('background_color');
$background_pattern = Mage::helper("ExtraConfig")->themeOptions('background_pattern');
$background_image = Mage::helper("ExtraConfig")->themeOptions('background_image');
?>

 <?php  if(isset($background_color) && $background_color != null) {  ?>
		
            body
                {
                    background-color:#<?php echo Mage::helper("ExtraConfig")->themeOptions('background_color') ?>;
                }
            .tabs li.active a,
            .tabs li a:hover
            {
            border-bottom-color:#<?php echo Mage::helper("ExtraConfig")->themeOptions('background_color') ?>;
            }
<?php	}  elseif(isset($background_pattern) && $background_pattern != null){ ?>
        
            body
                {
                    background-image: url(<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'pattern/'.Mage::helper("ExtraConfig")->themeOptions('background_pattern') ?>);
                }    
<?php   } elseif(isset($background_image) && $background_image != null){ ?>

                body            
                {
                        background-image: url(<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'custom/image/'.Mage::helper("ExtraConfig")->themeOptions('background_image') ?>);
                        background-attachment: <?php echo Mage::helper("ExtraConfig")->themeOptions('bg_attachment') ?>;
                         background-position: <?php echo Mage::helper("ExtraConfig")->themeOptions('bg_position_y') ?> <?php echo Mage::helper("ExtraConfig")->themeOptions('bg_position_x') ?>;
                        background-repeat: <?php echo Mage::helper("ExtraConfig")->themeOptions('bg_repeat') ?>;
			
			<?php if (Mage::helper("ExtraConfig")->themeOptions('bg_attachment') == 'fixed')
				{
			?>
				background-size: 100%;
			<?php	} ?>
			
                }    
        
<?php   } else { } ?>

/* End Background Option */


/* Theme Fonts Settings */

    <?php
    $titlefont = Mage::helper("ExtraConfig")->themeOptions('titlefont');
    $bodyfont = Mage::helper("ExtraConfig")->themeOptions('bodyfont');
    ?>
    
    /* Title font */
        <?php if(isset($titlefont) && $titlefont != null && $titlefont != '--select--')  {  ?>
                   
                    .page-title h1,
                    .page-title h2,
                    .new-arrow1 .subtitle, .new-arrow .subtitle,
                    .product-essential h1
                    {font-family: '<?php echo $titlefont; ?>';}
                
        <?php } ?>
    /* end Title font */
    
    /* Title color */
        .page-title h1,
        .page-title h2,
        .new-arrow1 .subtitle, .new-arrow .subtitle,
        .product-essential h1
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('titlefont_color') ?>; }
    /* End Title color */
    
    /* Title Font size */
        .page-title h1,
        .page-title h2,
        .new-arrow1 .subtitle, .new-arrow .subtitle,
        .product-essential h1
        {  font-size: <?php echo Mage::helper("ExtraConfig")->themeOptions('titlefont_size') ?>px; }
    /* End Title Font size */
    
    /* Body font */	
        <?php if(isset($bodyfont) && $bodyfont != null && $bodyfont != '--select--')  {  ?>
            
                    body,
                    a,
                    input, select, textarea,
                    .validation-advice span,
                    .breadcrumbs li strong,
                    .link-print span,
                    .header .form-search .search-autocomplete li,
                    div.wp-custom-menu-popup .itemSubMenu a.itemMenuName span,
                    .block-account .block-content li strong,
                    .block-related .block-title strong,
                    .compare-table .btn-remove span,
                    .menu-contain a span.label,
                    .footer_link .link_box li a,
                    .tooltip
                    {font-family: '<?php echo $bodyfont; ?>';}
                
        <?php } ?>	
    /* End Body font */
    
    /* Body font Color */
        body,
        a,
        input, select, textarea,
        .toggleMenu span,
        .header .form-language label,
        .block li a,
        .compare-table .btn-remove span,
        .featured-block .custom .custom-contain h2.off,
        .products-list .add-to-links .separator,
        .product-view .product-shop .add-to-links li .separator,
        .multiple-checkout .gift-messages h3,
        .default-container #nav li ul li a
        {  color: #<?php echo Mage::helper("ExtraConfig")->themeOptions('bodyfont_color') ?>; }
    /* End Body font Color */
    
    /* Body font size */
        body,
        a,
        input, select, textarea
        {  font-size: <?php echo Mage::helper("ExtraConfig")->themeOptions('bodyfont_size') ?>px; }
    /* End Body font size */
    
/* End Theme Fonts Settings */


/* sticky header */

<?php $sticky_header = Mage::helper("ExtraConfig")->themeOptions('sticky_header'); ?>
<?php if($sticky_header == '0' || Mage::helper("ExtraConfig")->is_mobile() == true) { ?>
    .menu-contain.fixed{position: inherit;}
<?php } ?>

/* End sticky header */

/* boxlayout */

<?php $boxlayout = Mage::helper("ExtraConfig")->themeOptions('boxlayout'); ?>
<?php if($boxlayout == '1') { ?>
    .page {width:1220px; margin: 0 auto; max-width: 100%; box-shadow: 4px 0px 6px -4px rgba(0, 0, 0, 0.25), -4px 0px 6px -4px rgba(0, 0, 0, 0.25);}
    .page{  background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('boxlayout_bg') ?>; }
    <?php if($menuwidth == 'full') { ?>
        .menu-contain.fixed{width:1220px; margin: 0 auto;}
    <?php } ?>
    .tabs li.active a,
    .tabs li a:hover
        {
        border-bottom-color:#<?php echo Mage::helper("ExtraConfig")->themeOptions('boxlayout_bg') ?>;
        }
<?php } ?>

<?php if($boxlayout == '2') { ?>
    .page {width:1220px; margin: 0 auto; max-width: 100%;}
    .page{  background: #<?php echo Mage::helper("ExtraConfig")->themeOptions('boxlayout_bg') ?>; }
    <?php if($menuwidth == 'full') { ?>
        .menu-contain.fixed{width:1220px; margin: 0 auto;}
    <?php } ?>
    .tabs li.active a,
    .tabs li a:hover
        {
        border-bottom-color:#<?php echo Mage::helper("ExtraConfig")->themeOptions('boxlayout_bg') ?>;
        }
<?php } ?>

/* End boxlayout */

/* Customcss */
    <?php echo Mage::helper("ExtraConfig")->themeOptions('customcss'); ?>
/* End Customcss */

/* Zoom */
<?php if(Mage::helper("ExtraConfig")->is_mobile() == true) { ?>
.cloud-zoom-lens,
.cloud-zoom-big{display: none !important;}
<?php } ?>
/* End Zoom */
