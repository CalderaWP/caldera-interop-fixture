<?php

namespace calderawp\HelloExtension\Models;

use calderawp\HelloExtension\Traits\HelloType;

abstract class Model extends \calderawp\interop\Models\Model
{

	use HelloType;
}
