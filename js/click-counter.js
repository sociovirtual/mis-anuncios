jQuery(document).ready(function ($) {
  // Delegar el evento de clics a un elemento superior para mejorar la eficiencia
  $(document).on("click", ".mi-anuncio-ad-link", function (e) {
    e.preventDefault();

    // Obtener datos del enlace del anuncio
    var post_id = $(this).data("postid");
    var ad_link = $(this).attr("href");

    // Realizar la solicitud AJAX
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
          // Actualizar el contador de clics en la página
          $(".mi-anuncio-click-count").text(
            "Clicks: " + response.data.click_count
          );

          // Redirigir al enlace del anuncio en una nueva ventana/tabulador
          window.open(ad_link, "_blank");
        } else {
          // Manejar errores (puedes agregar más detalles según tus necesidades)
          console.error("Error en la solicitud AJAX:", response.error);
        }
      },
      error: function (xhr, status, error) {
        // Manejar errores de conexión o del servidor
        console.error("Error en la solicitud AJAX:", error);
      },
    });
  });
});
