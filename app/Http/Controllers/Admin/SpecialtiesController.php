<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SpecialtiesController extends Controller
{
    // GET: Lấy danh sách chuyên khoa
    public function index(Request $request): JsonResponse
    {
         // Lấy giá trị `limit` từ query string, nếu không có thì trả về null
    $limit = $request->query('limit');

    // Kiểm tra nếu có giới hạn thì apply, còn không thì lấy tất cả
    $specialties = $limit ? Specialty::limit($limit)->get() : Specialty::all();
        return response()->json([
            'status' => 'success',
            'data' => $specialties
        ], 200);
    }

    // POST: Tạo mới chuyên khoa
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:specialties,name',
            'description' => 'nullable|string',
            // 'image' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only('name', 'description');
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }

        $specialty = Specialty::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Specialty created successfully',
            'data' => $specialty
        ], 201);
    }

    // GET: Lấy thông tin chi tiết một chuyên khoa
    public function show($id): JsonResponse
    {
        $specialty = Specialty::find($id);

        if (!$specialty) {
            return response()->json([
                'status' => 'error',
                'message' => 'Specialty not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $specialty
        ], 200);
    }

    // PUT: Cập nhật thông tin chuyên khoa
    public function update(Request $request, $id): JsonResponse
    {
        $specialty = Specialty::find($id);

        if (!$specialty) {
            return response()->json([
                'status' => 'error',
                'message' => 'Specialty not found'
            ], 404);
        }
        $data = $request->only('name', 'description');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:specialties,name,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only('name', 'description');

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($specialty->image) {
                Storage::disk('public')->delete($specialty->image);
            }
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }

        $specialty->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Specialty updated successfully',
            'data' => $specialty
        ], 200);
    }

    // DELETE: Xóa chuyên khoa
    public function destroy($id): JsonResponse
    {
        $specialty = Specialty::find($id);

        if (!$specialty) {
            return response()->json([
                'status' => 'error',
                'message' => 'Specialty not found'
            ], 404);
        }

        if ($specialty->image) {
            Storage::disk('public')->delete($specialty->image);
        }

        $specialty->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Specialty deleted successfully'
        ], 200);
    }
}
