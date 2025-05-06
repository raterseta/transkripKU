<?php
namespace Database\Factories;

use App\Models\Log;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition(): array
    {
        return [
            'id'         => $this->faker->uuid(),
            'activity'   => $this->faker->randomElement([
                'User login',
                'User logout',
                'Profile updated',
                'Password changed',
                'Document uploaded',
                'Document downloaded',
                'Request submitted',
                'Request approved',
                'Request rejected',
                'Comment added',
                'System backup',
                'Email sent',
                'Notification created',
            ]),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
}
