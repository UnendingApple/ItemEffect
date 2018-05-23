<?php
namespace AnkitM252\ItemEffect;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\utils\TextFormat as TF;

class EventListener implements Listener
{
    public function __construct(Loader $plugin)
    {
        $this->p = $plugin;
    }
    
    public function onHeld(PlayerItemHeldEvent $ev)
    {
        $p = $ev->getPlayer();
        $i = $ev->getItem();
        
        $p->removeAllEffects();
        
        $lore = $i->getLore();
        foreach ($lore as $e) {
            $name = strtolower($e);
            $e    = Effect::getEffectByName($name);
            
            if ($e != null) {
                $effect = new EffectInstance($e);
                $p->addEffect($effect);
            }
        }
    }
}