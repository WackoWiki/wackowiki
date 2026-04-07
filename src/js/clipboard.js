/**
* Native Clipboard API using data-clipboard-target attribute
*/
document.addEventListener('DOMContentLoaded', () => {

	// Find ALL buttons that have the data-clipboard-target attribute
	const copyButtons = document.querySelectorAll('button[data-clipboard-target]');

	copyButtons.forEach(button => {

		button.addEventListener('click', async (event) => {
			event.preventDefault();

			// Get the target selector (e.g. "#token-pre")
			const targetSelector = button.getAttribute('data-clipboard-target');

			// Find the element to copy from
			const targetElement = document.querySelector(targetSelector);

			if (!targetElement) {
				console.error(`Target element "${targetSelector}" not found!`);
				return;
			}

			// Get the text to copy
			let textToCopy = '';

			// Smart detection: use .value for form elements, .textContent for everything else
			if (targetElement.tagName === 'TEXTAREA' || targetElement.tagName === 'INPUT') {
				textToCopy = targetElement.value.trim();
			} else {
				textToCopy = targetElement.textContent.trim();
			}

			// If there's nothing to copy, do nothing
			if (!textToCopy) {
				console.warn('Nothing to copy – text is empty');
				return;
			}

			try {
				// The modern Clipboard API
				await navigator.clipboard.writeText(textToCopy);

				// Visual feedback
				const originalText = button.innerHTML;

				button.classList.add('copied');
				button.innerHTML = `✅ Copied!`;

				// Reset button after 2 seconds
				setTimeout(() => {
				button.classList.remove('copied');
				button.innerHTML = originalText;
				}, 2000);

				console.log('✅ Copied to clipboard:', textToCopy.substring(0, 30) + '...');

			} catch (err) {
				console.error('Failed to copy using Clipboard API:', err);

				// Fallback message
				const originalText = button.innerHTML;
				button.style.background = '#ef4444';
				button.innerHTML = `❌ Failed`;

				setTimeout(() => {
					button.style.background = '';
					button.innerHTML = originalText;
				}, 2000);
			}
		});
	});

	console.log('Clipboard API ready!');
});
