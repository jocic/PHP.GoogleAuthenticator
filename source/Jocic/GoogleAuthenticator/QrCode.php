<?php
    
    /*******************************************************************\
    |* Author: Djordje Jocic                                           *|
    |* Year: 2026                                                      *|
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
    
    namespace Jocic\GoogleAuthenticator;
    
    /**
     * <i>QrCode</i> class is used for generating and cashing QR Codes
     * for all the provided <i>Accounts</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class QrCode implements Interfaces\QrCodeInterface
    {
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        private int $size = 320;
        
        private string|null $directory = null;
        
        private string|null $filename = null;
        
        private string|null $path = null;
        
        private Interfaces\EncoderInterface|null $encoder = null;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        public function __construct()
        {
        
        }
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        public function getSize() : int
        {
            
            return $this->size;
        }
        
        public function getDirectory() : string|null
        {
            
            return $this->directory;
        }
        
        public function getFilename() : string|null
        {
            
            return $this->filename;
        }
        
        public function getPath() : string|null
        {
            
            return $this->path;
        }
        
        public function getEncoder() : Encoder
        {
            return $this->encoder;
        }
        
        /**
         * Generates the QR code based on the set parameters and
         * returns it's encoded value. If the QR code was already
         * generated only encoded value will be returned.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
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
        
        public function setSize(int $size) : self
        {
            if ($size <= 10)
            {
                throw new \Exception("Invalid size provided.");
            }
            
            $this->size = $size;
            
            return $this;
        }
        
        public function setDirectory(string $directory) : self
        {
            if (!is_dir($directory))
            {
                throw new \Exception("Invalid directory provided.");
            }
            
            $this->directory = $directory;
            
            $this->resolvePath();
            
            return $this;
        }
        
        public function setFilename(string $filename) : self
        {
            if (strlen($filename) == 0)
            {
                throw new \Exception("Invalid filename provided.");
            }
            
            $this->filename = $filename;
            
            $this->resolvePath();
            
            return $this;
        }
        
        public function setEncoder(Encoder $encoder) : self
        {
            $this->encoder = $encoder;
            
            return $this;
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        public function generate(Account $account) : bool
        {
            // Core Variables
            
            $otpUri = $this->compileOtpUri($account);
            
            // Logic
            
            if ($this->encoder == null)
            {
                throw new \Exception("Encoder wasn't set.");
            }
            
            $this->encoder->setSize($this->size);
            $this->encoder->setData($otpUri);
            
            if ($this->encoder->process())
            {
                
                if ($this->directory == null)
                {
                    $this->directory = sys_get_temp_dir();
                }
                
                if ($this->filename == null)
                {
                    $this->filename = hash('sha256',
                        $account->getSecret()->getValue()) . '.png';
                }
                
                $this->resolvePath();
                
                
                
                $wtf = $this->saveEncoding($this->encoder->getEncoding());
                
                return true;
            }
            
            return false;
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        private function compileOtpUri(Account $account) : string
        {
            
            // Core Variables
            
            $service = $account->getService();
            $name    = $account->getName();
            $secret  = $account->getSecret()->getValue();
            
            // Logic
            
            if (strlen($service) == 0)
            {
                $service = "Default Service";
            }
            
            if (strlen($name) == 0)
            {
                $name = "N/A";
            }
            
            return sprintf("otpauth://totp/%s:%s?secret=%s",
                $service, $name, $secret);
        }
        
        private function resolvePath() : void
        {
            // Logic
            
            $this->path = realpath($this->directory) . DIRECTORY_SEPARATOR .
                $this->filename;
        }
        
        private function saveEncoding(string $encoding) : bool
        {
            // Core Variables
            
            $fileHandler  = null;
            $bytesWritten = 0;
            
            // Logic
            
            try
            {
                $fileHandler = fopen($this->path, "w");
                
                if ($fileHandler !== false)
                {
                    $bytesWritten = fwrite($fileHandler, $encoding);
                }
            }
            catch (\Exception $e)
            {
                throw new \Exception("An unkown IO error occured.");
            }
            finally
            {
                if ($fileHandler != null)
                {
                    fclose($fileHandler);
                }
            }
            
            return $bytesWritten > 0;
        }
    }
    
?>
