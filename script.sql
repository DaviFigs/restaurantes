--sistema para restaurantes

create table endereco(
     id serial primary key,
     cep varchar(10) not null,
     logradouro varchar(50) not null,
     numero varchar(10) not null,
     complemento varchar(50),
     bairro varchar(50) not null,
     cidade varchar(50) not null,
     estado char(2) not null
);

create table restaurante(
     id serial primary key,
     id_endereco int not null,
     nome varchar(50) not null,
     login_restaurante varchar(30) not null,
     cpf_cnpj varchar(30) not null,
     data_cadastro timestamp default now(),
     url_foto text,
     cor_principal varchar(10) default '#580b7cda',
     foreign key(id_endereco) references endereco(id)
);

create table usuario(
     id serial primary key,
     id_restaurante int not null,
     nome varchar(50) not null,
     username varchar(30) not null,
     senha varchar(50) not null,
     nivel int not null,
     --1 utilizador
     --2 adm
     foreign key(id_restaurante) references restaurante(id)
);

create table produto(
     id serial primary key,
     id_restaurante int not null,
     codigo_barras VARCHAR(50),
     nome varchar(50) not null,
     preco numeric(15,2),
     ultima_alteracao timestamp default now(),
     foreign key(id_restaurante) references restaurante(id)
);

create table comanda(
     id serial primary key,
     id_usuario int not null,
     id_restaurante int not null,
     nome_cliente varchar(50) not null,
     data_abertura date not null,
     hora_abertura time not null,
     data_hora_fechamento timestamp,
     fechada boolean not null default false,
     valor_total numeric(15,2) default 0,
     num_mesa int,
     foreign key(id_usuario) references usuario(id),
     foreign key(id_restaurante) references restaurante(id)
);

create table comanda_produto(
     id serial primary key,
     id_comanda int not null,
     id_produto int not null,
     data_hora timestamp not null,
     foreign key(id_comanda) references comanda(id),
     foreign key(id_produto) references produto(id)
);

create table comanda_lancamento(
     id serial primary key,
     id_comanda int not null,
     data_hora timestamp not null,
     foreign key(id_comanda) references comanda(id)
);

CREATE TABLE tokens (
    id serial PRIMARY KEY,
    token varchar(32) NOT NULL,
    id_restaurante int NOT NULL,
    id_usuario int NOT NULL,
    criacao timestamp DEFAULT now(),
    validade timestamp DEFAULT (now() + interval '24 hours'),

    FOREIGN KEY (id_restaurante) REFERENCES restaurante(id),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);