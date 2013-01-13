<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Sdrdis\Color;

class Renderer_Picker extends \Fieldset_Field
{
    protected static $DEFAULT_RENDERER_OPTIONS = array(
        'colorpicker' => array(
	        'showOn'            => 'both',
            'buttonColorize'    => true,
            'buttonImage'       => 'static/apps/sdrdis_color/plugins/colorpicker/images/ui-colorpicker.png'
        ),
    );

    /**
     * Standalone build of the media renderer.
     *
     * @param  array  $renderer Renderer definition (attributes + renderer_options)
     * @return string The <input> tag + JavaScript to initialise it
     */
    public static function renderer($renderer = array())
    {
        list($attributes, $renderer_options) = static::parse_options($renderer);
        $attributes['data-colorpicker-options'] = htmlspecialchars(\Format::forge()->to_json($renderer_options['colorpicker']));

        return '<input '.array_to_attr($attributes).' />'.static::js_init($attributes['id'], $renderer_options);
    }

    protected $options = array();

    public function __construct($name, $label = '', array $renderer = array(), array $rules = array(), \Fuel\Core\Fieldset $fieldset = null)
    {
        list($attributes, $this->options) = static::parse_options($renderer);
        parent::__construct($name, $label, $attributes, $rules, $fieldset);
    }

    /**
     * How to display the field
     * @return type
     */
    public function build()
    {
        parent::build();
        $this->fieldset()->append(static::js_init($this->get_attribute('id'), $this->options));
        $colorpicker_options = $this->options['colorpicker'];
        $this->set_attribute('data-colorpicker-options', htmlspecialchars(\Format::forge()->to_json($colorpicker_options)));

        return (string) parent::build();
    }

    /**
     * Parse the renderer array to get attributes and the renderer options
     * @param  array $renderer
     * @return array 0: attributes, 1: renderer options
     */
    protected static function parse_options($renderer = array())
    {
        $renderer['type'] = 'text';
        $renderer['class'] = (isset($renderer['class']) ? $renderer['class'] : '').' cp-basic colorpicker';

        if (empty($renderer['id'])) {
            $renderer['id'] = uniqid('colorpicker_');
        }

        if (empty($renderer['size'])) {
            $renderer['size'] = 6;
        }

        // Default options of the renderer
        $renderer_options = static::$DEFAULT_RENDERER_OPTIONS;

        if (!empty($renderer['renderer_options'])) {
            $renderer_options = \Arr::merge($renderer_options, $renderer['renderer_options']);
        }
        unset($renderer['renderer_options']);

        return array($renderer, $renderer_options);
    }

    /**
     * Generates the JavaScript to initialise the renderer
     *
     * @param   string  HTML ID attribute of the <input> tag
     * @return string JavaScript to execute to initialise the renderer
     */
    protected static function js_init($id, $renderer_options = array())
    {
        return \View::forge('sdrdis_color::renderer/picker', array(
            'id' => $id,
            'wrapper' => \Arr::get($renderer_options, 'wrapper', ''),
        ), false);
    }
}
