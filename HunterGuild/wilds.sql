CREATE DATABASE IF NOT EXISTS mhWilds
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;
USE mhWilds;

CREATE TABLE versions(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	version VARCHAR(30) NOT NULL UNIQUE,
	nome VARCHAR(100) NOT NULL,
	data_ DATE NULL,
	active boolean NOT NULL DEFAULT TRUE
);

CREATE TABLE users(
	id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user VARCHAR(50) NOT NULL UNIQUE,
	email VARCHAR(255) NOT NULL UNIQUE,
	hash_senha VARCHAR(255) NOT NULL,
	criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

	ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tipo_equip(
	id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(50) NOT NULL UNIQUE
);
INSERT INTO tipo_equip (nome) VALUES ('arma'), ('armadura'), ('charm'), ('decos');

CREATE TABLE equipamentos(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(150) NOT NULL,
	descricao TEXT,
	tipo_equip_id TINYINT UNSIGNED NOT NULL,
	raridade TINYINT UNSIGNED NULL,
	game_id BIGINT UNSIGNED NULL,
	version_id INT UNSIGNED NULL,
	criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

	FOREIGN KEY (tipo_equip_id)
		REFERENCES tipo_equip(id),

	FOREIGN KEY (version_id)
		REFERENCES versions(id),

	INDEX idx_equipment_type (equipment_type_id),
	INDEX idx_equipment_name (name)
);

CREATE TABLE weapons (
    equipment_id INT UNSIGNED PRIMARY KEY,

    weapon_type VARCHAR(50) NOT NULL,

    attack INT UNSIGNED NOT NULL DEFAULT 0,
    affinity SMALLINT NOT NULL DEFAULT 0,

    defense_bonus SMALLINT NOT NULL DEFAULT 0,

    elderseal VARCHAR(30) NULL,

    FOREIGN KEY (equipment_id)
        REFERENCES equipment(id)
        ON DELETE CASCADE
);

CREATE TABLE weapon_elements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    weapon_id INT UNSIGNED NOT NULL,

    element_type ENUM(
        'fire',
        'water',
        'thunder',
        'ice',
        'dragon',
        'poison',
        'paralysis',
        'sleep',
        'blast'
    ) NOT NULL,

    value INT NOT NULL DEFAULT 0,

    FOREIGN KEY (weapon_id)
        REFERENCES weapons(equipment_id)
        ON DELETE CASCADE,

    INDEX idx_weapon_element (weapon_id)
);

CREATE TABLE weapon_sharpness (
    weapon_id INT UNSIGNED PRIMARY KEY,

    red INT UNSIGNED NOT NULL DEFAULT 0,
    orange INT UNSIGNED NOT NULL DEFAULT 0,
    yellow INT UNSIGNED NOT NULL DEFAULT 0,
    green INT UNSIGNED NOT NULL DEFAULT 0,
    blue INT UNSIGNED NOT NULL DEFAULT 0,
    white INT UNSIGNED NOT NULL DEFAULT 0,
    purple INT UNSIGNED NOT NULL DEFAULT 0,

    FOREIGN KEY (weapon_id)
        REFERENCES weapons(equipment_id)
        ON DELETE CASCADE
);

CREATE TABLE armor (
    equipment_id INT UNSIGNED PRIMARY KEY,

    armor_kind ENUM(
        'head',
        'chest',
        'arms',
        'waist',
        'legs'
    ) NOT NULL,

    defense_base SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    defense_max SMALLINT UNSIGNED NOT NULL DEFAULT 0,

    fire TINYINT NOT NULL DEFAULT 0,
    water TINYINT NOT NULL DEFAULT 0,
    thunder TINYINT NOT NULL DEFAULT 0,
    ice TINYINT NOT NULL DEFAULT 0,
    dragon TINYINT NOT NULL DEFAULT 0,

    FOREIGN KEY (equipment_id)
        REFERENCES equipment(id)
        ON DELETE CASCADE
);

CREATE TABLE skills (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(120) NOT NULL UNIQUE,

    description TEXT,

    max_level TINYINT UNSIGNED NOT NULL DEFAULT 1
);

CREATE TABLE skill_levels (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    skill_id INT UNSIGNED NOT NULL,

    level TINYINT UNSIGNED NOT NULL,

    description TEXT NOT NULL,

    FOREIGN KEY (skill_id)
        REFERENCES skills(id)
        ON DELETE CASCADE,

    UNIQUE (skill_id, level)
);

CREATE TABLE equipment_skills (
    equipment_id INT UNSIGNED NOT NULL,
    skill_id INT UNSIGNED NOT NULL,

    level TINYINT UNSIGNED NOT NULL DEFAULT 1,

    PRIMARY KEY (equipment_id, skill_id),

    FOREIGN KEY (equipment_id)
        REFERENCES equipment(id)
        ON DELETE CASCADE,

    FOREIGN KEY (skill_id)
        REFERENCES skills(id)
        ON DELETE CASCADE
);

CREATE TABLE equipment_slots (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    equipment_id INT UNSIGNED NOT NULL,

    slot_position TINYINT UNSIGNED NOT NULL,

    slot_level TINYINT UNSIGNED NOT NULL,

    FOREIGN KEY (equipment_id)
        REFERENCES equipment(id)
        ON DELETE CASCADE,

    UNIQUE (equipment_id, slot_position),

    INDEX idx_equipment_slots (equipment_id)
);

CREATE TABLE decorations (
    equipment_id INT UNSIGNED PRIMARY KEY,

    slot_level TINYINT UNSIGNED NOT NULL,

    FOREIGN KEY (equipment_id)
        REFERENCES equipment(id)
        ON DELETE CASCADE
);

CREATE TABLE charms (
    equipment_id INT UNSIGNED PRIMARY KEY,

    FOREIGN KEY (equipment_id)
        REFERENCES equipment(id)
        ON DELETE CASCADE
);

CREATE TABLE armor_sets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(120) NOT NULL,

    description TEXT
);

CREATE TABLE armor_set_pieces (
    armor_set_id INT UNSIGNED NOT NULL,

    armor_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (armor_set_id, armor_id),

    FOREIGN KEY (armor_set_id)
        REFERENCES armor_sets(id)
        ON DELETE CASCADE,

    FOREIGN KEY (armor_id)
        REFERENCES armor(equipment_id)
        ON DELETE CASCADE
);

CREATE TABLE armor_set_bonuses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    armor_set_id INT UNSIGNED NOT NULL,

    skill_id INT UNSIGNED NOT NULL,

    pieces_required TINYINT UNSIGNED NOT NULL,

    level TINYINT UNSIGNED NOT NULL DEFAULT 1,

    description TEXT,

    FOREIGN KEY (armor_set_id)
        REFERENCES armor_sets(id)
        ON DELETE CASCADE,

    FOREIGN KEY (skill_id)
        REFERENCES skills(id)
        ON DELETE CASCADE
);

CREATE TABLE builds (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT UNSIGNED NULL,

    name VARCHAR(150) NOT NULL,

    description TEXT,

    is_public BOOLEAN NOT NULL DEFAULT FALSE,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE SET NULL,

    INDEX idx_build_user (user_id),
    INDEX idx_build_public (is_public)
);

CREATE TABLE build_equipment (
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
        REFERENCES equipment(id)
);

CREATE TABLE build_decorations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    build_id BIGINT UNSIGNED NOT NULL,

    decoration_id INT UNSIGNED NOT NULL,

    target_equipment_id INT UNSIGNED NOT NULL,

    slot_position TINYINT UNSIGNED NOT NULL,

    FOREIGN KEY (build_id)
        REFERENCES builds(id)
        ON DELETE CASCADE,

    FOREIGN KEY (decoration_id)
        REFERENCES decorations(equipment_id),

    FOREIGN KEY (target_equipment_id)
        REFERENCES equipment(id),

    UNIQUE (
        target_equipment_id,
        slot_position
    ),

    INDEX idx_build_decorations (build_id)
);

CREATE TABLE materials (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(150) NOT NULL UNIQUE,

    description TEXT
);

CREATE TABLE equipment_materials (
    equipment_id INT UNSIGNED NOT NULL,

    material_id INT UNSIGNED NOT NULL,

    quantity SMALLINT UNSIGNED NOT NULL DEFAULT 1,

    PRIMARY KEY (equipment_id, material_id),

    FOREIGN KEY (equipment_id)
        REFERENCES equipment(id)
        ON DELETE CASCADE,

    FOREIGN KEY (material_id)
        REFERENCES materials(id)
        ON DELETE CASCADE
);

CREATE TABLE monsters (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(120) NOT NULL UNIQUE,

    description TEXT,

    species VARCHAR(100),

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE monster_materials (
    monster_id INT UNSIGNED NOT NULL,

    material_id INT UNSIGNED NOT NULL,

    source_description TEXT,

    PRIMARY KEY (monster_id, material_id),

    FOREIGN KEY (monster_id)
        REFERENCES monsters(id)
        ON DELETE CASCADE,

    FOREIGN KEY (material_id)
        REFERENCES materials(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_skills_name
ON skills(name);

CREATE INDEX idx_armor_kind
ON armor(armor_kind);

CREATE INDEX idx_weapon_type
ON weapons(weapon_type);

CREATE INDEX idx_builds_name
ON builds(name);

CREATE INDEX idx_materials_name
ON materials(name);
