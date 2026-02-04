<?php
namespace NPEU\Module\Blockscta\Site\Field;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\RadioField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

use NPEU\Plugin\System\Blocks\Helper\BlocksHelper;

/**
 * Form field for a list of brands.
 */
class IconselectField extends RadioField
{
    /**
     * The form field type.
     *
     * @var     string
     */
    protected $type = 'Iconselect';

    /**
     * Method to attach a Form object to the field.
     *
     * @param   \SimpleXMLElement  $element  The SimpleXMLElement object representing the `<field>` tag for the form field object.
     * @param   mixed              $value    The form field value to validate.
     * @param   string             $group    The field name group control value.
     *
     * @return  boolean  True on success.
     *
     * @see     FormField::setup()
     * @since   5.1.0
     */
    public function setup(\SimpleXMLElement $element, $value, $group = null)
    {

        // Add the behaviour script once per request (this field can appear multiple times in subforms).
        static $scriptAdded = false;

        if (!$scriptAdded) {
            $scriptAdded = true;

            $wa = Factory::getApplication()->getDocument()->getWebAssetManager();

            $script = [];
            $script[] = '(function () {';
            $script[] = '  function initIconselectField(details) {';
            $script[] = '    if (!details) { return; }';
            $script[] = '    if (details.dataset.iconselectInitialised) { return; }';
            $script[] = '    details.dataset.iconselectInitialised = "1";';
            $script[] = '    const radios = details.querySelectorAll("input[type=radio]");';
            $script[] = '    radios.forEach((radio) => {';
            $script[] = '      radio.addEventListener("click", (e) => {';
            $script[] = '        var val = e.target.value';
            $script[] = '        var summaryText = details.dataset.noneValue';
            $script[] = '        if (val != 0) {';
            #$script[] = '            summaryText = \'<svg focusable="false" aria-hidden="true" width="1.25em" height="1.25em" display="inline"><use xlink:href="#icon-\' + val + \'"></use></svg>\';';
            $script[] = '            summaryText = \'' . str_replace('FORJS', "' + val + '", BlocksHelper::renderUse('FORJS')) . '\';';
            $script[] = '        }';
            $script[] = '        details.querySelector("summary").innerHTML = summaryText;';
            $script[] = '        details.removeAttribute("open");';
            $script[] = '      });';
            $script[] = '    });';
            $script[] = '  }';
            $script[] = '';
            $script[] = '  function initInRoot(root) {';
            $script[] = '    (root || document).querySelectorAll("details[data-iconselect-field]").forEach(initIconselectField);';
            $script[] = '  }';
            $script[] = '';
            $script[] = '  document.addEventListener("DOMContentLoaded", () => initInRoot(document));';
            $script[] = '  document.addEventListener("subform-row-add", (e) => initInRoot(e.detail && e.detail.row ? e.detail.row : document));';
            $script[] = '})();';

            $wa->addInlineScript(implode("\n", $script));
        }
        /*
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();

        $script = [];
        $script[] = 'function iconselectField(details) {';
        $script[] = '    console.log(details)';
        $script[] = '    let radios = details.querySelectorAll(\'input[type="radio"]\')';
        $script[] = '    for (let radio of radios) {';
        $script[] = '        radio.addEventListener("click", function() {';
        $script[] = '            details.removeAttribute("open")';
        $script[] =         '});';
        $script[] = '    };';
        $script[] = '};';
        $script[] = 'document.addEventListener("DOMContentLoaded", () => {';
        $script[] = '    iconselectField(document.getElementById("jform_params__rows__rows0__columns"))';
        $script[] = '});';
        $script[] = 'document.addEventListener("subform-row-add", (e) => {';
        $script[] = '    iconselectField(e.detail.row.querySelector("details"))';
        $script[] = '});';
        $wa->addInlineScript(implode("\n", $script));
        */
        return parent::setup($element, $value, $group);
    }

    /**
     * Method to get the field input markup for a generic list.
     * Use the multiple attribute to enable multiselect.
     *
     * @return  string  The field input markup.
     */
    protected function getInput()
    {
        $data = $this->getLayoutData();
        $data['summaryText'] = Text::_('MOD_BLOCKSCTA_MODULE_ICON_OPTION_NONE');

        #echo '<pre>'; var_dump(array_keys($data)); echo '<pre>'; exit;
        #echo '<pre>'; var_dump($data['options']); echo '<pre>'; exit;

        // Load from the component's layouts folder in administrator.
        $basePath = JPATH_ADMINISTRATOR . '/components/com_blocks/layouts';

        return LayoutHelper::render('com_blocks.field.iconselect', $data, $basePath);

        /*$input = parent::getInput();

        $input = str_replace('fieldset', 'details', $input);
        $input = preg_replace('#<legend(.*?)>(.*?)</legend>#s', '<summary><span class="visually-hidden">$2</span>&nbsp;</summary>', $input);
        #$input = str_replace('summary class="visually-hidden"', 'summary', $input);
        $input = str_replace(Text::_('COM_BLOCKS_COLUMNS_LABEL'), Text::_('COM_BLOCKS_COLUMNS_SELECT'), $input);
        $input = str_replace('input class="', 'input class="visually-hidden ', $input);

        return $input;*/
    }


    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     */
    protected function getOptions()
    {

        $icons = BlocksHelper::getIconNames();
        $options = [];

        foreach ($icons as $icon) {
            $options[] = HTMLHelper::_('select.option', $icon, $icon);
        }

        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);
        /*
        if (!empty($options)) {
            // Merge any additional options in the XML definition.
            $options = array_merge(parent::getOptions(), $options);
        } else {
            $options = parent::getOptions();
            #$options[0]->text = Text::_('COM_RESEARCHPROJECTS_BRAND_DEFAULT');
            $options[0]->text = 'Select module';
        }
        */
        return $options;

        /*$lang      = Factory::getLanguage();
        $root_path = $_SERVER['DOCUMENT_ROOT'];

        $options = [];
        $db = Factory::getDBO();

        $q = $db->getQuery(true);
        $q->select($db->quoteName(['extension_id', 'name', 'element']));
        $q->from($db->quoteName('#__extensions'));
        $q->where([
            $db->quoteName('type') . ' = ' . $db->quote('module'),
            $db->quoteName('manifest_cache') . ' LIKE \'%"author":"Andy Kirk"%\''
        ]);
        #$q->order('m.title');

        $db->setQuery($q);
        if (!$db->execute($q)) {
            throw new GenericDataException($db->stderr(), 500);
            return false;
        }

        $modules = $db->loadAssocList();



        // Need to run the modules throufgh translator and order by their propername:
        $ordered_modules = [];
        foreach ($modules as $module) {
            $lang->load($module['element'] . '.sys', $root_path)
                || $lang->load($module['element'] . '.sys', $root_path . '/modules/' . $module['element']);



            $proper_name = Text::_($module['name']);
            $module['name'] = $proper_name;
            $ordered_modules[$proper_name] = $module;
        }
        ksort($ordered_modules);
        #echo '<pre>'; var_dump($ordered_modules); echo '<pre>'; exit;
        #$modules = ArrayHelper::sortObjects($modules, 'name', 1, true, true);

        $i = 0;
        foreach ($ordered_modules as $module) {
            $options[] = HTMLHelper::_('select.option', $module['extension_id'], $module['name']);
            $i++;
        }

        if ($i > 0) {
            // Merge any additional options in the XML definition.
            $options = array_merge(parent::getOptions(), $options);
        } else {
            $options = parent::getOptions();
            #$options[0]->text = Text::_('COM_RESEARCHPROJECTS_BRAND_DEFAULT');
            $options[0]->text = 'Select module';
        }
        return $options;*/
    }

    /**
     * Method to get the field label markup for a spacer.
     * Use the label text or name from the XML element as the spacer or
     * Use a hr="true" to automatically generate plain hr markup
     *
     * @return  string  The field label markup.
     */
    /*protected function getLabel()
    {
        $append = false;
        $module_id = $this->value;

        if (!empty($module_id)) {
            $append = "\n" . '<br><a href="' . Route::_('/administrator/index.php?option=com_modules&task=module.edit&id=' . $module_id) .'" target="_blank">Edit current module</a>';
        }

        return parent::getLabel() . $append;
    }*/
}