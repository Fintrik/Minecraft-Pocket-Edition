<?php
namespace main;

use pocketmine\utils\TextFormat as MT;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\server;
use pocketmine\level;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\math\Vector3;

	class antikickop extends PluginBase implements Listener
	{
		public function onEnable()
		{
			$this->getServer()->getPluginManager()->registerEvents($this,$this);
			$this->getLogger()->info(MT::AQUA."-=SH=-AntiKickOp loading...!");
		}

		public function onKick(PlayerKickEvent $event)
		{
			$player = $event->getPlayer();
			if($player->isOp()){$event->setCancelled(true);}
		}
		
		public function onDisable()
		{
			$this->getLogger()->info(MT::AQUA."Plugin unloaded!");
		}
	}
