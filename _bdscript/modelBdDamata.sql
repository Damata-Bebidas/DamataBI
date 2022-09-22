--
-- Banco de dados: `damata`
--
-- --------------------------------------------------------
--
-- Estrutura para tabela `analise_simulador`
--

CREATE TABLE `analise_simulador` (
  `id` mediumint(9) NOT NULL,
  `simulador` mediumint(9) NOT NULL,
  `qtd` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `serasa` char(1) NOT NULL,
  `classerisco` tinyint(1) DEFAULT NULL,
  `docs` char(1) DEFAULT NULL,
  `inad` char(1) DEFAULT NULL,
  `giro` char(1) DEFAULT NULL,
  `comodato` mediumint(9) DEFAULT NULL,
  `ttcompracxs` smallint(6) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `motivo` varchar(30) DEFAULT NULL,
  `aprovador` int(11) DEFAULT NULL,
  `log` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `aplicabilidade`
--

CREATE TABLE `aplicabilidade` (
  `id_aplic` varchar(12) NOT NULL,
  `id_tr` int(11) NOT NULL,
  `matricula` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `matricula` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `arquivos`
--

CREATE TABLE `arquivos` (
  `matricula` int(11) NOT NULL,
  `arquivo` varchar(100) NOT NULL,
  `data_envio` datetime NOT NULL,
  `tipo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `boleto`
--

CREATE TABLE `boleto` (
  `numDoc` varchar(40) NOT NULL,
  `NB` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `vencimento` date NOT NULL,
  `data` datetime NOT NULL,
  `danfe` varchar(20) DEFAULT NULL,
  `pj_pf` char(1) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `end` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `uf` char(2) NOT NULL,
  `cep` varchar(20) NOT NULL,
  `indicadorBaseCentral` varchar(100) NOT NULL,
  `codigoBarras` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro`
--

CREATE TABLE `cadastro` (
  `matricula` int(15) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `setor` varchar(20) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `cargo` varchar(50) NOT NULL,
  `nascimento` date NOT NULL,
  `admissao` date NOT NULL,
  `sexo` varchar(9) NOT NULL,
  `escolaridade` varchar(40) NOT NULL DEFAULT '-',
  `status` varchar(10) NOT NULL DEFAULT 'ATIVO',
  `tipo` varchar(10) NOT NULL DEFAULT 'BASIC',
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de Cadastro';

-- --------------------------------------------------------

--
-- Estrutura para tabela `censo`
--

CREATE TABLE `censo` (
  `id` int(11) NOT NULL,
  `setor` varchar(20) NOT NULL,
  `idade` varchar(20) NOT NULL,
  `tempo` varchar(20) NOT NULL,
  `lider` char(1) NOT NULL,
  `estadocivil` varchar(25) NOT NULL,
  `escolaridade` varchar(30) NOT NULL,
  `religiao` varchar(60) NOT NULL,
  `genero` char(1) NOT NULL,
  `orientacaosexual` varchar(60) NOT NULL,
  `cor` varchar(10) NOT NULL,
  `nacionalidade` char(1) NOT NULL,
  `naturalidade` char(1) NOT NULL,
  `pcd` char(1) NOT NULL,
  `deficiencia` char(1) DEFAULT 'N',
  `politicadiversidade` char(1) NOT NULL,
  `importante` tinyint(2) NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `check`
--

CREATE TABLE `check` (
  `id_check` varchar(12) NOT NULL,
  `id_key_check` varchar(12) NOT NULL,
  `id_tr` int(11) NOT NULL,
  `instrutor` int(11) NOT NULL,
  `freq` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL,
  `Questao` varchar(100) NOT NULL,
  `A` varchar(100) NOT NULL,
  `B` varchar(100) NOT NULL,
  `C` varchar(100) NOT NULL,
  `D` varchar(100) NOT NULL,
  `Gabarito` char(1) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `checkReacao`
--

CREATE TABLE `checkReacao` (
  `id_check` varchar(12) NOT NULL,
  `id_key_check` varchar(12) NOT NULL,
  `id_tr` int(11) NOT NULL,
  `matricula` int(11) NOT NULL,
  `freq` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL,
  `QT1_1` char(1) NOT NULL,
  `QT1_2` char(1) NOT NULL,
  `QT2_1` char(1) NOT NULL,
  `QT2_2` char(1) NOT NULL,
  `QT2_3` char(1) NOT NULL,
  `QT3_1` char(1) NOT NULL,
  `QT3_2` char(1) NOT NULL,
  `QT3_3` char(1) NOT NULL,
  `QT3_4` char(1) NOT NULL,
  `QT3_5` char(1) NOT NULL,
  `Obs` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `checkResp`
--

CREATE TABLE `checkResp` (
  `id_check` varchar(12) NOT NULL,
  `id_key_check` varchar(12) NOT NULL,
  `id_tr` int(11) NOT NULL,
  `matricula` int(11) NOT NULL,
  `freq` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL,
  `QT1` char(1) NOT NULL,
  `QT2` char(1) NOT NULL,
  `QT3` char(1) NOT NULL,
  `QT4` char(1) NOT NULL,
  `QT5` char(1) NOT NULL,
  `QT6` char(1) NOT NULL,
  `QT7` char(1) NOT NULL,
  `QT8` char(1) NOT NULL,
  `QT9` char(1) NOT NULL,
  `QT10` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cid`
--

CREATE TABLE `cid` (
  `CAT` char(3) NOT NULL,
  `DESCRABREV` tinytext NOT NULL,
  `DESCRICAO` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de Cadastro';

-- --------------------------------------------------------

--
-- Estrutura para tabela `entrevista`
--

CREATE TABLE `entrevista` (
  `id` varchar(100) NOT NULL,
  `matricula` int(11) NOT NULL,
  `data` date NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `motivo` varchar(50) NOT NULL,
  `semjust` char(1) NOT NULL,
  `comprevia` char(1) NOT NULL,
  `justicomp` char(1) NOT NULL,
  `acao` varchar(50) NOT NULL,
  `acatada` char(1) NOT NULL,
  `alinhada` char(1) NOT NULL,
  `diadescontado` char(1) NOT NULL,
  `inicio` date NOT NULL,
  `fim` date NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `medclin`
--

CREATE TABLE `medclin` (
  `Id` varchar(20) NOT NULL,
  `Data Atend` date NOT NULL,
  `Matricula` int(11) NOT NULL,
  `Prontuario` int(11) NOT NULL,
  `Tipo` tinytext NOT NULL,
  `CID` char(3) DEFAULT NULL,
  `Tempo` int(11) NOT NULL,
  `UnidTempo` varchar(20) NOT NULL,
  `Inicio` date NOT NULL,
  `Fim` date NOT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de Cadastro';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pesquisaNPS`
--

CREATE TABLE `pesquisaNPS` (
  `ID` int(11) NOT NULL,
  `NB` int(11) NOT NULL,
  `MatFunc` tinytext DEFAULT NULL,
  `Data` date NOT NULL,
  `Nota` tinyint(1) NOT NULL,
  `Motivo` char(1) DEFAULT NULL,
  `Comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `plano`
--

CREATE TABLE `plano` (
  `id_tr` int(11) NOT NULL,
  `previsao` date DEFAULT NULL,
  `custo` decimal(10,2) DEFAULT 0.00,
  `tipo` enum('Interno','Externo') DEFAULT 'Interno',
  `conclusao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `planobh`
--

CREATE TABLE `planobh` (
  `id` int(11) NOT NULL,
  `mat` int(11) NOT NULL,
  `saldo` smallint(6) NOT NULL,
  `abatido` smallint(6) NOT NULL,
  `PagarCompensar` char(1) NOT NULL,
  `data` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `autorizado` int(11) NOT NULL,
  `obs` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `prova`
--

CREATE TABLE `prova` (
  `id` int(11) NOT NULL,
  `matricula` int(11) NOT NULL,
  `aplicacao` date NOT NULL,
  `tipo` enum('3 Meses','6 Meses') NOT NULL,
  `cargo` char(1) NOT NULL,
  `qt1` char(1) NOT NULL,
  `qt2` char(1) NOT NULL,
  `qt3` char(1) NOT NULL,
  `qt4` char(1) NOT NULL,
  `qt5` char(1) NOT NULL,
  `qt6` char(1) NOT NULL,
  `qt7` char(1) NOT NULL,
  `qt8` char(1) NOT NULL,
  `qt9` char(1) NOT NULL,
  `qt10` char(1) NOT NULL,
  `qt11` char(1) NOT NULL,
  `qt12` char(1) NOT NULL,
  `qt13` char(1) NOT NULL,
  `qt14` char(1) DEFAULT NULL,
  `qt15` char(1) DEFAULT NULL,
  `qt16` char(1) DEFAULT NULL,
  `qt17` char(1) DEFAULT NULL,
  `qt18` char(1) DEFAULT NULL,
  `qt19` char(1) DEFAULT NULL,
  `qt20` char(1) DEFAULT NULL,
  `qt21` char(1) DEFAULT NULL,
  `qt22` char(1) DEFAULT NULL,
  `qt23` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `saneamento`
--

CREATE TABLE `saneamento` (
  `NB` int(11) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `PJ_PF` char(1) NOT NULL,
  `GV` tinyint(2) NOT NULL,
  `SV` tinyint(2) NOT NULL,
  `VDE` smallint(3) NOT NULL,
  `End` varchar(50) NOT NULL,
  `Compl` varchar(30) DEFAULT NULL,
  `Bairro` varchar(60) NOT NULL,
  `Cidade` varchar(40) NOT NULL,
  `CEP` varchar(11) NOT NULL,
  `Tel` varchar(70) NOT NULL,
  `Cadastro` date NOT NULL,
  `UltimaCompra` date NOT NULL,
  `Categoria` varchar(30) NOT NULL,
  `Anomalias` char(2) NOT NULL,
  `Base` char(1) NOT NULL,
  `Tipo` char(1) NOT NULL,
  `data` datetime DEFAULT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 1,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `simulador`
--

CREATE TABLE `simulador` (
  `id` mediumint(9) NOT NULL,
  `nb` int(11) NOT NULL,
  `vasilhame` varchar(20) NOT NULL,
  `descr` varchar(60) NOT NULL,
  `classerisco` tinyint(1) DEFAULT 6,
  `docs` char(1) DEFAULT 'N',
  `inad` char(1) DEFAULT 'N',
  `giro` char(1) DEFAULT 'Z',
  `comodato` mediumint(9) NOT NULL,
  `ttcompracxs` smallint(6) NOT NULL,
  `metagiro` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura para tabela `treinamento`
--

CREATE TABLE `treinamento` (
  `id_tr` int(11) NOT NULL,
  `Treinamento` varchar(100) NOT NULL,
  `cargos` varchar(80) DEFAULT NULL,
  `frequencia` varchar(30) DEFAULT NULL,
  `carga` varchar(80) DEFAULT NULL,
  `responsavel` varchar(80) DEFAULT NULL,
  `id_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `treinar`
--

CREATE TABLE `treinar` (
  `Id_tr_freq` varchar(20) NOT NULL,
  `id_treinar` varchar(11) NOT NULL,
  `matricula` int(11) NOT NULL,
  `id_tr` int(11) NOT NULL,
  `data` date NOT NULL,
  `previsao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `visitas`
--

CREATE TABLE `visitas` (
  `ID` int(11) NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `area` varchar(40) NOT NULL,
  `video` char(3) NOT NULL,
  `data` datetime NOT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `equipamentos` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `analise_simulador`
--
ALTER TABLE `analise_simulador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_simulador` (`simulador`);

--
-- Índices de tabela `aplicabilidade`
--
ALTER TABLE `aplicabilidade`
  ADD PRIMARY KEY (`id_aplic`),
  ADD KEY `fk_id_tr` (`id_tr`) USING BTREE,
  ADD KEY `fk_matricula` (`matricula`) USING BTREE;

--
-- Índices de tabela `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`),
  ADD KEY `fk_mat` (`matricula`) USING BTREE;

--
-- Índices de tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`matricula`);

--
-- Índices de tabela `boleto`
--
ALTER TABLE `boleto`
  ADD PRIMARY KEY (`numDoc`);

--
-- Índices de tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`matricula`);

--
-- Índices de tabela `censo`
--
ALTER TABLE `censo`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `check`
--
ALTER TABLE `check`
  ADD PRIMARY KEY (`id_check`),
  ADD KEY `id_tr` (`id_tr`),
  ADD KEY `instrutor` (`instrutor`);

--
-- Índices de tabela `checkReacao`
--
ALTER TABLE `checkReacao`
  ADD PRIMARY KEY (`id_check`),
  ADD KEY `matricula` (`matricula`),
  ADD KEY `id_tr` (`id_tr`);

--
-- Índices de tabela `checkResp`
--
ALTER TABLE `checkResp`
  ADD PRIMARY KEY (`id_check`),
  ADD KEY `id_tr` (`id_tr`),
  ADD KEY `matricula` (`matricula`);

--
-- Índices de tabela `cid`
--
ALTER TABLE `cid`
  ADD PRIMARY KEY (`CAT`);

--
-- Índices de tabela `entrevista`
--
ALTER TABLE `entrevista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricula` (`matricula`);

--
-- Índices de tabela `medclin`
--
ALTER TABLE `medclin`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Matricula` (`Matricula`),
  ADD KEY `CID` (`CID`);

--
-- Índices de tabela `pesquisaNPS`
--
ALTER TABLE `pesquisaNPS`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_NPS_NB` (`NB`);

--
-- Índices de tabela `plano`
--
ALTER TABLE `plano`
  ADD PRIMARY KEY (`id_tr`);

--
-- Índices de tabela `planobh`
--
ALTER TABLE `planobh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `planobh_ges_1` (`mat`),
  ADD KEY `planobh_ibfk_1` (`autorizado`);

--
-- Índices de tabela `prova`
--
ALTER TABLE `prova`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricula` (`matricula`);

--
-- Índices de tabela `saneamento`
--
ALTER TABLE `saneamento`
  ADD PRIMARY KEY (`NB`);

--
-- Índices de tabela `simulador`
--
ALTER TABLE `simulador`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `treinamento`
--
ALTER TABLE `treinamento`
  ADD PRIMARY KEY (`id_tr`),
  ADD KEY `fk_id_area` (`id_area`) USING BTREE;

--
-- Índices de tabela `treinar`
--
ALTER TABLE `treinar`
  ADD PRIMARY KEY (`Id_tr_freq`),
  ADD KEY `fk_matricula` (`matricula`) USING BTREE,
  ADD KEY `fk_id_tr` (`id_tr`) USING BTREE,
  ADD KEY `id_treinar` (`id_treinar`) USING BTREE;

--
-- Índices de tabela `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `analise_simulador`
--
ALTER TABLE `analise_simulador`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `censo`
--
ALTER TABLE `censo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pesquisaNPS`
--
ALTER TABLE `pesquisaNPS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `planobh`
--
ALTER TABLE `planobh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `prova`
--
ALTER TABLE `prova`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `simulador`
--
ALTER TABLE `simulador`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4852;

--
-- AUTO_INCREMENT de tabela `treinamento`
--
ALTER TABLE `treinamento`
  MODIFY `id_tr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT de tabela `visitas`
--
ALTER TABLE `visitas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `analise_simulador`
--
ALTER TABLE `analise_simulador`
  ADD CONSTRAINT `fk_simulador` FOREIGN KEY (`simulador`) REFERENCES `simulador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `aplicabilidade`
--
ALTER TABLE `aplicabilidade`
  ADD CONSTRAINT `fk_id_tr_aplicabidade` FOREIGN KEY (`matricula`) REFERENCES `cadastro` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_if_tr_aplicabidade` FOREIGN KEY (`id_tr`) REFERENCES `treinamento` (`id_tr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `fk_mat` FOREIGN KEY (`matricula`) REFERENCES `cadastro` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `fk_arquivos` FOREIGN KEY (`matricula`) REFERENCES `cadastro` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `check`
--
ALTER TABLE `check`
  ADD CONSTRAINT `fk_check` FOREIGN KEY (`id_tr`) REFERENCES `treinamento` (`id_tr`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_instrutor` FOREIGN KEY (`instrutor`) REFERENCES `cadastro` (`matricula`);

--
-- Restrições para tabelas `checkReacao`
--
ALTER TABLE `checkReacao`
  ADD CONSTRAINT `fk_mat_reacao` FOREIGN KEY (`matricula`) REFERENCES `cadastro` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tr_reacao` FOREIGN KEY (`id_tr`) REFERENCES `treinamento` (`id_tr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `checkResp`
--
ALTER TABLE `checkResp`
  ADD CONSTRAINT `fk_matricula_check` FOREIGN KEY (`matricula`) REFERENCES `cadastro` (`matricula`),
  ADD CONSTRAINT `fk_treina_check` FOREIGN KEY (`id_tr`) REFERENCES `treinamento` (`id_tr`);

--
-- Restrições para tabelas `entrevista`
--
ALTER TABLE `entrevista`
  ADD CONSTRAINT `fk_mat_entrevista` FOREIGN KEY (`matricula`) REFERENCES `cadastro` (`matricula`);

--
-- Restrições para tabelas `medclin`
--
ALTER TABLE `medclin`
  ADD CONSTRAINT `fk_cid` FOREIGN KEY (`CID`) REFERENCES `cid` (`CAT`),
  ADD CONSTRAINT `fk_cid_matricula` FOREIGN KEY (`Matricula`) REFERENCES `cadastro` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `pesquisaNPS`
--
ALTER TABLE `pesquisaNPS`
  ADD CONSTRAINT `FK_NPS_NB` FOREIGN KEY (`NB`) REFERENCES `saneamento` (`NB`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `plano`
--
ALTER TABLE `plano`
  ADD CONSTRAINT `fk_treinamento` FOREIGN KEY (`id_tr`) REFERENCES `treinamento` (`id_tr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `planobh`
--
ALTER TABLE `planobh`
  ADD CONSTRAINT `planobh_ges_1` FOREIGN KEY (`mat`) REFERENCES `cadastro` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `planobh_ibfk_1` FOREIGN KEY (`autorizado`) REFERENCES `cadastro` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `prova`
--
ALTER TABLE `prova`
  ADD CONSTRAINT `fk_matricula_prova` FOREIGN KEY (`matricula`) REFERENCES `cadastro` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `treinamento`
--
ALTER TABLE `treinamento`
  ADD CONSTRAINT `fk_id_area` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `treinar`
--
ALTER TABLE `treinar`
  ADD CONSTRAINT `fk_id_tr` FOREIGN KEY (`id_tr`) REFERENCES `treinamento` (`id_tr`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_matricula` FOREIGN KEY (`matricula`) REFERENCES `cadastro` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

-- Tabela 'Passivo'

CREATE TABLE `passivo` (
  `Id_numero` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `matricula` int(11) NOT NULL,
  `forum` varchar(50) NOT NULL,
  `vara` varchar(60) NOT NULL,
  `processo` varchar(50) NOT NULL,
  `reu` varchar(50) NOT NULL,
  `periodo_trabalho_ini` date NOT NULL,
  `periodo_trabalho_fim` date NOT NULL,
  `advogado_reclamante` varchar(100) DEFAULT NULL,
  `itens_reclamados` longtext DEFAULT NULL,
  `valor_requerido` decimal(10,2) DEFAULT NULL,
  `abertura_processo` date DEFAULT NULL,
  `contestacao` date DEFAULT NULL,
  `encerramento_processo` longtext DEFAULT NULL,
  `fase_processo_reclamados` longtext DEFAULT NULL,
  `reclamados` varchar(50) DEFAULT NULL,
  `audiencias` longtext DEFAULT NULL,
  `preposto` varchar(50) DEFAULT NULL,
  `juiz_do_trabalho` varchar(50) DEFAULT NULL,
  `testemunhas` longtext DEFAULT NULL,
  `pericia` longtext DEFAULT NULL,
  `deposito_recursal` varchar(120) DEFAULT NULL,
  `valor_acordo` longtext DEFAULT NULL,
  `sentenca` longtext DEFAULT NULL,
  `recurso_ordinario` longtext DEFAULT NULL,
  `recurso_revista` varchar(100) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `status_processo` char(1) NOT NULL,
  `pareto` char(2) NOT NULL,
  `data` date NOT NULL,
  FOREIGN KEY(`matricula`) REFERENCES `cadastro`(`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `remuneracao`

CREATE TABLE IF NOT EXISTS `remuneracao` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `data` date NOT NULL,
  `setor` char(1) NOT NULL,
  `tipo` char(1) NOT NULL,
  `matricula_colaborador` int(11) NOT NULL,
  `status` char(2) NOT NULL,
  `dias_trabalhados` smallint(2) NOT NULL,
  `atributo` varchar(50) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `gratificacao` decimal(10,2) DEFAULT NULL
  FOREIGN KEY(`matricula_colaborador`) REFERENCES `cadastro`(`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `entrada`
CREATE TABLE IF NOT EXISTS `entrada` ( 
  `matricula` INT NOT NULL PRIMARY KEY, 
  `hora` TIME NOT NULL,
  FOREIGN KEY(`matricula`) REFERENCES `cadastro`(`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `penalidades`
CREATE TABLE IF NOT EXISTS `penalidades` ( 
  `id` INT PRIMARY KEY AUTO_INCREMENT, 
  `colaborador` INT NOT NULL, 
  `data` DATE NOT NULL,
  `motivo` TEXT NOT NULL,
  `tipo` CHAR(1) NOT NULL,
  `aplicador` INT NOT NULL, 
  FOREIGN KEY(`colaborador`) REFERENCES `cadastro`(`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY(`aplicador`) REFERENCES `cadastro`(`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `mapeamento`
CREATE TABLE IF NOT EXISTS `mapeamento` ( 
  `id` INT PRIMARY KEY AUTO_INCREMENT, 
  `matricula` INT NOT NULL,
  `data` DATE NOT NULL,
  `tipo` CHAR(1) NOT NULL,
  `motivo` TEXT NOT NULL,
  `iniciativa` CHAR(1) NOT NULL,
  `ciclo` CHAR(1),
  `situacao` CHAR(1) NULL DEFAULT 'I', 
  FOREIGN KEY(`matricula`) REFERENCES `cadastro`(`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `token`
CREATE TABLE IF NOT EXISTS `tokenSicoob` ( 
  `id` INT PRIMARY KEY AUTO_INCREMENT, 
  `token` TEXT NOT NULL,
  `data` DATETIME NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `token`
CREATE TABLE IF NOT EXISTS `apiconfig` ( 
  `id` INT PRIMARY KEY AUTO_INCREMENT, 
  `api` VARCHAR(10) NOT NULL,
  `data` DATETIME NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura da tabela `encarrareiramento`
CREATE TABLE IF NOT EXISTS `encarreiramento` ( 
  `id` INT PRIMARY KEY AUTO_INCREMENT, 
  `matricula` INT NOT NULL,
  `data` DATE NOT NULL,
  `cargo` VARCHAR(100) NOT NULL,
  FOREIGN KEY(`matricula`) REFERENCES `cadastro`(`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;