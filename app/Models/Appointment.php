<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Appointment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'full_name',
        'email',
        'phone_code',
        'mobile_number',
        'password',
        'appointment_type',
        'symptoms',
        'preferred_doctor',
        'preferred_time',
        'preferred_date',
        'additional_notes',
        'medical_history',
        'current_medications',
        'appointment_fee',
        'payment_method',
        'payment_status',
        'payment_transaction_id',
        'status',
        'terms_conditions',
        'email_verified_at'
    ];
    
    protected $hidden = [
        'password',
    ];
    
    protected $casts = [
        'preferred_date' => 'date',
        'terms_conditions' => 'array',
        'email_verified_at' => 'timestamp',
        'appointment_fee' => 'decimal:2'
    ];
    
    // Mutators
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    
    // Accessors
    public function getFormattedAppointmentDateAttribute()
    {
        return $this->preferred_date ? $this->preferred_date->format('F j, Y') : null;
    }
    
    public function getFormattedAppointmentFeeAttribute()
    {
        return '$' . number_format($this->appointment_fee, 2);
    }
    
    // Authentication Methods
    public static function authenticate($email, $password)
    {
        $appointment = self::where('email', $email)->first();
        
        if ($appointment && Hash::check($password, $appointment->password)) {
            return $appointment;
        }
        
        return null;
    }
    
    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }
    
    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
    
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('preferred_date', $date);
    }
    
    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }
    
    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
