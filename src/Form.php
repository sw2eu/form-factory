<?php

namespace Sw2\Forms;

use Nette;
use Nette\Utils\Callback;

/**
 * Class Form
 *
 * @package Sw2\Forms
 */
class Form extends Nette\Application\UI\Form
{
	/** @var callable[]  function(Container $sender); Occurs when the form is attached */
	public $onAttached;

	/** @var callable[]  function(Container $sender); Occurs before the form is validated */
	public $beforeValidate;

	protected function attached($presenter)
	{
		parent::attached($presenter);
		if ($presenter instanceof Nette\Application\IPresenter) {
			$this->onAttached($this);
		}
	}

	public function validate(array $controls = NULL)
	{
		foreach ($this->beforeValidate ?: [] as $handler) {
			$params = Callback::toReflection($handler)->getParameters();
			$values = isset($params[1]) ? $this->getValues($params[1]->isArray()) : NULL;
			$this->values = Callback::invoke($handler, $this, $values);
		}
		parent::validate($controls);
	}

}
