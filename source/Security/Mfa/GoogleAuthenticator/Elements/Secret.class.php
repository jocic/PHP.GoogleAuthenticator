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
    
    namespace Security\Mfa\GoogleAuthenticator\Elements;
    
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
        
        // CORE CONSTANTS GO HERE
        
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
            
            $this->encoder = new \Security\Encoders\Base\Base32();
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
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param bool $setValue
         *   Value <i>TRUE</i> if you want to immediately set the generated
         *   value, and vice versa. Default value is <i>FALSE</i>.
         * @return string
         *   Value of the secret - randomly-generated.
         */
        
        public function generateValue($setValue = false)
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
            
            // Step 2 - Set & Return Value.
            
            if ($setValue)
            {
                $this->setValue($value);
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
        
        // OTHER METHODS GO HERE
    }
    
?>
