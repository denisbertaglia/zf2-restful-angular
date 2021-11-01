CREATE TABLE Consultores 
(
    id INTEGER PRIMARY KEY,
    nome varchar(255) NOT NULL,
    email varchar(255) NOT NULL
);

INSERT INTO Consultores (id,nome , email) VALUES(1,'Aline Santos Ribeiro','aline.santos@gmail.com');
INSERT INTO Consultores (id,nome , email) VALUES(2,'Carolina de Oliveira','carol.oliv@gmail.com');

CREATE TABLE Servicos 
(
    id INTEGER PRIMARY KEY,
    descricao varchar(255) NOT NULL
);

INSERT INTO Servicos (id,descricao) VALUES(1,'Desenvolvimento de Landing Page');
INSERT INTO Servicos (id,descricao) VALUES(2,'Customização de CSS');
INSERT INTO Servicos (id,descricao) VALUES(3,'Instalação do Wordpress');
INSERT INTO Servicos (id,descricao) VALUES(4,'Desenvolvimento de Plugin');
INSERT INTO Servicos (id,descricao) VALUES(5,'Desenvolvimento de Tema');

CREATE TABLE rel_servico_consultor 
(
    id_servico INTEGER,
    id_consultor INTEGER
);

INSERT INTO rel_servico_consultor (id_servico, id_consultor) VALUES(1,4);
INSERT INTO rel_servico_consultor (id_servico, id_consultor) VALUES(1,5);
INSERT INTO rel_servico_consultor (id_servico, id_consultor) VALUES(2,1);

CREATE TABLE Agendamento 
(
    id INTEGER PRIMARY KEY,
    data varchar(255) NOT NULL,
    consultor INTEGER NOT NULL,
    servico INTEGER NOT NULL,
    email_cliente varchar(255) NOT NULL
);

