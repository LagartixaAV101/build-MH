USE mhWilds;

INSERT INTO versions (version, descricao, data_, active)
	VALUES
	('Ver. 1.042.00.02', 'Ultima atualização antes da dlc', 14/08/2026, 1);

--insert das armas na tabela equipamentos
INSERT INTO equipamentos (nome, descricao, tipo_equip_id, raridade)
	VALUES
	('Hope Blade I', 'Hope Blade inicial', 1, 1),
	('Hope Blade II', 'Upgrade 1 da Hope Blade', 1, 1),
	('Hope Blade III', '3 Upgrade Hope Blade', 1, 3),
	('Hope Blade IV', '4 Upgrade Hope Blade', 1, 5),
	('Abaddonian Krake', 'Ultima upgrade espada Nu Udra', 1, 8);

INSERT INTO armas (equip_id, tipo_arma, ataque, afinidade, bonus_defesa, elderseal)
	SELECT id, 'GreatSword', 432, 0, 0, 'nao'
		FROM equipamentos WHERE nome = 'Hope Blade I'

	UNION ALL
	
	SELECT id, 'GreatSword', 480, 0, 0, 'nao'
		FROM equipamentos WHERE nome = 'Hope Blade II'

	UNION ALL
		
	SELECT id, 'GreatSword', 624, 0, 0, 'nao' 
		FROM equipamentos WHERE nome = 'Hope Blade III'

	UNION ALL
		
	SELECT id, 'GreatSword', 768, 0, 0, 'nao'
		FROM equipamentos WHERE nome = 'Hope Blade IV'

	UNION ALL
		
	SELECT id, 'GreatSword', 1104, -15, 0, 'nao'
		FROM equipamentos WHERE nome = 'Abaddonian Krake';

INSERT INTO dano_elemental (id_arma, elemento, dano)
	SELECT id, 'nenhum', 0
		FROM equipamentos WHERE nome = 'Hope Blade I'

	UNION ALL
		
	SELECT id, 'nenhum', 0
		FROM equipamentos WHERE nome = 'Hope Blade II'

	UNION ALL
		
	SELECT id, 'nenhum', 0
		FROM equipamentos WHERE nome = 'Hope Blade III'

	UNION ALL
		
	SELECT id, 'nenhum', 0
		FROM equipamentos WHERE nome = 'Hope Blade IV'

	UNION ALL
		
	SELECT id, 'fogo', 400
		FROM equipamentos WHERE nome = 'Abaddonian Krake';

INSERT INTO sharpness (id_arma, red, orange, yellow, green, blue, white, purple)
	SELECT id, 50, 50, 50, 15, 0, 0, 0
		FROM equipamentos WHERE nome = 'Hope Blade I'

	UNION ALL
		
	SELECT id, 50, 50, 50, 30, 0, 0, 0
		FROM equipamentos WHERE nome = 'Hope Blade II'

	UNION ALL

	SELECT id, 50, 50, 50, 45, 0, 0, 0
		FROM equipamentos WHERE nome = 'Hope Blade III'

	UNION ALL
		
	SELECT id, 50, 50, 50, 50, 15, 0, 0
		FROM equipamentos WHERE nome = 'Hope Blade IV'

	UNION ALL

	SELECT id, 100, 10, 150, 30, 50, 0, 0
		FROM equipamentos WHERE nome = 'Abaddonian Krake';
	
--insert de armaduras
INSERT INTO equipamentos (nome, descricao, tipo_equip_id, raridade)
	VALUES
	('Hope Mask', 'Capacete do conjunto Hope', 2, 1),
	('Hope Mail', 'Peitoral do conjunto Hope', 2, 1),
	('Hope Vambraces', 'Braçadeira do conjunto Hope', 2, 1),
	('Hope Coil', 'Cintura do conjunto Hope', 2, 1),
	('Hope Greaves', 'Calças do conjunto Hope', 2, 1),
	('Nerscylla Helm', 'Capacete da Nerscylla', 2, 3),
	('Nerscylla Mail', 'Peitoral da Nerscylla', 2, 3),
	('Nerscylla Vambraces', 'Braçadeira da Nerscylla', 2, 3),
	('Nerscylla Coil', 'Cintura da Nerscylla', 2, 3),
	('Nerscylla Greaves', 'Calças da Nerscylla', 2, 3),
	('Rompopolo Helm', 'Capacete do Rompopolo', 2, 3),
	('Rompopolo Mail', 'Peitoral do Rompopolo', 2, 3),
	('Rompopolo Vambraces', 'Braçadeira do Rompopolo', 2, 3),
	('Rompopolo Coil', 'Cintura do Rompopolo', 2, 3),
	('Rompopolo Greaves', 'Calças do Rompopolo', 2, 3),
	('Rey Sandhelm Alpha', 'Capacete Alpha do Rey Dau', 2, 7),
	('Rey Sandmail Alpha', 'Peitoral Alpha do Rey Dau', 2, 7),
	('Rey Sandbraces Alpha', 'Braçadeira Alpha do Rey Dau', 2, 7),
	('Rey Sandcoil Alpha', 'Cintura Alpha do Rey Dau', 2, 7),
	('Rey Sandgreaves Alpha', 'Calças Alpha do Rey Dau', 2, 7),
	('Rey Sandhelm Beta', 'Capacete Beta do Rey Dau', 2, 7),
	('Rey Sandmail Beta', 'Peitoral Beta do Rey Dau', 2, 7),
	('Rey Sandbraces Beta', 'Braçadeira Beta do Rey Dau', 2, 7),
	('Rey Sandcoil Beta', 'Cintura Beta do Rey Dau', 2, 7),
	('Rey Sandgreaves Beta', 'Calças Beta do Rey Dau', 2, 7),
	('Rey Sandhelm Y', 'Capacete Gamma do Rey Dau', 2, 8),
	('Rey Sandmail Y', 'Peitoral Gamma do Rey Dau', 2, 8),
	('Rey Sandbraces Y', 'Braçadeira Gamma do Rey Dau', 2, 8),
	('Rey Sandcoil Y', 'Cintura Gamma do Rey Dau', 2, 8),
	('Rey Sandgreaves Y', 'Calças Gamma do Rey Dau', 2, 8);

INSERT INTO armadura (equip_id, armor_type, defesa, fogo, agua, trovao, gelo, dragao)
SELECT id, 'head', 2, 1, 0, 1, 0, 0
	FROM equipamentos WHERE nome ='Hope Mask'

	UNION ALL
	
SELECT id, 'chest', 2, 1, 0, 1, 0, 0
	FROM equipamentos WHERE nome ='Hope Mail'

	UNION ALL
	
SELECT id, 'arms', 2, 1, 0, 1, 0, 0
	FROM equipamentos WHERE nome ='Hope Vambraces'

	UNION ALL
	
SELECT id, 'waist', 2, 1, 0, 1, 0, 0
	FROM equipamentos WHERE nome ='Hope Coil'

	UNION ALL
	
SELECT id, 'legs', 2, 1, 0, 1, 0, 0
	FROM equipamentos WHERE nome ='Hope Greaves'

	UNION ALL
	
SELECT id, 'head', 20, -2, 2, -2, 1, 2
	FROM equipamentos WHERE nome ='Nerscylla Helm'

	UNION ALL
	
SELECT id, 'chest', 20, -2, 2, -2, 1, 2
	FROM equipamentos WHERE nome ='Nerscylla Mail'

	UNION ALL
	
SELECT id, 'arms', 20, -2, 2, -2, 1, 2
	FROM equipamentos WHERE nome ='Nerscylla Vambraces'

	UNION ALL
	
SELECT id, 'waist', 20, -2, 2, -2, 1, 2
	FROM equipamentos WHERE nome ='Nerscylla Coil'

	UNION ALL
	
SELECT id, 'legs', 20, -2, 2, -2, 1, 2
	FROM equipamentos WHERE nome ='Nerscylla Greaves'

	UNION ALL
	
SELECT id, 'head', 18, 0, -3, 0, 0, 1
	FROM equipamentos WHERE nome ='Rompopolo Helm'

	UNION ALL
	
SELECT id, 'chest', 18, 0, -3, 0, 0, 1
	FROM equipamentos WHERE nome ='Rompopolo Mail'

	UNION ALL
	
SELECT id, 'arms', 18, 0, -3, 0, 0, 1
	FROM equipamentos WHERE nome ='Rompopolo Vambraces'

	UNION ALL
	
SELECT id, 'waist', 18, 0, -3, 0, 0, 1
	FROM equipamentos WHERE nome ='Rompopolo Coil'

	UNION ALL
	
SELECT id, 'legs', 18, 0, -3, 0, 0, 1
	FROM equipamentos WHERE nome ='Rompopolo Greaves'

	UNION ALL
	
SELECT id, 'head', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandhelm Alpha'

	UNION ALL
	
SELECT id, 'chest', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandmail Alpha'

	UNION ALL
	
SELECT id, 'arms', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandbraces Alpha'

	UNION ALL
	
SELECT id, 'waist', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandcoil Alpha'

	UNION ALL
	
SELECT id, 'legs', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandgreaves Alpha'

	UNION ALL
	
SELECT id, 'head', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandhelm Beta'

	UNION ALL
	
SELECT id, 'chest', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandmail Beta'

	UNION ALL
	
SELECT id, 'arms', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandbraces Beta'

	UNION ALL
	
SELECT id, 'waist', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandcoil Beta'

	UNION ALL
	
SELECT id, 'legs', 60, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandgreaves Beta'

	UNION ALL
	
SELECT id, 'head', 68, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandhelm Y'

	UNION ALL
	
SELECT id, 'chest', 68, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandmail Y'

	UNION ALL
	
SELECT id, 'arms', 68, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandbraces Y'

	UNION ALL
	
SELECT id, 'waist', 68, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandcoil Y'

	UNION ALL
	
SELECT id, 'legs', 68, 0, -2, 4, -3, 0
	FROM equipamentos WHERE nome ='Rey Sandgreaves Y';
