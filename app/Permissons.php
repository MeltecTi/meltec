<?php 

namespace App;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Permission\Models\Permission;

class Permissons extends Permission implements AuditableContract
{
    use Auditable;
}