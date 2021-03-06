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
    
    use Jocic\GoogleAuthenticator\Account;
    use Jocic\GoogleAuthenticator\Secret;
    use Jocic\GoogleAuthenticator\Qr\Remote\Scanova;
    
    /**
     * <i>TestGoQr</i> class is used for testing method implementation of the
     * class <i>GoQr</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class TestScanova extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>setApiKey</i> & <i>getApiKey</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testApiKeyMethods()
        {
            // Core Variables
            
            $scanova = new Scanova();
            $test    = "1234567890";
            
            // Logic
            
            $scanova->setApiKey($test);
            
            $this->assertEquals($test, $scanova->getApiKey());
        }
        
        /**
         * Tests <i>getUrl</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testUrlMethtod()
        {
            // Core Variables
            
            $scanova = new Scanova();
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            
            // Other Variables
            
            $testCombinations = [[
                "serviceName" => "A",
                "accountName" => "B",
                "secretValue" => "RMB4AMUMDHODBYNR",
                "qrCodeSize"  => "s",
                "qrUrl"       => "https://api.scanova.io/v2/qrcode/url?size=s&url=otpauth%3A%2F%2Ftotp%2FA%2520-%2520B%3Fsecret%3DRMB4AMUMDHODBYNR&apikey=1234567890",
                "apiKey"      => "1234567890"
            ], [
                "serviceName" => "C",
                "accountName" => "D",
                "secretValue" => "4JT4TVALIJOHCRZX",
                "qrCodeSize"  => "l",
                "qrUrl"       => "https://api.scanova.io/v2/qrcode/url?size=l&url=otpauth%3A%2F%2Ftotp%2FC%2520-%2520D%3Fsecret%3D4JT4TVALIJOHCRZX&apikey=0987654321",
                "apiKey"      => "0987654321"
            ], [
                "serviceName" => "E",
                "accountName" => "F",
                "secretValue" => "YPPMQXR6UGWBP3UI",
                "qrCodeSize"  => "xxl",
                "qrUrl"       => "https://api.scanova.io/v2/qrcode/url?size=xxl&url=otpauth%3A%2F%2Ftotp%2FE%2520-%2520F%3Fsecret%3DYPPMQXR6UGWBP3UI&apikey=XXXXXXXXXXX",
                "apiKey"      => "XXXXXXXXXXX"
            ]];
            
            // Step 1 - Test Combinations
            
            foreach ($testCombinations as $testCombination)
            {
                $account = new Account($testCombination["serviceName"],
                    $testCombination["accountName"],
                    $testCombination["secretValue"]);
                
                $scanova->setQrCodeSize($testCombination["qrCodeSize"]);
                $scanova->setApiKey($testCombination["apiKey"]);
                $scanova->setStorageDirectory($tempDirectory);
                
                $this->assertSame($testCombination["qrUrl"],
                    $scanova->getUrl($account));
            }
            
            // Step 2 - Teset Method With Invalid Secret
            
            try
            {
                $scanova->getUrl(new Secret());
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid object provided.",
                    $e->getMessage());
            }
            
            // Step 3 - Teset Method Without Secret
            
            try
            {
                $account = new Account();
                
                $scanova->getUrl($account);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Account is without a secret.",
                    $e->getMessage());
            }
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        // CHECK METHODS GO HERE
        
        /*******************\
        |* PRIMARY METHODS *|
        \*******************/
        
        // PRIMARY METHODS GO HERE
        
        /*********************\
        |* SECONDARY METHODS *|
        \*********************/
        
        // SECODARY METHODS GO HERE
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        // OTHER METHODS GO HERE
    }
    
?>
