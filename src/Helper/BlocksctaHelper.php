<?php

namespace NPEU\Module\Blockscta\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\Database\DatabaseAwareInterface;
use Joomla\Database\DatabaseAwareTrait;
use Joomla\Registry\Registry;


/**
 * Helper for mod_blockscta
 *
 * @since  1.5
 */
class BlocksctaHelper implements DatabaseAwareInterface
{
    use DatabaseAwareTrait;


    /*public function getStuff(Registry $config, SiteApplication $app): array
    {
        if (!$app instanceof SiteApplication) {
            return [];
        }
        $db = $this->getDatabase();

        // Do some database stuff here.

        return ["Hello, world."];
    }*/

}
