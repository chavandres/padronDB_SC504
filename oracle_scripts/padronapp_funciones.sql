select * from PERSONAS;

SET SERVEROUTPUT ON;


/* Consulta de datos por número de cédula */
create or replace FUNCTION CONSULTA_CED(id in number) RETURN SYS_REFCURSOR AS
    rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR  
        SELECT nombre, primerapellido, segundoapellido FROM personas
        WHERE cedula = id;
    RETURN rc;
END;

select consulta_ced(302850580) from dual;


-- *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
/* Consulta de datos por nombre */
create or replace FUNCTION CONSULTA_NOMBRE(nom in varchar) RETURN SYS_REFCURSOR AS
    rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR  
        SELECT cedula, primerapellido, segundoapellido FROM personas
        WHERE nombre = nom;
    RETURN rc;
END;

select consulta_nombre('LUISA MARIA') from dual;

-- *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
/* Consulta de datos por primer apellido */
create or replace FUNCTION CONSULTA_APELLIDO1(apellido1 in varchar) RETURN SYS_REFCURSOR AS
    rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR  
        SELECT cedula, nombre, segundoapellido FROM personas
        WHERE primerapellido = apellido1;
    RETURN rc;
END;

select consulta_apellido1('MOYA') from dual;

-- *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
/* Consulta de datos por segundo apellido */
create or replace FUNCTION CONSULTA_APELLIDO1(apellido2 in varchar) RETURN SYS_REFCURSOR AS
    rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR  
        SELECT cedula, nombre, primerapellido FROM personas
        WHERE primerapellido = apellido2;
    RETURN rc;
END;

select consulta_apellido1('ALVARADO') from dual;
