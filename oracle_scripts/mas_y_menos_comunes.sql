 SELECT NOMBRE, COUNT(*)
    FROM PERSONAS
    GROUP BY NOMBRE
   HAVING COUNT(*)>1;
   
    ------------------------------------------------ ------------------------------------------------ ------------------------------------------------ ------------------------------------------------
    
    /* - Muestra los 5 nombres más utilizados - */
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

 ------------------------------------------------ ------------------------------------------------ ------------------------------------------------ ------------------------------------------------
 
     /* - Muestra los 5 nombres menos utilizados - */
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

select bottom5_names from dual;
 
 
 
 
 
 