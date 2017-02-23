<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 * @license http://ipaya.cn/license/
 */

namespace iPaya\widgets\scriptBlock;

use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\Block;

class ScriptBlock extends Block
{
    public $jsOptions = [
        'position' => View::POS_END
    ];

    public $cssOptions = [];

    public $jsPattern = '/<(script.*?)>(?P<js_content>.+?)<(\/script.*?)>/si';

    public $cssPattern = '/<(style.*?)>(?P<css_content>.+?)<(\/style.*?)>/si';

    /**
     * Ends recording a block.
     * This method stops output buffering and saves the rendering result as a named block in the view.
     */
    public function run()
    {
        $block = trim(ob_get_clean());
        $this->registerCssBlock($block);
        $this->registerJsBlock($block);
    }

    /**
     * @param string $block
     * @throws \Exception
     */
    public function registerJsBlock($block)
    {
        if ($this->renderInPlace) {
            throw new \Exception("not support yet ! ");
        }
        if (preg_match_all($this->jsPattern, $block, $matches)) {
            $jsContents = ArrayHelper::getValue($matches, 'js_content', []);
            $pos = ArrayHelper::getValue($this->jsOptions, 'position');
            $key = ArrayHelper::getValue($this->jsOptions, 'key');

            foreach ($jsContents as $jsContent) {
                $this->view->registerJs($jsContent, $pos, $key);
            }
        }
    }

    /**
     * @param string $block
     * @throws \Exception
     */
    public function registerCssBlock($block)
    {
        if ($this->renderInPlace) {
            throw new \Exception("not support yet ! ");
        }
        if (preg_match_all($this->cssPattern, $block, $matches)) {
            $cssContents = ArrayHelper::getValue($matches, 'css_content', []);
            foreach ($cssContents as $cssContent) {
                $key = ArrayHelper::getValue($this->cssOptions, 'key');
                $this->view->registerCss($cssContent, $this->cssOptions, $key);
            }
        }
    }
}