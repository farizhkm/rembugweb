<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    // Tambahkan cookie yang tidak perlu dienkripsi di sini jika ada
    protected $except = [];
}
