<?php
    
    /*******************************************************************\
    |* Author: Djordje Jocic                                           *|
    |* Year: 2018                                                      *|
    |* License: MIT License (MIT)                                      *|
    |* =============================================================== *|
    |* Personal Website: http://www.djordjejocic.com/                  *|
    |* =============================================================== *|
    |* Permission is hereby granted, free of charge, to any person     *|
    |* obtaining a copy of this software and associated documentation  *|
    |* files (the "Software"), to deal in the Software without         *|
    |* restriction, including without limitation the rights to use,    *|
    |* copy, modify, merge, publish, distribute, sublicense, and/or    *|
    |* sell copies of the Software, and to permit persons to whom the  *|
    |* Software is furnished to do so, subject to the following        *|
    |* conditions.                                                     *|
    |* --------------------------------------------------------------- *|
    |* The above copyright notice and this permission notice shall be  *|
    |* included in all copies or substantial portions of the Software. *|
    |* --------------------------------------------------------------- *|
    |* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, *|
    |* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES *|
    |* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND        *|
    |* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT     *|
    |* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,    *|
    |* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, RISING     *|
    |* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR   *|
    |* OTHER DEALINGS IN THE SOFTWARE.                                 *|
    \*******************************************************************/
    
    namespace Jocic\GoogleAuthenticator\Qr\Remote;
    
    use Jocic\GoogleAuthenticator\Qr\QrInterface;
    use Jocic\GoogleAuthenticator\Qr\QrCore;
    use Jocic\GoogleAuthenticator\Account;
    use Jocic\GoogleAuthenticator\Helper;
    
    /**
     * <i>GoQr</i> class is used for generating QR codes using pubilcly
     * available GoQr's API.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class GoQr extends RemoteQrCore implements QrInterface,
        RemoteQrInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        // CORE VARIABLES GO HERE
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        /**
         * Constructor for the class <i>GoQr</i>. It's used for setting core
         * class parameters upon object instantiation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $qrCodeSize
         *   Size of the QR codes that should be generated.
         * @param string $storageDirectory
         *   Storage directory that should be set.
         * @return void
         */
        
        public function __construct($qrCodeSize = null, $storageDirectory = null)
        {
            // Step 1 - Handle QR Code Size
            
            if ($qrCodeSize != null)
            {
                $this->setQrCodeSize($qrCodeSize);
            }
            
            // Step 2 - Handle Storage Directory
            
            if ($storageDirectory != null)
            {
                $this->setStorageDirectory($storageDirectory);
            }
        }
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Generally this method is used for getting the set API key of a remote
         * QR code generator, but as GoQr's API doesn't require it, method
         * will only throw an exception.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function getApiKey()
        {
            // Logic
            
            throw new \Exception("API doesn't require a key.");
        }
        
        /**
         * Forms and returns an appropriate URL for that can be used for
         * generating QR codes remotely by sending a GET request.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $account
         *   Account that should be used for generating the QR code.
         * @return string
         *   Formed url that can be used for generating QR codes.
         */
        
        public function getUrl($account)
        {
            // Core Variables
            
            $urlFormat = "https://api.qrserver.com/v1/create-qr-code/?" .
                "size=%s&data=%s";
            $codeSize  = $this->getQrCodeSize();
            
            // Logic
            
            return vsprintf($urlFormat, [
                "code-size" => ($codeSize . "x" . $codeSize),
                "request"   => $this->compileRequest($account)
            ]);
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Generally this method is used for setting the API key of a remote
         * QR code generator, but as GoQr's API doesn't require it, method
         * will only throw an exception.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $apiKey
         *   API key that should be used.
         * @return void
         */
        
        public function setApiKey($apiKey)
        {
            // Logic
            
            throw new \Exception("API doesn't require a key: $apiKey");
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        // CORE METHODS GO HERE
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        // CHECK METHODS GO HERE
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        // OTHER METHODS GO HERE
    }
    
?>
