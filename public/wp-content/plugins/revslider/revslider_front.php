<?php

	class RevSliderFront extends UniteBaseFrontClassRev{
		
		/**
		 * 
		 * the constructor
		 */
		public function __construct($mainFilepath){
			
			parent::__construct($mainFilepath,$this);
			
			//set table names
			GlobalsRevSlider::$table_sliders = self::$table_prefix.GlobalsRevSlider::TABLE_SLIDERS_NAME;
			GlobalsRevSlider::$table_slides = self::$table_prefix.GlobalsRevSlider::TABLE_SLIDES_NAME;
			GlobalsRevSlider::$table_static_slides = self::$table_prefix.GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME;
			GlobalsRevSlider::$table_settings = self::$table_prefix.GlobalsRevSlider::TABLE_SETTINGS_NAME;
			GlobalsRevSlider::$table_css = self::$table_prefix.GlobalsRevSlider::TABLE_CSS_NAME;
			GlobalsRevSlider::$table_layer_anims = self::$table_prefix.GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME;
			
			UniteBaseClassRev::addAction('wp_enqueue_scripts', 'enqueue_styles');
			
		}
		
		
		/**
		 * 
		 * a must function. you can not use it, but the function must stay there!.
		 *   
		 */		
		public static function onAddScripts(){
			
			$operations = new RevOperations();
			$arrValues = $operations->getGeneralSettingsValues();
			
			$includesGlobally = UniteFunctionsRev::getVal($arrValues, "includes_globally","on");
			$includesFooter = UniteFunctionsRev::getVal($arrValues, "js_to_footer","off");
			$strPutIn = UniteFunctionsRev::getVal($arrValues, "pages_for_includes");
			$isPutIn = RevSliderOutput::isPutIn($strPutIn,true);
			
			//put the includes only on pages with active widget or shortcode
			// if the put in match, then include them always (ignore this if)			
			if($isPutIn == false && $includesGlobally == "off"){
				$isWidgetActive = is_active_widget( false, false, "rev-slider-widget", true );
				$hasShortcode = UniteFunctionsWPRev::hasShortcode("rev_slider");
				
				if($isWidgetActive == false && $hasShortcode == false)
					return(false);
			}
			
			self::addStyle("settings","rs-plugin-settings","rs-plugin/css");
			
			
			$db = new UniteDBRev();
			
			$styles = $db->fetch(GlobalsRevSlider::$table_css);
			$styles = UniteCssParserRev::parseDbArrayToCss($styles, "\n");
			wp_add_inline_style( 'rs-plugin-settings', $styles );

			
			$custom_css = RevOperations::getStaticCss();
			wp_add_inline_style( 'rs-plugin-settings', $custom_css );
			//self::addStyle("static-captions","rs-plugin-static","rs-plugin/css");
			
			$setBase = (is_ssl()) ? "https://" : "http://";
			
			$url_jquery = $setBase."ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js?app=revolution";
			self::addScriptAbsoluteUrl($url_jquery, "jquery");
			
			if($includesFooter == "off"){
				self::addScriptWaitFor("jquery.themepunch.plugins.min","rs-plugin/js",'themepunchtools','jquery');
				self::addScriptWaitFor("jquery.themepunch.revolution.min","rs-plugin/js",'revmin','jquery');
			}else{
				//put javascript to footer
				UniteBaseClassRev::addAction('wp_footer', 'putJavascript');
			}
			
			
		}
		
		public function enqueue_styles(){
			
			$font = new ThemePunch_Fonts();
			$font->register_fonts();
		}
		
		/**
		 * 
		 * javascript output to footer
		 */
		public function putJavascript(){
			$urlPlugin = UniteBaseClassRev::$url_plugin."rs-plugin/";
			?>
			<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.plugins.min.js?rev=<?php echo GlobalsRevSlider::SLIDER_REVISION; ?>'></script>
			<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.revolution.min.js?rev=<?php echo  GlobalsRevSlider::SLIDER_REVISION; ?>'></script>
			<?php
		}
		
		
		
	}
	

?>