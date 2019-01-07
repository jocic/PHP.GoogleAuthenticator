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
    
    use Jocic\Encoders\Base\Base32;
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
         * Size of the generated QR codes - width & height.
         * 
         * @var    integer
         * @access private
         */
        
        private $qrCodeSize = null;
        
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
         * Generates the QR code based on the set parameters and returns it's
         * location. If the QR code was already generated only the location is
         * returned.
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
         * Generates the QR code based on the set parameters and returns it's
         * filename. If the QR code was already generated only the filename is
         * returned.
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
         * @param integer $bufferSize
         *   Buffer size in bytes that will be used for loading.
         * @return string
         *   Encoded value of the QR code - Base 32 encoding.
         */
        
        public function getEncodedValue($account, $bufferSize = 1024)
        {
            // Core Variables
            
            $encoder = new Base32();
            
            // File Variables
            
            $fileLocation = $this->getFileLocation($account);
            $fileHandler  = null;
            $fileData     = null;
            
            // Logic
            
            try
            {
                $fileHandler = fopen($fileLocation, "r");
                
                while (!feof($fileHandler))
                {
                    $fileData .= fread($fileHandler, $bufferSize);
                }
                
                fclose($fileHandler);
            }
            catch (\Exception $e) {}
            
            return $encoder->encode($fileData);
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
         * @param object $account
         *   Account that should be used for generating the QR code.
         * @return string
         *   Formed url that can be used for generating QR codes.
         */
        
        public function getUrl($account)
        {
            // Core Variables
            
            $codeSize = $this->getQrCodeSize();
            
            // Format Variables
            
            $otpFormat  = "otpauth://totp/%s?secret=%s";
            $urlFormat  = "https://chart.googleapis.com/chart?chs=%s&" .
                "chld=M|0&cht=qr&chl=%s";
            
            // Other Variables
            
            $otpRequest = "";
            $identifier = "";
            $secret     = "";
            
            // Step 1 - Check Account Object
            
            if (!($account instanceof Account))
            {
                throw new \Exception("Invalid object provided.");
            }
            
            // Step 2 - Check Account Secret
            
            if ($account->getAccountSecret() == null)
            {
                throw new \Exception("Set account is without a secret.");
            }
            
            // Step 3 - Check Account Details
            
            if ($account->getServiceName() == "" && $account->getAccountName())
            {
                throw new \Exception("Set account is without details.");
            }
            
            // Step 4 - Generate Identifier & Secret
            
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
            
            // Step 5 - Generate & Return URL
            
            $otpRequest = sprintf($otpFormat, $identifier, $secret);
            
            return sprintf($urlFormat, ($codeSize . "x" . $codeSize), urlencode($otpRequest));
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
        
        public function setApiKey($apiKey)
        {
            // Logic
            
            throw new \Exception("Google's API doesn't require a key: $apiKey");
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
         * @param integer $bufferSize
         *   Buffer size in bytes that will be used for loading.
         * @return string
         *   Filename of a generated QR code.
         */
        
        public function generate($account, $bufferSize = 1024)
        {
            // Core Variables
            
            $requestUrl = $this->getUrl($account);
            $directory  = $this->getStorageDirectory();
            $filename   = sha1($requestUrl) . ".png";
            
            // File Variables
            
            $fileHandler  = null;
            $bytesWritten = 0;
            $fileLocation = "." . DIRECTORY_SEPARATOR . $filename;
            
            // Other Variables
            
            $temp = null;
            
            // Step 1 - Determine File Location
            
            if ($directory != null)
            {
                $fileLocation = $directory . DIRECTORY_SEPARATOR . $filename;
            }
            
            // Step 2 - Generate QR Code & Return It's Location
            
            if (!is_file($fileLocation))
            {
                // Get QR Code
                
                try
                {
                    $fileHandler = fopen($requestUrl, "r");
                    
                    while (!feof($fileHandler))
                    {
                        $temp .= fread($fileHandler, $bufferSize);
                    }
                    
                    fclose($fileHandler);
                }
                catch (\Exception $e) {}
                
                // Save QR Code
                
                try
                {
                    $fileHandler = fopen($fileLocation, "w");
                    
                    $bytesWritten = fwrite($fileHandler, $temp);
                    
                    fclose($fileHandler);
                }
                catch (\Exception $e) {}
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
        
        // OTHER METHODS GO HERE
    }
    
?>
