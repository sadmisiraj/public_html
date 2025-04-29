=== Cost Calculator Builder PRO ===

Contributors: StylemixThemes
Donate link: https://stylemixthemes.com/
Tags: cost calculator, calculator, calculator form builder
Requires at least: 4.6
Tested up to: 6.7.2
Stable tag: 3.2.26
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Changelog ==

= 3.2.26 =
 - Enhancement: Added the ability to toggle the display of the Order ID in user emails and on the Confirmation Page.
 - Fix: The "2 columns" page setting now works only if the "Show summary block on the last page of multi-step calculator" option is enabled in the Page Breaker settings.
 - Fix: Fixed an issue where product meta prices were not working correctly with the "Show summary block on the last page of multi-step calculator" setting.
 - Fix: Resolved a bug where page break navigation would break when the "Show summary block on the last page of multi-step calculator" setting was enabled.
 - Fix: Fixed an issue where some hidden totals were still visible in the WooCommerce Cart and Checkout.

= 3.2.25 =
 - Enhancement: Element options can now be disabled based on conditions.
 - Enhancement: Sticky Total: Now inherits the "Number of Decimals" from the selected total element if only one is chosen in Sticky settings. If multiple total elements are selected, it inherits the value from Settings → Currency → Number of Decimals
 - Fix: Fixed the issue where the dropdown list was not visible in geolocation elements when the sticky calculator was enabled.
 - Fix: Fixed the issue where the sticky calculator's sticky banner was not being disabled when the geolocation map popup was opened on the same page.
 - Fix: Fixed an issue where enabling PDF borders caused the creation of a second page.
 - Fix: Fixed an issue where orders were not being created if the Single Order Form settings were incomplete.
 - Fix: Optimized order creation time — orders for large calculators with complex calculations are now created instantly.
 - Fix: Fixed an issue where Checkbox and Switch Toggle option prices would break into multiple lines when using a lengthy option name.
 - Fix: Fixed an issue where the "Change Product Quantity Based on Calculator Fields" setting was still applying when disabled.

= 3.2.24 =
- Fix: Resolved an issue with the Sticky Calculator not displaying correctly with the Avada theme.
- Fix: Fixed the issue where the “any” value in conditions and conditions from one formula to another were not working.
- Fix: Resolved a problem where the Sticky Calculator opened and closed with visual bugs when the PDF Entries setting was turned off.
- Fix: Corrected the order total display in the PDF for multiselect elements.
- Fix: Fixed an issue where, with the “Zero Values in Orders, PDF Entries, Emails” setting disabled, formulas with a 0 value were still shown in Order details or WooCommerce orders.
- Fix: Corrected the Page Breaker not scrolling to the page start when navigating to the previous or next page with the “Progress with circle” and “Progress with bar” navigation styles.

= 3.2.23 =
- Fix: Fixed the calculator with Page Breaker not showing when “Show summary block on the last page of multi-step calculator” setting and click action “Pop up Order Form or Payments” were enabled. 
- Fix: Resolved an issue where “Show Summary with calculations after adding contact info” in the Order Form could be enabled with “Show total summary on the page” in Page Breaker being active.
- Fix: Corrected the Basic Slider not working or updating in Page Breaker when the “Show summary block on the last page of multi-step calculator” setting was enabled.
- Fix: Fixed an issue where enabling “Pop up Order Form or Payment” in Sticky Click Action resulted in a zero Total in Orders.
- Fix: Fixed Razorpay payments displaying as “No payment” in PDFs.

= 3.2.22 =
 - Enhancement: Added a new setting 'Collapse Group by Default' in Group Field.
 - Fix: Corrected accent color setting not affecting the “+” icon in the Repeater button.
 - Fix: Fixed misalignment of the Summary block in Page Breaker on product pages when “Show summary block on the last page of multi-step calculator” and “Show total summary on the page” settings are enabled.
 - Fix: Fixed Sticky Calculator displaying on all product pages instead of only selected products.
 - Fix: Resolved an issue with the File Upload saving duplicate files.
 - Fix: Corrected customer details not appearing in PDFs or Send Quote when using Razorpay as the payment method.
 - Fix: Updated warning texts in the Confirmation Page.
 - Fix: Fixed the issue preventing unauthorized users from uploading .cdr and .ai file types in File Upload.
 - Fix: Fixed minor element styling bugs.
 - Fix: Corrected minor Quick Tour issues in Mozilla Firefox.

= 3.2.21 =
- Enhancement: Added support for the .tif format in File Upload.
- Fix: Corrected Order ID not displaying in the Email Template Preview.
- Fix: Fixed a bug allowing conditions to be saved without selecting a second date for the Ranged Date Picker.
- Fix: Resolved a problem where dropdown options were not displayed at the end of page breaks.

= 3.2.20 =
 - Enhancement: Added a notice that appears when the "Actions after Submit" and "Click Action" settings are set to "Stay on Page" and "WooCheckout action after submit/WooCheckout action on WooProduct Page" respectively.
 - Enhancement: Made "Upload from URL" optional in the File Upload element.
 - Enhancement: Added missing translations for German, Italian, Spanish, French, and Portuguese to Pro plugin.
 - Fix: Fixed small text sizes in buttons on screens smaller than 1300px on the Conditions page.
 - Fix: Fixed an issue where the "Download PDF" option in Click Action did not generate and download the PDF document for the current calculator.
 - Fix: Fixed an issue where global settings were enabled, but values for the Order Form were applied from single settings.
 - Fix: Fixed payment methods displaying as enabled in Payment Gateways even when disabled via Payments.
 - Fix: Removed unnecessary dotted lines at the end of Email Templates.
 - Fix: Fixed issues with ABS, ROUND, POW, CEIL, MIN, and MAX methods in Formula displaying 0 in orders.
 - Fix: Fixed minor condition issues causing hidden formulas to be visible.

= 3.2.19 =
- Fix: Resolved an issue where the condition couldn't be applied to the Group element inside the Page Breaker.
- Fix: Corrected each new line in the Contact Form 7 message in Orders displayed as “n.”
- Fix: Fixed the issue with the pinned file icon appearing even when the File Upload field in the calculator was empty.
- Fix: Fixed a missing icon for the Add Discount button.
- Fix: Corrected the Geolocation element not showing the map.
- Fix: Fixed dynamic width sizes of the Make Order button on the Order Form.

= 3.2.18 =
- Enhancement: Introduced a setting to change the background color for the header in Email Template.
- Enhancement: Added an option to use forms from the Form Manager for payment methods without the Order Form.
- Fix: Resolved Group field elements resetting when values in element with conditions were changed.
- Fix: Corrected an issue where WooCommerce Meta elements couldn’t be selected if Group field/Repeater elements were inside Page Breaker.
- Fix: Fixed Back button in Page Breaker working incorrectly with conditions on the front page and Preview & Appearance.
- Fix: Removed unnecessary space in the footer on pages with Page Breaker.
- Fix: Resolved a problem where orders with the Cash Payment method were created with status "Completed."
- Fix: Corrected the issue where applied promo codes and discounts were not displayed throughout WooCommerce orders.
- Fix: Resolved an issue where the result showed as 0 in the Cart and Checkout when a Hidden Formula was included in another Formula.

= 3.2.17 =
- Enhancement: Added option to customize the border style in PDF documents and separately in the Order Block.
- Enhancement: Added "Line Style" setting for lines in PDF documents, specifically in the Order Block.
- Enhancement: Increased the character limit for Order Form buttons.
- Fix: Fixed resetting of elements in the Group field when values in a dependent element are changed.
- Fix: Resolved issues with displaying required fields within Group/Repeater and standalone fields.
- Fix: "Is required" text is now translatable in Loco Translate.
- Fix: Fixed design issues in Send Quote forms.
- Fix: Corrected elements in a Group resetting to zero when a Discount is added.
- Fix: Fixed minor bugs in Order Forms.
- Fix: Fixed "Invalid input" error for validated Name and Phone fields in forms.
- Fix: Corrected horizontal scrolling issue on mobile resolutions when “Terms and Conditions” is enabled.
- Fix: Fixed filter in Conditions not working with Page Breaker or Group elements in calculators.

= 3.2.16 =
- Enhancement: Improved user experience by adding focus movement to the selected element in the canvas under Conditions.
- Fix: Addressed a Wordfence vulnerability related to unauthenticated SQL Injection.
- Fix: Resolved an issue where users received order confirmations with Razorpay without completing a payment.
- Fix: Fixed an issue where the Formula element did not display the specified measuring unit in Orders, Order Details, WooCommerce Cart/Checkout, and PDFs.
- Fix: Fixed global Terms & Conditions settings not applying on the page.
- Fix: Corrected "Equal To" option in Discounts working incorrectly.

= 3.2.15 =
- Enhancement: Added customization of Font Size for all text blocks in PDF Builder.
- Fix: Resolved an issue where PayPal appeared as a payment option in Payment Gateways even when it was enabled globally but not within the calculator.
- Fix: Fixed a bug preventing Contact Form 7 forms from opening in Preview & Appearance.
- Fix: Resolved an issue where HTML elements and styles were not correctly applied to Hints in mobile view
- Fix: Fixed an issue where the default value in some input fields couldn't be removed.
- Fix: Fixed minor visual bugs.
- Fix: Resolved an issue where hidden Formula elements were visible in Orders during placement.
- Fix: Fixed a bug causing Calculator Summary Emails to display the Total as 0.
- Fix: Corrected an issue where Discounts were not applied when items were added to Cart.

= 3.2.14 =
- Fix: Fixed duplication of elements in Group field when two calculators with Group fields are on the same page.
- Fix: Corrected file duplication in File Upload after order confirmation.
- Fix: Fixed issue where orders weren’t submitted if a File Upload was inside a Repeater.
- Fix: Fixed missing alert pop-up when moving an element with a condition from Group field to Repeater.
- Fix: Corrected hidden formulas appearing in the Email Quote and Orders when “Send a quote and invoice to customer's email” is enabled.
- Fix: Fixed incorrect measuting unit symbol in the Order Confirmation email when the Measuring Unit is set.
- Fix: Resolved issue where elements in a Hidden group appeared in the Summary despite the Show condition.
- Fix: Fixed redirect issue to PayPal page if the Confirmation Page is not set to 'Same page as calculator' after placing an order.
- Fix: Corrected Discount calculation with problematic numbers, which previously caused the wrong Total.
- Fix: Fixed broken PDF in the Send Quote after checkout.
- Fix: Fixed minor visual bugs.

= 3.2.13 =
- Enhancement: Introduced the Default Values setting for Checkboxes, Dropdowns, and Radio buttons in Order Form.
- Enhancement: Added new fields to Order Form: Date Picker, Time Picker.
- Fix: Resolved an issue where conditions from the Page Breaker were not working properly in Preview & Appearance.
- Fix: Fixed alignment issues for Date Picker, Dropdown, Image Dropdown, and Time Picker elements on mobile in Preview & Appearance.
- Fix: Corrected minor text inconsistencies in Order Form.
- Fix: Fixed small bugs in Order Form.

= 3.2.12 =
- New feature: Introduced the ability to link Product Stock to the Cart quantity using WooCommerce hooks.
- Enhancement: Moved the "Email Quote" settings from the Order Form to a dedicated menu for better organization.
- Enhancement: Added option to customize the color for Download button text in Email Template settings.
- Fix: Resolved an issue where the "Go to Settings" button failed to navigate to the Payments tab in Global Settings.
- Fix: Corrected the functionality of “2 columns” setting on Page Breaker pages.
- Fix: Fixed an issue with elements being duplicated
- Fix: Fixed a problem with missing "Next" button when adding a Repeater in Page Breaker.
- Fix: Resolved an issue where PDFs with large amounts of data couldn’t display all fields properly.
- Fix: Fixed File Upload and Basic Slider elements not functioning correctly in Preview/Appearance mode.

= 3.2.11 =
- Enhancement: Made selecting a location required to create a Geolocation field.
- Enhancement: Enabled conditions for elements within a Group field and between elements in the same Group field.
- Enhancement: Added Multiselect support for Dropdown field in Order Form.
- Enhancement: Added a dedicated error message for the Email field in the Order Form when an invalid email format is entered.
- Enhancement: Introduced an option to show/hide the total in the PDF.

= 3.2.10 =
- Fix: Resolved an issue where the loader icon in the Total block overlapped the PDF Download and Quote buttons.
- Fix: Fixed the 'Zero Values in Orders, PDF Entries, Emails' setting in the Summary Block not working for File Upload fields.
- Fix: Addressed an issue where hiding a Repeater field in one Repeater also affected other Repeaters in the Summary.
- Fix: Fixed the Geolocation pop-up being cut off in the navigation when using the Astra theme.
- Fix: Corrected the Geolocation distance range calculation issue when the ranged price is set, but the value is zero.
- Fix: Resolved the 'Hide Condition' not working after switching options in a Radio field.
- Fix: Fixed the 'Required' tooltip appearing below the Validated form and Date Picker element titles.
- Fix: Addressed issues with conditions not working correctly in the Page Breaker.
- Fix: Fixed the Total Summary not appearing in Contact Form 7 if no formula is set.
- Fix: Resolved an issue where orders couldn’t be submitted if a Group field contained a hidden Required Validated Form element.

= 3.2.9 =
- Fix: Corrected total calculation when multiple formulas with "Hidden by default" and "Calculate hidden by default" settings are used within a common formula.
- Fix: Resolved issue where PDF contents were displayed before the calculator fully loaded.

= 3.2.8 =
- Enhancement: Introduced full customization options and new template designs for creating PDF entries.
- Update: Compatibility with WordPress 6.7

= 3.2.7 =
 - Fix: Fixed the issue where a different total was sent to Stripe than shown in the Summary calculator.
 - Fix: Corrected the malfunction of the "Hidden by default" and "Calculate hidden by default" settings in backend calculations.
 - Fix: Resolved the issue where payments were not processed when placing an order via Stripe and PayPal.
 - Fix: Fixed the error in global settings for Order Form & Payments, where PayPal displayed a "total cannot be 0" message.
 - Fix: Corrected the positioning of the popup button 'Close' in Geolocation, which was shifted downward.

= 3.2.6 =
- Fix: Resolved an issue where formulas within Group or in Page Breaker produced different results in Order and Confirmation Email.

= 3.2.5 =
- Enhancement: Added validation for Phone field in Order form to improve data accuracy.
- Enhancement: Introduced Sticky functionality for field settings in the Form Manager, enhancing user navigation.
- Enhancement: Made improvements to user experience and usability in Order Form.
- Fix: Resolved an issue with the Phone field, preventing the letter "e" from being entered.
- Fix: Fixed a bug where the total of item values was not calculated without the Formula element when processing payments via WooCommerce/Order Form/Payments.
- Fix: Corrected an issue where Order Details would not open when selecting the Payments option.
- Fix: Adjusted margin in Email field to ensure proper alignment across different width settings.

= 3.2.4 =
- Fix: Resolved an issue with Repeater element not displaying third Item in Cart.
- Fix: Fixed a problem when 'Add to Cart' button led to a blank page with 'Current Woo Product' setting.

= 3.2.3 =
 - Fix: Removed the extra dotted line that appeared in Email Template when adding Group field to the calculator.
 - Fix: Resolved an issue where elements in hidden group were still summed when hidden.
 - Fix: 'Calculate hidden by default' setting is now hidden in elements inside the Repeater.
 - Fix: Corrected an issue preventing order completion if a Group field contained hidden required elements.
 - Fix: Adjusted the height of the ‘Apply’ button to match the height of the promo code input field.
 - Fix: Corrected the alert about invalid promo codes overlapping with the input field.
 - Fix: Fixed an issue where elements from hidden groups were incorrectly displayed in Summary.
 - Fix: Now uploaded files are visible in Orders when paying via WooCommerce with Repeater and Group fields.
 - Fix: Fixed a problem where orders were created with value ‘auto’ in autoloads in the database.
 - Fix: Resolved an issue where calculators were not displayed on the page when added via Elementor widgets.

= 3.2.2 =
- Fix: Fixed Price manipulation vulnerability for enhanced security and integrity in calculations.
- Fix: Resolved an issue where the applied discount was not displayed when multiple discounts were created on the same formula.
- Fix: Fixed problems related to discount calculations involving multiple formulas in the final formula and applying promo codes correctly.

= 3.2.1 =
 - Enhancement: Added filters in Orders: Today, Week, Month, and custom date ranges for better order management.
 - Enhancement: Upgraded Range and Multi-Range settings with an option to display Range Value or Summary Value in the subtotal above the slider.
 - Enhancement: Middle-range selection in the Date Picker is now highlighted in a different color for clearer visual distinction from selected dates.
 - Enhancement: Upgraded the Date Picker with hovering over selected dates.
 - Fix: Resolved the issue where default values of tables were not translating in Orders.
 - Fix: Fixed untranslated "Open a map" and "Choose from map" lines in Geolocation.
 - Fix: Corrected the "Ranged price for distance" setting in Geolocation, ensuring floating point numbers are calculated accurately as decimals, not integers.
 - Fix: Fixed an issue where the Date Picker was not displayed inside a Group when the "Block Period" was removed in the "Make some days unselectable" setting.
 - Fix: Resolved the issue where exported orders used the calculator's Order ID instead of the actual Order IDs.
 - Fix: Fixed Date Picker not being displayed in the Summary within Orders.
 - Fix: Resolved the issue with unclickable checkboxes in both the dropdown menu of Embed Calculator and the WooProducts dropdown.
 - Fix: Resolved a display issue where an element inside the Repeater was shown in Total with the "Show in Total Grand" setting disabled.
 - Fix: Fixed disappearing images in Razorpay and Stripe payment settings after importing a calculator.
 - Fix: Fixed warning message related to third-party websites in Email message PDF.

= 3.2.0 =
Enhancement: Added Order Form Manager with 8 new fields: Input textbox, Text area, Number, Dropdown, Radio, Checkbox, Formatted text, Space (Pro).

= 3.1.99 =
- Enhancement: Smooth scrolling for Email Template preview in Global Settings.
- Fix: Uploaded file is not visible in Orders when paying through Order Forms.
- Fix: Status of created orders in Orders page is not changing.
- Fix: Color picker is displaced when opened in the Email Template tab of Global Settings.

= 3.1.98 =
- Fix: Name of value in the Multi-range element settings is not disabled when the Measuring unit setting is on.

= 3.1.97 =
- Enhancement: Scrolling in the Page Breaker is followed by Pagination, depending on which pages the user navigates to.
- Fix: When paying with WooCommerce, only the last added Repeater is displayed on Cart, Checkout, WooCommerce Orders pages.
- Fix: Orders are created and Confirmation page is opened with invalid data in the Order form.
- Fix: The position of Repeater in Summary is displayed incorrectly.
- Fix: After an order from the Orders section is deleted, it still remains in the database.

= 3.1.96 =
- Fix: After the Show condition is met, it is possible to select more options in the Checkbox/Toggle/Image Checkbox than the user has set in the element.
- Fix: The location of Currency in the final Total in Orders section is not changed.
- Fix: In some elements condition "Required" causes scrolling in mobile view.
- Fix: Icons change In Dropdown, Image Dropdown, and Time picker elements of the Page breaker/Group field.
- Fix: "Don't skip next to page" condition is not working with Switch toggle, Checkbox, and Image checkbox elements.
- Fix: When generating formulas with AI, an invalid value is displayed in Formula without elements.
- Fix: After deleting an element with a condition, all settings and data from input fields in Page disappear and new page settings cannot be set.

= 3.1.95 =
- Enhancement: Added Discounts information to the hook where orders are received by ID.
- Fix: When the "Don't skip next to next page" condition is selected, the Next button on previous pages becomes no longer available.
- Fix: The Required condition is not activated on pages with Page breaker, if the elements are in the Repeater/Group field.
- Fix: In the Page breaker with the "Jump to" action, you can select the page that you are currently viewing.
- Fix: If there is a hidden Required element, it is not possible to go to the next page until the Required element is revealed.
- Fix: Elements are duplicated in the Group field.

= 3.1.94 =
 - Fix: Terms & Condition and Calculate after submit sections do not load data from global settings in the calculator if enabled.
 - Fix: When generating a PDF file or viewing an order in the Orders page, the formula sequence is different from the calculator.
 - Fix: If there are too many elements, the last elements inside the Summary start to get lost.
 - Fix: Group elements are always displayed last in the PDF form of the Page Breaker section.
 - Fix: Backup modal is not visible in the Discount tab.
 - Fix: If you put Formula in Group field inside Page breaker, it is not displayed in Total field element.
 - Fix: Long text in File upload buttons goes over the edges of the button.

= 3.1.93 =
- Enhancement: Added AI helper/Formula generator to the Formula field.
- Fix: Errors in displaying values on Date picker, File upload, and Multi-range elements of WooCommerce Cart, Checkout, Confirmation, and Orders pages.
- Fix: After deleting a page in Page breaker with the “Jump to” action, a blank page remains selected.

= 3.1.92 =
- Enhancement: Added pop-up with warning when distance is over 4002km in Geolocation element.
- Enhancement: Added Integration types for PayPal payment method.
- Fix: When paying via Contact form 7 in Order form, if total is 0, Payment by Cash and PayPal do not appear.
- Fix: If you select the "Jump to" condition in Conditions Page break and choose the element which responds to the condition, the Back button stops working until the condition is met.
- Fix: In Date picker, the dates move out of the drop-down menu in Page breaker in Two columns page box style.
- Fix: Elements from Group field in Page break are not displayed in Formula.
- Fix: Contact Form 7 and PDF & Send Quote buttons are missing when there is a calculator with Order Form on the page.

= 3.1.91 =
 - Fix: Payments methods are not visible in Preview & Appearance.
 - Fix: Formula disappears from Total field elements after position change.
 - Fix: After moving an element to Group field/Repeater inside Page breaker, it doesn't display title/description/options.
 - Fix: You cannot delete elements inside the Page breaker in Group field/Repeater.
 - Fix: Inside the Page Breaker, the element is copied over the Page breaker or the wrong element is copied.
 - Fix: Elements are missing the hidden by default setting after they are moved to the Page breaker.
 - Fix: Image quality is reduced when displayed in Sticky banner/Floating button.
 - Fix: Links are not displayed in fields from Validated form (Email, URL) in Repeater when downloading PDF from Orders or submitting Send quote from Orders.
 - Fix: You cannot hide Summary with the setting Show summary block on the last page of multi-step calculator in Page breaker.

= 3.1.90 =
- Enhancement: Cost Calculator Pro is now available in Spanish, Portuguese, German, French, German and Italian.
- Fix: PDF and Send Quote buttons merge in mobile version in Preview & Appearance.
- Fix: Time picker is visible for the Formula element.
- Fix: After clicking on Save, Discounts list disappears.
- Fix: Send Quote form in the mobile version has no edge indentation at resolutions less than 420 pixels.
- Fix: In Two Columns of the Date picker element, the month/year selection in Preview & Appearance moves out of the way.
- Fix: Appearance in Validation form and Time picker is not applied to the dropdown menu.

= 3.1.89 =
- Enhancement: In the "Show Summary with calculations after adding contact info" setting, "Submit button text" and "Contact info form title" settings are now required to be filled.
- Fix: Calculator sends information as metadata, not as separate information that is bound to values in Stripe.
- Fix: A sticky banner is not displayed with custom images.
- Fix: In the Date picker in Two Columns dates move off when selecting month/year on the page.
- Fix: In Date Picker when selecting month/year in the mobile version, dates go outside the dropdown menu.
- Fix: In PDF and Send Quote, not all items receive values.
- Fix: You cannot download PDFs from Orders if there is a blank Geolocation element in the calculator.
- Fix: Orders do not show links in fields from the Validated form (Email, Name, URL) if the Validated form is in Repeater.

= 3.1.88 =
- Enhancement: The settings "Show Summary with calculations after adding contact info" and Terms and Conditions are displayed in Preview and Appearance.
- Fix: When ‘Calculate cost per day’ is disabled there is an unnecessary ‘0’ after the selected date in the Cart.
- Fix: The image in the HTML element is compressed on the page but not compressed in Preview and Appearance.
- Fix: After resetting the condition again, Default values in the Toggle, Checkbox, and Image Checkbox are also reset.
- Fix: If the Validated form is dragged into the Group field, the icon of the Validated form becomes like Multi range.
- Fix: With the condition ‘Skip next page’ in the Page breaker, the next page should be skipped, not the current page.
- Fix: The Add to Cart does not work due to the ‘ “ ” quotation marks in the calculator name or in the field name

= 3.1.87 =
- New: Added a new Page Breaker element to add step-by-step forms and calculators.
- Fix: An error occurs when trying to view a PDF file due to a conflict with PDF Invoices & Packing Slips for WooCommerce.
- Fix: When there are multiple calculators on one page, multiple requests are sent from Contact Form 7.
- Fix: Values in some elements are not coming in Orders.
- Fix: If the page has a calculator with Contact Form 7 and a Sticky calculator with Default order form, then Contact Form 7 does not work.

= 3.1.86 =
- Enhancement: Send a quote and invoice to customer's email - now does not display PDF and Send Quote.
- Enhancement: Show calculations on Summary block - now does not display PDF and Send Quote.
- Enhancement: Show calculations with buttons to download PDF and share quotes on Summary block - added new option, displays PDF and Enhancement: Send Quote depending on Show button setting only after making payment in PDF.
- Enhancement: Added word hyphenation for title in ‘Show Summary with calculations after adding contact info’ setting.
- Fix: After uploading multiple photos via camera, only one attachment is received.
- Fix: After uploading a photo via phone camera, the ‘Download’ buttons move to Email Template because of the long title in the downloaded file.
- Fix: In Contact form 7 the price is displayed in the Repeater element, Total remains empty.
- Fix: In Group field and Repeater the long text in the title goes outside the element.
- Fix: Long calculator name does not fit in Tooltip Position in Sticky Calculator.
- Fix: When clicking on an area in the drop-down menu in Product Category, the menu jumps around.
- Fix: After saving with Back up settings, the calculator navigation does not work.
- Fix: The Show Summary with calculations after adding contact info setting works with Order form turned off.

= 3.1.85 =
- Enhancement: Added the ability to select the year in the Date picker element.
- Enhancement: Added "Type of label in total" setting in Image Checkbox.
- Enhancement: The address selected in Geolocation is now pulled into Webhook.
- Enhancement: When selecting only one option in Image Checkbox, the value is displayed only in Total but not in Composition.
- Fix: PDF and Send Quote are not displayed in Preview & Appearance and Submit button is not changed.
- Fix: Default value is not applied in Image dropdown and Image Radio elements if the number is hundredth.
- Fix: The old label remains after changing the value in the Default Value(s) in the Image Checkbox element.

= 3.1.84 =
- Enhancement: Added a tooltip for long text and long ID in Conditions.
- Enhancement: Product names in WooCheckout are shortened with the addition of a tooltip.
- Enhancement: On the Confirmation page, the page name is shortened with the addition of a tooltip.
- Enhancement: The calculator name was shortened with the addition of a tooltip in the Calculator field in WooProduct.
- Enhancement: In WooProduct Product category shortened without adding a tooltip.
- Fix: PDF does not display totals without formula elements.
- Fix: Total field settings in WooCheckout override Total field settings in Payments and Order form.
- Fix: Long text in the calculator title overrides the field in Orders.
- Fix: Required in populated Repeater does not skip Geolocation element with Multiply option.
- Fix: The "DELETED" label on the Orders page moves off if the calculator name is 2 lines long

= 3.1.83 =
- Enhancement: Added ability to add multiple emails to the default Order form.
- Enhancement: Added warning for the case when the user enables the Contact form but leaves email and subject fields blank.
- Enhancement: Send Quote and PDF buttons are shown when filling Order form with Confirmation page disabled.
- Fix: The Multi Range field is incorrectly displayed with a long title.
- Fix: When deleting a new Repeater in an old Repeater, the country code in the Validated form returns to the original value.
- Fix: After entering a promo code, the price is calculated at the old price.
- Fix: If one period is deleted in the Date picker with Make some days unselectable and Block a period enabled, all periods are deleted.

= 3.1.82 =
- Enhancement: Added new options for Click action setting of Sticky Calculator: Pop up summary, Download PDF, Share invoice, WooCheckout action after submit, Pop up on WooProduct page and WooCheckout action on WooProduct page.
- Enhancement: Added a setting to show or not a calculator in the background when the Sticky Calculator is enabled.
- Fix: Notice "Note: PDF files are not enabled" is displayed with PDF entries enabled.
- Fix: Elements are not hidden in Preview and Appearance after resetting the condition.
- Fix: Calculator is not added to Elementor Popup.

= 3.1.81 =
- Enhancement: In Orders, all Formula elements are displayed regardless of selection in Payment Gateways and individual Formula elements with counts are highlighted.
- Enhancement: Formula elements are displayed on WooCommerce Cart and Checkout pages.
- Enhancement: In Email, all Formula elements are displayed regardless of their selection in Payment Gateways and separate Formula with counting are highlighted.
- Fix: Invalid data in one Repeater affects validation in a new Repeater in all elements.

= 3.1.80 =
- Fix: If a location is deleted in one Repeater, locations are also deleted in other Repeaters.

= 3.1.79 =
- Enhancement: Added a setting in Date Picker to prevent a site visitor from selecting several different dates or periods.
- Enhancement: Warnings show up when a user does not fill in the fields in Order form settings.
- Enhancement: Made integration of WooCommerce Meta with elements inside Repeater.
- Enhancement: Updated the view for customizing formula selection in Payment Gateways.
- Enhancement: Email and Website URLs are now displayed as links for Orders, WooCommerce, PDF and Send Quote.
- Fix: Lines from the Geolocation element from the page are not pulled up during translation.

= 3.1.78 =
- Fix: Minor bug fixes.

= 3.1.77 =
- New: A new feature, Sticky Calculator, was added.
- Fix: The ID comes in the Subject of the Order form in the mail, even if the setting is turned off.

= 3.1.76 =
- Enhancement: Added a setting to show calculations after the visitor has entered all form contact details in the Order form.
- Fix: The Submit button in Preview & Appearance does not change when changed via Global settings.
- Fix: When paying with Cash payment an alert comes out that the price must be greater than 0 if there are no calculations.
- Fix: Words in Conditions are cut off.
- Fix: Payment with Stripe, Razorpay, Cash payment, PayPal does not pass if there are special characters in the calculator name.
- Fix: In Conditions it is not possible to draw Range in Date picker through unselectable days.
- Fix: Repeater numbering moves away if the Repeater title is long.

= 3.1.75 =
- Fix: When you delete one of the products on the “Orders” page after reloading the page, the price of the remaining product is assigned to the product and not to the calculation.
- Fix: Order Form is not working when Upload File element is used in Conditions.
- Fix: When reopening the map with the Request user location option in the Geolocation element, the custom icon becomes the default icon.

= 3.1.74 =
- Enhancement: Added the ability to filter orders by date.
- Enhancement: Now you can export orders in CSV and XLS.
- Enhancement: Added the ability to search for orders by calculator name, ID and email.
- Enhancement: Added text transfer in the label of item option and description.
- Enhancement: It is possible to select dates if they are from the previous and next month.
- Enhancement: Added a setting to make the calendar close automatically after selecting dates.
- Fix: The geolocation element is incorrectly displayed in the mobile version.
- Fix: The dropdown with Woo products does not open on screens smaller than 1375px.

= 3.1.73 =
- Enhancement: Added the Order ID to the email subject line.
- Enhancement: Now Values are not displayed on WooCommerce pages in Dropdown list, Image dropdown, Radio select, and Image Radio items with label-only option.
- Fix: When an item is moved to Repeater, it remains inside Formula and the calculator does not load in Preview.
- Fix: In the Geolocation element, the distance is calculated in “miles” even if the settings are set to “kilometers”.
- Fix: With the Ranged price for the distance setting in Compositions, the distance is displayed as 10 for all values.
- Fix: With the Ask users to choose starting and destination points option, after clicking Clear selection, markers from the selected locations remain on the map.

= 3.1.72 =
- New: Added a new Validated Form element.
- Enhancement: Distance is displayed in the email when paying via Contact Form 7.
- Fix: Empty Geolocation element with Multiple locations option is shown in Email, PDF and Orders even if Zero Values setting is turned off.
- Fix: Title Geolocation with Multiple locations option in Repeater has indentation when downloading from PDF.
- Fix: The Geolocation with Multiple locations option does not display radio in the Geolocation with Multiple locations option if the location is incomplete.
- Fix: After applying Set location/set location & disable, map is not displayed on mail, PDF, Orders, or Send quote when used with the Multiple locations option.
- Fix: Small bug fixes.

= 3.1.71 =
- Enhancement: Added settings to change marker for selected addresses and pickup points in the Geolocation element.
- Fix: In Contact form 7 the display of elements in Repeater is not adapted.
- Fix: When paying without an Order form, the split for Repeater is not displayed in the Email.
- Fix: Default value was not applied to all items within a Group field when it was made hidden by default and displayed via Conditions.
- Fix: No data from Webhook when using the Send Quote or Payment button.
- Fix: If Formula elements in the Group field are greater than or equal to 11, Formula is no longer deleted inside the Group field.
- Fix: The options in Radio, Image Radio, DropDown and Image DropDown are duplicated in the Value drop-down menu when selecting the Conditions options.
- Fix: Elements hidden by default performed condition actions from Conditions

= 3.1.70 =
- Enhancement: The drop-down menu in the Time picker closes when clicking on any area of the screen.
- Enhancement: Added SVG format for image loading in Image Dropdown.
- Enhancement: Selected locations are displayed in Geolocation when paying via WooCommerce.
- Fix: Formula comes without ID in Delivery service & Web design templates.
- Fix: When making one Repeater field hidden, other Repeaters are also hidden.
- Fix: Total appears on the page with item count outside Repeater if there is no Formula item.
- Fix: The word "Orders ID" and date in the Email template is not translated via Loco Translate.
- Fix: Razorpay and Cash Payment are not payment methods for Webhook and the Toggle to enable the webhook for Payment methods is disabled.
- Fix: In Compositions labels merge with value due to lack of space between them.

= 3.1.69 =
- Enhancement: Added the ability to open the map If in Conditions select Geolocation via the "Select and disable" option.
- Enhancement: Added a separate button to reset the location when it is opened on the map.
- Enhancement: Selected locations in Geolocation are displayed when paying via Soptast form 7.
- Enhancement: The price for each km/mile is displayed in the Summary.
- Fix: After adding the first location with the "Ask to choose one among multiple locations" option, the address is displayed when adding all other locations.
- Fix: If you click Cancel, the selected location is reset with the "Multiple locations" option selected.
- Fix: Small bug fixes.

= 3.1.68 =
- Fix: Showing a certain number of orders per page is not visible if there are many pages in Orders.

= 3.1.67 =
- Fix: When the device width is between 768 and 820 pixels, the total field in the sticky total is not displayed.
- Fix: Contact Information is not displayed in PDF after payment without the Order form.
- Fix: If a long title is entered in the Texts field in the Confirmation page settings, words are not transferred.
- Fix: No transition to Cart page when using WooCommerce and Order form is enabled.
- Fix: If the label for the option in the Image dropdown element is longer than 100 characters, c 4 lines of words do not fit in the width of the field in the dropdown menu.
- Fix: If Payments methods are set up, they don't show up in Preview and Appearance.

= 3.1.66 =
- New: Added a Location element to the builder to get a customer location.

= 3.1.65 =
- Enhancement: Added counting of added Repeater to the right of the label in Total.
- Enhancement: Added an option to show the Confirmation page.
- Fix: Instead of the selected formula in Payments, the formula with the highest ID is added to the cart.
- Fix: After the Show/Hide condition is met, items inside the Group field are no longer required to be filled.
- Fix: Stripe is not sending emails after payment.
- Fix: Scripts from the Confirmation page are shown on the page load.
- Fix: Clicking on "Order again" pulls up the price for the product instead of calculations and options from the calculator on the Cart and Checkout page.
- Fix: Files are not sent to the Email template from File upload when paying without the Order form.

= 3.1.64 =
- Enhancement: Added text transfer for options of Dropdown list and Image dropdown elements with long text.
- Enhancement: Added promo code information when downloading a PDF document and when sending a PDF via Send Quote.
- Fix: Text in Contact information went beyond the table in PDF with Contact Form 7 enabled.
- Fix:  Values are displayed in ccb-subtotal in Contact Form 7 even though they are hidden in the calculator itself.
- Fix: Long text in the Email field in the Orders form goes outside the table in the PDF.
- Fix: If there are a lot of items, they don't fit in the PDF when uploaded via Orders.
- Fix: When opening an Order form, the calculator is overlaid on top of the bottom widget in the mobile version.
- Fix: Razorpay does not display the price and total in Orders.

= 3.1.63 =
- Enhancement: Added ability to upload .tiff format files into the File upload field.
- Enhancement: Minor visual edits were made to the Conditions.
- Fix: Removed extra spaces next to values in Total and Summary.
- Fix: Order is not translated in the Email template and on the Orders page for admin and user.
- Fix: Hidden Quantity element appears in Orders, PDF and email.
- Fix: Elements are incorrectly displayed in 1280px-1660px resolutions on the Email Template, Captcha, and Woo Checkout pages.
- Fix: The date in emails is not translated when the language is changed.
- Fix: No more than 5 field formulas come in when using webhooks.
- Fix: Small bug fixes.

= 3.1.62 =
- Fix: Fixed an issue with performance due to the sub-module.

= 3.1.61 =
- New: Added a feature to add discounts and promo codes to the calculator.

= 3.1.60 =
- Fix: Box style horizontal is not applied in Image radio, Image checkbox in mobile view.
- Fix: Image Radio element does not display images in mobile view.
- Fix: Small bug fixes.

= 3.1.59 =
- Fix: Small bug fixes.

= 3.1.58 =
- Enhancements: Added a button to switch to the editor of a specific calculator through the page.
- Enhancements: Added a setting to show a different measuring unit.

= 3.1.57 =
- Fix: In Text, Radio select and Switch toggle elements are not highlighted if the field is required.
- Fix: Small bug fixes.

= 3.1.56 =
- Enhancement: Added a setting for the Terms and Conditions agreement.
- Fix: When a client pays via Stripe, the payment amount is increased by several times.
- Fix: When filling out an Order form with Payment methods disabled, Contact info is not displayed in the email for admin.
- Fix: Small bug fixes.

= 3.1.55 =
- New: Added a Group Field element for grouping fields within calculator.
- Update: The Cost Calculator plugin is now compatible with Essentials theme.
- Fix: The Conditions tab in the calculator does not open after importing a calculator with a Repeater element.
- Fix: Minor bug fixes.

= 3.1.54 =
- New: Added a new section of settings with Payment Gateways (Pro).
- Enhancements: Updated the design of the settings page for payment gateways.
- Enhancements: Made integration with Razorpay for customer payments.
- Enhancements: Added a setting for cash payment.

= 3.1.53 =
- Fix: Minor bug fixes.

= 3.1.52 =
 - Enhancements: Added additional fonts for displaying signs in Czech and Vietnamese languages.
 - Enhancements: Added CSV format for selection in File Upload.
 - Fix: When changing the calendar option (with and without range) in the Date picker element when Conditions is connected, the date is reset.
 - Fix: Text is displayed incorrectly if Date picker with range is selected and Calculate cost per day is disabled.
 - Fix: Small bug fixes.

= 3.1.51 =
- Enhancements: Added a new setting to select a calculator by a product for WooProducts.
- Fix: PDF does not come to mail with email when sent via Send Quote using POST SMTP plugin.
- Fix: The order form/Payments method does not work when switching between the hidden elements and Conditions enabled.
- Fix: Small bug fixes.

= 3.1.50 =
- Enhancements: Added the ability to activate required for the elements inside the repeater.
- Enhancements: Image Checkbox is displayed in Horizontal view style at Default setting.
- Enhancements: Image Radio is displayed in Vertical view style at Default setting.
- Fix: When typing a large amount of text, fields in Send Quote are not displayed correctly and are stretched to full screen.
- Fix: If you upload multiple files and click the icon to expand The icon of the drop-down menu in File Upload is not clickable.

= 3.1.49 =
 - Update: Added a setting to choose a range through unselectable days and calculate them in the Date picker element.
 - Update: Added a setting to add price for file uploads and sum prices for each file in the File upload element.
 - Update: Added a setting to hide price in Dropdown, Image dropdown, Image radio and Image checkbox elements of the calculator.
 - Update: Added tip on the "Add another" button at the maximum limit of group usage in the Repeater element.
 - Fixed: With the disabled “Sum up values in all fields” setting in Repeater is not displayed on the page, but it is displayed in Orders.
 - Fixed: In Orders, an order made by WooCommerce is not displayed because it has a formula equal to 0.
 - Fixed: With the Order form turned off, when paying via Stripe/PayPal, the ID is not sent to the mail.
 - Fixed: If different items have the same label, WooCheckout displays the quantity 0.

= 3.1.48 =
- Fixed: Calculations are carried out with the "Use formula for each repeatable collection" toggle in Repeater turned off.
- Fixed: When deleting a new filled block after Add new in Repeater, the filled Text field in all blocks is deleted.
- Fixed: In the email template in the Customer Info block some words are not translated via WPML and Loco.
- Fixed: Information about the order is not transferred to the mail for Contact information.
- Fixed: If the Formula element is not used, the Woocommerce Product cart shows 0 in price.

= 3.1.47 =
 - Fixed: Added the ability to edit the text of the "Close" button in Email Quote.
 - Fixed: When selecting a time in the Time Picker element, the extra distance appears at the bottom of the calculator in Preview, Appearance and Webpage.
 - Fixed: Fixed translation of some words into Spanish via the WPML plugin in the calculator.
 - Fixed: Item jumping occurs when adding via Drang & Drop in Repeater element.
 - Fixed: If the Open Form Button Text field is empty, a button without text will appear on the page if the field responsible for the button text in the Order form on the page is deleted.
 - Fixed: There is no order ID in the templates of emails sent to the user and admin when the Order form is off.

= 3.1.46 =
- Fixed: Minor bug fixes.

= 3.1.45 =
- Update: Added a setting to select whether to display Repeator element in Formula element when calculating.
- Fixed: After filling out the Order form Confirmation page will not open and the calculator page will remain.
- Fixed: When hiding Formula via Conditions actions Show/Hide, the calculation still takes place in Orders.
- Fixed: If you set the Date picker with Calculate cost per day turned off and without Formula element, it adds $1.

= 3.1.44 =
- Update: Added popup about deleting Repeated groups in the Repeater element.
- Update Woocommerce meta price will not be displayed in Text, Line, HTML, File upload, Date picker, Time picker, Formula and Repeater elements.
- Update: Now, when dragging already saved elements from/to Repeater, the element and Repeater edit window will not open.
- Update: Reduced the distance between elements with calculations inside Repeater.
- Update: Added text input to Condition for Find Element section.
- Update: Added saving the open/closed position of the Find element section in Conditions.
- Update: Repeater now applies in Horizontal box style.
- Update: Added setting to write text for sending email quotes successfully and email quotes failed.
- Fixed: Conditions from Input fields do not work if the unit in Range, Multi Range and Quantity fields is not 1.
- Fixed: The Submit button of the default form for Order form in global calculator settings is not editable.
- Fixed: Non-insertable element is inserted into Repeater.
- Fixed: Clicking the checkbox when selecting "Total Field Element" in the WooCheckout setting does not work.
- Fixed: Small bug fixes.

= 3.1.43 =
- New: Added new Repeater element.
- Fixed: Small bug fixes.

= 3.1.42 =
- Update: Added Is selected(label(s)) condition for the calculator.
- Update: Returned functionality of "Is selected(option)" condition.
- Fixed: Validation considers a domain invalid if it has more than 4 characters after the dot in the email.
- Fixed: The name of the Submit order button in Contact Form 7 does not change if you change it through the global settings of the calculator.
- In the Multi range element, no alert is generated if the Default value is less than the min value.

= 3.1.41 =
 - Update: When selecting a payment method, if the Order form is turned off, Stripe or PayPal payment success messages now come for admin and customer.
 - Update: Added position setting (left, right, center) for Logo in Email Template.
 - Update: Now the placeholder Email logo is not displayed in the template if no logo is loaded.
 - Fixed: As for the Default Orders Form, the price in Orders of selected formulas is displayed.
 - Fixed: Price calculation for Stripe, Paypal, and Woocommerce payments is incorrect if there are multiple Formula items.

= 3.1.40 =
- Update: Added "Is selected with Options" condition for Checkbox and Toggle elements in the calculator.
- Fixed: When switching between old and new formula with calculations, values are not displayed unless saved.
- Fixed: With Contact Form 7 enabled, the Orders total always shows 0.

= 3.1.39 =
- Fixed: In Image Checkbox, Image Dropdown and Image Radio an image can not be inserted via URL.
- Fixed: Removed action in Conditions "Hide (leave in Total)" for Formula element.
- Fixed: When using a Separate page, the style was cached from another calculator and the color changed.
- Fixed: The "Add to cart" button when using WooCommerce was not disabled if the required element is not selected.

= 3.1.38 =
- Update: It is possible to make dates unavailable for selection in the Date Picker.
- Update: The date picker element now have an option to define 1 day price.
- Update: WooCommerce Stock can be used in the calculator.
- Fixed: Uploaded via upload file are not shown in Woocommerce orders.

= 3.1.37 =
- Fixed: HTML elements do not work in Header and Descriptions of Email Templates.
- Fixed: Minor bug fixes.

= 3.1.36 =
- Update: It is possible to make dates unavailable for selection in the Date Picker.
- Update: The date picker element now has the option to define 1 day price.
- Update: WooCommerce Stock can be used in the calculator.
- Update: Users can choose to include Zero Values in Orders, PDF Entries and Emails in calculator settings.
- Fixed: Required Field marker should be hidden if there is no Submit action on PDF and Send Quote since they do not create an order.
- Fixed: Parts of the page are blocked when the element settings window is open.
- Fixed: Uploaded via upload files are not shown in Woocommerce orders.
- Fixed: The total field is missing and appears after clicking or moving the cursor, and fields may be cropped afterward when Stripe is on.
- Fixed: Styles from Appearance are cached from other calculators.

= 3.1.35 =
- New: Added Version history for backup calculators after saving.
- Update: Added the ability to select the minimum interval for a gap in the Time picker element.
- Update: Added possibility to hide the left menu "Find Element" in Conditions.
- Fixed: With the Hidden by default setting enabled, if you set the condition to show datepicker in Conditions, Datepicker disappears from Preview after selecting a date during calculations.

= 3.1.34 =
- Update: Updated integration of calculator with Stripe

= 3.1.33 =
- Fixed: When formulas with if/else are summed together, the calculator does not load.
- Fixed: Small bug fixes.

= 3.1.32 =
- Fixed: Page selection should be mandatory item when Separate page and Custom Page in Confirmation page is selected.
- Fixed: Condition action Show does not work in all calculator elements.
- Fixed: Condition action Show does not work in calculations of Formula element.

= 3.1.31 =
- New: Added Confirmation Page to show to customers after calculations and ordering.
- Update: Made Value field for Radio, Image Radio, Dropdown, Image Dropdown optional.
- Update: Made it possible to select formulas to be displayed on email after calculations and ordering.
- Fixed: Datepicker does not work in the preview and appearance tab in the calculator builder.
- Fixed: The browser hangs when switching to Appearance/Condition in the calculator builder after enabling the Payment in the Contact form.

= 3.1.30 =
- Update: Added previews for some calculator element styles.
- Fixed: Small bug fixes.

= 3.1.29 =
- Update: Improved design and functionality of the Formula field.
- Update: New design and functionality of fields in the Create window
- Fixed: When clicking on the "+" the element is added twice to Conditions.
- Fixed: WooCommerce Add To Cart Form does not work when turning off this form on a product in the latest version of WooCommerce.
- Fixed: Fields are not displayed in Conditions if there is no name.
- Fixed: It was not possible to specify a date with the Date Picker in the Conditions.
- Fixed: Minor bug fixes.

= 3.1.28 =
- Update: Upgraded Design for Conditions
- Update: Canvas can be moved with the mouse via hold & drag in Conditions.
- Update: Elements in Conditions are added in the center of the canvas regardless of where the cursor is located.
- Fixed: All fields appear without a selected option when Select Any is selected

= 3.1.27 =
- Fixed: In File Upload, if the Show in Grand Total setting is disabled, files are not sent.

= 3.1.26 =
- Update: Changed the logic of each element's settings.
- Update: Redesigned element settings.
- Fixed: The unit values can not be shown on the right.

= 3.1.25 =
- Update: Redesigned unit view for quantity element in the free version and multi range element in the pro version.
- Fixed: Minor bug fixes on Time Field.

= 3.1.24 =
- Fixed: Unset action should remove the field value from the total and from the field itself in Time Picker.

= 3.1.23 =
- New: Added Time Picker Element to the functionality

= 3.1.22 =
- Update: Added .dxf .dwg formats to the Supported list in File Upload.
- Update: Added translation into Italian of the builder.
- Fixed: When putting the Image Radio element as the second level, the element breaks the condition.
- Fixed: The word Price is not translated in Loco Translate for Image Radio and Image Checkbox.
- Fixed: The currency sign is not displayed in the Orders and Orders PDF.
- Fixed: Email Quote sends an empty PDF file after an order.
- Fixed: Small bug fixes.

= 3.1.21 =
- Update: Added default value for Checkbox and Toggle Fields.
- Fixed: Removed translation of unnecessary texts in Russian.
- Fixed: There was a bar overlapping on the right side in the orders section at a resolution lower than 1420.

= 3.1.20 =
- Fixed: Webp format does not work with Image dropdown, Radio and Checkbox.
- Fixed: The orders section takes the total with the smallest id.
- Fixed: Added new animations gif format support.
- Fixed: Corrected word hyphenation in Ukrainian.
- Fixed: Redesigned Composition display in Grand Total.
- Fixed: Form validation fails when Required status for Date Picker is enabled.

= 3.1.19 =
- Fixed: Content of Text Field is displayed in Total Summary.
- Fixed: Items hidden with Radio conditions retain their value and are displayed in Total.
- Fixed: The Date Picker element in Orders (PDF) displays 1 instead of the date.

= 3.1.18 =
- Update: Security update.

= 3.1.17 =
- Fixed: Date Picker adds 1 to the default total.
- Fixed: Hidden by Default fields reset Total.
- Fixed: The marker icon overlaps the price in Image radio.
- Fixed: Only one element with the same name is selected from the webhooks.

= 3.1.16 =
- New: Added an option to connect to third-party automation applications using webhooks.
- Update: Added editor to format the content of the Email template.
- Fixed: The "Default Vertical" style did not apply to Toggle and Radio elements.
- Fixed: The "Box with heading" style did not apply to the Checkbox element.

= 3.1.15 =
- Update: Added an option to change decimals through arrows in option values of the elements and in the Quantity field.
- Fixed: Uploaded files did not display in Orders when Contact 7 integration was used.
- Fixed: Wrong direction of Multi Range element in RTL.
- Fixed: The color of the SVG icons was changed in Image Radio and Image Checkbox elements with Box with icon style.
- Fixed: The value of the Text field did not appear in WooCommerce orders, Email and PDF Quote.
- Fixed: Hidden Elements displayed in PDF Quote and Email.
- Fixed: Long values in the Unit column were broken off in the middle.

= 3.1.14 =
- New: Added an option to display calculated units in the Grand Total section.

= 3.1.13 =
- Fixed: Date Picker was not visible while customizing the calculator appearance.
- Fixed: Hidden Formula elements were visible in Email and PDF Quote.
- Fixed: Calculations did not add to the cart with Woo Checkout and the loader was displayed.

= 3.1.12 =
- Fixed: Elements with zero values did not display in Emails, WooCommerce checkout, and Order details.
- Fixed: The "Payment methods" label was displayed in the PDF Quote when the Contact form was disabled.
- Fixed: Conditions did not copy to the translated version of the calculator with WPML.

= 3.1.11 =
- Fixed: The email template did not apply to users with Gmail.

= 3.1.10 =
- Update: Revised some texts on the plugin dashboard to improve clarity and user experience.
- Fixed: Changes on option values of duplicated elements affected to the original one.

= 3.1.9 =
- New: Option to assign several WooCommerce Categories to a single calculator for WooProducts.
- Update: Added the option to make any field required.
- Fixed: Hidden by default Formula elements were visible in PDF Quote and Order details.
- Fixed: The arrow of the Image Drop down field was not clickable.
- Fixed: Payment details were displayed in PDF Quote and Order details when Payment methods were disabled.

= 3.1.8 =
- Fixed: Zero values of the Checkbox and Image Checkbox did not display in the PDF Quote.
- Fixed: Some letters did not display when PDF was generated in languages other than English.
- Fixed: Date Picker is overlapped on mobile view when the Two Columns Box Style is used.

= 3.1.7 =
- New: Personalized styles for Options of Toggle, Radio, Radio with Image, Checkbox, Checkbox With Image, DropDown, and DropDown With Image Fields.

= 3.1.6 =
- Update: Added option to disable Plugin branding in footer section for the Email template.

= 3.1.5 =
- New: Form Estimation Email Template has been added for easy personalization of outgoing emails.
- Update: Compatibility with WordPress 6.2.

= 3.1.4 =
- Update: Added global settings for Sender Email and Sender Name for outgoing emails.

= 3.1.3 =
- New: Conditions depending on the value of the Formula element.
- New: The Orders modal window will be closed when clicking on any area outside.
- Update: The Logic of the "is inferior" and "is superior" are changed for the Elements with Options, and the conditions should be set again.
- Fixed: The Uploaded file did not arrive in the WooCommerce orders.
- Fixed: Unpaid PayPal order displayed in Complete status.
- Fixed: The Value of the Hidden by Default Elements that was selected by the User was reset when they showed with Conditions.

= 3.1.2 =
- New: An allowed number of options to select is added for Image Checkbox field.
- New: The ability to add one WooCommerce product multiple times to the cart with different calculator options.
- New: The ability to stay on the page after adding a WooCommerce product to the cart to make a different calculation.
- Fixed: Submit button form Contact 7 did not apply accent color from Calculator Customizer.
- Fixed: The quantity field did not work with fractional numbers when the Hidden by default option was enabled.

= 3.1.1 =
- New: Option to make Total Summary Sticky is added to Grand total settings.
- Fixed: Global currency settings did not apply for the Currency symbol.

= 3.1.0 =
- New: Image Radio and Image Checkbox elements are added.
- Removed: "Not selected" option of reCaptcha was removed from global settings.
- Fixed: PayPal IPN History returned ERROR 500.
- Fixed: Incompatibility issues with PHP 8.

= 3.0.9 =
- New: Option to select the type of label for Dropdown with image field in Total.

= 3.0.8 =
- New: Added order creation date in Orders section.
- Fixed: Incorrect logic of WooCommerce Add To Cart toggle button in Calculator settings.

= 3.0.7 =
- New: Send PDF Quote form added.

= 3.0.6 =
- Fix: Get PDF button has not appeared before making payment using WooCoomerce checkout.
- Fix: The link of the attached file PDF invoice was redirected to the orders instead of downloading it.
- Fix: Selected values of the elements were reset, when conditions with the Checkbox and Toggle field is used.
- Fix: An error notice did not appear while making payment when the Grand Total was equal to 0.
- Fix: An empty notice appeared after a successful payment with Stripe.

= 3.0.5 =
- New: PDF Entries allow exporting the Total summary of calculations in a .pdf document.

= 3.0.4 =
- Fix: Emails from the default contact form were not translated.

= 3.0.3 =
- New: Quick premium support button in WP dashboard (for applying the issue tickets) and personal support account creation.

= 3.0.2 =
- Fix: File uploads are not displayed in WooCoommerce orders when WooCheckout is used.
- Fix: WooCoommerce orders are duplicated when WooCheckout is used.

= 3.0.1 =
- New: Select the Preloader icon through Calculator Appearance.
- Update: Added feedback button to the calculator dashboard to leave reviews.
- Fix: The Total summary was stretched when checkbox and toggle elements are used.

= 3.0.0 =
[Meet All-New Cost Calculator 3.0](https://stylemixthemes.com/wp/something-big-is-coming-meet-all-new-cost-calculator/)
* NEW: Cost Calculator Frontend UI was completely redesigned
* NEW: Redesigned and optimized Admin Dashboard
* NEW: Optimal navigation. Calculators list, orders, settings, and your accounts will be displayed in a horizontal panel.
* NEW: New calculator builder focused on a better user experience.
* NEW: Manage all points of the Contact Form in one place.
* NEW: Global settings for Payment Gateways.

= 2.2.8 =
- fixed: PayPal payment type did not work if the calculator’s fields contained more than 256 figures and symbols
- fixed: Drop Down with Image Field and File Upload Field were untranslatable
- fixed: Contact form was not submitted if any element's title had quotation marks
- fixed: Relevant notification to configure Calculator’s Settings
- fixed: Total Field issue with Stripe, PayPal and WooCommerce payments

= 2.2.7 =
- updated: Compatibility with WordPress 6.0
- fixed: Inappropriate load of graphical elements on "Contact Us" page

= 2.2.6 =
- updated: Security update

= 2.2.5 =
- fixed: Order can be created with empty custom fields, which have Required status
- fixed: WooCommerce Meta types in WooProducts Settings do not work with Quantity Custom Filed
- fixed: The confirmation text does not appear  after resending the message (when Send Form Feature is configured)
- fixed: 'This Filed is Required' notification is duplicated, when custom field with Required status is empty
- fixed: Badge "DELETED" appears on all calculator (Calculator Name Column) in Orders section
- fixed: Bug with Stripe payments
- fixed: After sending a message by using Send Form feature,  empty text area comes to email

= 2.2.4 =
- fixed: PayPal calculator field (set max 6)

= 2.2.3 =
- new: File Upload Custom Element
- new: Image Dropdown Custom Element
- fixed: Counters do not work on Image Dropdown Custom Element
- fixed: Keep the ID transaction from PayPal and Stripe
- fixed: Payments table not is separated from Orders Table (in database)
- fixed: Correct processing of PayPal and Stripe callbacks (if paid by the user, change the status of the order to complete with the date of payment)

= 2.2.2 =
- updated: You can choose multiple payment options in the form.
- fixed: WooCommerce cart data bug

= 2.2.1 =
- new: Show WooCommerce as third payment type if enabled
- new: "Show" action for hidden fields in Conditions
- new: Or/And logic for Condition added
- updated: Show multirange start and end values in Orders
- fixed: Correct calendar dropdown when date picker is at the bottom of the page
- fixed: Order details for WooCommerce orders
- fixed: Correct dropdown calendar translation
- fixed: Show cart data for all devices

= 2.2.0 =
- new: Order details section added in the dashboard
- new: PayPal feedback for payment status in order details
- new: Default contact form automatic usage with integrated payments methods (Stripe, PayPal)
- updated: Default contact form settings moved to separate section
- fixed: Minor bugs with Contact Form 7 plugin
- fixed: Datefield appearance in WooCommerce order details
- fixed: Required fields if option value equal to 0

= 2.1.9 =
- added: Date picker custom styles setup
- added: Wordpress date format for datepicker
- updated: Custom date picker
- updated: Date picker custom styles
- updated: Wordpress format for datepicker field
- updated: New date picker integrated
- updated:Refactoring of the conditions logic
- updated: Checkbox and toggles functionality updated
- new: Condition actions - Select Option, Select Option and Disable, Set date, Set date and disable, Set period , Set period and disable  added
- new: Can set period for date picker with range and multi range fields
- fixed: The elements removed from calculator stayed in condition section
- fixed: Required fields validation

= 2.1.8 =
- updated: Required option to Datepicker field
- added: Admin notifications

= 2.1.7 =
- fixed: Calculator displaying in WooCommerce if the product is out of stock
- fixed: Paypal currency symbol on redirect to Paypal checkout.
- fixed: The number of days is not counted for Date Picker field.
- fixed: Calculator title is not displayed in WooCommerce cart.

= 2.1.6 =
- fixed: Date format on Email.
- fixed: Captcha v2 does not work.
- fixed: Export/Import Calculators Condition bug.
- fixed: Multi-range is not displaying for Second Calculator on the same page.

= 2.1.5 =
- fixed: WooCommerce Cart Product Settings

= 2.1.4 =
- new: WooCommerce Products feature added
- fixed: WooCommerce Cart Product Variation bug

= 2.1.3 =
- fixed: Calendar Datepicker issue on Safari
- fixed: Deleting Calculator Product from Cart issue

= 2.1.2 =
- upd: Compatibility with Wordpress 5.7
- fixed: PayPal redirect issue
- fixed: Contact Form after submit bugs
- fixed: WooCommerce conflict when multiple Users add item to the cart at the same time

= 2.1.1 =
- Security update

= 2.1.0 =
- new: Hover effect settings added for Submit button (Customizer)
- fixed: Datepciker OK button appearance
- fixed: Condition link appearance in dashboard
- fixed: Set value action delay (Conditional system)
- fixed: HTML & Line elements disappear after set conditions to these elements
- fixed: Toggle to Drop Down condition bug
- fixed: Stripe 'Public key' typo

= 2.0.10 =
- upd: Watermark 'Powered by Stylemix' is not visible when Pro plugin activated
