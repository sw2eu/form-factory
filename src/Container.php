<?php

namespace Sw2\Forms;

use Nette;
use Nette\ComponentModel\IContainer;

/**
 * Class Container
 *
 * @package Sw2\Forms
 */
class Container extends Nette\Forms\Container
{
	/** @var callable[]  function(Container $sender); Occurs when the form is attached */
	public $onAttached;

	public function __construct(IContainer $parent = NULL, $name = NULL)
	{
		parent::__construct($parent, $name);
		$this->monitor(Nette\Application\IPresenter::class);
	}

	/**
	 * @param Nette\Application\IPresenter $presenter
	 */
	protected function attached($presenter)
	{
		parent::attached($presenter);
		if ($presenter instanceof Nette\Application\IPresenter) {
			$this->onAttached($this);
		}
	}

}
