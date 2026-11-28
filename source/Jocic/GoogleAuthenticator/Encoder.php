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
    
    use Jocic\GoogleAuthenticator\Helpers\Util;
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
        /*****************\
        |* ECC CONSTANTS *|
        \*****************/
        
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
        
        /********************\
        |* FORMAT CONSTANTS *|
        \********************/
        
        /**
         * Constant used for denoting encoder's file format - PNG.
         * 
         * @var    int
         * @access public
         */
        const FORMAT_PNG = 0;
        
        /**
         * Constant used for denoting encoder's file format - JPG.
         * 
         * @var    int
         * @access public
         */
        const FORMAT_JPG = 1;
        
        /**
         * Constant used for denoting encoder's file format - GIF.
         * 
         * @var    int
         * @access public
         */
        const FORMAT_GIF = 2;
        
        /**
         * Constant used for denoting encoder's file format - SVG.
         * 
         * @var    int
         * @access public
         */
        const FORMAT_SVG = 3;
        
        /**
         * Constant used for denoting encoder's file format - EPS.
         * 
         * @var    int
         * @access public
         */
        const FORMAT_EPS = 4;
        
        /**
         * Constant used for denoting encoder's file format - WEBP.
         * 
         * @var    int
         * @access public
         */
        const FORMAT_WEBP = 5;
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Size of the QR Code that should be generated by the encoder.
         * 
         * @var    int
         * @access protected
         */
        protected int $size = 320;
        
        /**
         * Error-Correction Code applied during the encoding.
         * 
         * @var    int
         * @access protected
         */
        protected int $ecc = self::ECC_LOW;
        
        /**
         * File format in which the QR Code should be generated.
         * 
         * @var    int
         * @access protected
         */
        protected int $format = self::FORMAT_PNG;
        
        /**
         * Margin between the edges of the image and the QR Code itself.
         * 
         * @var    int
         * @access protected
         */
        protected int $margin = 5;
        
        /**
         * Background color of the generated QR Code.
         * 
         * @var    string
         * @access protected
         */
        protected string $bgColor = "#ffffff";
        
        /**
         * Foreground color of the generated QR Code - color of the code.
         * 
         * @var    string
         * @access protected
         */
        protected string $fgColor = "#000000";
        
        /**
         * Data that should be encoded within the generated QR Code.
         * 
         * @var    int
         * @access protected
         */
        protected string|null $data = null;
        
        /**
         * QR Code with the encoded data in the specified image format.
         * 
         * @var    string
         * @access protected
         */
        protected string|null $encoding = null;
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns the set size of the QR Code.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return int
         *   Size of the QR Code that should be generated by the encoder.
         */
        public function getSize() : int
        {
            return $this->size;
        }
        
        /**
         * Returns the Error-Correction Code applied during the encoding.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return int
         *   Error-Correction Code that should be applied during the encoding.
         */
        public function getErrorCorrection() : int
        {
            return $this->ecc;
        }
        
        /**
         * Returns the file format in which the QR Code should be generated.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return int
         *   File format in which the QR Code should be generated.
         */
        public function getFormat() : int
        {
            return $this->format;
        }
        
        /**
         * Returns the margin between the edges of the image and the
         * QR Code itself. This value represents the margin in pixel.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return int
         *   Margin between the edges of the image and the QR Code itself.
         */
        public function getMargin() : int
        {
            return $this->margin;
        }
        
        /**
         * Returns the background color of the generated QR Code.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Background color of the generated QR Code.
         */
        public function getBackgroundColor() : string
        {
            return $this->bgColor;
        }
        
        /**
         * Returns the foreground color of the generated QR Code.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Foreground color of the generated QR Code.
         */
        public function getForegroundColor() : string
        {
            return $this->fgColor;
        }
        
        /**
         * Returns the data that should be encoded within the generated QR Code.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string|null
         *   Data that should be encoded within the generated QR Code.
         */
        public function getData() : string|null
        {
            return $this->data;
        }
        
        /**
         * Returns the QR Code with the encoded data in the
         * specified image format.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string|null
         *   QR Code with the encoded data in the specified image format.
         */
        public function getEncoding() : string|null
        {
            return $this->encoding;
        }
        
        /**
         * Returns the previously-generated <i>BASE64</i> encoded QR Code.
         * 
         * This is particularly useful if you only need to temporarily
         * embedd a QR code on a page as an inline image.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string|null
         *   Previously-generated <i>BASE64</i> encoded QR Code, or
         *   value <i>NULL</i> if the QR Code generation failed.
         */
        public function getEmbeddable() : string|null
        {
            if ($this->encoding === null)
            {
                return null;
            }
            
            $ext = Util::getFormatExtension($this->format);
            
            return "data:image/$ext;base64," .
                (new Base64())->encode($this->encoding);
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Sets the size of the QR Code.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param int $size
         *   Size of the QR Code that should be generated by the encoder.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setSize(int $size) : self
        {
            if ($size < 10 || $size > 1000)
            {
                throw new \Exception("Invalid size provided.");
            }
            
            $this->size = $size;
            
            return $this;
        }
        
        /**
         * Sets the Error-Correction Code applied during the encoding.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param int $ecc
         *   Error-Correction Code that should be applied during the encoding.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setErrorCorrection(int $ecc) : self
        {
            if (!in_array($ecc, [ self::ECC_LOW,
                self::ECC_MEDIUM, self::ECC_HIGH ]))
            {
                throw new \Exception("invalid ECC value provided.");
            }
            
            $this->ecc = $ecc;
            
            return $this;
        }
        
        /**
         * Sets the file format in which the QR Code should be generated.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param int $format
         *   File format in which the QR Code should be generated.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setFormat(int $format) : self
        {
            // Logic
            
            if (!in_array($format, [
                self::FORMAT_PNG, self::FORMAT_JPG,
                self::FORMAT_GIF, self::FORMAT_SVG,
                self::FORMAT_EPS, self::FORMAT_WEBP ]))
            {
                throw new \Exception("invalid format value provided.");
            }
            
            $this->format = $format;
            
            return $this;
        }
        
        /**
         * Sets the margin between the edges of the image and the
         * QR Code itself. This value represents the margin in pixel.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param int $margin
         *   Margin between the edges of the image and the QR Code itself.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setMargin(int $margin) : self
        {
            if ($margin < 0 || $margin > 50)
            {
                throw new \Exception("Invalid margin provided.");
            }
            
            $this->margin = $margin;
            
            return $this;
        }
        
        /**
         * Sets the background color of the generated QR Code.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $color
         *   Background color of the generated QR Code.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setBackgroundColor(string $color) : self
        {
            $color = trim($color);
            
            if (!Util::isColorValid($color))
            {
                throw new \Exception("Invalid color provided.");
            }
            
            $this->bgColor = $color;
            
            return $this;
        }
        
        /**
         * Sets the foreground color of the generated QR Code.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $color
         *   Foreground color of the generated QR Code.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setForegroundColor(string $color) : self
        {
            $color = trim($color);
            
            if (!Util::isColorValid($color))
            {
                throw new \Exception("Invalid color provided.");
            }
            
            $this->fgColor = $color;
            
            return $this;
        }
        
        /**
         * Sets the data that should be encoded within the generated QR Code.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $data
         *   Data that should be encoded within the generated QR Code.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setData(string $data) : self
        {
            $data = trim($data);
            
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
        
        /**
         * Placeholder method that should be overridden by dedicated
         * encoder implementations.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $data
         *   Data that should be encoded within the generated QR Code.
         * @return bool
         *   Value <i>TRUE</i> if QR Code was generated, and vice versa.
         */
        public function process() : bool
        {
            return false;
        }
    }
    
?>
