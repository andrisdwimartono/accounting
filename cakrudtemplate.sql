INSERT INTO `menus` (`id`, `mp_sequence`, `m_sequence`, `menu_name`, `url`, `menu_icon`, `parent_id`, `is_group_menu`, `is_shown_at_side_menu`, `user_creator_id`, `user_updater_id`, `created_at`, `updated_at`) VALUES
(1, 2, 0, 'Settings', '#', 'fa-cogs', NULL, 'on', 'on', 2, 2, NULL, '2021-09-07 02:41:04'),
(2, 2, 1, 'Menu', 'menu', 'fa-bars', 1, NULL, 'on', 2, 2, NULL, '2021-09-07 02:41:04'),
(3, 2, 5, 'User', 'user', 'fa-user', 1, NULL, 'on', 2, 2, NULL, '2021-09-07 02:41:04'),
(4, 3, 0, 'Master', '#', 'fa-database', NULL, 'on', 'on', 2, NULL, NULL, '2021-07-14 10:54:24'),
(8, 1, 0, 'Home', 'home', 'fa-home', NULL, NULL, 'on', 2, NULL, NULL, NULL),
(10, 2, 2, 'Create Menu', 'createmenu', 'fa-bars', 1, NULL, NULL, 2, 2, NULL, '2021-09-07 02:41:04'),
(11, 2, 4, 'Show Menu', 'menu/{id}', 'fa-bars', 1, NULL, NULL, 2, 2, NULL, '2021-09-07 02:41:04'),
(12, 2, 3, 'Edit Menu', 'menu/{id}/edit', 'fa-bars', 1, NULL, NULL, 2, 2, NULL, '2021-09-07 02:41:04'),
(13, 2, 6, 'Create User', 'createuser', '', 1, NULL, NULL, 2, 2, '2021-07-14 07:40:54', '2021-09-07 02:41:04'),
(14, 2, 7, 'Edit User', 'user/{id}/edit', '', 1, NULL, NULL, 2, 2, '2021-07-14 07:42:37', '2021-09-07 02:41:04'),
(15, 2, 8, 'Show User', 'user/{id}', '', 1, NULL, NULL, 2, 2, '2021-07-14 07:42:37', '2021-09-07 02:41:04'),
(16, 2, 9, 'Assign Menu', 'assignmenu/{id}/edit', '', 1, NULL, NULL, 2, 2, '2021-07-14 15:28:52', '2021-09-07 02:41:04');


INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_07_11_021043_create_user_menus_table', 1),
(5, '2021_07_11_021110_create_menus_table', 1),
(6, '2021_09_07_024131_create_user_role_menus_table', 2);


INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `photo_profile`, `role`, `role_label`, `user_creator_id`, `user_updater_id`, `created_at`, `updated_at`) VALUES
(2, 'Andris', 'admin@gmail.com', '2021-07-07 23:47:45', '$2y$10$7U7y8w4TP1bzJgbDJC/o4.YvLr2U.uUR83DW0IvFpifOuKBwR57Yq', NULL, 'photo_profile1630983027.jpg', 'admin', NULL, 2, 2, '2021-07-07 23:47:45', '2021-09-07 02:40:40'),
(3, 'Admin', 'andrisdwimartono@gmail.com', '2021-07-07 23:56:59', '$2y$10$aBY7PmvICHIt.QaXhYgEi.E4hJfyZ/aQ.32pr3y1tBAGEudcXBz26', NULL, 'foto1630642510.jpg', 'admin', 'Administrator', 2, 2, '2021-07-06 23:56:59', '2021-09-06 21:34:56');


INSERT INTO `user_menus` (`id`, `user_id`, `menu_id`, `is_granted`, `mp_sequence`, `m_sequence`, `menu_name`, `url`, `menu_icon`, `parent_id`, `is_group_menu`, `is_shown_at_side_menu`, `user_creator_id`, `user_updater_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'on', 2, 0, 'Settings', '#', 'fa-cogs', NULL, 'on', 'on', 2, 2, NULL, '2021-09-07 02:41:04'),
(2, 2, 2, 'on', 2, 1, 'Menu', 'menu', 'fa-bars', 1, NULL, 'on', 2, 2, NULL, '2021-09-07 02:41:04'),
(3, 2, 3, 'on', 2, 5, 'User', 'user', 'fa-user', 1, NULL, 'on', 2, 2, NULL, '2021-09-07 02:41:04'),
(4, 2, 4, NULL, 3, 0, 'Master', '#', 'fa-database', NULL, 'on', 'on', 2, NULL, NULL, '2021-09-07 02:40:40'),
(5, 2, 8, 'on', 1, 0, 'Home', 'home', 'fa-home', NULL, NULL, 'on', 2, NULL, NULL, '2021-09-07 02:40:40'),
(6, 2, 10, 'on', 2, 2, 'Create Menu', 'createmenu', 'fa-bars', 1, NULL, NULL, 2, 2, NULL, '2021-09-07 02:41:04'),
(7, 2, 11, 'on', 2, 4, 'Show Menu', 'menu/{id}', 'fa-bars', 1, NULL, NULL, 2, 2, NULL, '2021-09-07 02:41:04'),
(8, 2, 12, 'on', 2, 3, 'Edit Menu', 'menu/{id}/edit', 'fa-bars', 1, NULL, NULL, 2, 2, NULL, '2021-09-07 02:41:04'),
(9, 2, 13, 'on', 2, 6, 'Create User', 'createuser', '', 1, NULL, NULL, 2, 2, '2021-07-14 07:40:54', '2021-09-07 02:41:04'),
(10, 2, 14, 'on', 2, 7, 'Edit User', 'user/{id}/edit', '', 1, NULL, NULL, 2, 2, '2021-07-14 07:42:37', '2021-09-07 02:41:04'),
(11, 2, 15, 'on', 2, 8, 'Show User', 'user/{id}', '', 1, NULL, NULL, 2, 2, '2021-07-14 07:42:37', '2021-09-07 02:41:04'),
(12, 2, 16, 'on', 2, 9, 'Assign Menu', 'assignmenu/{id}/edit', '', 1, NULL, NULL, 2, 2, '2021-07-14 15:28:52', '2021-09-07 02:41:04'),
(13, 3, 16, 'on', 2, 9, 'Assign Menu', 'assignmenu/{id}/edit', '', 1, NULL, NULL, 2, 2, '2021-07-14 15:28:52', '2021-09-07 02:41:04'),
(14, 3, 2, 'on', 2, 1, 'Menu', 'menu', 'fa-bars', 1, NULL, 'on', NULL, 2, '2021-09-02 21:01:25', '2021-09-07 02:41:04'),
(15, 3, 3, 'on', 2, 5, 'User', 'user', 'fa-user', 1, NULL, 'on', NULL, 2, '2021-09-02 21:01:25', '2021-09-07 02:41:04'),
(16, 3, 8, 'on', 1, 0, 'Home', 'home', 'fa-home', NULL, NULL, 'on', NULL, NULL, '2021-09-02 21:01:25', '2021-09-06 21:34:56'),
(17, 3, 10, 'on', 2, 2, 'Create Menu', 'createmenu', 'fa-bars', 1, NULL, NULL, NULL, 2, '2021-09-02 21:01:25', '2021-09-07 02:41:04'),
(18, 3, 11, 'on', 2, 4, 'Show Menu', 'menu/{id}', 'fa-bars', 1, NULL, NULL, NULL, 2, '2021-09-02 21:01:25', '2021-09-07 02:41:04'),
(19, 3, 12, 'on', 2, 3, 'Edit Menu', 'menu/{id}/edit', 'fa-bars', 1, NULL, NULL, NULL, 2, '2021-09-02 21:01:25', '2021-09-07 02:41:04'),
(20, 3, 13, 'on', 2, 6, 'Create User', 'createuser', '', 1, NULL, NULL, NULL, 2, '2021-09-02 21:01:25', '2021-09-07 02:41:04'),
(21, 3, 14, 'on', 2, 7, 'Edit User', 'user/{id}/edit', '', 1, NULL, NULL, NULL, 2, '2021-09-02 21:01:25', '2021-09-07 02:41:04'),
(22, 3, 15, 'on', 2, 8, 'Show User', 'user/{id}', '', 1, NULL, NULL, NULL, 2, '2021-09-02 21:01:25', '2021-09-07 02:41:04'),
(23, 3, 1, 'on', 2, 0, 'Settings', '#', 'fa-cogs', NULL, 'on', 'on', NULL, 2, '2021-09-02 21:01:25', '2021-09-07 02:41:04'),
(24, 3, 4, NULL, 3, 0, 'Master', '#', 'fa-database', NULL, 'on', 'on', NULL, NULL, '2021-09-02 21:01:25', '2021-09-06 21:34:56');


INSERT INTO `user_role_menus` (`id`, `role`, `menu_id`, `is_granted`, `user_creator_id`, `user_updater_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', 1, 'on', 2, NULL, NULL, '2021-07-14 15:28:52'),
(2, 'admin', 2, 'on', 2, NULL, NULL, '2021-07-14 15:28:52'),
(3, 'admin', 3, 'on', 2, NULL, NULL, '2021-07-14 15:28:52'),
(4, 'admin', 4, 'on', 2, NULL, NULL, '2021-07-14 10:54:24'),
(5, 'admin', 8, 'on', 2, NULL, NULL, NULL),
(6, 'admin', 10, 'on', 2, NULL, NULL, '2021-07-14 15:28:52'),
(7, 'admin', 11, 'on', 2, NULL, NULL, '2021-07-14 15:28:52'),
(8, 'admin', 12, 'on', 2, NULL, NULL, '2021-07-14 15:28:52'),
(9, 'admin', 13, 'on', 2, NULL, '2021-07-14 07:40:54', '2021-07-14 15:28:52'),
(10, 'admin', 14, 'on', 2, NULL, '2021-07-14 07:42:37', '2021-07-14 15:28:52'),
(11, 'admin', 15, 'on', 2, NULL, '2021-07-14 07:42:37', '2021-07-14 15:28:52'),
(12, 'admin', 16, 'on', 2, NULL, '2021-07-14 15:28:52', '2021-07-14 15:28:52');
