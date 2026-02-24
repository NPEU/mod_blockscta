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


    public function getCta(Registry $config, SiteApplication $app): array
    {
        if (!$app instanceof SiteApplication) {
            return [];
        }
        //$db = $this->getDatabase();

        $cta = [];
        /*$cta['text']     = $config->get('cta_text');
        $cta['url']      = $config->get('cta_url');
        $cta['icon']     = $config->get('icon');
        if ($cta['icon'] != 0) {
            #$cta['icon = '<svg focusable="false" aria-hidden="true" width="1.25em" height="1.25em" display="inline"><use xlink:href="#icon-' . $params->get('icon') . '"></use></svg>';
            $cta['icon'] = BlocksHelper::renderUse($cta['icon']);
        }
        $cta['icon_pos'] = $config->get('icon_position');*/

        return $cta;
    }

}
