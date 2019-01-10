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
     * <i>FileSystem</i> class contains core IO methods.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2018 All Rights Reserved
     * @version   1.0.0
     */
    
    class FileSystem
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
        
        // GET METHODS GO HERE
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        // SET METHODS GO HERE
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Loads contents from a desired file.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $fileLocation
         *   File location that should be used for loading.
         * @param integer $bufferSize
         *   Buffer size in bytes that will be used for loading.
         * @param bool $suppressException
         *   Value <i>TRUE</i> if you want to suppress exception, and vice versa.
         * @return string
         *   Contents of a desired file.
         */
        
        public function loadFromFile($fileLocation, $bufferSize = 1024,
            $suppressException = false)
        {
            // Core Variables
            
            $fileHandler = null;
            $contents    = "";
            
            // Logic
            
            try
            {
                $fileHandler = fopen($fileLocation, "r");
                
                while (!feof($fileHandler))
                {
                    $contents .= fread($fileHandler, $bufferSize);
                }
            }
            catch (\Exception $e)
            {
                if (!$suppressException)
                {
                    throw new \Exception("An unkown IO error occured.");
                }
            }
            finally
            {
                if ($fileHandler != null)
                {
                    fclose($fileHandler);
                }
            }
            
            return $contents;
        }
        
        /**
         * Saves contents to a desired file location.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2018 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $fileLocation
         *   File location that should be used for saving.
         * @param mixed $contents
         *   Contents that should be saved to a desired file.
         * @param bool $suppressException
         *   Value <i>TRUE</i> if you want to suppress exception, and vice versa.
         * @return bool
         *   Value <i>TRUE</i> if data was saved, and vice versa.
         */
        
        public function saveToFile($fileLocation, $contents,
            $suppressException = false)
        {
            // Core Variables
            
            $fileHandler  = null;
            $bytesWritten = 0;
            
            // Logic
            
            try
            {
                $fileHandler  = fopen($fileLocation, "w");
                $bytesWritten = fwrite($fileHandler, $contents);
            }
            catch (\Exception $e)
            {
                if (!$suppressException)
                {
                    throw new \Exception("An unkown IO error occured.");
                }
            }
            finally
            {
                if ($fileHandler != null)
                {
                    fclose($fileHandler);
                }
            }
            
            return $bytesWritten > 0;
        }
        
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
