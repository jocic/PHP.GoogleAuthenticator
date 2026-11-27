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
    
    use Jocic\GoogleAuthenticator\Util;
    
    /**
     * <i>QrCode</i> class is a wrapper that manages various available
     * encoders for QR Code generation.
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
        
        /**
         * Directory in which the QR code should be generated.
         * 
         * Unspecified value will default to the system's temp directory path.
         * 
         * <strong>Example:</strong> /tmp
         * 
         * @var    string|null
         * @access private
         */
        private string|null $directory = null;
        
        /**
         * Filename of the QR code that should be generated.
         * 
         * Unspecified value will default to the hashed value of the provided
         * account's secret, followed by the extension format derived from
         * the encoder's settings.
         * 
         * <strong>Example:</strong> 322edfb8b7b...cb2230cea5fcb1.png
         * 
         * @var    string|null
         * @access private
         */
        private string|null $filename = null;
        
        /**
         * Path represents the concatination of the <i>directory</i> and the
         * <i>filename</i> variables and is resolved dynamically.
         * 
         * @var    string|null
         * @access private
         */
        private string|null $path = null;
        
        /**
         * Reference to the encoder currently used by the wrapper.
         * 
         * @var    Encoder|null
         * @access private
         */
        private Encoder|null $encoder = null;
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns the directory in which the QR code should be generated.
         * 
         * <strong>Example:</strong> /tmp
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string|null
         *   Directory in which the QR code should be generated, or
         *   <i>NULL</i> value if it wasn't set.
         */
        public function getDirectory() : string|null
        {
            // Logic
            
            return $this->directory;
        }
        
        /**
         * Returns the filename of the QR code that should be generated.
         * 
         * <strong>Example:</strong> 322edfb8b7b...cb2230cea5fcb1.png
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string|null
         *   Filename of the QR code that should be generated, or <i>NULL</i>
         *   value if it wasn't set.
         */
        public function getFilename() : string|null
        {
            // Logic
            
            return $this->filename;
        }
        
        /**
         * Returns the resolved path of the QR Code that should be generated.
         * 
         * Concatenated value of the resolved directory path and the filename
         * is returned when both directory and filename variables are set.
         * 
         * <strong>Example:</strong> /tmp/322edfb8b7b...cb2230cea5fcb1.png
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string|null
         *   Resolved path of the QR code that should be generated, or
         *   <i>NULL</i> value if no directory or filename were set.
         */
        public function getPath() : string|null
        {
            // Logic
            
            return $this->path;
        }
        
        /**
         * Returns the reference to the encoder currently used by the
         * QR Code wrapper, ex. <i>Encoders/Go</i>.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return Encoder|null
         *   Reference to the encoder, or value <i>NULL</i> if it wasn't set.
         */
        public function getEncoder() : Encoder|null
        {
            // Logic
            
            return $this->encoder;
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Sets the directory in which the QR code should be generated.
         * 
         * <strong>Example:</strong> /tmp
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $directory
         *   Directory in which the QR code should be generated.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setDirectory(string $directory) : self
        {
            // Logic
            
            $directory = realpath(trim($directory));
            
            if (!is_dir($directory))
            {
                throw new \Exception("Invalid directory provided.");
            }
            
            $this->directory = $directory;
            
            $this->resolvePath();
            
            return $this;
        }
        
        /**
         * Sets the filename in which the QR code should be generated.
         * 
         * <strong>Example:</strong> 322edfb8b7b...cb2230cea5fcb1.png
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $filename
         *   Filename of the QR code should be generated.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setFilename(string $filename) : self
        {
            // Logic
            
            $filename = basename(trim($filename));
            
            if (strlen($filename) == 0)
            {
                throw new \Exception("Invalid filename provided.");
            }
            
            $this->filename = $filename;
            
            $this->resolvePath();
            
            return $this;
        }
        
        /**
         * Sets the encoder reference that should be used by the wrapper.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param Encoder $encoder
         *   Reference to the encoder that should be used by the wrapper.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setEncoder(Encoder $encoder) : self
        {
            // Logic
            
            $this->encoder = $encoder;
            
            return $this;
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Generates the appropriate QR Code based on the provided account
         * details. Relative directory path and filename of the QR Code are
         * resolved during the procedure, and it ends if one was previously
         * generated.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param Account $account
         *   Account for which the QR Code should be generated.
         * @param bool $force
         *   If this flag is set, QR Code will be generated regardless
         *   whether that was previously done.
         * @return bool
         *   Value <i>TRUE</i> if the QR Code was generated, and vice versa.
         */
        public function generate(Account $account, bool $force = false) : bool
        {
            // Step 1 - Resolve QR Code Path
            
            if ($this->encoder == null)
            {
                throw new \Exception("Encoder wasn't set.");
            }
            
            $format_code = $this->encoder->getFormat();
            
            $format_ext = Util::getFormatExtension($format_code);
            
            if ($this->directory == null)
            {
                $this->directory = sys_get_temp_dir();
            }
            
            if ($this->filename == null)
            {
                $this->filename = hash('sha256',
                    $account->getSecret()->getValue()) . "." . $format_ext;
            }
            
            $this->resolvePath();
            
            // Step 2 - Generate QR Code
            
            if (file_exists($this->path) && !$force)
            {
                return true;
            }
            
            $otpUri = Util::getOtpUri($account);
            
            $this->encoder->setData($otpUri);
            
            if ($this->encoder->process())
            {
                return Util::saveFile($this->path,
                    $this->encoder->getEncoding());
            }
            
            return false;
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        /**
         * Helper method that resolves a full path for the QR Code
         * that should be generated.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return object
         *   Reference to the object calling the method - current object.
         */
        private function resolvePath() : self
        {
            // Logic
            
            $separator = DIRECTORY_SEPARATOR;
            
            if ($this->directory == DIRECTORY_SEPARATOR)
            {
                $separator = "";
            }
            
            $this->path = join($separator, [
                $this->directory,
                $this->filename
            ]);
            
            return $this;
        }
    }
    
?>
