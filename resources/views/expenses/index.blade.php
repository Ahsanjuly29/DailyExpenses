<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Expenses
        </h2>
    </x-slot>

    <div class="my-4">
        <form method="GET" action="{{ route('expenses.index') }}"
            class="mb-4 flex flex-wrap items-center gap-3 bg-white p-3 rounded shadow">

            <div class="flex flex-col">
                <label class="text-sm font-medium mb-1">From</label>
                <input type="date" name="from" value="{{ request('from') }}"
                    class="border rounded px-3 py-1.5 focus:ring focus:border-blue-400">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium mb-1">To</label>
                <input type="date" name="to" value="{{ request('to') }}"
                    class="border rounded px-3 py-1.5 focus:ring focus:border-blue-400">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium mb-1">&nbsp;</label>
                <select name="category_id" class="border rounded px-3 py-1.5 focus:ring focus:border-blue-400">
                    <option value="">Select a Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2 mt-4">
                <button class="px-4 py-2 bg-blue-600 btn btn-sm btn-primary rounded">Filter</button>
                <a href="{{ route('expenses.index') }}" class="px-4 py-2 border btn btn-sm btn-danger rounded">Reset</a>
            </div>
        </form>

        <div class="bg-white overflow-hidden shadow sm:rounded-lg my-2">
            <div class="bg-white shadow rounded p-4">
                <h1 class="h3">Grouped by category list of expenses({{ $rangeStart }} - {{ $rangeEnd }})</h1>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th>#</th>
                            <th class="border px-4 py-2 text-left">Category</th>
                            <th class="border px-4 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($summary as $row)
                            <tr>
                                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2">{{ $row->name }}</td>
                                <td class="border px-4 py-2 text-right">{{ number_format($row->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 font-semibold">
                            <td class="border px-4 py-2 text-right">Grand Total</td>
                            <td class="border px-4 py-2 text-right">{{ number_format($grandTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow sm:rounded-lg my-2">
            <div class="bg-white shadow rounded p-4">
                <h2 class="text-xl font-semibold mb-4">
                    Total list of expenses({{ $rangeStart }} - {{ $rangeEnd }})
                </h2>

                <table class="table table-hover table-bordered min-w-full divide-y divide-gray-200">
                    <thead class="bg-primary">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold">#</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Title</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Date</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Category</th>
                            <th class="px-4 py-2 text-right text-sm font-semibold">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if (!empty($expenses))
                            <tr>
                                <td colspan="4">
                                    {!! $expenses->links() !!}
                                </td>
                            </tr>
                        @endif
                        @foreach ($expenses as $expense)
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $expense->title }}</td>
                                <td>{{ $expense->date }}</td>
                                <td class="px-4 py-2">{{ $expense->category->name }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($expense->amount, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2"></td>
                            <td class="px-4 py-2 text-right">Total</td>
                            <td class="px-4 py-2 text-right">{{ number_format($total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</x-app-layout>
