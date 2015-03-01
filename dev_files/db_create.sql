
create database StudentSystem;

use StudentSystem;

create table admin(id int not null AUTO_INCREMENT , name text not null , pass nvarchar(255) not null , email nvarchar(255) not null , salt nvarchar(255) not null , primary key(id),unique(email));

#describe admin;

create table student(id int not null AUTO_INCREMENT , name text not null , pass nvarchar(255) not null , email nvarchar(255) not null , salt nvarchar(255) not null , status int not null  , primary key(id),unique(email));

create table topic(id int not null AUTO_INCREMENT , subject text not null , status int not null  , primary key(id) , sid int , foreign key(sid) references student(id));

create table reply(id int not null AUTO_INCREMENT , body text , status int not null , type int not null , date date not null , primary key(id) , tid int , foreign key(tid) references topic(id));

create table attachment(id int not null AUTO_INCREMENT , path text not null ,filename text not null , primary key(id) , rid int , foreign key(rid) references reply(id));

create table resource(id int not null AUTO_INCREMENT , subject text not null , course text , picpath text , note text , primary key(id));

create table resfile(id int not null AUTO_INCREMENT , path text , primary key(id) , rid int , foreign key(rid) references resource(id));

create table university(id int not null AUTO_INCREMENT , name text not null , primary key(id));

create table news(id int not null AUTO_INCREMENT , subject text not null , body text not null , date date not null , primary key(id));

create table un(uid int , nid int , primary key (uid,nid) , foreign key(uid) references university(id) , foreign key(nid) references news(id));

#---------------------------------------
ALTER TABLE student ADD uid int;
ALTER table student add foreign key(uid) references university(id);

#---------------------------------------


alter table student add lastip nvarchar(50);
alter table student add lastlogin bigint;
alter table student add registerDate bigint;

#By arashdn:
ALTER DATABASE StudentSystem CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE admin CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE student CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE reply CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE attachment CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE resource CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE resfile CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE university CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE news CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE un CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;


insert into university values(null , 'UUT');