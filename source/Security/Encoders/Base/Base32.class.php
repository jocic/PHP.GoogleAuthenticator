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
    
    namespace Security\Encoders\Base;
    
    /**
     * <i>Base32</i> class is used for encoding data in Base32 format.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class Base32 implements BaseInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Array containing characters of the encoding table for <i>Base 32</i>
         * encoding per RFC4648 specifications.
         * 
         * Note: Review page 8 of the mentioned document for more information.
         * 
         * @var    array
         * @access private
         */
        
        private $baseTable = [
            "A", "B", "C", "D", "E", "F", "G", "H", "I",
            "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "2",
            "3", "4", "5", "6", "7"
        ];
        
        /**
         * String containing a single character used for padding-purposes per
         * RFC4648 specifications.
         * 
         * Note: Review page 8 of the mentioned document for more information.
         * 
         * @var    string
         * @access private
         */
        
        private $basePadding = "=";
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        // MAGIC FUNCTIONS GO HERE
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns an array containing characters of the encoding table for
         * <i>Base 32</i> encoding per RFC4648 specifications.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return array
         *   Array containing characters of the encoding table.
         */
        
        public function getBaseTable()
        {
            // Logic
            
            return $this->baseTable;
        }
        
        /**
         * Returns a string containing a single character used for
         * padding-purposes per RFC4648 specifications.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   String containing a single character used for padding-purposes.
         */
        
        public function getBasePadding()
        {
            // Logic
            
            return $this->basePadding;
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        // SET METHODS GO HERE
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Encodes a provided string to <i>Base32</i> encoding.
         *  
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $input
         *   Input string that needs to be encoded.
         * @return string
         *   Encoded input per used specifications.
         */
        
        public function encode($input)
        {
            // Core Variables
            
            $encoding = "";
            
            // Logic
            
            if (!$this->isEncodingValid($encoding))
            {
                throw new \Exception("Invalid encoding produced.");
            }
            
            return $encoding;
        }
        
        /**
         * Decodes a provided string from <i>Base 32</i> encoding.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $input
         *   Input string that needs to be decoded.
         * @return string
         *   Decoded input per used specifications.
         */
        
        public function decode($input)
        {
            
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Checks if the <i>Base 32</i> encoding is valid or not.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $encoding
         *   <i>Base 32</i> encoding that needs to be checked.
         * @return bool
         *   Value <i>True</i> if encoding is valid, and vice versa.
         */
        
        public function isEncodingValid($encoding)
        {
            // Core Variables
            
            $baseTable   = $this->getBaseTable();
            $basePadding = $this->getPadding();
            
            // Other Variables
            
            $characters = [];
            
            // Step 1 - Trim Padding & Generate Array
            
            $characters = str_split(rtrim($encoding, $basePadding));
            
            // Step 2 - Check Characters
            
            foreach ($characters as $character)
            {
                if (!in_array($baseTable, $character))
                {
                    break;
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
