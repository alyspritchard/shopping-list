<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return View
     */
    public function dashboard()
    {
        $userId = auth()->user()->id;
        $shoppingList = User::find($userId)->shoppingList;
        $items = null;

        if ($shoppingList) {
            $items = $shoppingList->items;
        }

        return view('dashboard', ['shoppingList' => $shoppingList, 'items' => $items]);
    }
}
