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
    use Jocic\GoogleAuthenticator\Helpers\Util;
    
    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\ErrorCorrectionLevel;
    use Endroid\QrCode\RoundBlockSizeMode;
    use Endroid\QrCode\Color\Color;
    use Endroid\QrCode\Encoding\Encoding;
    use Endroid\QrCode\Writer\PngWriter;
    use Endroid\QrCode\Writer\GifWriter;
    use Endroid\QrCode\Writer\SvgWriter;
    use Endroid\QrCode\Writer\EpsWriter;
    use Endroid\QrCode\Writer\WebPWriter;
    use Endroid\QrCode\Writer\ValidationException;
    
    /**
     * <i>Endroid</i> class is used for generating QR codes using the
     * local PHP library <i>endroid/qr-code</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class Endroid extends Encoder
    {
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Translated and library-compliant <i>ECC</i> value.
         * 
         * @var    ErrorCorrectionLevel
         * @access protected
         */
        private ErrorCorrectionLevel $_ecc;
        
        /**
         * Translated and library-compliant <i>Background Color</i> value.
         * 
         * @var    Color
         * @access protected
         */
        private Color $_bgColor;
        
        /**
         * Translated and library-compliant <i>Foreground Color</i> value.
         * 
         * @var    Color
         * @access protected
         */
        private Color $_fgColor;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        /**
         * Generic PHP constructor for the class <i>Endroid</i>.
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
                case Encoder::ECC_LOW:
                    $this->_ecc = ErrorCorrectionLevel::Low;
                    break;
                case Encoder::ECC_MEDIUM:
                    $this->_ecc = ErrorCorrectionLevel::Medium;
                    break;
                case Encoder::ECC_HIGH:
                    $this->_ecc = ErrorCorrectionLevel::High;
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
            if (!in_array($format, [
                Encoder::FORMAT_PNG, Encoder::FORMAT_GIF,
                Encoder::FORMAT_SVG, Encoder::FORMAT_EPS,
                Encoder::FORMAT_WEBP ]))
            {
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
            
            $red   = hexdec($color[1] . $color[2]);
            $green = hexdec($color[3] . $color[4]);
            $blue  = hexdec($color[5] . $color[6]);
            
            $this->_bgColor = new Color($red, $green, $blue);
            
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
            
            $red   = hexdec($color[1] . $color[2]);
            $green = hexdec($color[3] . $color[4]);
            $blue  = hexdec($color[5] . $color[6]);
            
            $this->_fgColor = new Color($red, $green, $blue);
            
            return parent::setForegroundColor($color);
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Encodes specified data within a QR Code using the
         * local PHP library <i>endroid/qr-code</i>.
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
            // Step 1 - Prepare QR Code Data
            
            $qrCode = new QrCode(
                
                data:   $this->data,
                size:   $this->size,
                margin: $this->margin,
                
                backgroundColor: $this->_bgColor,
                foregroundColor: $this->_fgColor,
                
                encoding: new Encoding('UTF-8'),
                
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                
                errorCorrectionLevel: $this->_ecc
            );
            
            // Step 2 - Generate QR Code
            
            switch ($this->format) {
                case Encoder::FORMAT_PNG:
                    $writer = new PngWriter();
                    break;
                case Encoder::FORMAT_GIF:
                    $writer = new GifWriter();
                    break;
                case Encoder::FORMAT_SVG:
                    $writer = new SvgWriter();
                    break;
                case Encoder::FORMAT_EPS:
                    $writer = new EpsWriter();
                    break;
                case Encoder::FORMAT_WEBP:
                    $writer = new WebPWriter();
                    break;
                default:
                    throw new \Exception("Unsupported format selected.");
            }
            
            $result = $writer->write($qrCode);
            
            $this->encoding = $result->getString();
            
            return true;
        }
    }
    
?>
