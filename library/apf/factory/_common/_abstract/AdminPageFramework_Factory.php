<?php 
/**
	Admin Page Framework v3.7.9b05 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/admin-page-framework>
	Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
abstract class AdminPageFramework_Factory_Router {
    public $oProp;
    public $oDebug;
    public $oUtil;
    public $oMsg;
    public $oForm;
    protected $oPageLoadInfo;
    protected $oResource;
    protected $oHeadTag;
    protected $oHelpPane;
    protected $oLink;
    protected $_aSubClassNames = array('oDebug', 'oUtil', 'oMsg', 'oForm', 'oPageLoadInfo', 'oResource', 'oHelpPane', 'oLink',);
    public function __construct($oProp) {
        unset($this->oDebug, $this->oUtil, $this->oMsg, $this->oForm, $this->oPageLoadInfo, $this->oResource, $this->oHelpPane, $this->oLink);
        $this->oProp = $oProp;
        if ($this->oProp->bIsAdmin && !$this->oProp->bIsAdminAjax) {
            if (did_action('current_screen')) {
                $this->_replyToLoadComponents();
            } else {
                add_action('current_screen', array($this, '_replyToLoadComponents'));
            }
        }
        $this->start();
    }
    public function _replyToLoadComponents() {
        if ('plugins.php' === $this->oProp->sPageNow) {
            $this->oLink = $this->oLink;
        }
        if (!$this->_isInThePage()) {
            return;
        }
        if (in_array($this->oProp->_sPropertyType, array('widget')) && 'customize.php' !== $this->oProp->sPageNow) {
            return;
        }
        $this->_setSubClasses();
    }
    private function _setSubClasses() {
        $this->oResource = $this->oResource;
        $this->oHeadTag = $this->oResource;
        $this->oLink = $this->oLink;
        $this->oPageLoadInfo = $this->oPageLoadInfo;
    }
    protected function _isInstantiatable() {
        return true;
    }
    public function _isInThePage() {
        return true;
    }
    protected function _getFormInstance($oProp) {
        $oProp->setFormProperties();
        $_sFormClass = "AdminPageFramework_Form_{$oProp->_sPropertyType}";
        return new $_sFormClass($oProp->aFormArguments, $oProp->aFormCallbacks, $this->oMsg);
    }
    protected $_aResourceClassNameMap = array('admin_page' => 'AdminPageFramework_Resource_Page', 'network_admin_page' => 'AdminPageFramework_Resource_Page', 'post_meta_box' => 'AdminPageFramework_Resource_MetaBox', 'page_meta_box' => 'AdminPageFramework_Resource_MetaBox_Page', 'post_type' => 'AdminPageFramework_Resource_PostType', 'taxonomy_field' => 'AdminPageFramework_Resource_TaxonomyField', 'widget' => 'AdminPageFramework_Resource_Widget', 'user_meta' => 'AdminPageFramework_Resource_UserMeta',);
    protected function _getResourceInstance($oProp) {
        return $this->_getInstanceByMap($this->_aResourceClassNameMap, $oProp->sStructureType, $oProp);
    }
    protected $_aHelpPaneClassNameMap = array('admin_page' => 'AdminPageFramework_HelpPane_Page', 'network_admin_page' => 'AdminPageFramework_HelpPane_Page', 'post_meta_box' => 'AdminPageFramework_HelpPane_MetaBox', 'page_meta_box' => 'AdminPageFramework_HelpPane_MetaBox_Page', 'post_type' => null, 'taxonomy_field' => 'AdminPageFramework_HelpPane_TaxonomyField', 'widget' => 'AdminPageFramework_HelpPane_Widget', 'user_meta' => 'AdminPageFramework_HelpPane_UserMeta',);
    protected function _getHelpPaneInstance($oProp) {
        return $this->_getInstanceByMap($this->_aHelpPaneClassNameMap, $oProp->sStructureType, $oProp);
    }
    protected $_aLinkClassNameMap = array('admin_page' => 'AdminPageFramework_Link_Page', 'network_admin_page' => 'AdminPageFramework_Link_NetworkAdmin', 'post_meta_box' => null, 'page_meta_box' => null, 'post_type' => 'AdminPageFramework_Link_PostType', 'taxonomy_field' => null, 'widget' => null, 'user_meta' => null,);
    protected function _getLinkInstancce($oProp, $oMsg) {
        return $this->_getInstanceByMap($this->_aLinkClassNameMap, $oProp->sStructureType, $oProp, $oMsg);
    }
    protected $_aPageLoadClassNameMap = array('admin_page' => 'AdminPageFramework_PageLoadInfo_Page', 'network_admin_page' => 'AdminPageFramework_PageLoadInfo_NetworkAdminPage', 'post_meta_box' => null, 'page_meta_box' => null, 'post_type' => 'AdminPageFramework_PageLoadInfo_PostType', 'taxonomy_field' => null, 'widget' => null, 'user_meta' => null,);
    protected function _getPageLoadInfoInstance($oProp, $oMsg) {
        if (!isset($this->_aPageLoadClassNameMap[$oProp->sStructureType])) {
            return null;
        }
        $_sClassName = $this->_aPageLoadClassNameMap[$oProp->sStructureType];
        return call_user_func_array(array($_sClassName, 'instantiate'), array($oProp, $oMsg));
    }
    private function _getInstanceByMap() {
        $_aParams = func_get_args();
        $_aClassNameMap = array_shift($_aParams);
        $_sKey = array_shift($_aParams);
        if (!isset($_aClassNameMap[$_sKey])) {
            return null;
        }
        $_iParamCount = count($_aParams);
        if ($_iParamCount > 3) {
            return null;
        }
        array_unshift($_aParams, $_aClassNameMap[$_sKey]);
        return call_user_func_array(array($this, "_replyToGetClassInstanceByArgumentOf{$_iParamCount}"), $_aParams);
    }
    private function _replyToGetClassInstanceByArgumentOf0($sClassName) {
        return new $sClassName;
    }
    private function _replyToGetClassInstanceByArgumentOf1($sClassName, $mArg) {
        return new $sClassName($mArg);
    }
    private function _replyToGetClassInstanceByArgumentOf2($sClassName, $mArg1, $mArg2) {
        return new $sClassName($mArg1, $mArg2);
    }
    private function _replyToGetClassInstanceByArgumentOf3($sClassName, $mArg1, $mArg2, $mArg3) {
        return new $sClassName($mArg1, $mArg2, $mArg3);
    }
    public function __get($sPropertyName) {
        switch ($sPropertyName) {
            case 'oHeadTag':
                $sPropertyName = 'oResource';
            break;
        }
        if (in_array($sPropertyName, $this->_aSubClassNames)) {
            return call_user_func(array($this, "_replyTpSetAndGetInstance_{$sPropertyName}"));
        }
    }
    public function _replyTpSetAndGetInstance_oUtil() {
        $this->oUtil = new AdminPageFramework_FrameworkUtility;
        return $this->oUtil;
    }
    public function _replyTpSetAndGetInstance_oDebug() {
        $this->oDebug = new AdminPageFramework_Debug;
        return $this->oDebug;
    }
    public function _replyTpSetAndGetInstance_oMsg() {
        $this->oMsg = AdminPageFramework_Message::getInstance($this->oProp->sTextDomain);
        return $this->oMsg;
    }
    public function _replyTpSetAndGetInstance_oForm() {
        $this->oForm = $this->_getFormInstance($this->oProp);
        return $this->oForm;
    }
    public function _replyTpSetAndGetInstance_oResource() {
        $this->oResource = $this->_getResourceInstance($this->oProp);
        return $this->oResource;
    }
    public function _replyTpSetAndGetInstance_oHelpPane() {
        $this->oHelpPane = $this->_getHelpPaneInstance($this->oProp);
        return $this->oHelpPane;
    }
    public function _replyTpSetAndGetInstance_oLink() {
        $this->oLink = $this->_getLinkInstancce($this->oProp, $this->oMsg);
        return $this->oLink;
    }
    public function _replyTpSetAndGetInstance_oPageLoadInfo() {
        $this->oPageLoadInfo = $this->_getPageLoadInfoInstance($this->oProp, $this->oMsg);
        return $this->oPageLoadInfo;
    }
    public function __call($sMethodName, $aArguments = null) {
        $_mFirstArg = $this->oUtil->getElement($aArguments, 0);
        switch ($sMethodName) {
            case 'validate':
            case 'content':
                return $_mFirstArg;
            case 'setup_pre':
                $this->_setUp();
                $this->oUtil->addAndDoAction($this, "set_up_{$this->oProp->sClassName}", $this);
                return;
        }
        if (has_filter($sMethodName)) {
            return $this->_getAutoCallback($sMethodName, $aArguments);
        }
        $this->_triggerUndefinedMethodWarning($sMethodName);
    }
    private function _getAutoCallback($sMethodName, $aArguments) {
        if (false === strpos($sMethodName, "\\")) {
            return $this->oUtil->getElement($aArguments, 0);
        }
        $_sAutoCallbackClassName = str_replace('\\', '_', $this->oProp->sClassName);
        return method_exists($this, $_sAutoCallbackClassName) ? call_user_func_array(array($this, $_sAutoCallbackClassName), $aArguments) : $this->oUtil->getElement($aArguments, 0);
    }
    private function _triggerUndefinedMethodWarning($sMethodName) {
        trigger_error(AdminPageFramework_Registry::NAME . ': ' . sprintf(__('The method is not defined: %1$s', $this->oProp->sTextDomain), $sMethodName), E_USER_WARNING);
    }
    public function __toString() {
        return $this->oUtil->getObjectInfo($this);
    }
    public function setFooterInfoRight() {
    }
    public function setFooterInfoLeft() {
    }
}
abstract class AdminPageFramework_Factory_Model extends AdminPageFramework_Factory_Router {
    public function __construct($oProp) {
        parent::__construct($oProp);
        add_filter('field_types_' . $oProp->sClassName, array($this, '_replyToFilterFieldTypeDefinitions'));
    }
    protected function _setUp() {
        $this->setUp();
    }
    public function _replyToFieldsetResourceRegistration($aFieldset) {
        $aFieldset = $aFieldset + array('help' => null, 'title' => null, 'help_aside' => null,);
        if (!$aFieldset['help']) {
            return;
        }
        $this->oHelpPane->_addHelpTextForFormFields($aFieldset['title'], $aFieldset['help'], $aFieldset['help_aside']);
    }
    public function _replyToFilterFieldTypeDefinitions($aFieldTypeDefinitions) {
        if (method_exists($this, 'field_types_' . $this->oProp->sClassName)) {
            return call_user_func_array(array($this, 'field_types_' . $this->oProp->sClassName), array($aFieldTypeDefinitions));
        }
        return $aFieldTypeDefinitions;
    }
    public function _replyToModifySectionsets($aSectionsets) {
        return $this->oUtil->addAndApplyFilter($this, "sections_{$this->oProp->sClassName}", $aSectionsets);
    }
    public function _replyToModifyFieldsets($aFieldsets, $aSectionsets) {
        foreach ($aFieldsets as $_sSectionPath => $_aFields) {
            $_aSectionPath = explode('|', $_sSectionPath);
            $_sFilterSuffix = implode('_', $_aSectionPath);
            $aFieldsets[$_sSectionPath] = $this->oUtil->addAndApplyFilter($this, "fields_{$this->oProp->sClassName}_{$_sFilterSuffix}", $_aFields);
        }
        $aFieldsets = $this->oUtil->addAndApplyFilter($this, "fields_{$this->oProp->sClassName}", $aFieldsets);
        if (count($aFieldsets)) {
            $this->oProp->bEnableForm = true;
        }
        return $aFieldsets;
    }
    public function _replyToModifyFieldsetsDefinitions($aFieldsets) {
        return $this->oUtil->addAndApplyFilter($this, "field_definition_{$this->oProp->sClassName}", $aFieldsets);
    }
    public function _replyToModifyFieldsetDefinition($aFieldset) {
        $_sFieldPart = '_' . implode('_', $aFieldset['_field_path_array']);
        $_sSectionPart = implode('_', $aFieldset['_section_path_array']);
        $_sSectionPart = $this->oUtil->getAOrB('_default' === $_sSectionPart, '', '_' . $_sSectionPart);
        return $this->oUtil->addAndApplyFilter($this, "field_definition_{$this->oProp->sClassName}{$_sSectionPart}{$_sFieldPart}", $aFieldset, $aFieldset['_subsection_index']);
    }
    public function _replyToHandleSubmittedFormData($aSavedData, $aArguments, $aSectionsets, $aFieldsets) {
    }
    public function _replyToFormatFieldsetDefinition($aFieldset, $aSectionsets) {
        if (empty($aFieldset)) {
            return $aFieldset;
        }
        return $aFieldset;
    }
    public function _replyToFormatSectionsetDefinition($aSectionset) {
        if (empty($aSectionset)) {
            return $aSectionset;
        }
        $aSectionset = $aSectionset + array('_fields_type' => $this->oProp->_sPropertyType, '_structure_type' => $this->oProp->_sPropertyType,);
        return $aSectionset;
    }
    public function _replyToDetermineWhetherToProcessFormRegistration($bAllowed) {
        return $this->_isInThePage();
    }
    public function _replyToGetCapabilityForForm($sCapability) {
        return $this->oProp->sCapability;
    }
    public function _replyToGetSavedFormData() {
        return $this->oUtil->addAndApplyFilter($this, 'options_' . $this->oProp->sClassName, $this->oProp->aOptions);
    }
    public function getSavedOptions() {
        return $this->oForm->aSavedData;
    }
    public function getFieldErrors() {
        return $this->oForm->getFieldErrors();
    }
    protected function _getFieldErrors() {
        return $this->oForm->getFieldErrors();
    }
    public function setLastInputs(array $aLastInputs) {
        return $this->oForm->setLastInputs($aLastInputs);
    }
    public function _setLastInput($aLastInputs) {
        return $this->setLastInputs($aLastInputs);
    }
}
abstract class AdminPageFramework_Factory_View extends AdminPageFramework_Factory_Model {
    public function __construct($oProp) {
        parent::__construct($oProp);
        new AdminPageFramework_Factory_View__SettingNotice($this, $this->oProp->sSettingNoticeActionHook);
    }
    public function _replyToGetSectionName() {
        $_aParams = func_get_args() + array(null, null,);
        return $_aParams[0];
    }
    public function _replyToGetInputID() {
        $_aParams = func_get_args() + array(null, null, null, null);
        return $_aParams[0];
    }
    public function _replyToGetInputTagIDAttribute() {
        $_aParams = func_get_args() + array(null, null, null, null);
        return $_aParams[0];
    }
    public function _replyToGetFieldNameAttribute() {
        $_aParams = func_get_args() + array(null, null,);
        return $_aParams[0];
    }
    public function _replyToGetFlatFieldName() {
        $_aParams = func_get_args() + array(null, null,);
        return $_aParams[0];
    }
    public function _replyToGetInputNameAttribute() {
        $_aParams = func_get_args() + array(null, null, null);
        return $_aParams[0];
    }
    public function _replyToGetFlatInputName() {
        $_aParams = func_get_args() + array(null, null, null);
        return $_aParams[0];
    }
    public function _replyToGetInputClassAttribute() {
        $_aParams = func_get_args() + array(null, null, null, null);
        return $_aParams[0];
    }
    public function _replyToDetermineSectionsetVisibility($bVisible, $aSectionset) {
        return $this->_isElementVisible($aSectionset, $bVisible);
    }
    public function _replyToDetermineFieldsetVisibility($bVisible, $aFieldset) {
        return $this->_isElementVisible($aFieldset, $bVisible);
    }
    private function _isElementVisible($aElementDefinition, $bDefault) {
        $aElementDefinition = $aElementDefinition + array('if' => true, 'capability' => '',);
        if (!$aElementDefinition['if']) {
            return false;
        }
        if (!$aElementDefinition['capability']) {
            return true;
        }
        if (!current_user_can($aElementDefinition['capability'])) {
            return false;
        }
        return $bDefault;
    }
    public function isSectionSet(array $aFieldset) {
        $aFieldset = $aFieldset + array('section_id' => null,);
        return $aFieldset['section_id'] && '_default' !== $aFieldset['section_id'];
    }
    public function _replyToGetSectionHeaderOutput($sSectionDescription, $aSectionset) {
        return $this->oUtil->addAndApplyFilters($this, array('section_head_' . $this->oProp->sClassName . '_' . $aSectionset['section_id']), $sSectionDescription);
    }
    public function _replyToGetFieldOutput($sFieldOutput, $aFieldset) {
        $_sSectionPart = $this->oUtil->getAOrB(isset($aFieldset['section_id']) && '_default' !== $aFieldset['section_id'], '_' . $aFieldset['section_id'], '');
        return $this->oUtil->addAndApplyFilters($this, array('field_' . $this->oProp->sClassName . $_sSectionPart . '_' . $aFieldset['field_id']), $sFieldOutput, $aFieldset);
    }
}
abstract class AdminPageFramework_Factory_Controller extends AdminPageFramework_Factory_View {
    public function start() {
    }
    public function setUp() {
    }
    public function isInThePage() {
        return $this->_isInThePage();
    }
    public function setMessage($sKey, $sMessage) {
        $this->oMsg->set($sKey, $sMessage);
    }
    public function getMessage($sKey = '') {
        return $this->oMsg->get($sKey);
    }
    public function enqueueStyles($aSRCs, $_vArg2 = null) {
    }
    public function enqueueStyle($sSRC, $_vArg2 = null) {
    }
    public function enqueueScripts($aSRCs, $_vArg2 = null) {
    }
    public function enqueueScript($sSRC, $_vArg2 = null) {
    }
    public function addHelpText($sHTMLContent, $sHTMLSidebarContent = "") {
        if (method_exists($this->oHelpPane, '_addHelpText')) {
            $this->oHelpPane->_addHelpText($sHTMLContent, $sHTMLSidebarContent);
        }
    }
    public function addSettingSections() {
        foreach (func_get_args() as $_asSectionset) {
            $this->addSettingSection($_asSectionset);
        }
        $this->_sTargetSectionTabSlug = null;
    }
    public function addSettingSection($aSectionset) {
        if (!is_array($aSectionset)) {
            return;
        }
        $this->_sTargetSectionTabSlug = $this->oUtil->getElement($aSectionset, 'section_tab_slug', $this->_sTargetSectionTabSlug);
        $aSectionset['section_tab_slug'] = $this->oUtil->getAOrB($this->_sTargetSectionTabSlug, $this->_sTargetSectionTabSlug, null);
        $this->oForm->addSection($aSectionset);
    }
    public function addSettingFields() {
        foreach (func_get_args() as $_aFieldset) {
            $this->addSettingField($_aFieldset);
        }
    }
    public function addSettingField($asFieldset) {
        if (method_exists($this->oForm, 'addField')) {
            $this->oForm->addField($asFieldset);
        }
    }
    public function setFieldErrors($aErrors) {
        $this->oForm->setFieldErrors($aErrors);
    }
    public function hasFieldError() {
        return $this->oForm->hasFieldError();
    }
    public function setSettingNotice($sMessage, $sType = 'error', $asAttributes = array(), $bOverride = true) {
        $this->oForm->setSubmitNotice($sMessage, $sType, $asAttributes, $bOverride);
    }
    public function hasSettingNotice($sType = '') {
        return $this->oForm->hasSubmitNotice($sType);
    }
}
abstract class AdminPageFramework_Factory extends AdminPageFramework_Factory_Controller {
}