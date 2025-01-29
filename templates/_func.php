<?php namespace ProcessWire;

function sanitizeShortCode($input) {
    // Replace spaces with dashes
    $output = str_replace(' ', '-', $input);

    // Replace all unsafe characters with dashes (can be customized as needed)
    $output = preg_replace('/[^A-Za-z0-9-]/', '', $output); // removes anything that is not letters or digits

    // Convert everything to lowercase
    $output = strtolower($output);

    // Make sure the string is not empty and return the result
    return !empty($output) ? $output : null;
}


function handleShortUrl($page, $input, $sanitizer) {
	// Check if this is the home page (template 'home') and if there is a URL segment
	if ($page->template->name === 'home' && !$input->urlSegment1) {
		return; // Do not execute redirect if this is the home page and there is no URL segment
	}

	// Check if this is not a form submission for creating a short link
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		return; // If the request is POST, do not execute redirect
	}

	// Get the short code from different URL formats
	$requestedShort = '';

	// Check URL segment
	if ($input->urlSegment1) {
		$requestedShort = $input->urlSegment1;
	}
	// Check 'click' parameter
	elseif ($input->get('click')) {
		$requestedShort = $input->get('click');
	}

	// Clean the short code
	$requestedShort = $sanitizer->text(trim($requestedShort));

	// If there is a short code
	if ($requestedShort) {
		// Search for the corresponding record
		$shortlink = $page->shortlinks->find("short=$requestedShort")->first();

		if ($shortlink) {
			// Increase the click counter
			$page->of(false);
			$shortlink->of(false);
			$shortlink->clicks += 1;
			$shortlink->save();

			// Perform the redirect to the target URL
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $shortlink->link);
			exit();
		}
	}

	// If nothing is found, throw a 404 error
	throw new Wire404Exception();
}
