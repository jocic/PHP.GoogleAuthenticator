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
    
    /**
     * <i>Account</i> class is used for specifying various account-related
     * information required for <i>2FA</i> implementation.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class Account implements Interfaces\AccountInterface
    {
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Name of the 2FA service used by the account, ex. <i>Hosting ABC</i>.
         * 
         * <strong>Note:</strong> This line will be shown in the 2FA apps.
         * 
         * @var    string|null
         * @access private
         */
        private string|null $service = null;
        
        /**
         * Name of the account, ex. <i>John Doe</i> or <i>john@doe.com</i>.
         * 
         * <strong>Note:</strong> This line will be shown in the 2FA apps.
         * 
         * @var    string|null
         * @access private
         */
        private string|null $name = null;
        
        /**
         * Secret of the account, ex. <i>RMB4AMUMDHODBYNR</i>.
         * 
         * @var    object|null
         * @access private
         */
        private Secret|null $secret = null;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        /**
         * Generic PHP constructor for the class <i>Account</i>.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string|null $service
         *   Account's service name that should be set.
         * @param string|null $name
         *   Account's name that should be set.
         * @param object|null $secret
         *   Account's secret that should be set.
         * @return void
         */
        public function __construct(
            string|null $service = null,
            string|null $name = null,
            string|null $secret = null)
        {
            // Logic
            
            if ($service !== NULL)
            {
                $this->setService($service);
            }
            
            if ($name !== NULL)
            {
                $this->setName($name);
            }
            
            if ($secret !== NULL)
            {
                $this->setSecret($secret);
            }
        }
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns the 2FA service name used by the account.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string|null
         *   Name of the 2FA service, ex. <i>Hosting ABC</i>, or the value
         *   <i>NULL</i> if the account's service name wasn't previously set.
         */
        public function getService() : string|null
        {
            // Logic
            
            return $this->service;
        }
        
        /**
         * Returns the account's name.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string|null
         *   Name of the account, ex. <i>john@doe.com</i>, or the value
         *   <i>NULL</i> if the account's name wasn't previously set.
         */
        public function getName() : string|null
        {
            // Logic
            
            return $this->name;
        }
        
        /**
         * Returns the account's secret.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @return object|null
         *   Secret of the account, ex. <i>RMB4AMUMDHODBYNR</i>, or the value
         *   <i>NULL</i> if the account's secret wasn't previously set.
         */
        public function getSecret() : Secret|null
        {
            // Logic
            
            return $this->secret;
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Sets the 2FA service name of the acocunt.
         * 
         * <strong>Note:</strong> Service name parameter is required.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $serviceName
         *   New account's service name, ex. <i>Hosting ABC</i>.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setService($service) : self
        {
            // Logic
            
            $this->service = $service;
            
            return $this;
        }
        
        /**
         * Sets the account's name.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $accountName
         *   New account's name, ex. <i>John Doe</i> or <i>john@doe.com</i>.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setName(string $name) : self
        {
            // Logic
            
            $this->name = $name;
            
            return $this;
        }
        
        /**
         * Sets the account's secret.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param mixed $accountSecret
         *   New account's secret, ex. <i>RMB4AMUMDHODBYNR</i>.
         * @return object
         *   Reference to the object calling the method - current object.
         */
        public function setSecret(Secret|string $secret) : self
        {
            // Logic
            
            if (is_string($secret))
            {
                $secret = new Secret($secret);
            }
            
            $this->secret = $secret;
            
            return $this;
        }
    }
    
?>
