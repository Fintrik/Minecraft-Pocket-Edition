<?php
namespace main;

use pocketmine\utils\TextFormat as MT;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\scheduler\PluginTask;
use pocketmine\plugin\Plugin;

	class osd extends PluginBase implements Listener
	{

		public $schalter = array();

		public function onEnable()
		{
			$this->getServer()->getPluginManager()->registerEvents($this,$this);
			$this->getLogger()->info(MT::AQUA."Plugin -=SH=-OSD loading...!");
			$this->getServer()->getScheduler()->scheduleRepeatingTask(new osdtask($this), 15);

			$test = date_default_timezone_set("Europe/Belgrade");
		}
		
		public function onDisable()
		{
			$this->getLogger()->info(MT::AQUA."Plugin unloaded!");			
		}

		public function onCommand(CommandSender $p, Command $command, $label, array $args)
		{
			if($p instanceof Player) 
			{
				if(strtolower($command->getName()) == "shosd")
				{
					$id = $p->getID();
					$name = strtolower($p->getName());
				
					if (! (in_array($id, $this->schalter)))
					{
						$this->schalter[$name] = $id;
						$p->sendMessage(MT::GREEN."OSD Eingeschaltet");
						return true;
					}
					else
					{
						$index = array_search($id, $this->schalter);
						unset($this->schalter[$index]);
						$p->sendMessage(MT::GREEN."OSD Ausgeschaltet");
						return true;
					}
				}
			}
			else 
			{
				$p->sendMessage(MT::RED."Nur im Spiel moeglich");
				return true;
			}
		}
		
		public function onOSD()
		{
			$zeit = date("h:i");
			$leer = "\n\n\n\n\n\n\n";
			
			foreach($this->getServer()->getOnlinePlayers() as $p)
			{
				$id = $p->getID();
		
				if(in_array($id, $this->schalter))
				{
					$p->sendTip(MT::AQUA."$leer$zeit");
				}
			}
		}
	}

class osdtask extends PluginTask
{
	public function __construct(Plugin $owner)
	{
		parent::__construct($owner);
	}
	public function onRun($currentTick)
	{
		$this->getOwner()->onOSD();
	}
}
