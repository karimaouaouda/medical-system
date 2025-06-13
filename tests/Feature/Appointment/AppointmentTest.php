<?php

use App\Enums\AppointmentStatus;
use App\Enums\FollowRequestStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\FollowRequest;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

it('patients can request appointments with followed doctors', function () {
    $patient = User::factory()->create(['role' => UserRole::Patient]);
    $doctor = User::factory()->create(['role' => UserRole::Doctor]);
    FollowRequest::factory()->create([
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'status' => FollowRequestStatus::Accepted,
    ]);

    actingAs($patient);

    Appointment::create([
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'scheduled_at' => now()->addDay(),
        'status' => AppointmentStatus::Pending,
    ]);

    assertDatabaseHas('appointments', [
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'status' => AppointmentStatus::Pending->value,
    ]);
});

it('doctors can accept appointments', function () {
    $doctor = User::factory()->doctor()->create();
    $appointment = Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'status' => AppointmentStatus::Pending,
    ]);

    actingAs($doctor);

    $appointment->update(['status' => AppointmentStatus::Accepted]);

    assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'status' => AppointmentStatus::Accepted->value,
    ]);
});
