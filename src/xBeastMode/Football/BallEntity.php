<?php

namespace xBeastMode\Football;

use pocketmine\entity\Entity;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class BallEntity extends Entity {

    public const NETWORK_ID = self::SLIME;

    public $hit = false;
    public $scale = 1;
    public $baseSize = 0.51;
    public $height = 0;
    public $width = 0;

    public $speed = 0;
    /** @var Vector3 */
    public $hitMotion = null;

    public function __construct(Level $level, CompoundTag $nbt) {
        $this->height = ($this->baseSize * $this->scale) * $this->baseSize;
        $this->width = ($this->baseSize * $this->scale) * $this->baseSize;
        $this->motion = $this->hitMotion = new Vector3();
        parent::__construct($level, $nbt);
    }

    public function getName(): string {
        return "BallEntity";
    }

    public function entityBaseTick(int $tickDiff = 1): bool {
        if($this->isFlaggedForDespawn()) {
            return false;
        }
        if($this->closed) {
            return false;
        }
        if($this->level === null) {
            return false;
        }
        return parent::entityBaseTick($tickDiff);
    }

    public function onCollideWithPlayer(Player $player): void {
        $direc = $player->getDirectionVector();
        if(!$player->onGround) {
            $direc->y = 0.6;
        }
        if(!$player->isSprinting()) {
            $direc->divide(2);
        }
        $this->speed = 1;
        $this->setMotion($direc);
    }
}
