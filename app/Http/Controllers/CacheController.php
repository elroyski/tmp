<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

class CacheController extends Controller
{
    public function clearCache()
    {
        Artisan::call('cache:clear');
        return redirect()->back()->with('success', 'Pamięć podręczna została usunięta.');
    }

    public function regenerateCache()
    {
        // Logika do regeneracji cache
        // Na przykład: wywołaj funkcje, które generują dane cache'owane

        return redirect()->back()->with('success', 'Pamięć podręczna została wygenerowana ponownie.');
    }

   public function showConfigPage()
    {
        return view('config');
    }


}
