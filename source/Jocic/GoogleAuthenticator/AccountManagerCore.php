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
     * <i>AccountManagerCore</i> class contains core methods used for account
     * management ex. find methods, remove methods, etc.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class AccountManagerCore extends FileSystem
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * String containing manager's unique identifier.
         * 
         * @var    string
         * @access protected
         */
        
        protected $managerId = "";
        
        /**
         * Array containing manager's accounts.
         * 
         * @var    array
         * @access protected
         */
        
        protected $accounts = [];
        
        /**
         * Integer containing last used ID.
         * 
         * @var    array
         * @access protected
         */
        
        protected $lastId = 0;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        /**
         * Constructor for the class <i>AccountManager</i>. It's used for
         * determening and setting unique manager's identifer.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function __construct()
        {
            // Logic
            
            $this->managerId = sha1(microtime());
        }
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        // GET METHODS GO HERE
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        // SET METHODS GO HERE
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        // CORE METHODS GO HERE
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        // CHECK METHODS GO HERE
        
        /******************\
        |* REMOVE METHODS *|
        \******************/
        
        /**
         * Removes an account from the manager using account's ID.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $accountId
         *   ID of an account that should be removed.
         * @return bool
         *   Value <i>TRUE</i> if an account was removed, and vice versa.
         */
        
        public function removeByAccountId($accountId)
        {
            // Core Variables
            
            $accounts = $this->getAccounts();
            
            // Step 1 - Check Value
            
            if (!is_numeric($accountId))
            {
                throw new \Exception("Provided ID isn't numeric.");
            }
            
            // Step 2 - Remove Account
            
            foreach ($accounts as $accountKey => $accountObject)
            {
                if ($accountObject->getAccountId() == $accountId)
                {
                    unset($accounts[$accountKey]);
                    
                    $this->accounts = $accounts;
                    
                    return true;
                }
            }
            
            return false;
        }
        
        /**
         * Removes an account from the manager using account's name.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $accountName
         *   Name of an account that should be removed.
         * @return bool
         *   Value <i>TRUE</i> if an account was removed, and vice versa.
         */
        
        public function removeByAccountName($accountName)
        {
            // Core Variables
            
            $accounts = $this->getAccounts();
            
            // Step 1 - Check Value
            
            if (!is_string($accountName))
            {
                throw new \Exception("Provided ID isn't string.");
            }
            
            // Step 2 - Remove Account
            
            foreach ($accounts as $accountKey => $accountObject)
            {
                if ($accountObject->getAccountName() == $accountName)
                {
                    unset($accounts[$accountKey]);
                    
                    $this->accounts = $accounts;
                    
                    return true;
                }
            }
            
            return false;
        }
        
        /**
         * Removes an account from the manager using account's object.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $accountObject
         *   Object of an account that should be removed.
         * @return bool
         *   Value <i>TRUE</i> if an account was removed, and vice versa.
         */
        
        public function removeByAccountObject($accountObject)
        {
            // Core Variables
            
            $identifier = null;
            
            // Step 1 - Check Object
            
            if (!($accountObject instanceof Account))
            {
                throw new \Exception("Provided object isn't valid.");
            }
            
            // Step 2 - Remove Account
            
            if (($identifier = $accountObject->getAccountId()) != null)
            {
                return $this->removeByAccountId($identifier);
            }
            else if (($identifier = $accountObject->getAccountName()) != null)
            {
                return $this->removeByAccountName($identifier);
            }
            
            return false;
        }
        
        /****************\
        |* FIND METHODS *|
        \****************/
        
        /**
         * Finds and returns an account from the manager using account's ID.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $accountId
         *   ID of an account that should be found.
         * @return object
         *   Account object that was found, or value <i>NULL</i> if it wasn't.
         */
        
        public function findByAccountId($accountId)
        {
            // Core Variables
            
            $accounts = $this->getAccounts();
            
            // Step 1 - Check Value
            
            if (!is_numeric($accountId))
            {
                throw new \Exception("Provided ID isn't numeric.");
            }
            
            // Step 2 - Remove Account
            
            foreach ($accounts as $accountObject)
            {
                if ($accountObject->getAccountId() == $accountId)
                {
                    return $accountObject;
                }
            }
            
            return null;
        }
        
        /**
         * Finds and returns an account from the manager using account's name.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $accountName
         *   Name of an account that should be found.
         * @return object
         *   Account object that was found, or value <i>NULL</i> if it wasn't.
         */
        
        public function findByAccountName($accountName)
        {
            // Core Variables
            
            $accounts = $this->getAccounts();
            
            // Step 1 - Check Value
            
            if (!is_string($accountName))
            {
                throw new \Exception("Provided ID isn't string.");
            }
            
            // Step 2 - Find Account
            
            foreach ($accounts as $accountObject)
            {
                if ($accountObject->getAccountName() == $accountName)
                {
                    return $accountObject;
                }
            }
            
            return null;
        }
        
        /**
         * Finds and returns an account from the manager using account's object.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $accountObject
         *   Object of an account that should be found.
         * @return object
         *   Account object that was found, or value <i>NULL</i> if it wasn't.
         */
        
        public function findByAccountObject($accountObject)
        {
            // Core Variables
            
            $identifier = null;
            
            // Step 1 - Check Object
            
            if (!($accountObject instanceof Account))
            {
                throw new \Exception("Provided object isn't valid.");
            }
            
            // Step 2 - Find Account
            
            if (($identifier = $accountObject->getAccountId()) != null)
            {
                return $this->findByAccountId($identifier);
            }
            else if (($identifier = $accountObject->getAccountName()) != null)
            {
                return $this->findByAccountName($identifier);
            }
            
            return null;
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        // OTHER METHODS GO HERE
    }
    
?>
