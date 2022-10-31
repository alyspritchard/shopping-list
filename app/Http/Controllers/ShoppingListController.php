<?php

namespace App\Http\Controllers;

Use App\Models\ShoppingList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $shoppingList = ShoppingList::firstOrNew([
            'user_id' => $userId
        ]);
        $shoppingList->save();

        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $shoppingListId
     * @return RedirectResponse
     */
    public function update(Request $request, $shoppingListId)
    {
        try {
            $shoppingList = ShoppingList::findOrFail($shoppingListId);
            $shoppingList->budget = $request->budget ?? $shoppingList->budget;
            $shoppingList->total = $request->total ?? $shoppingList->total;
            $shoppingList->save();
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $shoppingListId
     * @return RedirectResponse
     */
    public function destroy($shoppingListId)
    {
        try {
            $shoppingList = ShoppingList::findOrFail($shoppingListId);
            $shoppingList->delete();
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('dashboard');
    }
}
