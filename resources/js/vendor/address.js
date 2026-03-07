import $ from "jquery";
$(function () {
    $("#postal_2").on("input", function () {
        const postal_1 = $("#postal_1").val();
        const postal_2 = $("#postal_2").val();

        const postal_code = postal_1 + postal_2;

        $.getJSON(
            "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" + postal_code,
        ).done(function (data) {
            if (data.results) {
                $("#prefecture")
                    .val(data.results[0].address1)
                    .trigger("input")
                    .trigger("change");
                $("#city")
                    .val(data.results[0].address2)
                    .trigger("input")
                    .trigger("change");
            }
        });
    });
});
