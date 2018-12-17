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
    
    /**
     * <i>Base32</i> class is used for testing it's implementation.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class Base32 extends TestCase
    {
        /**
         * Tests encoding of the <i>Base 32</i> implementation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testEncoding()
        {
            // Core Variables
            
            $encoder = new Security\Encoders\Base\Base32();
            
            // Logic.
            
            $this->assertSame("", $encoder->encode(""));
            $this->assertSame("MY======", $encoder->encode("f"));
            $this->assertSame("MZXQ====", $encoder->encode("fo"));
            $this->assertSame("MZXW6===", $encoder->encode("foo"));
            $this->assertSame("MZXW6YQ=", $encoder->encode("foob"));
            $this->assertSame("MZXW6YTB", $encoder->encode("fooba"));
            $this->assertSame("MZXW6YTBOI======", $encoder->encode("foobar"));
            $this->assertSame("MZXW6YTBOIYQ====", $encoder->encode("foobar1"));
            $this->assertSame("MZXW6YTBOIYTE===", $encoder->encode("foobar12"));
            $this->assertSame("MZXW6YTBOIYTEMY=", $encoder->encode("foobar123"));
        }
        
        /**
         * Tests decoding of the <i>Base 32</i> implementation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testDecoding()
        {
            // Core Variables
            
            $encoder = new Security\Encoders\Base\Base32();
            
            // Logic.
            
            $this->assertSame("", $encoder->decode(""));
            $this->assertSame("f", $encoder->decode("MY======"));
            $this->assertSame("fo", $encoder->decode("MZXQ===="));
            $this->assertSame("foo", $encoder->decode("MZXW6==="));
            $this->assertSame("foob", $encoder->decode("MZXW6YQ="));
            $this->assertSame("fooba", $encoder->decode("MZXW6YTB"));
            $this->assertSame("foobar", $encoder->decode("MZXW6YTBOI======"));
            $this->assertSame("foobar1", $encoder->decode("MZXW6YTBOIYQ===="));
            $this->assertSame("foobar12", $encoder->decode("MZXW6YTBOIYTE==="));
            $this->assertSame("foobar123", $encoder->decode("MZXW6YTBOIYTEMY="));
        }
    }
    
?>
