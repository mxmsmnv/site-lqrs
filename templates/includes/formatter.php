<?
function formatContent(?string $content): string {
	if (empty($content)) {
		return '';
	}
	
	$content = preg_replace(
		'/<p>(?!\s*<(blockquote|iframe|div class="fb-post"))/',
		'<p class="mb-4 text-base sm:text-lg leading-normal">',
		$content
	);
	
	$content = preg_replace(
		'/<figure[^>]*>(\s*)<img([^>]*)>(\s*)<figcaption[^>]*>(.*?)<\/figcaption>(\s*)<\/figure>/i',
		'<figure class="w-full relative h-auto p-2 border border-stone-200 rounded-md max-w-xl mx-auto my-4"><img$2 class="rounded-md w-full h-auto"><figcaption class="mt-2 text-xs text-center text-stone-500">$4</figcaption></figure>',
		$content
	);
	
	$content = preg_replace(
		'/<figure[^>]*>(\s*)<img([^>]*)>(\s*)<\/figure>/i',
		'<figure class="w-full relative h-auto p-2 border border-stone-200 rounded-md max-w-xl mx-auto my-4"><img$2 class="rounded-md w-full h-auto"></figure>',
		$content
	);
	
	$content = preg_replace(
		'/<a(?![^>]*class=)/', 
		'<a class="underline underline-offset-2 hover:no-underline text-blue-700 decoration-blue-500"', 
		$content
	);
	
	$content = preg_replace(
		'/target="_blank"/', 
		'target="_blank" rel="noopener noreferrer"', 
		$content
	);

	$content = preg_replace(
		'/<a([^>]*?)target="_blank"([^>]*?)>(.*?)<\/a>/',
		'<a$1target="_blank"$2>$3 <svg class="inline-block w-4 h-4 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></a>',
		$content
	);

	$content = preg_replace(
		'/<h2>/', 
		'<h2 class="text-xl sm:text-2xl font-bold mb-4 text-stone-900">', 
		$content
	);

	$content = preg_replace(
		'/<h3>/', 
		'<h3 class="text-lg sm:text-xl font-semibold mb-4 text-stone-900">', 
		$content
	);

	$content = preg_replace(
		'/<ul>/', 
		'<ul class="flex flex-col space-y-3 mb-5 list-none">', 
		$content
	);

	$content = preg_replace(
		'/<li>/', 
		'<li class="flex items-start gap-2 text-base sm:text-lg"><span class="mr-2 text-stromboli-700">&mdash;</span><span class="flex-1">', 
		$content
	);

	$content = preg_replace(
		'/<\/li>/', 
		'</span></li>', 
		$content
	);

	return $content;
}

if (isset($page) && $page->body) {
	$page->body = formatContent($page->body);
}