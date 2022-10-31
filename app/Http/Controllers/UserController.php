<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return View
     */
    public function dashboard()
    {
        try {
            $userId = auth()->user()->id;
            $shoppingList = User::findOrFail($userId)->shoppingList;
            $items = null;

            if ($shoppingList) {
                $items = $shoppingList->items;
            }
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('dashboard', ['shoppingList' => $shoppingList, 'items' => $items]);
    }
}
