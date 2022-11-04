Static variables exist only in a local function, but it does not free its memory after the program execution leaves the scope

@3 types datatype
1. scalar (pre defined) booolean, integer, float, string
2.compund (user defiend) array .obejct
3.special ... resource, NULL

$company = "Javatpoint";  
    //both single and double quote statements will treat different  
    echo "Hello $company";  
    echo "</br>";  
    echo 'Hello $company';     output Hello Javatpoint
                                       Hello $company 
 Resources are not the exact data type in PHP. Basically, these are used to store some function calls or references to external PHP resources. For example - 
 a database call. It is an external resource.     
 Null is a special data type that has only one value: NULL.                                