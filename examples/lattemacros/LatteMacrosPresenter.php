<?php declare(strict_types = 1);

namespace NextrasDemos\FormsRendering\LatteMacros;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;


class LatteMacrosPresenter extends Presenter
{
	public function actionDefault()
	{
	}


	public function createComponentForm()
	{
		$form = new Form();
		$form->addText('text', 'Name');
		$form->addCheckbox('checkbox', 'Do you agree?');
		$form->addCheckboxList('checkbox_list', 'CheckboxList', ['A', 'B', 'C']);
		$form->addInteger('integer', 'How much?');
		$form->addMultiSelect('multi_select', 'MultiSelect', ['A', 'B', 'C']);
		$form->addPassword('password', 'Password');
		$form->addRadioList('radio_list', 'RadioList', ['1', '2', '3']);
		$form->addSelect('select', 'Select', ['Y', 'X', 'C']);
		$form->addTextArea('textarea', 'Textarea');
		$form->addMultiUpload('multi_upload', 'MultiUpload');
		$form->addSubmit('save', 'Send');
		$form->addSubmit('secondary', 'Secondary');

		$form->onSuccess[] = function ($form, $values) {
			dump($values);
		};
		return $form;
	}


	public function formatTemplateFiles(): array
	{
		return [__DIR__ . '/LatteMacrosPresenter.latte'];
	}
}
