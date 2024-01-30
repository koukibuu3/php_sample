DROP TABLE IF EXISTS Cells;

CREATE TABLE Cells (
    `owner` VARCHAR(255) NOT NULL,
    `row` INT NOT NULL,
    `column` INT NOT NULL,
    `value` INT NOT NULL,
    `is_hit` TINYINT NOT NULL DEFAULT 0
);
