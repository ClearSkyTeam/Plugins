<?php
namespace InventoryKeeper;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class MainClass extends PluginBase implements Listener{
	protected $config;
	protected $keepInventory = true;
	protected $keepExperience = true;
	
	public function onLoad(){
		if($this->getServer()->getName() !== "ClearSky"){
			$this->getLogger()->warning(TextFormat::YELLOW . "This plugin is designed for ClearSky . You are using ". $this->getServer()->getName() ."instead!");
		}
		if(!file_exists($this->getDataFolder())){
			mkdir($this->getDataFolder(),0777);
		}
		$this->config = new Config($this->getDataFolder()."config.yml", CONFIG::YAML,[
			'keepInventory'=>true,
			'keepExperience'=>true
		]);
		$this->keepInventory = $this->config->get('keepInventory');
		$this->keepExperience = $this->config->get('keepExperience');
		$this->getLogger()->info(TextFormat::WHITE . "Loaded!");
	}

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if($this->keepInventory){
			$this->getLogger()->info(TextFormat::DARK_GREEN . "KeepingInventory...");
		}
		if($this->keepExperience){
			$this->getLogger()->info(TextFormat::DARK_GREEN . "KeepingExperience...");
		}
    }

	public function onDisable(){
		$this->getLogger()->info(TextFormat::DARK_RED . "Disabled!");
	}
	
	public function onDeath(PlayerDeathEvent $event){
		$event->setKeepInventory($this->keepInventory);
		$event->setKeepExperience($this->keepExperience);
	}
}