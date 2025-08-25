<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Expense Report
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('expenses.report') }}"
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
                <a href="{{ route('expenses.report') }}"
                    class="px-4 py-2 border btn btn-sm btn-danger rounded">Reset</a>
            </div>
        </form>

        {{-- Report Table --}}
        <div class="bg-white rounded shadow p-4">
            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Title</th>ß
                        <th class="px-4 py-2 border">Date</th>
                        <th class="px-4 py-2 border">Category</th>
                        <th class="px-4 py-2 border text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr>
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $expense->title }}</td>
                            <td class="px-4 py-2 border">{{ $expense->date }}</td>
                            <td class="px-4 py-2 border">{{ $expense->category->name ?? '-' }}</td>
                            <td class="px-4 py-2 border text-right">{{ number_format($expense->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-semibold bg-gray-50">
                        <td colspan="2" class="px-4 py-2 border text-right">
                            <button onclick="window.print()"
                                class="px-4 py-2 bg-green-600 btn btn-sm btn-info rounded hover:bg-green-700">
                                Print
                            </button>
                        </td>
                        <td colspan="1" class="px-4 py-2 border text-right">Total</td>
                        <td class="px-4 py-2 border text-right">{{ number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#printBtn').click(function() {
                // Clone the report table
                var printContents = $('.report-table').clone();
                var originalContents = $('body').html();

                // Create a new window
                var printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>Expense Report</title>');
                printWindow.document.write(
                    '<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid #000; padding: 8px; }</style>'
                );
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h3>Expense Report</h3>');
                printWindow.document.write(printContents.prop('outerHTML'));
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            });
        });
    </script>

</x-app-layout>
