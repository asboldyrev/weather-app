<?php

namespace App\Exceptions;

use UnexpectedValueException;

class NotFoundIconIndex extends UnexpectedValueException
{
	public function __construct(int $index) {
		$message = sprintf('Отсутствуют данные для иконки с кодом %s', $index);

		parent::__construct($message);
	}
}
