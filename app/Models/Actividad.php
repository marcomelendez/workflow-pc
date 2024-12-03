<?php

namespace App\Models;

use App\States\ContentState;
use App\States\Pending;
use App\States\Published;
use EightyNine\Approvals\Models\ApprovableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Actividad extends ApprovableModel
{
    protected $table = 'actividades';

    use HasFactory, HasStates;

    protected $casts = [
        'estado' => ContentState::class,
    ];

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo'
    ];

    public function shouldBeHidden(): bool
    {
        return true;
        return $this->approvalStatus->status === 'approved';
    }

    public function canBePublishedBy($user): bool
    {
        return $user->can('publish', $this);
    }

    public function isPublish(): bool
    {
        return $this->estado->equals(Published::class);
    }

    public function isPending(): bool
    {
        return $this->estado->equals(Pending::class);
    }
}
