<?php
/**
 Admin Page Framework v3.5.8b03 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class AdminPageFramework_TaxonomyField_Model extends AdminPageFramework_TaxonomyField_Router {
    public function validate($aInput, $aOldInput, $oFactory) {
        return $aInput;
    }
    public function _replyToManageColumns($aColumns) {
        return $this->_getFilteredColumnsByFilterPrefix($this->oUtil->getAsArray($aColumns), 'columns_', isset($_GET['taxonomy']) ? $_GET['taxonomy'] : '');
    }
    public function _replyToSetSortableColumns($aSortableColumns) {
        return $this->_getFilteredColumnsByFilterPrefix($this->oUtil->getAsArray($aSortableColumns), 'sortable_columns_', isset($_GET['taxonomy']) ? $_GET['taxonomy'] : '');
    }
    private function _getFilteredColumnsByFilterPrefix(array $aColumns, $sFilterPrefix, $sTaxonomy) {
        if ($sTaxonomy) {
            $aColumns = $this->oUtil->addAndApplyFilter($this, "{$sFilterPrefix}{$_GET['taxonomy']}", $aColumns);
        }
        return $this->oUtil->addAndApplyFilter($this, "{$sFilterPrefix}{$this->oProp->sClassName}", $aColumns);
    }
    public function _replyToRegisterFormElements($oScreen) {
        $this->_loadFieldTypeDefinitions();
        $this->oForm->format();
        $this->oForm->applyConditions();
        $this->_registerFields($this->oForm->aConditionedFields);
    }
    protected function _setOptionArray($iTermID = null, $sOptionKey) {
        $aOptions = get_option($sOptionKey, array());
        $this->oProp->aOptions = isset($iTermID, $aOptions[$iTermID]) ? $aOptions[$iTermID] : array();
    }
    public function _replyToValidateOptions($iTermID) {
        if (!$this->_verifyFormSubmit()) {
            return;
        }
        $aTaxonomyFieldOptions = get_option($this->oProp->sOptionKey, array());
        $_aOldOptions = $this->oUtil->getElementAsArray($aTaxonomyFieldOptions, $iTermID, array());
        $_aSubmittedOptions = array();
        foreach ($this->oForm->aFields as $_sSectionID => $_aFields) {
            foreach ($_aFields as $_sFieldID => $_aField) {
                if (isset($_POST[$_sFieldID])) {
                    $_aSubmittedOptions[$_sFieldID] = $_POST[$_sFieldID];
                }
            }
        }
        $_aSubmittedOptions = $this->oUtil->addAndApplyFilters($this, 'validation_' . $this->oProp->sClassName, $_aSubmittedOptions, $_aOldOptions, $this);
        $aTaxonomyFieldOptions[$iTermID] = $this->oUtil->uniteArrays($_aSubmittedOptions, $_aOldOptions);
        update_option($this->oProp->sOptionKey, $aTaxonomyFieldOptions);
    }
    private function _verifyFormSubmit() {
        if (!isset($_POST[$this->oProp->sClassHash])) {
            return false;
        }
        if (!wp_verify_nonce($_POST[$this->oProp->sClassHash], $this->oProp->sClassHash)) {
            return false;
        }
        return true;
    }
}