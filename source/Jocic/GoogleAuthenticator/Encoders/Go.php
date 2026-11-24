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
        
        // CORE VARIAVLES GO HERE
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        // GET METHODS GO HERE
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        // SET METHODS GO HERE
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        public function process() : bool
        {
            // Core Variables
            
            $ecc_values    = [ "L", "M", "H" ];
            $format_values = [ "png", "jpg", "gif" ];
            
            // Step 1 - Prepare Request
            
            $params = [
                'size'   => $this->size . 'x' . $this->size,
                'data'   => $this->data,
                'ecc'    => $ecc_values[$this->ecc],
                'format' => $format_values[$this->format]
            ];
            
            $url = self::API_ENDPOINT . '?' .
                http_build_query($params, '', '&', PHP_QUERY_RFC3986);
            
            $ch = curl_init($url);
            
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_HTTPHEADER     => [
                    'Accept: text/html',
                ],
            ]);
            
            // Step 2 - Send Request
            
            $response = curl_exec($ch);
            
            if ($response === false)
            {
                $error = curl_error($ch);
                
                curl_close($ch);
                
                return false;
            }
            
            // Step 3 - Handle Request
            
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            curl_close($ch);
            
            if ($status < 200 || $status >= 300)
            {
                return false;
            }
            
            $this->encoding = $response;
            
            return true;
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
