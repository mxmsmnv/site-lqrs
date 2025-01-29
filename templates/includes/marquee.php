<?php
$messages = [
	[
		'text' => 'Last Sale',
	],
	[
		'text' => 'Cell Phones & Accessories',
		'url' => '/electronics/cell-phones-accessories/'
	],
	[
		'text' => 'Home Décor',
		'url' => '/home-garden-pets/home-decor/'
	]
];

function renderMessage($message) {
	if (!empty($message['url'])) {
		return sprintf(
			'<a href="%s" class="hover:text-stromboli-300">%s</a>',
			htmlspecialchars($message['url']),
			htmlspecialchars($message['text'])
		);
	}
	return htmlspecialchars($message['text']);
}
?>

<div class="relative flex overflow-x-hidden bg-mindaro-300 text-stromboli-700">
	<div class="animate-marquee whitespace-nowrap py-2">
		<?php foreach ($messages as $message): ?>
			<span class="mx-8"><?php echo renderMessage($message); ?></span>
		<?php endforeach; ?>
		<?php foreach ($messages as $message): ?>
			<span class="mx-8"><?php echo renderMessage($message); ?></span>
		<?php endforeach; ?>
	</div>

	<div class="absolute top-0 animate-marquee2 whitespace-nowrap py-2">
		<?php foreach ($messages as $message): ?>
			<span class="mx-8"><?php echo renderMessage($message); ?></span>
		<?php endforeach; ?>
		<?php foreach ($messages as $message): ?>
			<span class="mx-8"><?php echo renderMessage($message); ?></span>
		<?php endforeach; ?>
	</div>
</div>