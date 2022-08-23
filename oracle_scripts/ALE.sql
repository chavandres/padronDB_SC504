SET SERVEROUTPUT ON;


DELIMITER //
CREATE PROCEDURE contadorV AS
select NOMBRE as nombre from PERSONAS;
CREATE TEMPORARY TABLE TEMPVOCAL (nombres VARCHAR(30))
len(nombre) -
      len(replace(replace(replace(replace(replace(
            lower(nombre), 'a', ''), 'e', ''), 'i', ''), 'o', ''), 'u', ''))
when(
datalenght(nombre)-datalenght(replace(nombre, a, '')) AND datalenght(nombre)-datalenght(replace(nombre, e, '')) AND
datalenght(nombre)-datalenght(replace(nombre, i, '')) AND datalenght(nombre)-datalenght(replace(nombre, o, '')) AND
datalenght(nombre)-datalenght(replace(nombre, u, ''))
)then
INSERT INTO TEMPVOCAL (nombres)
VALUES (nombre)
SELECT * FROM TEMPVOCAL
END;
DELIMITER;

create or replace FUNCTION topCantones RETURN SYS_REFCURSOR AS
    rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR  
        SELECT * FROM (SELECT CANTON, COUNT(CANTON) AS TOTAL FROM DISTELEC RIGHT JOIN PERSONAS ON DISTELEC.CANTON
 GROUP BY CANTON
 ORDER BY TOTAL DESC)
WHERE ROWNUM <= 5
    RETURN rc;
END;
 