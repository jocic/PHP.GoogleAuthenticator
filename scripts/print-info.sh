#!/bin/bash

###################################################################
# Script Author: Djordje Jocic                                    #
# Script Year: 2018                                               #
# Script License: MIT License (MIT)                               #
# =============================================================== #
# Personal Website: http://www.djordjejocic.com/                  #
# =============================================================== #
# Permission is hereby granted, free of charge, to any person     #
# obtaining a copy of this software and associated documentation  #
# files (the "Software"), to deal in the Software without         #
# restriction, including without limitation the rights to use,    #
# copy, modify, merge, publish, distribute, sublicense, and/or    #
# sell copies of the Software, and to permit persons to whom the  #
# Software is furnished to do so, subject to the following        #
# conditions.                                                     #
# --------------------------------------------------------------- #
# The above copyright notice and this permission notice shall be  #
# included in all copies or substantial portions of the Software. #
# --------------------------------------------------------------- #
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, #
# EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES #
# OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND        #
# NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT     #
# HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,    #
# WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, RISING     #
# FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR   #
# OTHER DEALINGS IN THE SOFTWARE.                                 #
###################################################################

####################
# System Variables #
####################

kernel_name="$(uname -s)";
kernel_version="$(uname -r)";
architecture="$(uname -m)";
hostname="$(uname -n)";

#################
# PHP Variables #
#################

php_command="$(command -v php)";
php_version="$(php --version | sed -n 1p)";

###########################
# Step 1 -System Details #
###########################

printf "[+] System Details\n\n";

printf "Kernel Name: %s\n" "$kernel_name";
printf "Kernel Version: %s\n" "$kernel_version";
printf "System Architecture: %s\n" "$architecture";
printf "Hostname: %s\n" "$hostname";

########################
# Step 2 - PHP Details #
########################

printf "\n[+] PHP Details\n\n";

printf "PHP Command: %s\n" "$php_command";

if [ -n "$php_command" ]; then
    
    printf "PHP Version: %s\n" "$php_version";
    
fi
