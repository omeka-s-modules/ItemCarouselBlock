<?php
namespace ItemCarouselBlock;

use Omeka\Module\AbstractModule;
use Laminas\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Mvc\MvcEvent;

class Module extends AbstractModule
{
	public function getConfig()
	{
		return include sprintf('%s/config/module.config.php', __DIR__);
	}
    public function attachListeners(SharedEventManagerInterface $sharedEventManager)
    {
        // Copy ItemCarouselBlock-related data for the CopyResources module.
        $sharedEventManager->attach(
            '*',
            'copy_resources.sites.post',
            function (Event $event) {
                $copyResources = $event->getParam('copy_resources');
                $siteCopy = $event->getParam('resource_copy');

                $copyResources->revertSiteBlockLayouts($siteCopy->id(), 'carousel');
            }
        );
	}
}
