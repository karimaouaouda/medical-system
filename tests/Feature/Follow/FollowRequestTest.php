<?php

use App\Enums\FollowRequestStatus;
use App\Models\FollowRequest;
use App\Models\User;
use App\Enums\UserRole;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

it('patients can create follow requests', function () {
    $patient = User::factory()->create(['role' => UserRole::Patient]);
    $doctor = User::factory()->create(['role' => UserRole::Doctor]);

    actingAs($patient);

    FollowRequest::create([
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'status' => FollowRequestStatus::Pending,
    ]);

    assertDatabaseHas('follow_requests', [
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'status' => FollowRequestStatus::Pending->value,
    ]);
});
