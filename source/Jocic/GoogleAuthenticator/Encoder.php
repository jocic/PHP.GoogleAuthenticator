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
    
    use Jocic\Encoders\Base\Base64;
    
    /**
     * <i>Encoder</i> is a base class used to simplify implementation and
     * integration of various API and System based QR Code generators.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class Encoder implements Interfaces\EncoderInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        /**
         * Low error correction code, ~7% destroyed data may be corrected.
         * 
         * <strong>Note:</strong> Actual error-correction depends on the
         * type of encoder you chose to use and how it was implemented.
         * 
         * @var    int
         * @access public
         */
        const ECC_LOW = 0;
        
        /**
         * Medium error correction code, ~15% destroyed data may be corrected.
         * 
         * <strong>Note:</strong> Actual error-correction depends on the
         * type of encoder you chose to use and how it was implemented.
         * 
         * @var    int
         * @access public
         */
        const ECC_MEDIUM = 1;
        
        /**
         * High error correction code, ~25% destroyed data may be corrected.
         * 
         * <strong>Note:</strong> Actual error-correction depends on the
         * type of encoder you chose to use and how it was implemented.
         * 
         * @var    int
         * @access public
         */
        const ECC_HIGH = 2;
        
        const FORMAT_PNG = 0;
        
        const FORMAT_JPG = 1;
        
        const FORMAT_GIF = 2;
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        protected int $size = 320;
        
        protected string|null $data = null;
        
        protected string|null $encoding = null;
        
        protected int $ecc = self::ECC_LOW;
        
        private int $format = self::FORMAT_PNG;
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        public function getSize() : int
        {
            // Logic
            
            return $this->size;
        }
        
        public function getErrorCorrection() : int
        {
            // Logic
            
            return $this->ecc;
        }
        
        public function getFormat() : int
        {
            // Logic
            
            return $this->format;
        }
        
        public function getData() : string|null
        {
            // Logic
            
            return $this->data;
        }
        
        public function getEncoding() : string|null
        {
            // Logic
            
            return $this->encoding;
        }
        
        public function getEmbeddable() : string|null
        {
            // Logic
            
            if ($this->encoding === null)
            {
                return null;
            }
            
            return "data:image/png;base64," .
                (new Base64())->encode($this->encoding);
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        public function setSize(int $size) : self
        {
            // Logic
            
            if ($size <= 0)
            {
                throw new \Exception("Invalid size provided.");
            }
            
            $this->size = $size;
            
            return $this;
        }
        
        public function setErrorCorrection(int $ecc) : self
        {
            // Logic
            
            if (!in_array($ecc, [ self::ECC_LOW, self::ECC_MEDIUM, self::ECC_HIGH ])) {
                throw new \Exception("invalid ECC value provided.");
            }
            
            $this->ecc = $ecc;
            
            return $this;
        }
        
        public function setFormat(int $format) : self
        {
            // Logic
            
            if (!in_array($format, [ FORMAT_PNG, FORMAT_JPG, FORMAT_GIF ]))
            {
                throw new \Exception("invalid format value provided.");
            }
            
            $this->format = $format;
            
            return $self;
        }
        
        public function setData(string $data) : self
        {
            // Logic
            
            if (strlen($data) == 0)
            {
                throw new \Exception("Invalid data provided.");
            }
            
            $this->data = $data;
            
            return $this;
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        public function process() : bool
        {
            return false;
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
