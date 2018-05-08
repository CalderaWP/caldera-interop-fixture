<?php


namespace calderawp\ExampleInteropExtension;

class SayHello
{

	/**
	 * Says Hi to Roy or optionally some one else
	 *
	 * @param string $to Optional. Who to say hi to, such as "Mike". Default is "Roy"
	 * @return string
	 */
	public function sayHi(string  $to = 'Roy') : string
	{
		return "Hi $to";
	}
}
