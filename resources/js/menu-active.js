
$(function () {
    $(".salon_menu a").each(function () {
        const linkPath = new URL($(this).attr("href"), location.href).pathname;

        if (linkPath === location.pathname) {
            $(this).addClass("is-current").attr("aria-current", "page");
        }
    });
});

$(function () {
    $(".dropdown-toggle").on("click", function () {
        $(".dropdown-menu").toggle();
    });
});
