<?php

namespace Sw2\Forms;

use Nette;

/**
 * Class TContainerHandler
 *
 * @package Sw2\Forms
 */
trait TContainerHandler
{

	/** @return Nette\Reflection\ClassType|\ReflectionClass */
	protected function getReflection()
	{
		$class = class_exists('Nette\Reflection\ClassType') ? 'Nette\Reflection\ClassType' : 'ReflectionClass';
		return new $class(get_called_class());
	}

	/**
	 * @param Nette\Forms\Container $parent
	 * @param string $name
	 * @param IFormEntity|NULL $entity
	 * @return Container
	 */
	protected function addContainer(Nette\Forms\Container $parent, $name, IFormEntity $entity = NULL)
	{
		$container = $this->getContainerFactory($name)->create($entity);
		$parent->addComponent($container, $name);
		return $container;
	}

	/**
	 * @param $containerName
	 * @return EntityContainerFactory
	 */
	protected function getContainerFactory($containerName)
	{
		$propertyName = $containerName . 'ContainerFactory';
		if (!$this->getReflection()->hasProperty($propertyName)) {
			$class = get_class($this);
			throw new Nette\NotImplementedException("Class '$class' has not defined property '$propertyName'.");
		}
		if (!$this->$propertyName instanceof EntityContainerFactory) {
			$class = get_class($this);
			throw new Nette\NotImplementedException("Class '$class' has wrongly defined factory '$propertyName'.");
		}

		return $this->$propertyName;
	}

	/**
	 * @param Nette\Forms\Container $parent
	 * @param string $name
	 * @param mixed $values
	 */
	protected function setContainerDefaults(Nette\Forms\Container $parent, $name, $values)
	{
		if ($values === NULL) return;

		$component = $parent->getComponent($name);
		$factory = $this->getContainerFactory($name);
		if ($values instanceof IFormEntity) {
			$factory->setDefaultByEntity($component, $values);
		} else {
			$factory->setDefaultByCollection($component, $values);
		}
	}

}
