<?php

namespace tim03we\chatlog;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use tim03we\chatlog\Listener\EventListener;

class Main extends PluginBase implements Listener {

    public function onEnable()
    {
        $this->saveResource("settings.yml");
        @mkdir($this->getDataFolder() . "logs/");
        $settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        if($settings->get("ChatLog", true)) {
            $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        } else {
            $this->getLogger()->notice("The chat is not recorded.");
        }
        $this->getLogger()->info("Plugin was enabled!");
    }

    public function onDisable()
    {
        $this->getLogger()->info("Plugin was disabled!");
    }
}