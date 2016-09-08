
sql                                                                                                                                                                                                                                                                                    
---------------------------------------------------------------------------------------------                                                                                                                                                                                          
CREATE TABLE atributo(
	id integer primary key autoincrement not null,
	nombre varchar(255) not null,
	tipo varchar(255) not null,
	descripcion text,
	idCategoria integer not null references categoria(id),
	esFiltro integer default 0 /* 1 si, 0 no */
, esGrupo integer default 0)
CREATE TABLE sqlite_sequence(name,seq)                                                                                                                                                                                                                                                 
CREATE TABLE atributo_producto(
	id integer primary key autoincrement not null,
	idProducto integer not null references producto(id),
	idAtributo integer not null references atributo(id),
	valor varchar(255) not null /* esto es el valor... ejemplo Atributo: color, VALOR: 'rojo' 
CREATE TABLE banner(
	id integer primary key autoincrement not null,
	nombre varchar(120) not null,
	idRecurso integer not null references recurso(id),
	url varchar(255),
	target varchar(16),
	tipo varchar(120),
	estado varchar(255),
	datetime datetime,
	orden float
)           
CREATE TABLE carro(
	id integer primary key autoincrement not null,
	cliente integer references cliente(id),
	fechaModificacion datetime,
	total float,
	despacho float /* costo de despacho */
)                                                                                      
CREATE TABLE categoria(
	id integer primary key autoincrement not null,
	nombre varchar(128) not null,
	padre integer not null default -1 references categoria(id),
	activa integer default 1, /* 1 si, 0 no */
	foto integer references recurso(id),
	banner integer references recurs
CREATE TABLE cliente(
	id integer primary key autoincrement not null,
	usuario varchar(128) not null,
	contrasena varchar(128) not null,
	rut varchar(16),
	nombre varchar(255) not null,
	apellido varchar(255) not null,
	correo varchar(255) not null,
	fechaNacimiento date,
	gener
CREATE TABLE config(
	id integer primary key autoincrement not null,
	nombre varchar(120) UNIQUE not null,
	valor varchar(255) not null,
	estado varchar(120),
	datetime datetime,
	tipo varchar(120)
)                                                                                
                                                                                                                                                                                                                                                                                       
CREATE TABLE contacto(
	id integer primary key autoincrement not null,
	tipo varchar(120) not null,
	nombre varchar(255) not null,
	email varchar(160) not null,
	fono varchar(16) not null,
	mensaje text,
	fecha datetime
)                                                          
CREATE TABLE correo_venta(
	id integer primary key autoincrement not null,
	asunto varchar(120) not null,
	cuerpo text not null,
	adjunto integer references recurso(id)
)                                                                                                             
CREATE TABLE costo_despacho(
	id integer primary key autoincrement not null,
	idZona integer not null references zona(id),
	costo float not null
)                                                                                                                                     
CREATE TABLE cupon(
	id integer primary key autoincrement not null,
	titulo varchar(120) not null,
	codigo varchar(120) not null UNIQUE,
	fechaInicio datetime default CURRENT_TIMESTAMP,
	fechaFin datetime not null,
	activo integer default 1
, giftcard integer default 0)         
                                                                                                                                                                                                                                                                                       
CREATE TABLE cupon_producto(
	id integer primary key autoincrement not null,
	idCupon integer references cupon(id),
	idProducto integer references producto(id),
	descuento float default 0
)                                                                                          
CREATE TABLE cupon_venta(
	id integer primary key autoincrement not null,
	idCupon integer references cupon(id),
	idVenta integer references venta(id)
)                                                                                                                               
CREATE TABLE destacado(
	id integer primary key autoincrement not null,
	titulo varchar(120) not null,
	activo integer default 1, /* 1 si, 0 no */
	fechaInicio datetime,
	fechaFin datetime,
	mostrarHome integer, /* 1 si, 0 no */
	fechaCreacion datetime
)                         
CREATE TABLE direccion(
	id integer primary key autoincrement not null,
	nombre varchar(255) not null,
	receptorNombre varchar(255) not null,
	receptorApellido varchar(255) not null,
	nombreEmpresa varchar(255),
	facturacion integer default 0, /* 1 si, 0 no */
	principal integer
CREATE TABLE elemento_slider_categoria(
	id integer primary key autoincrement not null,
	idSlider integer not null references slider_categoria(id),
	idRecurso integer not null references recurso(id),
	orden float default 0
)                                                       
CREATE TABLE empresa(
	id integer primary key autoincrement not null,
	nombre varchar(255) not null,
	razonSocial varchar(255) not null,
	rut varchar(16) not null,
	giro varchar(255),
	fono varchar(16),
	faz varchar(16),
	correo varchar(255),
	idCliente integer not null referenc
CREATE TABLE estado(
	id integer primary key autoincrement not null,
	descripcion varchar(120) UNIQUE not null,
	correo integer references correo_venta(id)
)                                                                                                                          
                                                                                                                                                                                                                                                                                       
CREATE TABLE factura(
    id integer primary key autoincrement not null,
    idVenta integer references venta(id),
    razon_social text,
    rut text,
    giro text,
    idZona integer references zona(id),
    fono text,
    correo text
, direccion text)                        
CREATE TABLE galeria_texto(
	id integer primary key autoincrement not null,
	idTexto integer not null references texto(id),
	idRecurso integer not null references recurso(id),
	orden float 
)                                                                                        
CREATE TABLE giftcard(
	id integer primary key autoincrement not null,
	codigo varchar(10) unique not null,
	monto float not null,
	archivo text,
	estado char(1) default 'A',
	fechaCreacion datetime default CURRENT_TIMESTAMP,
	fechaUso datetime,
	idCliente integer references cli
                                                                                                                                                                                                                                                                                       
CREATE TABLE historial_venta(
	id integer primary key autoincrement not null,
	idVenta integer not null references venta(id),
	idEstado integer not null references estado(id),
	fechaModificacion datetime default CURRENT_TIMESTAMP
)                                                
CREATE TABLE invitacion(
	id integer primary key autoincrement not null,
	nombre varchar(255) not null,
	apellido varchar(255) not null,
	correo varchar(255) not null,
	fono varchar(16),
	mensaje text,
	fecha datetime,
	referente integer not null references cliente(id)
)        
CREATE TABLE marca(
	id integer primary key autoincrement not null,
	nombre varchar(255) not null,
	descripcion text,
	foto integer references recurso(id),
	activo integer default 1, /* 1 si, 0 no */
	orden float
, fotoProductos integer references recurso(id))                   
CREATE TABLE oferta(
	id integer primary key autoincrement not null,
	idProducto integere references producto(id),
	precio float default 0,
	fechaInicio datetime,
	fechaFin datetime,
	orden float,
	maxCantidad int default 0 /* maxima cantidad de ofertas por compra... 0 => sin li
CREATE TABLE oferta_producto(
	id integer primary key autoincrement not null,
	idProducto integer not null references producto(id),
	idOferta integer not null references oferta(id),
	cantidad integer default 1 /* cantidad del mismo producto en la oferta --> opcional*/
)         
CREATE TABLE pago_venta(
	/* ESTA TABLE CONTIENE TODOS LOS DATOS DE CADA TRANSACCION DE WEBPAY */
	TBK_ORDEN_COMPRA TEXT,
	TBK_TIPO_TRANSACCION TEXT,
	TBK_RESPUESTA TEXT,
	TBK_MONTO TEXT,
	TBK_CODIGO_AUTORIZACION TEXT,
	TBK_FINAL_NUMERO_TARJETA TEXT,
	TBK_FECHA_CONTABLE TEXT,
	T
CREATE TABLE precio_cliente(
	id integer primary key autoincrement not null,
	idProducto integer references producto(id),
	precio float not null,
	tipoCliente varchar(128) not null
)                                                                                                 
CREATE TABLE producto(
	id integer primary key autoincrement not null,
	nombre varchar(120) not null,
	tipo integer references tipo(id),
	descripcion text,
	SKU varchar(120) UNIQUE not null,
    color text,
	tags text,
	stock integer default 0,
	marca integer references marca(id
                                                                                                                                                                                                                                                                                       
CREATE TABLE producto_bkup(
	id integer primary key autoincrement not null,
	nombre varchar(120) not null,
	tipo integer references tipo(id),
	descripcion text,
	SKU varchar(120) UNIQUE not null,
	tags text,
	stock integer default 0,
	marca integer  not null references marca(id)
                                                                                                                                                                                                                                                                                       
CREATE TABLE producto_carro(
	id integer primary key autoincrement not null,
	idCarro integer not null references carro(id),
	idProducto integer not null references producto(id),
	cantidad integer
, descuento float default 0)                                                      
CREATE TABLE producto_categoria(
	id integer primary key autoincrement not null,
	idProducto integer references producto(id),
	idCategoria integer references categoria(id),
	orden float,
	prioridad float
)                                                                          
CREATE TABLE producto_destacado(
	id integer primary key autoincrement not null,
	idProducto integer not null references producto(id),
	idDestacado integer not null references destacado(id),
	orden float,
	activo integer /* 1 si, 0 no */
)                                        
CREATE TABLE recurso(
	id integer primary key autoincrement not null,
	nombre varchar(255) not null,
	mime varchar(120) not null,
	url varchar(255),
	activo integer default 1, /* 1 si, 0 no */
	utlimaModificacion datetime
)                                                        
CREATE TABLE rol_usuario(
	/* MENOR ID, MAYORES PERMISOS */
	id integer primary key autoincrement not null,
	nombre varchar(120) not null	
)                                                                                                                                           
CREATE TABLE seo(
	id integer primary key autoincrement not null,
	url varchar(120) not null,
	title varchar(120) not null,
	descripcion text,
	keywords text,
	datetime datetime
)                                                                                                    
CREATE TABLE slider_categoria(
	id integer primary key autoincrement not null,
	idCategoria integer not null references categoria(id),
	activo integer default 1, /* 1 si, 0 no */
	orden float
)                                                                                      
CREATE TABLE texto(
	id integer primary key autoincrement not null,
	titulo varchar(255) not null,
	cuerpo text not null,
	llave varchar(120), /* esta llave se usa para vincular textos de distintos idiomas entre si; EJ: "condiciones-despacho", "politicas-privacidad", etc */
	idi
CREATE TABLE tipo( /* TAMBIEN CONOCIDO COMO ENVEJICIMIENTO, CALIDAD O CLASE */
	id integer primary key autoincrement not null,
	nombre varchar(120) not null, /* varietal, reserva, reserva especial, etc... */
	activo integer default 1
)                                            
CREATE TABLE tipo_texto(
	id integer primary key autoincrement not null,
	nombre varchar(120) not null
)                                                                                                                                                                               
CREATE TABLE usuario(
	id integer primary key autoincrement not null,
	username varchar(120) not null UNIQUE,
	password varchar(120) not null,
	activo integer default 1,
	rol integer not null references rol_usuario(id),
	creacion datetime default CURRENT_TIMESTAMP
)             
                                                                                                                                                                                                                                                                                       
CREATE TABLE venta(
	id integer primary key autoincrement not null,
	numero varchar(120) not null,
	esFactura integer default 0, /* 1 si, 0 no */
	fecha datetime default CURRENT_TIMESTAMP,
	costoDespacho float default 0,
	total float default 0,
	idCliente integer not null refere
CREATE TABLE venta_detalle(
	id integer primary key autoincrement not null,
	idVenta integer not null references venta(id),
	idProducto integer not null references producto(id),
	cantidad integer default 1, /* si la cantidad es 0 se debe eliminar de la compra */
	precio float no
CREATE TABLE zona(
	id integer primary key autoincrement not null,
	nombre varchar(128) not null,
	codigo varchar(3) not null,
	padre integer not null default -1 references zona(id)
)                                                                                                
