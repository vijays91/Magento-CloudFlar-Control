<?php
class Learn_Cloudflare_Model_Observer
{
	
	/*
	*
	*
	*/
    public function cloudflare_api() {
		
		$_helper = Mage::helper('cloudflare');
		
		if($_helper->cloudflare_enable()) {
			$this->email_id 	= $_helper->cloudflare_email_id();
			$this->zone_id 		= $_helper->cloudflare_zone_id();
			$this->api_key 		= $_helper->cloudflare_api_key();			
			$ssl 				= $_helper->cloudflare_ssl();
			$cache_level 		= $_helper->cloudflare_caching_level();
			$auto_minify 		= $_helper->cloudflare_auto_minify();
			$development_mode 	= $_helper->cloudflare_development_mode();
			$security_profile 	= $_helper->cloudflare_security_profile();
			$always_online	 	= $_helper->cloudflare_always_online();
			$rocket_loader	 	= $_helper->cloudflare_rocket_loader();
			$ipv6	 			= $_helper->cloudflare_ipv6();
			$websockets	 		= $_helper->cloudflare_websockets();
			$ip_geolocation	 	= $_helper->cloudflare_ip_geolocation();
			
			if( $this->email_id  && $this->zone_id && $this->api_key) {
				$this->security_level( $security_profile );
				$this->development_mode( $development_mode );
				$this->cache_level( $cache_level );
				$this->auto_minify( $auto_minify );
				$this->always_online( $always_online );
				$this->ssl( $ssl );
				$this->rocket_loader( $rocket_loader );
				$this->ipv6( $ipv6 );
				$this->websockets( $websockets );
				$this->ip_geolocation( $ip_geolocation );
			} else {
				$message = Mage::helper('core')->__("Kindly check the Email-ID, API-Key and Zone ID.");
				Mage::getSingleton('core/session')->addNotice($message);	
			}
		} else {
			$message = Mage::helper('core')->__("Kindly enable the module for cloudflare settings control.");
			Mage::getSingleton('core/session')->addNotice($message);
		}
    }
		
	/*
	*
	*
	*/
	public function auto_minify( $option ) {
		
		$api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/minify";		
		switch ($option) {
			case 1:
				$json = '{"value":{"html":"on","css":"off","js":"off"}}';
				break;
			case 2:
				$json = '{"value":{"css":"on","js":"off","html":"off"}}';
				break;
			case 3:
				$json = '{"value":{"js":"on","html":"off","css":"off"}}';
				break;
			case 4:
				$json = '{"value":{"html":"on","css":"on","js":"off"}}';
				break;
			case 5:
				$json = '{"value":{"html":"off","css":"on","js":"on"}}';
				break;
			case 6:
				$json = '{"value":{"html":"on","css":"off","js":"on"}}';
				break;
			case 7:
				$json = '{"value":{"html":"on","css":"on","js":"on"}}';
				break;
			default:
				$json = '{"value":{"html":"off","css":"off","js":"off"}}';
		}		
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);		
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("Auto minify option updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating auto minify option.");
			Mage::getSingleton('core/session')->addError($message);
		}
		return true;
    }
		
	/*
	*
	*
	*/
	public function cache_level( $cache_level ) {
		$api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/cache_level";
        $json = json_encode(
			array(
				'value' => $cache_level,
			)
		);
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);		
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("Cache Level updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating cache level.");
			Mage::getSingleton('core/session')->addError($message);	
		}
		return true;
    }
		
	/*
	*
	*
	*/
	public function development_mode( $development_mode ) {
		$api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/development_mode";
		$json = json_encode(
			array(
				'value' => $development_mode
			)
		);
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);		
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("Development mode updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating development mode.");
			Mage::getSingleton('core/session')->addError($message);	
		}
		return true;
	}
		
	/*
	*
	*
	*/
	public function security_level( $security_level ) {
        $api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/security_level";
        $json=  json_encode(
			array(
				'value' => $security_level
			)
		);
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("Security level updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating security level.");
			Mage::getSingleton('core/session')->addError($message);	
		}
		return true;
    }
	
	/*
	*
	*
	*/
	public function ssl( $ssl ) {
        $api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/ssl";
        $json=  json_encode(
			array(
				'value' => $ssl
			)
		);
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("SSL updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating SSL.");
			Mage::getSingleton('core/session')->addError($message);	
		}
		return true;
    }
	
	/*
	*
	*
	*/
	public function always_online( $always_online ) {
        $api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/always_online";
        $json=  json_encode(
			array(
				'value' => $always_online
			)
		);
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("Always Online updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating Always Online.");
			Mage::getSingleton('core/session')->addError($message);	
		}
		return true;
    } 			
	
	/*
	*
	*
	*/
	public function rocket_loader( $rocket_loader ) {
        $api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/rocket_loader";
        $json=  json_encode(
			array(
				'value' => $rocket_loader
			)
		);
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("Rocket Loader updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating Rocket Loader.");
			Mage::getSingleton('core/session')->addError($message);	
		}
		return true;
    }
	
	/*
	*
	*
	*/
	public function ipv6( $ipv6 ) {
        $api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/ipv6";
        $json=  json_encode(
			array(
				'value' => $ipv6
			)
		);
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("IPv6 updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating IPv6.");
			Mage::getSingleton('core/session')->addError($message);	
		}
		return true;
    }
	
	/*
	*
	*
	*/
	public function websockets( $websockets ) {
        $api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/websockets";
        $json=  json_encode(
			array(
				'value' => $websockets
			)
		);
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("WebSockets updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating WebSockets.");
			Mage::getSingleton('core/session')->addError($message);	
		}
		return true;
    }
	
	/*
	*
	*
	*/
	public function ip_geolocation( $ip_geolocation ) {
        $api_url = "https://api.cloudflare.com/client/v4/zones/". $this->zone_id ."/settings/ip_geolocation";
        $json=  json_encode(
			array(
				'value' => $ip_geolocation
			)
		);
		$result = Mage::getModel('cloudflare/api')->curlRequest($api_url, $json, $this->email_id, $this->api_key);
		if($result['success'] === true) {
			$message = Mage::helper('core')->__("IP Geolocation updated successfully.");
			Mage::getSingleton('core/session')->addSuccess($message);
		} else {
			$message = Mage::helper('core')->__("Error for updating  IP Geolocation.");
			Mage::getSingleton('core/session')->addError($message);	
		}
		return true;
	}

	/* Show in cache Zone*/
	public function injectHtml(Varien_Event_Observer $observer) {
        $block  = $observer->getBlock();

        if($block instanceof Mage_Adminhtml_Block_Cache_Additional) {
			
			$_helper = Mage::helper('cloudflare');

			if($_helper->cloudflare_enable()) {

				$transport = $observer->getTransport();
				$insert =
					'<tr>
						<td class="scope-label">
							<button onclick="setLocation(\'' . Mage::helper('adminhtml')->getUrl('cloudflare/adminhtml_index/newflush/') . '\')" type="button" class="scalable">
								<span>' . Mage::helper('adminhtml')->__('Flush CloudFlare Cache') . '</span>
							</button>
						</td>
						<td class="scope-label">' . Mage::helper('adminhtml')->__('Flush cache cloudflare account.') . '</td>
					</tr>';

				$dom = new DOMDocument();

				$dom->loadHTML($transport->getHtml());

				$td = $dom->createDocumentFragment();
				$td->appendXML($insert);

				$dom->getElementsByTagName('table')->item(1)->insertBefore($td, $dom->getElementsByTagName('table')->item(1)->firstChild);

				$transport->setHtml($dom->saveHTML());
			}
        }
    }
	
}
?>