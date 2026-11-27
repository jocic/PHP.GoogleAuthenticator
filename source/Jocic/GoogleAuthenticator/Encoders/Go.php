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
        
        const API_ENDPOINT = "http://api.qrserver.com/v1/create-qr-code";
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        private string $_ecc = 'L';
        
        private string $_format = 'png';
        
        private string $_bgColor = "255-255-255";
        
        private string $_fgColor = "0-0-0";
        
        public function __construct()
        {
            $this->setErrorCorrection($this->ecc);
            $this->setFormat($this->format);
            $this->setBackgroundColor($this->bgColor);
            $this->setBackgroundColor($this->fgColor);
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
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
        
        public function setFormat(int $format) : self
        {
            switch ($format)
            {
                case Go::FORMAT_PNG:
                    $this->_format = "png";
                    break;
                case Go::FORMAT_JPG:
                    $this->_format = "jpg";
                    break;
                case Go::FORMAT_GIF:
                    $this->_format = "gif";
                    break;
                case Go::FORMAT_SVG:
                    $this->_format = "svg";
                    break;
                case Go::FORMAT_EPS:
                    $this->_format = "eps";
                    break;
                default:
                    throw new \Exception("Unsupported format.");
            }
            
            return parent::setFormat($format);
        }
        
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
        
        public function process() : bool
        {
            // Step 1 - Prepare Parameters
            
            $params = [
                'size'    => $this->size . 'x' . $this->size,
                'data'    => $this->data,
                'margin'  => $this->margin,
                'color'   => $this->_fgColor,
                'bgcolor' => $this->_bgColor,
                'ecc'     => $this->_ecc,
                'format'  => $this->_format
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
