<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Quan lý thông tin người dùng
// Người dùng có thể là bác sĩ, bệnh nhân hoặc lễ tân
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }   
    public function receptionist()
    {
        return $this->hasOne(Receptionist::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isDoctor() {
        return $this->role === 'doctor';
    }

    public function isReceptionist() {
        return $this->role === 'receptionist';
    }

    public function isPatient() {
        return $this->role === 'patient';
    }

    // Sử dụng Eloquent Event để tự động tạo bản ghi trong doctors
    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->isDoctor()) { // Chỉ tạo bác sĩ nếu user có role là 'doctor'
                try {
                        // Tự động tạo bản ghi trong bảng doctors khi user được tạo
                        $user->doctor()->create([
                            'specialty_id' => 0, // Giá trị mặc định
                            'license_number' => 'TEMP-' . $user->id, // Giá trị tạm thời
                            'phone' => '', // Giá trị mặc định
                            'gender' => 'other', // Giá trị mặc định
                            'date_of_birth' => now(), // Giá trị mặc định
                            'status' => 'inactive', // Giá trị mặc định
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to create doctor record for user ' . $user->id . ': ' . $e->getMessage());
                        // Có thể rollback hoặc xử lý thêm nếu cần
                }
            }elseif($user->isPatient()){
                $user->patient()->create([
                    'date_of_birth' => now(),
                    'gender' => 'other', 
                    'phone' => '',
                    'address' => '',
                ]);
            }elseif($user->isReceptionist()){
                $user->receptionist()->create([
                    'phone' => '',
                    'gender' => 'other', 
                    'date_of_birth' => now(),
                    'address' => '',
                    'status' => 'inactive', 
                    'note' => '',
                ]);
            }
            
        });
    }
}
