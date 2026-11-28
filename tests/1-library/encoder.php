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
    
    use Jocic\GoogleAuthenticator\Encoder;
    
    /**
     * <i>TestEncoder</i> class is used for testing method implementation
     * of the class <i>Encoder</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class TestEncoder extends TestCase
    {
        /*****************\
        |* DEFAULT STATE *|
        \*****************/
        
        /**
         * Tests the default state of a freshly instantiated encoder.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testDefaults() : void
        {
            $encoder = new Encoder();
            
            $this->assertSame(320,
                $encoder->getSize());
            
            $this->assertSame(Encoder::ECC_LOW,
                $encoder->getErrorCorrection());
                
            $this->assertSame(Encoder::FORMAT_PNG,
                $encoder->getFormat());
                
            $this->assertSame(5,
                $encoder->getMargin());
                
            $this->assertSame("#ffffff",
                $encoder->getBackgroundColor());
                
            $this->assertSame("#000000",
                $encoder->getForegroundColor());
                
            $this->assertSame(null,
                $encoder->getData());
                
            $this->assertSame(null,
                $encoder->getEncoding());
                
            $this->assertSame(null,
                $encoder->getEmbeddable());
        }
        
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>setSize</i> & <i>getSize</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testSizeMethods() : void
        {
            // Step 1 - Test Valid Values
            
            $encoder = new Encoder();
            
            $validValues = [
                10, 320, 640, 1000
            ];
            
            foreach ($validValues as $validValue)
            {
                $this->assertSame($encoder,
                    $encoder->setSize($validValue));
                    
                $this->assertSame($validValue,
                    $encoder->getSize());
            }
            
            // Step 2 - Test Invalid Values
            
            $encoder = new Encoder();
            
            $invalidValues = [
                -10, 5, 9, 1001
            ];
            
            foreach ($invalidValues as $invalidValue)
            {
                try
                {
                    $encoder->setSize($invalidValue);
                    
                    $this->fail("Exception should've been thrown!");
                }
                catch (\Exception $e)
                {
                    $this->assertEquals("Invalid size provided.",
                        $e->getMessage());
                }
            }
        }
        
        /**
         * Tests <i>setErrorCorrection</i> & <i>getErrorCorrection</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testErrorCorrectionMethods() : void
        {
            // Step 1 - Test Valid Values
            
            $encoder = new Encoder();
            
            $validValues = [
                Encoder::ECC_LOW,
                Encoder::ECC_MEDIUM,
                Encoder::ECC_HIGH
            ];
            
            foreach ($validValues as $validValue)
            {
                $this->assertSame($encoder,
                    $encoder->setErrorCorrection($validValue));
                    
                $this->assertSame($validValue,
                    $encoder->getErrorCorrection());
            }
            
            // Step 2 - Test Invalid Value
            
            $encoder = new Encoder();
            
            $invalidValues = [
                -10, -1, 10, 1000
            ];
            
            foreach ($invalidValues as $invalidValue)
            {
                try
                {
                    $encoder->setErrorCorrection($invalidValue);
                    
                    $this->fail("Exception should've been thrown!");
                }
                catch (\Exception $e)
                {
                    $this->assertEquals("invalid ECC value provided.",
                        $e->getMessage());
                }
            }
        }
        
        /**
         * Tests <i>setFormat</i> & <i>getFormat</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testFormatMethods() : void
        {
            // Step 1 - Test Valid Values
            
            $encoder = new Encoder();
            
            $validValues = [
                Encoder::FORMAT_PNG, Encoder::FORMAT_JPG,
                Encoder::FORMAT_GIF, Encoder::FORMAT_SVG,
                Encoder::FORMAT_EPS, Encoder::FORMAT_WEBP
            ];
            
            foreach ($validValues as $validValue)
            {
                $this->assertSame($encoder,
                    $encoder->setFormat($validValue));
                    
                $this->assertSame($validValue,
                    $encoder->getFormat());
            }
            
            // Step 2 - Test Invalid Value
            
            $invalidValues = [
                -10, -1, 10, 1000
            ];
            
            foreach ($invalidValues as $invalidValue)
            {
                try
                {
                    $encoder->setFormat($invalidValue);
                    
                    $this->fail("Exception should've been thrown!");
                }
                catch (\Exception $e)
                {
                    $this->assertEquals("invalid format value provided.",
                        $e->getMessage());
                }
            }
        }
        
        /**
         * Tests <i>setMargin</i> & <i>getMargin</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testMarginMethods() : void
        {
            // Step 1 - Test Valid Values
            
            $encoder = new Encoder();
            
            $validValues = [
                0, 25, 50
            ];
            
            foreach ($validValues as $validValue)
            {
                $this->assertSame($encoder,
                    $encoder->setMargin($validValue));
                
                $this->assertSame($validValue,
                    $encoder->getMargin());
            }
            
            // Step 2 - Test Invalid Values
            
            $encoder = new Encoder();
            
            $invalidValues = [
                -1, 51
            ];
            
            foreach ($invalidValues as $invalidValue)
            {
                try
                {
                    $encoder->setMargin($invalidValue);
                    
                    $this->fail("Exception should've been thrown!");
                }
                catch (\Exception $e)
                {
                    $this->assertEquals("Invalid margin provided.",
                        $e->getMessage());
                }
            }
        }
        
        /**
         * Tests <i>setBackgroundColor</i>, <i>setForegroundColor</i> and
         * their corresponding getter methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testColorMethods() : void
        {
            // Step 1 - Test Valid Values
            
            $encoder = new Encoder();
            
            $validValues = [
                "#ffffff", "#FFFFFF", "#00ff00", "#ABCDEF",
                " #ffffff", "#FFFFFF ", " #00ff00 ", "#aBcDeF"
            ];
            
            foreach ($validValues as $validValue)
            {
                $this->assertSame($encoder,
                    $encoder->setBackgroundColor($validValue));
                
                $this->assertSame(trim($validValue),
                    $encoder->getBackgroundColor());
            }
            
            foreach ($validValues as $validValue)
            {
                $this->assertSame($encoder,
                    $encoder->setForegroundColor($validValue));
                
                $this->assertSame(trim($validValue),
                    $encoder->getForegroundColor());
            }
            
            // Step 2 - Test Invalid Values
            
            $encoder = new Encoder();
            
            $invalidValues = [
                "ffffff", "#FFF", "#00ffQ0", "#ABCPEF",
                " #red", "red ", "255", "#255"
            ];
            
            foreach ($invalidValues as $invalidValue)
            {
                try
                {
                    $encoder->setBackgroundColor($invalidValue);
                    
                    $this->fail("Exception should've been thrown!");
                }
                catch (\Exception $e)
                {
                    $this->assertEquals("Invalid color provided.",
                        $e->getMessage());
                }
            }
            
            foreach ($invalidValues as $invalidValue)
            {
                try
                {
                    $encoder->setForegroundColor($invalidValue);
                    
                    $this->fail("Exception should've been thrown!");
                }
                catch (\Exception $e)
                {
                    $this->assertEquals("Invalid color provided.",
                        $e->getMessage());
                }
            }
        }
        
        /**
         * Tests <i>setData</i> & <i>getData</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testDataMethods() : void
        {
            // Step 1 - Test Valid Value
            
            $encoder = new Encoder();
            
            $validValues = [
                "A", "AB", "ABC", "AA BB", "AA BB CC"
            ];
            
            foreach ($validValues as $validValue)
            {
                $this->assertSame($encoder,
                    $encoder->setData($validValue));
                
                $this->assertSame($validValue,
                    $encoder->getData());
            }
            
            // Step 2 - Test Invalid Value
            
            $encoder = new Encoder();
            
            $invalidValues = [
                "", " ", "   "
            ];
            
            foreach ($invalidValues as $invalidValue)
            {
                try
                {
                    $encoder->setData($invalidValue);
                    
                    $this->fail("Exception should've been thrown!");
                }
                catch (\Exception $e)
                {
                    $this->assertEquals("Invalid data provided.",
                        $e->getMessage());
                }
            }
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Tests the <i>getEmbeddable</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testEmbeddableMethod() : void
        {
            // Step 1 - Test Without Encoding
            
            $encoder = new Encoder();
            
            $this->assertSame(null, $encoder->getEmbeddable());
            
            // Step 2 - Test With Encoding
            
            $encoder = new class extends Encoder
            {
                public function inject(string $encoding, int $format) : void
                {
                    $this->encoding = $encoding;
                    $this->format   = $format;
                }
            };
            
            $encoder->inject("QRDATA", Encoder::FORMAT_PNG);
            
            $this->assertSame("data:image/png;base64," .
                base64_encode("QRDATA"), $encoder->getEmbeddable());
        }
        
        /**
         * Tests the <i>process</i> method of the base class.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        public function testProcessMethod() : void
        {
            $encoder = new Encoder();
            
            $this->assertFalse($encoder->process());
        }
    }
    
?>
