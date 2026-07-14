<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms-rendering
 */

namespace Nextras\FormsRendering\LatteTags;

use Latte\Compiler\PrintContext;
use Nette\Bridges\FormsLatte\Nodes\InputNode as NetteInputNode;
use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;


abstract class InputNode extends NetteInputNode
{
	public function print(PrintContext $context): string
	{
		$class = static::class;
		$hasForms33 = method_exists(\Nette\Bridges\FormsLatte\Runtime::class, 'renderFormBegin');
		$input = $hasForms33 ? 'Nette\Bridges\FormsLatte\Runtime::item(%node, $this->global)' : '$this->global->forms->get(%node);';
		return $context->format(
			'$ʟ_input = ' . $input
			. 'echo ' . $class . '::input($ʟ_input->'
			. ($this->part ? ('getControlPart(%node)') : 'getControl()')
			. ($this->attributes->items ? '->addAttributes(%2.node)' : '')
			. ' , $ʟ_input, %3.dump) %4.line;',
			$this->name,
			$this->part,
			$this->attributes,
			$this->part != null,
			$this->position,
		);
	}


	public static function input(Html $input, BaseControl $control, bool $isSubItem): Html
	{
		return $input;
	}
}
