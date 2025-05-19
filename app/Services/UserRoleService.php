<?php
namespace App\Services;

use App\Http\Resources\AdminResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\ReceptionistResource;
use App\Http\Resources\UserResource;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Receptionist;
use App\Models\User;

class UserRoleService
{
    public static function getResourceByRole(User $user)
    {
        switch ($user->role) {
            case 'admin':
                return new AdminResource($user);
            case 'doctor':
                return new DoctorResource($user);
            case 'receptionist':
                return new ReceptionistResource($user);
            case 'patient':
                $patient = $user->patient()->first();

                if (!$patient) {
                    // fallback nếu không tìm thấy bản ghi patient liên kết
                    return new UserResource($user); // hoặc throw exception nếu bạn muốn
                }
                return new PatientResource($patient);
                // return new PatientResource($user->patient()->first());
            default:
                return new UserResource($user);
        }
    }

    public static function createUserByRole($user){
        switch ($user->role) {
        case 'patient':
            Patient::create([
                'user_id' => $user->id,
            ]);
            break;
        case 'doctor':
            Doctor::create([
                'user_id' => $user->id,
            ]);
            break;
        case 'receptionist':
            Receptionist::create([
                'user_id' => $user->id,
            ]);
            break;
        }
    }
}