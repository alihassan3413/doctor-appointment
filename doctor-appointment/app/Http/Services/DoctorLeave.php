<?php

namespace App\Http\Services;

use App\Models\Doctor;
use App\Models\DoctorLeave as ModelsDoctorLeave;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

class DoctorLeave 
{
    public function requestLeave($data)
    {
        $doctor_id = Auth::user()->doctor->id;

        $existingLeave = ModelsDoctorLeave::where('doctor_id', $doctor_id)
        ->where(function (Builder $query) use ($data) {
            $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                  ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']])
                  ->orWhere(function (Builder $query) use ($data) {
                      $query->where('start_date', '<=', $data['start_date'])
                            ->where('end_date', '>=', $data['end_date']);
                  });
        })
        ->exists();

        if ($existingLeave) {
            throw new \Exception('You have already requested leave for this time period.');
        }

        $doctor = Auth::user()->doctor;
        $doctor->is_available = false;
        $doctor->save();
        
        return ModelsDoctorLeave::create([
            'doctor_id' => $doctor_id,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'reason' => $data['reason'],
            'status' => 'pending'
        ]);
    }

    public function viewLeaves($filter = [])
    {
        $query = ModelsDoctorLeave::query();
        if(!empty($filter['status']))
        {
            $query->where('status', $filter['status']);
        }
        return $query->with('doctor', 'doctor.user')->orderBy('created_at', 'desc')->paginate(10);
    }

    public function doctorLeaves()
    {
        $doctor_id = Auth::user()->doctor->id;
        return ModelsDoctorLeave::where('doctor_id', $doctor_id)->orderBy('created_at', 'desc')->paginate(10);
    }

    public function updateLeaveStatus($id, $data)
    {
        $leave = ModelsDoctorLeave::find($id);
        if($leave) {
            $leave->update($data);
            if ($data['status'] === 'approved') {
                $leave->doctor->is_available = false; // Not available
            } 
            return $leave;
        } else {
            return null;
        }
    }

    public function drIsAvailable($doctorId, $isAvailable)
    { 
        $doctor = Doctor::findOrFail($doctorId);

        $doctor->is_available = $isAvailable;
        $doctor->save();

        return $doctor;
    }
}