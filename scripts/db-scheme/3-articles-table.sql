USE tech_news;

CREATE TABLE articles (
	id INT unsigned NOT NULL AUTO_INCREMENT,
    id_user INT unsigned NOT NULL,
    id_category INT unsigned NOT NULL,
    title VARCHAR(255) NOT NULL UNIQUE,
    subtitle TEXT NOT NULL,
    uri VARCHAR(255) NOT NULL UNIQUE,
    cover VARCHAR(255) NOT NULL,
    video VARCHAR(255) DEFAULT NULL,
    views INT NOT NULL DEFAULT 0,
    status VARCHAR(50) NOT NULL DEFAULT 'created',
    published_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES users (id),
	FOREIGN KEY (id_category) REFERENCES categories (id)
);

# CREATE FULLTEXT INDEX search ON articles(title, subtitle);
