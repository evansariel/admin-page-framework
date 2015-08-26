<?php
/**
 Admin Page Framework v3.6.0b06 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class AdminPageFramework_Utility_File extends AdminPageFramework_Utility_URL {
    static public function getFileTailContents($asPath = array(), $iLines = 1) {
        $_sPath = self::_getFirstItem($asPath);
        if (!@is_readable($_sPath)) {
            return '';
        }
        return trim(implode('', array_slice(file($_sPath), -$iLines)));
    }
    static private function _getFirstItem($asItems) {
        $_aItems = is_array($asItems) ? $asItems : array($asItems);
        $_aItems = array_values($_aItems);
        return ( string )array_shift($_aItems);
    }
    static public function sanitizeFileName($sFileName, $sReplacement = '_') {
        $sFileName = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", $sReplacement, $sFileName);
        return preg_replace("([\.]{2,})", '', $sFileName);
    }
}