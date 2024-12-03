<?php

namespace Database\Seeders;

use App\Models\Actividad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RingleSoft\LaravelProcessApproval\Enums\ApprovalTypeEnum;
use Illuminate\Support\Str;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::makeApprovable([
            [
                'role_id' => 2,
                'action' => ApprovalTypeEnum::APPROVE->value,
                'order' => 1,
            ],
        ], 'Flujo para actividad');
    }

    /**
     * Undocumented function
     *
     * @param array|null|null $steps
     * @param string|null|null $name
     * @return boolean
     */
    public static function makeApprovable(array|null $steps = null, string|null $name = null): bool
    {
        $processApproval = new \RingleSoft\LaravelProcessApproval\ProcessApproval();
        try {
            DB::BeginTransaction();

            $class = Actividad::class;

            $flow = $processApproval->createFlow($name ?? Str::title($class), $class);
            if ($steps && count($steps) > 0) {
                $rolesModel = config('process_approval.roles_model');
                foreach ($steps as $key => $step) {
                    if (is_numeric($key) && is_numeric($step)) { // Associative
                        $roleId = ($rolesModel)::find($step)?->id;
                        $approvalActionType = ApprovalTypeEnum::APPROVE->value;
                    } elseif (is_numeric($key) && is_array($step)) { // Associative
                        $roleId = ($rolesModel)::find($step['role_id'])?->id;
                        $approvalActionType = ApprovalTypeEnum::from($step['action'])->value ?? ApprovalTypeEnum::APPROVE->value;
                    } else {
                        $roleId = ($rolesModel)::where((is_numeric($key) ? 'id' : 'name'), $key)->first()?->id;
                        $approvalActionType = ApprovalTypeEnum::from($step)->value ?? ApprovalTypeEnum::APPROVE->value;
                    }
                    if ($roleId) {
                        $processApproval->createStep($flow->id, $roleId, $approvalActionType);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return true;
    }
}
