<div class="p-6 bg-white rounded-lg shadow-md">
    <h4 class="mb-6 text-lg font-semibold text-gray-700">Generate HR Report</h4>
    <form action="{{ route('report.generate') }}" method="POST">
        @csrf
        <div class="mb-6">
            <label class="block text-sm mb-2">
                <span class="text-gray-700">Select Date Range</span>
                <input name="date_range" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="YYYY-MM-DD to YYYY-MM-DD" />
            </label>
        </div>
        <div class="mb-6">
            <label class="block text-sm mb-2">
                <span class="text-gray-700">Employee Group</span>
                <select name="group" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="all">All Employees</option>
                    <option value="department">By Department</option>
                    <option value="team">By Team</option>
                </select>
            </label>
        </div>
        <div class="mb-6">
            <label class="block text-sm mb-2">
                <span class="text-gray-700">Type of Leave</span>
                <select name="leave_type" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="all">All Types</option>
                    <option value="annual">Annual Leave</option>
                    <option value="sick">Sick Leave</option>
                    <option value="maternity">Maternity Leave</option>
                </select>
            </label>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-700">
                Generate Report
            </button>
        </div>
    </form>
</div>


