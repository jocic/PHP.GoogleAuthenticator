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
    use Jocic\GoogleAuthenticator\Encoder;
    use Jocic\GoogleAuthenticator\QrCode;
    
    use Jocic\GoogleAuthenticator\Encoders\Go;
    
    /**
     * <i>TestQr</i> class is used for testing method implementation
     * of the class <i>QrCode</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class TestQr extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>setDirectory</i> & <i>getDirectory</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testDirectoryMethods() : void
        {
            // Core Variables
            
            $qr = new QrCode();
            
            // Step 1 - Test Valid Paths
            
            $validValues = [
                "/tmp"     => "/tmp",
                "/tmp  "   => "/tmp",
                "  /tmp  " => "/tmp",
                "/tmp/../" => "/"
            ];
            
            foreach ($validValues as $relativeDirectory
                => $absoluteDirectory)
            {
                $qr->setDirectory($relativeDirectory);
                
                $this->assertSame($absoluteDirectory, $qr->getDirectory());
            }
            
            // Step 2 - Test Invalid Paths
            
            $invalidValues = [
                "/tmp1", "/tmp2  ", "  /tmp3  ", "/tmp4/../"
            ];
            
            foreach ($invalidValues as $testValue)
            {
                try
                {
                    $qr->setDirectory($testValue);
                    
                    $this->fail("Exception should've been thrown!");
                }
                catch (\Exception $e)
                {
                    $this->assertEquals("Invalid directory provided.",
                        $e->getMessage());
                }
            }
        }
        
        /**
         * Tests <i>setFilename</i> & <i>getFilename</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testFilenameMethods() : void
        {
            // Core Variables
            
            $qr = new QrCode();
            
            // Step 1 - Test Valid Filenames
            
            $testValues = [
                "a-b.svg"          => "a-b.svg",
                "a b c.svg"        => "a b c.svg",
                "  test.png  "     => "test.png",
                "test.png"         => "test.png",
                "/tmp/test.png"    => "test.png",
                "test.jpg"         => "test.jpg",
                "/tmp/../test.jpg" => "test.jpg",
            ];
            
            foreach ($testValues as $providedFilename
                => $processedFilename)
            {
                $qr->setFilename($providedFilename);
                
                $this->assertSame($processedFilename, $qr->getFilename());
            }
            
            // Step 2 - Test Invalid Filenames
            
            $invalidValues = [
                "", " ", "   "
            ];
            
            foreach ($invalidValues as $testValue)
            {
                try
                {
                    $qr->setFilename($testValue);
                    
                    $this->fail("Exception should've been thrown!");
                }
                catch (\Exception $e)
                {
                    $this->assertEquals("Invalid filename provided.",
                        $e->getMessage());
                }
            }
        }
        
        /**
         * Tests <i>getPath</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testPathMethod() : void
        {
            // Core Variables
            
            $qr = new QrCode();
            
            // Other Variables
            
            $testValues = [
                [ "/tmp", "001.png", "/tmp/001.png" ],
                [ "/tmp/../", "002.jpg", "/002.jpg" ],
                [ "/tmp", "  003.gif  ", "/tmp/003.gif" ],
                [ "  /tmp  ", "004.svg", "/tmp/004.svg" ]
            ];
            
            // Logic
            
            foreach ($testValues as $testValue)
            {
                $qr->setDirectory($testValue[0]);
                $qr->setFilename($testValue[1]);
                
                $this->assertSame($testValue[2], $qr->getPath());
            }
        }
        
        /**
         * Tests <i>setEncoder</i> & <i>getEncoder</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testEncoderMethods() : void
        {
            // Core Variables
            
            $qr = new QrCode();
            $go = new Go();
            
            $this->assertSame(null, $qr->getEncoder());
            
            $qr->setEncoder($go);
            
            $this->assertSame($go, $qr->getEncoder());
        }
        
        /*******************\
        |* PRIMARY METHODS *|
        \*******************/
        
        /**
         * Tests <i>generate</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testGenerateMethod() : void
        {
            $temp_dir = sys_get_temp_dir();
            
            /////////////////////////////
            
            $account = new Account();
            
            $account->setService("My Service");
            $account->setName("john@doe.com");
            $account->setSecret("RMB4AMUMDHODBYNR");
            
            /////////////////////////////
            
            $encoder = new Go();
            
            $encoder->setSize(60);
            $encoder->setErrorCorrection(Encoder::ECC_LOW);
            $encoder->setFormat(Encoder::FORMAT_JPG);
            
            /////////////////////////////
            
            $qrCode = new QrCode();
            
            $qrCode->setDirectory($temp_dir);
            $qrCode->setFilename("test.jpg");
            $qrCode->setEncoder($encoder);
            
            /////////////////////////////
            
            $this->assertSame(true, $qrCode->generate($account));
            $this->assertSame(true, file_exists($qrCode->getPath()));
        }
    }
    
?>
