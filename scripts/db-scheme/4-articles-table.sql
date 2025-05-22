USE tech_news;

CREATE TABLE IF NOT EXISTS `tech_news`.`articles` (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  id_admin INT unsigned NOT NULL,
  id_category INT unsigned NOT NULL,
  title VARCHAR(255) NOT NULL UNIQUE,
  uri VARCHAR(255) NOT NULL UNIQUE,
  cover VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  views INT NOT NULL DEFAULT 0,
  status ENUM ('created', 'published') NOT NULL DEFAULT 'created',
  published_at TIMESTAMP NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (id_admin) REFERENCES admins (id),
  FOREIGN KEY (id_category) REFERENCES categories (id)
);

CREATE FULLTEXT INDEX search ON articles (title);
