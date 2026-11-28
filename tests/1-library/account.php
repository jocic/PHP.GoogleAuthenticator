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
    
    use PHPUnit\Framework\TestCase;
    
    use Jocic\GoogleAuthenticator\Secret;
    use Jocic\GoogleAuthenticator\Account;
    
    /**
     * <i>TestAccount</i> class is used for testing method implementation
     * of the class <i>Account</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class TestAccount extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>setService</i> & <i>getService</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testServiceMethods() : void
        {
            $account = new Account();
            
            $testValues = [
                "Hosting ABC",
                "FastFood Joint",
                "That Shop"
            ];
            
            foreach ($testValues as $testValue)
            {
                $account->setService($testValue);
                
                $this->assertSame($testValue, $account->getService());
            }
        }
        
        /**
         * Tests <i>setName</i> & <i>getName</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testNameMethods() : void
        {
            $account = new Account();
            
            $testValues = [
                "John Doe",
                "john@doe.com",
                "Buyer McBuyerson"
            ];
            
            foreach ($testValues as $testValue)
            {
                $account->setName($testValue);
                
                $this->assertSame($testValue, $account->getName());
            }
        }
        
        /**
         * Tests <i>setSecret</i> & <i>getSecret</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testSecretMethods() : void
        {
            $account = new Account();
            
            $testSecrets = [
                new Secret(),
                "YPPMQXR6UGWBP3UI",
                new Secret("RMB4AMUMDHODBYNR")
            ];
            
            foreach ($testSecrets as $testSecret)
            {
                $account->setSecret($testSecret);
                
                if ($testSecret instanceof Secret)
                {
                    $this->assertSame($testSecret->getValue(),
                        $account->getSecret()->getValue());
                }
                else
                {
                    $this->assertSame($testSecret,
                        $account->getSecret()->getValue());
                }
            }
        }
        
        /*******************\
        |* PRIMARY METHODS *|
        \*******************/
        
        /**
         * Tests constructor of the class.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testConstructor() : void
        {
            $testValues = [
                [ null,  null,  null ],
                [ "",  "",  null ],
                [ "A", "B", "RMB4AMUMDHODBYNR" ]
            ];
            
            foreach ($testValues as $testValue)
            {
                $account = new Account(
                    $testValue[0],
                    $testValue[1],
                    $testValue[2]
                );
                
                $this->assertSame($testValue[0],
                    $account->getService(), "getService");
                
                $this->assertSame($testValue[1],
                    $account->getName(), "getName");
                
                if ($testValue[2] !== null)
                {
                    $this->assertSame($testValue[2],
                        $account->getSecret()->getValue(), "getSecret");
                }
                else
                {
                    $this->assertSame($testValue[2], null, "getSecret");
                }
            }
        }
    }
    
?>
