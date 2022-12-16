<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms-rendering
 */

namespace Nextras\FormsRendering\LatteTags\Bs3;

use Latte\Extension;


class Bs3FormsExtension extends Extension
{
	public function getTags(): array
	{
		return [
			'label' => [Bs3LabelNode::class, 'create'],
			'input' => [Bs3InputNode::class, 'create'],
		];
	}
}
