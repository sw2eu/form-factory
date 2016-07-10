<?php

namespace Sw2\Forms;

use Nette;
use Nette\Forms\Controls\BaseControl;
use Nette\Utils\ArrayHash;

/**
 * Class EntityFormFactory
 *
 * @package Sw2\Forms
 */
abstract class EntityFormFactory
{
	use TContainerHandler;

	/** @var Nette\Localization\ITranslator */
	protected $translator;

	/** @var Nette\Forms\IFormRenderer */
	private $formRenderer;

	/**
	 * @param Nette\Localization\ITranslator $translator
	 * @param Nette\Forms\IFormRenderer $formRenderer
	 */
	public function __construct(Nette\Localization\ITranslator $translator, Nette\Forms\IFormRenderer $formRenderer)
	{
		$this->translator = $translator;
		$this->formRenderer = $formRenderer;
	}

	/**
	 * @param IFormEntity|null $entity
	 * @return Form
	 */
	public final function create(IFormEntity $entity = NULL)
	{
		$form = new Form;
		$form->setTranslator($this->translator);
		$form->setRenderer($this->getFormRenderer());
		$this->build($form, $entity);

		$form->onAttached[] = function (Form $self) use ($entity) {
			$this->buildToggles($self, "frm-{$self->name}");
			if ($entity !== NULL) {
				$this->setDefaultsByEntity($self, $entity);
			}
		};
		$form->beforeValidate[] = function (Form $self) {
			return $this->beforeValidate($self->values);
		};
		$form->onValidate[] = function (Form $self) use ($entity) {
			$this->onValidate($self, $entity);
		};

		return $form;
	}

	/**
	 * @return Nette\Forms\IFormRenderer
	 */
	protected function getFormRenderer()
	{
		return $this->formRenderer;
	}

	/**
	 * @param Form $form
	 */
	abstract protected function build(Form $form, IFormEntity $entity = NULL);

	/**
	 * @param Form|BaseControl[] $self
	 * @param string $fid
	 */
	protected function buildToggles(Form $self, $fid)
	{
	}

	/**
	 * @param ArrayHash $values
	 *
	 * @return ArrayHash
	 */
	protected function beforeValidate(ArrayHash $values)
	{
		return $values;
	}

	/**
	 * @param Form $form
	 */
	protected function onValidate(Form $form, IFormEntity $entity = NULL)
	{
	}

	/**
	 * Method for set values by existing item.
	 *
	 * @param Form $form
	 * @param IFormEntity $entity
	 */
	abstract protected function setDefaultsByEntity(Form $form, IFormEntity $entity);

}
