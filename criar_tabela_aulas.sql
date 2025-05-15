-- Criar tabela aulas
CREATE TABLE IF NOT EXISTS `aulas` (
  `id_aula` int(11) NOT NULL AUTO_INCREMENT,
  `id_modulo` int(11) NOT NULL,
  `titulo_aula` varchar(255) NOT NULL,
  `descricao_aula` text,
  `video_aula` varchar(255),
  `imagem_aula` varchar(255),
  `ordem_aula` int(11) NOT NULL DEFAULT 0,
  `duracao_aula` int(11) DEFAULT NULL COMMENT 'Duração em minutos',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_aula`),
  KEY `fk_aulas_modulo` (`id_modulo`),
  CONSTRAINT `fk_aulas_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 