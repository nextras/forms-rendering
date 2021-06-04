<?php declare(strict_types = 1);

namespace NextrasDemos\FormsRendering\Renderers;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nextras\FormsRendering\Renderers\Bs3FormRenderer;
use Nextras\FormsRendering\Renderers\Bs4FormRenderer;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;


class RenderersPresenter extends Presenter
{
	/**
	 * @var string
	 * @persistent
	 */
	public $renderer = 'bs3';

	/**
	 * @var bool
	 * @persistent
	 */
	public $showBulky = true;


	public function actionDefault()
	{
		$this->template->renderer = $this->renderer;
		$this->template->showBulky = $this->showBulky;
	}


	public function createComponentForm()
	{
		$form = new Form();
		$form->addText('text', 'Name');
		$form->addText('color', 'Color')->setHtmlType('color');
		$form->addCheckbox('checkbox', 'Do you agree?');
		$form->addCheckboxList('checkbox_list', 'CheckboxList', ['A', 'B', 'C']);
		$form->addInteger('integer', 'How much?');
		$form->addInteger('range', 'Up to eleven?')->setHtmlType('range');
		if ($this->showBulky) {
			$form->addMultiSelect('multi_select', 'MultiSelect', ['A', 'B', 'C']);
		}
		$form->addPassword('password', 'Password');
		$form->addRadioList('radio_list', 'RadioList', ['1', '2', '3']);
		$form->addSelect('select', 'Select', ['Y', 'X', 'C']);
		if ($this->showBulky) {
			$form->addTextArea('textarea', 'Textarea');
		}
		$form->addMultiUpload('multi_upload', 'MultiUpload');
		$form->addSubmit('save', 'Send');
		$form->addSubmit('secondary', 'Secondary');

		if ($this->renderer === 'bs3') {
			$form->setRenderer(new Bs3FormRenderer());
		} elseif ($this->renderer === 'bs4h') {
			$form->setRenderer(new Bs4FormRenderer(FormLayout::HORIZONTAL));
		} elseif ($this->renderer === 'bs4v') {
			$form->setRenderer(new Bs4FormRenderer(FormLayout::VERTICAL));
		} elseif ($this->renderer === 'bs4i') {
			$form->setRenderer(new Bs4FormRenderer(FormLayout::INLINE));
		} elseif ($this->renderer === 'bs5h') {
			$form->setRenderer(new Bs5FormRenderer(FormLayout::HORIZONTAL));
		} elseif ($this->renderer === 'bs5v') {
			$form->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
		} elseif ($this->renderer === 'bs5i') {
			$form->setRenderer(new Bs5FormRenderer(FormLayout::INLINE));
		}

		$form->onSuccess[] = function ($form, $values) {
			dump($values);
		};
		return $form;
	}


	public function formatTemplateFiles(): array
	{
		return [__DIR__ . '/RenderersPresenter.latte'];
	}
}
