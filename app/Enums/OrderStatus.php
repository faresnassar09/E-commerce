<?php

namespace App\Enums;

enum OrderStatus:int{

case Preparing = 0;
case Delivered = 1;
case Canceled = 2;
case ReturnRequest = 3;
case ReturnRejected = 4;
case ReturnAccepted = 5;

}
