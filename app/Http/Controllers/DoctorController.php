<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    // Lấy danh sách bác sĩ
    public function index()
    {
        $doctors = Doctor::with([
            'user:id,name,email,avatar',
            'specialty:id,name'
        ])->get(); //with('user') lấy tất cả các field của user
        return response()->json([
            'status' => 'success',
            'data' => $doctors
        ], 200);
    }

    // Lấy thông tin 1 bác sĩ theo ID
    public function show($id)
    {
        $doctor = Doctor::with('user')->find($id);
        if (!$doctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Doctor not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $doctor
        ], 200);
    }

    // Thêm bác sĩ mới
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'specialty_id' => 'required|exists:specialties,id',
            'license_number' => 'required|string|max:50|unique:doctors',
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'status' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Kiểm tra xem user_id đã có bản ghi trong doctors chưa
        $existingDoctor = Doctor::where('user_id', $request->user_id)->first();
        if ($existingDoctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'This user already has a doctor record'
            ], 422);
        }

        $doctor = Doctor::create($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Doctor created successfully',
            'data' => $doctor
        ], 201);
    }

    // Sửa thông tin bác sĩ
    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Doctor not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'specialty_id' => 'required|exists:specialties,id',
            'license_number' => 'sometimes|string|max:50|unique:doctors,license_number,' . $id,
            'phone' => 'sometimes|string|max:15',
            'gender' => 'sometimes|in:male,female,other',
            'date_of_birth' => 'sometimes|date',
            'status' => 'sometimes|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $doctor->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Doctor updated successfully',
            'data' => $doctor
        ], 200);
    }

    // Xóa bác sĩ
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Doctor not found'
            ], 404);
        }

        // Chuyển trạng thái tài khoản liên quan sang khóa: 0
        $user = $doctor->user;
        if ($user) {
            $user->update(['status' => 0]);
        }

        $doctor->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Doctor deleted successfully, user status set to inactive'
        ], 200);
    }

    // Lấy danh sách tài khoản có role = 'doctor' nhưng chưa có bản ghi trong doctors
    public function getAvailableUsers()
    {
        $availableUsers = User::where('role', 'doctor')
            ->whereDoesntHave('doctor')
            ->get();
        // dd($availableUsers); // Debug
        return response()->json([
            'status' => 'success',
            'data' => $availableUsers
        ], 200);
    }
}
