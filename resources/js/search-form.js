$(function () {
    $("#search-form").submit(function () {
        // Disable empty input before submit, prevent dirty url
        $(this).find(":input").filter(function () {
            return !this.value;
        }).attr("disabled", "disabled");
        return true;
    });
});
