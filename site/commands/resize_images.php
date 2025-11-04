<?php

use Kirby\Filesystem\Dir;

ini_set('memory_limit', '4G');

return [
	'description' => 'Resize Images',
	'args' => [],
	'command' => static function ($cli): void {
		kirby()->impersonate('kirby');
		$files = kirby()->site()->index(true)->files();
		$i = 1;

		$root = kirby()->root() . '/' . 'to-resize';
		Dir::make($root);

		$resized = 0;
		foreach ($files as $file) {
			try {
				$orientation = $file->orientation();
				$height = $file->height();
				$width = $file->width();
				$oldRoot = $file->root();

				$fileInfo = sprintf('%s [%dx%d] [%s]', $file->id(), $width, $height, $orientation);

				if ($orientation === 'portrait' && $width > 1440) {
					$new = $file->resize(1440)->save();
					$cli->out($fileInfo);
					copy($new->root(), $oldRoot);

					$resized++;
				} elseif ($width > 2560) {
					$new = $file->resize(2560)->save();
					$cli->out($fileInfo);
					copy($new->root(), $oldRoot);

					$resized++;
				} else {
				}
			} catch (Exception $e) {
				$cli->error(sprintf('%s [%s]', $file->id(), $e->getMessage()));
			}

			$i++;
		}

		$cli->success(sprintf('Successfully resized [%s] files.', $resized));
	}
];
