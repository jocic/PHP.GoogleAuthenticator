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
    
    use Jocic\Encoders\Base\Base32;
    
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
         * Checks if the provided code is valid for the given account.
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
         * Calculates time factor per <i>RFC 6238</i> specifications.
         * 
         * Note: Review page 3, section 4 of the mentioned document for
         * additional details.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $offset
         *   Unix time to start counting time steps - default value is 0.
         * @param integer $timeStep
         *   Time step in seconds - default value is 30 seconds.
         * @return string
         *   Calculated time factor in a binary format.
         */
        
        private function calculateTimeFactor($offset = 0, $timeStep = 30)
        {
            // Core Variables
            
            $timeFactor = floor(time() / $timeStep) + $offset;
            
            // Logic
            
            return sprintf("%c%c%c%c", 0x00, 0x00, 0x00, 0x00)
                . sprintf("%c", ($timeFactor & 0xFF000000) >> 0x18)
                . sprintf("%c", ($timeFactor & 0x00FF0000) >> 0x10)
                . sprintf("%c", ($timeFactor & 0x0000FF00) >> 0x08)
                . sprintf("%c", ($timeFactor & 0x000000FF) >> 0x00);
        }
        
        /**
         * Calculates time-based password per <i>RFC 6238</i> specifications.
         * 
         * Note: Review page 3, section 4 of the mentioned document for
         * additional details.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $secret
         *  Secret that should be used in the calculation.
         * @param integer $timeFactor
         *   Time factor that should be used in the calculation.
         * @return string
         *   Calculated time-based password.
         */
        
        public function calculateTimeBasedPassword($secret, $timeFactor)
        {
            // Logic
            
            return hash_hmac("sha1", $timeFactor, $secret, true);
        }
        
        /**
         * Calculates a 6-digit time code per <i>RFC 6238</i> specifications.
         * 
         * Note: Review page 12, section 4 of the mentioned document for
         * additional details.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $timePassword
         *   Time-based password that should be used in the calculation.
         * @return string
         *   Calculated 6-digit time code.
         */
        
        public function calculateTimeCode($timePassword)
        {
            // Core Variables
            
            $timeCode   = null;
            $timeDigest = str_split($timePassword);
            $codeModuo  = 0x000F4240;
            $codeMask   = 0x7FFFFFFF;
            
            // Other Variables
            
            $offset = ord($timeDigest[19]) & 0x0F;
            $binary = (ord($timeDigest[$offset]) << 0x18)
                | (ord($timeDigest[$offset + 1]) << 0x10)
                | (ord($timeDigest[$offset + 2]) << 0x08)
                | (ord($timeDigest[$offset + 3]) << 0x00);
            
            // Logic
            
            $timeCode = strval(($binary & $codeMask) % $codeModuo);
            
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
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $secret
         *   Secret object that should be used for code generation.
         * @param string $offset
         *   Offset of the time slice.
         * @return string
         *   Generated 6-digit code.
         */
        
        private function generateCode($secret, $offset)
        {
            // Core Variables
            
            $encoder      = new Base32();
            $binarySecret = null;
            
            // Other Variables
            
            $timeFactor   = null;
            $timePassword = null;
            
            // Step 1 - Check Secret
            
            if (!($secret instanceof Secret))
            {
                throw new \Exception("Invalid object used.");
            }
            
            // Step 2 - Calculate Time Code
            
            $binarySecret = $encoder->decode($secret->getValue());
            
            $timeFactor = $this->calculateTimeFactor($offset);
            
            $timePassword = $this->calculateTimeBasedPassword($binarySecret, 
                $timeFactor);
            
            return $this->calculateTimeCode($timePassword);
        }
    }
    
?>
