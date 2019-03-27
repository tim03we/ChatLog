<?php

namespace tim03we\chatlog\Listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\Config;
use tim03we\chatlog\Main;

class EventListener implements Listener {

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onChat(PlayerChatEvent $event) {
        $settings = new Config($this->plugin->getDataFolder() . "settings.yml", Config::YAML);
        $player = $event->getPlayer();
        $name = $player->getName();
        $timeformat = new \DateTime('now');
        $date = $timeformat->format("Y-m-d");
        $time = $timeformat->format("H:i:s");
        if(!file_exists($time . ".yml")) {
            $log = new Config($this->plugin->getDataFolder() . "logs/" . $date . ".yml", Config::YAML);
        }
        $log = new Config($this->plugin->getDataFolder() . "logs/" . $date . ".yml", Config::YAML);
        $message = $event->getMessage(false);
        $log->set($this->convert($settings->get("Format"), $time, $date, $message, $name));
        $log->save();
    }

    public function convert(string $string, $time, $date, $message, $name): string{
        $string = str_replace("{time}", $time, $string);
        $string = str_replace("{date}", $date, $string);
        $string = str_replace("{message}", $message, $string);
        $string = str_replace("{name}", $name, $string);
        return $string;
    }
}