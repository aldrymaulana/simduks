use KOHANA;
create table nikcounter
(id int(11) not null primary key auto_increment,
kecamatan_id int(11) not null,
tanggal date not null,
counter int(11) not null default 0);
