<?php

namespace Sw2\Forms;

use Nette\Reflection\ClassType;

/**
 * Interface IFormEntity
 *
 * @package Sw2\Forms
 */
interface IFormEntity
{

	/** @return ClassType|\ReflectionClass */
	public static function getReflection();

}
