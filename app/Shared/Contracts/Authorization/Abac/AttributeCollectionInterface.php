<?php

namespace App\Shared\Contracts\Authorization\Abac;

use ArrayAccess;
use Illuminate\Support\Enumerable;

interface AttributeCollectionInterface extends ArrayAccess, Enumerable
{

}
