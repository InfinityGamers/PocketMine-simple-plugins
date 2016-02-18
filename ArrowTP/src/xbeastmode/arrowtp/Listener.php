<?php
namespace xbeastmode\arrowtp;
use pocketmine\entity\Arrow;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use xbeastmode\arrowtp\event\PlayerArrowTpEvent;
use pocketmine\item\Bow;
use pocketmine\Player;
class Listener implements \pocketmine\event\Listener{
    /**
     * @param ProjectileHitEvent $e
     */
    public function onHit(ProjectileHitEvent $e){
        $projectile = $e->getEntity();
        if($projectile instanceof Arrow){
            $p = ArrowTP::getInstance()->getArrowShooterEntity($projectile);
            if($p instanceof Player and $p->hasPermission("arrowtp.use") and ArrowTP::getInstance()->getInstance()->getConfig()->get("enable_use")) {
                ArrowTP::getInstance()->tpShooterToArrow($projectile);
            }
        }
    }
    /**
     * @param PlayerJoinEvent $e
     */
    public function onJoin(PlayerJoinEvent $e){
        $p = $e->getPlayer();
        if($p->hasPermission("arrowtp.kit") and ArrowTP::getInstance()->getInstance()->getConfig()->get("enable_join_kit")){
            ArrowTP::getInstance()->addArrowTpKit($p);
        }
    }
    /**
     * @param PlayerItemHeldEvent $e
     */
    public function onHeld(PlayerItemHeldEvent $e){
        $i = $e->getItem();
        $p = $e->getPlayer();
        if($i instanceof Bow){
            if($p->hasPermission("arrowtp.customname") and ArrowTP::getInstance()->getInstance()->getConfig()->get("enable_custom_name")){
                $p->sendPopup(ArrowTP::getInstance()->getBowCustomName());
            }
        }
    }
    /**
     * @param PlayerArrowTpEvent $e
     */
    public function onTp(PlayerArrowTpEvent $e){
        $p = $e->getPlayer();
        if(!ArrowTP::getInstance()->simpleAuth()->isPlayerAuthenticated($p)){
            $e->setCancelled();
        }
    }
}
