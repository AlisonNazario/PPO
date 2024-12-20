-- Database creation
CREATE DATABASE Livraria;
USE Livraria;

-- Table for authors
CREATE TABLE Autor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    sobrenome VARCHAR(50) NOT NULL
);

-- Table for books
CREATE TABLE Livro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    anoPublicacao INT,
    fotoCapa VARCHAR(255),
    idCategoria INT,
    preco DOUBLE,
    FOREIGN KEY (idCategoria) REFERENCES Categorias(id)
);

-- Table for book categories
CREATE TABLE Categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(100) NOT NULL,
    titulo VARCHAR(100) NOT NULL
);
ALTER TABLE Livro ADD COLUMN idAutor INT;

-- Table to link authors and books (many-to-many relationship)
CREATE TABLE AutorLivro (
    idAuto INT,
    idLivro INT,
    PRIMARY KEY (idAuto, idLivro),
    FOREIGN KEY (idAuto) REFERENCES Autor(id),
    FOREIGN KEY (idLivro) REFERENCES Livro(id)
);

-- Table for purchases
CREATE TABLE Compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dtCompra DATE NOT NULL,
    valorTotalCompra DOUBLE
);

-- Table for items in each purchase
CREATE TABLE ItensCompra (
    idLivro INT,
    idCompra INT,
    valorUnitario DOUBLE,
    quantidade INT,
    valorTotalItem DOUBLE,
    PRIMARY KEY (idLivro, idCompra),
    FOREIGN KEY (idLivro) REFERENCES Livro(id),
    FOREIGN KEY (idCompra) REFERENCES Compra(id)
);

ALTER TABLE itenscompra
DROP FOREIGN KEY itenscompra_ibfk_1;

ALTER TABLE itenscompra
ADD CONSTRAINT itenscompra_ibfk_1
FOREIGN KEY (idLivro) REFERENCES Livro(id)
ON DELETE CASCADE;


-- Table for users
CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivelPermissao INT
);

-- Table for clients (inherits from Usuario)
CREATE TABLE Cliente (
    id INT PRIMARY KEY,
    cpf VARCHAR(11) UNIQUE NOT NULL,
    FOREIGN KEY (id) REFERENCES Usuario(id)
);

create user 'Vinn'@'localhost' identified by 'Vinn'; -- cria o usuário para acessar ao banco de dados com o login fulano e senha 123
GRANT ALL PRIVILEGES ON Livraria.* TO 'Vinn'@'localhost';
grant all on Livraria.* to 'Vinn'@'localhost'; -- dá todas as permissões para o usuário fulano no banco contatosusuarios
