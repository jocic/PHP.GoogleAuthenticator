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
    
    namespace Jocic\GoogleAuthenticator;
    
    /**
     * <i>Secret</i> class is used for generating secrets required for one-time
     * password generation and validation of the same.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class Secret implements SecretInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        /**
         * Method constant - for generating secrets using <i>base</i> method.
         * 
         * @var    integer
         * @access public
         */
        
        public const M_BASE = 0;
        
        /**
         * Method constant - for generating secrets using <i>numerical</i> method.
         * 
         * @var    integer
         * @access public
         */
        
        public const M_NUMERICAL = 1;
        
        /**
         * Method constant - for generating secrets using <i>binary</i> method.
         * 
         * @var    integer
         * @access public
         */
        
        public const M_BINARY = 2;
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Set or generated value of the secret.
         * 
         * @var    string
         * @access private
         */
        
        private $value = "";
        
        /*******************\
        |* OTHER VARIABLES *|
        \*******************/
        
        /**
         * Object containing <i>Base 32</i> encoder.
         * 
         * @var    object
         * @access private
         */
        
        private $encoder = null;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        /**
         * Generic PHP constructor used for instantiating <i>Base 32</i> object.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         */
        
        public function __construct()
        {
            // Logic
            
            $this->encoder = new \Jocic\GoogleAuthenticator\Encoders\Base\Base32();
        }
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns a value of the secret.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Currently set value of the secret.
         */
        
        public function getValue()
        {
            // Logic
            
            return $this->value;
        }
        
        /**
         * Returns an instantiated <i>Base 32</i> encoder object, or throws an
         * exception if it's value is <i>NULL</i>.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return object
         *   Instantiated <i>Base 32</i> encoder object.
         */
        
        private function getEncoder()
        {
            // Logic
            
            if (is_null($this->encoder))
            {
                throw new \Exception("Encoder wasn't instantiated.");
            }
            
            return $this->encoder;
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Sets a value of the secret.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $secret
         *   New value of the secret.
         * @return void
         */
        
        public function setValue($secret)
        {
            // Logic
            
            if ($this->isSecretValid($secret))
            {
                $this->value = $secret;
            }
            else
            {
                throw new \Exception("Invalid secret provided. Secret: \"$secret\"");
            }
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Generates a random secret that may be used for implementing MFA.
         * 
         * Note: Secrets are actually random 80-bit values encoded using
         * <i>Base 32</i> encoder.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $method
         *   Method used for generating the secret. Default value is <i>0</i>.
         * @return string
         *   Value of the secret - randomly-generated.
         */
        
        public function generateValue($method = 0)
        {
            // Core Variables
            
            $value = "";
            
            // Logic
            
            switch ($method)
            {
                case 0:
                    $value = $this->runBaseMethod();
                    break;
                
                case 1:
                    $value = $this->runNumericalMethod();
                    break;
                
                case 2:
                    $value = $this->runBinaryMethod();
                    break;
                
                default:
                    throw new \Exception("Invalid method selected.");
            }
            
            return $value;
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Checks if a provided secret is valid or not.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $secret
         *   Secret that needs to be checked.
         * @return bool
         *   Value <i>TRUE</i> if secret is valid, and vice versa.
         */
        
        public function isSecretValid($secret)
        {
            // Core Variables
            
            $baseTable = $this->getEncoder()->getBaseTable();
            
            // Other Variables
            
            $characters = str_split($secret);
            
            // Step 1 - Check Length
            
            if (count($characters) != 16)
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
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Value of the secret - randomly-generated.
         */
        
        private function runBaseMethod()
        {
            // Core Variables
            
            $baseTable = $this->getEncoder()->getBaseTable();
            
            // Other Variables
            
            $value    = "";
            $maxIndex = count($baseTable) - 1;
            $index    = 0;
            
            // Step 1 - Generate Value
            
            for ($i = 0; $i < 16; $i ++)
            {
                $index = rand(0, $maxIndex);
                
                $value .= $baseTable[$index];
            }
            
            return $value;
        }
        
        /**
         * Generates a random secret using the <i>numerical</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Value of the secret - randomly-generated.
         */
        
        private function runNumericalMethod()
        {
            // Core Variables
            
            $value  = "";
            $number = 0;
            
            // Logic
            
            for ($i = 0; $i < 10; $i ++)
            {
                $number = rand(0, 256);
                
                $value .= chr($number);
            }
            
            return $this->getEncoder()->encode($value);
        }
        
        /**
         * Generates a random secret using the <i>binary</i> method.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Value of the secret - randomly-generated.
         */
        
        private function runBinaryMethod()
        {
            // Core Variables
            
            $value = "";
            $byte  = 0x0;
            
            // Other Variables
            
            $index = 0;
            
            // Logic
            
            for ($i = 0; $i < 10; $i ++)
            {
                for ($j = 0; $j < 8; $j ++)
                {
                    $byte = ($byte << 1) | rand(0, 1);
                }
                
                $value .= chr($byte);
            }
            
            return $this->getEncoder()->encode($value);
        }
    }
    
?>
