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
            
            $this->assertEquals("./bdd9d6fa406053b792f8ee1e7a0cd294892203ff.png",
                $googleQr->getFileLocation($account));
            
            unlink("./bdd9d6fa406053b792f8ee1e7a0cd294892203ff.png");
            
            // Step 3 - Test Method With Both Parameters
            
            $googleQr = new GoogleQr();
            
            $googleQr->setQrCodeSize(200);
            $googleQr->setStorageDirectory($tempDirectory);
            
            $this->assertEquals("$tempDirectory/bdd9d6fa406053b792f8ee1e7a0cd294892203ff.png",
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
                $googleQr->getFilename($account);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("QR code size wasn't set.", $e->getMessage());
            }
            
            $googleQr->setQrCodeSize(200);
            $googleQr->setStorageDirectory($tempDirectory);
            
            // Step 2 - Test Method With Set QR Code Size
            
            $this->assertEquals("bdd9d6fa406053b792f8ee1e7a0cd294892203ff.png",
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
            
            $googleQr->regenerate($account);
            
            $this->assertSame("89504E470D0A1A0A0000000D49484452000000C8000000C80802000000223A39C900000006624B474400FF00FF00FFA0BDA7930000049849444154789CEDDDCB8EE3381045417B50FFFFCBEEFDC80B82E049A90A11CBC65854D9170472F8C8F7E7F379C1693FAFD7EBFD7EDFF806D7645FDF6725FD2B7FC5CA587BF6DE70EF7D4E7D1B9DCFE7F3DF8DC3F387091609C122215824048BC4CFD77FEDFE1FC4A9AAE794BDB156FE8ABD1AF054757935FC9B9AB148081609C122215824048BC4F7AAF06A6FEDE95425726A1DF0DE2A6CAF96ECA4BFA9198B846091102C12824542B048AC568593F6AA956E0769B7CF736FAC5FB19BDC8C4542B048081609C1222158249E58155EEDD54A2B6B852B63EDBDCFA97AF357D48057662C12824542B048081609C122B15A15DE5B9B74FB2A276F6E3975FAEF54E598FEA6662C12824542B048081609C122F1BD2ABCF706CBAB5377879E5A9B3BB57639B95638FC9B9AB148081609C122215824048BC4FB811B14276FB6995C077CDAE829331609C122215824048B846091787F3E9F53EB53A7FAF15D4DEEAB5C7972E7DEEAF26AFB9B376391102C12824542B048081689EF6B85937B1D27EF5799EC23BF32FACA93EFFD7EF6A80AA9081609C122215824048BC4EA5AE1BD356057A9AD8CD5759FEFDC7E12D38C4542B048081609C12221582456D70A4FE9F682769FEAEAA9954F5D3D6DCDD10E52E6081609C122215824048BC47E678AA7ADFA9DAAE6569E7C35593976CF3958239BB148081609C122215824048BC46A55F81B4FE44DEE29BDB70FC503EFC3316391102C12824542B0480816899FD7B96A6EA5EA995C0B9BAC52BB3EF2DD7ED174A7AE198B846091102C12824542B048ACAE155EEDADA0ED3DF9DE1AA7DB9F79D58DBE32D61EE70A99235824048B846091102C126DBFC23D9377CB9C7A9F15DDCD362B86F7B89AB148081609C122215824048BC4F73B488F3DFD4FD49BA7C6BA772FE8E41DADD60AA9081609C122215824048BC4C9DB664E3D67B283C38AA775545CD19DBB74AE903B091609C122215824048BC47E678A3D5D65746F67F9C935D0AE6A3EF8EB98B148081609C122215824048BC46A17FBC91370A74CEEE1BC1ADEB17964F483CC5824048B846091102C12824562F5B699E7EFFC9CEC9F78D5BDF3BDB7E86C7F87662C12824542B048081609C12271F2B699C9EA72C5BDBD08579EBCA75B033DF53E2F331611C122215824048B846091D8EF57B8A2ABB0566A9CC91B50579E7C6F8D3CDC95C38C4542B048081609C1222158247E5EB32B4D7B95DAA9FFA6DBE3FAFCDDAAA72CFEA5662C12824542B048081609C122F1F3DAAD56866F2FF99F53EB8093A71127574E57E862CFEF235824048B846091102C12DF6F9B9974EFB9C2C95B49574CDE41AA3305BF8F6091102C12824542B0487C3F5738D9557065F4BD1A67E553A72AC77BEF7B59196B98198B846091102C12824542B048ACDE3633795749D705A33BD5B857393EEDA4E1C11E8B662C12824542B048081609C122D1DE41BA67B28BDFD32AD0ABC97B4AF746D7998239824542B048081609C122F1C4AAF0AADB0F397947CDD55ECD35D91752670A9E45B048081609C12221582456ABC2DBCFA91DF1B41A70EF53DDBAA4DB66783AC122215824048B846091F85E153EAD23DEBD7B26579CDA1D7AEA535D67C6C59AD48C4542B048081609C122215824DE7F631190A7F907CD58049E390510EF0000000049454E44AE426082",
                $googleQr->getEncodedValue($account, GoogleQr::E_BASE_16));
            
            $this->assertSame("RFIE4RYNBINAUAAAAAGUSSCEKIAAAAGIAAAABSAIAIAAAABCHI44SAAAAADGES2HIQAP6AH7AD72BPNHSMAAABEYJFCECVDYTTW53S4O4M4BARKBPNIP776L5364QC4C4BE2SCQRZPDFQVGZC4CHF6GI67T7G6OBNE727V7L7V7N76AG25SF7X3HEX6SW76FZJMHX5W6ODXX2TT5DOO47Z7T36G4H44HBELATQJCEFMCIBELYTH5O77N7YP4JKNK46KL3MKW72FL2GXQKR2XSNP4TONLCSAICYE4CIRBLASAJC6E66VPA2TP5XUVIJLSNIO7BXRKNSXZN3FEX6URTC4EMCIRALASQJCUFMCIVRLILE7WVKKW4B3JW7HXG35ML6YZXXEMIVBLASAICYE4CIRBLASJ4WAVL3W5KSRLNOCSWY7NXXH2S6XTK7KIAV3GFQJIERKCWBEAQFQJYERLCWQV3ZNZW5H3FITW63RZOX5O6VHFTD7KMZRMCKBEKQVQJAEBMCOBELY32KV464DMXK2TO6DZ4WU3HO2XMONZKY4PZG42WFEAQFQJYERCCWBEASF4J64BDMKCO35WTFOAO7G25AUTGFQJYERCCWBEASFYIYERPB7T5H2T5NJ2P6XRLVG65K24PFZOPXXK6JVPXGZXMOIRALASQJCUFMCIBALIT33LQWJXWHJH55LZT3BDX4ZPVSUT576X55VIBKUQQFQJYERCCWBEASF4J2S24G6TKYCXVGWYZVLVT7X5Y7QS2OGEKQVQJAEBMCOBEIQVQJCW24FE72PWQJ3J72XKVGKU6XJ5NXG5CDSS4YEBMCOBEIQVQJAERPCH4Z4KU6W7VHNK4ZLJ47BVLE4XNTZZLARZXMKIBALATQJCEFMCIBELYRVFL6A3J7SE33RJXW3Q7RID57BTCY4RCAWBFASFIKYEQCAWRGP5POLKN2S6VGK4BON2YUV3H3ZN27WROST24GMLQRQJCEBMCKBEKQVQJCWK4FK65WW2B3J57HPBVJ63T545LDN6GLLB5ZYKTERVQJAEROCGBEIQFQJG3P6CHWJXPS44PKPRLXONGYVYN55YTKYUQCAWBHASEIKYEQCIXRHXHNEI6PP5J7KJXJ6GXJ3S72HEDWW5MCVJBALATQJCEFMCIBELYTE5WZSOHVT3FA6DRKTXKVC42GO3W5FOSA5QSFQJYERCCWBEASF4I7THRI6V2ZLUN5T7TSJV2CXGUPXY5OMLCSAICYE4CIRBLASAJC6ENIL7XSITOCTUZ3XBXQNN5MLZMT2IHTCYEQCIXBDASEICYEUCIVRPLNUZ47X7ZHHMT54NLPPTXW36Q3D7Q5TCYEUCIVBLASAICYE4CITR6K3JTSPKOLC33PIIK6PLZJ23AM67KPRPGMLBDQJCEFMCIBELQRQJDWHPK64KFK5QKZVJZSI3KBLZ47DPRU6NZFODRRCUFMCIBALATQJCEFMCI7S6WMVU264V3KU77JW34P5PZXNKU4WP5JLGFQJIERKCWBEAQFQJYERPD462VVLIM3ZP7GPVH24ASOTRCJ2XJZL6QYWP54RVQJAEROCGBEIQFQJN6343TF2O7OOCZFNUSV2M3ZA2UMYFX6HWBEIQFQJIERKCWBEHYP2XHDMVK4DF6S6RUZ7FKOTSVR33555VSGLLTAMYXBDASEICYEUCIVBLASFM3Y3DG6KXJHLQLIZ32W4FOOJ65WSODQI6RNTCYEUCIVBLASAICYE4CIWR3ZA3UZ5SRPP5GKWQVPEXWSXXI3LZTARZQJCUFMCIBALATQJC6HCKV4FK3MHTS6KHZXKV5TJV3ELVEZYKTZC3ASAICYE4CIRBLASFNK6C3PH2SHPRWQNHB32T3W5KJW3GPA5MCIRBLASAJC4EMCI7QXQVH2WSHXV5PMTFPHG2DV5OUU25M7DMLGWURRCUFMCIBALATQJCEFMCJXT7MMIZBJ7ZA7GVQBE6HECRB3YAAAAAASKFJZCK4QTAQI======",
                $googleQr->getEncodedValue($account, GoogleQr::E_BASE_32));
            
            $this->assertSame("iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAIAAAAiOjnJAAAABmJLR0QA/wD/AP+gvaeTAAAEmElEQVR4nO3dy47jOBBFQXtQ///L7v3IC4LgSakKEcvGWFTZFwRy+Mj35/N5wWk/r9fr/X7f+AbXZF/fZyX9K3/Fylh79t5w731OfRudz+fz343D84cJFgnBIiFYJASLxM/Xf+3+H8SpqueUvbFW/oq9GvBUdXk1/JuasUgIFgnBIiFYJASLxPeq8Gpv7elUJXJqHfDeKmyvluykv6kZi4RgkRAsEoJFQrBIrFaFk/aqlW4HabfPc2+sX7Gb3IxFQrBICBYJwSIhWCSeWBVe7dVKK2uFK2Ptvc+pevNX1IBXZiwSgkVCsEgIFgnBIrFaFd5bm3T7Kidvbjl1+u9U5Zj+pmYsEoJFQrBICBYJwSLxvSq89wbLq1N3h55amzu1djm5Vjj8m5qxSAgWCcEiIVgkBIvE+4EbFCdvtplcB3za6CkzFgnBIiFYJASLhGCReH8+n1PrU6f68V1N7qtceXLn3uryavubN2ORECwSgkVCsEgIFonva4WTex0n71eZ7CO/MvrKk+/9fvaoCqkIFgnBIiFYJASLxOpa4b01YFeprYzVdZ/v3H4S04xFQrBICBYJwSIhWCRW1wpP6faCdp/q6qmVT109bc3RDlLmCBYJwSIhWCQEi8R+Z4qnrfqdquZWnnw1WTl2zzlYI5uxSAgWCcEiIVgkBIvEalX4G0/kTe4pvbcPxQPvwzFjkRAsEoJFQrBICBaJn9e5am6l6plcC5usUrs+8t1+0XSnrhmLhGCRECwSgkVCsEisrhVe7a2g7T353hqn25951Y2+MtYe5wqZI1gkBIuEYJEQLBJtv8I9k3fLnHqfFd3NNiuG97iasUgIFgnBIiFYJASLxPc7SI89/U/Um6fGuncv6OQdrdYKqQgWCcEiIVgkBIvEydtmTj1nsoPDiqd1VFzRnbt0rpA7CRYJwSIhWCQEi8R+Z4o9XWV0b2f5yTXQrmo++OuYsUgIFgnBIiFYJASLxGoX+8kTcKdM7uG8Gt6xeWT0g8xYJASLhGCRECwSgkVi9baZ5+/8nOyfeNW987236Gx/h2YsEoJFQrBICBYJwSJx8raZyepyxb29CFeevKdbAz31Pi8zFhHBIiFYJASLhGCR2O9XuKKrsFZqnMkbUFeefG+NPNyVw4xFQrBICBYJwSIhWCR+XrMrTXuV2qn/ptvj+vzdqqcs/qVmLBKCRUKwSAgWCcEi8fParVaGby/5n1PrgJOnESdXTlfoYs/vI1gkBIuEYJEQLBLfb5uZdO+5wslbSVdM3kGqMwW/j2CRECwSgkVCsEh8P1c42VVwZfS9GmflU6cqx3vve1kZa5gZi4RgkRAsEoJFQrBIrN42M3lXSdcFozvVuFc5Pu2k4cEei2YsEoJFQrBICBYJwSLR3kG6Z7KL39Mq0KvJe0r3RteZgjmCRUKwSAgWCcEi8cSq8KrbDzl5R83VXs012RdSZwqeRbBICBYJwSIhWCRWq8Lbz6kd8bQacO9T3bqk22Z4OsEiIVgkBIuEYJH4XhU+rSPevXsmV5zaHXrqU11nxsWa1IxFQrBICBYJwSIhWCTef2MRkKf5B81YBJ45BRDvAAAAAElFTkSuQmCC",
                $googleQr->getEncodedValue($account, GoogleQr::E_BASE_64));
            
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
                $this->assertEquals("API doesn't require a key: " .
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
                $this->assertEquals("API doesn't require a key.",
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
                "qrUrl"       => "https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FA%2520-%2520B%3Fsecret%3DRMB4AMUMDHODBYNR"
            ], [
                "serviceName" => "C",
                "accountName" => "D",
                "secretValue" => "4JT4TVALIJOHCRZX",
                "qrCodeSize"  => 300,
                "qrUrl"       => "https://chart.googleapis.com/chart?chs=300x300&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FC%2520-%2520D%3Fsecret%3D4JT4TVALIJOHCRZX"
            ], [
                "serviceName" => "E",
                "accountName" => "F",
                "secretValue" => "YPPMQXR6UGWBP3UI",
                "qrCodeSize"  => 400,
                "qrUrl"       => "https://chart.googleapis.com/chart?chs=400x400&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FE%2520-%2520F%3Fsecret%3DYPPMQXR6UGWBP3UI"
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
            
            // Step 2 - Teset Method With Invalid Secret
            
            try
            {
                $googleQr->getUrl(new Secret());
                
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
                
                $googleQr->getUrl($account);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Account is without a secret.",
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
            
            $googleQr = new GoogleQr(200);
            $account  = new Account("A", "B", "RMB4AMUMDHODBYNR");
            
            // Other Variables
            
            $tempDirectory = sys_get_temp_dir();
            $tempFilename  = "bdd9d6fa406053b792f8ee1e7a0cd294892203ff.png";
            $tempLocation  = join(DIRECTORY_SEPARATOR, [
                $tempDirectory,
                $tempFilename
            ]);
            
            // Logic
            
            $googleQr->setStorageDirectory($tempDirectory);
            
            $googleQr->saveToFile($tempLocation, "...");
            
            $googleQr->regenerate($account);
            
            $this->assertFalse($googleQr->loadFromFile($tempLocation) == "...");
            
            unlink($tempLocation);
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
