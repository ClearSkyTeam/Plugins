<?php
namespace NoCurse;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class MainClass extends PluginBase implements Listener{
	protected $fliter=[];
	
	public function onLoad(){
		if($this->getServer()->getName() !== "ClearSky"){
			$this->getLogger()->warning(TextFormat::YELLOW . "This plugin is designed for ClearSky . You are using ". $this->getServer()->getName() ." instead!");
		}
		if(!file_exists($this->getDataFolder())){
			mkdir($this->getDataFolder(),0777);
		}
		if(!file_exists($this->getDataFolder()."fliter.json")){
			$default = $this->getResource("fliter.json");
			file_put_contents($this->getDataFolder()."fliter.json",$default);
			fclose($default);
		}
		$this->fliter = json_decode(file_get_contents($this->getDataFolder()."fliter.json"),true);
		$this->getLogger()->info(TextFormat::WHITE . "Loaded!");
	}

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info(TextFormat::DARK_GREEN . "Enabled!");
    }

	public function onDisable(){
		$this->getLogger()->info(TextFormat::DARK_RED . "Disabled!");
	}
	
	public function onChat(PlayerChatEvent $event){
		$message = $event->getMessage();
		$flitered_message = str_ireplace($this->fliter,"***",$message);
		if($flitered_message !== $message){
			$event->setFlitered(true);
			$event->setMessage($flitered_message);
		}
	}
}