<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave; // 确保仅包含对 Leave 模型的引用
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        // Validate the input data
        $request->validate([
            'date_range' => 'required',
            'group' => 'required',
            'leave_type' => 'required',
        ]);

        // Extract date range
        [$startDate, $endDate] = explode(' to ', $request->date_range);

        // Fetch data
        $leaves = Leave::byDateRange($startDate, $endDate)
                        ->where('category', $request->leave_type) // 使用正确的字段名
                        ->with('users') // assuming there is a relationship to User
                        ->get();

        // Generate CSV
        $response = new StreamedResponse(function() use ($leaves) {
            $handle = fopen('php://output', 'w');

            // Add CSV header
            fputcsv($handle, ['Employee Name', 'Start Date', 'End Date', 'Leave Type']);

            // Add data rows
            foreach ($leaves as $leave) {
                fputcsv($handle, [
                    $leave->users->name,  // assuming User model has a name field
                    $leave->start_date,
                    $leave->end_date,
                    $leave->category,  // assuming LeaveType relationship
                ]);
            }

            fclose($handle);
        });

        // Set CSV headers
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="leave_report.csv"');

        return $response;
    }

    public function index()
    {
        return view('filament.widgets.reportgeneratorwidget');
    }
}
