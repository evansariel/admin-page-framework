<?php
/**
 Admin Page Framework v3.6.0b06 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_FormPart_FieldsetRow extends AdminPageFramework_FormPart_TableRow {
    protected function _getRow(array $aFieldset, $hfCallback) {
        if ('section_title' === $aFieldset['type']) {
            return '';
        }
        $_oFieldrowAttribute = new AdminPageFramework_Attribute_Fieldrow($aFieldset);
        return $this->_getFieldByContainer($aFieldset, $hfCallback, array('open_main' => "<div " . $_oFieldrowAttribute->get() . ">", 'close_main' => "</div>",));
    }
}