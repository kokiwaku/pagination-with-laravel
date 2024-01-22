CREATE SEQUENCE posts_seq;

DROP TABLE IF EXISTS posts;

CREATE TABLE posts (
    posts_id INT NOT NULL DEFAULT nextval('posts_seq')
    , title VARCHAR(255) NOT NULL
    , content TEXT NOT NULL
    , created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    , updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    , CONSTRAINT pk_posts PRIMARY KEY (posts_id)
);