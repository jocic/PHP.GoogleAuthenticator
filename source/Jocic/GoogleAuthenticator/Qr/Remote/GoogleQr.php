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
    use Jocic\GoogleAuthenticator\Account;
    
    /**
     * <i>GoogleQr</i> class is used for generating QR codes using pubilcly
     * available Google's API.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class GoogleQr implements QrInterface, RemoteQrInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Account object that should be used for generating the QR code.
         * 
         * @var    string
         * @access private
         */
        
        private $account = null;
        
        /**
         * Directory location that should be used for storing the QR code.
         * 
         * @var    string
         * @access private
         */
        
        private $storageDirectory = null;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        /**
         * Constructor for the class <i>GoogleQr</i>. It's used for setting
         * core class parameters upon object instantiation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $account
         *   Account object that should be set.
         * @param string $storageDirectory
         *   Storage directory that should be set.
         * @return void
         */
        
        public function __construct($account = null, $storageDirectory = null)
        {
            // Step 1 - Handle Account
            
            if ($account != null)
            {
                $this->setAccount($account);
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
         * Returns set account used for QR code creation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return object
         *   Set account.
         */
        
        public function getAccount()
        {
            // Logic
            
            return $this->account;
        }
        
        /**
         * Returns get directory used for storing generated QR codes.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Set storage directory.
         */
        
        public function getStorageDirectory()
        {
            // Logic
            
            return $this->storageDirectory;
        }
        
        /**
         * Generates the QR code based on the set parameters and returns it's
         * absolute location. If the QR code was already generated only the
         * location is returned.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         *   Return absolute location of the generated QR code.
         */
        
        public function getAbsoluteLocation()
        {
            // Step 1 - Check Parameters
            
            if (!$this->areParametersValid())
            {
                throw new \Exception("Account or storage directory wasn't set.");
            }
            
            // Step 2 - Generate QR Code & Return It's Location
            
            return join(DIRECTORY_SEPARATOR, [
                $this->getStorageDirectory().
                $this->generate()
            ]);
        }
        
        /**
         * Generates the QR code based on the set parameters and returns it's
         * relative location. If the QR code was already generated only the
         * location is returned.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         *   Return relative location of the generated QR code.
         */
        
        public function getRelativeLocation()
        {
            // Step 1 - Check Parameters
            
            if (!$this->areParametersValid())
            {
                throw new \Exception("Account or storage directory wasn't set.");
            }
            
            // Step 2 - Generate QR Code & Return It's Location
            
            return $this->generate();
        }
        
        /**
         * Generates the QR code based on the set parameters and returns it's
         * encoded value. If the QR code was already generated only encoded
         * value will be returned.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Encoded value of the generated QR code in <i>Base 32</i> format.
         */
        
        public function getEncodedValue()
        {
            // Logic
            
            // TBI
        }
        
        /**
         * Generally this method is used for getting the set API key of a remote
         * QR code generator, but as Google's API doesn't require it, method
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
            
            throw new \Exception("Google's API doesn't require a key.");
        }
        
        /**
         * Forms and returns an appropriate URL for that can be used for
         * generating QR codes remotely by sending a GET request.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Formed r
         */
        
        public function getUrl()
        {
            // Core Variables
            
            $account    = $this->getAccount();
            $identifier = "";
            $secret     = "";
            
            // Other Variables
            
            $otpFormat = "otpauth://totp/%s?secret=%s";
            $urlFormat = "https://chart.googleapis.com/chart?chs=200x200&" .
                "chld=M|0&cht=qr&chl=%s";
            
            // Step 1 - Check Account Secret
            
            if ($account->getAccountSecret() == null)
            {
                throw new \Exception("Set account is without a secret.");
            }
            
            // Step 2 - Check Account Details
            
            if ($account->getServiceName() == "" && $account->getAccountName())
            {
                throw new \Exception("Set account is without details.");
            }
            
            // Step 3 - Generate Identifier & Secret
            
            if ($account->getServiceName() != "")
            {
                $identifier .= $account->getServiceName();
            }
            
            if ($account->getAccountName() != "")
            {
                if ($identifier != "")
                {
                    $identifier .= " - ";
                }
                
                $identifier .= $account->getAccountName();
            }
            
            $secret = $account->getAccountSecret()->getValue();
                
            // Step 4 - Generate & Return URL
            
            $otpRequest = sprintf($otpFormat, $identifier, $secret);
            
            return sprintf($urlFormat, urlencode($otpRequest));
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Sets account used for QR code creation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $account
         *   Account that should be used for QR creation.
         * @return void
         */
        
        public function setAccount($account)
        {
            // Logic
            
            if (!($account instanceof Account))
            {
                throw new \Exception("Invalid object used.");
            }
            
            $this->account = $account;
        }
        
        /**
         * Sets directory used for storing generated QR codes.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $directory
         *   Directory for storing generated QR codes.
         * @return void
         */
        
        public function setStorageDirectory($storageDirectory)
        {
            // Logic
            
            if (!is_string($storageDirectory))
            {
                throw new \Exception("Invalid storage directory used.");
            }
            
            $this->storageDirectory = $storageDirectory;
        }
        
        /**
         * Generally this method is used for setting the API key of a remote
         * QR code generator, but as Google's API doesn't require it, method
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
        
        public function setApiKey($apiKey = null)
        {
            // Logic
            
            throw new \Exception("Google's API doesn't require a key.");
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Generates a QR code based on the set value.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         */
        
        public function generate()
        {
            // Core Variables
            
            $url      = $this->getUrl();
            $filename = sha1($url) . ".png";
            
            // Logic
            
            // TBI
        }
        
        /**
         * Regenerates a QR code based on the set value.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         */
    
        public function regenerate()
        {
            // Core Variables
            
            $url      = $this->getUrl();
            $filename = sha1($url) . ".png";
        
            // Logic
            
            // TBI
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Checks if set parameters are valid and can be used for generating
         * the QR code or not.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return bool
         *   Value <i>TRUE</i> if parameters are valid, and vice versa.
         */
        
        public function areParametersValid()
        {
            // Logic
            
            return !($this->account == null || $this->storageDirectory == null);
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        // OTHER METHODS GO HERE
    }
    
?>
