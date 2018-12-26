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
     * <i>Account</i> class is used for specifying various account-related
     * information required for <i>2FA</i> implementation.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class Account implements AccountInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Name of the service used by an account, ex. <i>Hosting ABC</i>.
         * 
         * @var    string
         * @access private
         */
        
        private $serviceName = "";
        
        /**
         * Name of an account, ex. <i>John Doe</i> or <i>john@doe.com</i>.
         * 
         * @var    string
         * @access private
         */
        
        private $accountName = "";
        
        /**
         * Secret of an account.
         * 
         * @var    string
         * @access private
         */
        
        private $accountSecret = null;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        /**
         * Constructor for the class <i>Account</i>. It's used for setting
         * core class parameters upon object instantiation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $serviceName
         *   Account's service name that should be set.
         * @param string $accountName
         *   Account's name that should be set.
         * @param object $secret
         *   Account's secret that should be set.
         * @return void
         */
        
        public function __construct($serviceName = "", $accountName = "",
            $accountSecret = null)
        {
            // Logic
            
            $this->setServiceName($serviceName);
            $this->setAccountName($accountName);
            $this->setAccountSecret($accountSecret);
        }
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns an account's service name.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Name of an account's service, ex. <i>Hosting ABC</i>.
         */
        
        public function getServiceName()
        {
            // Logic
            
            return $this->serviceName;
        }
        
        /**
         * Returns an account's name.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Name of an account, ex. <i>John Doe</i> or <i>john@doe.com</i>.
         */
        
        public function getAccountName()
        {
            // Logic
            
            return $this->accountName;
        }
        
        /**
         * Returns an account's secret.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return object
         *   Secret of an account.
         */
        
        public function getAccountSecret()
        {
            // Logic
            
            return $this->accountSecret;
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Sets an account's service name.
         * 
         * Note: Service name parameter is required, it must be set.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $serviceName
         *   New account's service name.
         * @return void
         */
        
        public function setServiceName($serviceName)
        {
            // Logic
            
            $this->serviceName = $serviceName;
        }
        
        /**
         * Sets an account's name.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $accountName
         *   New account's name.
         * @return void
         */
        
        public function setAccountName($accountName)
        {
            // Logic
            
            $this->accountName = $accountName;
        }
        
        /**
         * Sets an account's secret.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $accountSecret
         *   New account's secret.
         * @return void
         */
        
        public function setAccountSecret($accountSecret)
        {
            // Logic
            
            $this->accountSecret = $accountSecret;
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        // CORE METHODS GO HERE
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        // CHECK METHODS GO HERE
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        // OTHER METHODS GO HERE
    }
    
?>
