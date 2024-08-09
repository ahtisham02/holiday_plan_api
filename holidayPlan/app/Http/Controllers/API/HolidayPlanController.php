<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HolidayPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Storage;

class HolidayPlanController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $holidays = HolidayPlan::OrderBy('id','DESC')->get();
        return $this->success($holidays, 'Holiday plans retrieved successfully');
    }

    public function show($id)
    {
        $plan = HolidayPlan::find($id);
        if (!$plan) {
            return $this->error('Holiday plan not found', 404);
        }
        return $this->success($plan, 'Holiday plan retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date_format:Y-m-d',
            'location' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation errors', 422, $validator->errors());
        }

        $plan = HolidayPlan::create($request->all());
        return $this->success($plan, 'Holiday plan created successfully', 201);
    }

    public function update(Request $request, $id)
    {
        $plan = HolidayPlan::find($id);
        if (!$plan) {
            return $this->error('Holiday plan not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string',
            'date' => 'date_format:Y-m-d',
            'location' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation errors', 422, $validator->errors());
        }

        $plan->update($request->all());
        return $this->success($plan, 'Holiday plan updated successfully');
    }

    public function destroy($id)
    {
        $plan = HolidayPlan::find($id);
        if (!$plan) {
            return $this->error('Holiday plan not found', 404);
        }

        $plan->delete();
        return $this->success(null, 'Holiday plan deleted successfully', 204);
    }

    public function generatePdf($id)
    {
        $plan = HolidayPlan::find($id);
        if (!$plan) {
            return $this->error('Holiday plan not found', 404);
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('pdf.holiday_plan', compact('plan'))->render());
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $fileName = 'holiday_plan_' . $id . '.pdf';
        
        Storage::disk('public')->put($fileName, $dompdf->output());

        $fileUrl = Storage::disk('public')->url($fileName);

        return $this->success(['pdf_url' => $fileUrl], 'PDF generated and uploaded successfully');
    }
}
