<?php

namespace NPEU\Module\Blockscta\Site\Dispatcher;

\defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Joomla\CMS\Helper\ModuleHelper;


/**
 * Dispatcher class for mod_blockscta
 *
 * @since  4.4.0
 */
class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    /**
     * Returns the layout data.
     *
     * @return  array
     */
    protected function getLayoutData(): array
    {
        $data   = parent::getLayoutData();
        /*$params = $data['params'];


        $data['stuff'] = $this->getHelperFactory()
            ->getHelper('BlocksctaHelper')
            ->getStuff($params, $this->getApplication());*/

        return $data;
    }
}
