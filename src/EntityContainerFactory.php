<?php

namespace Sw2\Forms;

use Nette\Forms\Controls\BaseControl;
use Nette\NotImplementedException;

/**
 * Class EntityContainerFactory
 *
 * @package Sw2\Forms
 */
abstract class EntityContainerFactory
{
	use TContainerHandler;

	/**
	 * @param IFormEntity|NULL $entity
	 * @return Container
	 */
	public function create(IFormEntity $entity = NULL)
	{
		$container = new Container;
		$this->build($container, $entity);

		$container->onAttached[] = function (Container $self) use ($entity) {
			$this->buildToggles($self, "frm-{$self->form->name}", $self->name);
		};
		$container->onValidate[] = function(Container $self) use ($entity) {
			$this->onValidate($self, $entity);
		};

		return $container;
	}

	/**
	 * @param Container $container
	 * @param IFormEntity $entity
	 */
	abstract protected function build(Container $container, IFormEntity $entity = NULL);


	/**
	 * @param Container|BaseControl[] $self
	 * @param string $fid
	 * @param string $cid
	 */
	protected function buildToggles(Container $self, $fid, $cid)
	{
	}

	/**
	 * @param Container $self
	 * @param IFormEntity|null $entity
	 */
	protected function onValidate(Container $self, IFormEntity $entity = NULL)
	{
	}

	/**
	 * Set values by entity of this container.
	 *
	 * @param Container $container
	 * @param IFormEntity $entity
	 */
	public function setDefaultByEntity(Container $container, IFormEntity $entity)
	{
		$class = get_class($this);
		throw new NotImplementedException("Class '$class' has not defined method 'setDefaultByEntity'.");
	}

	/**
	 * Set values by collection.
	 *
	 * @param Container $container
	 * @param mixed $collection
	 */
	public function setDefaultByCollection(Container $container, $collection)
	{
		$class = get_class($this);
		throw new NotImplementedException("Class '$class' has not defined method 'setDefaultByCollection'.");
	}

}
