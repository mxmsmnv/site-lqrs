<?php
	$footerData = [
		'copyright' => [
			'year' => date('Y'),
			'text' => 'All Rights Reserved'
		]
	];
	
	$footerData['social'] = [
		[
			'name' => 'Facebook',
			'url' => 'https://facebook.com/',
			'icon' => 'logo-facebook'
		],
		[
			'name' => 'X (Twitter)',
			'url' => 'https://x.com/',
			'icon' => 'logo-twitter'
		],
		[
			'name' => 'Youtube',
			'url' => 'https://youtube.com/',
			'icon' => 'logo-youtube'
		],
		[
			'name' => 'Instagram',
			'url' => 'https://instagram.com/',
			'icon' => 'logo-instagram'
		]
	];
	?>
<footer class="bg-white">
	<div class="max-w-screen-xl mx-auto">
		<div class="sm:mb-8 mb-2 mt-8 p-4 border-t border-stromboli-200 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
			<p class="text-base text-stromboli-600">
				&copy; <?= $footerData['copyright']['year'] ?> <?= htmlspecialchars($config['title'] ?? 'LQRS') ?>. <?= htmlspecialchars($footerData['copyright']['text']) ?>
			</p>
			<div class="flex items-center space-x-4">
				<?php if (!empty($footerData['social'])): ?>
				<?php foreach ($footerData['social'] as $social): ?>
				<?php if (!empty($social['url'])): ?>
				<a href="<?= htmlspecialchars($social['url']) ?>" class="text-stromboli-600 hover:text-mindaro-600 transition-colors" target="_blank" rel="noopener noreferrer" aria-label="<?= htmlspecialchars($social['name']) ?>">
					<ion-icon name="<?= htmlspecialchars($social['icon']) ?>" class="text-[24px]"></ion-icon>
				</a>
				<?php endif; ?>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</footer>
<noscript><img src="https://static.utqi.net/ingress/511644bd-5ecd-4b42-bbee-0f6342a638dc/pixel.gif"></noscript>
<script defer src="https://static.utqi.net/ingress/511644bd-5ecd-4b42-bbee-0f6342a638dc/script.js"></script>

