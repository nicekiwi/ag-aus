<?php
/**
 * @category       PHP5.4 Progress Bar
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012, Pierre-Henry Soria. All Rights Reserved.
 * @license        CC-BY License - http://creativecommons.org/licenses/by/3.0/
 * @version        1.0.0
 */

class Upload
{

    private $_sProgressKey;

    public function __construct()
    {
        // Session initialization
        if ('' === session_id()) session_start();
        
        // You can also retrieve the session this way.
        $this->_sProgressKey = strtolower(ini_get('session.upload_progress.prefix') . $_POST[ini_get('session.upload_progress.name')]);
        
    }

    /**
     * @return integer Percentage increase.
     */
    public function progress()
    {
        if(!empty($_SESSION[$this->_sProgressKey]))
        {
            $aData = $_SESSION[$this->_sProgressKey];
            $iProcessed = $aData['bytes_processed'];
            $iLength = $aData['content_length'];
            $iProgress = ceil(100*$iProcessed / $iLength);
        }
        else
        {
            $iProgress = 100;
        }

        return $iProgress;
    }

    /**
     * Cancel the file download.
     *
     * @return object this
     */
    public function cancel()
    {
        if (!empty($_SESSION[$this->_sProgressKey]))
            $_SESSION[$this->_sProgressKey]['cancel_upload'] = true;

        return $this;
    }

}
