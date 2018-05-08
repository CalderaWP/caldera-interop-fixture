<?php

namespace calderawp\ExampleInteropExtension\Models;

use calderawp\ExampleInteropExtension\Traits\HelloType;

abstract class Model extends \calderawp\interop\Models\Model
{

	use HelloType;
}
