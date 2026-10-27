produtos	CREATE TABLE `produtos` (
   `id` int NOT NULL AUTO_INCREMENT,
   `nome` varchar(150) NOT NULL,
   `preco` decimal(10,2) NOT NULL,
   `quantidade` int NOT NULL,
   `categoria` varchar(100) NOT NULL,
   `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci