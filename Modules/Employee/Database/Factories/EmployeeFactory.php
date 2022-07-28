<?php

namespace Modules\Employee\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Employee\Entities\Employee;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                      => substr($this->faker->text(15), 0, -1),
            'slug'                      => '',
            'employee_department'       => '',
            'employee_role'             => '',
            'status'                    => 1,
            'created_at'                => Carbon::now(),
            'updated_at'                => Carbon::now(),
        ];
    }
}
