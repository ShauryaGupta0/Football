<?php

namespace xBeastMode\Football;

use pocketmine\entity\Entity;
use pocketmine\world\World;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

class BallEntity extends Entity {

    public const NETWORK_ID = self::SLIME;

    public bool $hit = false;
    public float $scale = 1.0;
    public float $baseSize = 0.51;
    public float $height = 0;
    public float $width = 0;

    public float $speed = 0;
    /** @var Vector3 */
    public ?Vector3 $hitMotion = null;

    public function __construct(World $world, CompoundTag $nbt) {
        $this->height = ($this->baseSize * $this->scale) * $this->baseSize;
        $this->width = ($this->baseSize * $this->scale) * $this->baseSize;
        $this->motion = $this->hitMotion = new Vector3();
        parent::__construct($world, $nbt);
    }

    public function getName(): string {
        return "BallEntity";
    }

    protected function entityBaseTick(int $tickDiff = 1): bool {
        if($this->isFlaggedForDespawn() || $this->closed || $this->location->world === null) {
            return false;
        }
        return parent::entityBaseTick($tickDiff);
    }

    public function onCollideWithPlayer(Player $player): void {
        $direc = $player->getDirectionVector();
        if(!$player->isOnGround()) {
            $direc->y = 0.6;
        }
        if(!$player->isSprinting()) {
            $direc->divide(2);
        }
        $this->speed = 1;
        $this->setMotion($direc);
    }
}
