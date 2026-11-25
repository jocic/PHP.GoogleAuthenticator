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
    
    namespace Jocic\GoogleAuthenticator;
    
    use Jocic\Encoders\Base\Base32;
    
    /**
     * <i>Secret</i> class is used for generating secrets required for
     * one-time password generation and validation of the same.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class Secret implements Interfaces\SecretInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        /**
         * Method constant for generating secrets using the <i>base</i>
         * creation method - picking random <i>BASE32</i> values until an
         * 80-bit long secret is generated.
         * 
         * @var    int
         * @access public
         */
        const METHOD_BASE = 0;
        
        /**
         * Method constant for generating secrets using the <i>numerical</i>
         * creation method - picking random numbers between 0 and 256 until an
         * 80-bit long secret is generated.
         * 
         * @var    int
         * @access public
         */
        const METHOD_NUMERICAL = 1;
        
        /**
         * Method constant for generating secrets using the <i>binary</i>
         * creation method - picking random bits until an 80-bit long secret
         * is generated.
         * 
         * @var    int
         * @access public
         */
        const METHOD_BINARY = 2;
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Set or generated value of the secret.
         * 
         * @var    string|NULL
         * @access private
         */
        private string|NULL $value = null;
        
        /*******************\
        |* OTHER VARIABLES *|
        \*******************/
        
        /**
         * Object containing <i>Base 32</i> encoder.
         * 
         * @var    object|null
         * @access private
         */
        private Base32|NULL $encoder = null;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        /**
         * Generic PHP constructor for the class <i>Secret</i>.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string|null $value
         *   Secret that should be set - otherwise the secret will be
         *   generated automatically upon object instantiation.
         */
        public function __construct(string|null $value = null)
        {
            // Logic
            
            $this->encoder = new Base32();
            
            if ($value == null)
            {
                $value = $this->generateValue();
            }
            
            $this->setValue($value);
        }
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns the secret's value.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Currently set value of the secret.
         */
        public function getValue() : string
        {
            // Logic
            
            return $this->value;
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Sets the secret's value.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $value
         *   New value of the secret.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setValue(string $value) : self
        {
            // Logic
            
            if (!$this->isSecretValid($value))
            {
                throw new \Exception("Invalid secret provided: \"$value\"");
            }
            
            $this->value = $value;
            
            return $this;
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Generates a random secret that may be used for implementing MFA.
         * 
         * <strong>Note:</string> Secrets are random 80-bit values
         * encoded using the <i>BASE32</i> encoding.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $method
         *   Method used for generating the secret. Default value
         *   corresponds to the <i>M_BASE</i> constant.
         * @return string
         *   Value of the secret - randomly-generated.
         */
        public function generateValue(int $method = self::METHOD_BASE) : string
        {
            // Logic
            
            switch ($method)
            {
                case self::METHOD_BASE:
                    return $this->__generateValue_BASE();
                case self::METHOD_NUMERICAL:
                    return $this->__generateValue_NUMERICAL();
                case self::METHOD_BINARY:
                    return $this->__generateValue_BINARY();
                default:
                    throw new \Exception("Invalid method selected.");
            }
            
            return "";
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Checks if the provided secret is valid or not.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $secret
         *   Secret that needs to be checked.
         * @return bool
         *   Value <i>TRUE</i> if secret is valid, and vice versa.
         */
        public function isSecretValid(string $secret) : bool
        {
            // Core Variables
            
            $baseTable = $this->encoder->getBaseTable();
            
            // Other Variables
            
            $characters = str_split($secret);
            
            // Step 1 - Check Length
            
            if (count($characters) < 8)
            {
                return false;
            }
            
            // Step 2 - Check Characters
            
            foreach ($characters as $character)
            {
                if (!in_array($character, $baseTable))
                {
                    return false;
                }
            }
            
            return true;
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        /**
         * Generates a random secret using the <i>base</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Value of the secret - randomly-generated.
         */
        private function __generateValue_BASE() : string
        {
            // Core Variables
            
            $baseTable = $this->encoder->getBaseTable();
            
            // Other Variables
            
            $value    = "";
            $maxIndex = count($baseTable) - 1;
            $index    = 0;
            
            // Logic
            
            for ($i = 0; $i < 16; $i ++)
            {
                $index  = random_int(0, $maxIndex);
                $value .= $baseTable[$index];
            }
            
            return $value;
        }
        
        /**
         * Generates a random secret using the <i>numerical</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Value of the secret - randomly-generated.
         */
        private function __generateValue_NUMERICAL() : string
        {
            // Core Variables
            
            $value  = "";
            $number = 0;
            
            // Logic
            
            for ($i = 0; $i < 10; $i ++)
            {
                $number = random_int(0, 255);
                $value .= sprintf("%c", $number);
            }
            
            return $this->encoder->encode($value);
        }
        
        /**
         * Generates a random secret using the <i>binary</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Value of the secret - randomly-generated.
         */
        private function __generateValue_BINARY() : string
        {
            // Core Variables
            
            $value = "";
            $byte  = 0;
            
            // Logic
            
            for ($i = 0; $i < 10; $i ++)
            {
                $byte = 0;
                
                for ($j = 0; $j < 8; $j ++)
                {
                    $byte = ($byte << 1) | random_int(0, 1);
                }
                
                $value .= sprintf("%c", $byte);
            }
            
            return $this->encoder->encode($value);
        }
    }
    
?>
