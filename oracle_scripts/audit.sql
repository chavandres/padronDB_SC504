create or replace
package AUDIT_HANDLER
is
PROCEDURE HANDLE_SELECT_PERSONAS
( object_schema VARCHAR2
, object_name VARCHAR2
, policy_name VARCHAR2
);
end;

create or replace
package body AUDIT_HANDLER
is
PROCEDURE HANDLE_SELECT_PERSONAS
( object_schema VARCHAR2
, object_name VARCHAR2
, policy_name VARCHAR2
) is
  PRAGMA AUTONOMOUS_TRANSACTION;
begin
  insert into bitacora
  ( usuario, fecha, sentencia)
  values
  ( user, systimestamp, sys_context('userenv','current_sql'))
  ;
  commit;
end HANDLE_SELECT_PERSONAS;
end;

create table bitacora
(usuario varchar2(40),
fecha timestamp,
sentencia varchar2(4000))

begin
  dbms_fga.add_policy
  ( object_schema=>'PADRONAPP',
  object_name=>'PERSONAS',
  policy_name=>'PERSONAS_ACCESO_HANDLED',
  audit_column => NULL,
  audit_condition => NULL,
  handler_schema => 'PADRONAPP',
  handler_module => 'AUDIT_HANDLER.HANDLE_SELECT_PERSONAS'
  );
end;

select * from personas;

select * from bitacora;

delete from bitacora;