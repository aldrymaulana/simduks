use kohana;
alter table pernikahan add column kelurahan_id int(11) after wali;
alter table pernikahan modify column saksi1 varchar(80);
alter table pernikahan modify column saksi2 varchar(80);
alter table pernikahan add column no_pernikahan varchar(15) after id;
alter table pernikahan add column status_pria_sebelum enum('Jejaka', 'Menikah','Duda')after pria;
alter table pernikahan add column status_wanita_sebelum enum('Perawan', 'Janda') after wanita;
