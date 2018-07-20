
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_persona` int(10) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `id_persona`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador del Sistema', 'admin@ibaquedano.cl', '$2y$10$hL4KZ4E55hHV.sZdFS17B.acdc0MZfQQoyLtC94u1VL1mGLN/.pO.', 1, 'RjDtlgDr7FXF8cczqAPd9giFT7LRd6dPe8XliVpduLAk4j9NNVsykcJUMO2W', '2018-07-05 01:19:32', '2018-07-05 01:19:32'),
(2, 'Pablo Jimenez', 'pablo@ibaquedano.cl', '$2y$10$oIKP91M0GCfIA9qWmDDktu5ULtTan44v56kcT24MvL3FsjBPZtnPa', 2, NULL, '2018-07-05 01:19:32', '2018-07-05 01:19:32'),
(3, 'Neila Chavez', 'neila@ibaquedano.cl', '$2y$10$2BFdy5sv7vj/tuhKBAZh3uD5aGqn6bNclOI/8/XVoyz1Y1drH1wFm', 3, NULL, '2018-07-05 01:19:32', '2018-07-05 01:19:32'),
(4, 'Daniel Gutierrez', 'daniela@ibaquedano.cl', '$2y$10$bu2JI1XZEHAG6iwFialYduQYuIqM/oqRjkali89e.Mdm/qC7wH5ze', 4, 'KTBvII3tmiFwhTdsogcdra59XGlR23Nhq2eT52z66N5oaXariyuafm6tgj5a', '2018-07-05 01:19:32', '2018-07-05 01:19:32'),
(5, 'Javier Faria', 'javier@ibaquedano.cl', '$2y$10$joW/0Rjnh27OyLK9K3CL8.SJDPWBRPxt7/DOiPP0k5sZxLbrxh1Qy', 5, 'gqKL6DsQeAX0pXHqU7iUhu2DO9SbhuYRGVM2vX81nAw1QzghGqtRksbeitqT', '2018-07-05 01:19:32', '2018-07-05 01:19:32'),
(6, 'Conctact Center 1', 'contactcenter1@ibaquedano.cl', '$2y$10$y7jb9pdJ8xfjSoixsEZzy.DfMDnLRCorHF/HwCOPY3VpMqKq8CPrq', 6, 'Ee1TKCANbYpc8O0kLbY2wCIAsyqQCboBPW122Hd6TeTDiPdCNd8YhtWnV9SJ', '2018-07-05 01:19:32', '2018-07-05 01:19:32'),
(7, 'Conctact Center 2', 'contactcenter2@ibaquedano.cl', '$2y$10$WiiL4vI7WM6SQojT/MzSv.n1GZSvu1wCf67qemnNIRH11RLpjRiaG', 7, NULL, '2018-07-05 01:19:32', '2018-07-05 01:19:32'),
(8, 'Conctact Center 3', 'contactcenter3@ibaquedano.cl', '$2y$10$ixMsKoqr35/WYlU1ryguuei2i3cz7ikDgRPjcfkDuIMOZeeAZWuCO', 8, NULL, '2018-07-05 01:19:33', '2018-07-05 01:19:33'),
(9, 'Nelson Galaz', 'nelson.galaz@gmail.com', '$2y$10$G4rI0Q743N/iWVhdUVtYsOAan.8gNsZkcvvl6w.A60QyluAYVe8eW', 9, 'Pd2v5prd9p6OMbleVxR8Sykad98MdvyJLoz6fJxrzeGQqMHZEcQouHu0JPbD', '2018-07-05 01:35:22', '2018-07-05 01:35:53'),
(10, 'Douglas Nuñez', 'dminicor@gmail.com', '$2y$10$G4rI0Q743N/iWVhdUVtYsOAan.8gNsZkcvvl6w.A60QyluAYVe8eW', 12, 'uextphdbfb945mCoPrPGf0iF1HM69hkeoPblmsNpnjBZHb67JfPfM52jiy4Z', '2018-07-05 18:29:19', '2018-07-06 00:42:19'),
(11, 'Ricardo Garces', 'ragarcesa@gmail.com', '$2y$10$G4rI0Q743N/iWVhdUVtYsOAan.8gNsZkcvvl6w.A60QyluAYVe8eW', 315, 'YEjyXn5BoBuBl0tZHAt7N23vgKcDw6wMOad3DFXEKDTH8fQxweOAwjdxKD96', '2018-07-12 20:33:11', '2018-07-12 20:33:50');
