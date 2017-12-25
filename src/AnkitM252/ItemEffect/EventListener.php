<?php
namespace AnkitM252\ItemEffect;

use pocketmine\entity\Effect;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;

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
            $effect = Effect::getEffectByName($name);

            if ($effect != null) {
                $p->addEffect($effect);
            }
        }
    }
}