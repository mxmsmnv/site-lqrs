<? namespace ProcessWire; ?>
<? header("HTTP/1.0 404 Not Found"); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?=$page->title; ?></title>
		<meta name="description" content="<?=$page->summary; ?>">
		<script src="//unpkg.com/alpinejs" defer></script>
		<script src="https://cdn.tailwindcss.com"></script>
		<? include "includes/head.php"; ?>
		<? include "includes/formatter.php"; ?>
	</head>
	<body>
		<? include "includes/header.php"; ?>
		<section class="max-w-screen-xl mx-auto my-32">
			<div class="p-4">
				<h1 class="text-3xl sm:text-6xl leading-none font-bold text-stone-900 text-center"><?=$page->title; ?></h1>
				
				<div class="my-4 text-center text-base sm:text-lg font-normal text-stone-600">
					<?php if (!empty($page->body)): ?><?=$page->body; ?><?php endif; ?>
				</div>
			</div>
		</section>
		<? include "includes/footer.php"; ?>
	</body>
</html>
