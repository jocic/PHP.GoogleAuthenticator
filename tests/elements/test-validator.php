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
    
    use PHPUnit\Framework\TestCase;
    
    use Jocic\Encoders\Base\Base32;
    use Jocic\GoogleAuthenticator\Validator;
    use Jocic\GoogleAuthenticator\Account;
    use Jocic\GoogleAuthenticator\Secret;
    
    /**
     * <i>TestValidator</i> class is used for testing method implementation of
     * the class <i>Validator</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class TestValidator extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>getPreviousCode</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testPreviousCode()
        {
            // Core Variables
            
            $validator = new Validator();
            $account   = new Account("A", "B", "RMB4AMUMDHODBYNR");
            
            // Logic
            
            $this->assertSame($this->generateCode("RMB4AMUMDHODBYNR", -1),
                $validator->getPreviousCode($account));
        }
        
        /**
         * Tests <i>getCurrentCode</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testCurrentCode()
        {
            // Core Variables
            
            $validator = new Validator();
            $account   = new Account("A", "B", "RMB4AMUMDHODBYNR");
            
            // Logic
            
            $this->assertSame($this->generateCode("RMB4AMUMDHODBYNR", 0),
                $validator->getCurrentCode($account));
        }
        
        /**
         * Tests <i>getNextCode</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testNextCode()
        {
            // Core Variables
            
            $validator = new Validator();
            $account   = new Account("A", "B", "RMB4AMUMDHODBYNR");
            
            // Logic
            
            $this->assertSame($this->generateCode("RMB4AMUMDHODBYNR", 1),
                $validator->getNextCode($account));
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Tests <i>isCodeValid</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testIsCodeValidMethod()
        {
            // Core Variables
            
            $validator = new Validator();
            $account   = new Account("A", "B", "RMB4AMUMDHODBYNR");
            
            // Other Variables
            
            $currentCode = $this->generateCode("RMB4AMUMDHODBYNR", 0);
            
            // Logic
            
            $this->assertTrue($validator->isCodeValid($currentCode, $account));
        }
        
        /*******************\
        |* PRIMARY METHODS *|
        \*******************/
        
        // PRIMARY METHODS GO HERE
        
        /*********************\
        |* SECONDARY METHODS *|
        \*********************/
        
        // SECONDARY METHODS GO HERE
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        /**
         * Returns previous code generated for the provided encoded secret.
         * 
         * Note: This method was created by referencing existing implementation,
         * <i>PHPGangsta/GoogleAuthenticator</i> to be exact, and it is assumed
         * that the calculation is correct.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $secret
         *   Encoded 80-bit secret that should be used for code generation.
         * @param string $offset
         *   Offset of the time slice.
         * @return string
         *   Generated 6-digit code.
         */
        
        private function generateCode($secret, $offset)
        {
            // Core Variables
            
            $encoder      = new Base32();
            $binarySecret = $encoder->decode($secret);
            
            // Primary Algorithm Variables
            
            $timeSlice  = floor(time() / 30) + $offset;
            $timePacked = (chr(0) . chr(0) . chr(0) . chr(0) . pack("N*", $timeSlice));
            $timeHmac   = hash_hmac("sha1", $timePacked, $binarySecret, true);
            
            // Secondary Algorithm Variables
            
            $offset   = ord(substr($timeHmac, -1)) & 0x0F;
            $hashPart = substr($timeHmac, $offset, 4);
            $moduo    = pow(10, 6);
            $bitMask  = 0x7;
            $code     = null;
            
            // Step 1 - Generate Bit Mask
            
            for ($i = 0; $i <= 6; $i ++)
            {
                $bitMask = ($bitMask << 4) | 0x0F;
            }
            
            // Step 2 - Generate Code
            
            $code = unpack("N", $hashPart);
            
            if (isset($code[1]))
            {
                $code = $code[1] & $bitMask;
                
                return str_pad(($code % $moduo), 6, "0", STR_PAD_LEFT);
            }
            
            return "0";
        }
    }
    
?>
