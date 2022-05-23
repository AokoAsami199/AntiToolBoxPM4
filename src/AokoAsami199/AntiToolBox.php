<?php

namespace AokoAsami199;

use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\{Player, Server};
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\server\DataPacketReceiveEvent;

class AntiToolBox extends PluginBase implements Listener
{
    
    public $AntiToolBox = "§aAnti ToolBox";

    public function onEnable(): void
    {
        $this->getLogger()->alert("Enabled!");
        $this->client = new Config($this->getDataFolder() . "ClientID.yml", Config::YAML, [
            "Banned ClientID" => 0,
            "Banned ClientID's Name" => "Toolbox",
        ]);

        $this->client->save();
    }

    public function onLoad(): void
    {
        $this->getLogger()->info("§aAntiToolBox");
    }

    public function onReceive(DataPacketReceiveEvent $aoko): void
    {
        $atb = $aoko->getPacket();
        if ($atb instanceof LoginPacket) {
            if ($atb->clientId === 0) {
                $aoko->setCancelled(true);
                $aoko->getPlayer()->close($this->AntiToolBox);
            }
        }
    }

    public function onJoin(PlayerJoinEvent $aoko): void
    {
        $player = $aoko->getPlayer();
        if ($player->isClosed()) {
            $this->getServer()->broadCastMessage("§aPlayer §c" . $player->getName() . "§a got kicked by using ToolBox!");
        }
    }
}
