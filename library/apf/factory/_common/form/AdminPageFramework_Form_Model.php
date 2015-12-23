<?php
/**
 Admin Page Framework v3.7.6.1 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_Form_Model extends AdminPageFramework_Form_Base {
    public function __construct() {
        if ($this->aArguments['register_if_action_already_done']) {
            $this->registerAction($this->aArguments['action_hook_form_registration'], array($this, '_replyToRegisterFormItems'), 100);
        } else {
            add_action($this->aArguments['action_hook_form_registration'], array($this, '_replyToRegisterFormItems'));
        }
    }
    public function getSubmittedData(array $aDataToParse, $bExtractFromFieldStructure = true, $bStripSlashes = true) {
        $_aSubmittedFormData = $bExtractFromFieldStructure ? $this->castArrayContents($this->getDataStructureFromAddedFieldsets(), $aDataToParse) : $aDataToParse;
        $_aSubmittedFormData = $this->getSortedInputs($_aSubmittedFormData);
        return $bStripSlashes ? stripslashes_deep($_aSubmittedFormData) : $_aSubmittedFormData;
    }
    public function getSortedInputs(array $aFormInputs) {
        $_aDynamicFieldAddressKeys = array_unique(array_merge($this->getElementAsArray($_POST, '__repeatable_elements_' . $this->aArguments['structure_type'], array()), $this->getElementAsArray($_POST, '__sortable_elements_' . $this->aArguments['structure_type'], array())));
        if (empty($_aDynamicFieldAddressKeys)) {
            return $aFormInputs;
        }
        $_oInputSorter = new AdminPageFramework_Form_Model___Modifier_SortInput($aFormInputs, $_aDynamicFieldAddressKeys);
        return $_oInputSorter->get();
    }
    public function getDataStructureFromAddedFieldsets() {
        $_aFormDataStructure = array();
        foreach ($this->getAsArray($this->aFieldsets) as $_sSectionID => $_aFieldsets) {
            if ($_sSectionID != '_default') {
                $_aFormDataStructure[$_sSectionID] = $_aFieldsets;
                continue;
            }
            foreach ($_aFieldsets as $_sFieldID => $_aFieldset) {
                $_aFormDataStructure[$_aFieldset['field_id']] = $_aFieldset;
            }
        }
        return $_aFormDataStructure;
    }
    public function dropRepeatableElements(array $aSubject) {
        $_oFilterRepeatableElements = new AdminPageFramework_Form_Model___Modifier_FilterRepeatableElements($aSubject, $this->getElementAsArray($_POST, '__repeatable_elements_' . $this->aArguments['structure_type']));
        return $_oFilterRepeatableElements->get();
    }
    public function _replyToRegisterFormItems() {
        if (!$this->isInThePage()) {
            return;
        }
        $this->_setFieldTypeDefinitions('admin_page_framework');
        $this->_setFieldTypeDefinitions($this->aArguments['caller_id']);
        $this->aSavedData = $this->_getSavedData($this->aSavedData + $this->getDefaultFormValues());
        $this->_handleCallbacks();
        $_oFieldResources = new AdminPageFramework_Form_Model___SetFieldResources($this->aArguments, $this->aFieldsets, self::$_aResources, $this->aFieldTypeDefinitions, $this->aCallbacks);
        self::$_aResources = $_oFieldResources->get();
        $this->callBack($this->aCallbacks['handle_form_data'], array($this->aSavedData, $this->aArguments, $this->aSectionsets, $this->aFieldsets,));
    }
    private function _handleCallbacks() {
        $this->aSectionsets = $this->callBack($this->aCallbacks['secitonsets_before_registration'], array($this->aSectionsets,));
        $this->aFieldsets = $this->callBack($this->aCallbacks['fieldsets_before_registration'], array($this->aFieldsets, $this->aSectionsets,));
    }
    static private $_aFieldTypeDefinitions = array('admin_page_framework' => array(),);
    private function _setFieldTypeDefinitions($_sCallerID) {
        if (!$this->hasBeenCalled(__METHOD__ . $_sCallerID)) {
            $_oBuiltInFieldTypeDefinitions = new AdminPageFramework_Form_Model___BuiltInFieldTypeDefinitions($_sCallerID, $this->oMsg);
            self::$_aFieldTypeDefinitions[$_sCallerID] = $_oBuiltInFieldTypeDefinitions->get();
        }
        if ('admin_page_framework' === $_sCallerID) {
            $this->_setSiteWideFieldTypeDefinitions();
        }
        $this->_setPerClassFieldTypeDefinitions($_sCallerID);
    }
    private function _setPerClassFieldTypeDefinitions($_sCallerID) {
        $this->aFieldTypeDefinitions = apply_filters("field_types_{$_sCallerID}", self::$_aFieldTypeDefinitions[$_sCallerID] + self::$_aFieldTypeDefinitions['admin_page_framework']);
    }
    private function _setSiteWideFieldTypeDefinitions() {
        if ($this->hasBeenCalled('__filed_types_admin_page_Framework')) {
            return;
        }
        self::$_aFieldTypeDefinitions['admin_page_framework'] = apply_filters("field_types_admin_page_framework", self::$_aFieldTypeDefinitions['admin_page_framework']);
    }
    private function _getSavedData($aDefaultValues) {
        $_aSavedData = $this->getAsArray($this->callBack($this->aCallbacks['saved_data'], array($aDefaultValues,))) + $aDefaultValues;
        $_aLastInputs = $this->getAOrB($this->getElement($_GET, 'field_errors') || isset($_GET['confirmation']), $this->_getLastInputs(), array());
        return $_aLastInputs + $_aSavedData;
    }
    private function _getLastInputs() {
        static $_aCaches = array();
        $_sKey = 'apf_tfd' . md5('temporary_form_data_' . $this->aArguments['caller_id'] . get_current_user_id());
        if (isset($_aCaches[$_sKey])) {
            return $_aCaches[$_sKey];
        }
        $_vValue = $this->getTransient($_sKey);
        $this->deleteTransient($_sKey);
        $_aCaches[$_sKey] = is_array($_vValue) ? $_vValue : array();
        return $_aCaches[$_sKey];
    }
    public function getDefaultFormValues() {
        $_oDefaultValues = new AdminPageFramework_Form_Model___DefaultValues($this->aFieldsets);
        return $_oDefaultValues->get();
    }
    protected function _formatElementDefinitions(array $aSavedData) {
        $_oSectionsetsFormatter = new AdminPageFramework_Form_Model___FormatSectionsets($this->aSectionsets, $this->aArguments['structure_type'], $this->sCapability, $this->aCallbacks, $this);
        $this->aSectionsets = $_oSectionsetsFormatter->get();
        $_oFieldsetsFormatter = new AdminPageFramework_Form_Model___FormatFieldsets($this->aFieldsets, $this->aSectionsets, $this->aArguments['structure_type'], $this->aSavedData, $this->sCapability, $this->aCallbacks, $this);
        $this->aFieldsets = $_oFieldsetsFormatter->get();
    }
    public function getFieldErrors() {
        $_aErrors = $this->oFieldError->get();
        $this->oFieldError->delete();
        return $_aErrors;
    }
    public function setLastInputs(array $aLastInputs) {
        return $this->setTransient('apf_tfd' . md5('temporary_form_data_' . $this->aArguments['caller_id'] . get_current_user_id()), $aLastInputs, 60 * 60);
    }
}