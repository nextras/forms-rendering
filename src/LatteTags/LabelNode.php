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
use Nette\Bridges\FormsLatte\Nodes\LabelNode as NetteLabelNode;
use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;


abstract class LabelNode extends NetteLabelNode
{
	public function print(PrintContext $context): string
	{
		return $context->format(
			($this->name instanceof StringNode
				? 'if ($ʟ_label = end($this->global->formsStack)[%node]->'
				: '$ʟ_input = is_object($ʟ_tmp = %node) ? $ʟ_tmp : end($this->global->formsStack)[$ʟ_tmp]; if ($ʟ_label = $ʟ_input->')
			. ($this->part ? ('getLabelPart(%node)') : 'getLabel()')
			. ') echo ' . get_class() . '::label($ʟ_label'
			. ($this->attributes->items ? '->addAttributes(%2.node)' : '')
			. ($this->void ? ' %3.line, $ʟ_label, %2.var);' : '->startTag() %3.line, $ʟ_label, %2.var); %4.node if ($ʟ_label) echo $ʟ_label->endTag() %5.line;'),
			$this->name,
			$this->part,
			$this->attributes,
			$this->position,
			$this->content,
			$this->endLine
		);
	}


	public static function label(Html $label, BaseControl $control, bool $isSubItem): Html
	{
		return $label;
	}
}
