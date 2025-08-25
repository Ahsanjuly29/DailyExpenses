<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Expense
        </h2>
    </x-slot>

    <form action="{{ route('expenses.store') }}" method="POST" class="my-4 bg-white p-6 shadow sm:rounded-lg">
        @csrf
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="mt-1 w-full border rounded px-3 py-2">
                @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Amount</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required
                    class="mt-1 w-full border rounded px-3 py-2">
                @error('amount')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Date</label>
                <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" required
                    class="mt-1 w-full border rounded px-3 py-2">
                @error('date')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Category</label>
                <select name="category_id" required class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-2">
            <button class="px-4 py-2 bg-green-600 rounded btn btn-primary">Save</button>
            <a href="{{ route('expenses.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>
</x-app-layout>
