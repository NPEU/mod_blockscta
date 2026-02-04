<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_blockscta
 *
 * @copyright   Copyright (C) NPEU 2026.
 * @license     MIT License; see LICENSE.md
 */

\defined('_JEXEC') or die;

use NPEU\Plugin\System\Blocks\Helper\BlocksHelper;

$text     = $params->get('cta_text');
$url      = $params->get('cta_url');
$icon     = $params->get('icon');
if ($icon != 0) {
    #$icon = '<svg focusable="false" aria-hidden="true" width="1.25em" height="1.25em" display="inline"><use xlink:href="#icon-' . $params->get('icon') . '"></use></svg>';
    $icon = BlocksHelper::renderUse($params->get('icon'));

}
$icon_pos = $params->get('icon_position');
?>

<div class="blocks-container blockscta-container">
    <a href="<?php echo $url; ?>"><?php if ($icon && $icon_pos == 'before'): ?><span><?php echo $icon ?></span><?php endif; ?><?php echo $text; ?><?php if ($icon && $icon_pos == 'after'): ?><span><?php echo $icon; ?></span><?php endif; ?></a>
</div>