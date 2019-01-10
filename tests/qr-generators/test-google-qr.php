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
        
        public function testQrCodeSizeMethods()
        {
            // Core Variables
            
            $googleQr = new GoogleQr();
            
            // Step 1 - Set Valid Value
            
            $googleQr->setQrCodeSize(400);
            
            $this->assertSame(400, $googleQr->getQrCodeSize());
            
            // Step 2 - Set Invalid Value
            
            try
            {
                $googleQr->setQrCodeSize("#");
                
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
            
            $googleQr = new GoogleQr();
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            
            // Step 1 - Set Valid Setting
            
            $googleQr->setStorageDirectory($tempDirectory);
            
            $this->assertSame($tempDirectory, $googleQr->getStorageDirectory());
            
            // Step 2 - Set Invalid Setting
            
            try
            {
                $googleQr->setStorageDirectory(1337);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid storage directory used.",
                    $e->getMessage());
            }
        }
        
        /**
         * Tests <i>getFileLocation</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testFileLocationMethod()
        {
            // Core Variables
            
            $googleQr = null;
            $account  = new Account("A", "B", "RMB4AMUMDHODBYNR");
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            
            // Step 1 - Test Method Without QR Code Size
            
            $googleQr = new GoogleQr();
            
            $googleQr->setStorageDirectory($tempDirectory);
            
            try
            {
                $googleQr->getFileLocation($account);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("QR code size wasn't set.", $e->getMessage());
            }
            
            // Step 2 - Test Method Without Storage Directory Set
            
            $googleQr = new GoogleQr();
            
            $googleQr->setQrCodeSize(200);
            
            $this->assertEquals("./e5fd6380b30bce7e3cf1a722ea3af2d8a6dc2051.png",
                $googleQr->getFileLocation($account));
            
            unlink("./e5fd6380b30bce7e3cf1a722ea3af2d8a6dc2051.png");
            
            // Step 3 - Test Method With Both Parameters
            
            $googleQr = new GoogleQr();
            
            $googleQr->setQrCodeSize(200);
            $googleQr->setStorageDirectory($tempDirectory);
            
            $this->assertEquals("$tempDirectory/e5fd6380b30bce7e3cf1a722ea3af2d8a6dc2051.png",
                $googleQr->getFileLocation($account));
        }
        
        /**
         * Tests <i>getFilename</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testGetFilenameMethod()
        {
            // Core Variables
            
            $googleQr = new GoogleQr();
            $account  = new Account("A", "B", "RMB4AMUMDHODBYNR");
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            
            // Step 1 - Test Method Without QR Code Size
            
            try
            {
                $googleQr->getFileLocation($account);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("QR code size wasn't set.", $e->getMessage());
            }
            
            $googleQr->setQrCodeSize(200);
            $googleQr->setStorageDirectory($tempDirectory);
            
            // Step 2 - Test Method With Set QR Code Size
            
            $this->assertEquals("e5fd6380b30bce7e3cf1a722ea3af2d8a6dc2051.png",
                $googleQr->getFilename($account));
        }
        
        /**
         * Tests <i>getEncodedValue</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testEncodedValueMethod()
        {
            // Core Variables
            
            $googleQr = new GoogleQr();
            $account  = new Account("A", "B", "RMB4AMUMDHODBYNR");
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            
            // Step 1 - Set Core Parameters
            
            $googleQr->setQrCodeSize(200);
            $googleQr->setStorageDirectory($tempDirectory);
            
            // Step 2 - Test Supported Encodings
            
            $this->assertSame("89504E470D0A1A0A0000000D49484452000000C8000000C80802000000223A39C900000006624B474400FF00FF00FFA0BDA7930000047449444154789CEDDD616AE43A1085D1CE23FBDF72DE026C1821F4494A38E7E7D06D3BC91D4121B9EAEBE7E7E703AB7D7F3E9FAFAFAF834FF04CF6DCF38C5C67EE5EBFF1FFDEF1BFE97F076FCF1F265824048B846091102C12DFAFFFDAD541ABAAB0B9AA67E7DDBB6A77CEE6BFA9158B846091102C12824542B048BC57854F3B2B9A913DBEEE5B7357EEEACDB99F6B44FA37B56291102C12824542B048081689D1AA70A7AEEAD9791674559DF81BCFAF7EAC5844048B846091102C128245E2C6AAF069E7DB7F73BB8767EF7561E568C522215824048B846091102C12A355E1D95DB69D2751779E0E3D5BCDA577B76291102C12824542B048081689F7AAF06C07CB11672BACB97EA723E6DE61ECFAF34CB36291102C12824542B048081689AF0B0F1F8E38BB9FD85D67E79553562C12824542B048081609C122F13EAF70E75ED8D3AAC983DD679EEEDFD1EB3ABBBE7EC68A4542B048081609C122215824BE7E7E7E769E2DDCD913E6EC6EDDCE3A7AC4E6371FAD5824048B846091102C12824562650FD2915DA4B31D35574DE89BBBCECEFA6ED5DDED157217C122215824048B84609198EF41BAB3C29AAB4DCE9E3B7D5A758274E76F7EFA64AC158B846091102C12824542B048BC779BE9EAA05515CDD36DCFBCCACE9DC15575ABBD422A824542B048081609C122F1DE6D664ED77165E43AF74FA658F57B9EFB6DEC7CC28F158B886091102C12824542B0487C7FF6BE37B7AAA299BBFB6DD322BA33A5697FD19127B46291102C12824542B048081689957B854FBF71F6DFD953A6DD3B83DD9B98AFAC5824048B846091102C128245E27D324537C520ED703271AF91BBAFB2B323CD88745685158B846091102C12824542B048BC779B79F9DCC649F773CF3367E7A4FB6E17B2EB893ACD8A4542B048081609C122215824DA13A45D6D72DBCCBEB97BEDEC90F3949E56B56291102C12824542B0480816897632C5D3D9EB74B5E4CE3728CFF6961964C522215824048B846091102C12EF53EC476A81DBE6E8CDE9CE67AEAAB076F6839D63AF907D048B846091102C128245E2BD2AEC6616EC9CA3D79D4D3DFB99AE638F7985DC4EB048081609C122215824DE7B908E38BB5778DBB9D39DF32C769E839DAEEBAD5824048B846091102C12824562BE07E9D36DFB893BBBA476E74577CEE0F05E21B7132C12824542B048081689F9BDC255CEEE7C8DB87F6F6E27F30A3949B048081609C12221582446F70A773AFB36E2081D50FFF93C562C12824542B048081609C122D1CE2B1CB1B32CED2638CCF9AB1D503F562C22824542B048081609C122313F9962CECED9EEAB7A909E7DF3F1ECA9D7E9DD432B1609C122215824048B84609178AF0A9FCECE19DCD925A6FBD6FDD759D8D9C68A4542B048081609C12221582446ABC2B3569DFC9CBBD7CE898A5DF5BD6AAEFDE0335BB148081609C122215824048BC48D556157859D7D83F2A99B96F8FCD6E613AD562C12824542B048081609C122315A159EED09D3D5806777FDBA8A6FEE3AE615723BC122215824048B846091B8715EE16D33EB775E67D53EE9C23704279EC7640A2A824542B048081609C12271E3BC42FE80FF01CC76ECD4452ADE7C0000000049454E44AE426082",
                $googleQr->getEncodedValue($account, GoogleQr::E_BASE_16));
            
            $this->assertSame("RFIE4RYNBINAUAAAAAGUSSCEKIAAAAGIAAAABSAIAIAAAABCHI44SAAAAADGES2HIQAP6AH7AD72BPNHSMAAABDUJFCECVDYTTW52YLK4Q5BBBORZYR7XX3S3YBGYGBB6REUUOHH47IG2O6JDVASDOPK5PT6PZYDVN6X6PU7V6X27A2P6BGPNXHTRROGP3S6X7Y77XXRX7UX6B3PZ4PSMWBEASFYIYERCAWBFX5P77NNKQNLVKYLTKTH47O3W2TXZ3TL7KIVROCGBEIQFQJIERKCWBELYV4FJ45SXGURHW7O4W3TK7XOVTNZT5VUJ6RXWVRJCEBMCKBEKQVQJAEBNCORVJYKPLXK3F4RM5CVTX4BXT5PP2WFQRAEROCGBEIQFQJIERPCY2VPA2PH3N7XHO4HM7XXKYPFNDCSEIKYEQCIXBDASEICYEVDKXQ5SXNWTUTVC546BY6VXTNFO63WFEIQFQJIERKCWBEAQFUJ66VPA3AHZMIWOK5MXF7KOI7G3ZQ6Z6XTJSZWFEIQFQJIERKCWBEAQFUJV4FQ6H4OHC5Z7WC5M7TZKU2WFQJIERKCWBEAQFQJYERPCPVPODTV5WGTVLEYHXLHT3XN7UPLHK5347WGRJCUFMCIBALATQJCEFMCJPT6PZ7HNHRN3TMRHZXMN3O44OT2YTTDOH5NLASAJC4EMCIRALASQJCWEZIP2KIV3JFTDU2VOTPITO545TX2N3K533IVOIL4CIRBLASAJC4EMCIZR32BXKZ4FGVLJXHJ4O35LJ2YE5HHN57PUZFMCWFYIYERCAWBFASFIKYERPDXTPU6VICVCXG5G3OPXTFM5HOBKV22XPKCFKBEKQVQJAEBMCOBELY543LGJ3LXCZPEHL3U7JSY6V5Z563N5R6MFDYVROEGBEIQFQJIERKCWBEHY77WXY33PKVCTG57W3OTEK5DHJLJP7IZCJ5UMKIRALASQJCUFMCIBALITFL3QVH364PW37MVHJW5HOB53G4YV6WFQJAEROCGBEIQFQJIERPCPUZEKN6FEDWXAMTRV6I3XL5SWMR43CDUK2CRLC4EMCIRALASQJCUFMCIXR3ZW6PZ3TDET53TZ4ZWPZ5E7NXBPMXLRE5M3CSFIKYEQCAWBHASEIKYETNBHJC5NVZNXTF6XF5633EQ6OKJ4VVVMKIRALASQJCUFMCIBALIS5RSYXJ5T23UWXSM4NZIZ73JMGLEYURCCWBEASFYIYERCAWBF32T5RDWVAO343UM32OOM6XKVMDW62BZ2Y5PSB6QJC4EMCIRALASQJC6FPJK5RTBN3E4UPLZ2TJ57OM24Y4PPGC5YTVQJAEBMCOBEIQVQJG6POII4OF3K54NXOOTTXZSY5U6QOO2525NLASAJC4EMCIRALASQJCWFPQH5HJW364JHO52I5XHIV345YHQLYQ3OEZMCKBEKQVQJAEBNCPZXXBFLTXOPSG3Q73PNYT7GCRZJGYEQCAWBHASEIKYERDPOCTXHL5TNYQIDVIP76J4KYWBFASFIKYEQCAWBHASFUOOFMOLDMZM5UTDRTHZVMOVAP2WFQRIERKCWBEAQFQJYERDCP4ZMLHM5WPOVN5JBHT56PY6ZKOX5HOUGKYWBHASEIKYEQCIXBDASF4K6CU7Z3HBTXGZEWTPXVX525M5RWOGRJCUFMCIBALATQJCEFMCIRVLYKZVNHP4TS55PTUJRJO7LPLKV366AM23WFEAQFQJYERCCWBEASF4JDKVMFLYLHL5QPZKTG4W7D6NNZQTVVLCYEUCIVBLASAICYE4CIRRLIKZ53IJ2PKYAZ3X7W5IU37OHLTBK4R3YERCCWBEASFYIYERXBYV5YLNGPVXOXTH2U7OTQRXAQTZ5R3EBIVIERKCWBEAQFQJYERHDY54IL7IB7YBZR3OZVCFFLPHYAAAAAAESRKOISXEEYEC",
                $googleQr->getEncodedValue($account, GoogleQr::E_BASE_32));
            
            // Step 3 - Test Unsupported Encoding
            
            try
            {
                $googleQr->getEncodedValue($account, 1337);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid encoding ID provided.", $e->getMessage());
            }
        }
        
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
            
            $googleQr = new GoogleQr();
            
            // Step 1 - Test Setting
            
            try
            {
                $googleQr->setApiKey("The cake is a lie!");
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Google's API doesn't require a key: " .
                    "The cake is a lie!", $e->getMessage());
            }
            
            // Step 2 - Test Getting
            
            try
            {
                $googleQr->getApiKey();
                
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
            
            $googleQr = new GoogleQr();
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            
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
            
            // Step 1 - Test Combinations
            
            foreach ($testCombinations as $testCombination)
            {
                $account = new Account($testCombination["serviceName"],
                    $testCombination["accountName"],
                    $testCombination["secretValue"]);
                
                $googleQr->setQrCodeSize($testCombination["qrCodeSize"]);
                $googleQr->setStorageDirectory($tempDirectory);
                
                $this->assertSame($testCombination["qrUrl"],
                    $googleQr->getUrl($account));
            }
            
            // Step 2 - Teset Method Without Secret
            
            try
            {
                $account = new Account();
                
                $googleQr->getUrl($account);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Set account is without a secret.",
                    $e->getMessage());
            }
            
            // Step 3 - Test Method Without Details
            
            try
            {
                $account = new Account();
                
                $account->setAccountSecret(new Secret());
                
                $googleQr->getUrl($account);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Set account is without details.",
                    $e->getMessage());
            }
        }
        
        /**
         * Tests <i>regenerate</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testRegenerateMethod()
        {
            // Core Variables
            
            $googleQr = new GoogleQr();
            $account  = new Account("A", "B", "RMB4AMUMDHODBYNR");
            
            // Other Variables
            
            $testFile = "171fac1957f9625d712b639dfaf3e8569a204486.png";
            
            // Logic
            
            $googleQr->saveToFile($testFile, "...");
            
            $googleQr->regenerate($account);
            
            $this->assertFalse($googleQr->loadFromFile($testFile) == "...");
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        // CHECK METHODS GO HERE
        
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
            
            $googleQr = null;
            
            // Other Variables
            
            $testValues = [[
                "size"      => null,
                "directory" => null
            ], [
                "size"      => 400,
                "directory" => sys_get_temp_dir()
            ]];
            
            // Logic
            
            foreach ($testValues as $testValue)
            {
                $googleQr = new GoogleQr($testValue["size"],
                    $testValue["directory"]);
                
                $this->assertSame($testValue["size"],
                    $googleQr->getQrCodeSize());
                
                $this->assertSame($testValue["directory"],
                        $googleQr->getStorageDirectory());
            }
        }
        
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
