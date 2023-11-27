
select * from conta ;
select * from ideia ;
ALTER TABLE conta

ADD COLUMN renda varchar(40);
use pit ;

create database pit ;
 CREATE TABLE  conta (
    id int not null primary key auto_increment ,
    Nome VARCHAR(50),
    Sobrenome VARCHAR(50),
    Senha VARCHAR(50),
    Email VARCHAR(50),
    Informacao VARCHAR(50),
    tel VARCHAR(50),
    cpf VARCHAR(50),
    tipo varchar(50),
    renda varchar(40)
);

create table ideia (
id int not null primary key auto_increment ,
nome_ideia varchar(100),
descricao varchar(200),
Valor_nin varchar(100),
foto longblob,
tipo_apoiador varchar(50), 
Tag varchar(50),
tipo_ideia varchar(50),
Email VARCHAR(50)
);

CREATE TABLE seguidores (
    id_seguidor INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_ideia INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES conta (id),
    FOREIGN KEY (id_ideia) REFERENCES ideia (id)
);

CREATE TABLE doacoes_ideia (
    id_doacao INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_ideia INT NOT NULL,
    valor_doacao DECIMAL(10, 2) NOT NULL,
    data_doacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES conta (id),
    FOREIGN KEY (id_ideia) REFERENCES ideia (id)
);

CREATE TABLE investimentos (
    id_investimento INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_ideia INT NOT NULL,
    valor_investimento DECIMAL(10, 2) NOT NULL,
    porcentagem_retorno DECIMAL(5, 2) NOT NULL,
    data_investimento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES conta (id),
    FOREIGN KEY (id_ideia) REFERENCES ideia (id)
);


select * from seguidores ;
select * from doacoes_ideia ;
select * from conta ;
select * from investimentos ;
use pit ;


