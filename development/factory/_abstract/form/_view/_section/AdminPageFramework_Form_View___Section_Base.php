<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2015 Michael Uno; Licensed MIT
 * 
 */

/**
 * Provides shared methods for rendering forms.
 * 
 * @package     AdminPageFramework
 * @subpackage  Form
 * @since       DEVVER      
 * @internal
 */
class AdminPageFramework_Form_View___Section_Base extends AdminPageFramework_Form_Base {
     
    /**
     * @since       DEVVER
     * @return      boolean
     */
    public function isSectionsetVisible( $aSectionset ) {
        if ( empty( $aSectionset ) ) {
            return false;
        }        
        return $this->callBack( 
            $this->aCallbacks[ 'is_sectionset_visible' ], 
            array( true, $aSectionset ) 
        );        
    }

    /**
     * @since       DEVVER
     * @return      boolean
     */    
    public function isFieldsetVisible( $aFieldset ) {
        if ( empty( $aFieldset ) ) {
            return false;
        }
        return $this->callBack( 
            $this->aCallbacks[ 'is_fieldset_visible' ], 
            array( true, $aFieldset ) 
        );
    }
 
    /**
     * The output of the fieldset.
     *
     * @remark      Accessed from section title class and fieldset table row class.
     * @return      string
     */
    public function getFieldsetOutput( $aFieldset ) {

        // check if the field is visible
        if ( ! $this->isFieldsetVisible( $aFieldset ) ) {          
            return '';
        }

// @todo rename the class
        $_oFieldset = new AdminPageFramework_FormFieldset( 
            $aFieldset, 
            $this->aSavedData,    // passed by reference. @todo: examine why it needs to be passed by reference.
            $this->aFieldErrors, 
            $this->aFieldTypeDefinitions, 
            $this->oMsg,
            $this->aCallbacks // field output element callables.
        );
        $_sFieldOutput = $_oFieldset->get(); // field output

        return $_sFieldOutput;
        
    } 
    
}