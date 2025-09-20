document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formAgregarProducto");

    // Agregar producto via AJAX
    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.textContent = "Agregando...";
            submitButton.disabled = true;

            const formData = new FormData(form);

            try {
                const response = await fetch("/productos", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success !== false) {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Producto Agregado!',
                        text: result.message || 'El producto ha sido agregado correctamente',
                        timer: 3000,
                        showConfirmButton: false
                    });

                    // Limpiar formulario
                    form.reset();

                    // Recargar página para mostrar el nuevo producto
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);

                } else {
                    // Mostrar mensaje de error
                    const errorMessage = result.message || result.error || "Error al agregar el producto";
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });

                    // Mostrar errores de validación específicos
                    if (result.errors) {
                        let errorText = "Errores de validación:\n";
                        for (const [field, messages] of Object.entries(result.errors)) {
                            errorText += `• ${field}: ${messages.join(', ')}\n`;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Errores de Validación',
                            text: errorText
                        });
                    }
                }
            } catch (error) {
                console.error("Error al enviar formulario:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Conexión',
                    text: "No se pudo conectar con el servidor. Verifica tu conexión a internet."
                });
            } finally {
                // Restaurar botón
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        });
    }

    // La confirmación de eliminación ahora se maneja con el modal personalizado en el HTML

    console.log("JavaScript de inventario cargado correctamente");
});
