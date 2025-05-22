USE tech_news;

CREATE TABLE IF NOT EXISTS `tech_news`.`comments` (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  id_user INT unsigned NOT NULL,
  id_article INT unsigned NOT NULL,
  comment TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (id_user) REFERENCES users (id),
  FOREIGN KEY (id_article) REFERENCES articles (id)
);
