/**
 * JS Class for Column objects
 *
 * @author Alexander Gilmanov
 * @since 22.11.2016
 */
var WDTColumn = function (column, parent_table) {
    /**
     * Id of column
     * @type {null|int}
     */
    this.id = null;

    /**
     * Type of column
     * @type {null|string}
     */
    this.type = null;
    /**
     * Predefined Type of column
     * @type {null|string}
     */
    this.predefinedType = null;
    /**
     * Original header of column. Must be unique within the table
     * @type {null|string}
     */
    this.orig_header = null;

    /**
     * Header to display
     * @type {null|string}
     */
    this.display_header = '';

    /**
     * Position of column in the table
     * @type {null|int}
     */
    this.pos = null;

    /**
     * Text to display before content of cells
     * @type {string}
     */
    this.text_before = '';

    /**
     * Text to display after content of cells
     * @type {string}
     */
    this.text_after = '';

    /**
     * Hide on mobiles on responsive
     * @type {int}
     */
    this.hide_on_mobiles = 0;

    /**
     * Hide on desktops on responsive
     * @type {int}
     */
    this.hide_on_tablets = 0;

    /**
     * CSS class
     * @type {string}
     */
    this.css_class = '';

    /**
     * Whether this column should be used as a group column
     * @type {number}
     */
    this.groupColumn = 0;

    /**
     * Column color
     */
    this.color = '';

    /**
     * Column visibility
     * @type {number}
     */
    this.visible = 1;

    /**
     * Column width
     * @type {number}
     */
    this.width = 0;

    /**
     * Default decimal places amount for floats
     * @type {number}
     */
    this.decimalPlaces = -1;

    /**
     * Defines how the possible values will be read
     * Fixed list, read on load, use from another table
     * @type {null|string}
     */
    this.possibleValuesType = null;

    /**
     * If possible values defined as a fixed list store it here
     * @type {null|string}
     */
    this.valuesList = null;

    /**
     * If possible values defined to be loaded from another table
     * store it here
     * @type {null|string}
     */
    this.foreignKeyRule = null;

    /**
     * Allow empty values for possible values list
     * @type {int}
     */
    this.possibleValuesAddEmpty = 0;

    /**
     * Possible values AJAX loading
     * @type {number}
     */
    this.possibleValuesAjax = 10;
    this.column_align_header = '';
    this.column_align_fields = '';
    /**
     * Column rotate header name
     *
     */
    this.column_rotate_header_name = '';
    /**
     * Toggle calculate total for numeric columns
     * @type {int}
     */
    this.calculateTotal = 0;
    /**
     * Toggle calculate average for numeric columns
     * @type {int}
     */
    this.calculateAvg = 0;

    /**
     * Toggle calculate minimum for numeric columns
     * @type {int}
     */
    this.calculateMin = 0;

    /**
     * Toggle calculate maximum for numeric columns
     * @type {int}
     */
    this.calculateMax = 0;

    /**
     * Toggle skip thousands separator for integer columns
     * @type {int}
     */
    this.skip_thousands_separator = 0;

    /**
     * Toggle sorting
     * @type {int}
     */
    this.sorting = 1;

    /**
     * Use as default sorting column
     * @type {number}
     */
    this.defaultSortingColumn = 0;

    /**
     * Enable a filter for this column
     * @type {number}
     */
    this.filtering = 0;

    /**
     * Toggle global search column
     * @type {int}
     */
    this.globalSearchColumn = 1;

    /**
     * Filter type for this column
     * @type {string}
     */
    this.filter_type = null;

    /**
     * Toggle exact filtering
     * @type {int}
     */
    this.exactFiltering = 0;

    /**
     * Toggle range slider
     *  @type {int}
     */
    this.rangeSlider = 0;

    /**
     * Display max value on range slider
     *  @type {string}
     */
    this.rangeMaxValueDisplay = 'default';

    /**
     * Custom max value string in the range slider
     *  @type {string}
     */
    this.customMaxRangeValue = null;

    /**
     * Filter label
     * @type {string}
     */
    this.filterLabel = null;

    /**
     * Default filter value
     * @type {string}
     */
    this.filterDefaultValue = null;

    /**
     * Toggle the search in select-box/ multiselect-box filters
     * @type {int}
     */
    this.searchInSelectBox = 1;

    /**
     * Editor input type for editable tables
     * @type {null}
     */
    this.editor_type = null;

    /**
     * Toggle the non-empty validation for this column
     * @type {int}
     */
    this.editingNonEmpty = 0;

    /**
     * Default editing value
     * @type {string}
     */
    this.editingDefaultValue = null;

    /**
     * Toggle the search in select-box entry editing for this column
     * @type {int}
     */
    this.searchInSelectBoxEditing = 1;

    /**
     * Conditional formatting rules
     */
    this.conditional_formatting = [];

    /**
     * Link to parent wpdatatable_config object
     * @type {null}|obj
     */
    this.parent_table = null;

    /**
     * Formula for the formula-based columns
     * @type {string}
     */
    this.formula = '';

    /**
     * Indicator if the config editor open for this column
     */
    this.is_config_open = false;

    /**
     * Flag if this is the ID column for editing
     */
    this.id_column = 0;

    /**
     * Date input format
     */
    this.dateInputFormat = null;

    /**
     * Checkbox filter in modal
     */
    this.checkboxesInModal = 0;

    /**
     * Use AND logic in multiselectbox/checkbox filter
     */
    this.andLogic = 0;

    /**
     * Open link column in a popup
     */
    this.linkTargetAttribute = '_self';

    /**
     * Open link as a nofollow link
     */
    this.linkNoFollowAttribute = 0;

    /**
     * Set NOREFERRER link
     */
    this.linkNoreferrerAttribute = 0;

    /**
     * Set SPONSORED link
     */
    this.linkSponsoredAttribute = 0;

    /**
     *  Open link column as a button
     */
    this.linkButtonAttribute = 0;

    /**
     *  Url link button label
     */
    this.linkButtonLabel = null;

    /**
     *  Url link button class
     */
    this.linkButtonClass = null;

    /**
     * Text to transform content of cells
     * @type {string}
     */
    this.transformValueText = '';


    /**
     * Initialize with object if passed
     */
    if (typeof column !== 'undefined') {
        this.calculateAvg = column.calculateAvg || 0;
        this.calculateMax = column.calculateMax || 0;
        this.calculateMin = column.calculateMin || 0;
        this.calculateTotal = column.calculateTotal || 0;
        this.checkboxesInModal = column.checkboxesInModal || 0;
        this.andLogic = column.andLogic || 0;
        this.color = column.color || '';
        this.conditional_formatting = column.conditional_formatting || [];
        this.css_class = column.css_class || '';
        this.dateInputFormat = column.dateInputFormat || '';
        this.decimalPlaces = column.decimalPlaces;
        this.defaultSortingColumn = column.defaultSortingColumn || 0;
        this.display_header = column.display_header || '';
        this.editingDefaultValue = column.editingDefaultValue || null;
        this.editingNonEmpty = column.input_mandatory || 0;
        this.searchInSelectBoxEditing = column.searchInSelectBoxEditing || 0;
        this.editor_type = column.editor_type || 'none';
        this.exactFiltering = column.exactFiltering || 0;
        this.filter_type = column.filter_type || 'text';
        this.filterDefaultValue = column.filterDefaultValue || null;
        this.searchInSelectBox = column.searchInSelectBox || 0;
        this.filtering = typeof column.filtering !== 'undefined' ? column.filtering : 1;
        this.globalSearchColumn = column.globalSearchColumn || 0;
        this.filterLabel = column.filterLabel || null;
        this.foreignKeyRule = column.foreignKeyRule || null;
        this.formula = column.formula || '';
        this.groupColumn = column.groupColumn || 0;
        this.hide_on_mobiles = column.hide_on_mobiles || 0;
        this.hide_on_tablets = column.hide_on_tablets || 0;
        this.id = column.id || null;
        this.id_column = column.id_column || 0;
        this.linkTargetAttribute = column.linkTargetAttribute || '_self';
        this.linkNoFollowAttribute = column.linkNoFollowAttribute || 0;
        this.linkNoreferrerAttribute = column.linkNoreferrerAttribute || 0;
        this.linkSponsoredAttribute = column.linkSponsoredAttribute || 0;
        this.linkButtonAttribute = column.linkButtonAttribute || 0;
        this.linkButtonLabel = column.linkButtonLabel || null;
        this.linkButtonClass = column.linkButtonClass || null;
        this.rangeSlider = column.rangeSlider || 0;
        this.rangeMaxValueDisplay = column.rangeMaxValueDisplay || 'default';
        this.customMaxRangeValue = column.customMaxRangeValue || null;
        this.orig_header = column.orig_header || null;
        this.parent_table = column.parent_table || null;
        this.pos = column.pos || 0;
        this.possibleValuesAddEmpty = column.possibleValuesAddEmpty || 0;
        this.possibleValuesType = column.possibleValuesType || null;
        this.possibleValuesAjax = column.possibleValuesAjax || 10;
        this.column_align_fields = column.column_align_fields || '';
        this.skip_thousands_separator = column.skip_thousands_separator || 0;
        this.sorting = typeof column.sorting !== 'undefined' ? column.sorting : 1;
        this.column_align_header = column.column_align_header || '';
        this.text_after = column.text_after || null;
        this.text_before = column.text_before || null;
        this.type = column.type || null;
        this.predefinedType = column.predefinedType || null;
        this.valuesList = column.valuesList || null;
        this.visible = typeof column.visible !== 'undefined' ? column.visible : 1;
        this.width = column.width || null;
        this.column_rotate_header_name = column.column_rotate_header_name || '';
        this.transformValueText = column.transformValueText || '';

        if (typeof callbackExtendColumnObject !== 'undefined') {
            callbackExtendColumnObject(column, this);
        }
    }
};

/**
 * Set column type
 * @param type
 */
WDTColumn.prototype.setType = function (type) {
    this.type = type;
};

/**
 * Gets column type
 * @returns {null|*}
 */
WDTColumn.prototype.getType = function () {
    return this.type;
};

/**
 * Set column ID
 * @param id
 */
WDTColumn.prototype.setId = function (id) {
    this.id = id;
};

/**
 * Get column ID
 * @returns {null|*}
 */
WDTColumn.prototype.getId = function () {
    return this.id;
};


/**
 * Set column display header
 * @param display_header
 */
WDTColumn.prototype.setDisplayHeader = function (display_header) {
    this.display_header = display_header;
};

/**
 * Get column display header
 */
WDTColumn.prototype.getDisplayHeader = function () {
    return this.display_header;
};

/**
 * Set text before
 * @param {string} text_before
 */
WDTColumn.prototype.setTextBefore = function (text_before) {
    this.text_before = text_before;
};

/**
 * Get text before
 * @returns {string|*|null}
 */
WDTColumn.prototype.getTextBefore = function () {
    return this.text_before;
};

/**
 * Set text after
 * @param {string} text_after
 */
WDTColumn.prototype.setTextAfter = function (text_after) {
    this.text_after = text_after;
};

/**
 * Get text after
 * @returns {string|*|null}
 */
WDTColumn.prototype.getTextAfter = function () {
    return this.text_after;
};
/**
 * Set text transform value
 * @param {string} transformValue_text
 */
WDTColumn.prototype.setTransformValueText = function (transformValue_text) {
    this.transformValueText = transformValue_text;
};

/**
 * Get text transform value
 * @returns {string|*|null}
 */
WDTColumn.prototype.getTransformValueText = function () {
    return this.transformValueText;
};

/**
 * Set Hide on Mobiles for responsive tables
 * @param {int} hideOnMobiles
 */
WDTColumn.prototype.setHideOnMobiles = function (hideOnMobiles) {
    this.hide_on_mobiles = hideOnMobiles;
};

/**
 * Get Hide On Mobiles
 * @returns {int}
 */
WDTColumn.prototype.getHideOnMobiles = function () {
    return this.hide_on_mobiles;
};

/**
 * Set Hide on Mobiles for responsive tables
 * @param {int} hideOnTablets
 */
WDTColumn.prototype.setHideOnTablets = function (hideOnTablets) {
    this.hide_on_tablets = hideOnTablets;
};

/**
 * Get Hide On Mobiles
 * @returns {int}
 */
WDTColumn.prototype.getHideOnTablets = function () {
    return this.hide_on_tablets;
};

/**
 * Set column CSS class
 * @param {string} css_class
 */
WDTColumn.prototype.setCssClass = function (css_class) {
    this.css_class = css_class;
};

WDTColumn.prototype.setAdditionalParam = function (paramName, paramValue) {
    this[paramName] = paramValue;
};

WDTColumn.prototype.getAdditionalParam = function (paramName) {
    return this[paramName];
};

/**
 * Get column Column CSS class
 * @returns {string}
 */
WDTColumn.prototype.getCssClass = function () {
    return this.css_class;
};

/**
 * Set Group Column
 * @param {int} groupColumn
 */
WDTColumn.prototype.setGroupColumn = function (groupColumn) {
    this.groupColumn = groupColumn;
};

/**
 * Get Group Column
 * @return {int}
 */
WDTColumn.prototype.getGroupColumn = function () {
    return this.groupColumn;
};

/**
 * Set column color
 * @param {string} color
 */
WDTColumn.prototype.setColor = function (color) {
    this.color = color;
};

/**
 * Get column color
 * @returns {string}
 */
WDTColumn.prototype.getColor = function () {
    return this.color;
};

/**
 * Set column ID for editing flog
 * @param {int} idColumn
 */
WDTColumn.prototype.setIdColumn = function (idColumn) {
    this.id_column = idColumn;
    jQuery('#wdt-id-editing-column').val(this.id);
};

/**
 * Get column ID for editing flog
 * @returns {string}
 */
WDTColumn.prototype.getIdColumn = function () {
    return this.id_column;
};

/**
 * Set Visibility
 * @param {int} visible
 */
WDTColumn.prototype.setVisible = function (visible) {
    this.visible = visible;
};

/**
 * Get Visibility
 * @return {int}
 */
WDTColumn.prototype.getVisible = function () {
    return this.visible;
};

/**
 * Set Width
 * @param {string} width
 */
WDTColumn.prototype.setWidth = function (width) {
    this.width = width;
};

/**
 * Get Width
 * @return {string}
 */
WDTColumn.prototype.getWidth = function () {
    return this.width;
};

/**
 * Get Position
 * @return {int}
 */
WDTColumn.prototype.getPos = function () {
    return this.pos;
};

/**
 * Set Position
 */
WDTColumn.prototype.setPos = function (pos) {
    this.pos = pos;
};

/**
 * Set Decimal Places
 * @param {int} decimalPlaces
 */
WDTColumn.prototype.setDecimalPlaces = function (decimalPlaces) {
    this.decimalPlaces = decimalPlaces;
};

/**
 * Get Decimal Places
 * @return {int}
 */
WDTColumn.prototype.getDecimalPlaces = function () {
    return this.decimalPlaces;
};

/**
 * Set Values Type (how to handle possible values)
 * @param {string} valuesType
 */
WDTColumn.prototype.setPossibleValuesType = function (valuesType) {
    this.possibleValuesType = valuesType;
};

/**
 * Get Values Type
 * @return {string}
 */
WDTColumn.prototype.getPossibleValuesType = function () {
    return this.possibleValuesType;
};

/**
 * Set Add Empty Value flag
 * Defines whether an empty value will be added to the list of possible values
 * @param {int} possibleValuesAddEmpty
 */
WDTColumn.prototype.setPossibleValuesAddEmpty = function (possibleValuesAddEmpty) {
    this.possibleValuesAddEmpty = possibleValuesAddEmpty;
};

/**
 * Get the Add Empty Value flag
 * (If an empty value in the list of possible values is allowed)
 * @return {int}
 */
WDTColumn.prototype.getPossibleValuesAddEmpty = function () {
    return this.possibleValuesAddEmpty;
};

/**
 * Set Values List (for columns with hardcoded list of possible values)
 * @param {string} valuesList
 */
WDTColumn.prototype.setValuesList = function (valuesList) {
    this.valuesList = valuesList;
};

/**
 * Get Values List
 * @return {string}
 */
WDTColumn.prototype.getValuesList = function () {
    return this.valuesList;
};

/**
 * Set Values ForeignKey (configuration for connecting to a remote table
 * for list of values for filtering and editing)
 * @param {obj} foreignKeyRule
 */
WDTColumn.prototype.setForeignKeyRule = function (foreignKeyRule) {
    this.foreignKeyRule = foreignKeyRule;
};

/**
 * Get Values Foreign Key config
 * @return {obj}
 */
WDTColumn.prototype.getForeignKeyRule = function () {
    return this.foreignKeyRule;
};

/**
 * Set Calculate Total
 * @param calculateTotal
 */
WDTColumn.prototype.setCalculateTotal = function (calculateTotal) {
    this.calculateTotal = calculateTotal;
};

/**
 * Get Calculate Total
 * @return calculateTotal
 */
WDTColumn.prototype.getCalculateTotal = function () {
    return this.calculateTotal;
};

/**
 * Set Calculate Average
 * @param {int} calculateAvg
 */
WDTColumn.prototype.setCalculateAvg = function (calculateAvg) {
    this.calculateAvg = calculateAvg;
};

/**
 * Get Calculate Average
 * @return {int} calculateTotal
 */
WDTColumn.prototype.getCalculateAvg = function () {
    return this.calculateAvg;
};

/**
 * Set Calculate Max
 * @param {int} calculateMax
 */
WDTColumn.prototype.setCalculateMax = function (calculateMax) {
    this.calculateMax = calculateMax;
};

/**
 * Get Calculate Max
 * @return {int} calculateMax
 */
WDTColumn.prototype.getCalculateMax = function () {
    return this.calculateMax;
};

/**
 * Set Calculate Min
 * @param {int} calculateMin
 */
WDTColumn.prototype.setCalculateMin = function (calculateMin) {
    this.calculateMin = calculateMin;
};

/**
 * Get Calculate Min
 * @return calculateMin
 */
WDTColumn.prototype.getCalculateMin = function () {
    return this.calculateMin;
};

/**
 * Set Skip Thousands Separator
 * @param {int} skipThousandsSeparator
 */
WDTColumn.prototype.setSkipThousandsSeparator = function (skipThousandsSeparator) {
    this.skip_thousands_separator = skipThousandsSeparator;
};

/**
 * Get Skip Thousands Separator
 * @return {int} skipThousandsSeparator
 */
WDTColumn.prototype.getSkipThousandsSeparator = function () {
    return this.skip_thousands_separator;
};

/**
 * Set Sorting
 * @param {int} sorting
 */
WDTColumn.prototype.setSorting = function (sorting) {
    this.sorting = sorting;
};

/**
 * Get Sorting
 * @return {int} sorting
 */
WDTColumn.prototype.getSorting = function () {
    return this.sorting;
};

/**
 * Set as Default Sorting Column
 * @param {int} defaultSortingColumn
 */
WDTColumn.prototype.setDefaultSortingColumn = function (defaultSortingColumn) {
    this.defaultSortingColumn = defaultSortingColumn;
};

/**
 * Get Default Sorting Column
 * @return {int} sorting
 */
WDTColumn.prototype.getDefaultSortingColumn = function () {
    return this.defaultSortingColumn;
};

/**
 * Set Filtering
 * @param {int} filtering
 */
WDTColumn.prototype.setFiltering = function (filtering) {
    this.filtering = filtering;
};

/**
 * Get Filtering
 * @return {int} filtering
 */
WDTColumn.prototype.getFiltering = function () {
    return this.filtering;
};

/**
 * Set global search for column
 * @param {int} globalSearchColumn
 */
WDTColumn.prototype.setGlobalSearchColumm = function (globalSearchColumn) {
    this.globalSearchColumn = globalSearchColumn;
};

/**
 * Get global search for column
 * @return {int} globalSearchColumn
 */
WDTColumn.prototype.getGlobalSearchColumn = function () {
    return this.globalSearchColumn;
};

/**
 * Set Filter Type
 * @param {string} filterType
 */
WDTColumn.prototype.setFilterType = function (filterType) {
    this.filter_type = filterType;
};

/**
 * Get Filter Type
 * @return {int} filterType
 */
WDTColumn.prototype.getFilterType = function () {
    return this.filter_type;
};

/**
 * Set Editor Type
 * @param {string} editorType
 */
WDTColumn.prototype.setEditorType = function (editorType) {
    this.editor_type = editorType;
};

/**
 * Get Editor Type
 * @return {string} editorType
 */
WDTColumn.prototype.getEditorType = function () {
    return this.filter_type;
};

/**
 * Set Non Empty
 * @param {int} nonEmpty
 */
WDTColumn.prototype.setNonEmpty = function (nonEmpty) {
    this.editingNonEmpty = nonEmpty;
};

/**
 * Get Non Empty
 * @return {int} nonEmpty
 */
WDTColumn.prototype.getNonEmpty = function () {
    return this.editingNonEmpty;
};

/**
 * Set search in select-box for editing
 * @param {int} searchInSelectBoxEdit
 */
WDTColumn.prototype.setSearchInSelectBoxEditing = function (searchInSelectBoxEdit) {
    this.searchInSelectBoxEditing = searchInSelectBoxEdit;
};

/**
 * Get search in select-box for editing
 * @return {int}
 */
WDTColumn.prototype.getSearchInSelectBoxEditing = function () {
    return this.searchInSelectBoxEditing;
};

/**
 * Set Conditional Formatting rules
 * @param {array} conditionalFormatting
 */
WDTColumn.prototype.setConditionalFormatting = function (conditionalFormatting) {
    this.conditional_formatting = conditionalFormatting;
};

/**
 * Get Conditional Formatting rules
 * @return {int} nonEmpty
 */
WDTColumn.prototype.getConditionalFormatting = function () {
    return this.conditional_formatting;
};

/**
 * Set Formula
 * @param {string} formula
 */
WDTColumn.prototype.setFormula = function (formula) {
    this.formula = formula;
};

/**
 * Get Formula
 * @return {string}
 */
WDTColumn.prototype.getFormula = function () {
    return this.formula;
};

/**
 * Defines a link to a parent table
 * @param tableLink
 */
WDTColumn.prototype.setParentTable = function (tableLink) {
    this.parent_table = tableLink;
};

/**
 * Returns the link to parent table
 * @returns {null|*}
 */
WDTColumn.prototype.getParentTable = function () {
    return this.parent_table;
};

/**
 * Set date input format
 * @param {string} dateInputFormat
 */
WDTColumn.prototype.setDateInputFormat = function (dateInputFormat) {
    this.dateInputFormat = dateInputFormat;
};

/**
 * Get date input format
 * @returns {string|*|null}
 */
WDTColumn.prototype.getDateInputFormat = function () {
    return this.dateInputFormat;
};

/**
 * Renders the conditional formatting rule in the column settings panel
 * @param formattingRule object with the rule
 */
WDTColumn.prototype.renderConditionalFormattingBlock = function (formattingRule) {
    var conditional_formatting_tpl = jQuery('#wdt-column-conditional-formatting-template').html();
    var $block = jQuery(conditional_formatting_tpl)
        .appendTo('div.wdt-conditional-formatting-rules-container');
    $block.find('select.formatting-rule-if-clause')
        .val(formattingRule.ifClause)
        .selectpicker();
    $block.find('input.formatting-rule-cell-value')
        .val(formattingRule.cellVal).addClass('wdt-' + jQuery('#wdt-column-type').val() + 'picker');
    $block.find('select.formatting-rule-action')
        .val(formattingRule.action)
        .selectpicker();
    $block.find('input.formatting-rule-set-value')
        .val(formattingRule.setVal);

    if (['date', 'int', 'float', 'datetime', 'time'].indexOf(jQuery('#wdt-column-type').val()) !== -1) {
        $block
            .find('select.formatting-rule-if-clause option[value="contains"],select.formatting-rule-if-clause option[value="contains_not"]')
            .remove();
    } else if (['string', 'link', 'email', 'image'].indexOf(jQuery('#wdt-column-type').val()) !== -1) {
        $block
            .find('select.formatting-rule-if-clause option[value="lt"],'
                + 'select.formatting-rule-if-clause option[value="lteq"],'
                + 'select.formatting-rule-if-clause option[value="gteq"],'
                + 'select.formatting-rule-if-clause option[value="gt"]'
            )
            .remove();
    }

    $block.find('select.formatting-rule-action').on('change', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (['setCellColor', 'setRowColor', 'setColumnColor'].indexOf(jQuery(this).val()) !== -1) {
            if (!$block.find('div.wdt-color-picker').length) {
                wdtInputToColorpicker($block.find('input.formatting-rule-set-value'));
            }
        } else if ($block.find('div.wdt-color-picker').length) {
            wdtColorPickerToInput($block.find('input.formatting-rule-set-value'));
        }
    }).change();

    $block.find('select.formatting-rule-if-clause').selectpicker('refresh');

    if (jQuery.inArray($block.find('.formatting-rule-cell-value').val(), ['%LAST_WEEK%','%THIS_WEEK%','%NEXT_WEEK%','%LAST_30_DAYS%','%LAST_MONTH%','%NEXT_MONTH%','%THIS_MONTH%']) !== -1) {
        $block.find('.formatting-rule-if-clause').prop('disabled', true).selectpicker('val','');
        jQuery('.wpdt-conditional-message .alert').removeClass('hidden');
    } else {
        jQuery('.wpdt-conditional-message .alert').addClass('hidden');
    }
};

/**
 * Helper function to show/hide the colorpicker in conditional formatting block
 */
jQuery(document).on('change', 'div.wdt-conditional-formatting-rules-container select.formatting-rule-action', function (e) {
    e.preventDefault();
    if (jQuery(this).val() == 'setCellColor' || jQuery(this).val() == 'setRowColor' || jQuery(this).val() == 'setColumnColor') {
        jQuery('.wdt-conditional-formatting-rules-container').parent().find('input.formatting-rule-set-value').remove();
    } else {
        var val = jQuery(this).parent().find('input.formatting-rule-set-value').val();
        jQuery(this).parent().find('div.wp-picker-container').replaceWith('<input class="setVal" value="' + val + '" />')
    }
});

WDTColumn.prototype.compileConditionalFormattingRules = function () {
    var column = this;
    var formattingRules = [];
    jQuery('div.wdt-conditional-formatting-rules-container div.wdt-conditional-formatting-rule').each(function () {
        if ((column.type == 'int') || (column.type == 'float')) {
            var cellVal = parseFloat(jQuery(this).find('input.formatting-rule-cell-value').val());
        } else {
            cellVal = jQuery(this).find('input.formatting-rule-cell-value').val().replace('"', "'");
        }
        formattingRules.push({
            ifClause: jQuery(this).find('select.formatting-rule-if-clause').val(),
            cellVal: cellVal,
            action: jQuery(this).find('select.formatting-rule-action').val(),
            setVal: jQuery(this).find('input.formatting-rule-set-value').val()
        });
    });
    this.conditional_formatting = formattingRules;
};

WDTColumn.prototype.columnTransformValue = function () {
    var column = this;
    var transformValueRules = [[]];
    var k = 0;
    var cellVal = '';
    var columnOrigHeaderString = column.orig_header.replace(/\s|\(|\)/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '');
    jQuery('#column-transform-value div.transform-value-container').each(function () {
        if (column.transformValueText != '') {
            cellVal = column.transformValueText;
            jQuery('table tbody tr td.column-' + columnOrigHeaderString).each(function () {
                this.innerHTML = cellVal;
                transformValueRules[0].push({
                    setVal: cellVal
                });
            });
        } else {
            transformValueRules[0].push({
                setVal: cellVal
            });
        }
    });
};

/**
 * Fill in the visible inputs with data
 */
WDTColumn.prototype.fillInputs = function () {
    jQuery('span.wdtColumnOrigHeader').html(this.orig_header);
    jQuery('#wdt-column-display-header').val(this.display_header);
    jQuery('#wdt-column-position').val(this.pos);
    jQuery('#wdt-column-display-text-before').val(this.text_before);
    jQuery('#wdt-column-display-text-after').val(this.text_after);
    jQuery('#wdt-column-transform-value').val(this.transformValueText);

    if (this.parent_table.responsive) {
        jQuery('div.wdt-columns-responsive-block').show();
        jQuery('#wdt-hide-column-on-mobiles').prop('checked', this.hide_on_mobiles);
        jQuery('#wdt-hide-column-on-tablets').prop('checked', this.hide_on_tablets);
    } else {
        jQuery('div.wdt-columns-responsive-block').hide();
    }

    jQuery('#wdt-column-css-class').val(this.css_class).keyup();
    wpdatatable_config.server_side == 1 ? jQuery('div.wdt-group-column-block').hide() : jQuery('div.wdt-group-column-block').show();
    jQuery('#wdt-group-column').prop('checked', this.groupColumn);
    jQuery('#wdt-column-color').val(this.color).keyup();
    jQuery('#wdt-column-color').siblings('.wpcolorpicker-icon').find('i').css("background", this.color);
    jQuery('#wdt-column-visible').prop('checked', this.visible);
    jQuery('#wdt-column-width').val(this.width);
    jQuery('#wdt-link-target-attribute').prop('checked', this.linkTargetAttribute === '_self' ? 0 : 1);
    jQuery('#wdt-link-nofollow-attribute').prop('checked', this.linkNoFollowAttribute).change();
    jQuery('#wdt-link-noreferrer-attribute').prop('checked', this.linkNoreferrerAttribute).change();
    jQuery('#wdt-link-sponsored-attribute').prop('checked', this.linkSponsoredAttribute).change();
    jQuery('#wdt-link-button-attribute').prop('checked', this.linkButtonAttribute).change();
    jQuery('#wdt-link-button-label').val(this.linkButtonLabel);
    jQuery('#wdt-link-button-class').val(this.linkButtonClass);
    jQuery('#wdt-column-enable-global-search').prop('checked', this.globalSearchColumn);

    jQuery('#wdt-column-decimal-places').val('');

    let specialColumnTypes = ['hidden', 'formula', 'index', 'select', 'cart'];
    switch (this.type) {
        case 'hidden':
            this.toggleColumnOption('hidden', true, '.wdt-hidden-column-block');
            break;
        case 'select':
            this.toggleColumnOption('select', true);
            break;
        case 'cart':
            this.toggleColumnOption('cart', true);
            break;
        case 'index':
            this.toggleColumnOption('index', true);
            break;
        case 'formula':
            this.toggleColumnOption('formula', true);
            if (this.decimalPlaces !== -1) {
                jQuery('#wdt-column-decimal-places').val(this.decimalPlaces);
            }
            break;
        default:
            specialColumnTypes.forEach(type => this.toggleColumnOption(type, false));
    }
    // Keep column type disabled for specific types
    if (specialColumnTypes.includes(this.type)) {
        jQuery('#wdt-column-type').prop('disabled', 'disabled');
    }

    jQuery('#wdt-column-type').selectpicker('val', this.type).change();
    if (jQuery.inArray(this.type, ['date', 'datetime']) !== -1) {
        jQuery('#wdt-date-input-format').selectpicker('val', this.dateInputFormat);
    }

    jQuery('#wdt-column-values').selectpicker('val', this.possibleValuesType).change();
    jQuery('#wdt-column-values-list').tagsinput('removeAll');
    jQuery('#wdt-possible-values-ajax').selectpicker('val', this.possibleValuesAjax).change();
    jQuery('#wdt-column-align-header').selectpicker('val', this.column_align_header).change();
    jQuery('#wdt-column-align-fields').selectpicker('val', this.column_align_fields).change();
    jQuery('#wdt-column-rotate-header-name').selectpicker('val', this.column_rotate_header_name).change();
    if (this.possibleValuesType == 'list') {
        jQuery('#wdt-column-values-list').tagsinput('add', this.valuesList);
    } else if (this.possibleValuesType == 'foreignkey') {
        jQuery('#wdt-connected-table-name').html(this.foreignKeyRule.tableName);
        jQuery('#wdt-connected-table-show-column').html(this.foreignKeyRule.displayColumnName);
        jQuery('#wdt-connected-table-value-column').html(this.foreignKeyRule.storeColumnName);
        jQuery('div.wdt-foreign-rule-display').show();
        jQuery('.wdt-possible-values-ajax-block').hide();
        jQuery('#wdt-possible-values-foreign-keys').prop('checked', this.foreignKeyRule.allowAllPossibleValuesForeignKey);
        if (wpdatatable_config.edit_only_own_rows == 1) {
            jQuery('.wdt-possible-values-foreign-keys-block').show();
        } else {
            jQuery('.wdt-possible-values-foreign-keys-block').hide();
        }
    }
    jQuery('#wdt-column-values-add-empty').prop('checked', this.possibleValuesAddEmpty);

    jQuery('#wdt-column-calc-total').prop('checked', this.calculateTotal);
    jQuery('div.wdt-column-calc-total-block #wdt-column-calc-total-shortcode span')
        .html('[wpdatatable_sum table_id=' + wpdatatable_config.id + ' col_id=' + wpdatatable_config.currentOpenColumn.id + ' value_only=0]');
    jQuery('#wdt-column-calc-avg').prop('checked', this.calculateAvg);
    jQuery('div.wdt-column-calc-avg-block #wdt-column-calc-avg-shortcode span')
        .html('[wpdatatable_avg table_id=' + wpdatatable_config.id + ' col_id=' + wpdatatable_config.currentOpenColumn.id + ' value_only=0]');
    jQuery('#wdt-column-calc-min').prop('checked', this.calculateMin);
    jQuery('div.wdt-column-calc-min-block #wdt-column-calc-min-shortcode span')
        .html('[wpdatatable_min table_id=' + wpdatatable_config.id + ' col_id=' + wpdatatable_config.currentOpenColumn.id + ' value_only=0]');
    jQuery('#wdt-column-calc-max').prop('checked', this.calculateMax);
    jQuery('div.wdt-column-calc-max-block #wdt-column-calc-max-shortcode span')
        .html('[wpdatatable_max table_id=' + wpdatatable_config.id + ' col_id=' + wpdatatable_config.currentOpenColumn.id + ' value_only=0]');

    if (jQuery.inArray(this.type, ['int', 'float', 'formula']) !== -1) {
        this.type == 'int' ?
            jQuery('#wdt-column-skip-thousands').prop('checked', this.skip_thousands_separator)
            : this.decimalPlaces != -1 ?
                jQuery('#wdt-column-decimal-places').val(this.decimalPlaces) :
                jQuery('#wdt-column-decimal-places').val('');
    }

    jQuery('#wdt-column-allow-sorting').prop('checked', this.sorting).change();
    jQuery('#wdt-column-default-sort').prop('checked', this.defaultSortingColumn).change();

    if (this.defaultSortingColumn) {
        jQuery('#wdt-column-default-sorting-direction')
            .selectpicker('val', this.defaultSortingColumn);
    }

    let filteringOptionEnabled = this.parent_table.filtering;
    let globalOptionEnabled = this.parent_table.global_search;
    if (!(filteringOptionEnabled || globalOptionEnabled) ||
        this.type == 'formula' || this.type == 'select' || this.type == 'cart') {
        jQuery('li.column-filtering-settings-tab').hide();
    } else {
        if (!globalOptionEnabled) {
            jQuery('.wdt-global-search-block').addClass('hidden');
            jQuery('.wdt-column-enable-filter-block, .wdt-filtering-enabled-block').removeClass('hidden');
        } else if (!filteringOptionEnabled) {
            jQuery('.wdt-column-enable-filter-block, .wdt-filtering-enabled-block').addClass('hidden');
            jQuery('.wdt-global-search-block').removeClass('hidden');
        } else {
            jQuery('.wdt-column-enable-filter-block, .wdt-filtering-enabled-block, .wdt-global-search-block ').removeClass('hidden');
        }

        jQuery('#wdt-column-enable-global-search').prop('checked', this.globalSearchColumn).change();

        jQuery('li.column-filtering-settings-tab').removeClass('active').show();
        jQuery('#wdt-column-exact-filtering').prop('checked', this.exactFiltering).change();
        jQuery('#wdt-column-range-slider').prop('checked', this.rangeSlider).change();
        jQuery('#wdt-max-value-display').selectpicker('val', this.rangeMaxValueDisplay);
        jQuery('#wdt-custom-max-value').val(this.customMaxRangeValue);
        jQuery('#wdt-column-filter-label').val(this.filterLabel);
        jQuery('#wdt-search-in-selectbox').prop('checked', this.searchInSelectBox).change();

        if (this.filter_type != 'none') {
            jQuery('#wdt-column-filter-type').selectpicker('val', this.filter_type);
            jQuery('#wdt-column-enable-filter').prop('checked', 1).change();

            if (this.filter_type === 'checkbox') {
                if (this.parent_table.filtering_form === 1)
                    jQuery('#wdt-checkboxes-in-modal').prop('checked', this.checkboxesInModal).change();
                jQuery('#wdt-and-logic').prop('checked', this.andLogic).change();
            }

            if (jQuery.inArray(this.filter_type, ['select', 'multiselect']) !== -1) {
                jQuery('#wdt-search-in-selectbox').prop('checked', this.searchInSelectBox).change();

                if (this.filter_type === 'multiselect')
                    jQuery('#wdt-and-logic').prop('checked', this.andLogic).change();
            }

            if (this.filterDefaultValue) {
                if (jQuery.inArray(this.filter_type, ['text', 'number']) != -1) {
                    if (typeof this.filterDefaultValue === 'object') {
                        jQuery('#wdt-filter-default-value').val(this.filterDefaultValue.value);
                    } else {
                        jQuery('#wdt-filter-default-value').val(this.filterDefaultValue);
                    }
                } else if (jQuery.inArray(this.filter_type, ['number-range', 'date-range', 'datetime-range', 'time-range']) != -1) {
                    if (typeof this.filterDefaultValue === 'object') {
                        jQuery('#wdt-filter-default-value-from').val(this.filterDefaultValue[0].value);
                        jQuery('#wdt-filter-default-value-to').val(this.filterDefaultValue[1].value);
                    } else {
                        var filterDefaultValues = this.filterDefaultValue.split('|');
                        jQuery('#wdt-filter-default-value-from').val(filterDefaultValues[0]);
                        jQuery('#wdt-filter-default-value-to').val(filterDefaultValues[1]);
                        this.filterDefaultValue = filterDefaultValues.join('|');
                    }
                } else {

                    if (jQuery.inArray(this.filter_type, ['checkbox', 'select', 'multiselect']) != -1) {
                        if (typeof this.filterDefaultValue === 'object')
                            this.filterDefaultValue = this.filterDefaultValue.value;
                        else
                            this.filterDefaultValue = this.filterDefaultValue.split('|');
                    }

                    jQuery('#wdt-filter-default-value-selectpicker').selectpicker('val', this.filterDefaultValue);
                    if (this.filterDefaultValue instanceof Array) {
                        this.filterDefaultValue = this.filterDefaultValue.join('|');
                    }
                }
            } else {
                jQuery('#wdt-filter-default-value').val('');
                jQuery('#wdt-filter-default-value-from').val('');
                jQuery('#wdt-filter-default-value-to').val('');
                jQuery('#wdt-filter-default-value-selectpicker').selectpicker('val', '');
            }
        } else {
            jQuery('#wdt-column-enable-filter').prop('checked', 0).change();
        }
    }

    if ((this.parent_table.editable || this.parent_table.table_type == 'manual') && this.type != 'formula') {
        jQuery('li.column-editing-settings-tab').show();
        if (jQuery('#wdt-column-editor-input-type').length) {
            jQuery('#wdt-column-editor-input-type').selectpicker('val', this.editor_type).change();
            jQuery('#wdt-column-not-null').prop('checked', this.editingNonEmpty);
            jQuery('#wdt-search-in-selectbox-editing').prop('checked', this.searchInSelectBoxEditing).change();
            if (this.type == 'hidden') {
                jQuery('#wdt-column-not-null').hide()
                jQuery('#wdt-search-in-selectbox-editing').hide()
                jQuery('#wdt-editing-default-value').hide()
                jQuery('#wdt-column-editor-input-type option[value="hidden"]').prop('disabled', '');
                jQuery('#wdt-column-editor-input-type').prop('disabled', 'disabled');
            } else {
                jQuery('#wdt-column-editor-input-type option[value="hidden"]').prop('disabled', 'disabled');
                jQuery('#wdt-column-editor-input-type').prop('disabled', '');
                jQuery('#wdt-column-not-null').show()
                jQuery('#wdt-search-in-selectbox-editing').show()
                jQuery('#wdt-editing-default-value').show()
            }
            jQuery('select#wdt-column-editor-input-type').selectpicker('refresh');
        }
        if (this.editingDefaultValue) {
            if (jQuery.inArray(this.editor_type, ['selectbox', 'multi-selectbox']) != -1) {
                if (typeof this.editingDefaultValue === 'object') {
                    jQuery('#wdt-editing-default-value-selectpicker').selectpicker('val', this.editingDefaultValue.value);
                } else {
                    if (this.editor_type == 'multi-selectbox') {
                        this.editingDefaultValue = this.editingDefaultValue.split('|');
                        jQuery('#wdt-editing-default-value-selectpicker').selectpicker('val', this.editingDefaultValue);
                    } else {
                        jQuery('#wdt-editing-default-value-selectpicker').selectpicker('val', this.editingDefaultValue);
                    }

                    if (this.editingDefaultValue instanceof Array) {
                        this.editingDefaultValue = this.editingDefaultValue.join('|');
                    }
                }
            } else if (jQuery.inArray(this.editor_type, ['link']) != -1) {
                let urlValue = jQuery('#wdt-editing-default-value').val();
                if (!(/^https?:\/\/.*\..*/.test(urlValue) || urlValue === '')) {
                    this.editingDefaultValue = "http://" + urlValue;
                } else this.editingDefaultValue = jQuery('#wdt-editing-default-value').val();
                jQuery('#wdt-editing-default-value').val(this.editingDefaultValue);
            } else if (jQuery.inArray(this.editor_type, ['hidden']) != -1) {
                if (this.editingDefaultValue.indexOf("query-param:") != -1) {
                    var queryParam = this.editingDefaultValue.replace('query-param:', '')
                    jQuery('#wdt-editing-hidden-default-value-selectpicker').selectpicker('val', 'query-param');
                    jQuery('#wdt-editing-hidden-default-value-selectpicker').selectpicker('refresh');
                    jQuery('.wdt-editing-hidden-query-param-value-block').show()
                    jQuery('.wdt-editing-hidden-query-param-value').val(queryParam)
                    jQuery('.wdt-editing-hidden-post-meta-value-block').hide()
                    jQuery('.wdt-editing-hidden-post-meta-value').val('')
                    jQuery('.wdt-editing-hidden-acf-data-value-block').hide()
                    jQuery('.wdt-editing-hidden-acf-data-value').val('')
                } else if (this.editingDefaultValue.indexOf("post-meta:") != -1) {
                    var postMeta = this.editingDefaultValue.replace('post-meta:', '')
                    jQuery('#wdt-editing-hidden-default-value-selectpicker').selectpicker('val', 'post-meta');
                    jQuery('#wdt-editing-hidden-default-value-selectpicker').selectpicker('refresh');
                    jQuery('.wdt-editing-hidden-post-meta-value-block').show()
                    jQuery('.wdt-editing-hidden-post-meta-value').val(postMeta)
                    jQuery('.wdt-editing-hidden-acf-data-value-block').hide()
                    jQuery('.wdt-editing-hidden-acf-data-value').val('')
                    jQuery('.wdt-editing-hidden-query-param-value-block').hide()
                    jQuery('.wdt-editing-hidden-query-param-value').val('')
                } else if (this.editingDefaultValue.indexOf("acf-data:") != -1) {
                    var acfData = this.editingDefaultValue.replace('acf-data:', '')
                    jQuery('#wdt-editing-hidden-default-value-selectpicker').selectpicker('val', 'acf-data');
                    jQuery('#wdt-editing-hidden-default-value-selectpicker').selectpicker('refresh');
                    jQuery('.wdt-editing-hidden-acf-data-value-block').show()
                    jQuery('.wdt-editing-hidden-acf-data-value').val(acfData)
                    jQuery('.wdt-editing-hidden-query-param-value-block').hide()
                    jQuery('.wdt-editing-hidden-query-param-value').val('')
                    jQuery('.wdt-editing-hidden-post-meta-value-block').hide()
                    jQuery('.wdt-editing-hidden-post-meta-value').val('')
                } else {
                    jQuery('#wdt-editing-hidden-default-value-selectpicker').selectpicker('val', this.editingDefaultValue);
                    jQuery('.wdt-editing-hidden-query-param-value-block').hide()
                    jQuery('.wdt-editing-hidden-query-param-value').val('')
                    jQuery('.wdt-editing-hidden-post-meta-value-block').hide()
                    jQuery('.wdt-editing-hidden-post-meta-value').val('')
                    jQuery('.wdt-editing-hidden-acf-data-value-block').hide()
                    jQuery('.wdt-editing-hidden-acf-data-value').val('')
                }
            } else {
                jQuery('#wdt-editing-default-value').val(this.editingDefaultValue);
                jQuery('#wdt-editing-hidden-default-value-selectpicker').selectpicker('val', this.editingDefaultValue);
                jQuery('.wdt-editing-hidden-query-param-value-block').hide()
                jQuery('.wdt-editing-hidden-query-param-value').val('')
                jQuery('.wdt-editing-hidden-post-meta-value-block').hide()
                jQuery('.wdt-editing-hidden-post-meta-value').val('')
                jQuery('.wdt-editing-hidden-acf-data-value-block').hide()
                jQuery('.wdt-editing-hidden-acf-data-value').val('')
            }
        } else {
            if (jQuery('#wdt-editing-default-value').length)
                jQuery('#wdt-editing-default-value').val('');
        }
        this.id_column == 1 ? jQuery('.wdt-skip-thousands-separator-block').hide() : '';
    } else {
        jQuery('li.column-editing-settings-tab').hide();
    }
    jQuery('div.wdt-conditional-formatting-rules-container').html('');
    if (this.conditional_formatting) {
        for (var i in this.conditional_formatting) {
            this.renderConditionalFormattingBlock(this.conditional_formatting[i]);
        }
    }

    if (typeof callbackFillAdditinalOptionWithData !== 'undefined') {
        callbackFillAdditinalOptionWithData(this);
    }

};

/**
 * Open the column settings block on the right, setting all
 * the UI controls to match the object config
 */
WDTColumn.prototype.show = function () {
    jQuery('div.column-settings-panel').fadeInRight();
    jQuery('div.column-settings-overlay').animateFadeIn();
    wpdatatable_config.currentOpenColumn = this;
    this.fillInputs();

    // Set Display tab and content as default one
    jQuery('div.column-settings-panel .tab-nav').find('.active').removeClass('active');
    jQuery('li.column-display-settings-tab').addClass('active');
    jQuery('div.column-settings-panel .tab-content').find('.active').removeClass('active');
    jQuery('div#column-display-settings').addClass('active');

    wpdatatable_config.sorting == 0 || this.type == 'formula' || this.type == 'select' || this.type == 'cart' ?
        jQuery('.column-sorting-settings-tab').hide() :
        jQuery('.column-sorting-settings-tab').show();

    jQuery(document).on('keyup.hideCSEsc', function (e) {
        if (e.which == 27) {
            e.preventDefault();
            e.stopImmediatePropagation();
            if (jQuery('.wdt-datatables-admin-wrap div.modal').is(':visible')) {
                jQuery('.wdt-datatables-admin-wrap div.modal').modal('hide');
            } else {
                wpdatatable_config.currentOpenColumn.hide();
            }
        }
    });

    if (typeof callbackHideColumnOptions !== 'undefined') {
        callbackHideColumnOptions(this);
    }

    this.is_config_open = true;
};

/**
 * Hide the column settings block
 */
WDTColumn.prototype.hide = function () {
    jQuery('div.column-settings-panel').fadeOutRight();
    jQuery('div.column-settings-overlay').animateFadeOut();
    jQuery(document).off('keyup.hideCSEsc');
    this.is_config_open = false;
    this.parent_table.currentOpenColumn = null;
};

/**
 * Apply changes from UI to the object
 */
WDTColumn.prototype.applyChanges = function () {
    if (!this.is_config_open) {
        return;
    }
    this.type = jQuery('#wdt-column-type').val();
    this.display_header = jQuery('#wdt-column-display-header').val();

    // If column type is formula and display header is empty set orig header as display header
    if (this.type === 'formula' && !this.display_header) {
        this.display_header = this.orig_header;
    }

    // If column type is ACF and display header is changed, change it in the WP Post Parameters
    if (this.parent_table.table_type === "wp_posts_query") {
        let customFieldColumns = wpdatatable_config.queryParameters.customFieldColumns ? wpdatatable_config.queryParameters.customFieldColumns : null;

        if (customFieldColumns) {
            Object.entries(customFieldColumns).forEach(([index, column]) => {
                if (column.cf === this.orig_header) {
                    jQuery('#wdt-wp-query-cf-header-' + (parseInt(index) + 1)).val(this.display_header);
                    wpdatatable_config.queryParameters.customFieldColumns[parseInt(index)].column_header = this.display_header;
                }
            });
        }
    }

    // Reorder columns if columns position is changed
    var oldPos = this.pos;
    this.pos = jQuery('#wdt-column-position').val() > wpdatatable_config.columns.length - 1 ?
        wpdatatable_config.columns.length - 1 : parseInt(jQuery('#wdt-column-position').val());
    if (this.pos < 0) {
        this.pos = 0
    }
    if (oldPos != this.pos) {
        if (oldPos < this.pos) {
            for (var i = 0; i < wpdatatable_config.columns.length; i++) {
                if (i > oldPos && i <= this.pos) {
                    --wpdatatable_config.columns[i].pos;
                }
            }
        } else {
            for (i in wpdatatable_config.columns) {
                if (i >= this.pos && i < oldPos) {
                    ++wpdatatable_config.columns[i].pos;
                }
            }
        }
    }

    this.text_before = jQuery('#wdt-column-display-text-before').val();
    this.text_after = jQuery('#wdt-column-display-text-after').val();
    this.hide_on_mobiles = jQuery('#wdt-hide-column-on-mobiles').is(':checked') ? 1 : 0;
    this.hide_on_tablets = jQuery('#wdt-hide-column-on-tablets').is(':checked') ? 1 : 0;
    this.css_class = jQuery('#wdt-column-css-class').val();
    this.linkTargetAttribute = jQuery('#wdt-link-target-attribute').is(':checked') ? '_blank' : '_self';
    this.linkNoFollowAttribute = jQuery('#wdt-link-nofollow-attribute').is(':checked') ? 1 : 0;
    this.linkNoreferrerAttribute = jQuery('#wdt-link-noreferrer-attribute').is(':checked') ? 1 : 0;
    this.linkSponsoredAttribute = jQuery('#wdt-link-sponsored-attribute').is(':checked') ? 1 : 0;
    this.linkButtonAttribute = jQuery('#wdt-link-button-attribute').is(':checked') ? 1 : 0;
    this.linkButtonLabel = jQuery('#wdt-link-button-label').val();
    this.linkButtonClass = jQuery('#wdt-link-button-class').val();
    this.transformValueText = jQuery('#wdt-column-transform-value').val();


    // If group is checked ungroup all other columns
    if (jQuery('#wdt-group-column').is(':checked')) {
        for (i in wpdatatable_config.columns) {
            wpdatatable_config.columns[i].groupColumn =
                wpdatatable_config.columns[i].orig_header != this.orig_header ? 0 : 1;
        }
    } else {
        this.groupColumn = 0;
    }

    this.color = jQuery('#wdt-column-color').val();
    this.visible = jQuery('#wdt-column-visible').is(':checked') ? 1 : 0;
    let tempColumnWidth = wpdatatable_config.fixed_layout == 0 ? '' : jQuery('#wdt-column-width').val();
    this.width = tempColumnWidth.indexOf('px') != -1 ? tempColumnWidth.replace('px', '') : tempColumnWidth
    this.decimalPlaces = ((this.type == 'float' || this.type == 'formula') && jQuery('#wdt-column-decimal-places').val() != '') ?
        jQuery('#wdt-column-decimal-places').val() : -1;
    if (jQuery.inArray(this.type, ['date', 'datetime']) !== -1) {
        this.dateInputFormat = jQuery('#wdt-date-input-format').selectpicker('val');
    }
    this.possibleValuesType = jQuery('#wdt-column-values').val();
    if (this.possibleValuesType == 'list') {
        this.valuesList = jQuery('#wdt-column-values-list').val().replace(/,/g, '|');
    }
    if (this.possibleValuesType == 'foreignkey') {
        this.foreignKeyRule.allowAllPossibleValuesForeignKey = jQuery('#wdt-possible-values-foreign-keys').is(':checked') ? 1 : 0;
    }
    this.possibleValuesAddEmpty = jQuery('#wdt-column-values-add-empty').is(':checked') ? 1 : 0;
    this.possibleValuesAjax = jQuery('#wdt-possible-values-ajax').val();
    this.column_align_header = jQuery('#wdt-column-align-header').val();
    this.column_align_fields = jQuery('#wdt-column-align-fields').val();
    this.column_rotate_header_name = jQuery('#wdt-column-rotate-header-name').val();
    this.calculateTotal = (jQuery('#wdt-column-calc-total').is(':checked') && (this.type == 'int' || this.type == 'float' || this.type == 'formula')) ? 1 : 0;
    this.calculateAvg = (jQuery('#wdt-column-calc-avg').is(':checked') && (this.type == 'int' || this.type == 'float' || this.type == 'formula')) ? 1 : 0;
    this.calculateMax = (jQuery('#wdt-column-calc-max').is(':checked') && (this.type == 'int' || this.type == 'float' || this.type == 'formula')) ? 1 : 0;
    this.calculateMin = (jQuery('#wdt-column-calc-min').is(':checked') && (this.type == 'int' || this.type == 'float' || this.type == 'formula')) ? 1 : 0;
    this.skip_thousands_separator = jQuery('#wdt-column-skip-thousands').is(':checked') ? 1 : 0;
    this.sorting = jQuery('#wdt-column-allow-sorting').is(':checked') ? 1 : 0;
    this.defaultSortingColumn = jQuery('#wdt-column-default-sort').is(':checked') ? 1 : 0;

    // If default sort column is checked remove default sort column for all other columns
    if (jQuery('#wdt-column-default-sort').is(':checked')) {
        for (i in wpdatatable_config.columns) {
            wpdatatable_config.columns[i].defaultSortingColumn =
                wpdatatable_config.columns[i].orig_header != this.orig_header ? 0 : 1;
        }
        this.defaultSortingColumn = jQuery('#wdt-column-default-sorting-direction').val() == 1 ? 1 : 2;
    } else {
        this.defaultSortingColumn = 0;
    }

    this.filter_type = jQuery('#wdt-column-enable-filter').is(':checked') ?
        jQuery('#wdt-column-filter-type').val() :
        'none';
    this.exactFiltering = jQuery('#wdt-column-exact-filtering').is(':checked') ? 1 : 0;
    this.filterLabel = jQuery('#wdt-column-filter-label').val();
    this.globalSearchColumn = jQuery('#wdt-column-enable-global-search').is(':checked') ? 1 : 0;
    this.searchInSelectBox = jQuery('#wdt-search-in-selectbox').is(':checked') ? 1 : 0;
    if (this.filter_type == 'none') {
        this.filterDefaultValue = null;
    } else if (jQuery.inArray(this.filter_type, ['text', 'number']) != -1) {
        this.filterDefaultValue = jQuery('#wdt-filter-default-value').val();
    } else if (jQuery.inArray(this.filter_type, ['number-range', 'date-range', 'datetime-range', 'time-range']) != -1) {
        this.filterDefaultValue = jQuery('#wdt-filter-default-value-from').val() + '|' + jQuery('#wdt-filter-default-value-to').val();
    } else {
        this.filterDefaultValue = jQuery.isArray(jQuery('#wdt-filter-default-value-selectpicker').selectpicker('val')) ?
            jQuery('#wdt-filter-default-value-selectpicker').selectpicker('val').join('|') :
            jQuery('#wdt-filter-default-value-selectpicker').selectpicker('val');

        this.andLogic = jQuery('#wdt-and-logic').is(':checked') ? 1 : 0;

        if (this.parent_table.filtering_form === 1) {
            this.checkboxesInModal = ((jQuery('#wdt-checkboxes-in-modal').is(':checked') && this.filter_type === 'checkbox')) ? 1 : 0;
        }
    }
    this.editor_type = 'text';
    if (jQuery('#wdt-column-editor-input-type').length) {
        this.editor_type = this.type === 'formula' ? 'none' : jQuery('#wdt-column-editor-input-type').val();
    }
    this.editingNonEmpty = 0;
    if (jQuery('#wdt-column-not-null').length) {
        this.editingNonEmpty = jQuery('#wdt-column-not-null').is(':checked') ? 1 : 0;
    }

    this.searchInSelectBoxEditing = jQuery('#wdt-search-in-selectbox-editing').is(':checked') ? 1 : 0;
    this.rangeSlider = jQuery('#wdt-column-range-slider').is(':checked') ? 1 : 0;
    this.rangeMaxValueDisplay = jQuery('#wdt-max-value-display').selectpicker('val');
    this.customMaxRangeValue = jQuery('#wdt-custom-max-value').val();

    if (typeof callbackApplyUIChangesForNewColumnOption !== 'undefined') {
        callbackApplyUIChangesForNewColumnOption(this);
    }
    this.editingDefaultValue = '';
    if (jQuery('#wdt-editing-default-value').length) {
        if (jQuery.inArray(this.editor_type, ['selectbox', 'multi-selectbox']) != -1) {
            this.editingDefaultValue = jQuery.isArray(jQuery('#wdt-editing-default-value-selectpicker').selectpicker('val')) ?
                jQuery('#wdt-editing-default-value-selectpicker').selectpicker('val').join('|') :
                jQuery('#wdt-editing-default-value-selectpicker').selectpicker('val');
        } else if (jQuery.inArray(this.editor_type, ['link']) != -1) {
            let urlValue = jQuery('#wdt-editing-default-value').val();
            if (!(/^https?:\/\/.*\..*/.test(urlValue) || urlValue === '')) {
                this.editingDefaultValue = "http://" + urlValue;
            } else this.editingDefaultValue = jQuery('#wdt-editing-default-value').val();
            jQuery('#wdt-editing-default-value').val(this.editingDefaultValue);
        } else if (jQuery.inArray(this.editor_type, ['hidden']) != -1) {
            let hiddenValue = jQuery('#wdt-editing-hidden-default-value-selectpicker').selectpicker('val')
            if (jQuery.inArray(hiddenValue, ['query-param', 'post-meta', 'acf-data']) != -1) {
                let hiddenParamValue = jQuery('.wdt-editing-hidden-' + hiddenValue + '-value').val()
                this.editingDefaultValue = hiddenValue + ':' + hiddenParamValue
            } else {
                this.editingDefaultValue = hiddenValue
            }
        } else {
            this.editingDefaultValue = jQuery('#wdt-editing-default-value').val();
        }
    }
    this.compileConditionalFormattingRules();
    this.columnTransformValue();

    this.hide();
};

/**
 * Return all settings in an object format
 * @return allColumnSettings
 */
WDTColumn.prototype.getJSON = function () {

    var allColumnSettings = {
        calculateAvg: this.calculateAvg,
        calculateMax: this.calculateMax,
        calculateMin: this.calculateMin,
        calculateTotal: this.calculateTotal,
        checkboxesInModal: this.checkboxesInModal,
        andLogic: this.andLogic,
        color: this.color,
        conditional_formatting: this.conditional_formatting,
        css_class: this.css_class,
        dateInputFormat: this.dateInputFormat,
        decimalPlaces: this.decimalPlaces,
        defaultSortingColumn: this.defaultSortingColumn,
        display_header: this.display_header,
        editingDefaultValue: this.editingDefaultValue,
        editingNonEmpty: this.editingNonEmpty,
        searchInSelectBoxEditing: this.searchInSelectBoxEditing,
        editor_type: this.editor_type,
        exactFiltering: this.exactFiltering,
        filter_type: this.filter_type,
        filterDefaultValue: this.filterDefaultValue,
        searchInSelectBox: this.searchInSelectBox,
        filtering: this.filtering,
        globalSearchColumn: this.globalSearchColumn,
        filterLabel: this.filterLabel,
        foreignKeyRule: this.foreignKeyRule,
        formula: this.formula,
        groupColumn: this.groupColumn,
        hide_on_mobiles: this.hide_on_mobiles,
        hide_on_tablets: this.hide_on_tablets,
        id: this.id,
        id_column: this.id_column,
        linkTargetAttribute: this.linkTargetAttribute,
        linkNoFollowAttribute: this.linkNoFollowAttribute,
        linkNoreferrerAttribute: this.linkNoreferrerAttribute,
        linkSponsoredAttribute: this.linkSponsoredAttribute,
        linkButtonAttribute: this.linkButtonAttribute,
        linkButtonLabel: this.linkButtonLabel,
        linkButtonClass: this.linkButtonClass,
        orig_header: this.orig_header,
        pos: this.pos,
        possibleValuesAddEmpty: this.possibleValuesAddEmpty,
        possibleValuesType: this.possibleValuesType,
        possibleValuesAjax: this.type === 'string' ? this.possibleValuesAjax : -1,
        column_align_fields: this.column_align_fields,
        rangeSlider: this.rangeSlider,
        rangeMaxValueDisplay: this.rangeMaxValueDisplay,
        customMaxRangeValue: this.customMaxRangeValue,
        skip_thousands_separator: this.skip_thousands_separator,
        column_align_header: this.column_align_header,
        sorting: this.sorting,
        text_after: this.text_after,
        text_before: this.text_before,
        type: this.type,
        valuesList: this.valuesList,
        visible: this.visible,
        width: this.width,
        column_rotate_header_name: this.column_rotate_header_name,
        transformValueText: this.transformValueText
    };

    if (typeof callbackExtendOptionInObjectFormat !== 'undefined') {
        callbackExtendOptionInObjectFormat(allColumnSettings, this);
    }

    return allColumnSettings;

};
jQuery(document).on('click',
    '#wdt-select-all-column-tablet-visibility, ' +
    '#wdt-select-all-column-mobile-visibility, ' +
    '#wdt-select-all-column-visibility, ' +
    '#wdt-select-all-column-sorting, ' +
    '#wdt-select-all-column-filters, ' +
    '#wdt-select-all-column-global-search, ' +
    '#wdt-select-all-column-editing', function (e) {
        jQuery(this).toggleClass('select-all-columns deselect-all-columns');
    });

/**
 * Renders a small block for this column in the list (in the columns quickaccess modal, and in the formula editor)
 */
WDTColumn.prototype.renderSmallColumnBlock = function (columnIndex) {
    var columnHtml = jQuery('#wdt-column-small-block').html();

    // Adding to the columns quickaccess modal
    var $columnBlock = jQuery(columnHtml).appendTo('#wdt-columns-list-modal div.wdt-columns-container');
    this.display_header != '' ?
        $columnBlock.find('div.fg-line input').val(this.display_header) :
        $columnBlock.find('div.fg-line input').val(this.orig_header);
    $columnBlock.attr('data-orig_header', this.orig_header);
    var column = this;

    var checkbox = jQuery('#wdt-select-all-column-tablet-visibility');

    jQuery('#wdt-select-all-column-tablet-visibility').click(function (e) {
        if (jQuery(this).hasClass('select-all-columns')) {
            column.hide_on_tablets = 0;
            jQuery('i.wdt-toggle-show-on-tablet').removeClass('inactive');
        } else {
            column.hide_on_tablets = 1;
            jQuery('i.wdt-toggle-show-on-tablet').addClass('inactive')
        }
    });

    jQuery('#wdt-select-all-column-mobile-visibility').click(function (e) {
        if (jQuery(this).hasClass('select-all-columns')) {
            column.hide_on_mobiles = 0;
            jQuery('i.wdt-toggle-show-on-mobile').removeClass('inactive')
        } else {
            column.hide_on_mobiles = 1;
            jQuery('i.wdt-toggle-show-on-mobile').addClass('inactive')
        }
    });

    jQuery('#wdt-select-all-column-visibility').click(function (e) {
        if (jQuery(this).hasClass('select-all-columns')) {
            column.visible = 0;
            jQuery('i.toggle-visibility').addClass('inactive')
        } else {
            column.visible = 1;
            jQuery('i.toggle-visibility').removeClass('inactive')
        }
    });

    jQuery('#wdt-select-all-column-sorting').click(function (e) {
        if (jQuery(this).hasClass('select-all-columns')) {
            column.sorting = 0;
            jQuery('i.wdt-toggle-show-sorting').addClass('inactive')
        } else {
            column.sorting = 1;
            jQuery('i.wdt-toggle-show-sorting').removeClass('inactive')
        }
    });

    jQuery('#wdt-select-all-column-filters').click(function (e) {
        if (jQuery(this).hasClass('select-all-columns')) {
            column.filter_type = 'text';
            jQuery('i.wdt-toggle-show-filters').removeClass('inactive')
            if (!column.globalSearchColumn) {
                column.globalSearchColumn = 1;
                jQuery('i.wdt-toggle-global-search').removeClass('inactive');
            }
        } else {
            column.filter_type = 'none';
            jQuery('i.wdt-toggle-show-filters').addClass('inactive')
        }
    });

    jQuery('#wdt-select-all-column-global-search').click(function (e) {
        if (jQuery(this).hasClass('select-all-columns')) {
            column.globalSearchColumn = 0;
            jQuery('i.wdt-toggle-global-search').addClass('inactive')
            jQuery('i.wdt-toggle-show-filters')
                .addClass('inactive');
            column.filter_type = "none";
        } else {
            column.globalSearchColumn = 1;
            jQuery('i.wdt-toggle-global-search').removeClass('inactive')
            jQuery('i.wdt-toggle-show-filters')
                .removeClass('inactive');
            column.filter_type = "text";
        }
    });

    jQuery('#wdt-select-all-column-editing').click(function (e) {
        if (jQuery(this).hasClass('deselect-all-columns')) {
            column.editor_type = 'text';
            jQuery('i.wdt-toggle-enable-editing')
                .removeClass('inactive');
        } else {
            column.editor_type = 'none';
            jQuery('i.wdt-toggle-enable-editing')
                .addClass('inactive');
        }
    });

    if (parseInt(columnIndex) === column.parent_table.columns.length - 1) {
        jQuery('#wdt-select-all-column-global-search',
            '#wdt-select-all-column-filters',
            '#wdt-select-all-column-sorting',
            '#wdt-select-all-column-visibility',
            '#wdt-select-all-column-mobile-visibility',
            '#wdt-select-all-column-tablet-visibility',
            '#wdt-select-all-column-editing'
        ).removeAttr('checked');
    }

    /**
     * Quick visibility toggle
     */
    $columnBlock.find('i.toggle-visibility').click(function (e) {
        e.preventDefault();
        if (!column.visible) {
            column.visible = 1;
            jQuery(this)
                .removeClass('inactive')
        } else {
            column.visible = 0;
            jQuery(this)
                .addClass('inactive')
        }
    });
    if (!column.visible) {
        $columnBlock.find('i.toggle-visibility')
            .addClass('inactive')
    }

    $columnBlock.find('i.wdt-toggle-show-on-mobile').click(function (e) {
        e.preventDefault();
        if (column.hide_on_mobiles) {
            column.hide_on_mobiles = 0;
            jQuery(this)
                .removeClass('inactive')
        } else {
            column.hide_on_mobiles = 1;
            jQuery(this)
                .addClass('inactive')
        }
    });

    if (column.hide_on_mobiles) {
        $columnBlock.find('i.wdt-toggle-show-on-mobile')
            .addClass('inactive')
    }

    $columnBlock.find('i.wdt-toggle-show-on-tablet').click(function (e) {
        e.preventDefault();
        if (column.hide_on_tablets) {
            column.hide_on_tablets = 0;
            jQuery(this)
                .removeClass('inactive')
        } else {
            column.hide_on_tablets = 1;
            jQuery(this)
                .addClass('inactive')
        }
    });

    if (column.hide_on_tablets) {
        $columnBlock.find('i.wdt-toggle-show-on-tablet')
            .addClass('inactive')
    }

    /**
     *    Show/hide filters in List of the columns in the data source with quickaccess tools.
     */

    $columnBlock.find('i.wdt-toggle-show-filters').click(function (e) {
        e.preventDefault();
        if (column.filter_type == 'none') {
            column.filter_type = 'text';
            jQuery(this)
                .removeClass('inactive');
            if (!column.globalSearchColumn) {
                column.globalSearchColumn = 1;
                $columnBlock.find('i.wdt-toggle-global-search').removeClass('inactive');
            }
        } else {
            column.filter_type = 'none';
            jQuery(this)
                .addClass('inactive')
        }
    });

    if (column.filter_type == 'none') {
        $columnBlock.find('i.wdt-toggle-show-filters')
            .addClass('inactive')
    }

    /**
     *   Show/hide sorting in List of the columns in the data source with quickaccess tools.
     */

    $columnBlock.find('i.wdt-toggle-show-sorting').click(function (e) {
        e.preventDefault();
        if (!column.sorting) {
            column.sorting = 1;
            jQuery(this)
                .removeClass('inactive')
        } else {
            column.sorting = 0;
            jQuery(this)
                .addClass('inactive')

        }
    });

    if (!column.sorting) {
        $columnBlock.find('i.wdt-toggle-show-sorting')
            .addClass('inactive')
    }

    /**
     *  Enable/disable editing in List of the columns in the data source with quickaccess tools.
     */

    $columnBlock.find('i.wdt-toggle-enable-editing').click(function (e) {
        e.preventDefault();
        if (column.editor_type == 'none') {
            column.editor_type = 'text';
            jQuery(this)
                .removeClass('inactive')
        } else {
            column.editor_type = 'none';
            jQuery(this)
                .addClass('inactive')
        }
    });

    if (column.editor_type == 'none') {
        $columnBlock.find('i.wdt-toggle-enable-editing')
            .addClass('inactive')
    }

    if (typeof callbackExtendSmallBlock !== 'undefined') {
        callbackExtendSmallBlock($columnBlock, column);
    }

    /**
     * Enable/disable global search for a column
     */
    $columnBlock.find('i.wdt-toggle-global-search').click(function (e) {
        e.preventDefault();
        if (column.globalSearchColumn) {
            column.globalSearchColumn = 0;
            jQuery(this)
                .addClass('inactive');
            $columnBlock.find('i.wdt-toggle-show-filters')
                .addClass('inactive');
            column.filter_type = "none";
        } else {
            column.globalSearchColumn = 1;
            jQuery(this)
                .removeClass('inactive');
            $columnBlock.find('i.wdt-toggle-show-filters')
                .removeClass('inactive');
            column.filter_type = "text";
        }
    });

    if (!column.globalSearchColumn) {
        $columnBlock.find('i.wdt-toggle-global-search')
            .addClass('inactive');
    }

    /**
     * Open column settings on wrench click
     */
    $columnBlock.find('i.open-settings').click(function (e) {
        e.preventDefault();
        jQuery('#wdt-columns-list-modal').modal('hide');
        wpdatatable_config.showColumn(columnIndex);
    });

    // Adding to the formula editor
    if (this.type == 'int' || this.type == 'float') {
        $columnBlock = jQuery(columnHtml).appendTo('#wdt-formula-editor-modal div.formula-columns-container');
        $columnBlock.find('div.fg-line input').replaceWith('<span>' + this.display_header + '</span>');
        $columnBlock.attr('data-orig_header', this.orig_header);
        $columnBlock.find('i.column-control').remove();
    }

    if (this.type != '') {

        $columnBlock = jQuery(columnHtml).appendTo('#column-transform-value div.transform-value-container');
        $columnBlock.find('div.fg-line input').replaceWith('<span style="width: 30%">' + this.display_header + ':' + '</span>');
        $columnBlock.attr('data-orig_header', this.display_header);
        $columnBlock = jQuery(columnHtml).appendTo('#column-transform-value div.transform-value-shortcodes-container');
        $columnBlock.find('div.fg-line input').replaceWith('<span>' + '{' + this.orig_header + '.value}' + '</span>');
        $columnBlock.attr('data-orig_header', this.orig_header);
    }

    if (this.type == 'formula') {
        $columnBlock.find('.formula-remove-option').remove();
    }

};

/**
 * Populate Column For Editing And User Selectpicker
 */
WDTColumn.prototype.populateColumnForEditing = function () {
    var $selecter = jQuery('#editing-settings #wdt-id-editing-column');

    jQuery('<option value="' + this.id + '">' + this.orig_header + '</option>')
        .appendTo($selecter);

    if (this.id_column) {
        $selecter.selectpicker('val', this.id);
        wpdatatable_config.id_editing_column = true;
    }
};

/**
 * Populate User ID Column Selectpicker
 */
WDTColumn.prototype.populateUserIdColumn = function () {
    var $selecter = jQuery('#editing-settings #wdt-user-id-column');

    jQuery('<option value="' + this.id + '">' + this.orig_header + '</option>').appendTo($selecter);
};

/**
 * Helper function to enable/disable option and field
 */
WDTColumn.prototype.toggleColumnOption = function (type, isEnabled, showBlockSelector = '') {
    const optionSelector = `#wdt-column-type option[value="${type}"]`;
    const fieldSelector = '#wdt-column-type';

    jQuery(optionSelector).prop('disabled', isEnabled ? '' : 'disabled');

    jQuery(fieldSelector).prop('disabled', isEnabled ? 'disabled' : '');

    if (showBlockSelector) {
        jQuery(showBlockSelector).toggle(isEnabled);
    }
};