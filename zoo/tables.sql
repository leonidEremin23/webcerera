CREATE TABLE users (
   id     int AUTO_INCREMENT PRIMARY KEY        COMMENT 'индекс',
   usr    varchar(32) UNIQUE                    COMMENT 'имя пользователя',
   pubkey text                                  COMMENT 'публичный ключ',
   pwd    varchar(255)                          COMMENT 'пароль пользователя',
   prim   varchar(255)                          COMMENT 'примечание',
   last   datetime                              COMMENT 'дата последнего обращения',
   wdat   timestamp DEFAULT current_timestamp() COMMENT 'время записи'
) ENGINE=MyISAM COMMENT='пользователи';

create table mess
(
   im     int auto_increment primary key        comment 'индекс сообщения',
   ufrom  varchar(32)                           comment 'отправитель',
   uto    varchar(32)                           comment 'получатель',
   msg    text                                  comment 'зашифрованное сообщение',
   datr   datetime                              comment 'дата прочтения',
   wdat   timestamp default current_timestamp() comment 'время сообщения'
) ENGINE=MyISAM comment='сообщения';
