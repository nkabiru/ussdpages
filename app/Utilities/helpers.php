<?php

use App\UssdView;

function ussd_view($name){
    return UssdView::query()->where('name', $name)->firstOrFail(['body'])->body;
}
