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
    
    namespace Jocic\GoogleAuthenticator\Helpers;
    
    use Jocic\GoogleAuthenticator\Encoder;
    
    /**
     * <i>File</i> class is a helper class used for file I/O.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2026 All Rights Reserved
     * @version   1.0.0
     */
    class File
    {
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Saves the provided contents to a file.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $path
         *   Path of the file that should be saved.
         * @param string $contents
         *   Contents of the file that should be saved.
         * @return bool
         *   Value <i>TRUE</i> if the file was saved, and vice versa.
         */
        public static function save(string $path, string $contents) : bool
        {
            $bytesWritten = 0;
            
            try
            {
                $fileHandler = fopen($path, "w");
                
                if ($fileHandler !== false)
                {
                    $bytesWritten = fwrite($fileHandler, $contents);
                }
            }
            catch (\Exception $e)
            {
                throw new \Exception("An unkown IO error occured.");
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
        
        /**
         * Loads contents from the provided file.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2026 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $path
         *   Path of the file that should be saved.
         * @return string|false
         *   Contents of the file or <i>FALSE</i> on failure.
         */
        public static function load(string $path) : string|bool
        {
            $contents  = false;
            $bytesRead = 0;
            
            try
            {
                $fileHandler = fopen($path, "r");
                
                if ($fileHandler !== false)
                {
                    $contents = fread($fileHandler, filesize($path));
                }
            }
            catch (\Exception $e)
            {
                throw new \Exception("An unkown IO error occured.");
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
    }
    
?>
