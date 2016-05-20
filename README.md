# Donation Management System 
#### An oracle pl/sql and php Web Application. This application is about donation management system. It can be maintained by both Oracle and mysql database. Basically the project has been designed with Oracle pl/sql.

# Steps taken for Oracle 11g

1. Installed Oracle 11g and instant client for my 32 bit Windows OS. Environment Path Variable added for Oracle instant client.
2. Followed this link to setup the environment for Oracle 11g, instant client,  php, apache web server: http://www.oracle.com/technetwork/articles/technote-php-instant-084410.html
3. Created users and given necessary privilages access.
4. Unlocked the Sample User Account(HR)
5. Created workspaces
6. For connecting the Oracle database with php followed the steps here: http://docs.oracle.com/cd/E17781_01/appdev.112/e18555/ch_two.htm#TDPPH114
(Testing PHP Connections to Oracle section is the connecting with php part.)



# Some problems I have faced

1. Always connect by typing this in "Run SQL Command Line":
```
connect sys as sysdba
```
2. To unlock a user type:
```
alter user system identified by *newpassword* account unlock;
```
3. If the Oracle homepage not appears, start all services from services.msc

# Creating a Database User and giving necessary privilages access

1. "Run SQL Command Line" and then type:
```
connect;
Enter user-name: system
Enter password: [type the password]
```
2. Create the user. For example, enter a statement in the following form:
```
create user chris identified by [password_for_chris];
```
3. Grant the user the necessary privileges. For example:
```
grant CREATE SESSION, ALTER SESSION, CREATE DATABASE LINK, -
CREATE MATERIALIZED VIEW, CREATE PROCEDURE, CREATE PUBLIC SYNONYM, -
CREATE ROLE, CREATE SEQUENCE, CREATE SYNONYM, CREATE TABLE, - 
CREATE TRIGGER, CREATE TYPE, CREATE VIEW, UNLIMITED TABLESPACE -
to chris;
```
4. Optionally, exit SQL*Plus (which also closes the command window):
```
exit;
```

# Unlocking the Sample User Account(HR)

1. Enter the following statement to unlock the HR account:
```
ALTER USER hr ACCOUNT UNLOCK;
```
2. Enter a statement in the following form to specify the password that you want for the HR user:
```
ALTER USER hr IDENTIFIED BY [password_for_hr];
```
# Tables and commands for Oracle/Mysql
```
CREATE TABLE user_info(
   user_id number primary key,
   username varchar2(150),
   password varchar2(150)
);

INSERT INTO user_info(user_id,username,password) VALUES (new_user_seq.nextval, 'shohan', 'shohan');

CREATE TABLE branch (
   b_id number primary key,
   b_name varchar2(150),
   address varchar2(150),
   area varchar2(50),
   phone varchar2(50)
);

CREATE TABLE donor(
   d_id number primary key,
   b_id number,
   d_name varchar2(150),
   address varchar2(150),
   donated_item varchar2(10),
   phone varchar2(50),
   email varchar2(50)
);

CREATE TABLE item(
item_id number primary key,
d_id number,
item_amount varchar2(50),
item_name varchar2(50)
);

CREATE TABLE employee(
   emp_id number primary key,
   b_id number,
   emp_name varchar2(150),
   emp_address varchar2(150),
   emp_dept varchar2(50),
   emp_salary number,
   phone varchar2(50)
);

CREATE TABLE item_request(
   item_request_id number primary key,
   b_id number,
   name varchar2(150),
   item_name varchar2(50),
   item_amount varchar2(50),
   address varchar2(100),
   phone varchar2(50),
   confirm_request varchar2(50)
);

CREATE TABLE user_triger(
 t_id number primary key,
 action varchar2(100),
 time varchar2(100),
 old varchar2(100),
 new varchar2(100)
);
```
# Sequences, Procedure, Triger, Sample and Complex Views command for Oracle pl/sql Only

Sequences
----------
```
CREATE SEQUENCE usertriger_seq
 START WITH     1
 INCREMENT BY   1;

CREATE SEQUENCE new_user_seq
 START WITH     1
 INCREMENT BY   1;

CREATE SEQUENCE donor_seq
 START WITH     1
 INCREMENT BY   1;

CREATE SEQUENCE branch_seq
 START WITH     1
 INCREMENT BY   1;

CREATE SEQUENCE item_request_seq
 START WITH     1
 INCREMENT BY   1;

CREATE SEQUENCE item_seq
 START WITH     1
 INCREMENT BY   1;

CREATE SEQUENCE emp_seq
 START WITH     1
 INCREMENT BY   1;
```
Procedure
----------
```
CREATE OR REPLACE PROCEDURE 
    sayHello (name IN VARCHAR2, greeting OUT VARCHAR2) 
  AS
    BEGIN
        greeting := 'Welcome, ' || name;
    END;
```
Triger
--------
```
CREATE OR REPLACE TRIGGER ins_update_user
  AFTER INSERT OR UPDATE ON user_info 
  FOR EACH ROW
BEGIN
  IF INSERTING THEN 
    INSERT INTO user_triger (t_id,action,time,old,new) 
    VALUES (usertriger_seq.nextval, 'Insert', SYSTIMESTAMP, '-', :NEW.username);
  END IF;
  IF UPDATING THEN
    INSERT INTO user_triger (t_id,action,time,old,new)
    VALUES (usertriger_seq.nextval, 'Update', SYSTIMESTAMP, :OLD.username, :NEW.username);
  END IF;
END;
```
Simple Views
-------------
```
create view pro1_simple_view as select * from branch where Area='Comilla';
select * from pro1_simple_view

create view pro2_simple_view as select * from item_request where item_amount ='25' and name='alam';
select * from pro2_simple_view

create view pro4_simple_view as select * from Employee where emp_salary='10000';
select * from pro4_simple_view
```
Complex View
-------------------
```
create view pro5_comp_view as select b_name,b_id from branch 
where b_id=(select b_id from employee where emp_salary=(select max(emp_salary)from employee));

select * from pro5_comp_view

create view pro6_comp_view as select d_name,d_id from donor 
where d_id=(select d_id from item where item_amount=(select max(item_amount) from item));

select * from pro6_comp_view
```
