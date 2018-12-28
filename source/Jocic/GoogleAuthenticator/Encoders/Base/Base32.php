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
    
    namespace Jocic\GoogleAuthenticator\Encoders\Base;
    
    /**
     * <i>Base32</i> class is used for encoding data in <i>Base 32</i> format.
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
         * encoding per <i>RFC 4648</i> specifications.
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
         * <i>RFC 4648</i> specifications.
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
         * <i>Base 32</i> encoding per <i>RFC 4648</i> specifications.
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
         * padding-purposes per <i>RFC 4648</i> specifications.
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
         * Encodes a provided string to <i>Base 32</i> encoding.
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
            
            $baseTable = $this->getBaseTable();
            $output    = "";
            $chunks    = [];
            
            // Step 1 - Handle Empty Input
            
            if ($input == "")
            {
                return "";
            }
            
            // Step 2 - Split Input Into 5-bit Chunks
            
            $chunks = $this->convertInputToChunks($input);
            
            // Step 3 - Process Chunks
            
            foreach ($chunks as $chunk)
            {
                $output .= $baseTable[$chunk];
            }
            
            // Step 4 - Apply Padding & Return Encoding
            
            return $this->applyPadding($output);
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
            // Core Variables
            
            $chunks = [];
            
            // Step 1 - Handle Empty Input
            
            if ($input == "")
            {
                return "";
            }
            
            // Step 2 - Trim Padding
            
            $input = $this->stripPadding($input);
            
            // Step 3 - Decode Input Into 5-bit Chunks
            
            $chunks = $this->convertEncodingToChunks($input);
            
            // Step 4 - Merge Dervided Chunks
            
            $input = $this->mergeEncodingChunks($chunks);
            
            // Step 5 - Return Decoding
            
            return $input;
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Checks if the <i>Base 32</i> encoding is valid or not.
         * 
         * Note: Invalid encodings should be rejected per section <i>3.3</i>
         * in the <i>RFC 4648</i> specifications.
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
            $basePadding = $this->getBasePadding();
            
            // Other Variables
            
            $characters = [];
            
            // Step 1 - Check If Empty
            
            if ($encoding == "")
            {
                return true;
            }
            
            // Step 2 - Check General Form
            
            if (!preg_match("/^([A-z0-9]+)([=]+)?$/", $encoding))
            {
                return false;
            }
            
            // Step 3 - Trim Padding & Generate Array
            
            $characters = str_split(rtrim($encoding, $basePadding));
            
            // Step 4 - Check Characters
            
            foreach ($characters as $character)
            {
                if (!in_array($character, $baseTable))
                {
                    return false;
                }
            }
            
            return true;
        }
        
        /********************\
        |* ENCODING METHODS *|
        \********************/
        
        /**
         * Adds padding to the provided encoding.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $encoding
         *   Encoding that needs to be padded.
         * @return string
         *   Encoding that was padded appropriately.
         */
        
        public function applyPadding($encoding)
        {
            // Core Variables
            
            $basePadding  = $this->getBasePadding();
            $paddingCount = 0;
            
            // Step 1 - Check Encoding
            
            if (!$this->isEncodingValid($encoding))
            {
                throw new \Exception("Invalid encoding provided, padding can't be applied. Encoding: \"$encoding\"");
            }
            
            // Step 2 - Apply Padding
            
            $paddingCount = 8 - (strlen($encoding) % 8);
            
            if ($paddingCount != 8)
            {
                $encoding .= str_repeat($basePadding, $paddingCount);
            }
            
            // Step 3 - Return Encoding
            
            return $encoding;
        }
        
        /**
         * Converts provided string into chunks - 5-bit values.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $input
         *   Input that needs to be converted to chunks.
         * @return array
         *   Array containing chunks (5-bit values).
         */
        
        public function convertInputToChunks($input)
        {
            // Core Variables
            
            $characters = null;
            
            // Algorithm Variables
            
            $eIndex    = 0x00;
            $eShifts   = [ 0x03, 0x06, 0x04, 0x07, 0x05 ];
            $ePaddings = [ 0x02, 0x04, 0x01, 0x03, 0x01 ];
            $rShifts   = [ 0x08, 0x02, 0x04, 0x01, 0x03 ];
            $rMasks    = [ 0x07, 0x01, 0x0F, 0x03, 0x03 ];
            $cShifts   = [ 0x00, 0x01, 0x00, 0x02, 0x00 ];
            $cIndexes  = [ 0x01, 0x03, 0x04 ];
            
            // Chunk Variables
            
            $chunks     = [];
            $chunkIndex = 0x00;
            $byte       = null;
            $remainder  = null;
            $padding    = 0x00;
            
            // Other Variables
            
            $temp = null;
            
            // Step 1 - Process Input
            
            $characters = str_split($input);
            
            foreach ($characters as $character)
            {
                // Handle Chunk Value
                
                $byte = ord($character) & 0xFF;
                
                // Process Chunk Value
                
                $chunks[$chunkIndex ++] = (($byte >> $eShifts[$eIndex]) | ($remainder << $rShifts[$eIndex])) & 0x01F;
                
                if (in_array($eIndex, $cIndexes))
                {
                    $chunks[$chunkIndex ++] = ($byte >> $cShifts[$eIndex]) & 0x01F;
                }
                
                $remainder = $byte & $rMasks[$eIndex];
                $padding   = $ePaddings[$eIndex];
                
                // Handle Encoding Index
                
                if (($eIndex ++) == 0x04)
                {
                    $eIndex = 0x00;
                }
            }
            
            // Step 2 - Handle Remainder
            
            if (strlen($input) % 0x05 != 0x00)
            {
                if (($temp = ($remainder << $padding)) != 0x20)
                {
                    $chunks[$chunkIndex ++] = $temp & 0x1F;
                }
            }
            
            return $chunks;
        }
        
        /********************\
        |* DECODING METHODS *|
        \********************/
        
        /**
         * Removes padding from the provided encoding.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $encoding
         *   Encoding that needs to be stripped from it's padding.
         * @return string
         *   Encoding that was stripped from it's padding appropriately.
         */
        
        public function stripPadding($encoding)
        {
            // Core Variables
            
            $basePadding  = $this->getBasePadding();
            
            // Step 1 - Check Encoding
            
            if (!$this->isEncodingValid($encoding))
            {
                throw new \Exception("Invalid encoding provided, padding can't be stripped. Encoding: \"$encoding\"");
            }
            
            // Step 2 - Strip & Return Encoding
            
            return rtrim($encoding, $basePadding);
        }
        
        /**
         * Converts provided encoding into chunks (5-bit values) based on the
         * <i>Base 32</i> table.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $encoding
         *   Encoding that needs to be converted to chunks.
         * @return array
         *   Array containing chunks (5-bit values).
         */
        
        public function convertEncodingToChunks($encoding)
        {
            // Core Variables
            
            $baseTable = $this->getBaseTable();
            $chunks    = [];
            
            // Other Variables
            
            $flippedTable = array_flip($baseTable);
            $characters   = str_split($encoding);
            
            // Step 1 - Check Encoding
            
            if (!$this->isEncodingValid($encoding))
            {
                throw new \Exception("Invalid encoding provided, it can't be converted. Encoding: \"$encoding\"");
            }
            
            // Step 2 - Convert Encoding
            
            foreach ($characters as $character)
            {
                if (isset($flippedTable[$character]))
                {
                    $chunks[] = $flippedTable[$character];
                }
            }
            
            return $chunks;
        }
        
        /**
         * Merges encoding chunks into a single string.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param array $chunks
         *   Encoding chunks that should be merged.
         * @return string
         *   Merged encoding chunks - actual decoding.
         */
        
        public function mergeEncodingChunks($chunks)
        {
            // Core Variables
            
            $decoding  = "";
            $byte      = null;
            $remainder = 0x00;
            
            // Algorithm Variables
            
            $rMasks   = [ 0xFF, 0x03, 0xFF, 0x0F, 0x01, 0xFF, 0x07, 0x00 ];
            $rShifts  = [ 0x00, 0x00, 0x05, 0x00, 0x00, 0x05, 0x00, 0x00 ];
            $rClears  = [ 0x01, 0x01, 0x00, 0x01, 0x01, 0x00, 0x01, 0x01 ];
            $cIndexes = [ 0x00, 0x01, 0x00, 0x01, 0x01, 0x00, 0x01, 0x01 ];
            $dShifts  = [ 0x00, 0x03, 0x00, 0x01, 0x04, 0x00, 0x02, 0x05 ];
            $bShifts  = [ 0x00, 0x02, 0x00, 0x04, 0x01, 0x00, 0x03, 0x00 ];
            $dIndex   = 0x00;
            
            // Logic
            
            foreach ($chunks as $chunk)
            {
                // Handle Chunk Value
                
                $byte = $chunk & 0x1F;
                
                // Handle Character Decoding
                
                if ($cIndexes[$dIndex] == 0x01)
                {
                    $decoding .= sprintf("%c", (($remainder << $dShifts[$dIndex])
                        | ($byte >> $bShifts[$dIndex])) & 0xFF);
                }
                
                // Handle Remainder
                
                if ($rClears[$dIndex] == 0x01)
                {
                    $remainder = 0x00;
                }
                
                $remainder = (($remainder << $rShifts[$dIndex]) | $byte)
                    & $rMasks[$dIndex];
                
                // Handle Decoding Index
                
                if (($dIndex ++) == 0x07)
                {
                    $dIndex = 0x00;
                }
            }
            
            return $decoding;
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        // OTHER METHODS GO HERE
    }
    
?>
