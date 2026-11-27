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
    use Jocic\GoogleAuthenticator\Http;
    use Jocic\GoogleAuthenticator\Util;
    
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
        
        private string $ecc_alt = 'L';
        
        private string $format_alt = 'png';
        
        private int $margin = 10;
        
        private string $bg_color = "255-255-255";
        
        private string $fg_color = "0-0-0";
        
        public function __construct()
        {
            $this->setErrorCorrection($this->ecc);
            $this->setFormat($this->format);
        }
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        public function getMargin() : int
        {
            return $this->margin;
        }
        
        public function getBackgroundColor() : string
        {
            return $this->bg_color;
        }
        
        public function getForegroundColor() : string
        {
            return $this->fg_color;
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        public function setErrorCorrection(int $ecc) : self
        {
            switch ($ecc)
            {
                case Go::ECC_LOW:
                    $this->ecc_alt = "L";
                    break;
                case Go::ECC_MEDIUM:
                    $this->ecc_alt = "M";
                    break;
                case Go::ECC_HIGH:
                    $this->ecc_alt = "H";
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
                    $this->format_alt = "png";
                    break;
                case Go::FORMAT_JPG:
                    $this->format_alt = "jpg";
                    break;
                case Go::FORMAT_GIF:
                    $this->format_alt = "gif";
                    break;
                case Go::FORMAT_SVG:
                    $this->format_alt = "svg";
                case Go::FORMAT_EPS:
                    $this->format_alt = "eps";
                    break;
                default:
                    throw new \Exception("Unsupported format.");
            }
            
            return parent::setFormat($format);
        }
        
        public function setMargin(int $margin) : self
        {
            $this->margin = $margin;
            
            return $this;
        }
        
        public function setBackgroundColor(string $color) : self
        {
            if (!Util::isColorValid($color))
            {
                throw new \Exception("Invalid color provided.");
            }
            
            $this->bg_color = hexdec($color[1] . $color[2]) . "-" .
                hexdec($color[3] . $color[4]) . "-" .
                hexdec($color[5] . $color[6]);
            
            return $this;
        }
        
        public function setForegroundColor(string $color) : self
        {
            if (!Util::isColorValid($color))
            {
                throw new \Exception("Invalid color provided.");
            }
            
            $this->fg_color = hexdec($color[1] . $color[2]) . "-" .
                hexdec($color[3] . $color[4]) . "-" .
                hexdec($color[5] . $color[6]);
            
            return $this;
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
                'color'   => $this->fg_color,
                'bgcolor' => $this->bg_color,
                'ecc'     => $this->ecc_alt,
                'format'  => $this->format_alt
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
