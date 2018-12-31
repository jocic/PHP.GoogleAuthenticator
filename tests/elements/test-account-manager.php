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
    use Jocic\GoogleAuthenticator\Secret;
    use Jocic\GoogleAuthenticator\Account;
    use Jocic\GoogleAuthenticator\AccountManager;
    
    /**
     * <i>TestAccountManager</i> class is used for testing method implementation
     * of the class <i>AccountManager</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class TestAccountManager extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>setAccounts</i> & <i>getAccounts</i> methods.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testAccountsMethods()
        {
            // Core Variables
            
            $accountManager = new AccountManager();
            
            // Other Variables
            
            $setAccounts  = null;
            $testAccounts = [
                new Account("A", "B", new Secret()),
                new Account("C", "D", new Secret()),
                new Account("E", "F", new Secret())
            ];
            
            // Step 1 - Test Valid Setting
            
            $accountManager->setAccounts($testAccounts);
            
            $setAccounts = $accountManager->getAccounts();
            
            $this->assertSame(3, count($setAccounts),
                "Not all accounts were set.");
            
            for ($i = 0; $i < count($testAccounts); $i ++)
            {
                $this->assertSame($setAccounts[$i]->getAccountSecret(),
                    $testAccounts[$i]->getAccountSecret(), "Invalid secret found.");
            }
            
            // Step 2 - Test Invalid Setting
            
            try
            {
                $accountManager->setAccounts([
                    new Secret()
                ]);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid object type.", $e->getMessage());
            }
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        // CHECK METHODS GO HERE
        
        /*******************\
        |* PRIMARY METHODS *|
        \*******************/
        
        /**
         * Tests <i>addAccount</i> method of the <i>AccountManager</i> class.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testAddAccountMethod()
        {
            // Core Variables
            
            $accountManager = null;
            $account        = null;
            
            // Other Variables
            
            $testAccounts = [
                new Account("A", "B", new Secret()),
                new Account("C", "D", new Secret()),
                new Account("E", "F", new Secret())
            ];
            
            // Step 1 - Test Adding Accounts
            
            $accountManager = new AccountManager();
            
            foreach ($testAccounts as $testAccount)
            {
                // Add Account
                
                $accountManager->addAccount($testAccount);
                
                // Check If Added
                
                $account = $accountManager->findAccount($testAccount);
                
                $this->assertSame($account->getAccountSecret(),
                    $testAccount->getAccountSecret(), "Invalid secret found.");
            }
            
            $this->assertSame(3, $accountManager->getLastId(),
                "Invalid last ID after generated account ID.");
            
            $this->assertSame(4, $accountManager->getNextId(),
                "Invalid next ID after generated account ID.");
            
            // Step 2 - Test Adding Account With & Without ID
            
            $account = new Account("X", "X", new Secret());
            
            $account->setAccountId(1337);
            
            $accountManager->addAccount($account);
            
            $this->assertSame(1337, $accountManager->getLastId(),
                "Invalid last ID after pre-set account ID.");
            
            $this->assertSame(1338, $accountManager->getNextId(),
                "Invalid next ID after pre-set account ID");
            
            // Step 3 - Test Adding Invalid Object
            
            $accountManager = new AccountManager();
            
            try
            {
                $accountManager->addAccount(new Secret());
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid object type.", $e->getMessage());
            }
            
            // Step 4 - Test Adding Assigned Account
            
            $accountManager = new AccountManager();
            
            try
            {
                $accountManager->addAccount($testAccounts[0]);
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Account belongs to a manager, or has an" .
                    " ID assigned.", $e->getMessage());
            }
        }
        
        /**
         * Tests <i>removeAccount</i> method of the <i>AccountManager</i> class.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testRemoveAccountMethod()
        {
            // Core Variables
            
            $accountManager = new AccountManager();
            
            // Other Variables
            
            $testAccounts = [
                new Account("A", "B", new Secret()),
                new Account("C", "D", new Secret()),
                new Account("E", "F", new Secret()),
                new Account("G", "H", new Secret()),
                new Account("I", "J", new Secret())
            ];
            
            // Step 1 - Set Accounts
            
            $accountManager->setAccounts($testAccounts);
            
            // Step 2 - Test Removal By ID
            
            $this->assertTrue($accountManager->removeAccount(1),
                "Removal by \"ID\" failed.");
            
            // Step 3 - Test Removal By Name
            
            $this->assertTrue($accountManager->removeAccount("D"),
                "Removal by \"Name\" failed.");
            
            // Step 4 - Test Removal By Object
            
            $this->assertTrue($accountManager->removeAccount($testAccounts[2]),
                "Removal by \"Object\" failed.");
            
            // Step 5 - Test Invalid Removal Method
            
            try
            {
                $accountManager->removeAccount(new Secret());
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Option couldn't be determined.",
                    $e->getMessage());
            }
        }
        
        /*********************\
        |* SECONDARY METHODS *|
        \*********************/
        
        // SECONDARY METHODS GO HERE
    }
    
?>
