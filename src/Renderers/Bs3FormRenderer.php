<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms-rendering
 */

namespace Nextras\FormsRendering\Renderers;

use Nette\Forms\Controls;
use Nette\Forms\Form;
use Nette\Forms\IControl;
use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\Utils\Html;


/**
 * Form renderer for Bootstrap 3.
 */
class Bs3FormRenderer extends DefaultFormRenderer
{
	/** @var Controls\Button */
	public $primaryButton = null;

	/** @var bool */
	private $controlsInit = false;


	public function __construct()
	{
		$this->wrappers['controls']['container'] = null;
		$this->wrappers['pair']['container'] = 'div class=form-group';
		$this->wrappers['pair']['.error'] = 'has-error';
		$this->wrappers['control']['container'] = 'div class=col-sm-9';
		$this->wrappers['label']['container'] = 'div class="col-sm-3 control-label"';
		$this->wrappers['control']['description'] = 'span class=help-block';
		$this->wrappers['control']['errorcontainer'] = 'span class=help-block';
		$this->wrappers['error']['container'] = null;
		$this->wrappers['error']['item'] = 'div class="alert alert-danger"';
	}


	public function render(Form $form, string $mode = null): string
	{
		if ($this->form !== $form) {
			$this->controlsInit = false;
		}

		return parent::render($form, $mode);
	}


	public function renderBegin(): string
	{
		$this->controlsInit();
		return parent::renderBegin();
	}


	public function renderEnd(): string
	{
		$this->controlsInit();
		return parent::renderEnd();
	}


	public function renderBody(): string
	{
		$this->controlsInit();
		return parent::renderBody();
	}


	public function renderControls($parent): string
	{
		$this->controlsInit();
		return parent::renderControls($parent);
	}


	public function renderPair(IControl $control): string
	{
		$this->controlsInit();
		return parent::renderPair($control);
	}


	public function renderPairMulti(array $controls): string
	{
		$this->controlsInit();
		return parent::renderPairMulti($controls);
	}


	public function renderLabel(IControl $control): Html
	{
		$this->controlsInit();
		return parent::renderLabel($control);
	}


	public function renderControl(IControl $control): Html
	{
		$this->controlsInit();
		return parent::renderControl($control);
	}


	private function controlsInit()
	{
		if ($this->controlsInit) {
			return;
		}

		$this->controlsInit = true;
		$this->form->getElementPrototype()->addClass('form-horizontal');
		foreach ($this->form->getControls() as $control) {
			if ($control instanceof Controls\Button) {
				$markAsPrimary = $control === $this->primaryButton || (!isset($this->primaryButton) && empty($usedPrimary) && $control->parent instanceof Form);
				if ($markAsPrimary) {
					$class = 'btn btn-primary';
					$usedPrimary = true;
				} else {
					$class = 'btn btn-default';
				}
				$control->getControlPrototype()->addClass($class);
			} elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
				$control->getControlPrototype()->addClass('form-control');
			} elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
				if ($control instanceof Controls\Checkbox) {
					$control->getSeparatorPrototype()->setName('div')->appendAttribute('class', $control->getControlPrototype()->type);
				} else {
					$control->getItemLabelPrototype()->addClass($control->getControlPrototype()->type . '-inline');
				}
			}
		}
	}
}
