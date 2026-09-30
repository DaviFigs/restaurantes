--sistema para restaurantes

create table contratante(
		id serial primary key,
		nome_completo varchar(100) not null,
		email varchar(100) not null,
		senha varchar(256) not null,
		data_criacao timestamp default now(),
		cpf varchar(11) not null,
		telefone varchar(20) not null
);


create table restaurante(
     id serial primary key,
	id_contratante int not null,
     nome varchar(50) not null,
     login_restaurante varchar(30) not null,
     cpf_cnpj varchar(30) not null,
     data_cadastro timestamp default now(),
     email varchar(100) not null,
     telefone varchar(20) not null,
     ativo int not null default 1,
     url_foto text default 'icone_padrao.jpg',
     cor_principal varchar(10) default '#580b7cda',
	foreign key(id_contratante) references contratante(id)
);
create table endereco(
     id serial primary key,
     id_restaurante int not null,
     cep varchar(10) not null,
     logradouro varchar(50) not null,
     numero varchar(10) not null,
     complemento varchar(50),
     bairro varchar(50) not null,
     cidade varchar(50) not null,
     estado char(2) not null,
     foreign key(id_restaurante) references restaurante(id)
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
