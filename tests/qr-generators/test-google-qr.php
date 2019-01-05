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
    use Jocic\GoogleAuthenticator\Qr\Remote\GoogleQr;
    
    /**
     * <i>TestGoogleQr</i> class is used for testing method implementation of
     * the class <i>GoogleQr</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class TestGoogleQr extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>setQrCodeSize</i> & <i>getQrCodeSize</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testQrCodeSize()
        {
            // Core Variables
            
            $qr = new GoogleQr();
            
            // Step 1 - Set Valid Value
            
            $qr->setQrCodeSize(400);
            
            $this->assertSame(400, $qr->getQrCodeSize());
            
            // Step 2 - Set Invalid Value
            
            try
            {
                $qr->setQrCodeSize("#");
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid value provided.", $e->getMessage());
            }
        }
        
        /**
         * Tests <i>setStorageDirectory</i> & <i>getStorageDirectory</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testStorageDirectoryMethods()
        {
            // Core Variables
            
            $qr = new GoogleQr();
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            
            // Step 1 - Set Valid Setting
            
            $qr->setStorageDirectory($tempDirectory);
            
            $this->assertSame($tempDirectory, $qr->getStorageDirectory());
            
            // Step 2 - Set Invalid Setting
            
            try
            {
                $qr->setStorageDirectory(1337);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid storage directory used.",
                    $e->getMessage());
            }
        }
        
        /**
         * Tests <i>getAbsoluteLocation</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        /*public function testAbsoluteLocationMethod()
        {
            // Core Variables
            
            $qr = new GoogleQr();
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            
            // Step 1 - Test Before Directory Setting
            
            try
            {
                $qr->getAbsoluteLocation(1337);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid storage directory used.",
                    $e->getMessage());
            }
            
            // Step 2 - Test Before Account Setting
            
            
            
            // Step 3 - Test After Directory Setting
            
            
        }*/
        
        /**
         * Tests <i>getRelativeLocation</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        /*public function testRelativeLocationMethod()
        {
            // Core Variables
            
            $qr = new GoogleQr();
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            
            // Step 1 - Test Before Directory Setting
            
            
            
            
            // Step 2 - Test Before Account Setting
            
            
            
            // Step 3 - Test After Directory Setting
            
            
        }*/
        
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
            
            $qr = new GoogleQr();
            
            // Step 1 - Test Setting
            
            try
            {
                $qr->setApiKey("The cake is a lie!");
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Google's API doesn't require a key.",
                    $e->getMessage());
            }
            
            // Step 2 - Test Getting
            
            try
            {
                $qr->getApiKey();
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Google's API doesn't require a key.",
                    $e->getMessage());
            }
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
            
            $qr = new GoogleQr();
            
            // Other Variables
            
            $testCombinations = [[
                "serviceName" => "A",
                "accountName" => "B",
                "secretValue" => "RMB4AMUMDHODBYNR",
                "qrCodeSize"  => 200,
                "qrUrl"       => "https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FA+-+B%3Fsecret%3DRMB4AMUMDHODBYNR"
            ], [
                "serviceName" => "C",
                "accountName" => "D",
                "secretValue" => "4JT4TVALIJOHCRZX",
                "qrCodeSize"  => 300,
                "qrUrl"       => "https://chart.googleapis.com/chart?chs=300x300&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FC+-+D%3Fsecret%3D4JT4TVALIJOHCRZX"
            ], [
                "serviceName" => "E",
                "accountName" => "F",
                "secretValue" => "YPPMQXR6UGWBP3UI",
                "qrCodeSize"  => 400,
                "qrUrl"       => "https://chart.googleapis.com/chart?chs=400x400&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FE+-+F%3Fsecret%3DYPPMQXR6UGWBP3UI"
            ]];
            
            // Logic
            
            foreach ($testCombinations as $testCombination)
            {
                $secret  = new Secret();
                $account = new Account($testCombination["serviceName"],
                    $testCombination["accountName"],
                    $testCombination["secretValue"]);
                
                $qr->setQrCodeSize($testCombination["qrCodeSize"]);
                
                $this->assertSame($testCombination["qrUrl"], $qr->getUrl($account));
            }
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Tests <i>areParametersValid</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testParametersMethod()
        {
            // Core Variables
            
            $qr = new GoogleQr();
            
            // Other Variables
            
            $testCombinations = [
                false => [
                    "storage" => null,
                    "size"    => null
                ],
                false => [
                    "storage" => sys_get_temp_dir(),
                    "size"    => null
                ],
                false => [
                    "storage" => null,
                    "size"    => 400
                ],
                true => [
                    "storage" => sys_get_temp_dir(),
                    "size"    => 400
                ]
            ];
            
            // Logic
            
            foreach ($testCombinations as $testResult => $testCombination)
            {
                $qr = new GoogleQr();
                
                if ($testCombination["storage"] != null)
                {
                    $qr->setStorageDirectory($testCombination["storage"]);
                }
                
                if ($testCombination["size"] != null)
                {
                    $qr->setQrCodeSize($testCombination["size"]);
                }
                
                $this->assertEquals($testResult, $qr->areParametersValid());
            }
        }
        
        /*******************\
        |* PRIMARY METHODS *|
        \*******************/
        
        /**
         * Tests constructor of the class.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testConstructor()
        {
            // Core Variables
            
            $qr = null;
            
            // Other Variables
            
            $testValues = [[
                "directory" => null,
                "size"      => null
            ], [
                "directory" => sys_get_temp_dir(),
                "size"      => 400
            ]];
            
            // Logic
            
            foreach ($testValues as $testValue)
            {
                $qr = new GoogleQr($testValue["directory"], $testValue["size"]);
                
                $this->assertSame($testValue["directory"],
                        $qr->getStorageDirectory());
                
                $this->assertSame($testValue["size"], $qr->getQrCodeSize());
            }
        }
        
        /*********************\
        |* SECONDARY METHODS *|
        \*********************/
        
        // SECODARY METHODS GO HERE
    }
    
?>
