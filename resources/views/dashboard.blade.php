<x-app-layout>
    <div class="container m-auto">
        <h2 class="mb-2 mt-5 text-lg font-semibold text-gray-900 dark:text-white">List of process:</h2>
        <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
            @if(auth()->user()->role == 'admin')
                <li>
                    <a href="{{ route('employees.create') }}"> Create Employee</a>
                </li>
            @endif
            <li>
                <a href="{{ route('employees.index') }}"> List Employees</a>
            </li>
        </ul>
    </div>
</x-app-layout>
