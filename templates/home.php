<?php namespace ProcessWire;

$redirectpage = "home"; // target page to create short code

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // honeypot
    if (!empty($_POST['lqrs'])) {
        $error = "Something went wrong, please try again later.";
    } else {
        // validation
        $link = $sanitizer->url($_POST['link']);
        $short = $sanitizer->text($_POST['short']);
        $title = $sanitizer->text($_POST['title']);
        $description = $sanitizer->text($_POST['description']);

        // Применение функции для безопасного преобразования short
        $short = sanitizeShortCode($short);

        // check if short code is available
        $homePage = $pages->get("template=$redirectpage");
        if (!empty($short) && $homePage->shortlinks->find("short=$short")->count() > 0) {
            $error = "This short code is already taken. Please choose another one.";
        }
        
        // generate short code if not provided
        elseif (empty($short)) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            do {
                $short = '';
                for ($i = 0; $i < 5; $i++) {
                    $short .= $characters[rand(0, strlen($characters) - 1)];
                }
            } while ($homePage->shortlinks->find("short=$short")->count() > 0);
        }

        // check if URL is valid
        if (!isset($error) && !filter_var($link, FILTER_VALIDATE_URL)) {
            $error = "Invalid URL";
        }

        if (!isset($error)) {
            try {
                $page = $pages->get("template=$redirectpage");
                if (!$page->id) {
                    throw new Exception("Page with template '$redirectpage' not found");
                }

                $page->of(false);

                // Create new short link item
                $newItem = $page->shortlinks->getNew();
                $newItem->link = $link;
                $newItem->short = $short;
                $newItem->clicks = 0;

                // Set additional metadata
                $newItem->title = $title;
                $newItem->description = $description;

                // Add the new short link to the field
                $page->shortlinks->add($newItem);
                $pages->saveField($page, 'shortlinks');

                $success = "Short URL created: " . $homePage->httpUrl . $short;
            } catch (Exception $e) {
                $error = "Error while saving: " . $e->getMessage();
            }
        }
    }
}

$goPage = $pages->get("template=$redirectpage");

// Redirect functionality
handleShortUrl($page, $input, $sanitizer); // redirect function
?>

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
	<section class="max-w-screen-xl mx-auto py-8">
		<div class="p-4">
			<h1 class="text-3xl sm:text-6xl leading-none font-bold text-stone-900 text-center"><?=$page->get('title')?></h1>
			<div class="my-4">
				<?php if (!empty($page->summary)): ?>
				<div class="max-w-screen-md mx-auto text-center text-base sm:text-lg font-normal text-stone-600 mb-4"><?=$page->summary?></div>
				<?php endif; ?>
			</div>
			<?php if($user->isSuperuser()): ?>
			<div class="overflow-x-auto my-8 border-2 bg-mustard-50 border-mindaro-500 rounded-lg">
				<?php 
				// Get last 7 items, sorted by newest first
				$recentLinks = $goPage->shortlinks->reverse()->slice(0, 7); if(count($recentLinks)): ?>
				<table class="min-w-full divide-y divide-mindaro-400">
					<thead class="bg-mindaro-200">
						<tr>
							<th scope="col" class="px-6 py-3 text-left font-medium text-stromboli-500 uppercase tracking-wider">
								Code
							</th>
							<th scope="col" class="px-6 py-3 text-left font-medium text-stromboli-500 uppercase tracking-wider">
								Short URL
							</th>
							<th scope="col" class="px-6 py-3 text-left font-medium text-stromboli-500 uppercase tracking-wider">
								Original URL
							</th>
							<th scope="col" class="px-6 py-3 text-center font-medium text-stromboli-500 uppercase tracking-wider">
								Clicks
							</th>
							<th scope="col" class="px-6 py-3 text-center font-medium text-stromboli-500 uppercase tracking-wider">
								Copy
							</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-mindaro-400">
						<?php foreach($recentLinks as $item): ?>
						<tr class="hover:bg-mindaro-50">
							<td class="px-6 py-4 whitespace-nowrap text-stromboli-500">
								<div class="max-w-xs truncate">
									<?= $item->short ?>
								</div>
							</td>
							<td class="px-6 py-4 whitespace-nowrap">
								<div class="max-w-xs truncate">
									<a href="<?= $pages->get('template=' . $redirectpage)->url . $item->short ?>" class="text-blue-600 hover:text-blue-900" target="_blank">
										<?= $pages->get('template=' . $redirectpage)->httpUrl . $item->short ?>
									</a>
								</div>
							</td>
							<td class="px-6 py-4">
								<div class="max-w-xs truncate">
									<a href="<?= $item->link ?>" class="text-blue-600 hover:text-blue-900" target="_blank" title="<?= $item->link ?>">
										<?= $item->link ?>
									</a>
								</div>
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-center"><?= $item->clicks ?></td>
							<td class="px-6 py-4 whitespace-nowrap text-center">
								<button class="copy-btn bg-stromboli-500 hover:bg-stromboli-700 text-white font-bold py-1 px-3 rounded" data-url="<?= $pages->get('template=' . $redirectpage)->httpUrl . $item->short ?>">
									Copy
								</button>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php else: ?>
				<p class="text-stromboli-600 p-8 text-center text-lg">No short URLs created yet.</p>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		<!-- -->
		<form method="POST" action="" class="flex flex-col w-full my-12 max-w-screen-lg mx-auto">
			<div class="mb-6">
				<?php if(isset($error)): ?>
				<div class="w-full bg-red-100 border border-red-400 text-red-700 px-7 py-6 rounded">
					<pre class="whitespace-pre-wrap"><?= htmlspecialchars($error) ?></pre>
				</div>
				<?php endif; ?>
				<?php if(isset($success)): ?>
				<div class="w-full bg-green-100 border border-green-400 text-green-700 px-7 py-6 rounded flex items-center justify-between">
					<span><?= htmlspecialchars($success) ?></span>
					<button class="copy-new-url bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded ml-4 transition-colors" data-url="<?= $pages->get('template=' . $redirectpage)->httpUrl . $short ?>">
						Copy
					</button>
				</div>
				<?php endif; ?>
			</div>
			<div class="flex flex-col md:flex-row gap-4">
				<div class="w-full md:w-[49%] relative">
					<div class="absolute top-3 left-3 flex items-center text-stromboli-500">
						<label for="link" class="block text-xs font-medium uppercase">URL</label>
					</div>
					<input type="url" id="link" name="link" class="block w-full bg-mustard-50 rounded border border-stromboli-300 pt-8 pb-2 px-3 h-[60px] placeholder:text-stone-400 placeholder:text-sm focus:outline-1 focus:outline-mindaro-500" placeholder="https://lqrs.com" required />
				</div>
				<div class="w-full md:w-[29%] relative">
					<div class="absolute top-2.5 left-3 flex items-center text-stromboli-500">
						<label for="short" class="block text-xs font-medium uppercase">Short Code</label>
					</div>
					<input type="text" id="short" name="short" class="block w-full bg-mustard-50 rounded border border-stromboli-300 pt-8 pb-2 px-3 h-[60px] placeholder:text-stone-400 placeholder:text-sm focus:outline-1 focus:outline-mindaro-500" placeholder="Optional" />
						<input type="text" name="lqrs" value="" style="display:none;">
				</div>
				<div class="w-full md:w-[19%]">
					<button type="submit" class="w-full rounded bg-stromboli-600 px-6 h-[60px] text-center text-base font-bold text-white hover:bg-mindaro-600">
						Create
					</button>
				</div>
			</div>
		</form>
		<!-- // -->
		</div>
		<div class="p-4">
			<div class="mt-2">
				<div class="max-w-screen-lg mx-auto text-base sm:text-lg font-normal text-stone-500"><?=$page->body; ?></div>
			</div>
		</div>
	</section>
	<? include "includes/footer.php"; ?>
	<script>
		document.querySelectorAll(".copy-btn").forEach((button) => {
			button.addEventListener("click", async () => {
				const url = button.dataset.url;
				try {
					await navigator.clipboard.writeText(url);
					const originalText = button.textContent;
					button.textContent = "Copied";
					button.classList.remove("bg-stromboli-500", "hover:bg-stromboli-700");
					button.classList.add("bg-mindaro-500", "hover:bg-mindaro-700");
					setTimeout(() => {
						button.textContent = originalText;
						button.classList.remove("bg-mindaro-500", "hover:bg-mindaro-700");
						button.classList.add("bg-stromboli-500", "hover:bg-stromboli-700");
					}, 2000);
				} catch (err) {
					console.error("Failed to copy:", err);
				}
			});
		});
		document.querySelectorAll(".copy-new-url").forEach((button) => {
			button.addEventListener("click", async () => {
				const url = button.dataset.url;
				try {
					await navigator.clipboard.writeText(url);
					const originalText = button.textContent;
					button.textContent = "Copied";
					button.classList.remove("bg-stromboli-500", "hover:bg-stromboli-700");
					button.classList.add("bg-mindaro-500", "hover:bg-mindaro-700");
					setTimeout(() => {
						button.textContent = originalText;
						button.classList.remove("bg-mindaro-500", "hover:bg-mindaro-700");
						button.classList.add("bg-stromboli-500", "hover:bg-stromboli-700");
					}, 2000);
				} catch (err) {
					console.error("Failed to copy:", err);
				}
			});
		});
	</script>
</body>
</html>