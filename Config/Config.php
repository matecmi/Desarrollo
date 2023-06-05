<?php 
	//const BASE_URL = "https://bmbijou.com";
	const BASE_URL = "http://localhost:86";
/////////////////////////////
	//Zona horaria
	date_default_timezone_set('America/Lima');

	//Datos de conexión a Base de Datos
	const DB_HOST = "192.168.18.155:3323";
    //const DB_HOST = "192.168.18.35:3323";
	const DB_NAME = "userbmbijou_tienda_virutal_db";
	const DB_USER = "root";
	const DB_PASSWORD = "12345678";
	const DB_CHARSET = "utf8";

	//Producción
	//const DB_HOST = "localhost";
	//const DB_NAME = "userbmbijou_tienda_virutal_db";
	//const DB_USER = "userbmbijou_web";
	//const DB_PASSWORD = "ing&tal2023@";
	//const DB_CHARSET = "utf8";

	//Para envío de correo
	const ENVIRONMENT = 0; // Local: 0, Produccón: 1;

	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbolo de moneda
	const SMONEY = "S/";
	const CURRENCY = "PEN";

	//Api PayPal
	//SANDBOX PAYPAL
	const URLPAYPAL = "https://api-m.sandbox.paypal.com";
	const IDCLIENTE = "AYcF2p8R-9gV_iUQ1AGdOz_6vOAc_jwwUSfCC4FQr6bWLT_7_d4mbDFrv1ulNnelVZcicrJwgwVwJIRF";
	const SECRET = "EIhyWpvOuPhIBhTKG54dyTJ2HtFc-EbegpQgsyqQkHKqRzZTu0zzdHr9_M7A7u25hNG0o_NySx8wBuCt";
	//LIVE PAYPAL
	//const IDCLIENTE = "AWBtVubwv1loCQFkpbwVdxw3GN9v4wj8ieLQPCpm8i8v0iwHSO_wc1_fWPNqldrcrPh1RqQ1bIcZPKWD";
	//const URLPAYPAL = "https://api-m.paypal.com";
	//const SECRET = "ELCYtuxTFft8kEuAhcg8jE7_Bi31BnMd8E4DilpsnnsgXnZRUA8AKiXHwOVSPVu7xFIDZYw_6AjXulyC";

	//Datos envio de correo
	const NOMBRE_REMITENTE = "Bmbijou - Tienda virtual";
	const EMAIL_REMITENTE = "rmerinoa@hotmail.com";
	const NOMBRE_EMPESA = "Bmbijou - Tienda virtual";
	const BIENVENIDA_EMAIL = "BIENVENID@ A BMBIJOU";
	const WEB_EMPRESA = "https://bmbijou.com/";

	const DESCRIPCION = "La mejor tienda en línea con artículos de moda.";
	const SHAREDHASH = "TiendaVirtual";

	//Datos Empresa
	const DIRECCION = "Piura - Perú";
	const TELEMPRESA = "+(51)949160993";
	const WHATSAPP = "+51949160993";
	const EMAIL_EMPRESA = "rmerinoa@hotmail.com";
	const EMAIL_PEDIDOS = "rmerinoa@hotmail.com"; 
	const EMAIL_SUSCRIPCION = "rmerinoa@hotmail.com";
	const EMAIL_CONTACTO = "rmerinoa@hotmail.com";

	const CAT_SLIDER = "1,2,3";
	const CAT_BANNER = "4,5,6";
	const CAT_FOOTER = "1,2,3,4,5";

	//Datos para Encriptar / Desencriptar
	const KEY = 'ingytal';
	const METHODENCRIPT = "AES-128-ECB";

	//Envío
	const COSTOENVIO = 50;

	//Módulos
	const MDASHBOARD = 1;
	const MUSUARIOS = 2;
	const MCLIENTES = 3;
	const MPRODUCTOS = 4;
	const MPEDIDOS = 5;
	const MCATEGORIAS = 6;
	const MSUSCRIPTORES = 7;
	const MDCONTACTOS = 8;
	const MDPAGINAS = 9;
	const MDDESCUENTOS = 10;
	const MDLANDINGPAGES = 11;
	const MDCATALOGOS = 12;
	const MDPRECIOENVIOS = 13;
	const MDLANDINGPAGESREPORTES = 14;

	//Páginas
	const PINICIO = 1;
	const PTIENDA = 2;
	const PCARRITO = 3;
	const PNOSOTROS = 4;
	const PCONTACTO = 5;
	const PPREGUNTAS = 6;
	const PTERMINOS = 7;
	const PSUCURSALES = 8;
	const PERROR = 9;

	//Roles
	const RADMINISTRADOR = 1;
	const RSUPERVISOR = 2;
	const RCLIENTES = 3;

	const STATUS = array('Completo','Aprobado','Cancelado','Reembolsado','Pendiente','Entregado');

	//Productos por página
	const CANTPORDHOME = 8;
	const PROPORPAGINA = 4;
	const PROCATEGORIA = 4;
	const PROBUSCAR = 4;

	//REDES SOCIALES
	const FACEBOOK = "https://www.facebook.com/profile.php?id=100075928885130";
	const INSTAGRAM = "https://www.instagram.com/bm.bijou/";

 ?>