<?php

use Kirby\Cms\Page;

return [
	...require dirname(__DIR__) . '/routes/buy.php',
	...require dirname(__DIR__) . '/routes/docs.php',
	...require dirname(__DIR__) . '/routes/legacy.php',
	...require dirname(__DIR__) . '/routes/plugins.php',
	...require dirname(__DIR__) . '/routes/releases.php',
	[
		'pattern' => '.well-known/security.txt',
		'action'  => fn () => go('security.txt')
	],
	[
		'pattern' => 'cdn/info',
		'action'  => fn () => kirby()->request()->headers()
	],
	[
		'pattern' => 'hooks/clean',
		'method'  => 'GET|POST',
		'action'  => function () {
			$key = option('keys.hooks');

			if (empty($key) === false && get('key') === $key) {
				kirby()->cache('diffs')->flush();
				kirby()->cache('meet')->flush();
				kirby()->cache('pages')->flush();
				kirby()->cache('reference')->flush();
			}

			go();
		}
	],
	[
		'pattern' => 'pixels',
		'action'  => fn () => new Page([
			'slug'     => 'pixels',
			'template' => 'pixels',
			'content'  => [
				'title' => 'Pixels'
			]
		])
	]
];
