<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray leading-tight">
            {{ __('Shopping List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray">
                    {{ __('Hi') }} {{ Auth::user()->name }}!
                </div>
                @isset ($shoppingList)
                    <div class="p-6 bg-white border-b border-gray">
                        <h2>{{ __("Add some stuff here:") }}</h2>
                        <div class="mt-2">
                            <form method="POST"
                                  action="{{ route('item.store', ['shopping_list_id' => $shoppingList->id]) }}">
                                @csrf
                                @method('POST')
                                <div class="flex flex-wrap items-center">
                                    <x-label for="name" :value="__('Item:')" />

                                    <x-input id="name"
                                             class="ml-2"
                                             type="text"
                                             name="name"
                                             :value="old('name')"
                                             required
                                             autofocus />

                                    <x-button class="ml-2 bg-blue">
                                        {{ __('Add') }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-6 bg-white flex-auto w-50">
                            <h3 class="underline">{{ __('Stuff To Get') }}</h3>
                            <ul class="my-4">
                                @foreach($items as $item)
                                    @if (!$item->is_purchased)
                                        <li class="mt-2 flex flex-wrap items-center">
                                            <span class="ml-2">{{ $item->name }}</span>
                                            {{-- Add to Basket --}}
                                            <form method="POST"
                                                  action="{{ route('item.update', ['shopping_list_id' => $shoppingList->id, 'item_id' => $item->id]) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex flex-wrap items-center">
                                                    <x-label class="sr-only"
                                                             for="{{ $item->id }}_is_purchased"
                                                             :value="__('Is Purchased:')" />

                                                    <x-input id="{{ $item->id }}_is_purchased"
                                                             type="checkbox"
                                                             class="hidden"
                                                             name="is_purchased"
                                                             :value="1"
                                                             checked
                                                             required />
                                                    <x-button class="ml-2 bg-green">
                                                        {{ __('Add to Basket') }}
                                                    </x-button>
                                                </div>
                                            </form>

                                            {{-- Delete item --}}
                                            <form method="POST"
                                                  action="{{ route('item.destroy', ['shopping_list_id' => $shoppingList->id, 'item_id' => $item->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="flex flex-wrap items-center">
                                                    <x-button class="ml-2 bg-red">
                                                        {{ __('Delete') }}
                                                    </x-button>
                                                </div>
                                            </form>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <div class="p-6 bg-white flex-auto w-50">
                            <h3 class="underline">{{ __('Stuff in Your Basket') }}</h3>
                            <ul class="my-4 ">
                                @foreach($items as $item)
                                    @if ($item->is_purchased)
                                        <li class="mt-2 flex flex-wrap items-center">
                                            <span class="ml-2">{{ $item->name }}</span>
                                            {{-- Remove From Basket --}}
                                            <form method="POST"
                                                  action="{{ route('item.update', ['shopping_list_id' => $shoppingList->id, 'item_id' => $item->id]) }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="flex flex-wrap items-center">
                                                    <x-label class="sr-only"
                                                             for="{{ $item->id }}_is_purchased"
                                                             :value="__('Is Purchased:')" />

                                                    <x-input id="{{ $item->id }}_is_purchased"
                                                             type="checkbox"
                                                             class="hidden"
                                                             name="is_purchased"
                                                             :value="0"
                                                             checked
                                                             required />
                                                    <x-button class="ml-2 bg-red">
                                                        {{ __('Remove from Basket') }}
                                                    </x-button>
                                                </div>
                                            </form>

                                            {{-- Delete item --}}
                                            <form method="POST"
                                                  action="{{ route('item.destroy', ['shopping_list_id' => $shoppingList->id, 'item_id' => $item->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="flex flex-wrap items-center">
                                                    <x-button class="ml-2 bg-red">
                                                        {{ __('Delete') }}
                                                    </x-button>
                                                </div>
                                            </form>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    </div>
                    <div class="p-6 bg-white border-t border-gray">
                        <form method="POST" action="{{ route('shopping-list.destroy', ['shopping_list_id' => $shoppingList->id]) }}">
                            @csrf
                            @method('DELETE')
                            <x-button class="ml-3 bg-red">
                                {{ __('Delete your shopping list') }}
                            </x-button>
                        </form>
                    </div>

                @else
                    <div class="p-6 bg-white border-b border-gray">
                        <form method="POST" action="{{ route('shopping-list.store') }}">
                            @csrf
                            @method('POST')
                            <x-button class="ml-3 bg-green">
                                {{ __('Create your shopping List') }}
                            </x-button>
                        </form>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</x-app-layout>
