<?php

use App\UssdView;

function ussd_view($name){
    return UssdView::where('name', $name)->value('body');
}
