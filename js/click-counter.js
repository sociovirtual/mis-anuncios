jQuery(document).ready(function ($) {
  $(document).on("click", ".mi-anuncio-ad-link", function (e) {
    e.preventDefault();
    var post_id = $(this).data("postid");
    var ad_link = $(this).attr("href");
    $.ajax({
      url: mi_anuncio_ajax.url,
      type: "post",
      data: {
        action: "mi_anuncio_increment_click_count",
        post_id: post_id,
        nonce: mi_anuncio_ajax.nonce,
      },
      success: function (response) {
        if (response.success) {
          $(".mi-anuncio-click-count").text(
            "Clicks: " + response.data.click_count
          );
          window.open(ad_link, "_blank");
        } else {
          console.error("Error en la solicitud AJAX:", response.error);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX:", error);
      },
    });
  });
});
