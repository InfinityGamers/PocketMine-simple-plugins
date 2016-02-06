<?php
namespace xbeastmode\arrowtp;
use pocketmine\entity\Arrow;
use pocketmine\item\Bow;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
//-----------------------------//
use xbeastmode\arrowtp\event\PlayerArrowTpEvent;
class ArrowTP extends PluginBase{
    /** @var ArrowTP*/
    private static $api;
    public function onLoad(){
        if(!self::$api instanceof ArrowTP){
            self::$api = $this;
        }
    }
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents(new Listener(), $this);
        $this->saveDefaultConfig();
    }
    //___  ______ _____
    /// _ \ | ___ \_   _|
    /// /_\ \| |_/ / | |
    //|  _  ||  __/  | |
    //| | | || |    _| |_
    //\_| |_/\_|    \___/
    /**
     * @return ArrowTP
     */
    public static function getInstance(){
        return self::$api;
    }
    /**
     * @param Arrow $a
     */
    public function tpShooterToArrow(Arrow $a){
        $shooter = $a->shootingEntity;
        if($shooter instanceof Player){
            $pos = new Position($a->x, $a->y, $a->z, $a->level);
            $tpEvent = new PlayerArrowTpEvent($this, $shooter, $a, $pos);
            ArrowTP::getInstance()->getServer()->getPluginManager()->callEvent($tpEvent);
            if($tpEvent->isCancelled()) return;
            $shooter->teleport($pos);
        }
    }
    /**
     * @param Arrow $a
     * @return array
     */
    public function arrowPositionToArray(Arrow $a){
        return [$a->x, $a->y, $a->z, $a->yaw, $a->pitch];
    }
    /**
     * @param Arrow $a
     * @return string
     */
    public function arrowPositionToString(Arrow $a){
        return $a->x.",".$a->y.",".$a->z.",".$a->yaw.",".$a->pitch;
    }
    /**
     * @param Arrow $a
     * @return $this|\pocketmine\item\Item
     */
    public function getArrowShooterBow(Arrow $a){
        $shooter = $a->shootingEntity;
        if($shooter instanceof Player){
            $bow = $shooter->getInventory()->getItemInHand();
            if($bow instanceof Bow){
                return $bow;
            }
        }
        return false;
    }
    /**
     * @param Arrow $a
     * @return \pocketmine\entity\Entity
     */
    public function getArrowShooterEntity(Arrow $a){
        return $a->shootingEntity;
    }
    /**
     * @param Arrow $a
     * @return bool|\pocketmine\entity\Entity
     */
    public function getArrowShooterPlayer(Arrow $a){
        $shooter = $a->shootingEntity;
        if($shooter instanceof Player){
            return $shooter;
        }
        return false;
    }
    /**
     * @param Arrow $a
     * @return null|string
     */
    public function getArrowShooterPlayerName(Arrow $a){
        $shooter = $a->shootingEntity;
        if($shooter instanceof Player){
            return $shooter->getName();
        }
        return null;
    }
    /**
     * @param Player $p
     */
    public function addArrowTpKit(Player $p){
        $bow = Item::get(Item::BOW, 0, $this->getConfig()->get("bow_amount"));
        $arrow = Item::get(Item::ARROW, 0, $this->getConfig()->get("arrow_amount"));
        $p->getInventory()->addItem($bow, $arrow);
    }
    /**
     * @return string
     */
    public function getBowCustomName(){
        return $this->getConfig()->get("bow_custom_name");
    }
}
