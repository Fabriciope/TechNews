USE tech_news;

CREATE TABLE IF NOT EXISTS `tech_news`.`categories` (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  category VARCHAR(100) NOT NULL UNIQUE,
  uri VARCHAR(150) NOT NULL UNIQUE,
  PRIMARY KEY (id)
);
