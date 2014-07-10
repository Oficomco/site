<?php 
class ThemeOptions_ExtraConfig_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    function is_mobile()
    {
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	$mobiles = array("android", "iphone", "ipod", "ipad",
		"blackberry", "palm", "mobile", "mini", "kindle");
	foreach($mobiles as $mobile)
	{
		if(strpos($ua,$mobile)) return true;
	}
	return false;
    }
    
    function jsString($str='')
    { 
        return trim(preg_replace("/('|\"|\r?\n)/", '', $str)); 
    }
    
    function themeOptions ($themeOption)
    {
	switch ($themeOption)
	{
            
        /* background color and Pattern */
	    
	    
	    case 'background_pattern':
		return Mage::getStoreConfig('mygeneral/background/background_pattern', Mage::app()->getStore()->getId());
	    break; 
	    case 'background_color':
		return Mage::getStoreConfig('mygeneral/background/background_color', Mage::app()->getStore()->getId());
	    break;
	    case 'background_image':
		return Mage::getStoreConfig('mygeneral/background/background_image', Mage::app()->getStore()->getId());
	    break;
	    case 'bg_repeat':
		return Mage::getStoreConfig('mygeneral/background/bg_repeat', Mage::app()->getStore()->getId());
	    break;  
	    case 'bg_attachment':
		return Mage::getStoreConfig('mygeneral/background/bg_attachment', Mage::app()->getStore()->getId());
	    break;  
	    case 'bg_position_x':
		return Mage::getStoreConfig('mygeneral/background/bg_position_x', Mage::app()->getStore()->getId());
	    break; 
	    case 'bg_position_y':
		return Mage::getStoreConfig('mygeneral/background/bg_position_y', Mage::app()->getStore()->getId());
	    break;   
	
            
         /* PRODUCT LIST */
     
	    case 'productlayout':
		return Mage::getStoreConfig('mygeneral/product_list/productlayout');
	    break;
	    case 'ajaxcart':
                return Mage::getStoreConfig('mygeneral/product_list/ajaxcart');
             break;
	     case 'ajaxpopup':
                return Mage::getStoreConfig('mygeneral/product_list/ajaxpopup');
             break;
	     case 'newsaleicon':
                return Mage::getStoreConfig('mygeneral/product_list/newsaleicon');
             break;
	    case 'product_border':
                return Mage::getStoreConfig('mygeneral/product_list/product_border');
             break;
	    case 'show_border':
                return Mage::getStoreConfig('mygeneral/product_list/show_border');
             break;
	     case 'product_bg':
                return Mage::getStoreConfig('mygeneral/product_list/product_bg');
             break;
	    case 'product_image_bg':
                return Mage::getStoreConfig('mygeneral/product_list/product_image_bg');
             break;
	    case 'latestproduct_bg':
                return Mage::getStoreConfig('mygeneral/product_list/latestproduct_bg');
             break;
	    case 'homeproduct':
                return Mage::getStoreConfig('mygeneral/product_list/homeproduct');
             break;
	    case 'productimage':
                return Mage::getStoreConfig('mygeneral/product_list/productimage');
             break;
	    case 'productcontent':
                return Mage::getStoreConfig('mygeneral/product_list/productcontent');
             break;
	    
	    case 'addtocart_bg':
                return Mage::getStoreConfig('mygeneral/product_list/addtocart_bg');
             break;
	    case 'addtocart_color':
                return Mage::getStoreConfig('mygeneral/product_list/addtocart_color');
             break;
	    case 'addtocart_hover_bg':
                return Mage::getStoreConfig('mygeneral/product_list/addtocart_hover_bg');
             break;
	    case 'addtocart_hover_color':
                return Mage::getStoreConfig('mygeneral/product_list/addtocart_hover_color');
             break;
	    case 'button_fonts':
                return Mage::getStoreConfig('mygeneral/product_list/button_fonts');
             break;
	    case 'productname_color':
                return Mage::getStoreConfig('mygeneral/product_list/productname_color');
             break;
	    case 'productname_hover_color':
                return Mage::getStoreConfig('mygeneral/product_list/productname_hover_color');
             break;
	    case 'productname_fonts':
                return Mage::getStoreConfig('mygeneral/product_list/productname_fonts');
             break;
	    case 'quickview_bg_color':
                return Mage::getStoreConfig('mygeneral/product_list/quickview_bg_color');
             break;
	    case 'quickview_hover_bg_color':
                return Mage::getStoreConfig('mygeneral/product_list/quickview_hover_bg_color');
             break;
	    case 'sharingicon':
                return Mage::getStoreConfig('mygeneral/product_list/sharingicon');
             break;
	    case 'brandlogo':
                return Mage::getStoreConfig('mygeneral/product_list/brandlogo');
             break;
	   
	    
            /* COLORS */
            
            case 'primary_color':
                return Mage::getStoreConfig('mygeneral/colors/primary_color');
             break;
	     case 'secondary_color':
                return Mage::getStoreConfig('mygeneral/colors/secondary_color');
             break;
	     case 'third_color':
                return Mage::getStoreConfig('mygeneral/colors/third_color');
             break;
	     case 'buttonaerrow_color':
                return Mage::getStoreConfig('mygeneral/colors/buttonaerrow_color');
             break;
	     case 'buttonhover_color':
                return Mage::getStoreConfig('mygeneral/colors/buttonhover_color');
             break;
	     case 'border_color':
                return Mage::getStoreConfig('mygeneral/colors/border_color');
             break;
	

	
	/* Menu */
            
	    case 'topmenu_background':
                return Mage::getStoreConfig('mygeneral/menu/topmenu_background');
             break;
            case 'menu_background':
                return Mage::getStoreConfig('mygeneral/menu/menu_background');
             break;
	     case 'topmenu_fonts':
                return Mage::getStoreConfig('mygeneral/menu/topmenu_fonts');
             break;
	     case 'menu_fonts':
                return Mage::getStoreConfig('mygeneral/menu/menu_fonts');
             break;
	    case 'topmenu_fonts_color':
                return Mage::getStoreConfig('mygeneral/menu/topmenu_fonts_color');
             break;
	    case 'topmenu_fontshover_color':
                return Mage::getStoreConfig('mygeneral/menu/topmenu_fontshover_color');
             break;
	    case 'topmenu_fontshover_bg_color':
                return Mage::getStoreConfig('mygeneral/menu/topmenu_fontshover_bg_color');
             break;
	     case 'menu_fonts_color':
                return Mage::getStoreConfig('mygeneral/menu/menu_fonts_color');
             break;
	     case 'menu_fontshover_color':
                return Mage::getStoreConfig('mygeneral/menu/menu_fontshover_color');
             break;
	    case 'category_label_color':
                return Mage::getStoreConfig('mygeneral/menu/category_label_color');
             break;
	    case 'menu_border_color':
                return Mage::getStoreConfig('mygeneral/menu/menu_border_color');
             break;
	    case 'shoppingcart_bg_color':
                return Mage::getStoreConfig('mygeneral/menu/shoppingcart_bg_color');
             break;
	     case 'homelink':
                return Mage::getStoreConfig('mygeneral/menu/homelink');
             break;
	    case 'menuwidth':
                return Mage::getStoreConfig('mygeneral/menu/menuwidth');
             break;
	     
	     
	
	/* Sidebar */
            
            case 'sidebar_background_color':
                return Mage::getStoreConfig('mygeneral/sidebar/sidebar_background_color');
             break;
	     case 'sidebar_title_fonts':
                return Mage::getStoreConfig('mygeneral/sidebar/sidebar_title_fonts');
             break;
	     case 'sidebar_title_fonts_color':
                return Mage::getStoreConfig('mygeneral/sidebar/sidebar_title_fonts_color');
             break;
	     case 'sidebar_linkhover_color':
                return Mage::getStoreConfig('mygeneral/sidebar/sidebar_linkhover_color');
             break;
	     case 'sidebar_fonts_color':
                return Mage::getStoreConfig('mygeneral/sidebar/sidebar_fonts_color');
             break;
	     case 'sidebar_seperator_color':
                return Mage::getStoreConfig('mygeneral/sidebar/sidebar_seperator_color');
             break;
	
	
	/* header */
        
	     
	    case 'headerbg_color':
                return Mage::getStoreConfig('mygeneral/header/headerbg_color');
             break;
	    case 'headerbg_pattern':
                return Mage::getStoreConfig('mygeneral/header/headerbg_pattern');
             break;
	    case 'headerbg_image':
                return Mage::getStoreConfig('mygeneral/header/headerbg_image');
             break;
	    case 'headerbg_repeat':
		return Mage::getStoreConfig('mygeneral/header/headerbg_repeat');
	    break;  
	    case 'headerbg_attachment':
		return Mage::getStoreConfig('mygeneral/header/headerbg_attachment');
	    break;  
	    case 'headerbg_position_x':
		return Mage::getStoreConfig('mygeneral/header/headerbg_position_x');
	    break; 
	    case 'headerbg_position_y':
		return Mage::getStoreConfig('mygeneral/header/headerbg_position_y');
	    break;
	    case 'header_font_color':
                return Mage::getStoreConfig('mygeneral/header/header_font_color');
             break;
	    case 'header_fonthover_color':
                return Mage::getStoreConfig('mygeneral/header/header_fonthover_color');
             break;
	    case 'sticky_header':
                return Mage::getStoreConfig('mygeneral/header/sticky_header');
             break;
	    
	    
	/* Banner */
	
	    case 'banner_border':
                return Mage::getStoreConfig('mygeneral/banner/banner_border');
            break;
	    case 'banner_title_color':
                return Mage::getStoreConfig('mygeneral/banner/banner_title_color');
            break;
	    case 'banner_title_fontsize':
                return Mage::getStoreConfig('mygeneral/banner/banner_title_fontsize');
            break;
	    case 'banner_content_color':
                return Mage::getStoreConfig('mygeneral/banner/banner_content_color');
            break;
            
        
	    
	/* footer */
            case 'footer_background_color':
		return Mage::getStoreConfig('mygeneral/footer/footer_background_color');
	     break;
	    case 'footer_background_pattern':
		return Mage::getStoreConfig('mygeneral/footer/footer_background_pattern');
	     break;
	     case 'footer_background_image':
		return Mage::getStoreConfig('mygeneral/footer/footer_background_image');
	     break;
	     case 'footer_background_repeat':
		return Mage::getStoreConfig('mygeneral/footer/footer_background_repeat');
	     break;
	     case 'footer_background_attachment':
		return Mage::getStoreConfig('mygeneral/footer/footer_background_attachment');
	     break;
	     case 'footer_background_position_x':
		return Mage::getStoreConfig('mygeneral/footer/footer_background_position_x');
	     break;
	     case 'footer_background_position_y':
		return Mage::getStoreConfig('mygeneral/footer/footer_background_position_y');
	     break;
            case 'footer_font_color':
                return Mage::getStoreConfig('mygeneral/footer/footer_font_color');
             break;
	     case 'footer_link_font_color':
                return Mage::getStoreConfig('mygeneral/footer/footer_link_font_color');
             break;
	     case 'footer_linkhover_font_color':
                return Mage::getStoreConfig('mygeneral/footer/footer_linkhover_font_color');
             break;
	     case 'footer_border_color':
                return Mage::getStoreConfig('mygeneral/footer/footer_border_color');
             break;
	    case 'footer_topblock_bg':
                return Mage::getStoreConfig('mygeneral/footer/footer_topblock_bg');
             break;
	    case 'footer_topblock_border':
                return Mage::getStoreConfig('mygeneral/footer/footer_topblock_border');
             break;
	
	/* Category */
		
	    case 'displaycategorysidebar':
                return Mage::getStoreConfig('mygeneral/category/displaycategorysidebar');
             break;
	    case 'sidebarmenu':
                return Mage::getStoreConfig('mygeneral/category/sidebarmenu');
             break;
	
	
	/*  Extra settings */
	
	     case 'backtotop':
                return Mage::getStoreConfig('mygeneral/extra_settings/backtotop');
             break;
	     case 'instock':
                return Mage::getStoreConfig('mygeneral/extra_settings/instock');
             break;
	     case 'responsiveness':
                return Mage::getStoreConfig('mygeneral/extra_settings/responsiveness');
             break;
	    case 'boxlayout':
                return Mage::getStoreConfig('mygeneral/extra_settings/boxlayout');
             break;
	    case 'boxlayout_bg':
                return Mage::getStoreConfig('mygeneral/extra_settings/boxlayout_bg');
             break;
	    case 'animation':
                return Mage::getStoreConfig('mygeneral/extra_settings/animation');
             break;
	    case 'customcss':
                return Mage::getStoreConfig('mygeneral/extra_settings/customcss');
             break;
            
	     
	    
	
	/* Theme Fonts Setting */
		
	     case 'titlefont_color':
                return Mage::getStoreConfig('mygeneral/themefont/titlefont_color');
             break;
	     case 'titlefont_size':
                return Mage::getStoreConfig('mygeneral/themefont/titlefont_size');
             break;
	     case 'titlefont':
                return Mage::getStoreConfig('mygeneral/themefont/titlefont');
             break;
	     case 'bodyfont_color':
                return Mage::getStoreConfig('mygeneral/themefont/bodyfont_color');
             break;
	     case 'bodyfont_size':
                return Mage::getStoreConfig('mygeneral/themefont/bodyfont_size');
             break;
	     case 'bodyfont':
                return Mage::getStoreConfig('mygeneral/themefont/bodyfont');
             break;
	     
	    
		
	}
    }
    
    
    
}
?>