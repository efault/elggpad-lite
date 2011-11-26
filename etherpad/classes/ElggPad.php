<?php
/**
 * Elgg EtherPad
 *
 *
 */
class ElggPad extends ElggObject {
	
	protected $pad;
	protected $groupID;
	protected $authorID;
	
	/**
	 * Initialise the attributes array to include the type,
	 * title, and description.
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = "etherpad";
	}
	
	function save(){
		$guid = parent::save();
		
		try {
			$sessionID = $this->startSession();
			
			$name    = uniqid();
			$groupID = $this->groupID;
			$padID   = $groupID . "$" . $name;
			
			//Create new pad
			//TODO : Access control, private pads. 
			$this->pad->createGroupPad($groupID, $name, elgg_get_plugin_setting('new_pad_text', 'etherpad'));
			
			$this->setMetaData('pname', $padID);
			$this->setMetaData('paddress', elgg_get_plugin_setting('etherpad_host', 'etherpad') . "/p/". $padID);
			
			//set etherpad permissions
			if($access == '2') {
				$this->pad->setPublicStatus($padID, "true");
			} else {
				$this->pad->setPublicStatus($padID, "false");
			}
			
			$this->pad->deleteSession($sessionID);
			
		} catch (Exception $e){
			return false;
		}
		
		return $guid;
	}
	
	function delete(){
		try {
			$this->startSession();
			$this->pad->deletePad($this->getMetaData('pname'));
		} catch(Exception $e) {
			return false;
		}
		return parent::delete();
	}
	
	function startSession(){
		include(elgg_get_plugins_path() . 'etherpad/vendors/etherpad-lite-client.php');
		 
		// Etherpad: Create an instance
		$apikey = elgg_get_plugin_setting('etherpad_key', 'etherpad');
		$apiurl = elgg_get_plugin_setting('etherpad_host', 'etherpad') . "/api";
		$this->pad = new EtherpadLiteClient($apikey, $apiurl);

		//Etherpad: Create a group for logged in user
		$mappedGroup = $this->pad->createGroupIfNotExistsFor("elggpad");//(get_loggedin_user()->username); 
		$this->groupID = $mappedGroup->groupID;

		//Etherpad: Create an author(etherpad user) for logged in user
		$author = $this->pad->createAuthorIfNotExistsFor(elgg_get_logged_in_user_entity()->username);
		$this->authorID = $author->authorID;

		//Etherpad: Create session
		$validUntil = mktime(date("H"), date("i")+5, 0, date("m"), date("d"), date("y")); // 5 minutes in the future
		$session = $this->pad->createSession($this->groupID, $this->authorID, $validUntil);
		$sessionID = $session->sessionID;
		
		if(!setcookie('sessionID', $sessionID, $validUntil, '/')){
			throw new Exception(elgg_echo('etherpad:error:cookies_required'));
		}
		
		return $sessionID;
	}
	
	function getPadPath(){
		$settings = array('show_controls', 'monospace_font', 'show_chat', 'line_numbers');
		
		if(elgg_is_logged_in()) {
			$name = elgg_get_logged_in_user_entity()->name;
		} else {
			$name = 'undefined';
		}
		
		array_walk($settings, function(&$setting) {
			if(elgg_get_plugin_setting($setting, 'etherpad') == 'no') {
				$setting = 'false';
			} else {
				$setting = 'true';
			}
		});
		
		$options = array(
			'userName' => $name,
			'showControls' => $settings[0],
			'useMonospaceFont' => $settings[1],
			'showChat' => $settings[2],
			'showLineNumbers' => $settings[3],
		);
		
		return $this->getMetaData('paddress') . '?' . http_build_query($options);
	}
}
