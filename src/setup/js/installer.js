/**
 * WackoWiki installer
 *
 * All installer behaviour lives in this file. The installer must not use
 * inline scripts or inline event handlers, because the Content-Security-Policy
 * of the application forbids them (script-src-elem / script-src-attr).
 *
 * Configuration is passed through data-* attributes:
 *
 *   form[data-msg-no-driver]       message when no database driver is selected
 *   form[data-msg-confirm-delete]  message for the table deletion confirmation
 *   form[data-pwd-min-chars]       minimum length of the admin password
 *   form[data-msg-pwd-short]       message for a too short admin password
 *   form[data-msg-pwd-mismatch]    message for two different passwords
 *
 *   input[type=radio][data-submit-action]  reloads the form with that action
 *   [data-action="reload"]                  reloads the current page
 *   [data-action="back"]                    returns to the previous page
 */
(function () {
	'use strict';

	function attr(element, name, fallback) {
		var value = element.getAttribute(name);

		return (value === null || value === '') ? (fallback || '') : value;
	}

	/* ------------------------------------------------------------------ */
	/* validation                                                          */
	/* ------------------------------------------------------------------ */

	function checkDatabaseForm(form) {
		var drivers = form.elements['config[db_driver]'];
		var selected = false;

		if (drivers) {
			if (typeof drivers.value === 'undefined') {
				// array of radio boxes
				for (var i = 0; i < drivers.length; i++) {
					if (drivers[i].checked) {
						selected = true;
						break;
					}
				}
			} else {
				// only one radio box available, it will already be selected
				selected = true;
			}
		}

		if (!selected) {
			window.alert(attr(form, 'data-msg-no-driver', 'Please select a database driver.'));

			return false;
		}

		var deleteTables = form.elements['config[DeleteTables]'];

		if (deleteTables && deleteTables.checked) {
			if (!window.confirm(attr(form, 'data-msg-confirm-delete', 'Do you really want to delete all existing tables?'))) {
				return false;
			}
		}

		return true;
	}

	function checkSiteForm(form) {
		var password = form.elements['password'];
		var password2 = form.elements['password2'];
		var minChars = parseInt(attr(form, 'data-pwd-min-chars', '0'), 10) || 0;

		if (password && password.value.length < minChars) {
			window.alert(attr(form, 'data-msg-pwd-short', 'The password is too short.'));

			return false;
		}

		if (password && password2 && password.value !== password2.value) {
			window.alert(attr(form, 'data-msg-pwd-mismatch', 'The passwords do not match.'));

			return false;
		}

		return true;
	}

	var validators = {
		config_database: checkDatabaseForm,
		config_site: checkSiteForm
	};

	/* ------------------------------------------------------------------ */
	/* actions                                                             */
	/* ------------------------------------------------------------------ */

	function initActions() {
		// delegated, because install_guard() adds buttons after the page was sent
		document.addEventListener('click', function (event) {
			var target = event.target;

			while (target && target !== document) {
				if (target.hasAttribute && target.hasAttribute('data-action')) {
					var action = target.getAttribute('data-action');

					if (action === 'reload') {
						event.preventDefault();
						window.location.reload();

						return;
					}

					if (action === 'back') {
						event.preventDefault();
						window.history.go(-1);

						return;
					}
				}

				target = target.parentNode;
			}
		});
	}

	/* ------------------------------------------------------------------ */
	/* radio buttons which reload the page                                 */
	/* ------------------------------------------------------------------ */

	function initAutoSubmit() {
		var radios = document.querySelectorAll('input[type="radio"][data-submit-action]');

		Array.prototype.forEach.call(radios, function (radio) {
			radio.addEventListener('change', function () {
				var form = radio.form;

				if (!form) {
					return;
				}

				form.action = radio.getAttribute('data-submit-action');

				// form.submit() does not fire the 'submit' event and does not
				// run constraint validation - same behaviour as the old inline
				// onClick handler (the MySQL fields are "required", switching
				// to SQLite must not be blocked by the browser).
				form.submit();
			});
		});
	}

	/* ------------------------------------------------------------------ */
	/* form validation on submit                                           */
	/* ------------------------------------------------------------------ */

	function initValidation() {
		var forms = document.querySelectorAll('form[name]');

		Array.prototype.forEach.call(forms, function (form) {
			if (!validators[form.name]) {
				return;
			}

			form.addEventListener('submit', function (event) {
				if (!validators[form.name](form)) {
					event.preventDefault();

					return false;
				}
			});
		});
	}

	function init() {
		initActions();
		initAutoSubmit();
		initValidation();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();