BEGIN TRANSACTION;
CREATE TABLE `users` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`user_name`	TEXT NOT NULL,
	`password`	TEXT NOT NULL,
	`user_type`	INTEGER NOT NULL
);
INSERT INTO `users` VALUES (1,'rescuer1','0496d9ffade9e22fff52b64bfd893f1e',2);
INSERT INTO `users` VALUES (2,'rescuer2','0496d9ffade9e22fff52b64bfd893f1e',2);
INSERT INTO `users` VALUES (3,'rescuer3','0496d9ffade9e22fff52b64bfd893f1e',2);
INSERT INTO `users` VALUES (4,'rescuer4','0496d9ffade9e22fff52b64bfd893f1e',2);
INSERT INTO `users` VALUES (5,'rescuer5','0496d9ffade9e22fff52b64bfd893f1e',2);
INSERT INTO `users` VALUES (6,'moderator1','0496d9ffade9e22fff52b64bfd893f1e',3);
INSERT INTO `users` VALUES (7,'moderator2','0496d9ffade9e22fff52b64bfd893f1e',3);
INSERT INTO `users` VALUES (8,'moderator3','0496d9ffade9e22fff52b64bfd893f1e',3);
INSERT INTO `users` VALUES (9,'moderator4','0496d9ffade9e22fff52b64bfd893f1e',3);
INSERT INTO `users` VALUES (10,'moderator5','0496d9ffade9e22fff52b64bfd893f1e',3);
COMMIT;
