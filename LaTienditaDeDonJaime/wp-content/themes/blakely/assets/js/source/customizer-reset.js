jQuery(function(s) {
    var e = [
        ["#customize-theme-controls", "all", "ct-reset", "ct-reset-main", photoFocusCustomizerReset.confirm, photoFocusCustomizerReset.reset],
        ["#_customize-input-blakely_footer_content", "footer_options", "ct-footer-reset", "ct-reset-section", photoFocusCustomizerReset.confirmSection, photoFocusCustomizerReset.resetSection],
        ["#_customize-input-blakely_section_title_font", "fonts", "ct-fonts-reset", "ct-reset-section", photoFocusCustomizerReset.confirmSection, photoFocusCustomizerReset.resetSection],
        ["#blakely_sortable_value", "sorter", "ct-sorter-reset", "ct-reset-section", photoFocusCustomizerReset.confirmSection, photoFocusCustomizerReset.resetSection]
    ];
    s.each(e, function(e, o) {
        var t = s(o[0]),
            c = s('<input type="submit" name="' + o[2] + '" id="' + o[2] + '" class="ct-reset ' + o[3] + ' button-secondary button">').attr("value", o[5]);
        c.on("click", function(e) {
            e.preventDefault();
            var t = {
                wp_customize: "on",
                action: "customizer_reset",
                nonce: photoFocusCustomizerReset.nonce.reset,
                section: o[1]
            };
            confirm(o[4]) && (s(".spinner").css("visibility", "visible"), c.attr("disabled", "disabled"), s.post(ajaxurl, t, function() {
                wp.customize.state("saved").set(!0), location.reload()
            }))
        }), t.after(c)
    })
});
