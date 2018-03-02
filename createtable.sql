create table user
(
username char(20) not null primary key,
password char(30) not null
);

create table broadcast
(
id int unsigned not null auto_increment primary key,
content TEXT,
username char(20) not null
);

create table curplay
(
songmid char(40) not null primary key,
songname TEXT not null,
singername TEXT not null,
url TEXT not null,
username char(20) not null,
addtime TIMESTAMP not null
);
