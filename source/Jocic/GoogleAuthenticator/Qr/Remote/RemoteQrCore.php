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
    
    use Jocic\Encoders\Base\Base16;
    use Jocic\Encoders\Base\Base32;
    use Jocic\Encoders\Base\Base64;
    use Jocic\GoogleAuthenticator\Qr\QrInterface;
    use Jocic\GoogleAuthenticator\Qr\QrCore;
    use Jocic\GoogleAuthenticator\Account;
    use Jocic\GoogleAuthenticator\Helper;
    
    /**
     * <i>RemoteQrCore</i> class contains core methods used for remote QR code
     * creation - as in by utilizing online APIs.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class RemoteQrCore extends QrCore
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        /**
         * Encoding constant - for getting QR code image in <i>Base 16</i>.
         * 
         * @var    integer
         * @access public
         */
        
        const E_BASE_16 = 0;
        
        /**
         * Encoding constant - for getting QR code image in <i>Base 32</i>.
         * 
         * @var    integer
         * @access public
         */
        
        const E_BASE_32 = 1;
        
        /**
         * Encoding constant - for getting QR code image in <i>Base 64</i>.
         * 
         * @var    integer
         * @access public
         */
        
        const E_BASE_64 = 2;
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Size of the generated QR codes - width & height.
         * 
         * @var    integer
         * @access protected
         */
        
        protected $qrCodeSize = null;
        
        /**
         * Directory location that should be used for storing the QR code.
         * 
         * @var    string
         * @access protected
         */
        
        protected $storageDirectory = null;
        
        /**
         * API key that should be used for generating QR codes.
         * 
         * @var    string
         * @access protected
         */
        
        protected $apiKey = null;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        /**
         * Constructor for the class <i>RemoteQrCore</i>. It's used
         * for setting core class parameters upon object instantiation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $apiKey
         *   API key that should be set.
         * @param integer $qrCodeSize
         *   Size of the QR codes that should be generated.
         * @param string $storageDirectory
         *   Storage directory that should be set.
         * @return void
         */
        
        public function __construct($apiKey = null, $qrCodeSize = null,
            $storageDirectory = null)
        {
            // Step 1 - Handle API Key
            
            if ($apiKey != null)
            {
                $this->setApiKey($apiKey);
            }
            
            // Step 2 - Handle QR Code Size
            
            if ($qrCodeSize != null)
            {
                $this->setQrCodeSize($qrCodeSize);
            }
            
            // Step 3 - Handle Storage Directory
            
            if ($storageDirectory != null)
            {
                $this->setStorageDirectory($storageDirectory);
            }
        }
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns set QR code size - width and height.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return integer
         *   Set QR code size.
         */
        
        public function getQrCodeSize()
        {
            // Logic
            
            return $this->qrCodeSize;
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
         * Returns API key used for generating QR codes.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   API key used for generating QR codes.
         */
        
        public function getApiKey()
        {
            // Logic
            
            return $this->apiKey;
        }
        
        /**
         * Generates the QR code based on the set parameters and
         * returns it's location. If the QR code was already
         * generated only the location is returned.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         *   Return location of the generated QR code.
         */
        
        public function getFileLocation($account)
        {
            // Step 1 - Check Parameters
            
            if ($this->qrCodeSize == null)
            {
                throw new \Exception("QR code size wasn't set.");
            }
            
            // Step 2 - Generate QR Code & Return It's Location
            
            if ($this->getStorageDirectory() == null)
            {
                return "." . DIRECTORY_SEPARATOR . $this->generate($account);
            }
            
            return join(DIRECTORY_SEPARATOR, [
                $this->getStorageDirectory(),
                $this->generate($account)
            ]);
        }
        
        /**
         * Generates the QR code based on the set parameters and
         * returns it's filename. If the QR code was already generated
         * only the filename is returned.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         *   Return filename of the generated QR code.
         */
        
        public function getFilename($account)
        {
            // Step 1 - Check Parameters
            
            if ($this->qrCodeSize == null)
            {
                throw new \Exception("QR code size wasn't set.");
            }
            
            // Step 2 - Generate QR Code & Return It's Location
            
            return $this->generate($account);
        }
        
        /**
         * Generates the QR code based on the set parameters and
         * returns it's encoded value. If the QR code was already
         * generated only encoded value will be returned.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param $account
         *   Account that should be used for generating the QR code.
         * @param integer $encoding
         *   ID of an encoding that should be used.
         * @return string
         *   Encoded value of the QR code in a selected format.
         */
        
        public function getEncodedValue($account, $encoding = 1)
        {
            // Core Variables
            
            $encoder      = null;
            $codeLocation = $this->getFileLocation($account);
            
            // Step 1 - 
            
            switch ($encoding)
            {
                case 0:
                    $encoder = new Base16();
                    break;
                
                case 1:
                    $encoder = new Base32();
                    break;
                
                case 2:
                    $encoder = new Base64();
                    break;
                
                default:
                    throw new \Exception("Invalid encoding ID provided.");
            }
            
            // Step 2 - Encode Generated Code
            
            return $encoder->encode($this->loadFromFile($codeLocation));
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Sets QR code size - width and height.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $qrCodeSize
         *   Size of the QR codes that should be generated.
         * @return void
         */
        
        public function setQrCodeSize($qrCodeSize)
        {
            // Logic
            
            if (!is_numeric($qrCodeSize))
            {
                throw new \Exception("Invalid value provided.");
            }
            
            $this->qrCodeSize = $qrCodeSize;
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
         * Sets API key used for generating QR codes.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $apiKey
         *   API key that should be set.
         * @return void
         */
        
        public function setApiKey($apiKey)
        {
            // Logic
            
            if (!is_string($apiKey))
            {
                throw new \Exception("Invalid API key used.");
            }
            
            $this->apiKey = $apiKey;
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
         * 
         * @param object $account
         *   Account that should be used for generating the QR code.
         * @return string
         *   Filename of a generated QR code.
         */
        
        public function generate($account)
        {
            // Core Variables
            
            $requestUrl   = $this->getUrl($account);
            $directory    = $this->getStorageDirectory();
            $filename     = sha1($requestUrl) . ".png";
            $fileLocation = "." . DIRECTORY_SEPARATOR . $filename;
            
            // Other Variables
            
            $codeData = null;
            
            // Step 1 - Determine File Location
            
            if ($directory != null)
            {
                $fileLocation = $directory . DIRECTORY_SEPARATOR . $filename;
            }
            
            // Step 2 - Generate QR Code & Return It's Location
            
            if (!is_file($fileLocation))
            {
                // Get QR Code
                
                $codeData = $this->loadFromFile($requestUrl, 1024, true);
                
                // Save QR Code
                
                $this->saveToFile($fileLocation, $codeData);
            }
            
            return $filename;
        }
        
        /**
         * Regenerates a QR code based on the set value.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $account
         *   Account that should be used for generating the QR code.
         * @return string
         *   Filename of a regenerated QR code.
         */
        
        public function regenerate($account)
        {
            // Core Variables
            
            $requestUrl = $this->getUrl($account);
            $directory  = $this->getStorageDirectory();
            $filename   = sha1($requestUrl) . ".png";
            
            // File Variables
            
            $fileLocation = "." . DIRECTORY_SEPARATOR . $filename;
            
            // Logic
            
            if ($directory != null)
            {
                $fileLocation = $directory . DIRECTORY_SEPARATOR . $filename;
            }
            
            if (is_file($fileLocation))
            {
                unlink($fileLocation);
            }
            
            return $this->generate($account);
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        // CHECK METHODS GO HERE
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        /**
         * Compiles and returns an account identifier.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $account
         *   Account that should be used for generating the identifier.
         * @return string
         *   Compiled identifier, ex. <i>Wordpress - Jon Doe</i>.
         */
        
        protected function compileIdentifier($account)
        {
            // Core Variables
            
            $identifier = "";
            
            // Logic
            
            if (   $account->getServiceName() == ""
                && $account->getAccountName() == "")
            {
                return "Default";
            }
            
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
            
            return rawurlencode($identifier);
        }
        
        /**
         * Compiles and returns an OTP/TOTP request.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $account
         *   Account that should be used for generating the request.
         * @return string
         *   Compiled request, ex. <i>otpauth://totp/XXXX?secret=XXXX</i>.
         */
        
        protected function compileRequest($account)
        {
            // Core Variables
            
            $secret     = null;
            $identifier = null;
            
            // Logic
            
            if (!($account instanceof Account))
            {
                throw new \Exception("Invalid object provided.");
            }
            
            $secret     = Helper::getInstance()->fetchSecret($account);
            $identifier = $this->compileIdentifier($account);
            
            return rawurlencode(sprintf("otpauth://totp/%s?secret=%s",
                $identifier, $secret));
        }
    }
    
?>
