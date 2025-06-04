<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientsController extends Controller
{
   // Lấy danh sách bác sĩ
    public function index()
    {
        $receptionists = Patient::with('user:id,id,name,email,avatar')->get(); //with('user') lấy tất cả các field của user
        return response()->json([
            'status' => 'success',
            'data' => $receptionists
        ], 200);
    }

    // Lấy thông tin 1 bác sĩ theo ID
    public function show($id)
    {
        $receptionist = Patient::with('user')->find($id);
        if (!$receptionist) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $receptionist
        ], 200);
    }

    // Thêm bác sĩ mới
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Kiểm tra xem user_id đã có bản ghi trong Receptionists chưa
        $existingReceptionist = Patient::where('user_id', $request->user_id)->first();
        if ($existingReceptionist) {
            return response()->json([
                'status' => 'error',
                'message' => 'This user already has a Patient record'
            ], 422);
        }

        $receptionist = Patient::create($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Patient created successfully',
            'data' => $receptionist
        ], 201);
    }

    // Sửa thông tin bác sĩ
    public function update(Request $request, $id)
    {
        $receptionist = Patient::find($id);
        if (!$receptionist) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $receptionist->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Patient updated successfully',
            'data' => $receptionist
        ], 200);
    }

    // Xóa bác sĩ
    public function destroy($id)
    {
        $receptionist = Patient::find($id);
        if (!$receptionist) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        // Chuyển trạng thái tài khoản liên quan sang khóa: 0
        $user = $receptionist->user;
        if ($user) {
            $user->update(['status' => 0]);
        }

        $receptionist->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Patient deleted successfully, user status set to inactive'
        ], 200);
    }

    // Lấy danh sách tài khoản có role = 'Patient' nhưng chưa có bản ghi trong Receptionists
    public function getAvailableUsers()
    {
        $availableUsers = User::where('role', 'patient')
            ->whereDoesntHave('patient')
            ->get();
        // dd($availableUsers); // Debug
        return response()->json([
            'status' => 'success',
            'data' => $availableUsers
        ], 200);
    }
}
