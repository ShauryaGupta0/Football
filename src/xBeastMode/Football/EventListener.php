<?php

namespace xBeastMode\Football;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;

class EventListener implements Listener {

    public function onDamage(EntityDamageEvent $event): void {
        $target = $event->getEntity();
        if ($target instanceof BallEntity) {
            // Cancel damage towards BallEntity
            $event->setCancelled();
        }
    }

    // Additional event Handling May Curd
}
