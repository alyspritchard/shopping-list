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
        $shoppingList = ShoppingList::find($shoppingListId);

        if ($shoppingList) {
            $name = $request->name;
            $item = $shoppingList->items()->firstOrNew(['name' => $name]);
            $item->save();
            return redirect()->route('dashboard');
        }

        return 'Shopping List not found';
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
        $item = Item::find($itemId);

        if ($item && $item->shopping_list_id == $shoppingListId) {
            $item->is_purchased = $request->is_purchased;
            $item->save();
            return redirect()->route('dashboard');
        }

        return "Item not found.";
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
        $item = Item::find($itemId);

        if ($item && $item->shopping_list_id == $shoppingListId) {
            $item->delete();
            return redirect()->route('dashboard');
        }

        return "Item not found";
    }
}
