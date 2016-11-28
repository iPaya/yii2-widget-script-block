<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 * @license http://ipaya.cn/license/
 */

namespace iPaya\widgets\scriptblock;

use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\Block;

class ScriptBlock extends Block
{
    public $jsOptions = [
        'position' => View::POS_END
    ];

    public $cssOptions = [];

    public $jsPattern = '|^<script[^>]*>(?P<js_content>.+?)</script>$|is';

    public $cssPattern = '|^<style[^>]*>(?P<css_content>.+?)</style>$|is';

    public function init()
    {
        parent::init();
    }

    /**
     * Ends recording a block.
     * This method stops output buffering and saves the rendering result as a named block in the view.
     */
    public function run()
    {
        $this->registerCssBlock();
        $this->registerJsBlock();
    }

    /**
     * @throws \Exception
     */
    public function registerJsBlock()
    {
        $block = ob_get_clean();
        if ($this->renderInPlace) {
            throw new \Exception("not support yet ! ");
        }
        $block = trim($block);

        if (preg_match($this->jsPattern, $block, $matches)) {
            $block = $matches['js_content'];
        }
        $pos = ArrayHelper::getValue($this->jsOptions, 'position');
        $key = ArrayHelper::getValue($this->jsOptions, 'key');

        $this->view->registerJs($block, $pos, $key);
    }

    /**
     * @throws \Exception
     */
    public function registerCssBlock()
    {
        $block = ob_get_clean();
        if ($this->renderInPlace) {
            throw new \Exception("not support yet ! ");
        }
        $block = trim($block);
        if (preg_match($this->cssPattern, $block, $matches)) {
            $block = $matches['css_content'];
        }
        $key = ArrayHelper::getValue($this->cssOptions, 'key');

        $this->view->registerCss($block, $this->cssOptions, $key);
    }
}