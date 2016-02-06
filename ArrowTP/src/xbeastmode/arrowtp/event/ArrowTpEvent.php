<?php
namespace xbeastmode\arrowtp\event;
use pocketmine\event\plugin\PluginEvent;
use xbeastmode\arrowtp\ArrowTP;
abstract class ArrowTpEvent extends PluginEvent{
    /**
     * @param \xbeastmode\arrowtp\ArrowTP
     */
    public function __construct(ArrowTP $plugin){
        parent::__construct($plugin);
    }
}
