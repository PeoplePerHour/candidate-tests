#
# TABLE STRUCTURE FOR: authors
#

DROP TABLE IF EXISTS authors;

CREATE TABLE `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (1, 'Providenci', 'Schaden', 'cspinka@example.com', '2014-06-18', '1977-03-30 16:25:30');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (2, 'Loy', 'Beer', 'amie.hamill@example.org', '2003-03-19', '2000-07-13 04:45:59');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (3, 'Kade', 'Kassulke', 'efren.lemke@example.net', '2011-04-17', '2017-04-04 00:48:09');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (4, 'Tyrese', 'Kutch', 'elwyn99@example.org', '2001-05-28', '2012-04-02 17:56:54');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (5, 'Ayana', 'Torp', 'katelynn.hamill@example.net', '2003-05-23', '1991-04-19 10:25:20');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (6, 'Paris', 'Rath', 'cielo.friesen@example.net', '2008-02-20', '1992-10-20 20:21:24');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (7, 'Rollin', 'Weimann', 'marcelle77@example.net', '2008-09-06', '2004-09-03 13:07:20');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (8, 'Ronaldo', 'Bednar', 'rconsidine@example.com', '2004-02-23', '1972-12-14 14:50:24');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (9, 'Hermann', 'Langosh', 'adalberto05@example.org', '1981-09-25', '2005-01-27 15:20:45');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (10, 'Kamille', 'Bartoletti', 'magdalena48@example.com', '1988-10-17', '2017-04-07 11:54:29');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (11, 'Noelia', 'Nikolaus', 'pietro04@example.com', '2009-08-01', '2010-01-30 06:17:56');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (12, 'Myrtie', 'Torp', 'elmore.howe@example.com', '1970-04-11', '1987-10-08 15:27:10');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (13, 'Tiffany', 'Botsford', 'priscilla.homenick@example.com', '1974-10-26', '1986-11-01 08:50:24');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (14, 'Lonie', 'Smitham', 'rafaela42@example.org', '1973-02-21', '2011-05-14 05:41:47');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (15, 'Hiram', 'Abernathy', 'enola.ebert@example.org', '1983-11-02', '2009-10-31 08:44:28');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (16, 'Waylon', 'Kris', 'hansen.stevie@example.org', '1985-01-13', '2013-01-21 03:06:02');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (17, 'Vallie', 'Towne', 'ckassulke@example.org', '1995-02-05', '1989-06-22 08:23:09');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (18, 'Deangelo', 'Gerlach', 'uwisozk@example.net', '1980-03-28', '1980-04-19 21:19:32');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (19, 'Danial', 'D\'Amore', 'zbayer@example.com', '2010-10-10', '1986-10-21 12:31:15');
INSERT INTO authors (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES (20, 'Bryce', 'DuBuque', 'garnet39@example.org', '1995-10-20', '1983-03-06 03:58:55');


#
# TABLE STRUCTURE FOR: posts
#

DROP TABLE IF EXISTS posts;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (1, 17, 'Vitae omnis nobis officia adipisci perferendis quis distinctio a.', 'Ducimus tempore neque ipsa vero eaque ut ut voluptatem. Occaecati sed ut quas ut. Consequatur fugiat aut aut eos saepe nostrum. Est aut at blanditiis esse sunt voluptatem impedit. Dolorem quisquam quis in nihil velit.', 'Rem ratione quisquam velit doloribus quia labore ea omnis. Assumenda magni dolorem esse quisquam voluptatem sapiente fugiat. Mollitia et fugit ducimus quo quia numquam.', '1992-03-01');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (2, 6, 'Ea repudiandae sit amet tempora et nemo nobis dolorem.', 'Ab rem qui voluptatum quo alias dolor at excepturi. Nostrum eligendi molestias non. Illum eius soluta fuga eveniet.', 'Et natus ut eaque. Qui ut quae quos. Ut sed officia vero itaque laudantium non qui.', '1993-03-17');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (3, 8, 'Eos quo at dolores culpa quam qui quis.', 'Est doloribus possimus pariatur soluta delectus esse. Explicabo consequatur consectetur aut deserunt vel doloremque. Velit possimus id dicta eum rem necessitatibus dolorem. Consequuntur provident quia aut qui.', 'Cum qui sequi autem sed. Ad et autem dolores sunt quaerat. Iure doloribus est fugiat temporibus molestiae ex. Voluptatum illo debitis dolorum et reiciendis aliquam. Quis dolorem voluptatem est quae.', '1998-11-05');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (4, 1, 'Non incidunt dolor minima tenetur sint delectus eveniet voluptatem.', 'Cum dolores aut modi corporis aliquam sit facere. Voluptatibus cupiditate doloribus alias quaerat ex quam voluptatum. Ut molestias voluptatum a. Nobis corporis sint aut totam. Odio recusandae et qui a et incidunt.', 'Eligendi odit facilis blanditiis qui consequuntur provident accusamus. Est a error et unde. Necessitatibus consectetur ut aliquid. Qui in sunt a et vitae optio facere.', '1971-11-03');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (5, 16, 'A animi nemo sed at eligendi.', 'Facilis voluptatem beatae omnis qui rerum sit sequi. Rerum modi inventore minima enim ut quis aut. Autem dolores repellendus nemo reiciendis. Voluptas alias aut voluptatum voluptatem et.', 'Consectetur dolores illo vero autem. Minima id doloribus aut ipsum et dolor repudiandae quia. Unde qui vel nihil. Optio voluptatem rem soluta et quae quos.', '2002-05-23');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (6, 20, 'Ad velit ducimus suscipit aut ut commodi.', 'Sint quis porro ad odio fugit illo reprehenderit. Optio quas velit dolore sit. Dicta veniam labore ab fugit. Eius ipsum et accusamus rerum alias voluptas et.', 'Fuga eos placeat aut veniam est perferendis. Cumque ut quo eos id. Hic aut nisi facilis ab corporis.', '2001-11-12');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (7, 17, 'Possimus qui dolorem consequatur placeat aut vel.', 'Veniam vitae consectetur repudiandae asperiores id. Hic omnis quos nulla quia officia. Rem aut illo veniam et.', 'Ut non qui nemo deleniti nesciunt. Nisi neque dolores vel beatae. Sit aut est et et. Dolor qui doloremque ea minus eum.', '1977-08-25');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (8, 5, 'Nihil sequi libero ut atque.', 'Quibusdam quia libero est quasi dolor nihil. Est distinctio est nisi possimus velit et. Consequatur aut dolorum eum voluptatem sint.', 'Sapiente quia non cupiditate necessitatibus illum et qui ut. Optio rem et et ipsum explicabo commodi nam. Non quo quaerat sed veritatis eum. Consectetur magni itaque voluptatum itaque.', '1974-12-17');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (9, 12, 'Neque vero tempore quis porro delectus enim ipsa.', 'Quia itaque perferendis blanditiis atque necessitatibus et. Vero earum et soluta rerum quia aut dolorum. Nisi ipsa reiciendis quibusdam sed enim id voluptas enim. Commodi neque veniam voluptatem iusto corrupti nam.', 'Tenetur ut autem pariatur. Ipsam eos qui perferendis rem amet fugit. Tempore ex ut minima rem.', '2017-05-12');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (10, 20, 'Soluta labore dolorem sint provident praesentium ipsum.', 'Sint necessitatibus neque temporibus aperiam. Voluptates et numquam recusandae. Fugit animi rerum omnis odio.', 'Odit quo provident temporibus minima dolorem qui. Fuga consequatur id minus autem et. Et est eligendi rem recusandae. Quis inventore eum ea eum non. Qui quis repellat quae adipisci.', '1986-06-08');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (11, 20, 'Ullam et fuga exercitationem voluptatibus.', 'Saepe asperiores delectus aut. Et aut qui odio dolorem voluptatem a necessitatibus natus. Aut temporibus corporis eum ducimus in.', 'Impedit eos excepturi aut est. Velit omnis magnam odit est omnis molestias dicta. Laborum magnam fuga id qui velit ut.', '2009-11-29');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (12, 8, 'Minima sed fugit est modi eveniet minima.', 'Dolorem expedita est repellat enim delectus. Amet quibusdam non eligendi enim et aut maxime. Ipsa doloribus quasi vel quos fugit numquam magni. Et voluptate porro quia.', 'Qui ut soluta autem quasi. Labore qui odio sapiente aliquam. Quo mollitia assumenda delectus maxime voluptas. Voluptas suscipit blanditiis est qui.', '2004-05-31');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (13, 17, 'Natus autem similique et excepturi aut aut provident eum.', 'Ut velit qui ipsa excepturi. At fugiat ducimus sed sunt molestiae itaque nobis. Ullam voluptatum quia doloremque tempore.', 'Voluptatem eum voluptas voluptatem natus voluptas expedita nostrum. Sit et atque illum voluptatem minima iure sed. Optio dignissimos tempora id.', '1986-12-11');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (14, 1, 'Saepe quibusdam corporis eligendi doloribus rerum et.', 'Eligendi et ratione iusto explicabo ad ex quis pariatur. Repellendus voluptatum vero ex nihil maiores doloribus optio rerum. Aut praesentium alias quod dolore animi rerum et ut.', 'Dolore veniam amet nihil quia sit. Dolores ipsa ipsa vero nostrum voluptatem temporibus. Libero vel voluptatem provident est ipsam corrupti assumenda.', '2012-03-29');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (15, 12, 'Similique nostrum assumenda cupiditate laborum autem necessitatibus.', 'Sunt voluptatem et molestias sit rem culpa. Exercitationem ratione id porro ipsam quo sed. Ea rem tenetur facere sit ex optio velit.', 'Ut ea et asperiores ad consequatur nobis. Temporibus aliquam id sapiente accusantium id. Omnis ducimus non odio ut vero velit esse laudantium.', '1980-05-24');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (16, 10, 'Ut molestiae id error saepe id.', 'Explicabo mollitia voluptatem quasi vero optio. Sed dolores quo iusto sint aut et quam fugiat. Tenetur hic perferendis laboriosam ut nulla. Et et sint officia repudiandae.', 'Sit quo natus laboriosam. Eum velit doloremque occaecati asperiores qui aperiam. Ipsam inventore eius autem consequatur qui.', '2012-08-26');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (17, 14, 'Ex reprehenderit in reiciendis.', 'Aliquid facilis pariatur deleniti accusantium eum assumenda. Consectetur sit rerum ad et dolore ut unde repudiandae. Molestiae accusamus ratione saepe ut non. Non iste non aut sint provident.', 'Quia est dolor tenetur molestias accusamus qui atque odit. Magni amet suscipit numquam quaerat laudantium hic. Nulla rerum alias laboriosam.', '1977-04-25');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (18, 4, 'Fugit natus cupiditate nihil dolores.', 'Consequatur rem ut sed consectetur quos voluptatem. Unde et praesentium deserunt dolores quia molestiae neque. Totam eum assumenda et voluptatem quae sed. Sit et qui velit corporis voluptatibus.', 'Qui voluptates dicta delectus harum iste atque aperiam. Ea praesentium facilis aliquam. Harum iste sed saepe necessitatibus distinctio qui eveniet.', '2003-11-29');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (19, 11, 'Similique veritatis dolorem placeat laborum facere.', 'Et molestias ut qui qui aperiam. Optio hic quia aliquid ut atque. Illo quae totam repellendus sint.', 'Dicta impedit ullam et unde illo sed. Deleniti est eos voluptatem vel ab. Unde voluptates neque et provident natus omnis.', '2007-05-19');
INSERT INTO posts (`id`, `author_id`, `title`, `description`, `content`, `date`) VALUES (20, 11, 'Aperiam sunt totam sit aut est distinctio reprehenderit.', 'Ab consequatur quae provident non. Asperiores pariatur vel nihil aspernatur ea. Velit veritatis dolor pariatur quia.', 'Velit officiis est nihil quasi placeat quos. Enim optio dignissimos quia voluptas qui aperiam laborum eos. Veritatis odio reprehenderit ut tenetur ut et ut.', '1987-12-04');

