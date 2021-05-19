jQuery(document).ready(function($) {

    var title = window.jQuery('.wp-heading-inline');
    title.after('<div class="buttons_menu"></div>');

    var menuContainer = window.jQuery('.buttons_menu');

    var addProductBtn = window.jQuery('a.page-title-action');

    var importBtn = window.jQuery('#form_json');
    var importOrigBtn = window.jQuery('#formOriginal_json');
    var importAllBtn = window.jQuery('#formAll_json');

    var exportBtn = window.jQuery('#export_json');
    var exportAllBtn = window.jQuery('#exportAll_json');

    var info1 = window.jQuery('#info');

    addProductBtn.appendTo(menuContainer);

    importBtn.appendTo(menuContainer);
    importAllBtn.appendTo(menuContainer);
    importOrigBtn.appendTo(menuContainer);

    exportBtn.appendTo(menuContainer);
    exportAllBtn.appendTo(menuContainer);

    info1.appendTo(window.jQuery('.wp-heading-inline'));
});