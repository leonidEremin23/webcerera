CREATE TABLE users (
   id     int AUTO_INCREMENT PRIMARY KEY        COMMENT 'индекс',
   usr    varchar(32)                           COMMENT 'имя пользователя',
   pubkey text                                  COMMENT 'публичный ключ',
   prim   varchar(255)                          COMMENT 'примечание',
   last   datetime                              COMMENT 'дата последнего обращения',
   wdat   timestamp DEFAULT current_timestamp() COMMENT 'время записи'
) ENGINE=MyISAM COMMENT='пользователи';

create table mess
(
   im     int auto_increment primary key        comment 'индекс сообщения',
   idfrom int                                   comment 'индекс отправителя',
   idto   int                                   comment 'индекс получателя',
   msg    text                                  comment 'зашифрованное сообщение',
   datr   datetime                              comment 'дата прочтения',
   wdat   timestamp default current_timestamp() comment 'время сообщения'
) ENGINE=MyISAM comment='сообщения';
