<?php
/**
 Admin Page Framework v3.5.8b03 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class AdminPageFramework_Page_Model extends AdminPageFramework_Form_Controller {
    static protected $_aScreenIconIDs = array('edit', 'post', 'index', 'media', 'upload', 'link-manager', 'link', 'link-category', 'edit-pages', 'page', 'edit-comments', 'themes', 'plugins', 'users', 'profile', 'user-edit', 'tools', 'admin', 'options-general', 'ms-admin', 'generic',);
    static protected $_aStructure_InPageTabElements = array('page_slug' => null, 'tab_slug' => null, 'title' => null, 'order' => null, 'show_in_page_tab' => true, 'parent_tab_slug' => null, 'url' => null,);
    protected function _finalizeInPageTabs() {
        if (!$this->oProp->isPageAdded()) {
            return;
        }
        foreach ($this->oProp->aPages as $sPageSlug => $aPage) {
            if (!isset($this->oProp->aInPageTabs[$sPageSlug])) {
                continue;
            }
            $this->oProp->aInPageTabs[$sPageSlug] = $this->oUtil->addAndApplyFilter($this, "tabs_{$this->oProp->sClassName}_{$sPageSlug}", $this->oProp->aInPageTabs[$sPageSlug]);
            foreach ($this->oProp->aInPageTabs[$sPageSlug] as & $aInPageTab) {
                $aInPageTab = $this->_formatInPageTab($aInPageTab);
            }
            uasort($this->oProp->aInPageTabs[$sPageSlug], array($this, '_sortByOrder'));
            foreach ($this->oProp->aInPageTabs[$sPageSlug] as $sTabSlug => & $aInPageTab) {
                if (!isset($aInPageTab['tab_slug'])) {
                    continue;
                }
                $this->oProp->aDefaultInPageTabs[$sPageSlug] = $aInPageTab['tab_slug'];
                break;
            }
        }
    }
    private function _formatInPageTab(array $aInPageTab) {
        $aInPageTab = $aInPageTab + self::$_aStructure_InPageTabElements;
        $aInPageTab['order'] = is_null($aInPageTab['order']) ? 10 : $aInPageTab['order'];
        return $aInPageTab;
    }
    public function _replyToFinalizeInPageTabs() {
        $this->_finalizeInPageTabs();
    }
}