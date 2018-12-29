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
     * <i>AccountManager</i> class is used for storage and management of
     * created <i>Account</i> classes.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class AccountManager implements AccountManagerInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Array containing manager's accounts.
         * 
         * @var    array
         * @access private
         */
        
        private $accounts = [];
        
        /**
         * Integer containing last used ID.
         * 
         * @var    array
         * @access private
         */
        
        private $lastId = 0;
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        // MAGIC FUNCTIONS GO HERE
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns an array containing added accounts.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return array
         *   Array containing all added accounts.
         */
        
        public function getAccounts()
        {
            // Logic
            
            return $this->accounts;
        }
        
        /**
         * Returns the last available account ID.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return integer
         *   Last available account ID.
         */
        
        public function getLastId()
        {
            // Logic
            
            return $this->lastId;
        }
        
        /**
         * Returns the next available account ID.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return integer
         *   Next available account ID.
         */
        
        public function getNextId()
        {
            // Logic
            
            return $this->lastId + 1;
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        /**
         * Replaces manager's accounts with new ones.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param array $accounts
         *   Array containing new accounts that should be assigned.
         * @return void
         */
        
        public function setAccounts($accounts)
        {
            // Step 1 - Check Array
            
            if (!is_array($accounts))
            {
                throw new \Exception("Provided accounts are not in an array.");
            }
            
            // Step 2 - Check Elements
            
            foreach ($accounts as $account)
            {
                if (!($account instanceof Account))
                {
                    throw new \Exception("Invalid object type.");
                }
            }
            
            // Step 3 - Set Accounts
            
            $this->accounts = $accounts;
        }
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Adds an account to the manager.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $account
         *   Account that should be added.
         */
        
        public function addAccount($account)
        {
            // Core Variables
            
            $nextId = $this->getNextId();
            
            // Step 1 - Check Account Type
            
            if (!($account instanceof Account))
            {
                throw new \Exception("Invalid object type.");
            }
            
            // Step 2 - Check Account State
            
            if ($account->getId() != null)
            {
                throw new \Exception("Account belongs to a manager.");
            }
            
            // Step 3 - Add Account
            
            $this->accounts[$nextId] = $account;
            
            $account->setId($nextId);
            $account->setAccountManager($this);
        }
        
        /**
         * Removes an account from the manager.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param object $account
         *   Account that should be removed.
         * @return bool
         *   Value <i>TRUE</i> if an account was removed, and vice versa.
         */
        
        public function removeAccount($account)
        {
            
        }
        
        public function findAccount($account)
        {
            
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        // CHECK METHODS GO HERE
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        /**
         * Resets account manager, essentially removing all added accounts.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function reset()
        {
            // Logic
            
            $this->accounts = [];
            $this->lastId   = 0;
        }
    }
    
?>
