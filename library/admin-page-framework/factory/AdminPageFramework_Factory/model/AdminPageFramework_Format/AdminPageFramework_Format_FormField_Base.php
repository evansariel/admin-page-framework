<?php
/**
 Admin Page Framework v3.6.0b06 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class AdminPageFramework_Format_FormField_Base extends AdminPageFramework_Format_Base {
    protected function _isSectionSet(array $aField) {
        return isset($aField['section_id']) && $aField['section_id'] && '_default' !== $aField['section_id'];
    }
}