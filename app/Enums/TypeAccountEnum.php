<?php
  
namespace App\Enums;
 
enum TypeAccountEnum:int {
    case ADMIN = 1;
    case USER = 2;
    case CUSTOMER = 3;
}