<?
$menuItems = $pages->find("parent=/,status=1,sort=sort");

function renderMenu($pages, $isMobile = false) {
	foreach($pages as $page) {
		$children = $page->children("status=1,sort=sort");
		
		if($children->count > 0) {
			// Dropdown menu
			if(!$isMobile) {
				?>
				<div x-data="{ open: false }" class="relative">
					<button @click="open = !open" class="flex items-center hover:text-stromboli-300">
						<?= $page->title ?>
						<svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
						</svg>
					</button>
					<div x-cloak x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 bg-white text-stone-700 rounded shadow-lg">
						<?php foreach($children as $child): ?>
							<a href="<?= $child->url ?>" class="block px-4 py-2 hover:bg-stone-100"><?= $child->title ?></a>
						<?php endforeach; ?>
					</div>
				</div>
				<?php
			} else {
				?>
				<div x-data="{ open: false }">
					<button aria-label="Menu" @click="open = !open" class="flex items-center hover:text-stromboli-300 w-full text-left">
						<?= $page->title ?>
						<svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
						</svg>
					</button>
					<div x-cloak x-show="open" class="pl-4 mt-2 space-y-2">
						<?php foreach($children as $child): ?>
							<a href="<?= $child->url ?>" class="block hover:text-stromboli-300"><?= $child->title ?></a>
						<?php endforeach; ?>
					</div>
				</div>
				<?php
			}
		} else {
			// Simple link
			?>
			<a href="<?= $page->url ?>" class="hover:text-stromboli-300"><?= $page->title ?></a>
			<?php
		}
	}
}
$homepage = $pages->get('/');
?>
	<style>[x-cloak] { display: none !important; }</style>
	<header x-cloak x-data="{ isOpen: false }" class="bg-white text-stromboli-500 relative z-40">
		<div class="container max-w-screen-xl mx-auto">
			<div class="flex items-center justify-between p-4 border-b border-stromboli-200">
				<div class="text-2xl font-bold truncate">
					<a href="/"><img class="size-12" src="/site/templates/assets/logo.svg" alt="<?= htmlspecialchars($config['title'] ?? 'LQRS') ?>"></a>
				</div>
				<!-- mobile menu (button) -->
				<div class="md:hidden">
					<button aria-label="Menu" @click="isOpen = !isOpen" class="text-stromboli-500 focus:outline-none">
						<svg class="h-8 w-8 transition-transform duration-300" :class="{'rotate-45': isOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path :class="{'hidden': isOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
							<path :class="{'hidden': !isOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
						</svg>
					</button>
				</div>
				<!-- desktop menu -->
				<nav class="hidden md:flex space-x-6 text-base">
					<a href="/" class="hover:text-stromboli-300">Home</a>
					<?=renderMenu($menuItems, false); ?>
					<?php if($user->isSuperuser()): ?>
					<a href="<?=$config->urls->admin?>" class="rounded uppercase font-bold text-sm bg-rose-600 text-white hover:bg-stromboli-600 border border-rose-500 hover:border-stromboli-600 px-2 py-0.5"><?=$config->urls->admin?></a>
					<?php endif; ?>
				</nav>
			</div>
			<!-- mobile menu (hover) -->
			<div x-show="isOpen" @click.away="isOpen = false" class="md:hidden">
				<nav class="flex flex-col space-y-2 p-4 text-lg">
					<a href="/" class="hover:text-stromboli-300">Home</a>
					<?=renderMenu($menuItems, true); ?>
					<a href="<?=$config->urls->admin?>" class="text-rose-600 hover:text-rose-300"><?=$config->urls->admin?></a>
				</nav>
			</div>
		</div>
	</header>
