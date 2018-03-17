function checkInputs() {

    let autocomplete    = $('#autocomplete').attr('value');
    let autocomplete2   = $('#autocomplete2').attr('value');

    return ((autocomplete === undefined || autocomplete === null || autocomplete === "") ||
    (autocomplete2 === undefined || autocomplete2 === null || autocomplete2 === ""));
}

