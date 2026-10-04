--DROP DATABASE IF EXISTS mhWilds;

CREATE DATABASE IF NOT EXISTS mhWilds
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;
USE mhWilds;

--tabela que guarda qual a versao atual do jogo
--incrementa o id automatico||nao vai ter duas linhas com id 11
CREATE TABLE versions(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	version VARCHAR(30) NOT NULL UNIQUE, 
	descricao VARCHAR(100) NOT NULL,
	data_ DATE NULL,
	active boolean NOT NULL DEFAULT TRUE 
);

--tabela de usuarios
--ao inves de guardar a senha diretamente guarda o hash dela pq é mais seguro
CREATE TABLE users(
	id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user VARCHAR(50) NOT NULL UNIQUE,
	email VARCHAR(255) NOT NULL UNIQUE,
	hash_senha VARCHAR(255) NOT NULL, 
	criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

	ON UPDATE CURRENT_TIMESTAMP 
);

--tabela separando os tipo de equipamentos, facilita pra listar só as armas por exemplo, ja q todas vao ter o mesmo id 'pai'
CREATE TABLE tipo_equip(
	id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(50) NOT NULL UNIQUE
);
INSERT INTO tipo_equip (nome) VALUES ('armas'), ('armadura'), ('charm'), ('decos');

--foreign key faz a ligação entre as tabelas
--INDEX cria indices para facilitar buscas. tipo indice de livro
CREATE TABLE equipamentos(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(150) NOT NULL,
	descricao TEXT,
	tipo_equip_id TINYINT UNSIGNED NOT NULL,
	raridade TINYINT UNSIGNED NULL,

	FOREIGN KEY (tipo_equip_id)
		REFERENCES tipo_equip(id),

	INDEX idx_tipo_equip (tipo_equip_id),
	INDEX idx_equip_nome (nome) 
);

--tabelas que guarda os dados dar armas e.q dano elemento
--ON DELETE CASCADE faz com que caso algo seja deletado de 'equipamentos' seja deletado aq tbm
CREATE TABLE armas(
    equip_id INT UNSIGNED PRIMARY KEY,
    tipo_arma VARCHAR(50) NOT NULL,
    ataque INT UNSIGNED NOT NULL DEFAULT 0,
    afinidade SMALLINT NOT NULL DEFAULT 0,
    bonus_defesa SMALLINT NOT NULL DEFAULT 0,
    elderseal VARCHAR(30) NULL,

    FOREIGN KEY (equip_id)
        REFERENCES equipamentos(id)
        ON DELETE CASCADE 
);

CREATE TABLE dano_elemental(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_arma INT UNSIGNED NOT NULL,

    elemento ENUM(
    	'nenhum',
        'fogo',
        'agua',
        'raio',
        'gelo',
        'dragao',
        'poison',
        'paralisisa',
        'sleep',
        'blast'
    ) NOT NULL,

    dano INT NOT NULL DEFAULT 0,

    FOREIGN KEY (id_arma)
        REFERENCES armas(equip_id)
        ON DELETE CASCADE,

    INDEX idx_elemento (id_arma)
);

CREATE TABLE sharpness(
    id_arma INT UNSIGNED PRIMARY KEY,

    red INT UNSIGNED NOT NULL DEFAULT 0,
    orange INT UNSIGNED NOT NULL DEFAULT 0,
    yellow INT UNSIGNED NOT NULL DEFAULT 0,
    green INT UNSIGNED NOT NULL DEFAULT 0,
    blue INT UNSIGNED NOT NULL DEFAULT 0,
    white INT UNSIGNED NOT NULL DEFAULT 0,
    purple INT UNSIGNED NOT NULL DEFAULT 0,

    FOREIGN KEY (id_arma)
        REFERENCES armas(equip_id)
        ON DELETE CASCADE
);

CREATE TABLE armadura(
    equip_id INT UNSIGNED PRIMARY KEY,

    armor_type ENUM(
        'head',
        'chest',
        'arms',
        'waist',
        'legs'
    ) NOT NULL,

    defesa SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    
    fogo TINYINT NOT NULL DEFAULT 0,
    agua TINYINT NOT NULL DEFAULT 0,
    trovao TINYINT NOT NULL DEFAULT 0,
    gelo TINYINT NOT NULL DEFAULT 0,
    dragao TINYINT NOT NULL DEFAULT 0,

    FOREIGN KEY (equip_id)
        REFERENCES equipamentos(id)
        ON DELETE CASCADE
);

--tabela com as skills do jogo e qual o nivel maximo delas, e.q attack boost lvl 7
CREATE TABLE skills(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL UNIQUE,
    descricao TEXT,
    max_level TINYINT UNSIGNED NOT NULL DEFAULT 1
);

--tabela com os niveis individuais de cada skill
CREATE TABLE skill_levels(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    skill_id INT UNSIGNED NOT NULL,
    level TINYINT UNSIGNED NOT NULL,
    descricao TEXT NOT NULL,

    FOREIGN KEY (skill_id)
        REFERENCES skills(id)
        ON DELETE CASCADE,

    UNIQUE (skill_id, level)
);

--tabela que liga as skill e equipamentos, talvez eu apague se der td certo no hmtl
--faz com q a chave primaria tenha 2 fatores
--pode ter dois itens com o memso equip_id desde q o skill_id seja diferente e vice-versa
CREATE TABLE skills_equip(
    equip_id INT UNSIGNED NOT NULL,
    skill_id INT UNSIGNED NOT NULL,
    level TINYINT UNSIGNED NOT NULL DEFAULT 1,

    PRIMARY KEY (equip_id, skill_id), 
    
    FOREIGN KEY (equip_id)
        REFERENCES equipamentos(id)
        ON DELETE CASCADE,

    FOREIGN KEY (skill_id)
        REFERENCES skills(id)
        ON DELETE CASCADE
);

--diz ql equipamento ta o slot de deco
CREATE TABLE slots_equip(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    equip_id INT UNSIGNED NOT NULL,
    slot_equip TINYINT UNSIGNED NOT NULL,
    slot_level TINYINT UNSIGNED NOT NULL,

    FOREIGN KEY (equip_id)
        REFERENCES equipamentos(id)
        ON DELETE CASCADE,

    UNIQUE (equip_id, slot_equip),  
    INDEX idx_slot_equip (equip_id)
);

--tabela com as decos 
CREATE TABLE decorations(
    equip_id INT UNSIGNED PRIMARY KEY,
    slot_level TINYINT UNSIGNED NOT NULL,

    FOREIGN KEY (equip_id)
        REFERENCES equipamentos(id)
        ON DELETE CASCADE
);

CREATE TABLE charms(
    equip_id INT UNSIGNED PRIMARY KEY,

    FOREIGN KEY (equip_id)
        REFERENCES equipamentos(id)
        ON DELETE CASCADE
);

--tabela q guarda o nome dos sets e.q set de rathalos/deviljho/doshaguma
CREATE TABLE armor_sets(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    descricao TEXT
);

CREATE TABLE armor_set_peca(
    armor_set_id INT UNSIGNED NOT NULL,
    id_armadura INT UNSIGNED NOT NULL,

    PRIMARY KEY (armor_set_id, id_armadura),

    FOREIGN KEY (armor_set_id)
        REFERENCES armor_sets(id)
        ON DELETE CASCADE,

    FOREIGN KEY (id_armadura)
        REFERENCES armadura(equip_id)
        ON DELETE CASCADE
);

CREATE TABLE armor_set_bonus(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    armor_set_id INT UNSIGNED NOT NULL,
    skill_id INT UNSIGNED NOT NULL,
    pecas TINYINT UNSIGNED NOT NULL,
    level TINYINT UNSIGNED NOT NULL DEFAULT 1,
    descricao TEXT,

    FOREIGN KEY (armor_set_id)
        REFERENCES armor_sets(id)
        ON DELETE CASCADE,

    FOREIGN KEY (skill_id)
        REFERENCES skills(id)
        ON DELETE CASCADE
);

--tabela que armazena as builds
CREATE TABLE builds(
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    publico BOOLEAN NOT NULL DEFAULT FALSE,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE SET NULL,

    INDEX idx_build_user (user_id),
    INDEX idx_build_publica (publico)
);

CREATE TABLE equip_build(
    build_id BIGINT UNSIGNED NOT NULL,
    equipment_id INT UNSIGNED NOT NULL,

    equipment_slot ENUM(
        'weapon',
        'head',
        'chest',
        'arms',
        'waist',
        'legs',
        'charm'
    ) NOT NULL,

    PRIMARY KEY (build_id, equipment_slot),

    FOREIGN KEY (build_id)
        REFERENCES builds(id)
        ON DELETE CASCADE,

    FOREIGN KEY (equipment_id)
        REFERENCES equipamentos(id)
);

CREATE TABLE build_decos(
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    build_id BIGINT UNSIGNED NOT NULL,
    decos_id INT UNSIGNED NOT NULL,
    equip_id INT UNSIGNED NOT NULL,
    slot_equip TINYINT UNSIGNED NOT NULL,

    FOREIGN KEY (build_id)
        REFERENCES builds(id)
        ON DELETE CASCADE,

    FOREIGN KEY (decos_id)
        REFERENCES decorations(equip_id),

    FOREIGN KEY (equip_id)
        REFERENCES equipamentos(id),

    UNIQUE(
        equip_id,
        slot_equip
    ),

    INDEX idx_build_decos (build_id)
);

CREATE INDEX idx_nome_skill
ON skills(nome);

CREATE INDEX idx_tipo_armadura
ON armadura(armor_type);

CREATE INDEX idx_tipo_arma
ON armas(tipo_arma);

CREATE INDEX idx_nome_build
ON builds(nome);
