<?php
namespace xbeastmode\arrowtp\event;
use pocketmine\entity\Arrow;
use pocketmine\event\Cancellable;
use pocketmine\level\Position;
use pocketmine\Player;
use xbeastmode\arrowtp\ArrowTP;
class PlayerArrowTpEvent extends ArrowTpEvent implements Cancellable{
    public static $handlerList = null;
    /**
     * @var Player
     */
    private $player;
    /**
     * @var Arrow
     */
    private $arrow;
    /** @var Position*/
    private $position;
    /**
     * @param ArrowTP $plugin
     * @param Player $p
     * @param Arrow $a
     * @param Position $pos
     */
    public function __construct(ArrowTP $plugin, Player $p, Arrow $a, Position $pos){
        parent::__construct($plugin);
        $this->player = $p;
        $this->arrow = $a;
        $this->position = $pos;
    }
    /**
     * @return Player
     */
    public function getPlayer(){
        return $this->player;
    }
    /**
     * @param Player $p
     */
    public function setPlayer(Player $p){
        $this->player = $p;
    }
    /**
     * @return Arrow
     */
    public function getArrow(){
        return $this->arrow;
    }
    /**
     * @param Arrow $a
     */
    public function setArrow(Arrow $a){
        $this->arrow = $a;
    }
    /**
     * @return Position
     */
    public function getPosition(){
        return $this->position;
    }
    /**
     * @param Position $pos
     * @internal param Position $position
     */
    public function setPosition(Position $pos){
        $this->position = $pos;
    }
}
