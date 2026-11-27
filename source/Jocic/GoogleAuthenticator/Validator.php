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
    use Jocic\Encoders\Base\Base32;
    
    /**
     * <i>Validator</i> class is used for generating and validating
     * one-time passwords.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class Validator implements Interfaces\ValidatorInterface
    {
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Checks if the provided one-time password is valid or not.
         * 
         * Valid one-time-passwords are generated for the previous, current,
         * and the following time cycles, then compared to the provided one. If
         * there is a match then the code is considered to be valid.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $code
         *   Six-digit code that should be used for validation.
         * @param mixed $entity
         *   Account or Secret that should be used for code validation.
         * @return bool
         *   Value <i>TRUE</i> if the provide code is valid, and vice versa.
         */
        public function isValid(string $code, mixed $entity) : bool
        {
            $secret = Util::getSecret($entity);
            
            $code_tp = $this->generateCode($secret, -1);
            $code_tc = $this->generateCode($secret,  0);
            $code_tn = $this->generateCode($secret,  1);
            
            return (   $code_tp == $code
                    || $code_tc == $code
                    || $code_tn == $code);
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        /**
         * Calculates time factor per <i>RFC 6238</i> specifications.
         * 
         * <strong>Note:</strong> Review page 3, section 4 of the mentioned
         *  document for additional details.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param int $offset
         *   Unix time to start counting time steps - default value is 0.
         * @param int $timeStep
         *   Time step in seconds - default value is 30 seconds.
         * @return string
         *   Calculated time factor in a binary format.
         */
        private function calculateTimeFactor(
            int $offset = 0, int $timeStep = 30) : string
        {
            $timeFactor = floor(time() / $timeStep) + $offset;
            
            return sprintf("%c%c%c%c", 0x00, 0x00, 0x00, 0x00)
                . sprintf("%c", ($timeFactor & 0xFF000000) >> 0x18)
                . sprintf("%c", ($timeFactor & 0x00FF0000) >> 0x10)
                . sprintf("%c", ($timeFactor & 0x0000FF00) >> 0x08)
                . sprintf("%c", ($timeFactor & 0x000000FF) >> 0x00);
        }
        
        /**
         * Calculates time-based password per <i>RFC 6238</i> specifications.
         * 
         * <strong>Note:</strong> Review page 3, section 4 of the mentioned
         * document for additional details.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $secret
         *  Secret that should be used in the calculation.
         * @param string $timeFactor
         *   Time factor that should be used in the calculation.
         * @return string
         *   Calculated time-based password.
         */
        private function calculateTimeBasedPassword(
            string $secret, string $timeFactor) : string
        {
            return hash_hmac("sha1", $timeFactor, $secret, true);
        }
        
        /**
         * Calculates a 6-digit time code per <i>RFC 6238</i> specifications.
         * 
         * <strong>Note:</strong> Review page 12, section 4 of the mentioned
         * document for additional details.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $timePassword
         *   Time-based password that should be used in the calculation.
         * @return string
         *   Calculated 6-digit time code.
         */
        private function calculateTimeCode(string $timePassword) : string
        {
            $timeDigest = str_split($timePassword);
            
            $offset = ord($timeDigest[19]) & 0x0F;
            
            $binary = (ord($timeDigest[$offset]) << 0x18)
                | (ord($timeDigest[$offset + 1]) << 0x10)
                | (ord($timeDigest[$offset + 2]) << 0x08)
                | (ord($timeDigest[$offset + 3]) << 0x00);
            
            $timeCode = strval(($binary & 0x7FFFFFFF) % 0x000F4240);
            
            while (strlen($timeCode) < 0x06)
            {
                $timeCode = "0" . $timeCode;
            }
            
            return $timeCode;
        }
        
        /**
         * Returns previous code generated for the account.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $secret
         *   Secret that should be used for code generation.
         * @param string $offset
         *   Offset of the time slice.
         * @return string
         *   Generated 6-digit code.
         */
        private function generateCode(string $secret, string $offset) : string
        {
            $encoder = new Base32();
            
            $binarySecret = $encoder->decode($secret);
            
            $timeFactor = $this->calculateTimeFactor($offset);
            
            $timePassword = $this->calculateTimeBasedPassword(
                $binarySecret, $timeFactor);
            
            return $this->calculateTimeCode($timePassword);
        }
    }
    
?>
