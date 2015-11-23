/**
 * @author th
 */

/** @param {jQuery} $ jQuery Object */
!function($, window, document, _undefined)
{
	if (typeof ThemeHouse === "undefined") ThemeHouse = {};

	ThemeHouse.PostTitlesQuickReply = function($form)
	{
		$form.data('QuickReply', this).bind(
		{
			/**
			 * Fires after the AutoValidator form has successfully validated the AJAX submission
			 *
			 * @param event e
			 */
			AutoValidationComplete: function(e)
			{
				var $title = $('#QuickReply').find('input[name=post_title]');
				$title.val('');
			}
		});
	};

	XenForo.register('#QuickReply', 'ThemeHouse.PostTitlesQuickReply');
}
(jQuery, this, document);