<?php
/**
 Admin Page Framework v3.5.5b01 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class AdminPageFramework_Menu_Model extends AdminPageFramework_Page_Controller {
    protected $_aBuiltInRootMenuSlugs = array('dashboard' => 'index.php', 'posts' => 'edit.php', 'media' => 'upload.php', 'links' => 'link-manager.php', 'pages' => 'edit.php?post_type=page', 'comments' => 'edit-comments.php', 'appearance' => 'themes.php', 'plugins' => 'plugins.php', 'users' => 'users.php', 'tools' => 'tools.php', 'settings' => 'options-general.php', 'network admin' => "network_admin_menu",);
    protected static $_aStructure_SubMenuLinkForUser = array('type' => 'link', 'title' => null, 'href' => null, 'capability' => null, 'order' => null, 'show_page_heading_tab' => true, 'show_in_menu' => true,);
    protected static $_aStructure_SubMenuPageForUser = array('type' => 'page', 'title' => null, 'page_title' => null, 'menu_title' => null, 'page_slug' => null, 'screen_icon' => null, 'capability' => null, 'order' => null, 'show_page_heading_tab' => true, 'show_in_menu' => true, 'href_icon_32x32' => null, 'screen_icon_id' => null, 'show_page_title' => null, 'show_page_heading_tabs' => null, 'show_in_page_tabs' => null, 'in_page_tab_tag' => null, 'page_heading_tab_tag' => null,);
    public function _replyToBuildMenu() {
        if ($this->oProp->aRootMenu['fCreateRoot']) {
            $this->_registerRootMenuPage();
        }
        $this->oProp->aPages = $this->oUtil->addAndApplyFilter($this, "pages_{$this->oProp->sClassName}", $this->oProp->aPages);
        uasort($this->oProp->aPages, array($this, '_sortByOrder'));
        foreach ($this->oProp->aPages as $aPage) {
            if (!isset($aPage['page_slug'])) {
                continue;
            }
            $this->oProp->sDefaultPageSlug = $aPage['page_slug'];
            break;
        }
        foreach ($this->oProp->aPages as & $aSubMenuItem) {
            $aSubMenuItem = $this->_formatSubMenuItemArray($aSubMenuItem);
            $aSubMenuItem['_page_hook'] = $this->_registerSubMenuItem($aSubMenuItem);
        }
        if ($this->oProp->aRootMenu['fCreateRoot']) {
            remove_submenu_page($this->oProp->aRootMenu['sPageSlug'], $this->oProp->aRootMenu['sPageSlug']);
        }
        $this->oProp->_bBuiltMenu = true;
    }
    private function _registerRootMenuPage() {
        $this->oProp->aRootMenu['_page_hook'] = add_menu_page($this->oProp->sClassName, $this->oProp->aRootMenu['sTitle'], $this->oProp->sCapability, $this->oProp->aRootMenu['sPageSlug'], '', $this->oProp->aRootMenu['sIcon16x16'], $this->oUtil->getElement($this->oProp->aRootMenu, 'iPosition', null));
    }
    private function _formatSubMenuItemArray($aSubMenuItem) {
        $aSubMenuItem = $this->oUtil->getAsArray($aSubMenuItem);
        if (isset($aSubMenuItem['page_slug'])) {
            return $this->_formatSubMenuPageArray($aSubMenuItem);
        }
        if (isset($aSubMenuItem['href'])) {
            return $this->_formatSubmenuLinkArray($aSubMenuItem);
        }
        return array();
    }
    protected function _formatSubmenuLinkArray(array $aSubMenuLink) {
        if (!filter_var($aSubMenuLink['href'], FILTER_VALIDATE_URL)) {
            return array();
        }
        return array('capability' => $this->oUtil->getElement($aSubMenuLink, 'capability', $this->oProp->sCapability), 'order' => isset($aSubMenuLink['order']) && is_numeric($aSubMenuLink['order']) ? $aSubMenuLink['order'] : count($this->oProp->aPages) + 10,) + $aSubMenuLink + self::$_aStructure_SubMenuLinkForUser;
    }
    protected function _formatSubMenuPageArray(array $aSubMenuPage) {
        $aSubMenuPage = $aSubMenuPage + array('show_page_title' => $this->oProp->bShowPageTitle, 'show_page_heading_tabs' => $this->oProp->bShowPageHeadingTabs, 'show_in_page_tabs' => $this->oProp->bShowInPageTabs, 'in_page_tab_tag' => $this->oProp->sInPageTabTag, 'page_heading_tab_tag' => $this->oProp->sPageHeadingTabTag,) + self::$_aStructure_SubMenuPageForUser;
        $aSubMenuPage['screen_icon_id'] = trim($aSubMenuPage['screen_icon_id']);
        return array('href_icon_32x32' => $this->oUtil->resolveSRC($aSubMenuPage['screen_icon'], true), 'screen_icon_id' => $this->oUtil->getAOrB(in_array($aSubMenuPage['screen_icon'], self::$_aScreenIconIDs), $aSubMenuPage['screen_icon'], 'generic'), 'capability' => $this->oUtil->getElement($aSubMenuPage, 'capability', $this->oProp->sCapability), 'order' => $this->oUtil->getAOrB(is_numeric($aSubMenuPage['order']), $aSubMenuPage['order'], count($this->oProp->aPages) + 10),) + $aSubMenuPage;
    }
    private function _registerSubMenuItem(array $aArgs) {
        if (!current_user_can($aArgs['capability'])) {
            return '';
        }
        $_sRootPageSlug = $this->oProp->aRootMenu['sPageSlug'];
        $_sMenuSlug = plugin_basename($_sRootPageSlug);
        switch ($aArgs['type']) {
            case 'page':
                return $this->_addPageSubmenuItem($_sRootPageSlug, $_sMenuSlug, $aArgs['page_slug'], $this->oUtil->getElement($aArgs, 'page_title', $aArgs['title']), $this->oUtil->getElement($aArgs, 'menu_title', $aArgs['title']), $aArgs['capability'], $aArgs['show_in_menu']);
            case 'link':
                return $this->_addLinkSubmenuItem($_sMenuSlug, $aArgs['title'], $aArgs['capability'], $aArgs['href'], $aArgs['show_in_menu']);
            default:
                return '';
        }
    }
    private function _addPageSubmenuItem($sRootPageSlug, $sMenuSlug, $sPageSlug, $sPageTitle, $sMenuTitle, $sCapability, $bShowInMenu) {
        if (!$sPageSlug) {
            return '';
        }
        $_sPageHook = add_submenu_page($sRootPageSlug, $sPageTitle, $sMenuTitle, $sCapability, $sPageSlug, array($this, $this->oProp->sClassHash . '_page_' . $sPageSlug));
        if (!isset($this->oProp->aPageHooks[$_sPageHook])) {
            add_action('current_screen', array($this, "load_pre_" . $sPageSlug), 20);
        }
        $this->oProp->aPageHooks[$sPageSlug] = $this->oUtil->getAOrB(is_network_admin(), $_sPageHook . '-network', $_sPageHook);
        if ($bShowInMenu) {
            return $_sPageHook;
        }
        $this->_removePageSubmenuItem($sMenuSlug, $sMenuTitle, $sPageTitle, $sPageSlug);
        return $_sPageHook;
    }
    private function _removePageSubmenuItem($sMenuSlug, $sMenuTitle, $sPageTitle, $sPageSlug) {
        foreach (( array )$GLOBALS['submenu'][$sMenuSlug] as $_iIndex => $_aSubMenu) {
            if (!isset($_aSubMenu[3])) {
                continue;
            }
            $_aA = array($_aSubMenu[0], $_aSubMenu[3], $_aSubMenu[2],);
            $_aB = array($sMenuTitle, $sPageTitle, $sPageSlug,);
            if ($_aA !== $_aB) {
                continue;
            }
            $this->_removePageSubMenuItemByIndex($sPageSlug, $sMenuSlug, $_iIndex);
            $this->oProp->aHiddenPages[$sPageSlug] = $sMenuTitle;
            add_filter('admin_title', array($this, '_replyToFixPageTitleForHiddenPages'), 10, 2);
            break;
        }
    }
    private function _removePageSubMenuItemByIndex($sPageSlug, $sMenuSlug, $_iIndex) {
        if (is_network_admin()) {
            unset($GLOBALS['submenu'][$sMenuSlug][$_iIndex]);
            return;
        }
        if (!isset($_GET['page']) || isset($_GET['page']) && $sPageSlug != $_GET['page']) {
            unset($GLOBALS['submenu'][$sMenuSlug][$_iIndex]);
        }
    }
    private function _addLinkSubmenuItem($sMenuSlug, $sTitle, $sCapability, $sHref, $bShowInMenu) {
        if (!$bShowInMenu) {
            return;
        }
        if (!isset($GLOBALS['submenu'][$sMenuSlug])) {
            $GLOBALS['submenu'][$sMenuSlug] = array();
        }
        $GLOBALS['submenu'][$sMenuSlug][] = array($sTitle, $sCapability, $sHref,);
    }
    public function _replyToFixPageTitleForHiddenPages($sAdminTitle, $sPageTitle) {
        if (isset($_GET['page'], $this->oProp->aHiddenPages[$_GET['page']])) {
            return $this->oProp->aHiddenPages[$_GET['page']] . $sAdminTitle;
        }
        return $sAdminTitle;
    }
}