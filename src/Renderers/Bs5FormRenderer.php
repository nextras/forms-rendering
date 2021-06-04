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
 * Form renderer for Bootstrap 5.
 */
class Bs5FormRenderer extends DefaultFormRenderer
{
	/** @var Controls\Button */
	public $primaryButton;

	/** @var bool */
	private $controlsInit = false;

	/** @var string */
	private $layout;


	public function __construct($layout = FormLayout::HORIZONTAL)
	{
		$this->layout = $layout;

		if ($layout === FormLayout::HORIZONTAL) {
			$groupClasses = 'mb-3 row';
		} elseif ($layout === FormLayout::INLINE) {
			// Will be overridden by `.row-cols-lg-auto` from the form on large-enough screens.
			$groupClasses = 'col-12';
		} else {
			$groupClasses = 'mb-3';
		}

		$this->wrappers['controls']['container'] = null;
		$this->wrappers['pair']['container'] = 'div class="' . $groupClasses . '"';
		$this->wrappers['control']['container'] = $layout === FormLayout::HORIZONTAL ? 'div class=col-sm-9' : null;
		$this->wrappers['label']['container'] = $layout === FormLayout::HORIZONTAL ? 'div class="col-sm-3 col-form-label"' : null;
		$this->wrappers['control']['description'] = 'small class="form-text text-muted"';
		$this->wrappers['control']['errorcontainer'] = 'div class=invalid-feedback';
		$this->wrappers['control']['.error'] = 'is-invalid';
		$this->wrappers['control']['.file'] = 'form-control';
		$this->wrappers['error']['container'] = null;
		$this->wrappers['error']['item'] = 'div class="alert alert-danger" role=alert';

		if ($layout === FormLayout::INLINE) {
			$this->wrappers['group']['container'] = null;
			$this->wrappers['group']['label'] = 'h2';
		}
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

		if ($this->layout === FormLayout::INLINE) {
			// Unlike previous versions, Bootstrap 5 has no special class for inline forms.
			// Instead, upstream recommends a wrapping flexbox row with auto-sized columns.
			// https://getbootstrap.com/docs/5.0/forms/layout/#inline-forms
			$this->form->getElementPrototype()->addClass('row row-cols-lg-auto g-3 align-items-center');
		}

		foreach ($this->form->getControls() as $control) {
			if ($this->layout === FormLayout::INLINE) {
				// Unfortunately, the aforementioned solution does not seem to expect labels
				// so we need to add some hacks. Notably, `.form-control`, `.form-select` and
				// others add `display: block`, forcing the control onto a next line.
				// The checkboxes are exception since they have their own inline class.

				if (!$control instanceof Controls\Checkbox && !$control instanceof Controls\CheckboxList && !$control instanceof Controls\RadioList) {
					$control->getControlPrototype()->addClass('d-inline-block');

					// But setting `display: inline-block` is not enough since the widgets will inherit
					// `width: 100%` from `.form-control` and end up wrapped anyway.
					// Let’s counter that using `width: auto`.
					$control->getControlPrototype()->addClass('w-auto');
					if ($control instanceof Controls\TextBase && $control->control->type === 'color') {
						// `input[type=color]` is a special case since `width: auto` would make it squish.
						$control->getControlPrototype()->addStyle('min-width', '3rem');
					}
				}

				// Also, we need to add some spacing between the label and the control.
				$control->getLabelPrototype()->addClass('me-2');
			}

			if ($control instanceof Controls\Button) {
				// Mark first form button (or the one provided) as primary.
				$markAsPrimary = $control === $this->primaryButton || (!isset($this->primaryButton) && $control->parent instanceof Form);
				if ($markAsPrimary) {
					$class = 'btn btn-primary';
					$this->primaryButton = $control;
				} else {
					$class = 'btn btn-secondary';
				}
				$control->getControlPrototype()->addClass($class);
			} elseif ($control instanceof Controls\TextBase) {
				// `input` is generally a `.form-control`, except for `[type=range]`.
				if ($control->control->type === 'range') {
					$control->getControlPrototype()->addClass('form-range');
				} else {
					$control->getControlPrototype()->addClass('form-control');
				}

				// `input[type=color]` needs an extra class.
				if ($control->control->type === 'color') {
					$control->getControlPrototype()->addClass('form-control-color');
				}
			} elseif ($control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
				// `select` needs a custom class.
				$control->getControlPrototype()->addClass('form-select');
			} elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
				// `input[type=checkbox]` and `input[type=radio]` need a custom class.
				$control->getControlPrototype()->addClass('form-check-input');

				// They also need to be individually wrapped in `div.form-check`.
				$control->getSeparatorPrototype()
					->setName('div')
					->appendAttribute('class', 'form-check')
					// They support being displayed inline with `.form-check-inline`.
					// https://getbootstrap.com/docs/5.0/forms/checks-radios/
					// But do not add the class for `Controls\Checkbox` since a single checkbox
					// can be inlined just fine and the class adds unnecessary `margin-right`.
					->appendAttribute('class', 'form-check-inline', $this->layout === FormLayout::INLINE && !$control instanceof Controls\Checkbox);

				// Labels of individual checkboxes/radios also need a special class.
				if ($control instanceof Controls\Checkbox) {
					// For `Controls\Checkbox` there is only the label of the control.
					$control->getLabelPrototype()->addClass('form-check-label');
				} else {
					$control->getItemLabelPrototype()->addClass('form-check-label');
				}
			}
		}
	}
}
