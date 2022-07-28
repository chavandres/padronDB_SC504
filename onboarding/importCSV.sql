Para facilitar que se mantengan los carácteres como la Ñ cuando se hace una inserción en Oracle, haga lo siguiente:

El archivo de texto debe ser guardado como (Save as), escoger el Encoding UTF-8 y especificar el nombre nuevo.


En Windows, para copiar un archivo al appliance Oracle, usar el comando:

	scp SJGOICOECHEA.txt oracle@192.168.1.74:/u01/userhome/oracle

Un archivo de texto muy grande se puede recortar a un número limitado de líneas, 100000 por ejemplo
En Windows PowerShell:  get-content archivo.txt | select-object -first 100000
En Oracle Linux: cat archivo.txt | head -100000 > nuevo_archivo.txt

-------------------------------------------------------
-------------------------------------------------------

--------------------------------------------------------
--  DDL for Table PADRON_CARGA
--------------------------------------------------------
  CREATE TABLE "HR"."PADRON_CARGA" 
   (	"CEDULA" NUMBER(9,0), 
	"CODELEC" NUMBER(6,0), 
	"RELLENO" VARCHAR2(1 BYTE) COLLATE "USING_NLS_COMP", 
	"FECHACADUC" DATE, 
	"JUNTA" VARCHAR2(5 BYTE) COLLATE "USING_NLS_COMP", 
	"NOMBRE" VARCHAR2(30 BYTE) COLLATE "USING_NLS_COMP", 
	"APE1" VARCHAR2(30 BYTE) COLLATE "USING_NLS_COMP", 
	"APE2" VARCHAR2(30 BYTE) COLLATE "USING_NLS_COMP"
       )  DEFAULT COLLATION "USING_NLS_COMP" SEGMENT CREATION DEFERRED 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  TABLESPACE "USERS" ;
  
     COMMENT ON COLUMN "HR"."PADRON_CARGA"."CODELEC" IS 'Codigo electoral donde esta inscrito';
     
CREATE UNIQUE INDEX "HR"."PADRON_CARGA_PK" ON "HR"."PADRON_CARGA" ("CEDULA") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  TABLESPACE "USERS" ;

  ALTER TABLE "HR"."PADRON_CARGA" MODIFY ("CEDULA" NOT NULL ENABLE);
  ALTER TABLE "HR"."PADRON_CARGA" MODIFY ("CODELEC" NOT NULL ENABLE);
  ALTER TABLE "HR"."PADRON_CARGA" ADD CONSTRAINT "PADRON_CARGA_PK" PRIMARY KEY ("CEDULA")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  TABLESPACE "USERS"  ENABLE;


--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table PADRON
--------------------------------------------------------

  CREATE TABLE "HR"."PADRON" 
   (	"CEDULA" NUMBER(9,0), 
	"CODELEC" NUMBER(6,0), 
	"RELLENO" VARCHAR2(1 BYTE) COLLATE "USING_NLS_COMP", 
	"FECHACADUC" DATE, 
	"JUNTA" VARCHAR2(5 BYTE) COLLATE "USING_NLS_COMP", 
	"NOMBRE" VARCHAR2(30 BYTE) COLLATE "USING_NLS_COMP", 
	"APE1" VARCHAR2(30 BYTE) COLLATE "USING_NLS_COMP", 
	"APE2" VARCHAR2(30 BYTE) COLLATE "USING_NLS_COMP"
   )  DEFAULT COLLATION "USING_NLS_COMP" SEGMENT CREATION DEFERRED 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  TABLESPACE "USERS" ;

   COMMENT ON COLUMN "HR"."PADRON"."CODELEC" IS 'Codigo electoral donde esta inscrito';
--------------------------------------------------------
--  DDL for Index PADRON_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "HR"."PADRON_PK" ON "HR"."PADRON" ("CEDULA") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  Constraints for Table PADRON
--------------------------------------------------------

  ALTER TABLE "HR"."PADRON" MODIFY ("CEDULA" NOT NULL ENABLE);
  ALTER TABLE "HR"."PADRON" MODIFY ("CODELEC" NOT NULL ENABLE);
  ALTER TABLE "HR"."PADRON" ADD CONSTRAINT "PADRON_PK" PRIMARY KEY ("CEDULA")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  TABLESPACE "USERS"  ENABLE;


---------------------------------------------------
---------------------------------------------------
-- Conectado como sys as sysdba

CREATE OR REPLACE DIRECTORY TXT_DIR AS '/u01/userhome/oracle';
GRANT READ ON DIRECTORY TXT_DIR TO HR;


-------------------------------------------------------
-------------------------------------------------------
-- Conectado con el usuario del proyecto (en mi caso HR)
-- Crea el procedimiento para carga de datos

CREATE OR REPLACE PROCEDURE read_txt
IS
l_file_type UTL_FILE.file_type; -- acceso a archivo por cargar
l_string VARCHAR2 (32765);

-- Define tabla para carga de datos
TYPE Fieldvalue IS TABLE OF VARCHAR2 (4000)
INDEX BY BINARY_INTEGER;

t_field Fieldvalue; -- variable de campos

-- Función para leer datos entre el separador, en este caso las comas
FUNCTION GetString (Source_string IN VARCHAR2,
Field_position IN NUMBER,
UnTerminated IN BOOLEAN DEFAULT FALSE,
Delimiter IN VARCHAR2 DEFAULT ',')
RETURN VARCHAR2
IS
iPtrEnd PLS_INTEGER := 0;
iPtrStart PLS_INTEGER := 0;
vcSourceStrCopy VARCHAR2 (4000) := Source_string;

BEGIN
    IF UnTerminated THEN
        vcSourceStrCopy := vcSourceStrCopy || Delimiter;
    END IF;

    IF Field_Position > 1 THEN
        iPtrStart := INSTR (vcSourceStrCopy, Delimiter, 1, Field_Position - 1) + LENGTH (Delimiter);
    ELSE
        iPtrStart := 1;
    END IF;

    iPtrEnd := INSTR (vcSourceStrCopy, Delimiter, 1, Field_Position);
    RETURN SUBSTR (vcSourceStrCopy, iPtrStart, (iPtrEnd - iPtrStart));
END GetString;

BEGIN

    l_file_type := UTL_FILE.Fopen ('TXT_DIR', 'goico1.txt', 'r');

    LOOP
        UTL_FILE.Get_Line (l_file_type, l_string);
        l_string := l_string || ',';

        FOR n IN 1 .. REGEXP_COUNT (l_string, ',')
            LOOP
                t_field (n) := Getstring (l_string,n,FALSE,',');
            END LOOP;

        INSERT INTO PADRON_CARGA (CEDULA,
        CODELEC,
        RELLENO,
        FECHACADUC,
        JUNTA,
        NOMBRE,
        APE1,
        APE2)
        VALUES (to_number (t_field (1),'999999999'),
        to_number (t_field (2),'999999'),
        t_field (3),
        TO_DATE (t_field (4), 'yyyy/mm/dd'),
        t_field (5),
        trim(t_field (6)),
        trim(t_field (7)),
        trim(t_field (8)));
    END LOOP;

    UTL_FILE.Fclose (l_file_type);

    COMMIT;

EXCEPTION
    WHEN OTHERS THEN
        IF UTL_FILE.is_open (l_file_type) THEN
            UTL_FILE.Fclose (l_file_type);
        END IF;
END;


---------------------------------------------------
---------------------------------------------------
EXECUTE READ_TXT;
truncate table padron_carga;
SELECT * FROM PADRON_CARGA;
SELECT * FROM PADRON;
SELECT * FROM LOG;
SET SERVEROUTPUT ON;
CREATE OR REPLACE DIRECTORY TXT_DIR AS '/home/oracle';
GRANT READ ON DIRECTORY TXT_DIR TO HR;
TRUNCATE TABLE LOG;
select count(*) from padron_carga;

insert into padron_carga values (108050088,123456,' ',
to_date('27/07/1971'),'12345','OSCAR','CAMPOS','SOLANO');

insert into padron_carga values (108050088,123456,' ',
sysdate,'12345','OSCAR','CAMPOS','SOLANO');

select TO_DATE ('20001231', 'yyyy/mm/dd') from dual;
select to_number ('111') from dual;

CREATE TABLE LOG (TEXTO VARCHAR2(400));
select * from log;

---------------------------------------------------
---------------------------------------------------
---------------------------------------------------
---------------------------------------------------
Conectado como sys as sysdba

CREATE OR REPLACE DIRECTORY TXT_DIR AS '/u01/userhome/oracle';
GRANT READ ON DIRECTORY TXT_DIR TO HR;