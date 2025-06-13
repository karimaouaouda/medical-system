<?php

namespace Database\Factories;

use App\Enums\FollowRequestStatus;
use App\Models\FollowRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FollowRequest>
 */
class FollowRequestFactory extends Factory
{
    protected $model = FollowRequest::class;

    public function definition(): array
    {
        return [
            'doctor_id' => User::factory()->doctor(),
            'patient_id' => User::factory(),
            'status' => FollowRequestStatus::Pending->value,
        ];
    }
}
