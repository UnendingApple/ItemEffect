<?php
namespace AnkitM252\ItemEffect;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Effect;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;

class Loader extends PluginBase
{
    public function onEnable()
    {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getLogger()->info("ItemEffect has been enabled!");
    }
    
    public function onCommand(CommandSender $sender, Command $command, $labels, array $args) : bool
    {
        $cmd = strtolower($command->getName());
        if ($cmd == "itemeffect") {
            if ($sender instanceof Player) {
                if ($sender->hasPermission('ie.command')) {
                    if (isset($args[0])) {
                        if (isset($args[1])) {
                            if (strtolower($args[0]) == "remove") {
                                $ef_upper = strtoupper($args[1]);
                                $ef_lower = strtolower($args[1]);
                                
                                $item = $sender->getInventory()->getItemInHand();
                                
                                if ($item->getId() != 0) {
                                    if (Effect::getEffectByName($ef_lower) != null) {
                                        $lores = $item->getLore();
										
                                        foreach ($lores as $key => $l) {
                                            if ($l == $ef_upper) {
                                                unset($lores[$key]);
                                                $item->setLore($lores);
                                                $sender->getInventory()->setItemInHand($item);
                                                $sender->sendMessage($this->getPrefix() . TF::GREEN . "Successfully removed " . TF::GOLD . $ef_upper . TF::GREEN . " effect in your item!");
                                                return true;
                                            }
                                        }
										
                                        $sender->sendMessage($this->getPrefix() . TF::RED . "The effect " . TF::GOLD . $ef_upper . TF::RED . " isn't available in your item!");
                                    } else {
                                        $sender->sendMessage($this->getPrefix() . TF::RED . "That effect doesn't exist!");
                                    }
                                } else {
                                    $sender->sendMessage($this->getPrefix() . TF::RED . "Please hold an item!");
                                }
                            } else if (strtolower($args[0]) == "add") {
                                $effect = strtoupper($args[1]);
                                $ef = strtolower($args[1]);
                                
                                $item = $sender->getInventory()->getItemInHand();
                                
                                if ($item->getId() != 0) {
                                    if (Effect::getEffectByName($ef) != null) {
                                        $lores = $item->getLore();
                                        $isset = false;
                                        foreach ($lores as $key => $l) {
                                            if ($l == $effect) {
                                                $isset = true;
                                            }
                                        }
                                        if (!$isset) {
                                            $lores[] = $effect;
                                            $item->setLore($lores);
                                            $sender->getInventory()->setItemInHand($item);
                                            $sender->sendMessage($this->getPrefix() . TF::GREEN . "Successfully added " . TF::GOLD . $effect . TF::GREEN . " effect in your item!");
                                        } else {
                                            $sender->sendMessage($this->getPrefix() . TF::RED . "Your item already has this effect!");
                                        }
                                    } else {
                                        $sender->sendMessage($this->getPrefix() . TF::RED . "That effect doesn't exist!");
                                    }
                                    
                                } else {
                                    $sender->sendMessage($this->getPrefix() . TF::RED . "Please hold an item!");
                                }
                            }
                        } else {
                            $sender->sendMessage($this->getPrefix() . TF::RED . "Usage: /ie <add|remove> <effect_name>");
                        }
                        
                        if (strtolower($args[0]) == "check") {
                            $item = $sender->getInventory()->getItemInHand();
                            
                            if ($item->getId() != 0) {
                                $lores = $item->getLore();
                                $arr = [];
                                foreach ($lores as $lore) {
                                    if (Effect::getEffectByName($lore) != null) {
                                        $arr[] = $lore;
                                    }
                                }
                                if (empty($arr)) {
                                    $sender->sendMessage($this->getPrefix() . TF::RED . "Your item doesn't have any effect!");
                                } else {
                                    $sender->sendMessage($this->getPrefix() . TF::GREEN . "Your item has:");
                                    foreach ($arr as $efs) {
                                        $sender->sendMessage($this->getPrefix() . TF::GREEN . $efs);
                                    }
                                }
                            } else {
                                $sender->sendMessage($this->getPrefix() . TF::RED . "Please hold an item!");
                            }
                        }
                    } else {
                        $sender->sendMessage($this->getPrefix() . TF::RED . "Usage: /ie <add|remove|check>");
                    }
                } else {
                    $sender->sendMessage($this->getPrefix() . TF::RED . "You don't have permission to use this command");
                }
            } else {
                $sender->sendMessage($this->getPrefix() . TF::RED . "Run this command in game!");
            }
            return true;
        }
    }
    
    public function translateColors($symbol, $message)
    {
        $message = str_replace($symbol . "0", TF::BLACK, $message);
        $message = str_replace($symbol . "1", TF::DARK_BLUE, $message);
        $message = str_replace($symbol . "2", TF::DARK_GREEN, $message);
        $message = str_replace($symbol . "3", TF::DARK_AQUA, $message);
        $message = str_replace($symbol . "4", TF::DARK_RED, $message);
        $message = str_replace($symbol . "5", TF::DARK_PURPLE, $message);
        $message = str_replace($symbol . "6", TF::GOLD, $message);
        $message = str_replace($symbol . "7", TF::GRAY, $message);
        $message = str_replace($symbol . "8", TF::DARK_GRAY, $message);
        $message = str_replace($symbol . "9", TF::BLUE, $message);
        $message = str_replace($symbol . "a", TF::GREEN, $message);
        $message = str_replace($symbol . "b", TF::AQUA, $message);
        $message = str_replace($symbol . "c", TF::RED, $message);
        $message = str_replace($symbol . "d", TF::LIGHT_PURPLE, $message);
        $message = str_replace($symbol . "e", TF::YELLOW, $message);
        $message = str_replace($symbol . "f", TF::WHITE, $message);
        
        $message = str_replace($symbol . "k", TF::OBFUSCATED, $message);
        $message = str_replace($symbol . "l", TF::BOLD, $message);
        $message = str_replace($symbol . "m", TF::STRIKETHROUGH, $message);
        $message = str_replace($symbol . "n", TF::UNDERLINE, $message);
        $message = str_replace($symbol . "o", TF::ITALIC, $message);
        $message = str_replace($symbol . "r", TF::RESET, $message);
        
        return $message;
    }
    
    public function getPrefix()
    {
        return $this->translateColors("&", $this->getConfig()->get("prefix") . "&r ");
    }
}