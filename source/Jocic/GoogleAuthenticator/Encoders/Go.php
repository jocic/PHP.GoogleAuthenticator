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
    
    namespace Jocic\GoogleAuthenticator\Encoders;
    
    use Jocic\GoogleAuthenticator\Encoder;
    use Jocic\GoogleAuthenticator\Helpers\Http;
    use Jocic\GoogleAuthenticator\Helpers\Util;
    
    /**
     * <i>Go</i> class is used for generating QR codes using pubilcly
     * available API from <i>GO QR</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class Go extends Encoder
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        /**
         * API endpoint used for generating QR Codes.
         * 
         * @var    int
         * @access public
         */
        const API_ENDPOINT = "https://api.qrserver.com/v1/create-qr-code";
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Translated and API-compliant <i>ECC</i> value.
         * 
         * @var    string
         * @access protected
         */
        private string $_ecc;
        
        /**
         * Translated and API-compliant <i>Format</i> value.
         * 
         * @var    string
         * @access protected
         */
        private string $_format;
        
        /**
         * Translated and API-compliant <i>Background Color</i> value.
         * 
         * @var    string
         * @access protected
         */
        private string $_bgColor;
        
        /**
         * Translated and API-compliant <i>Foreground Color</i> value.
         * 
         * @var    string
         * @access protected
         */
        private string $_fgColor;
        
        /**
         * Generic PHP constructor for the class <i>Go</i>.
         * 
         * It automatically translates any presets into their
         * API-compliant alternatives.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function __construct()
        {
            $this->setErrorCorrection($this->ecc);
            $this->setFormat($this->format);
            $this->setBackgroundColor($this->bgColor);
            $this->setForegroundColor($this->fgColor);
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Sets the Error-Correction Code applied during the encoding.
         * 
         * <strong>Note:</strong> Overriden function.
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
            switch ($ecc)
            {
                case Go::ECC_LOW:
                    $this->_ecc = "L";
                    break;
                case Go::ECC_MEDIUM:
                    $this->_ecc = "M";
                    break;
                case Go::ECC_HIGH:
                    $this->_ecc = "H";
                    break;
                default:
                    throw new \Exception("Unsupported ECC.");
            }
            
            return parent::setErrorCorrection($ecc);
        }
        
        /**
         * Sets the file format in which the QR Code should be generated.
         * 
         * <strong>Note:</strong> Overriden function.
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
            switch ($format)
            {
                case Encoder::FORMAT_PNG:
                    $this->_format = "png";
                    break;
                case Encoder::FORMAT_JPG:
                    $this->_format = "jpg";
                    break;
                case Encoder::FORMAT_GIF:
                    $this->_format = "gif";
                    break;
                case Encoder::FORMAT_SVG:
                    $this->_format = "svg";
                    break;
                case Encoder::FORMAT_EPS:
                    $this->_format = "eps";
                    break;
                default:
                    throw new \Exception("Unsupported format.");
            }
            
            return parent::setFormat($format);
        }
        
        /**
         * Sets the background color of the generated QR Code.
         * 
         * <strong>Note:</strong> Overriden function.
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
            if (!Util::isColorValid($color))
            {
                throw new \Exception("Invalid color provided.");
            }
            
            $this->_bgColor = hexdec($color[1] . $color[2]) . "-" .
                hexdec($color[3] . $color[4]) . "-" .
                hexdec($color[5] . $color[6]);
            
            return parent::setBackgroundColor($color);
        }
        
        /**
         * Sets the foreground color of the generated QR Code.
         * 
         * <strong>Note:</strong> Overriden function.
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
        public function setForegroundColor(string $color) : self
        {
            if (!Util::isColorValid($color))
            {
                throw new \Exception("Invalid color provided.");
            }
            
            $this->_fgColor = hexdec($color[1] . $color[2]) . "-" .
                hexdec($color[3] . $color[4]) . "-" .
                hexdec($color[5] . $color[6]);
            
            return parent::setForegroundColor($color);
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Encodes specified data within a QR Code using the publicly
         * available <i>GO QR</i> API.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return bool
         *   Value <i>TRUE</i> if QR Code was generated, and vice versa.
         */
        public function process() : bool
        {
            // Step 1 - Prepare Parameters
            
            $params = [
                "size"    => $this->size . "x" . $this->size,
                "data"    => $this->data,
                "margin"  => $this->margin,
                "color"   => $this->_fgColor,
                "bgcolor" => $this->_bgColor,
                "ecc"     => $this->_ecc,
                "format"  => $this->_format
            ];
            
            // Step 2 - Send Request
            
            $response = Http::get(self::API_ENDPOINT, $params);
            
            if ($response == null)
            {
                return false;
            }
            
            $this->encoding = $response;
            
            return true;
        }
    }
    
?>
