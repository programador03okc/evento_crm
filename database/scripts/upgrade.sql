-- use crmmarketing;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna uuidimportacion
-- FECHA DE CREACIÓN:		26-06-2020
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
CALL SP_ADD_COLUMN_IF_NOT_EXISTS('clientes','uuidimportacion','char(36) collate utf8mb4_unicode_ci','anioegreso');

-- -------------------------------------------------------------
-- TABLA:					atenciones
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna idcliente
-- FECHA DE CREACIÓN:		03-07-2020
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
CALL SP_ADD_COLUMN_IF_NOT_EXISTS('atenciones','idcliente','int not null','iduser');
CALL SP_ADD_COLUMN_IF_NOT_EXISTS('atenciones','fechaatencion','timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP','idcliente');
call SP_DROP_CONSTRAINT_IF_EXISTS('atenciones','fk_idcliente_atenciones');
alter table atenciones add constraint fk_idcliente_atenciones FOREIGN KEY (idcliente) REFERENCES clientes (idcliente);

-- -------------------------------------------------------------
-- TABLA:					atenciones
-- ACCION:					Elimminar foreign key y columnas 
-- DESCRIPCIÓN:				
-- FECHA DE CREACIÓN:		04-07-2020
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_DROP_CONSTRAINT_IF_EXISTS('atenciones','fk_idcuenta_atenciones');
call SP_DROP_CONSTRAINT_IF_EXISTS('atenciones','fk_idcampania_atenciones');
call SP_DROP_COLUMN_IF_EXISTS('atenciones','idcuenta');
call SP_DROP_COLUMN_IF_EXISTS('atenciones','idcampania');
call SP_DROP_COLUMN_IF_EXISTS('atenciones','fechaatencioningreso');
call SP_DROP_COLUMN_IF_EXISTS('atenciones','fechaatencionestado');


-- -------------------------------------------------------------
-- TABLA:					tipoatenciones
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna color
-- FECHA DE CREACIÓN:		26-06-2020
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
CALL SP_ADD_COLUMN_IF_NOT_EXISTS('tipoatenciones','color','varchar(30) COLLATE utf8mb4_unicode_ci','tipoatencion');

CALL SP_ADD_COLUMN_IF_NOT_EXISTS('clientes','idtipoatencion','int NOT NULL DEFAULT 1','uuidimportacion');

CALL SP_ADD_COLUMN_IF_NOT_EXISTS('clientes','asistencia','int NOT NULL DEFAULT 0','idtipoatencion');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna fechaasistencia
-- FECHA DE CREACIÓN:		9-01-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------

call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','fechaasistencia','timestamp','asistencia');

-- -------------------------------------------------------------
-- TABLA:					users
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna api_token
-- FECHA DE CREACIÓN:		9-01-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------

call SP_ADD_COLUMN_IF_NOT_EXISTS ('users','api_token','varchar(100) collate utf8mb4_unicode_ci','password');

-- -------------------------------------------------------------
-- TABLA:					users
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				UNIQUE
-- FECHA DE CREACIÓN:		03-07-2020
-- CREADO POR:				Yanet Marleni Inga
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------

call SP_DROP_CONSTRAINT_IF_EXISTS('api_token','api_token_UNIQUE');
ALTER TABLE users
ADD UNIQUE INDEX `api_token_UNIQUE` (`api_token` ASC) VISIBLE;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna origen
-- FECHA DE CREACIÓN:		12-01-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','origen','varchar(100) collate utf8mb4_unicode_ci','carrera');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna grado
-- FECHA DE CREACIÓN:		18-01-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','grado','varchar(150) collate utf8mb4_unicode_ci','utm');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna edad
-- FECHA DE CREACIÓN:		24-03-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','edad','int','telefono');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna evento
-- FECHA DE CREACIÓN:		5-05-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','evento','varchar(150)','origen');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna tipoparticipante
-- FECHA DE CREACIÓN:		5-05-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','tipoparticipante','varchar(150)','evento');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_content
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_content varchar(300) collate utf8mb4_unicode_ci;
-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_medium
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_medium varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_name
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_name varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_source
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_source varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_term
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_term varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna procedencia
-- FECHA DE CREACIÓN:		15-06-2021
-- CREADO POR:				Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add procedencia varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna ocupacion
-- FECHA DE CREACIÓN:		23-09-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add ocupacion varchar(300) collate utf8mb4_unicode_ci;
-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna especialidad
-- FECHA DE CREACIÓN:		10-11-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add especialidad varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna pais
-- FECHA DE CREACIÓN:		10-11-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add pais varchar(300) collate utf8mb4_unicode_ci;


