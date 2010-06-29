<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 **/

/**
 * @package Omeka
 * @subpackage Controllers
 * @author CHNM
 * @copyright Center for History and New Media, 2007-2010
 **/
class SecurityController extends Omeka_Controller_Action
{    
    public function indexAction() {
        $this->_forward('edit');
    }
    
    public function browseAction() {
        $this->_forward('edit');
    }
    
    public function editAction() {
        //Any changes to this list should be reflected in the install script (and possibly the view functions)        
        $options = array(Omeka_Validate_File_Extension::WHITELIST_OPTION,
                         'file_mime_type_whitelist',
                         'disable_default_file_validation',
                         'enable_header_check_for_file_mime_types');
        
        //process the form
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                if (in_array($key, $options)) {
                    set_option($key, $value);
                }
            }          
            $this->flashSuccess("The security settings have been updated.");
        }        
    }
    
    public function getFileExtensionWhitelistAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        if ($this->_getParam('default')) {
            $body = Omeka_Validate_File_Extension::DEFAULT_WHITELIST;
        } else {
            $body = get_option(Omeka_Validate_File_Extension::WHITELIST_OPTION);
        }
        $this->getResponse()->setBody($body);
    }
    
    public function getFileMimeTypeWhitelistAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        if ($this->_getParam('default')) {
            $body = Omeka_Validate_File_MimeType::DEFAULT_WHITELIST;
        } else {
            $body = get_option('file_mime_type_whitelist');
        }
        $this->getResponse()->setBody($body);
    }
}