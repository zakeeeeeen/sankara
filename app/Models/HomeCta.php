<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['heading', 'body', 'primary_label', 'primary_url', 'secondary_label', 'secondary_url'])]
class HomeCta extends Model
{
}

