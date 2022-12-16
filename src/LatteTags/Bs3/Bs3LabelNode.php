<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms-rendering
 */

namespace Nextras\FormsRendering\LatteTags\Bs3;

use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;
use Nextras\FormsRendering\LatteTags\LabelNode as BaseLabelNode;


class Bs3LabelNode extends BaseLabelNode
{
	public static function label(Html $label, BaseControl $control, bool $isSubItem): Html
	{
		if ($label->getName() === 'label' && !$isSubItem) {
			$label->addClass('control-label');
		}
		return $label;
	}
}
