<?php

use Carbon\Carbon;

if(!function_exists('tgl')){
    function tgl($tanggal)
    {
       $tgl = Carbon::parse($tanggal);
       $tgl->format("d F Y H:i:s");
       return $tgl;
    }
}
