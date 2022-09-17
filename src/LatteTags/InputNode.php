<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms-rendering
 */

namespace Nextras\FormsRendering\LatteTags;

use Latte\Compiler\Nodes\Php\Scalar\StringNode;
use Latte\Compiler\PrintContext;
use Nette\Bridges\FormsLatte\Nodes\InputNode as NetteInputNode;
use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;


abstract class InputNode extends NetteInputNode
{
	public function print(PrintContext $context): string
	{
		$class = get_class();
		return $context->format(
			($this->name instanceof StringNode
				? '$ʟ_input = end($this->global->formsStack)[%node]; echo ' . $class . '::input($ʟ_input->'
				: '$ʟ_input = is_object($ʟ_tmp = %node) ? $ʟ_tmp : end($this->global->formsStack)[$ʟ_tmp]; echo ' . $class . '::input($ʟ_input->')
			. ($this->part ? ('getControlPart(%node)') : 'getControl()')
			. ($this->attributes->items ? '->addAttributes(%2.node)' : '')
			. ' %3.line, $ʟ_input, %2.var);',
			$this->name,
			$this->part,
			$this->attributes,
			$this->position,
		);
	}


	public static function input(Html $input, BaseControl $control, bool $isSubItem): Html
	{
		return $input;
	}
}
