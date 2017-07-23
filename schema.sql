CREATE TABLE `tracks` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `duration` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ut8;

CREATE TABLE `user_tracks` (
  `user_id` smallint(5) UNSIGNED NOT NULL,
  `track_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_tracks`
  ADD PRIMARY KEY (`user_id`,`track_id`),
  ADD KEY `track_id` (`track_id`);

ALTER TABLE `tracks`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_tracks`
  ADD CONSTRAINT `user_tracks_ibfk_2` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`),
  ADD CONSTRAINT `user_tracks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
