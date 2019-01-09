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
    
    class AccountManager extends AccountManagerCore
        implements AccountManagerInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        // CORE VARIABLES GO HERE
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        // MAGIC FUNCTIONS GO HERE
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns a manager's unique identifier.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   Value of manager's unique identifier.
         */
        
        public function getManagerId()
        {
            // Logic
            
            return $this->managerId;
        }
        
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
            
            return array_values($this->accounts);
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
            // Step 1 - Reset Manager
            
            $this->reset();
            
            // Step 2 - Check Array
            
            if (!is_array($accounts))
            {
                throw new \Exception("Provided accounts are not in an array.");
            }
            
            // Step 3 - Process Accounts
            
            foreach ($accounts as $account)
            {
                if (!($account instanceof Account))
                {
                    throw new \Exception("Invalid object type.");
                }
                
                $this->addAccount($account);
            }
        }
        
        /**
         * Sets an ID that was assigned to the newly added account.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param integer $id
         *   ID that should be set.
         * @return void
         */
        
        public function setLastId($lastId)
        {
            // Logic
            
            if ($this->lastId >= $lastId)
            {
                throw new \Exception("Provided ID was already used.");
            }
            
            $this->lastId = $lastId;
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
            // Step 1 - Check Account Type
            
            if (!($account instanceof Account))
            {
                throw new \Exception("Invalid object type.");
            }
            
            // Step 2 - Check Account State
            
            if ($account->getAccountManager() != null)
            {
                throw new \Exception("Account belongs to a manager, or has an ID assigned.");
            }
            
            // Step 3 - Handle Account ID
            
            if ($account->getAccountId() == null)
            {
                $account->setAccountId($this->getNextId());
            }
            
            $this->setLastId($account->getAccountId());
            
            // Step 4 - Add Account
            
            $this->accounts[] = $account;
            
            $account->setAccountManager($this);
        }
        
        /**
         * Removes an account from the manager.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param mixed $account
         *   Account that should be removed - ID, Name, or an Object.
         * @return bool
         *   Value <i>TRUE</i> if an account was removed, and vice versa.
         */
        
        public function removeAccount($account)
        {
            // Logic
            
            if (is_numeric($account))
            {
                return $this->removeByAccountId($account);
            }
            else if (is_string($account))
            {
                return $this->removeByAccountName($account);
            }
            else if ($account instanceof Account)
            {
                return $this->removeByAccountObject($account);
            }
            
            throw new \Exception("Option couldn't be determined.");
        }
        
        /**
         * Finds an account in the manager.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param mixed $account
         *   Account that should be removed - ID, Name, or an Object.
         * @return object
         *   Account object that was found, or value <i>NULL</i> if it wasn't.
         */
        
        public function findAccount($account)
        {
            // Logic
            
            if (is_numeric($account))
            {
                return $this->findByAccountId($account);
            }
            else if (is_string($account))
            {
                return $this->findByAccountName($account);
            }
            else if ($account instanceof Account)
            {
                return $this->findByAccountObject($account);
            }
            
            throw new \Exception("Option couldn't be determined.");
        }
        
        /**
         * Saves manager's accounts to a file.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $fileLocation
         *   File location that should be used for saving.
         * @return bool
         *   Value <i>TRUE</i> if accounts were saved, and vice versa.
         */
        
        public function save($fileLocation)
        {
            // Core Variables
            
            $accounts = $this->getAccounts();
            $data     = [];
            
            // IO Variables
            
            $fileHandler  = null;
            $bytesWritten = null;
            
            // Logic
            
            foreach ($accounts as $account)
            {
                $data[] = [
                    "version"      => "1",
                    "account_id"   => $account->getAccountId(),
                    "service_name" => $account->getServiceName(),
                    "account_name" => $account->getAccountName(),
                    "secret"       => $account->getAccountSecret()
                ];
            }
            
            $data = serialize($data);
            
            // Step 3 - Save Data
            
            try
            {
                $fileHandler = fopen($fileLocation, "w");
                
                $bytesWritten = fwrite($fileHandler, $data);
                
                fclose($fileHandler);
            }
            catch (\Exception $e) {}
            
            return $bytesWritten > 0;
        }
        
        /**
         * Loads manager's accounts from a file.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $fileLocation
         *   File location that should be used for loading.
         * @param integer $bufferSize
         *   Buffer size in bytes that will be used for loading.
         * @return bool
         *   Value <i>TRUE</i> if accounts were loaded, and vice versa.
         */
        
        public function load($fileLocation, $bufferSize = 1024)
        {
            // Core Variables
            
            $accounts = null;
            $account  = null;
            
            // IO Variables
            
            $fileHandler = null;
            
            // Step 1 - Load Accounts
            
            try
            {
                $fileHandler = fopen($fileLocation, "r");
                
                while (!feof($fileHandler))
                {
                    $accounts .= fread($fileHandler, $bufferSize);
                }
                
                fclose($fileHandler);
                
                $accounts = unserialize($accounts);
            }
            catch (\Exception $e) {}
            
            // Step 2 - Process Accounts
            
            if (is_array($accounts))
            {
                $this->reset();
                
                foreach ($accounts as $account)
                {
                    // Only Add Valid Data
                    
                    if (    isset($account["account_id"])
                         && isset($account["service_name"])
                         && isset($account["account_name"])
                         && isset($account["secret"]))
                    {
                        $loadedAccount = new Account();
                        
                        $loadedAccount->setAccountId($account["account_id"]);
                        $loadedAccount->setServiceName($account["service_name"]);
                        $loadedAccount->setAccountName($account["account_name"]);
                        $loadedAccount->setAccountSecret($account["secret"]);
                        
                        $this->addAccount($loadedAccount);
                    }
                }
                
                return true;
            }
            
            return false;
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
