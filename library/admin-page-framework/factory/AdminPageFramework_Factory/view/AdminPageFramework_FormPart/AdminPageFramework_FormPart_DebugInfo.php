<?php
/**
 Admin Page Framework v3.6.0b06 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_FormPart_DebugInfo extends AdminPageFramework_FormPart_Base {
    public $sFieldsType = '';
    public function __construct() {
        $_aParameters = func_get_args() + array($this->sFieldsType,);
        $this->sFieldsType = $_aParameters[0];
    }
    public function get() {
        if (!$this->isDebugModeEnabled()) {
            return '';
        }
        if (!in_array($this->sFieldsType, array('widget', 'post_meta_box', 'page_meta_box', 'user_meta'))) {
            return '';
        }
        return "<div class='admin-page-framework-info'>" . 'Debug Info: ' . AdminPageFramework_Registry::NAME . ' ' . AdminPageFramework_Registry::getVersion() . "</div>";
    }
}