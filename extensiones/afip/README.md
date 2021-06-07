Implementación simple para interactuar con WebService de AFIP y realizar Factura Electrónica Argentina en PHP.

Permite realizar Facturas, Notas de Crédito y Débito: A, B, C M y E con webservice wsfev1 y wsfexv1.

Pasos:

1. copiar carpeta FE
2. Crear una carpeta dentro del mismo con el [cuit] de la persona autorizada en AFIP 
3. Crear dos carpetas dentro de la anterior: ./[cuit]/wsfe y ./[cuit]/wsfex
3. Dentro de dichas carpetas crear tres carpetas más: ./[cuit]./[serviceName]/tmp  ./[cuit]./[serviceName]/token y ./[cuit]./[serviceName]/key
4. Dentro de .key crear dos carpetas ./key/homologacion y ./key/produccion.
   Colocar los certificados generados en afip junto con las claves privadas. con el número de cuit y la extension .pem para el certificado
   y sin extension para arcrivo clave (Ej. 2015065930.pem y 2015065930)

   Ejemplo estructura de archivos
   FE
		20150659303 
			wsfe
				key
					homologacion
						2015065930  (archivo key)
						2015065930.pem
					produccion
				tmp
				token
			wsfex
				key
					homologacion
						2015065930  (archivo key)
						2015065930.pem
					produccion
				tmp
				token
		wsdl
			
				
Test:

1. Editar el archivo prueba.php y modificar el valor de la variable $CUIT por el de la persona autorizada en AFIP.

