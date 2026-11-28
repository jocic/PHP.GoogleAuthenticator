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
    
    namespace Jocic\GoogleAuthenticator\Helpers;
    
    use Jocic\GoogleAuthenticator\Account;
    use Jocic\GoogleAuthenticator\Secret;
    use Jocic\GoogleAuthenticator\Encoder;
    
    /**
     * <i>Util</i> class is a generic helper class of the library.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class Util
    {
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Helper method that extracts the secret from the provided object.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param mixed $entity
         *   Account or Secret that should be used for code generation.
         * @return string
         *   Value of the secret.
         */
        public static function getSecret(mixed $entity) : string
        {
            $secret = "";
            
            if ($entity instanceof Account)
            {
                $secret = $entity->getSecret()->getValue();
            }
            else if ($entity instanceof Secret)
            {
                $secret = $entity->getValue();
            }
            else if (is_string($entity))
            {
                $secret = $entity;
            }
            else
            {
                throw new \Exception("Secret couldn't be extracted.");
            }
            
            return $secret;
        }
        
        /**
         * Returns the OTP URI derived from the account-related details.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param Account $account
         *   Account that should be used in the derivation.
         * @return string
         *   OTP URI formatted as: <i>otpauth://totp/%s:%s?secret=%s</i>
         */
        public static function getOtpUri(Account $account) : string
        {
            $service = $account->getService();
            $name    = $account->getName();
            $secret  = $account->getSecret()->getValue();
            
            if (empty($service))
            {
                $service = "Default Service";
            }
            
            if (empty($name))
            {
                $name = "N/A";
            }
            
            return sprintf("otpauth://totp/%s:%s?secret=%s",
                $service, $name, $secret);
        }
        
        /**
         * Returns the file format extension based on the provided
         * file format code as defined in the <i>Encoder</i> class.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param int $code
         *   File format code as defined in the <i>Encoder</i> class.
         * @return string|null
         *   File format extension, e.g. <i>jpg</i>.
         */
        public static function getFormatExtension(int $code) : string
        {
            switch ($code)
            {
                case Encoder::FORMAT_PNG:
                    return "png";
                case Encoder::FORMAT_JPG:
                    return "jpg";
                case Encoder::FORMAT_GIF:
                    return "gif";
                case Encoder::FORMAT_SVG:
                    return "svg";
                case Encoder::FORMAT_EPS:
                    return "eps";
                case Encoder::FORMAT_WEBP:
                    return "webp";
            }
            
            return "";
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Checks if the hexadecimal representation of an RGB color is valid.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $color
         *   Hexadecimal color, e.g. <i>#FFFF00</i>.
         * @return bool
         *   Value <i>TRUE</i> if the color is valid, and vice versa.
         */
        public static function isColorValid(string $color) : bool
        {
            return preg_match("/^#[0-9a-fA-F]{6}$/", trim($color));
        }
    }
    
?>
