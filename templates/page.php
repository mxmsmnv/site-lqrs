<? namespace ProcessWire; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?=$page->title; ?></title>
		<script src="//unpkg.com/alpinejs" defer></script>
		<script src="https://cdn.tailwindcss.com"></script>
		<? include "includes/head.php"; ?>
		<? include "includes/formatter.php"; ?>
	</head>
	<body>
		<? include "includes/header.php"; ?>
			<section class="max-w-screen-xl mx-auto my-8">
			<div class="p-4">
				<h1 class="text-3xl sm:text-6xl leading-none font-bold text-stone-900 text-center"><?=$page->title; ?></h1>
				
				<div class="my-4">
					<?php if (!empty($page->summary)): ?><div class="max-w-screen-lg mx-auto text-center text-base sm:text-lg font-normal text-stone-600 mb-4"><?=$page->summary; ?></div><?php endif; ?>
				</div>
			</div>
			<div class="p-4">
				<div class="mt-2">
					<div class="max-w-screen-lg text-base sm:text-lg font-normal text-stone-600"><?=$page->body; ?></div>
				</div>
			</div>
		</section>
		<? include "includes/footer.php"; ?>
	</body>
</html>
