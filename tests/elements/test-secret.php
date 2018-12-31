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
    use Jocic\GoogleAuthenticator\Secret;
    
    /**
     * <i>TestSecret</i> class is used for testing method implementation of the
     * class <i>Secret</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class TestSecret extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>setValue</i> & <i>getValue</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testValueMethods()
        {
            // Core Variables
            
            $secret = new Secret();
            
            // Other Variables
            
            $testValues = [
                "RMB4AMUMDHODBYNR",
                "4JT4TVALIJOHCRZX",
                "YPPMQXR6UGWBP3UI"
            ];
            
            // Step 1 - Test Valid Values
            
            foreach ($testValues as $testValue)
            {
                $secret->setValue($testValue);
                
                $this->assertSame($testValue, $secret->getValue());
            }
            
            // Step 2 - Test Invalid Value
            
            try
            {
                $secret->setValue("#");
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid secret provided. Secret: \"#\"",
                    $e->getMessage());
            }
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Tests secret validation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testValidation()
        {
            // Core Variables
            
            $secret = new Secret();
            
            // Other Variables
            
            $testValues = [
                "RMB4AMUMDHODBYNR" => true,
                "4JT4TVALIJOHCRZX" => true,
                "YPPMQXR6UGWBP3UI" => true,
                "RMB4AMU=DHODBYNR" => false,
                "4JT4T#ALIJOHCRZX" => false,
                "YPPMQXR6UmWBP3UI" => false,
            ];
            
            // Step 1 - Test Valid Values
            
            foreach ($testValues as $testValue => $testResult)
            {
                $this->assertSame($testResult,
                    $secret->isSecretValid($testValue), $testValue);
            }
        }
        
        /*******************\
        |* PRIMARY METHODS *|
        \*******************/
        
        /**
         * Tests <i>generate</i> method of the <i>Secret</i> class.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testGenerateMethod()
        {
            // Core Variables
            
            $secret = new Secret();
            
            // Other Variables
            
            $value = null;
            
            // Step 1 - Base Method
            
            for ($i = 0; $i < 10; $i ++)
            {
                $value = $secret->generateValue(Secret::M_BASE);
                
                $this->assertSame(true, $secret->isSecretValid($value), $value);
            }
            
            // Step 2 - Numerical Method
            
            for ($i = 0; $i < 10; $i ++)
            {
                $value = $secret->generateValue(Secret::M_NUMERICAL);
                
                $this->assertSame(true, $secret->isSecretValid($value), $value);
            }
            
            // Step 3 - Binary Method
            
            for ($i = 0; $i < 10; $i ++)
            {
                $value = $secret->generateValue(Secret::M_BINARY);
                
                $this->assertSame(true, $secret->isSecretValid($value), $value);
            }
            
            // Step 4 - Invalid Method
            
            try
            {
                $secret->generateValue(1337);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid method selected.",
                    $e->getMessage());
            }
        }
        
        /*********************\
        |* SECONDARY METHODS *|
        \*********************/
        
        // SECONDARY METHODS GO HERE
    }
    
?>
