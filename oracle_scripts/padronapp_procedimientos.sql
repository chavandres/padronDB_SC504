select * from PERSONAS;

SET SERVEROUTPUT ON;

-- *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
/* Consulta de datos por número de cédula */
--%NOTFOUND  %ISOPEN
create or replace procedure consulta_cedula(ced in varchar2)
AS 
    c1 SYS_REFCURSOR;
    BEGIN
    open c1 FOR
    SELECT * from personas where cedula=ced;
    DBMS_SQL.RETURN_RESULT(c1);
END;

execute consulta_cedula('304560850');

drop function consulta_cedula;
drop procedure consulta_cedula;


-- *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
/* Consulta de datos por nombre y/o apellidos
Muestra el primer apellido de la consulta */

DECLARE
    CURSOR CONSULTA_NOMBRE(pnombre IN VARCHAR2) IS
    SELECT primerapellido
    FROM personas
    WHERE nombre = pnombre;
    CONSULTA_NOMBRE_rec CONSULTA_NOMBRE%ROWTYPE;
    vnombre VARCHAR2(20);
BEGIN
    vnombre := 'LUISA MARIA';
    DBMS_OUTPUT.PUT_LINE
    ('*----- Primer apellido de las personas con nombre: ' || vnombre || ' -----*');
    FOR CONSULTA_NOMBRE_rec IN CONSULTA_NOMBRE(vnombre)
LOOP
    DBMS_OUTPUT.PUT_LINE
    (CONSULTA_NOMBRE_rec.primerapellido || ' ');
    END LOOP;
END;

-- *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
/* Consulta de datos por nombre y/o apellidos
Muestra el segundo apellido de la consulta */
DECLARE
    CURSOR CONSULTA_NOMBRE(pnombre IN VARCHAR2) IS
    SELECT segundoapellido
    FROM personas
    WHERE nombre = pnombre;
    CONSULTA_NOMBRE_rec CONSULTA_NOMBRE%ROWTYPE;
    vnombre VARCHAR2(20);
BEGIN
    vnombre := 'LUISA MARIA';
    DBMS_OUTPUT.PUT_LINE
    ('*----- Segundo apellido de las personas con nombre: ' || vnombre || ' -----*');
    FOR CONSULTA_NOMBRE_rec IN CONSULTA_NOMBRE(vnombre)
LOOP
    DBMS_OUTPUT.PUT_LINE
    (CONSULTA_NOMBRE_rec.segundoapellido || ' ');
    END LOOP;
END;



-- Consulta de datos por nombre y/o apellidos
-- Muestra ambos apellidos de la consulta
DECLARE
    CURSOR CONSULTA_NOMBRE(pnombre IN VARCHAR2) IS
    SELECT primerapellido, segundoapellido
    FROM personas
    WHERE nombre = pnombre;
    CONSULTA_NOMBRE_rec CONSULTA_NOMBRE%ROWTYPE;
    vnombre VARCHAR2(20);
BEGIN
    vnombre := 'LUISA MARIA';
    DBMS_OUTPUT.PUT_LINE
    ('*----- Ambos apellidos de las personas con nombre: ' || vnombre || ' -----*');
    FOR CONSULTA_NOMBRE_rec IN CONSULTA_NOMBRE(vnombre)
LOOP
    DBMS_OUTPUT.PUT_LINE
    (CONSULTA_NOMBRE_rec.primerapellido || ' '  || CONSULTA_NOMBRE_rec.segundoapellido);
    END LOOP;
END;
