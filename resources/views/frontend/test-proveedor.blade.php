<!DOCTYPE html>
<html>
<head>
    <title>Test Proveedor</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Proveedor</h1>
    
    <div id="result"></div>
    
    <form id="testForm">
        <input type="text" name="Identificacion" placeholder="Identificación" required><br><br>
        <input type="text" name="Nombre" placeholder="Nombre" required><br><br>
        <input type="text" name="Telefono" placeholder="Teléfono" required><br><br>
        <input type="email" name="Correo" placeholder="Correo" required><br><br>
        <input type="number" name="ID_producto" placeholder="ID Producto (opcional)"><br><br>
        <button type="submit">Crear Proveedor</button>
    </form>
    
    <script>
        document.getElementById('testForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const resultDiv = document.getElementById('result');
            
            try {
                const response = await fetch('/test-proveedor', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    resultDiv.innerHTML = '<p style="color: #00d4ff;">¡Proveedor creado exitosamente! ID: ' + data.id + '</p>';
                    this.reset();
                } else {
                    resultDiv.innerHTML = '<p style="color: red;">Error: ' + data.error + '</p>';
                }
            } catch (error) {
                resultDiv.innerHTML = '<p style="color: red;">Error de conexión: ' + error.message + '</p>';
            }
        });
        
        // Probar conexión al cargar la página
        fetch('/test-proveedor')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('result').innerHTML = '<p style="color: blue;">Conexión a BD OK. Proveedores existentes: ' + data.count + '</p>';
                } else {
                    document.getElementById('result').innerHTML = '<p style="color: red;">Error de BD: ' + data.error + '</p>';
                }
            })
            .catch(error => {
                document.getElementById('result').innerHTML = '<p style="color: red;">Error de conexión: ' + error.message + '</p>';
            });
    </script>
</body>
</html>
