----------Funcion Top 5 Nombres Menos Comunes----------

create or replace FUNCTION bottom5_names RETURN SYS_REFCURSOR AS
    rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR  
        SELECT *
        FROM (SELECT NOMBRE, COUNT( NOMBRE ) AS total
        FROM  PERSONAS
        GROUP BY NOMBRE
        ORDER BY total ASC )
        WHERE rownum <= 5;
    RETURN rc;
END;

----------Funcion Top 5 Nombres Mas Comunes----------

create or replace FUNCTION top5_names RETURN SYS_REFCURSOR AS
  rc SYS_REFCURSOR;
BEGIN
  OPEN rc FOR 
  SELECT *
        FROM (SELECT NOMBRE, COUNT( NOMBRE ) AS total
        FROM  PERSONAS
        GROUP BY NOMBRE
        ORDER BY total DESC)
        WHERE rownum <= 5;
  RETURN rc;
END;


----------Funcion Consulta Personas por Campos----------

create or replace FUNCTION CONSULTA_PERSONA(ced in varchar DEFAULT '', nom in varchar DEFAULT '',
ape1 in varchar DEFAULT '', ape2 in varchar DEFAULT '') RETURN SYS_REFCURSOR AS
    rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR
        SELECT * FROM personas
            WHERE cedula LIKE ced||'%'
            AND nombre LIKE nom||'%' 
            AND primerapellido LIKE  ape1||'%' 
            AND segundoapellido LIKE ape2||'%';
        RETURN rc;
    CLOSE rc;
END;

----------Funcion Reporte 5 Vocales----------

create or replace FUNCTION nombresVocales RETURN SYS_REFCURSOR AS
    rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR 
        SELECT * FROM (SELECT nombre, count(nombre) as TOTAL FROM personas
            WHERE nombre LIKE '%U%' 
            and nombre LIKE '%A%' 
            and nombre LIKE '%O%' 
            and nombre LIKE '%I%'
            and nombre LIKE '%E%'
            GROUP BY nombre)
            ORDER BY TOTAL DESC;
    RETURN rc;        
END;

----------Funcion Reporte Top Cantones----------

create or replace FUNCTION topCantones RETURN SYS_REFCURSOR AS
    rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR  
        SELECT * FROM ( SELECT distelec.canton, count(distelec.canton) as TOTAL from personas INNER JOIN distelec
            ON personas.CODELEC = distelec.codelec
            GROUP BY distelec.canton
            ORDER BY TOTAL DESC)
        WHERE ROWNUM <= 5;
    RETURN rc;
CLOSE rc;
END;

