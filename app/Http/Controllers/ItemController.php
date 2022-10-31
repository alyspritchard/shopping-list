<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ShoppingList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param  int $shoppingListId
     * @return RedirectResponse
     */
    public function store(Request $request, int $shoppingListId)
    {
        $validated = $request->validate([
            'name' => 'required|unique:App\Models\Item,name|max:255',
        ]);

        try {
            $shoppingList = ShoppingList::findOrFail($shoppingListId);
            $name = $validated['name'];
            $item = $shoppingList->items()->firstOrNew(['name' => $name]);
            $item->save();
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $shoppingListId
     * @param $itemId
     * @return RedirectResponse
     */
    public function update(Request $request, $shoppingListId, $itemId)
    {
        $validated = $request->validate([
            'is_purchased' => 'boolean',
        ]);

        try {
            $item = Item::findOrFail($itemId);

            if ($item->shopping_list_id == $shoppingListId) {
                $item->is_purchased = $validated['is_purchased'] ?? $item->is_purchased;
                $item->save();
            }
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $shoppingListId
     * @param $itemId
     * @return RedirectResponse
     */
    public function destroy($shoppingListId, $itemId)
    {
        try {
            $item = Item::findorFail($itemId);

            if ($item->shopping_list_id == $shoppingListId) {
                $item->delete();
            }
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('dashboard');
    }
}
