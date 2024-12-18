<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorLeaveRequest;
use App\Http\Requests\DoctorLeaveStatusRequest;
use App\Http\Resources\DoctorLeaveResource;
use App\Http\Services\DoctorLeave;
use App\Models\DoctorLeave as ModelsDoctorLeave;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DoctorLeaveController extends Controller
{
    protected $leaveService;
    use ApiResponse;

    public function __construct(DoctorLeave $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    public function requestLeave(DoctorLeaveRequest $request)
    {
        try {
            $leave = $this->leaveService->requestLeave($request->validated());
            return $this->ok("Leave request created successfully", new DoctorLeaveResource($leave));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    public function viewLeaves(Request $request)
    {
        try {
            $leaves = $this->leaveService->viewLeaves($request->all());
            return $this->ok("Leaves retrieved successfully", DoctorLeaveResource::collection($leaves));
        } catch (\Exception $e) {
            return $this->error('An error occurred while retrieving the leaves.' . $e->getMessage());
        }
    }

    public function updateLeaveStatus(DoctorLeaveStatusRequest $request, $id)
    {
        try {
            $leave = $this->leaveService->updateLeaveStatus($id, $request->validated());
            return $this->ok("Leave status updated successfully", new DoctorLeaveResource($leave));
        } catch (\Exception $e) {
            return $this->error('An error occurred while updating the leave status.' . $e->getMessage());
        }
    }

    public function drIsAvailable(Request $request, $id)
    {
        try {
            $dr = $this->leaveService->drIsAvailable($id, $request->is_available);
            return $this->ok("Doctor availability updated successfully", $dr);
        } catch (\Exception $e) {
            return $this->error('An error occurred while updating the doctor availability.' . $e->getMessage());
        }
    }

    public function doctorLeaves()
    {
        try {
            $leaves = $this->leaveService->doctorLeaves();
            return $this->ok("Leaves retrieved successfully", DoctorLeaveResource::collection($leaves));
        } catch (\Exception $e) {
            return $this->error('An error occurred while retrieving the leaves.' . $e->getMessage());
        }
    }

    public function deleteLeave($leaveId)
    {
        try {
            $leave = ModelsDoctorLeave::findOrFail($leaveId);
            $leave->delete();
            return $this->ok("Leave deleted successfully");
        } catch (\Exception $e) {
            return $this->error('An error occurred while deleting the leave.' . $e->getMessage());
        }
    }


}
