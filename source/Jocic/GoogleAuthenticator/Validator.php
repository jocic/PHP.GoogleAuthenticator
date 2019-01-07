<?php
    
    /*******************************************************************\
    |* Author: Djordje Jocic                                           *|
    |* Year: 2018                                                      *|
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
    
    use Jocic\GoogleAuthenticator\Encoders\Base\Base32;
    
    /**
     * <i>Validator</i> class is used for generating QR codes, and validating
     * provided one-time passwords.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class Validator implements ValidatorInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        // CORE VARIABLES GO HERE
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        // MAGIC FUNCTIONS GO HERE
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns previous code generated for the account.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $account
         *   Account that should be used for code generation.
         * @return string
         *   6-digit code that was valid in the previous cycle.
         */
        
        public function getPreviousCode($account)
        {
            // Logic
            
            return $this->generateCode($account->getAccountSecret(), -1);
        }
        
        /**
         * Returns current code generated for the account.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $account
         *   Account that should be used for code generation.
         * @return string
         *   6-digit code that is valid in the current cycle.
         */
        
        public function getCurrentCode($account)
        {
            // Logic
            
            return $this->generateCode($account->getAccountSecret(), 0);
        }
        
        /**
         * Returns next code generated for the account.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $account
         *   Account that should be used for code generation.
         * @return string
         *   6-digit code that is going to be valid in the next cycle.
         */
        
        public function getNextCode($account)
        {
            // Logic
            
            return $this->generateCode($account->getAccountSecret(), 1);
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        // SET METHODS GO HERE
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        // CORE METHODS GO HERE
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Returns previous code generated for the account.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $code
         *   Six-digit code that should be used for validation.
         * @param string $account
         *   Account that should be used for code validation.
         * @return bool
         *   Value <i>TRUE</i> if the provide code is valid, and vice versa.
         */
        
        public function isCodeValid($code, $account)
        {
            // Logic
            
            return (   $this->getPreviousCode($account) == $code
                    || $this->getCurrentCode($account) == $code
                    || $this->getNextCode($account) == $code);
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        /**
         * Returns previous code generated for the account.
         * 
         * Note: This method will be refactored as it is not good.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $secret
         *   Secret object that should be used for code generation.
         * @param string $offset
         *   Offset of the time slice.
         * @param string $codeLength
         *   Length of the generated code.
         * @return string
         *   Generated 6-digit code.
         */
        
        private function generateCode($secret, $offset, $codeLength = 6)
        {
            // Core Variables
            
            $encoder      = new Base32();
            $binarySecret = $encoder->decode($secret->getValue());
            
            // Primary Algorithm Variables
            
            $timeSlice  = floor(time() / 30) + $offset;
            $timePacked = (chr(0) . chr(0) . chr(0) . chr(0) . pack("N*", $timeSlice));
            $timeHmac   = hash_hmac("sha1", $timePacked, $binarySecret, true);
            
            // Secondary Algorithm Variables
            
            $offset   = ord(substr($timeHmac, -1)) & 0x0F;
            $hashPart = substr($timeHmac, $offset, 4);
            $moduo    = pow(10, $codeLength);
            $bitMask  = 0x7;
            $code     = null;
            
            // Step 1 - Generate Bit Mask
            
            for ($i = 0; $i <= $codeLength; $i ++)
            {
                $bitMask = ($bitMask << 4) | 0x0F;
            }
            
            // Step 2 - Generate Code
            
            $code = unpack("N", $hashPart);
            
            if (isset($code[1]))
            {
                $code = $code[1] & $bitMask;
                
                return str_pad(($code % $moduo), $codeLength, "0", STR_PAD_LEFT);
            }
            
            return "0";
        }
    }
    
?>
