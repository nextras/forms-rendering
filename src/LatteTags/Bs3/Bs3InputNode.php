<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms-rendering
 */

namespace Nextras\FormsRendering\LatteTags\Bs3;

use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Controls\CheckboxList;
use Nette\Forms\Controls\RadioList;
use Nette\Utils\Html;
use Nextras\FormsRendering\LatteTags\InputNode as BaseInputNode;


class Bs3InputNode extends BaseInputNode
{
	public static function input(Html $input, BaseControl $control, bool $isSubItem): Html
	{
		static $inputControls = ['radio', 'checkbox', 'file', 'hidden', 'range', 'image', 'submit', 'reset'];
		$name = $input->getName();
		if (
			$name === 'select' ||
			$name === 'textarea' ||
			($name === 'input' && !in_array($input->type, $inputControls, true))
		) {
			$input->addClass('form-control');
		} elseif ($name === 'input' && ($input->type === 'submit' || $input->type === 'reset')) {
			$input->setName('button');
			$input->addHtml($input->value);
			$input->addClass('btn');
		} elseif (($control instanceof RadioList) && !$isSubItem) {
			$input = Html::el('div')->addAttributes(['class' => 'radio'])->addHtml($input);
		} elseif (($control instanceof CheckboxList) && !$isSubItem) {
			$input = Html::el('div')->addAttributes(['class' => 'checkbox'])->addHtml($input);
		}

		return $input;
	}
}
