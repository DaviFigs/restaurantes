--sistema para restaurantes

create table restaurante(
     id serial primary key,
     nome varchar(50) not null,
     cpf_cnpj varchar(30) not null,
     data_cadastro timestamp default now(),
     url_foto text,

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
     foreign key(id_restaurante) references restaurante(id),
);

create table produto(
     id serial primary key,
     id_restaurante int not null,
     codigo_barras VARCHAR(50),
     nome varchar(50) not null,
     preco numeric(15,2),
     ultima_alteracao timestamp default now(),
     foreign key(id_restaurante) references restaurante(id),
);

create table comanda(
     id serial primary key,
     id_usuario int not null,
     id_restaurante int not null,
     cliente_nome varchar(50) not null,
     data date not null,
     horario time not null,
     fechada boolean not default false,
     valor_total numeric(15,2) default 0,
     foreign key(id_usuario) references usuario(id),
     foreign key(id_restaurante) references restaurante(id)
);

create table comanda_produto(
     id serial primary key,
     id_comanda int not null,
     id_produto int not null,
     foreign key(id_comanda) references comanda(id),
     foreign key(id_produto) references produto(id)
);


