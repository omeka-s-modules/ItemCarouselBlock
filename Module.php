<?php
namespace CarouselBrowse;

use Omeka\Module\AbstractModule;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Mvc\MvcEvent;

class Module extends AbstractModule
{
	public function getConfig()
	{
		return include sprintf('%s/config/module.config.php', __DIR__);
	}
}