<?php

namespace Sw2\Forms;

use Nette;
use Nette\Forms\Controls\BaseControl;
use Nette\Utils\ArrayHash;

/**
 * Class FormFactory
 *
 * @package Sw2\Forms
 */
abstract class FormFactory extends Nette\Object
{
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
	 * Method for fill form.
	 *
	 * @return Form
	 */
	public final function create()
	{
		$form = new Form;
		$form->setTranslator($this->translator);
		$form->setRenderer($this->getFormRenderer());
		$this->build($form);

		$form->onAttached[] = function (Form $self) {
			$this->buildToggles($self, "frm-{$self->name}");
		};
		$form->beforeValidate[] = function (Form $self) {
			return $this->beforeValidate($self->values);
		};
		$form->onValidate[] = function (Form $self) {
			$this->onValidate($self);
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
	abstract protected function build(Form $form);

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
	protected function onValidate(Form $form)
	{
	}

}
